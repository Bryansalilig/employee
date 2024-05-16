<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployeeDepartment extends Model
{
    use SoftDeletes;
    protected $table = "employee_department";
    public $timestamps = false;

    public function manager(){
    	return $this->belongsTo('App\Models\User', 'manager_id');
    }
    public function division(){
    	return $this->belongsTo('App\Models\ElinkDivision', 'division_id');
    }
    public function account(){
    	return $this->belongsTo('App\\Models\ElinkAccount', 'account_id');
    }
}
