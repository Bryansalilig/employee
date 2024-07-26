<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\OvertimeRequest;
use App\Models\OvertimeRequestDetails;
use App\Models\Notifications;
use App\Models\NotificationDetails;
use App\Events\OvertimeNotification;
use App\Models\User;
use App\Models\Log;

class OvertimeController extends Controller
{
    public function index(Request $request)
    {

        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'pending');
        $id = Auth::user()->id;
        // echo "<pre>";
        // echo $status;
        // return;

        $data['overtime_request'] = OvertimeRequest::getOvertime($status, 'user', $id);

        // echo "<pre>";
        // print_r($data['overtime_request']);
        // return;
        $data['type'] = $status;
        $data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));
        $data['status_filter'] = $request->input('status');
        // if user is admin retrieve all pending overtime
        if(Auth::user()->isAdmin()){ $data['overtime_request'] = OvertimeRequest::getOvertime($status); }

        return view('overtime.overtime_request', $data);
    }

    public function create()
    {
        $data['employees'] = User::AllExceptSuperAdmin()->activeEmployees()->orderBy('first_name')->get();

        return view('overtime.create', $data);
    }

    public function store(Request $request)
    {

        $employee = User::withTrashed()->find($request->employee_id);

        $notif = new Notifications();
        $notif->sender_id = $request->employee_id;
        $notif->module = "Overtime";
        $notif->message = "Filed Overtime";
        $notif->reason = $request->reason;

        if($notif->save()) {
            $notif_details = new NotificationDetails();
            $notif_details->notif_id = $notif->id;
            $notif_details->supervisor_id = $employee->supervisor_id;
            $notif_details->manager_id = $employee->manager_id;
            if ($notif_details->approver_id == 0) {
                $notif_details->approver_id = $employee->manager_id;
            }
            $notif_details->save();
        }

        if(!$employee) {
            return Redirect::route('error404');
        }

        $overtime = new OvertimeRequest();
        $overtime->employee_id = $employee->id;
        $overtime->reason = $request->reason;
        $overtime->save();
        $dates = $request->date;
        $hours = $request->no_of_hours;

        $combined = array_map(function ($date, $hours) {
            return [
                'date' => $date,
                'no_of_hours' => $hours,
            ];
        }, $dates, $hours);

        foreach ($combined as $data) {
            $date = $data['date'];
            $no_of_hours = $data['no_of_hours'];

            $detail = new OvertimeRequestDetails();
            $detail->overtime_id = $overtime->id;
            $detail->date = Carbon::parse($date)->toDateString();
            $detail->no_of_hours = $no_of_hours;
            $detail->save();

        }

        $first = strtotime(date('Y-m-d H:i:s'));
        $second = substr(md5($overtime->id), -4);
        $third = substr(uniqid(), -4);
        $fourth = substr(rand(), -4);
        $fifth = generateRandomString();

        $slug = $first.'-'.$second.'-'.$third.'-'.$fourth.'-'.$fifth;

        $overtime->slug = $slug;
        $overtime->save();

        $notif->url =  url("overtime/".$overtime->slug);
        $notif->save();

        $supervisor = User::find($employee->supervisor_id);
        $manager = User::find($employee->manager_id);

        $data['id'] = $overtime->id;
        $data['requester_name'] = strtoupper($employee->fullname());
        $data['details'] = $combined;
        $data['url'] = url("overtime/{$slug}");
        $data['emp_name'] = 'CC MAIL';
        $data['reason'] = $request->reason;

        if(!empty($supervisor->id) || !empty($manager->id)) {
            $data['emp_name'] = strtoupper($supervisor->first_name);

            event(new OvertimeNotification($notif->id, $notif->message, $notif->reason, $notif->url, $employee));

            if(!empty($supervisor->id)) {
            // Mail::to($supervisor->email)->send(new OvertimeNotification($data));
            }

            if(!empty($manager->id)) {
             // Mail::to($manager->email)->send(new OvertimeNotification($data));
            }
        }

        // Mail::to($employee->email)->send(new OvertimeSelfNotification(['emp_name' => strtoupper($employee->first_name)]));

        $log = new Log();
        $log->employee_id = Auth::user()->id;
        $log->module_id = $overtime->id;
        $log->module = 'Overtime';
        $log->method = 'Insert';
        $log->message = 'Created an Overtime Request';
        $log->save();

        return back()->with('success', 'Overtime Request Successfully Submitted!!');
    }

    public function multiApprove(Request $request)
    {
        $ids = $request->input('ids'); // Use $request->input() to get input data
        foreach ($ids as $id) {
            $request->merge(['id' => $id]);
            $this->approve($request); // Call the approve function for each ID
        }
        // You can return a response or perform additional actions as needed
        return response()->json(['ret' => true, 'message' => 'Overtime requests approve successfully']);
    }

    public function approve(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->approved_id = Auth::user()->id;
        $overtime->approved_date = date('Y-m-d H:i:s');
        $overtime->approved_reason = null;
        $overtime->status = 'APPROVED';

        $employee = User::withTrashed()->find($overtime->employee_id);
        $details = DB::select("SELECT * FROM `overtime_request_details` WHERE `overtime_request_details`.`overtime_id` = {$overtime->id} ORDER BY `overtime_request_details`.`date`");

        $obj = [];
        foreach($details as $key=>$detail) {
            $obj[$key]['date'] = date('Y-m-d', strtotime($detail->date));
            $obj[$key]['no_of_hours'] = $detail->no_of_hours;
        }

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'date' => $details[0]->date,
            'details' => $obj,
            'reason' => $overtime->reason
        ];

        $log = new Log();
        $log->employee_id = Auth::user()->id;
        $log->module_id = $overtime->id;
        $log->module = 'Overtime';
        $log->method = 'Approved';
        $log->message = 'Approved the Overtime Request';
        $log->save();

        if($overtime->save()){
            // Mail::to($employee->email)->send(new OvertimeApproved($data));

            return back()->with('success', 'Overtime Request successfully approved. . .');
        } else {
            return back()->with('error', 'Something went wrong. . .');
        }
    }

    public function updateNo(Request $request)
    {
        // Check if the request is AJAX
        if ($request->ajax()) {
            $senderId = $request->sender_id;
            $reason = $request->reason;

            // Find the notification record
            $notification = Notifications::where('sender_id', $senderId)->where('reason', $reason)->first();

            // Update the status
            if ($notification) {
                $notification->status = 1;
                $notification->save();
                return response()->json(['success' => 'Status successfully updated']);
            } else {
                return response()->json(['error' => 'Notification not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }


    public function show($slug)
    {
        $item = OvertimeRequest::getOvertime('', 'show', $slug);
        if(count($item) <= 0) {
            return redirect('/404');
            exit;
        }
        // echo "<pre>";
        // print_r($item[0]);
        // return;
        $completer = User::withTrashed()->find($item[0]->completed_id);

        if (empty($completer)){
            $completer = User::withTrashed()->find($item[0]->approver_id);

            if (empty($completer)) {
                $completer = ($item[0]->approved_id) ? User::withTrashed()->find($item[0]->approved_id) : User::withTrashed()->find($item[0]->manager_id);
            }
        }
        $overtime = OvertimeRequest::withTrashed()->where('slug', $slug)->first();

        $employee = User::withTrashed()->where('id', $overtime->employee_id)->first();

        if(Auth::user()->usertype == 2 || Auth::user()->usertype == 3){
            if($employee->supervisor_id != Auth::user()->id){
                if(Auth::user()->usertype == 2 || Auth::user()->usertype == 3){

                }else {
                    return redirect('404');
                }
            }

        } else if (Auth::user()->usertype == 1 && !Auth::user()->isAdmin()){
            if(Auth::user()->id != $item[0]->employee_id){
                return redirect('404');
            }
        }

        $data['employee'] = $employee;
        $data['overtime'] = $item[0];
        $data['manager'] = ($item[0]->approved_id) ? User::withTrashed()->find($item[0]->approved_id) : User::withTrashed()->find($item[0]->manager_id);
        $data['supervisor'] = ($item[0]->recommend_id) ? User::withTrashed()->find($item[0]->recommend_id) : User::withTrashed()->find($item[0]->supervisor_id);
        $data['completer'] = $completer;
        $data['logs'] = Log::getLog('Overtime', $item[0]->id);

        return view('overtime.overtime_show', $data);
    }

    public function team(Request $request)
    {
        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'pending');
        $id = Auth::user()->id;

        $data['overtime_request'] = OvertimeRequest::getOvertime($status, 'team', $id);
        $data['type'] = $status;
        $data['status_filter'] = $request->input('status');

        return view('overtime.overtime_team', $data);
    }

    public function recommend(Request $request)
    {
        echo "<pre>";
        echo $request->id;
        return;
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        echo "<pre>";
        print_r($overtime);
        return;
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->recommend_id = Auth::user()->id;
        $overtime->recommend_date = date('Y-m-d H:i:s');

        $employee = User::withTrashed()->find($overtime->employee_id);
        $manager = User::find($employee->manager_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->fullname()),
            'id' => $request->id,
            'url' => url("overtime/{$overtime->slug}")
        ];

        $log = new Log();
        $log->employee_id = Auth::user()->id;
        $log->module_id = $overtime->id;
        $log->module = 'Overtime';
        $log->method = 'Recommend';
        $log->message = 'Recommended the Overtime Request';
        $log->save();

        if($overtime->save()){
            if(empty($manager)) {
                $data['leader_name'] = 'HR DEPARTMENT';

                // Mail::to('hrd@elink.com.ph')->send(new OvertimeReminder($data));
            } else {
                $data['leader_name'] = strtoupper($manager->first_name);

                // Mail::to($manager->email)->send(new OvertimeReminder($data));
            }

            return back()->with('success', 'Overtime Request successfully recommended for approval.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function updateUnread(Request $request)
    {
        $notification = NotificationDetails::where('notif_id', $request->Id)->first();

        if ($notification->supervisor_id == Auth::user()->id) {
            $notification->supervisor_status = 1;
        }
        if ($notification->manager_id == Auth::user()->id) {
            $notification->manager_status = 1;
        }

        if ($notification->save()) {
            return redirect($request->Url);
        } else {
            return back()->with('error', 'Course not found or something went wrong.');
        }
    }
}
