<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evaluation extends Model
{
    use HasFactory;
    protected $table = "evaluation";

    public static function getEvaluations($in_id = null, $in_type = 'list', $in_acknowledged = false)
    {
        $query = '1';
        if(!empty($in_id)) {
            if($in_type == 'team') {
                $query .= " AND (`employee_info`.`supervisor_id`={$in_id} OR `employee_info`.`manager_id`={$in_id})";
            } else {
                $query .= " AND `evaluation`.`employee_id` = {$in_id}";
            }
        }

        if($in_acknowledged) {
            $query .= " AND `evaluation`.`is_acknowledged` = 0";
        }

        $data = DB::select("
            SELECT
                `evaluation`.*,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`,
                `employee_info`.`email`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`contact_number`,
                `employee_info`.`position_name`,
                `employee_info`.`team_name`
            FROM
                `evaluation`
            INNER JOIN 
                `employee_info`
            ON 
                `evaluation`.`employee_id` = `employee_info`.`id`
            WHERE
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1 AND
                {$query}
            ORDER BY 
                `evaluation`.`created_at` 
            DESC
        ");

        return $data;
    }
}
