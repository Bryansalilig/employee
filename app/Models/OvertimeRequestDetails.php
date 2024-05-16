<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OvertimeRequestDetails extends Model
{
    use SoftDeletes;

    protected $table = 'overtime_request_details';
}
