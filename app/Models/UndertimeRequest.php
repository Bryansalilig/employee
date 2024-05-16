<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UndertimeRequest extends Model
{
    use SoftDeletes;

    protected $table = 'undertime_request';

    public static function getUndertime($in_type = 'pending', $in_method = 'list', $in_id = null)
    {
        $in_type = strtoupper($in_type);
        $query = '';
        switch($in_method) {
            case 'user':
            $query = " AND `employee_info`.`id`={$in_id}";
            $query .= " AND `undertime_request`.`status` = '{$in_type}'";
                break;
            case 'show':
            $query = " AND `undertime_request`.`id`={$in_id}";
                break;
            case 'team':
            $query = " AND (`employee_info`.`supervisor_id`={$in_id} OR `employee_info`.`manager_id`={$in_id})";
            $query .= " AND `undertime_request`.`status` = '{$in_type}'";
                break;
            default:
            $query = " AND `undertime_request`.`status` = '{$in_type}'";
                break;
        }

        $data = DB::select("
            SELECT
                `undertime_request`.*,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`contact_number`,
                `employee_info`.`position_name`,
                `employee_info`.`team_name`
            FROM
                `undertime_request`
            INNER JOIN 
                `employee_info`
            ON 
                `undertime_request`.`employee_id` = `employee_info`.`id`
            WHERE
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1 {$query}
            ORDER BY 
                `undertime_request`.`created_at` 
            DESC
        ");

        return $data;
    }
}
