<?php
/**
 * Controller for Leave Request Module
 *
 * This controller handles CRUD operations related to Leave Request.
 *
 * @version 1.0
 * @since 2024-06-07
 *
 * Changes:
 * - 2024-06-07: File creation
 */

namespace App\Http\Controllers;

use App\Models\LeaveAudit;
use App\Models\LeaveCreditData;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestDetails;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller class definition
class LeaveController extends Controller
{
  /**
   * @var array
   */
  public static $data = [];

  /**
   * Constructor method to set up session data.
   *
   * This method initializes session variables for view and menu navigation
   * within the Leave Request Module.
   */
  public function __construct()
  {
    // Set variables for view and menu navigation
    self::$data['menu'] = 'leave';
  }

  /**
   * Display all leave requests based on the status.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    // Determine the status from the request, defaulting to 'pending' if not provided
    $status = empty($request->status) ? 'pending' : $request->status;

    // Set variables for leave requests based on the current user's ID and the status
    self::$data['items'] = LeaveRequest::getLeave($status, Auth::user()->id);
    self::$data['status'] = $status;

    // If the user is an administrator, fetch all leave requests regardless of user ID
    if(Auth::user()->isAdmin()){ self::$data['items'] = LeaveRequest::getLeave($status); }

    // Return the index view with the leave request data
    return view('leave.index', self::$data);
  }

  /**
   * Display the leave request form.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function create()
  {
    // Set variables for the list of employees excluding the Super Admin and CEO, and the list of active leave types
    self::$data['employees'] = User::AllExceptSuperAdmin()->where('position_name', '<>', 'CEO')->orderBy('last_name')->get();
    self::$data['leave_types'] = LeaveType::where('status' , '<>', 3)->get();

    // Return the create view with the necessary data
    return view('leave.create.index', self::$data);
  }

  /**
   * Function to add a new leave request after form submission.
   *
   * @param  \Illuminate\Http\Request  $request  The request instance containing form data
   * @return \Illuminate\Http\Response  The response instance indicating the outcome of the operation
   */
  public function store(Request $request)
  {
    // Create a new LeaveRequest instance and populate it with form data
    $item = new LeaveRequest();
    $item->employee_id = $request->employee_id;
    $item->number_of_days = ($request->pay_type_id == 1) ? array_sum($request->planned_length) : array_sum($request->unplanned_length);
    $item->leave_type_id = $request->leave_type_id;
    $item->pay_type_id = $request->pay_type_id;
    $item->report_date = $request->report_date;
    $item->contact_number = $request->contact_number;
    $item->reason = $request->reason;
    $item->filed_by_id = Auth::user()->id;
    $item->date_filed = date('Y-m-d H:i:s');

    // Attempt to save the leave request
    if ($item->save()) {
      // Generate a unique slug for the leave request
      $first = substr(time(), 2);
      $second = substr(md5($item->id), -4);
      $third = substr(uniqid(), -4);
      $fourth = substr(rand(), -4);
      $fifth = generateRandomString();
      $item->slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
      $item->save();

      // Save the leave request details based on pay type
      if ($request->pay_type_id == 1) { // Planned leave
        for ($i = 0; $i < count($request->planned_date); $i++) {
          $details = new LeaveRequestDetails();
          $details->leave_id = $item->id;
          $details->date = $request->planned_date[$i];
          $details->length = $request->planned_length[$i];
          $details->pay_type = $request->planned_pay_type[$i];
          $details->save();
        }
      } else { // Unplanned leave
        for ($i = 0; $i < count($request->unplanned_date); $i++) {
          $details = new LeaveRequestDetails();
          $details->leave_id = $item->id;
          $details->date = $request->unplanned_date[$i];
          $details->length = $request->unplanned_length[$i];
          $details->pay_type = $request->unplanned_pay_type[$i];
          $details->save();
        }
      }

      // Redirect back with success message
      return back()->with('success', 'Successfully Added an Activity!');
    } else {
      // Redirect back with error message if saving fails
      return back()->with('error', 'Something went wrong.');
    }
  }

  /**
   * Show a specific leave request based on its slug.
   *
   * @param  string  $slug  The unique identifier for the leave request
   * @return \Illuminate\Contracts\View\View  The view displaying the leave request details
   */
  public function show($slug)
  {
    // Retrieve the leave request using the slug
    $item = LeaveRequest::where('slug', $slug)->first();

    // If no leave request is found, redirect to a 404 error page
    if(empty($item)) {
      redirect('error404');
      return;
    }

    // Populate the data array with leave request details
    self::$data['item'] = $item;
    self::$data['details'] = LeaveRequestDetails::where('leave_id', $item->id)->orderBy('date')->get();
    self::$data['employee'] = User::withTrashed()->find($item->employee_id);
    self::$data['type'] = LeaveType::find($item->leave_type_id);
    self::$data['audits'] = LeaveAudit::where('leave_id', $item->id)->orderBy('created_at', 'DESC')->get();

    // Return the view with the leave request details
    return view('leave.info.index', self::$data);
  }

