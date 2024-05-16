<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Make sure to import the User model

class Development extends Model
{
    use HasFactory;

    protected $table = 'development';

    public static function getTeamDevelopment($id = null)
    {
        $condition = "1";
        if (!empty($id)) {
            $condition .= " AND (supervisor_id={$id} OR manager_id={$id})";
        }

        $data = DB::select("
            SELECT
                `employee_info`.*
            FROM
                `employee_info`
            WHERE
                `deleted_at` IS NULL
                AND `status` <> 2
                AND NOW() BETWEEN DATE_SUB(DATE_FORMAT(DATE_ADD(`hired_date`, INTERVAL (YEAR(CURRENT_DATE()) - YEAR(`hired_date`)) YEAR), '%Y-%m-%d'), INTERVAL 20 DAY) 
                AND DATE_FORMAT(DATE_ADD(`hired_date`, INTERVAL (YEAR(CURRENT_DATE()) - YEAR(`hired_date`)) YEAR), '%Y-%m-%d')
                AND {$condition}
            ORDER BY 
                `employee_info`.`hired_date`
            DESC
        ");

        foreach ($data as $employee) {
            $supervisor = User::find($employee->supervisor_id);
            $manager = User::find($employee->manager_id);
            $superior = "---";
            $from = date('Y-').date('m-d', strtotime($employee->hired_date. '-20 days'));
            $to = date('Y-').date('m-d', strtotime($employee->hired_date));
            $item = Development::where('employee_id', $employee->id)->whereRaw("NOW() BETWEEN '{$from}' AND '{$to}'")->first();
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

    public static function getDevelopment($condition = null)
    {
        $query = '1';
        if (!empty($condition)) {
            $query .= " AND {$condition}";
        }

        $data = DB::select("
            SELECT
                `development`.*,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`,
                `employee_info`.`email`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`contact_number`,
                `employee_info`.`position_name`,
                `employee_info`.`hired_date`,
                `employee_info`.`team_name`
            FROM
                `development`
            INNER JOIN 
                `employee_info`
            ON 
                `development`.`employee_id` = `employee_info`.`id`
            WHERE
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1 AND
                {$query}
            ORDER BY 
                `development`.`created_at` 
            DESC
        ");

        foreach ($data as $employee) {
            $superior = User::withTrashed()->find($employee->superior_id);

            $employee->superior = $superior->last_name.', '.$superior->first_name;
        }

        return $data;
    }
}
