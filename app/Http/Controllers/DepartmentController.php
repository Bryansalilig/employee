<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeDepartment;
use App\Models\ElinkDivision;
use App\Models\ElinkAccount;
use App\Models\User;
use App\Models\Log;

class DepartmentController extends Controller
{
    public function index()
    {
        $data['departments'] = EmployeeDepartment::all();
        $data['logs'] = Log::getLog('Department');

        return view('department.department', $data);
    }

    public function create()
    {
        $data['divisions'] = ElinkDivision::all();
        $data['accounts'] = ElinkAccount::all();
        $data['departments'] = EmployeeDepartment::all();

        return view('department.create', $data);
    }

    public function store(Request $request){
    
        $department = new EmployeeDepartment();
        $department->department_name = $request->department_name;
        $department->department_code = $request->department_code;
        $department->division_id = $request->division_id;
        $department->account_id = $request->account_id;
        
        $department->save();

        $log = new Log();
        $log->employee_id = Auth::user()->id;
        $log->module_id = $department->id;
        $log->module = 'Department';
        $log->method = 'Insert';
        $log->message = "Added new Department<br>Name: <b>{$request->department_name}</b>";
        $log->save();

        $first = substr(time(), 2);
        $second = substr(md5($department->id), -4);
        $third = substr(uniqid(), -4);
        $fourth = substr(rand(), -4);
        $fifth = generateRandomString();

        $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
        $department->slug = $slug;
        $department->save();

        return redirect('department')->with('success', "Successfully created department");
    }

    public function edit($slug)
    {
        $department = EmployeeDepartment::where('slug', $slug)->first();
        if(empty($department)) {
            return redirect(url('404'));
        }

        $data['department'] = $department;
        $data['divisions'] = ElinkDivision::all();
        $data['accounts'] = ElinkAccount::all();
        $data['departments'] = EmployeeDepartment::where('id', '<>', $department->id)->whereNull('deleted_at')->get();

        return view('department.edit', $data);
    }

    public function update(Request $request)
    {
        $department = EmployeeDepartment::find($request->id);
        $department->department_name = $request->department_name;
        $department->department_code = $request->department_code;
        $department->division_id = $request->division_id;
        $department->account_id = $request->account_id;
        $department->update();

        $log = new Log();
        $log->employee_id = Auth::user()->id;
        $log->module_id = $department->id;
        $log->module = 'Department';
        $log->method = 'Update';
        $log->message = "Updated {$request->department_name}'s Information";
        $log->save();

        return redirect('department')->with('success', "Successfully edited department");
    }
    
}
