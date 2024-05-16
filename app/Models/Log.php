<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    public $timestamps = false;

    protected $fillable = [
        'employee_id', // Add employee_id to this array
        'module_id',
        'module',
        'method',
        'message',
    ];

    public function employeeInfo()
    {
        return $this->belongsTo(EmployeeInfo::class, 'employee_id');
    }

    public static function getLog($in_module = '', $in_id = null)
    {
        $query = "1";
        if (!empty($in_id)) {
            $query .= " AND `log`.`module_id` = '{$in_id}'";
        }

        return self::select('log.*', 'employee_info.first_name', 'employee_info.last_name', 'employee_info.profile_img')
            ->join('employee_info', 'employee_info.id', '=', 'log.employee_id')
            ->where('log.module', $in_module)
            ->whereRaw($query)
            ->orderByDesc('log.created_at')
            ->get();
    }
}
