<?php
/**
 * Controller for the Landing Page
 *
 * This controller handles the sliders and other data.
 *
 * @version 1.0
 * @since 2024-04-20
 *
 * Changes:
 * - 2024-03-20: File creation
 * - 2024-04-23:
 *    - Add Banner data
 */

// Declare the namespace for the controller
namespace App\Http\Controllers;

// Import necessary classes for the controller
use App\Models\Banner;
use App\Models\DAInfraction;
use App\Models\ElinkActivities;
use App\Models\EmployeeInfoDetails;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\Referral;
use App\Models\UndertimeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Controller class definition
class HomeController extends Controller
{
  /**
   * @var array
   */
  public static $data = [];

  /**
   * Constructor method to set up session data.
   *
   * This method initializes session variables for view and menu navigation
   * within the Board > Event module.
   */
  public function __construct()
  {
    // Set variables for view and menu navigation
    self::$data['menu'] = 'dashboard';
  }

  /**
   * Method to display data that can be viewed by all users.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    self::$data['submenu'] = 'home';
    self::$data['banners'] = Banner::where('status', '1')->get();
    self::$data['new_hires'] = User::allExceptSuperAdmin()->where('position_name', '<>', 'CEO')->orderBy('hired_date', 'DESC')->get();
    self::$data['birthdays'] = User::allExceptSuperAdmin()->whereRaw('MONTH(birth_date) = ?', date('n'))->whereNull('deleted_at')->where('status', '1')->orderByRaw('DAYOFMONTH(birth_date) ASC')->get();
    self::$data['today_birthdays'] = User::allExceptSuperAdmin()->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", date('m-d'))->whereNull('deleted_at')->where('status', '1')->get();
    self::$data['engagements'] = ElinkActivities::getActivities();

    return view('home', self::$data);
  }

  /**
   * Method to display data and statistics that can be viewed by administrators.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function dashboard(Request $request)
  {
    self::$data['submenu'] = 'dashboard';
    self::getWidget();
    self::getNewHires();
    self::getAttritionChart();
// echo '<pre>';
// print_r(self::$data);
// return;
    return view('dashboard', self::$data);
  }

  public function newhires(Request $request)
  {
    $users = User::allExceptSuperAdmin()->orderBy('prod_date', 'DESC')->paginate(5);
    foreach($users as $user) {
      $user->fullname = $user->fullname();
      $user->prod_date = customDate($user->prod_date, 'M d, Y');
    }

    return $users;
  }

  public function getFormattedDate(Request $request)
  {
    return customDate($request->date, $request->string);
  }

  private function getWidget()
  {
    $current = date('Y-n');
    $previous = date('Y-n', strtotime('last month'));

    self::$data['new_hires'] = User::allExceptSuperAdmin()->whereNull('deleted_at')->where('status', 1)->whereRaw("DATE_FORMAT(prod_date, '%Y-%c') = ?", $current)->count();
    self::$data['old_hires'] = User::allExceptSuperAdmin()->whereNull('deleted_at')->where('status', 1)->whereRaw("DATE_FORMAT(prod_date, '%Y-%c') = ?", $previous)->count();
    self::$data['new_leave'] = LeaveRequest::whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $current)->count();
    self::$data['old_leave'] = LeaveRequest::whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $previous)->count();
    self::$data['new_overtime'] = OvertimeRequest::withTrashed()->whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $current)->count();
    self::$data['old_overtime'] = OvertimeRequest::withTrashed()->whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $previous)->count();
    self::$data['new_undertime'] = UndertimeRequest::withTrashed()->whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $current)->count();
    self::$data['old_undertime'] = UndertimeRequest::withTrashed()->whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $previous)->count();
    self::$data['new_attrition'] = EmployeeInfoDetails::whereRaw("DATE_FORMAT(resignation_date, '%Y-%c') = ?", $current)->count();
    self::$data['old_attrition'] = EmployeeInfoDetails::whereRaw("DATE_FORMAT(resignation_date, '%Y-%c') = ?", $previous)->count();
    self::$data['new_infraction'] = DAInfraction::withTrashed()->whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $current)->count();
    self::$data['old_infraction'] = DAInfraction::withTrashed()->whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $previous)->count();
    self::$data['new_referral'] = Referral::whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $current)->count();
    self::$data['old_referral'] = Referral::whereRaw("DATE_FORMAT(created_at, '%Y-%c') = ?", $previous)->count();

    return self::$data;
  }

  private function getNewHires()
  {
    $current = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0];
    $users = User::whereRaw("YEAR(prod_date) = ?", date('Y'))->get();
    foreach ($users as $user) {
      $current[date('n', strtotime($user->prod_date))] += 1;
    }

    $previous = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0];
    $users = User::whereRaw("YEAR(prod_date) = ?", date('Y') - 1)->get();
    foreach ($users as $user) {
      $previous[date('n', strtotime($user->prod_date))] += 1;
    }

    self::$data['hires']['current'] = json_encode(array_values($current));
    self::$data['hires']['previous'] = json_encode(array_values($previous));

    return self::$data;
  }

  private function getAttritionChart()
  {
    $current = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0];
    $details = EmployeeInfoDetails::whereRaw("YEAR(resignation_date) = ?", date('Y'))->get();
    foreach ($details as $detail) {
      $current[date('n', strtotime($detail->resignation_date))] += 1;
    }

    $previous = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0];
    $details = EmployeeInfoDetails::whereRaw("YEAR(resignation_date) = ?", date('Y') - 1)->get();
    foreach ($details as $detail) {
      $previous[date('n', strtotime($detail->resignation_date))] += 1;
    }

    self::$data['attrition']['current'] = json_encode(array_values($current));
    self::$data['attrition']['previous'] = json_encode(array_values($previous));

    return self::$data;
  }
} 
