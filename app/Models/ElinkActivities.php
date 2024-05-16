<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ElinkActivities extends Model
{

    protected $table = "elink_activities";

    public function scopeThisMonth($query)
    {
    	return $query->whereRaw('MONTH(activity_date) =' . date('n') . " AND YEAR(activity_date) = " .date('Y') . ' OR MONTH(activity_date) = ' . date("n", strtotime("first day of previous month")) . " AND YEAR(activity_date) = " . date("Y", strtotime("first day of previous month")));
    }

    public static function getActivities()
    {
        $date_start = date('Y-m-d');
        $date_end = date('Y-m-d', strtotime('+30 days'));

        $data = DB::select("
            SELECT 
                `elink_activities`.*
            FROM 
                `elink_activities`
            WHERE
                DATE(`elink_activities`.`activity_date`) BETWEEN '{$date_start}' AND '{$date_end}'
            ORDER BY
                `elink_activities`.`activity_date`
        ");

        return $data;
    }
}
