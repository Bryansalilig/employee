<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DAInfraction extends Model
{
    use SoftDeletes;

    protected $table = 'da_infraction';

    public static function getInfractions($in_id = null, $in_type = 'list', $in_status = 'all')
    {
        $query = '1';

        if(!empty($in_id) && $in_type != 'team') {
            $query .= " AND `da_infraction`.`employee_id` = {$in_id}";
        }

        if($in_type == 'team') {
            $query .= " AND (`employee_info`.`supervisor_id`={$in_id} OR `employee_info`.`manager_id`={$in_id})";
        }

        if($in_type == 'reminder') {
            $query .= " AND `da_infraction`.`status` = 0";
        }

        if($in_status != 'all') {
            if($in_status == 'nod') {
                $query .= " AND `da_infraction`.`infraction_type`='NOD'";
            } else {
                $in_status = ($in_status == 'pending') ? 'NONE' : strtoupper($in_status);
                $query .= " AND `da_infraction`.`infraction_type`='NTE'";
                if($in_status != 'NTE') {
                    $query .= " AND `da_infraction`.`approved_status`='{$in_status}'";
                }
            }
        }

        $data = DB::select("
            SELECT
                `da_infraction`.*,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`,
                `employee_info`.`email`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`contact_number`,
                `employee_info`.`position_name`,
                `employee_info`.`team_name`
            FROM
                `da_infraction`
            INNER JOIN 
                `employee_info`
            ON 
                `da_infraction`.`employee_id` = `employee_info`.`id`
            WHERE
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1 AND
                {$query}
            ORDER BY 
                `da_infraction`.`created_at` 
            DESC
        ");

        return $data;
    }
}
