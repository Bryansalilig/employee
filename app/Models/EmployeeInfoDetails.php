<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeInfoDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'employee_id';
    protected $table = "employee_info_details";
}
