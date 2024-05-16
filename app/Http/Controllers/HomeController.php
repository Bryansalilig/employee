<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\DAInfraction;
use App\Models\ElinkActivities;
use App\Models\EmployeeInfoDetails;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\Posts;
use App\Models\UndertimeRequest;
use App\Models\User;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $this->getCredits();

        // if(Auth::check() && Auth::user()->isAdmin()) {
        //     return redirect('dashboard');
        // }

        $data['posts'] = Posts::where('enabled', '1')->get();
        $data['new_hires'] = User::allExceptSuperAdmin()->orderBy('prod_date', 'DESC')->paginate(5);
        // $data['employees'] = User::allExceptSuperAdmin()->get();
        $data['birthdays'] = User::allExceptSuperAdmin()->whereRaw('MONTH(birth_date) = '.date('n'))->whereRaw('deleted_at is null')->where("status","=",1)->orderByRaw('DAYOFMONTH(birth_date) ASC')->get();
        $data['engagements'] = ElinkActivities::getActivities();
        // $data['dashboard'] = 0;

        return view('home', $data);
    }

    public function dashboard(Request $request)
    {
        $data['new_hires'] = User::allExceptSuperAdmin()->whereRaw('MONTH(prod_date) = '.date('n'))->whereRaw('YEAR(prod_date) = '.date('Y'))->whereRaw('deleted_at is null')->where("status", 1)->count();
        $data['old_hires'] = User::allExceptSuperAdmin()->whereRaw('MONTH(prod_date) = '.date('n', strtotime('last month')))->whereRaw('YEAR(prod_date) = '.date('Y', strtotime('last month')))->whereRaw('deleted_at is null')->where("status", 1)->count();
        $data['new_leave'] = LeaveRequest::whereRaw('MONTH(created_at) = '.date('n'))->whereRaw('YEAR(created_at) = '.date('Y'))->count();
        $data['old_leave'] = LeaveRequest::whereRaw('MONTH(created_at) = '.date('n', strtotime('last month')))->whereRaw('YEAR(created_at) = '.date('Y', strtotime('last month')))->count();
        $data['new_overtime'] = LeaveRequest::whereRaw('MONTH(created_at) = '.date('n'))->whereRaw('YEAR(created_at) = '.date('Y'))->count();
        $data['new_overtime'] = OvertimeRequest::withTrashed()->whereRaw('MONTH(created_at) = '.date('n'))->whereRaw('YEAR(created_at) = '.date('Y'))->count();
        $data['old_overtime'] = OvertimeRequest::withTrashed()->whereRaw('MONTH(created_at) = '.date('n', strtotime('last month')))->whereRaw('YEAR(created_at) = '.date('Y', strtotime('last month')))->count();
        $data['new_undertime'] = UndertimeRequest::withTrashed()->whereRaw('MONTH(created_at) = '.date('n'))->whereRaw('YEAR(created_at) = '.date('Y'))->count();
        $data['old_undertime'] = UndertimeRequest::withTrashed()->whereRaw('MONTH(created_at) = '.date('n', strtotime('last month')))->whereRaw('YEAR(created_at) = '.date('Y', strtotime('last month')))->count();
        // $data['new_infraction'] = DAInfraction::withTrashed()->whereRaw('MONTH(created_at) = '.date('n'))->whereRaw('YEAR(created_at) = '.date('Y'))->count();
        // $data['old_infraction'] = DAInfraction::withTrashed()->whereRaw('MONTH(created_at) = '.date('n', strtotime('last month')))->whereRaw('YEAR(created_at) = '.date('Y', strtotime('last month')))->count();
        $data['new_attrition'] = EmployeeInfoDetails::whereRaw('MONTH(resignation_date) = '.date('n'))->whereRaw('YEAR(resignation_date) = '.date('Y'))->count();
        $data['old_attrition'] = EmployeeInfoDetails::whereRaw('MONTH(resignation_date) = '.date('n', strtotime('last month')))->whereRaw('YEAR(resignation_date) = '.date('Y', strtotime('last month')))->count();
        $data['dashboard'] = 1;
// echo '<pre>';
// print_r($data);
// return;
        return view('dashboard', $data);
    }

    public function newhires(Request $request)
    {
        $users = User::allExceptSuperAdmin()->orderBy('prod_date', 'DESC')->paginate(5);
        foreach($users as $user) {
            $user->fullname = $user->fullname();
            $user->prod_date = customDate($user->prod_date, 'M d, Y');
        }

        return $users;
    }

    public function getFormattedDate(Request $request)
    {
        return customDate($request->date, $request->string);
    }

    // private function getCredits()
    // {
    //     $obj = DB::select("
    //         SELECT 
    //             id
    //         FROM
    //             employee_info
    //         WHERE
    //             status = 1 AND 
    //             deleted_at IS NULL AND 
    //             eid LIKE 'ESCC-%';
    //     ");

    //     foreach($obj as $e) {
    //         $year = 2023;

    //         $archive = LeaveCreditArchive::where('employee_id', $e->id)->where('year', $year)->where('type', 99)->where('status', 1)->first();
    //         $credit = LeaveCredits::where('employee_id', $e->id)->where('year', $year)->where('type', 2)->where('status', 1)->first();

    //         if(!empty($archive) && empty($credit)){
    //             $credit = new LeaveCredits();
    //             $credit->employee_id = $e->id;
    //             $credit->credit = $archive->credit;
    //             $credit->type = 2;
    //             $credit->month = 0;
    //             $credit->year = $year;
    //             $credit->leave_id = 0;
    //             $credit->status = 1;
    //             $credit->save();
    //         }
    //     }
    // }
} 
