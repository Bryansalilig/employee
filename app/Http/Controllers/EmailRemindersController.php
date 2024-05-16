<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Development;
use App\Models\DevelopmentUpcoming;

class EmailRemindersController extends Controller
{
    public function reminderDevelopment2()
    {
        // $date1 = date('2023-09-01');
        // $date2 = date('Y-m-d', strtotime('+20 days'));

        // $employees = User::AllExceptSuperAdmin()->ActiveEmployees()->orderBy('last_name')->whereRaw("DATE_FORMAT(hired_date,'2023-%m-%d') >= '{$date1}' AND DATE_FORMAT(hired_date,'2023-%m-%d') <= '{$date2}'")->whereRaw('YEAR(hired_date) != YEAR(NOW())')->get();

        $employees = User::whereNull('deleted_at')->where('status', '<>', 2)->where('id', '<>', 1)->orderBy('last_name')->whereRaw("NOW() BETWEEN DATE_SUB(DATE_FORMAT(DATE_ADD(`hired_date`, INTERVAL (YEAR(CURRENT_DATE()) - YEAR(`hired_date`)) YEAR), '%Y-%m-%d'), INTERVAL 20 DAY) AND DATE_FORMAT(DATE_ADD(`hired_date`, INTERVAL (YEAR(CURRENT_DATE()) - YEAR(`hired_date`)) YEAR), '%Y-%m-%d')")->get();

        $arr = [];
        foreach($employees as $employee) {
            $development = Development::where('employee_id', $employee->id)->orderBy('id')->first();
            $upcoming = DevelopmentUpcoming::where('employee_id', $employee->id)->orderBy('id')->first();
            $supervisor = User::find($employee->supervisor_id);
            $manager = User::find($employee->manager_id);
            $email = 'hrd@elink.com.ph';
            $superior = 'HR DEPARTMENT';
            if(!empty($manager)) {
                $email = $manager->email;
                $superior = $manager->first_name;
            }
            if(!empty($supervisor)) {
                $email = $supervisor->email;
                $superior = $supervisor->first_name;
            }

            $data['supervisor'] = ucwords(strtolower($superior));
            $data['user'] = ucwords(strtolower($employee->first_name.' '.$employee->last_name));
            $data['slug'] = $employee->slug;
            $data['hired_date'] = date('F d,', strtotime($employee->hired_date)).' '.date('Y');

            if(empty($development)) {
                if(empty($upcoming)) {
                    $upcoming = new DevelopmentUpcoming();
                    $upcoming->employee_id = $employee->id;
                    $upcoming->year = date('Y');
                    $upcoming->save();

                    // Mail::to($email)->cc('juncelcarreon@elink.com.ph')->send(new DevelopmentNotification($data));
                }
            }
        }

        $upcomings = DevelopmentUpcoming::getUpcoming();
        foreach($upcomings as $upcoming) {
            $development = DevelopmentUpcoming::find($upcoming->upcoming_id);
            $supervisor = User::find($upcoming->supervisor_id);
            $manager = User::find($upcoming->manager_id);
            $email = 'hrd@elink.com.ph';
            $superior = 'HR DEPARTMENT';
            if(!empty($manager)) {
                $email = $manager->email;
                $superior = $manager->first_name;
            }
            if(!empty($supervisor)) {
                $email = $supervisor->email;
                $superior = $supervisor->first_name;
            }

            $data['supervisor'] = ucwords(strtolower($superior));
            $data['user'] = ucwords(strtolower($upcoming->first_name.' '.$upcoming->last_name));
            $data['slug'] = $upcoming->slug;
            $data['hired_date'] = date('F d,', strtotime($upcoming->hired_date)).' '.date('Y');

            if($development->status == 0 && date('Y-m-d') != date('Y-m-d', strtotime($development->updated_at))) {
                $development->updated_at = date('Y-m-d H:i:s');
                $development->save();

                // Mail::to($email)->cc('juncelcarreon@elink.com.ph')->send(new DevelopmentNotification($data));
            }
        }
    }
}
