<?php

use App\Http\Controllers\AttachController;
use App\Http\Controllers\Board\ActivityController;
use App\Http\Controllers\Board\BannerController;
use App\Http\Controllers\Board\EventsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EmailReminderController;
use App\Http\Controllers\EmailRemindersController;
use App\Http\Controllers\EmployeeInfoController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LinkingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PaginationController;
use App\Http\Controllers\ReferralController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // Check if user is logged in
    if(Auth::check()) {
        // if user is admin redirect to dashboard
        if(Auth::user()->isAdmin()) {
            return redirect('/dashboard');
        } else {
            return redirect('/home');
        }
    } else {
        return redirect('/home');
    }
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


/*
 *
 * Normal User Routes
 */
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('company-policy', [CompanyController::class, 'index'])->name('company-policy');


Route::middleware(['guest'])->group(function () {
  Route::controller(LoginController::class)->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('signin');
  });
});

/*
 *
 * Normal User / JSON Results
 */
Route::controller(ActivityController::class)->prefix('board')->group(function () {
  Route::get('activities', 'index')->name('activities');
  Route::get('activity-create', 'create')->name('activity.create');
  Route::get('activity-edit/{slug}', 'edit')->name('activity.edit');
  Route::get('activity-destroy', 'destroy')->name('activity.destroy');
  Route::post('activity-add', 'store')->name('activity.store');
  Route::put('activity/{id}', 'update')->name('activity.update');
});

Route::controller(EventsController::class)->prefix('board')->group(function () {
  Route::get('events', 'index')->name('events');
  Route::get('events/calendar', 'calendar')->name('events.calendar');
  Route::get('event/add', 'create')->name('event.create');
  Route::get('event/edit/{slug}', 'edit')->name('event.edit');
  Route::get('event/destroy', 'destroy')->name('event.destroy');
  Route::post('event-add', 'store')->name('event.store');
  Route::put('event/{id}', 'update')->name('event.update');
});

Route::controller(BannerController::class)->prefix('board')->group(function () {
  Route::get('banner', 'index')->name('banner');
  Route::get('banner/calendar', 'calendar')->name('banner.calendar');
  Route::get('banner/add', 'create')->name('banner.create');
  Route::get('banner/edit/{slug}', 'edit')->name('banner.edit');
  Route::get('banner/{id}/enabled', 'enabled')->name('banner.enabled');
  Route::get('banner/destroy', 'destroy')->name('banner.destroy');
  Route::post('banner-add', 'store')->name('banner.store');
  Route::put('banner/{id}', 'update')->name('banner.update');
});


Route::controller(EvaluationController::class)->group(function () {
  Route::get('evaluation', 'evaluation')->name('evaluation.evaluation');
  Route::get('evaluation/create', 'create')->name('evaluation.create');
  Route::post('evaluation/update', 'update')->name('evaluation.update');
  Route::get('evaluation/{id}', 'show')->name('evaluation.show');
  Route::post('evaluation', 'store')->name('evaluation.store');
  Route::get('team-evaluation', 'team')->name('team-evaluation');
  Route::get('excel-evaluation/{id}', 'excel')->name('excel-evaluation');
  Route::get('pdf-evaluation/{id}', 'pdf')->name('pdf-evaluation');
});

Route::controller(DevelopmentController::class)->group(function () {
  Route::get('development', 'index')->name('development.development');
  Route::get('team-development', 'team')->name('team-development');
  Route::get('personal-development', 'personal')->name('personal-development');
  Route::get('/development/create', 'create')->name('development.create');
  Route::post('development', 'store')->name('development');
  Route::post('development/draft', 'draft')->name('development/draft');
  Route::get('development/{id}', 'show')->name('development/show');
  Route::get('development/{id}/edit', 'edit')->name('development/edit');
  Route::post('development/update-draft', 'updateDraft')->name('development/update-draft');
  Route::post('development/submit-draft', 'submitDraft')->name('development/submit-draft');
  Route::get('history-development', 'history')->name('history-development');
  Route::post('development/update', 'update')->name('development/update');
  Route::get('personal-development', 'personal')->name('personal-development');
  Route::get('upcoming-development', 'upcoming')->name('upcoming-development');

});