  /**
   * Recommend the leave request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function recommend(Request $request)
  {
    $item = LeaveRequest::find($request->id);
    if($item->approve_status_id == 3) {
      return response()->json(['ret' => 0, 'msg'=>'Leave Request already Recommended.']);
    }

    if($item->approve_status_id == 2) {
      return response()->json(['ret' => 0, 'msg'=>'Leave Request already Declined.']);
    }

    if($item->approve_status_id == 1) {
      return response()->json(['ret' => 0, 'msg'=>'Leave Request already Approved.']);
    }

    $employee = User::withTrashed()->find($item->employee_id);
    $manager = User::find($employee->manager_id);

    if ($employee->superior_id == Auth::user()->id) {
      $item->superior_signed_date = date('Y-m-d H:i:s');
    } else {
      $item->recommending_approval_by_id = Auth::user()->id;
      $item->recommending_approval_by_signed_date = date('Y-m-d H:i:s');
    }
    $item->approve_status_id = 3;

    $audit = new LeaveAudit();
    $audit->leave_id = $request->id;
    $audit->employee_id = Auth::user()->id;
    $audit->name = 'Status';
    $audit->old = 'Pending';
    $audit->new = 'Recommended';
    $audit->created_at = date('Y-m-d H:i:s');
    $audit->save();

    if($item->save()) {
      // $data = [
      //   'emp_name' => strtoupper($employee->last_name .', '. $employee->first_name),
      //   'url'       => url("leave/{$leave_request->slug}")
      // ];

      // if(empty($manager)) {
      //   $data['leader_name'] = 'HR DEPARTMENT';

      //   Mail::to('hrd@elink.com.ph')->send(new LeaveReminder($data));
      // } else {
      //   $data['leader_name'] = strtoupper($manager->first_name); 

      //   Mail::to($manager->email)->send(new LeaveReminder($data));
      // }

      return response()->json(['ret' => 1, 'msg'=>'Leave request successfully recommended for approval.', 'url'=>route('leave.show', ['slug' => $item->slug])]);
    } else {
      return response()->json(['ret' => 0, 'msg'=>'Something went wrong.']);
    }
  }

  /**
   * Approve the leave request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function approve(Request $request)
  {
    /* Get Leave Request Data and Update approved date and approve status */
    $leave_request = LeaveRequest::find($request->id);

    $item = LeaveRequest::find($request->id);
    if($item->approve_status_id == 2) {
      return response()->json(['ret' => 0, 'msg'=>'Leave Request already Declined.']);
    }

    if($item->approve_status_id == 1) {
      return response()->json(['ret' => 0, 'msg'=>'Leave Request already Approved.']);
    }

    $employee = User::withTrashed()->find($item->employee_id);
    $details = LeaveRequestDetails::where('leave_id', $item->id)->where('status', 1)->where('pay_type', 1)->get();

    $with_pay = 0;
    foreach($details as $detail) { $with_pay += ($detail->length == '0.50') ? 0.5 : 1; }

    $audit = new LeaveAudit();
    $audit->leave_id = $request->id;
    $audit->employee_id = Auth::user()->id;
    $audit->name = 'Status';
    $audit->old = ($item->approve_status_id == 3) ? 'Recommended' : 'Pending';
    $audit->new = 'Approved';
    $audit->created_at = date('Y-m-d H:i:s');
    $audit->save();

    $item->approved_by_id = Auth::user()->id;
    $item->approved_by_signed_date = date('Y-m-d H:i:s');
    $item->approve_status_id = 1;

    if($item->save()){
      $credit = new LeaveCreditData();
      $credit->employee_id = $employee->id;
      $credit->credit = $with_pay * -1;
      $credit->type = 'USED';
      $credit->month = date('n');
      $credit->year = date('Y');
      $credit->leave_id = $item->id;
      $credit->created_at = date('Y-m-d H:i:s');
      $credit->save();

      // Mail::to($employee->email)->send(new LeaveApproved(['emp_name' => strtoupper($employee->first_name), 'date' => $first_date]));

      return response()->json(['ret' => 1, 'msg'=>'Leave request successfully approved.', 'url'=>route('leave.show', ['slug' => $item->slug])]);
    } else {
      return response()->json(['ret' => 0, 'msg'=>'Something went wrong.']);
    }
  }

  /**
   * Edit a specific leave request based on its slug.
   *
   * @param  string  $slug  The unique identifier for the leave request
   * @return \Illuminate\Contracts\View\View  The display that lets you edit the leave request
   */
  public function edit($slug)
  {
    // Retrieve the leave request using the slug
    $item = LeaveRequest::where('slug', $slug)->first();

    // If no leave request is found, redirect to a 404 error page
    if(empty($item)) {
      redirect('error404');
      return;
    }

    // Populate the data array with leave request details
    self::$data['item'] = $item;
    self::$data['details'] = LeaveRequestDetails::where('leave_id', $item->id)->orderBy('date')->get();
    self::$data['employee'] = User::withTrashed()->find($item->employee_id);
    self::$data['type'] = LeaveType::find($item->leave_type_id);
    self::$data['leave_types'] = LeaveType::where('status' , '<>', 3)->get();
    self::$data['audits'] = LeaveAudit::where('leave_id', $item->id)->orderBy('created_at', 'DESC')->get();

    // // Return the view with the leave request details
    return view('leave.edit.index', self::$data);
  }
}
