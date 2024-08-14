<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OvertimeRequest extends Model
{
    use SoftDeletes;

    protected $table = 'overtime_request';


    public static function getOvertime($in_type = 'pending', $in_method = 'list', $in_id = null)
    {
        $in_type = strtoupper($in_type);
        $query = '';
        switch($in_method) {
            case 'user':
            $query = " AND `employee_info`.`id`={$in_id}";
            $query .= " AND `overtime_request`.`status` = '{$in_type}'";
                break;
            case 'show':
            $query = " AND `overtime_request`.`slug`='{$in_id}'";
                break;
            case 'team':
            $query = " AND (`employee_info`.`supervisor_id`={$in_id} OR `employee_info`.`manager_id`={$in_id} OR `employee_info`.`approver_id`={$in_id})";
            $query .= " AND `overtime_request`.`status` = '{$in_type}'";
                break;
            default:
            $query = " AND `overtime_request`.`status` = '{$in_type}'";
                break;
        }

        $data = DB::select("
            SELECT
                `overtime_request`.*,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`approver_id`,
                `employee_info`.`contact_number`,
                `employee_info`.`position_name`,
                `employee_info`.`team_name`
            FROM
                `overtime_request`
            INNER JOIN
                `employee_info`
            ON
                `overtime_request`.`employee_id` = `employee_info`.`id`
            WHERE
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1 {$query}
            ORDER BY
                `overtime_request`.`created_at`
            DESC
        ");

        foreach($data as $key=>$value) {
            $overtime_details = DB::select("SELECT * FROM `overtime_request_details` WHERE `overtime_request_details`.`overtime_id` = {$value->id} ORDER BY `overtime_request_details`.`date`");
            $ids = [];
            $date = [];
            $no_of_hours = [];
            $time_in = [];
            $time_out = [];
            foreach($overtime_details as $i=>$overtime) {
                $ids[$i] = $overtime->id;
                $date[$i] = date("M d, Y", strtotime($overtime->date));
                $no_of_hours[$i] = $overtime->no_of_hours;
                $time_in[$i] = $overtime->time_in;
                $time_out[$i] = $overtime->time_out;
            }

            $data[$key]->ids = $ids;
            $data[$key]->dates = $date;
            $data[$key]->no_of_hours = $no_of_hours;
            $data[$key]->time_in = $time_in;
            $data[$key]->time_out = $time_out;
        }


        return $data;
    }
    public static function getNotificationData($ot_slug){
        $overtime_data = DB::table('overtime_request')
                            ->where('slug', $ot_slug)
                            ->first();

        return $overtime_data;
    }

}
