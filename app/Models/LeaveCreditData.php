<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveCreditData extends Model
{
  protected $table = 'leave_credits_data';

  public $timestamps = false;

  protected $fillable = [
    'employee_id', 'type'
  ];
}
