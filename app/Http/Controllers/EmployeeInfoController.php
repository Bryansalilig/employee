<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ElinkAccount;
use App\Models\EmployeeDepartment;
use App\Models\EmployeeDependents;
use App\Models\EmployeeInfoDetails;
use App\Models\LeaveCredits;
use App\Models\LeaveRequest;
use App\Models\LinkingMaster;
use App\Models\Log;
use App\Models\MovementsTransfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EmployeeInfoController extends Controller
{
  public function employees(Request $request)
  {
    $departments = EmployeeDepartment::orderBy('department_name')->get();
    $positions = User::allExceptSuperAdmin()->select('position_name')->distinct()->orderBy('position_name')->get();
    $idx = empty(Auth::user()->id) ? 0 : Auth::user()->id;

    if(Auth::check() && Auth::user()->isAdmin()) {
      $employees = User::activeEmployees();
      $filtered = self::filterEmployees($employees, $request);
      $employees = $filtered->paginate(10);

      foreach($employees as $key=>$employee) {
        $manager = User::find($employee->manager_id);
        $supervisor = User::find($employee->supervisor_id);

        $employee->manager_name = (empty($manager) ? 'NO MANAGER' : $employee->manager_name);
        $employee->supervisor_name = (empty($supervisor) ? 'NO SUPERVISOR' : $employee->supervisor_name);
      }

      $data['employees'] = $employees;
      $data['request'] = $request;
      $data['departments'] = $departments;
      $data['positions'] = $positions;
      $data['active'] = true;

      return view('employee.list.index', $data);
    }
  }

  public function card(Request $request)
  {
    $departments = EmployeeDepartment::orderBy('department_name')->get();
    $positions = User::allExceptSuperAdmin()->select('position_name')->distinct()->orderBy('position_name')->get();
    $idx = empty(Auth::user()->id) ? 0 : Auth::user()->id;

    if(Auth::check() && Auth::user()->isAdmin()) {
      $employees = User::activeEmployees();
      $filtered = self::filterEmployees($employees, $request);
      $employees = $filtered->paginate(12);

      $data['employees'] = $employees;
      $data['request'] = $request;
      $data['departments'] = $departments;
      $data['positions'] = $positions;
      $data['active'] = true;

      return view('employee.card.index', $data);
    }
  }

  public function separated(Request $request)
  {
    $departments = EmployeeDepartment::orderBy('department_name')->get();
    $positions = User::allExceptSuperAdmin()->select('position_name')->distinct()->orderBy('position_name')->get();
    $idx = empty(Auth::user()->id) ? 0 : Auth::user()->id;

    if(Auth::check() && Auth::user()->isAdmin()) {
      $employees = User::separatedEmployees();
      $filtered = self::filterEmployees($employees, $request);
      $employees = $filtered->paginate(10);

      $data['employees'] = $employees;
      $data['request'] = $request;
      $data['departments'] = $departments;
      $data['positions'] = $positions;
      $data['active'] = false;

      return view('employee.list.index', $data);
    }
  }

  public function show($slug)
  {
    $employee = User::withTrashed()->where('slug', $slug)->first();
    if(empty($employee)) {
      redirect('errror404');
      return;
    }

    return view('employee.profile.index', self::showInformation($employee));
  }

  public function create(Request $request)
  {
    $data['departments'] = EmployeeDepartment::all();
    $data['accounts'] = ElinkAccount::all();
    $data['employees'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();

    return view('employee.create.index', $data);
  }

  public function store(Request $request)
  {
    $employee = new User();
    $details = new EmployeeInfoDetails();
    $movement = new MovementsTransfer();
    $password = generateRandomString(6);

    /* Employee Information Tab */
    $employee->first_name = $request->first_name;
    $employee->middle_name = $request->middle_name;
    $employee->last_name = $request->last_name;
    $employee->eid = $request->eid;
    $employee->alias = $request->alias;
    $employee->birth_date = $request->birth_date;
    $employee->contact_number = $request->contact_number;
    $employee->gender = $request->gender_id; // 1 - Male, 2 - Female
    $employee->civil_status = $request->civil_status; // 1 - Single, 2 - Married, 3 - Separated, 4 - Anulled, 5 - Divorced
    $employee->address = $request->address;
    $details->town_address = $request->town_address;
    $details->avega_num = $request->avega_num;
    if($request->gender_id == 1) {
      $employee->profile_img = URL::to("img/nobody_m.original.jpg");
    } else {
      $employee->profile_img = URL::to("img/nobody_f.original.jpg");
    }
    $employee->password = Hash::make($password);
    /* End Employee Information */

    /* Family Details Tab */
    $details->fathers_name = $request->fathers_name;
    $details->fathers_bday = $request->fathers_bday ?? '1970-01-01';
    $details->mothers_name = $request->mothers_name;
    $details->mothers_bday = $request->mothers_bday ?? '1970-01-01';
    $details->spouse_name = $request->spouse_name;
    $details->spouse_bday = $request->spouse_bday ?? '1970-01-01';
    /* End Family Details */

    /* In Case of Emergency Tab */
    $details->em_con_name = $request->em_con_name;
    $details->em_con_address = $request->em_con_address;
    $details->em_con_num = $request->em_con_num;
    $details->em_con_rel = $request->em_con_rel;
    /* End In Case of Emergency */

    /* Job Information Tab */
    $employee->position_name = $request->position_name;
    $employee->account_id = $request->account_id;
    if($department = EmployeeDepartment::find($request->department_id)) {
      $employee->dept_code = $department->department_code;
      $employee->team_name = $department->department_name;
    }
    $employee->manager_id = $request->manager_id;
    if($manager = User::find($request->manager_id)) {
      $employee->manager_name = $manager->fullName();
    }
    $employee->supervisor_id = $request->supervisor_id;
    if($supervisor = User::find($request->supervisor_id)) {
      $employee->supervisor_name = $supervisor->fullName();
    }
    $employee->is_regular = $request->is_regular; // 0 - Probationary, 1 - Regular, 2 - Project Based
    $employee->employee_category = $request->employee_category; // 1 - Manager, 2 - Supervisor, 3 - Support, 4 - Rank
    $employee->hired_date = $request->hired_date;
    $employee->prod_date = $request->prod_date;
    $employee->regularization_date = $request->regularization_date;
    $employee->ext = $request->ext;
    $employee->wave = $request->wave;
    $details->resignation_date = $request->resignation_date;
    $details->rehirable = $request->rehirable; // 0 - No, 1 - Yes
    $details->rehire_reason = $request->rehire_reason;
    $employee->notes = $request->notes;
    $employee->approver_id = $request->approver_id;
    /* End Job Information */

    /* Government Numbers Tab */
    $employee->sss = $request->sss;
    $employee->pagibig = $request->pagibig;
    $employee->philhealth = $request->philhealth;
    $employee->tin = $request->tin;
    /* End Government Numbers */

    /* Login Credentials Tab */
    $employee->email = $request->email;
    $employee->email2 = $request->email2;
    $employee->email3 = $request->email3;
    /* End Login Credentials */

    if($employee->save()) {
      self::saveLog($employee, 'add');

      /* Photo Tab */
      if($request->hasFile("profile_img")) {
        $path = $request->profile_img->store('images/' . $employee->id);
        $employee->profile_img =  asset('storage/app/' . $path);
      }
      /* End Photo */

      /* Save Slug */
      $first = substr(strtotime($employee->created_at), 2);
      $second = substr(md5($employee->id), -4);
      $third = substr(uniqid(), -4);
      $fourth = substr(rand(), -4);
      $fifth = generateRandomString();

      $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
      $employee->slug = $slug;
      $employee->save();
      /* End Slug */

      /* Save Employee Info Details */
      $details->employee_id = $employee->id;
      $details->save();
      /* End Save */

      /* Dependents Tab */
      $dependents = [];
      for($i = 0; $i < count($request->dependent_name); $i++) {
        if(empty($request->dependent_name[$i]) && empty($request->dependent_bday[$i]) && empty($request->generali_num[$i])) { continue; } // Ignore empty rows

        $dependent = new EmployeeDependents();
        $dependent->employee_num = $employee->id;
        $dependent->dependent = $request->dependent_name[$i];
        $dependent->bday = $request->dependent_bday[$i];
        $dependent->generali_num = $request->generali_num[$i];
        $dependent->save();
      }
      /* End Dependents */

      /* Save Movement */
      $movement->mv_employee_no = $employee->id;
      $movement->mv_transfer_date = $request->hired_date;
      $movement->mv_dept = $request->department_id;
      $movement->mv_position = $request->position_name;
      $movement->save();
      /* End Save */

      return redirect(url("employee-info/{$slug}"))->with('success', "Successfully Added New Employee");
    } else {
      return back()->with('error', "Oops, something went wrong. Please try again later.");
    }
  }

  public function update(Request $request)
  {
    $employee = User::withTrashed()->find($request->id);
    if(empty($employee)) {
      redirect('error404');
      return;
    }

    if($request->info == 'employee') {
      return self::updateEmployeeInfo($request);
    } else {
      return self::updateJobInfo($request);
    }
  }

  public function upload(Request $request)
  {
    $employee = User::withTrashed()->find($request->id);
    if(empty($employee)) {
      redirect('error404');
      return;
    }

    if($request->hasFile("upload")) {
      $path = $request->upload->store('images/' . $employee->id);
      $employee->profile_img =  asset('storage/app/' . $path);
      if($employee->save()) {
        return back()->with('success', "Profile Photo Successfully Uploaded!");
      }
    } else {
      return back()->with('error', "Oops, something went wrong. Please try again later.");
    }
  }

  public function reactivate(Request $request)
  {
    $employee = User::withTrashed()->find($request->id);
    if(empty($employee)) {
      redirect('error404');
      return;
    }

    if($employee->reactivate()) {
      self::saveLog($employee, 'reactivate');

      return response()->json(['ret' => 1, 'msg'=>'Successfully Reactivated Employee!', 'url'=>url("employee-info/{$employee->slug}")]);
    }
  }

  public function deactivate(Request $request)
  {
    $employee = User::find($request->id);
    if(empty($employee)) {
      redirect('error404');
      return;
    }

    if($employee->delete()) {
      self::saveLog($employee);

      return response()->json(['ret' => 1, 'msg'=>'Successfully Deactivated Employee!', 'url'=>url("employee-info/{$employee->slug}")]);
    }
  }

  public function duplicate(Request $request)
  {
    $employee = User::withTrashed()->where($request->field, $request->value)->first();
    if(empty($employee)) {
      return response()->json(['ret' => 1]);
    } else {
      $msg = '';
      if($request->field == 'eid') { $msg = 'Employee ID already existed!'; }
      if($request->field == 'email') { $msg = 'Company Email already existed!'; }

      return response()->json(['ret' => 0, 'msg'=>$msg]);
    }
  }

  public function view(Request $request)
  {
    $employee = User::withTrashed()->find($request->id);
    if(empty($employee)) {
      return response()->json(['ret' => 0, 'msg'=>'Employee Not Found!']);
    } else {
      $data = self::showInformation($employee);

      $html = '
      <div class="row">
        <div class="col-md-4">
          <div class="ibox">
            <div class="ibox-body text-center">
              <div class="img-profile">
                <div class="img-circle" style="background-image: url(\''.$employee->profile_img.'\');"></div>
              </div>
              <h5 class="font-strong m-b-10 m-t-10">'.formatName($employee->fullname2()).'</h5>
              <div class="text-muted">'.$employee->position_name.'</div>
              <div class="text-muted">'.$employee->team_name.'</div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="ibox">
            <div class="ibox-body">
              <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" href="#tab-employee-info" data-toggle="tab"><i class="ti-id-badge"></i> Basic Info</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tab-job-info" data-toggle="tab"><i class="ti-briefcase"></i> Job Info</a>
                </li>';
                if(count($data['linkees']) > 0) {
                $html .= '
                <li class="nav-item">
                  <a class="nav-link" href="#tab-linkee" data-toggle="tab"><i class="fa fa-users"></i> Subordinates</a>
                </li>';
                }
                if($data['manager']) {
                $html .= '
                <li class="nav-item">
                  <a class="nav-link" href="#tab-report-to" data-toggle="tab"><i class="fa fa-file"></i> Superiors</a>
                </li>';
                }
              $html .= '
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-employee-info">
                  <div class="row">
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">First Name</label>
                      <div class="text-muted">'.$employee->first_name.'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Middle Name</label>
                      <div class="text-muted">'.$employee->middle_name.'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Last Name</label>
                      <div class="text-muted">'.$employee->last_name.'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Gender</label>
                      <div class="text-muted">'.(($employee->gender === 1) ? 'Male' : 'Female').'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Birth Date</label>
                      <div class="text-muted">'.date('F d, Y', strtotime($employee->birth_date)).'</div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tab-job-info">
                  <div class="row">
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Hired Date</label>
                      <div class="text-muted">'.date('F d, Y', strtotime($employee->hired_date)).'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Position</label>
                      <div class="text-muted">'.$employee->position_name.'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Department</label>
                      <div class="text-muted">'.$employee->team_name.'</div>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                      <label class="mb-1">Email</label>
                      <div class="text-muted word-break">'.$employee->email.'</div>
                    </div>
                  </div>
                </div>';
                if(count($data['linkees']) > 0) {
                $html .= '
                <div class="tab-pane fade" id="tab-linkee" style="max-height:250px;overflow:auto;">
                  <ul class="media-list media-list-divider m-0">';
                    foreach($data['linkees'] as $key=>$linkee) {
                    $html .= '
                    <li class="media px-2">
                      <div class="media-img">
                        <div class="img-circle" style="background-image: url(\''.$linkee->profile_img.'\');"></div>
                      </div>
                      <div class="media-body">
                        <div class="media-heading">'.formatName($linkee->first_name.' '.$linkee->last_name).'</div>
                        <div class="font-13">
                          '.$linkee->position_name.'
                        </div>
                      </div>
                    </li>';
                    }
                  $html .= '
                  </ul>
                </div>';
                }
                if($data['manager']) {
                $html .= '
                <div class="tab-pane fade" id="tab-report-to">
                  <ul class="media-list media-list-divider m-0">';
                  if($data['reports_to']) {
                    $html .= '
                    <li class="media px-2">
                      <div class="media-img">
                        <div class="img-circle" style="background-image: url(\''.$data['manager']->profile_img.'\');"></div>
                      </div>
                      <div class="media-body">
                        <div class="media-heading">'.formatName($data['manager']->fullname2()).'</div>
                        <div class="font-13">'.$data['manager']->position_name.'</div>
                      </div>
                    </li>';
                  } else {
                    if($data['manager']) {
                      $html .= '
                      <li class="media px-2">
                        <div class="media-img">
                          <div class="img-circle" style="background-image: url(\''.$data['manager']->profile_img.'\');"></div>
                        </div>
                        <div class="media-body">
                          <div class="media-heading">'.formatName($data['manager']->fullname2()).'</div>
                          <div class="font-13">'.$data['manager']->position_name.'</div>
                        </div>
                      </li>';
                    }
                    if($data['supervisor']) {
                      $html .= '
                      <li class="media px-2">
                        <div class="media-img">
                          <div class="img-circle" style="background-image: url(\''.$data['supervisor']->profile_img.'\');"></div>
                        </div>
                        <div class="media-body">
                          <div class="media-heading">'.formatName($data['supervisor']->fullname2()).'</div>
                          <div class="font-13">'.$data['supervisor']->position_name.'</div>
                        </div>
                      </li>';
                    }
                  }
                  $html .= '
                  </ul>';
                }
              $html .= '
              </div>
            </div>
          </div>
        </div>
      </div>';

      return response()->json(['ret' => 1, 'html'=>$html]);
    }
  }

  private static function filterEmployees($employees, $request)
  {
    if($request->has('keyword') && $request->get('keyword') != "") {
      $employees = $employees->where(function($query) use($request) {
        $query->where('first_name', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('last_name', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('middle_name', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere(DB::raw('CONCAT(first_name, " ", last_name)'), 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('email', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('email2', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('email3', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('alias', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('team_name', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('dept_code', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('position_name', 'LIKE', '%'.$request->get('keyword').'%')
        ->orWhere('ext', 'LIKE', '%'.$request->get('keyword').'%');
      });
    }

    if($request->has('department') && $request->get('department') != "") {
      $employees = $employees->where('team_name', $request->get('department'));
    }

    if($request->has('position') && $request->get('position') != "") {
      $employees = $employees->where('position_name', $request->get('position'));
    }

    if($request->has('no_profile_images') && $request->get('no_profile_images') == 'true'){
      $employees = $employees->where(function($query) use($request){
        $query->where('profile_img', 'LIKE', 'http://clouddir.elink.corp/public/img/nobody_m.original.jpg')
        ->orWhere('profile_img', 'LIKE', 'http://clouddir.elink.corp/public/img/nobody_f.original.jpg')
        ->orWhereNull('profile_img');
      });
    }

    if($request->has('birthmonth') && $request->get('birthmonth') != "") {
      $employees = $employees->whereRaw('MONTH(birth_date) = '. $request->get('birthmonth'));
    }

    if($request->has('invalid_birth_date') && $request->get('invalid_birth_date') != "") {
      $employees = $employees->where(function($query) use ($request){
        $query->whereRaw('YEAR(birth_date) > ' . (date('Y') - 16) . ' OR YEAR(birth_date) <' . (date('Y') - 70))
        ->orWhereNull('birth_date');
      });
    }

    return $employees->where('id', '<>', 1)->orderBy('last_name', 'ASC');
  }

  private static function showInformation($employee)
  {
    $manager = User::find($employee->manager_id);
    $supervisor = User::find($employee->supervisor_id);
    $employees = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();
    $active = true;
    if($employee->status == 2 || !empty($employee->deleted_at)) {
      $manager = User::withTrashed()->find($employee->manager_id);
      $supervisor = User::withTrashed()->find($employee->supervisor_id);
      $employees = User::withTrashed()->where('id', '<>', 1)->orderBy('last_name')->get();
      $active = false;
    }

    $data['employee'] = $employee;
    $data['logs'] = Log::getLog('Employee', $employee->id, true);
    $data['leave_requests'] = LeaveRequest::where('employee_id', $employee->id)->orderBy('date_filed', 'DESC')->paginate(5);
    $data['details'] = EmployeeInfoDetails::where('employee_id', $employee->id)->first();
    $data['dependents'] = EmployeeDependents::where('employee_num', $employee->id)->where('status', 1)->get();
    $data['manager'] = $manager;
    $data['supervisor'] = $supervisor;
    $data['reports_to'] = ($employee->manager_id == $employee->supervisor_id) ? true : false;
    $data['employees'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->whereRaw("(manager_id='{$employee->id}' OR supervisor_id='{$employee->id}')")->orderBy('hired_date', 'DESC')->paginate(4);
    $data['session_ql'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 1)->count();
    $data['session_ce'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 2)->count();
    $data['session_as'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 3)->count();
    $data['session_sda'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 4)->count();
    $data['session_gtky'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 5)->count();
    $data['session_sb'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 6)->count();
    $data['session_gs'] = LinkingMaster::where('lnk_linkee', $employee->id)->where('lnk_type', 7)->count();
    $data['linkees'] = $employee->getLinkees();
    $data['supervisors'] = $employees;
    $data['departments'] = EmployeeDepartment::all();
    $data['accounts'] = ElinkAccount::all();
    $data['movements'] = MovementsTransfer::where('mv_employee_no', $employee->id)->leftJoin('employee_department','movements.mv_dept','=','employee_department.id')->orderBy('mv_transfer_date', 'DESC')->get();
    $data['positions'] = User::allExceptSuperAdmin()->select('position_name')->distinct()->orderBy('position_name')->get();
    $data['active'] = $active;

    return $data;
  }

  private static function validateEmployeeInfo($request)
  {
    $validator = Validator::make($request->all(), [
      'first_name' => 'required|max:50',
      'last_name' => 'required|max:50',
    ], [
      'first_name.required' => 'First Name field is required.',
      'first_name.max' => 'First Name must not exceed 50 characters.',
      'last_name.required' => 'Last Name field is required.',
      'last_name.max' => 'Last Name must not exceed 50 characters.',
    ]);

    $validator->stopOnFirstFailure();

    if($validator->fails()) {
      $errors = $validator->errors();
      $firstErrorField = $errors->keys()[0];
      $firstErrorMessage = $errors->first($firstErrorField);

      return back()->withInput()->with('error', $firstErrorMessage)->with('employee', true);
    }

    return back()->with('success', 'Yezzir')->with('employee', true);
  }

  private static function updateEmployeeInfo($request)
  {
    $employee = User::withTrashed()->find($request->id);
    $details = EmployeeInfoDetails::where('employee_id', $request->id)->first();
    if(empty($details)) {
      $details = new EmployeeInfoDetails();
      $details->employee_id = $request->id;
    }

    /* Employee Information Container */
    $employee->first_name = $request->first_name;
    $employee->middle_name = $request->middle_name;
    $employee->last_name = $request->last_name;
    $employee->alias = $request->alias;
    $employee->birth_date = $request->birth_date;
    $employee->contact_number = $request->contact_number;
    $employee->gender = $request->gender_id; // 1 - Male, 2 - Female
    $employee->civil_status = $request->civil_status; // 1 - Single, 2 - Married, 3 - Separated, 4 - Anulled, 5 - Divorced
    $employee->address = $request->address;
    $details->town_address = $request->town_address;
    $details->avega_num = $request->avega_num;
    /* End Employee Information */

    /* Family Details Container */
    $details->fathers_name = $request->fathers_name;
    $details->fathers_bday = $request->fathers_bday ?? '1970-01-01';
    $details->mothers_name = $request->mothers_name;
    $details->mothers_bday = $request->mothers_bday ?? '1970-01-01';
    $details->spouse_name = $request->spouse_name;
    $details->spouse_bday = $request->spouse_bday ?? '1970-01-01';
    /* End Family Details Container */

    /* Dependents Container */
    $dependents = [];
    EmployeeDependents::where('employee_num', $request->id)->delete(); // Delete Previous Entries
    for($i = 0; $i < count($request->dependent_name); $i++) {
      if(empty($request->dependent_name[$i]) && empty($request->dependent_bday[$i]) && empty($request->generali_num[$i])) { continue; } // Ignore empty rows

      $dependent = new EmployeeDependents();
      $dependent->employee_num = $request->id;
      $dependent->dependent = $request->dependent_name[$i];
      $dependent->bday = $request->dependent_bday[$i];
      $dependent->generali_num = $request->generali_num[$i];
      $dependent->save();
    }
    /* End Dependents Container */

    /* In Case of Emergency Container */
    $details->em_con_name = $request->em_con_name;
    $details->em_con_address = $request->em_con_address;
    $details->em_con_num = $request->em_con_num;
    $details->em_con_rel = $request->em_con_rel;
    /* End In Case of Emergency Container */

    if($employee->save() && $details->save()) {
      self::saveLog($employee, 'employee');

      return back()->with('success', "Successfully updated Employee information")->with('employee', true);
    } else {
      return back()->with('error', "Oops, something went wrong. Please try again later.")->with('employee', true);
    }
  }

  private static function updateJobInfo($request)
  {
    $employee = User::withTrashed()->find($request->id);
    $category = $employee->employee_category;
    $details = EmployeeInfoDetails::where('employee_id', $request->id)->first();
    if(empty($details)) {
      $details = new EmployeeInfoDetails();
      $details->employee_id = $request->id;
    }

    /* Job Information Container */
    $employee->account_id = $request->account_id;
    $employee->manager_id = $request->manager_id;
    if($manager = User::find($request->manager_id)) {
      $employee->manager_name = $manager->fullName();
    }
    $employee->supervisor_id = $request->supervisor_id;
    if($supervisor = User::find($request->supervisor_id)) {
      $employee->supervisor_name = $supervisor->fullName();
    }
    $employee->is_regular = $request->is_regular; // 0 - Probationary, 1 - Regular, 2 - Project Based
    $employee->employee_category = $request->employee_category; // 1 - Manager, 2 - Supervisor, 3 - Support, 4 - Rank
    $employee->hired_date = $request->hired_date;
    $employee->prod_date = $request->prod_date;
    $employee->regularization_date = $request->regularization_date;
    $employee->ext = $request->ext;
    $employee->wave = $request->wave;
    $details->resignation_date = $request->resignation_date;
    $details->rehirable = $request->rehirable; // 0 - No, 1 - Yes
    $details->rehire_reason = $request->rehire_reason;
    $employee->notes = $request->notes;
    /* End Job Information */

    /* Government Numbers Container */
    $employee->sss = $request->sss;
    $employee->pagibig = $request->pagibig;
    $employee->philhealth = $request->philhealth;
    $employee->tin = $request->tin;
    /* End Government Numbers Container */

    /* Login Credentials Container */
    $employee->email = $request->email;
    $employee->email2 = $request->email2;
    $employee->email3 = $request->email3;
    /* End Login Credentials Container */

    if($employee->save() && $details->save()) {
      self::saveLog($employee, 'job');

      /* Employee Category Changes */
      if($request->employee_category != $category && intval(date('j')) <= 15 && !empty($leave_credit)) {
        LeaveCredits::where('id', $leave_credit->id)->update(['credit' => $current_credit->credits]);
      }
      /* End Employee Category Changes */

      return back()->with('success', "Successfully updated Job information")->with('job', true);
    } else {
      return back()->with('error', "Oops, something went wrong. Please try again later.")->with('job', true);
    }
  }

  private static function saveLog($employee, $type = null)
  {
    $msg = 'Remove '.strtoupper($employee->first_name).' from Active Employees';
    $method = 'Delete';
    if($type == 'employee') {
      $msg = 'Updated '.strtoupper($employee->first_name).'\'s Information';
      $method = 'Update';
    } else if($type == 'job') {
      $msg = 'Updated '.strtoupper($employee->first_name).'\'s Job Information';
      $method = 'Update';
    } else if($type == 'reactivate') {
      $msg = 'Added '.strtoupper($employee->first_name).' to Active Employees';
      $method = 'Reactivate';
    } else if($type == 'add') {
      $msg = 'Added '.strtoupper($employee->first_name).' to HR Gateway';
      $method = 'Insert';
    }

    $log = new Log();
    $log->employee_id = Auth::user()->id;
    $log->module_id = $employee->id;
    $log->module = 'Employee';
    $log->method = $method;
    $log->message = $msg;
    $log->save();
  }
}