Route::controller(DepartmentController::class)->group(function (){
  Route::get('department', 'index')->name('department.department');
  Route::get('department/create', 'create')->name('department/create');
  Route::post('department/store', 'store')->name('department.store');
  Route::get('department/{id}/edit', 'edit')->name('department/edit');
  Route::post('department/update', 'update')->name('department/update');
});


Route::controller(ReferralController::class)->group(function (){
  Route::get('referral', 'index')->name('referral.referral');
  Route::get('referral/create', 'create')->name('referral/create');
  Route::post('referral/store', 'store')->name('referral.store');
  Route::get('referral/{id}', 'show')->name('referral/show');
  Route::get('/download/{filename}', 'download')->name('download');
});

Route::controller(OvertimeController::class)->group(function (){
  Route::get('overtime', 'index')->name('overtime');
  Route::get('overtime/create', 'create')->name('overtime/create');
  Route::get('team-overtime', 'team')->name('team-overtime');
  Route::get('overtime/{slug}', 'show')->name('overtime/show');
  Route::post('overtime/approve', 'approve')->name('overime.approve');
  Route::post('overtime/recommend', 'recommend')->name('overtime/recommend');
  Route::post('overtime/verification', 'verification')->name('overtime/verification');
  Route::post('overtime/store', 'store')->name('overtime.store');
  Route::post('overtime/updateUnread', 'updateUnread')->name('overtime.updateUnread');
  Route::get('overtime/update', 'OvertimeController@updateNo')->name('overtime.update');

});

Route::get('newhires', [HomeController::class, 'newhires'])->name('newhires');
Route::get('get-formatted-date', [HomeController::class, 'getFormattedDate'])->name('get-formatted-date');

// Route::resource('leave', LeaveController::class);

Route::controller(LeaveController::class)->group(function () {
  Route::get('leave', 'index')->name('leave');
  // Route::get('employees-card', 'card')->name('employees.card');
  // Route::get('separated-employees', 'separated')->name('employees.separated');
  Route::get('leave-info/{slug}', 'show')->name('leave.show');
  Route::get('leave/create', 'create')->name('leave.create');
  Route::get('leave-edit/{slug}', 'edit')->name('leave.edit');
  // Route::get('employee-view', 'view')->name('employee.view');
  Route::post('leave-add', 'store')->name('leave.store');
  Route::post('leave-recommend', 'recommend')->name('leave.recommend');
  Route::post('leave-approve', 'approve')->name('leave.approve');
  // Route::post('employee-reactivate', 'reactivate')->name('employee.reactivate');
  // Route::post('employee-deactivate', 'deactivate')->name('employee.deactivate');
});


Route::controller(AttachController::class)->group(function () {
  Route::get('/attach/download/{key}/{id}', 'download')->name('attach.download');
  Route::post('/attach/add', 'add')->name('attach.add');
  Route::post('/attach/remove', 'remove')->name('attach.remove');
});

Route::controller(EmployeeInfoController::class)->group(function () {
  Route::get('employees', 'employees')->name('employees.employees');
  Route::get('employees-card', 'card')->name('employees.card');
  Route::get('separated-employees', 'separated')->name('employees.separated');
  Route::get('employee-info/{slug}', 'show')->name('employee.show');
  Route::get('employee-create', 'create')->name('employee.create');
  Route::get('employee-duplicate', 'duplicate')->name('employee.duplicate');
  Route::get('employee-view', 'view')->name('employee.view');
  Route::post('employee-add', 'store')->name('employee.store');
  Route::post('employee-update', 'update')->name('employee.update');
  Route::post('employee-upload', 'upload')->name('employee.upload');
  Route::post('employee-reactivate', 'reactivate')->name('employee.reactivate');
  Route::post('employee-deactivate', 'deactivate')->name('employee.deactivate');
});

Route::controller(MovementController::class)->group(function () {
  Route::post('save-movement', 'store')->name('movement.store');
});

Route::controller(LinkingController::class)->group(function () {
  Route::post('save-linking', 'store')->name('linking.store');
  Route::post('delete-linking', 'delete')->name('linking.delete');
});

Route::controller(LogController::class)->group(function () {
  Route::get('load-logs', 'load')->name('log.load');
});

Route::middleware(['auth'])->group(function () {

  Route::get('stop-reminder/{id}', [EmailRemindersController::class, 'stopReminder']);
});

Route::controller(InboxController::class)->prefix('inbox')->group(function () {
  Route::get('overtime_notification', 'index')->name('overtime_notification');
});
