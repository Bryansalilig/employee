<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DevelopmentUpcoming extends Model
{
    protected $table = 'development_upcoming';

    public static function getUpcoming($id = null)
    {
        $condition = "1";
        if (!empty($id)) {
            $condition .= " AND (supervisor_id={$id} OR manager_id={$id})";
        }

        $data = DB::select("
            SELECT
                `employee_info`.*,
                `development_upcoming`.`id` AS `upcoming_id`
            FROM
                `employee_info`,
                `development_upcoming`
            WHERE
                {$condition}
                AND `development_upcoming`.`employee_id`=`employee_info`.`id`
                AND `employee_info`.`deleted_at` IS NULL
                AND `employee_info`.`status` <> 2
            ORDER BY 
                `employee_info`.`hired_date`
            DESC
        ");

        foreach ($data as $employee) {
            $supervisor = User::find($employee->supervisor_id);
            $manager = User::find($employee->manager_id);
            $superior = "---";
            $item = Development::where('employee_id', $employee->id)->where('draft', 1)->first();
            if (!empty($manager)) {
                $superior = $manager->last_name.', '.$manager->first_name;
            }
            if (!empty($supervisor)) {
                $superior = $supervisor->last_name.', '.$supervisor->first_name;
            }

            $employee->superior = $superior;
            $employee->data = $item;
        }

        return $data;
    }
}
