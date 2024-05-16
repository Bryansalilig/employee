<?php

namespace App\Models;

use App\Models\LeaveRequestDetails;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class LeaveRequest extends Model
{
    protected $table = 'leave_request';

    public function employee()
    {
    	return $this->belongsTo('App\User', 'employee_id');
    }

    public function leave_type()
    {
    	return $this->belongsTo('App\LeaveType');
    }

    public function pay_type()
    {
    	return $this->belongsTo('App\PayType');
    }

    public function leave_details_from()
    {
        return $this->hasMany('App\Models\LeaveRequestDetails',"leave_id")->orderBy("date","asc")->take(1);

    }

    public function leave_details_to()
    {
        return $this->hasMany('App\Models\LeaveRequestDetails',"leave_id")->orderBy("date","desc")->take(1);
    }

    public function leave_details()
    {
        return $this->hasMany('App\Models\LeaveRequestDetails',"leave_id");
    }

    public function scopeUnapproved($query)
    {
        return $query->where('approve_status_id', '=', 0)->orWhereNull('approve_status_id');
    }

    public function recipients()
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));

        $main_recipients = json_decode($settings->get('leave_email_main_recipients'));
        $business_leaders = json_decode($settings->get('business_leaders'));

        $email_recipients = [];
        $business_leader_emails = [];

        if ($main_recipients != NULL){
            foreach ($main_recipients as $key => $email) {
                array_push($email_recipients, $email->value);
            }
        }
        if ($business_leaders != NULL){
            foreach ($business_leaders as $key => $email) {
                array_push($business_leader_emails, $email->value);
            }
        }

        // GET SUPERVISOR AND MANAGER EMAILS
        $supervisor_recipient = $this->employee->supervisor_email();
        $manager_recipient = $this->employee->manager_email();

        if ($this->employee->isManager() || $this->employee->isBusinessLeader()){
            array_push($email_recipients, $this->employee->generalManager()->email);
        } else if ($this->employee->isSupervisor()) {
            array_push($email_recipients, $this->employee->generalManager()->email);
            array_push($email_recipients, $manager_recipient);
        } else if ($this->employee->isRankAndFile()){
            array_push($email_recipients, $supervisor_recipient);
            array_push($email_recipients, $manager_recipient);
        } 
        return array_values(array_filter(array_unique($email_recipients)));
    }

    public function scopeManagedBy($query, $user)
    {
        $id = $user->id;
        return $query->whereHas('employee', function($q) use ($id){
            $q->where('supervisor_id', '=',$id);
        })->orWhereHas('employee', function($q) use ($id){
            $q->where('manager_id', '=',$id);
        });
    }

    public function scopeMyLeaves($query,$user)
    {
        $id = $user->id;
        return $query->where('employee_id','=',$id);
    }

    public function scopeStatus()
    {
        if($this->approve_status == 1){
            return "Approved";
        } else if($this->approved_by_signed_date != NULL){
            return "Approved";
        } else if($this->noted_by_signed_date != NULL){
            return "Approved";
        } else if($this->recommending_approval_by_signed_date != NULL){
            return "Recommended";
        } else {
            return "Not yet approved";
        }
    }

    public function getApprovalStatus()
    {
        if($this->approve_status_id == 0){
            return '<span class="fa fa-refresh"></span> Waiting for response';
        } else if($this->approve_status_id == 1){
            return '<span class="fa fa-check" style="color: green"></span> Approved';
        } else if($this->approve_status_id == 2){
            return '<span class="fa fa-thumbs-down" style="color: darkred"></span> Declined<br>Reason for disapproval: ' . $this->reason_for_disapproval;
        }
        return 'Waiting for response';
    }

    public function scopeLeaveDays()
    {
        if($this->number_of_days == 0.5){
            return "half day";
        } else if($this->number_of_days % 1 == 0.5){
            if((int)$this->number_of_days == 1){
                return (int)$this->number_of_days . ' day and a half days';
            }
            return (int)$this->number_of_days . ' days and a half days';
        } else if((int)$this->number_of_days == 1){
            return (int)$this->number_of_days . ' day';
        }
        else {
            return (int)$this->number_of_days . ' days';
        }
    }

    public function scopeIsForRecommend()
    {
        return Auth::user()->id == $this->employee->supervisor_id && $this->recommending_approval_by_signed_date == NULL && $this->approve_status_id != 2;
    }

    public function scopeIsForApproval()
    {
        return Auth::user()->id == $this->employee->manager_id && $this->approved_by_signed_date == NULL && $this->approve_status_id != 2;
    }

    public function scopeIsForNoted()
    {
        return Auth::user()->isHR() && ($this->noted_by_signed_date == NULL && $this->approve_status_id != 2);
    }

    public function scopeCanBeDeclined()
    {
        return ($this->isForRecommend() || $this->isForApproval() || $this->isForNoted()) && $this->approve_status_id != 2;
    }

    public function getEmployeeName($id)
    {
        return DB::table('employee_info')->where('id', $id)->get();
    }

    public static function getBlockedDates($dept)
    {
        if(Auth::user()->isManager())
            DB::select("
                SELECT 
                    d.date AS cwd
                FROM
                    leave_request_details AS d
                        LEFT JOIN
                    leave_request AS l ON l.id = d.leave_id
                        LEFT JOIN
                    employee_info AS e ON l.employee_id = e.id
                WHERE
                    (e.team_name = '$dept' or e.usertype = 3 )
                        AND d.date >= CURDATE()
                        AND l.approve_status_id <> 2
                        AND d.pay_type <> 3
                        AND d.status = 1
                ORDER BY d.date ASC
            ");
        else
            return DB::select("
                SELECT 
                    d.date AS cwd
                FROM
                    leave_request_details AS d
                        LEFT JOIN
                    leave_request AS l ON l.id = d.leave_id
                        LEFT JOIN
                    employee_info AS e ON l.employee_id = e.id
                WHERE
                    e.team_name = '$dept'
                        AND d.date >= CURDATE()
                        AND l.approve_status_id <> 2
                        AND d.pay_type <> 3
                        AND d.status = 1
                ORDER BY d.date ASC
            ");
    }

    public static function getCWD()
    {
        return DB::select("
            SELECT 
                DATE_FORMAT(start_date, '%Y-%m-%d') AS cwd
            FROM
                events
            WHERE
                start_date >= CURDATE();"
        );
    }

    public static function getLeave($leave_type = 'pending', $id = null, $type = 'list', $is_separated = null)
    {
        $query = "";
        switch ($leave_type) {
            case 'approve':
                $query = "`leave_request`.`approve_status_id` = 1 ";
                break;
            case 'cancelled':
                $query = "`leave_request`.`approve_status_id` = 2 ";
                break;
            case 'separated':
                $query = "`leave_request`.`approve_status_id` IS NOT NULL ";
                break;
            default:
                $query = "(`leave_request`.`approve_status_id` = 0 OR `leave_request`.`approve_status_id` = 3) ";
                break;
        }

        if(!empty($id) && $type == 'list') {
            $query .= "AND `leave_request`.`employee_id`={$id}";
        }

        if(!empty($id) && $type == 'team') {
            $query .= "AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})";
        }

        $query2 = "1";
        if(empty($is_separated)) {
            $query2 = "`employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1";
        }

        $data = DB::select("
            SELECT
                `leave_request`.*,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`
            FROM
                `leave_request`
            LEFT JOIN 
                `employee_info`
            ON 
                `leave_request`.`employee_id` = `employee_info`.`id`
            WHERE
                {$query} AND
                `leave_request`.`status` = 1 AND
                {$query2}
            ORDER BY 
                `leave_request`.`date_filed` 
            DESC
        ");

        $leave_details  = [];
        foreach($data as $key=>$value) {
            $details = DB::select("SELECT * FROM `leave_request_details` WHERE `leave_request_details`.`leave_id` = {$value->id} AND `leave_request_details`.`status` != 0 AND `leave_request_details`.`pay_type` != 3 ORDER BY `leave_request_details`.`date`");

            if(!empty($details)) {
                $leave_details[$key] = $value;
                $leave_details[$key]->leave_details = $details;
            }
        }

        return $leave_details;
    }

    public static function getLeavePendingCount($in_id = null)
    {
        if(empty($in_id)) {
            return 0;
        }

        $leaves = LeaveRequest::where('approve_status_id', '<>', 1)->where('approve_status_id', '<>', 2)->where('employee_id', $in_id)->get();

        $count = 0;
        foreach($leaves as $leave) {
            $details = LeaveRequestDetails::where('leave_id', $leave->id)->where('pay_type', 1)->get();
            foreach($details as $detail) {
                $count += $detail->length;
            }
        }

        return $count;
    }

    public static function extractLeaves($in_data = [])
    {
        $condition = '1';
        foreach($in_data as $key=>$val) {
            $condition .= " AND {$key}='{$val}'";
        }

        $data = DB::select("
            SELECT
                `leave_request`.`id`,
                `leave_request`.`leave_type_id`,
                `leave_request`.`pay_type_id`,
                `leave_request`.`reason`,
                `leave_request`.`date_filed`,
                `leave_request_details`.`date`,
                `leave_request_details`.`length`,
                `leave_request_details`.`pay_type`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                CONCAT(`employee_info`.`last_name`, ', ', `employee_info`.`first_name`) AS 'fullname',
                '' AS 'supervisor',
                '' AS 'manager'
            FROM
                `leave_request`
            LEFT JOIN 
                `employee_info`
            ON 
                `leave_request`.`employee_id` = `employee_info`.`id`
            INNER JOIN 
                `leave_request_details`
            ON 
                `leave_request_details`.`leave_id` = `leave_request`.`id`
            WHERE
                {$condition} AND
                `employee_info`.`status` = 1 AND
                `employee_info`.`deleted_at` IS NULL AND
                `leave_request`.`approve_status_id` = 1 AND
                `leave_request`.`status` = 1
            ORDER BY 
                `leave_request_details`.`date` 
            DESC
        ");

        $leave_details  = [];
        foreach($data as $key=>$value) {
            $supervisor = User::find($value->supervisor_id);
            $manager = User::find($value->manager_id);
            $leave_type = LeaveType::find($value->leave_type_id);

            if(!empty($supervisor)) { $value->supervisor = $supervisor->last_name.', '.$supervisor->first_name; }
            if(!empty($manager)) { $value->manager = $manager->last_name.', '.$manager->first_name; }
            $value->pay_type_id = ($value->pay_type_id == 1) ? 'Planned' : 'Unplanned';
            $value->pay_type = ($value->pay_type == 1) ? 'With Pay' : 'Without Pay';
            $value->leave_type_id = empty($leave_type) ? 'CTO' : $leave_type->leave_type_name;

            $leave_details[$value->id][] = $value;
        }

        return $leave_details;
    }

}
