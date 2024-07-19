<?php
/**
 * Model for Leave Audit Module
 *
 * This model handles the Leave Request History.
 *
 * @version 1.0
 * @since 2024-07-13
 *
 * Changes:
 * - 2024-07-13: File creation
 */

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Valuestore\Valuestore;

class LeaveAudit extends Model
{
  protected $table = 'leave_audit';

  public $timestamps = false;

  protected $fillable = [
    'leave_id', 'employee_id'
  ];

  public function employee()
  {
    return $this->belongsTo('App\Models\User', 'employee_id');
  }
}
