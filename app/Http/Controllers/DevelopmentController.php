<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Development;
use App\Models\DevelopmentUpcoming;
use App\Models\User;

class DevelopmentController extends Controller
{

    private static function getDetails($user)
    {
        $supervisor = User::find($user->supervisor_id);
        $manager = User::find($user->manager_id);
        $superior_name = '---';
        $superior = 'HR DEPARTMENT';

        if(!empty($manager)) {
            $superior_name = $manager->last_name.', '.$manager->first_name;
            $superior = $manager->first_name;
        }
        if(!empty($supervisor)) {
            $superior_name = $supervisor->last_name.', '.$supervisor->first_name;
            $superior = $supervisor->first_name;
        }

        $user->superior_name = $superior_name;
        $user->superior = $superior;

        $tenure = '';
        $year_string = '';
        $date1 = date('Y-m-d H:i:s', strtotime($user->hired_date. '-20 days'));
        $date2 = date('Y-m-d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

        if($years > 0) {
            $description = ($years > 1) ? 'Years' : 'Year';

            $year_string = $years.' '.$description;
            $tenure .= $years.' '.$description;
        }

        if($months > 0) {
            $description = ($months > 1) ? 'Months' : 'Month';
            $tenure .= '';
        }

        $user->tenure = $tenure;
        $user->year_string = $year_string;

        return $user;
    }

    public function getEmployees()
    {
        $users = User::whereNull('deleted_at')->where('status', '<>', 2)->where('id', '<>', 1)->orderBy('last_name')->get();

        foreach($users as $user) {
            $this->getDetails($user);
        }

        return $users;
    }

    public function index(Request $request)
    {
        app('App\Http\Controllers\EmailRemindersController')->reminderDevelopment2();

        if(!Auth::user()->isAdmin() && Auth::user()->team_name != 'Organizational Development') {
            return redirect(url('team-development'));
        }

        $data['items'] = Development::getDevelopment();
        $data['is_leader'] = count(DevelopmentUpcoming::getUpcoming(Auth::user()->id));

        return view('development.development', $data);
    }

    public function team(Request $request)
    {
        $is_leader = $this->isLeader(Auth::user()->id);

        if(!$is_leader) {
            return redirect(url('personal-development'));
        }

        $data['items'] = DevelopmentUpcoming::getUpcoming(Auth::user()->id);

        return view('development.team', $data);
    }

    public function isLeader($id)
    {
        $subordinates = DB::select("SELECT id, first_name, last_name, email, position_name, team_name FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})");

        $employees = [];
        foreach($subordinates as $emp) {
            $arr['id'] = $emp->id;
            $arr['first_name'] = $emp->first_name;
            $arr['last_name'] = $emp->last_name;
            $arr['email'] = $emp->email;
            $arr['position_name'] = $emp->position_name;
            $arr['team_name'] = $emp->team_name;

            $employees[$emp->id] = (object) $arr;
        }

        return $employees;
    }

    public function create(Request $request)
    {
        
        $slug = $_GET['record'];
        $employee = User::where('slug', $slug)->first();

        if(!Auth::user()->isAdmin() && $employee->supervisor_id != Auth::user()->id){
            if((Auth::user()->usertype == 1 && $employee->id == Auth::user()->id) || (Auth::user()->usertype == 3)){
            } else {
                return redirect('404');
            }
            
        }

        $data['employees'] = $this->getEmployees();
        $data['record'] = !empty($request->record) ? $request->record : '';

        return view('development.create', $data);
    }

    public function edit($id)
    {
        $item = Development::where('slug', $id)->first();
        $employee = User::where('id', $item->employee_id)->first();

        if(!Auth::user()->isAdmin() && $employee->supervisor_id != Auth::user()->id){
            if((Auth::user()->usertype == 1 && $employee->id == Auth::user()->id) || (Auth::user()->usertype == 3)){
            }else {
                return redirect('404');
            }
            
        }
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        $employee = User::withTrashed()->find($item->employee_id);

        $data['item'] = $this->distribute($item);
        $data['employee'] = $this->getDetails($employee);

        return view('development.edit', $data);
    }

    public function store(Request $request) {
        $employee = User::find($request->employee_id);

        if(empty($employee)) {
            redirect('/404');
            exit;
        }

        $from = date('Y-').date('m-d', strtotime($employee->hired_date. '-20 days'));
        $to = date('Y-').date('m-d', strtotime($employee->hired_date));
        $item = Development::where('employee_id', $employee->id)->whereRaw("NOW() BETWEEN '{$from}' AND '{$to}'")->first();

        if(!empty($item)) {
            $message = 'A Yearly Development Form is already submitted for this employee';
            if($item->draft) { $message = 'A Draft - Yearly Development Form is already created for this employee'; }

            return back()->with('error', $message);
        }

        $courtesy['score'] = $request['courtesy-score'];
        $courtesy['remark'] = $request['courtesy-remark'];
        $courtesy['recommendation'] = $request['courtesy-recommendation'];

        $ownership['score'] = $request['ownership-score'];
        $ownership['remark'] = $request['ownership-remark'];
        $ownership['recommendation'] = $request['ownership-recommendation'];

        $nurture['score'] = $request['nurture-score'];
        $nurture['remark'] = $request['nurture-remark'];
        $nurture['recommendation'] = $request['nurture-recommendation'];

        $collaboration['score'] = $request['collaboration-score'];
        $collaboration['remark'] = $request['collaboration-remark'];
        $collaboration['recommendation'] = $request['collaboration-recommendation'];

        $integrity['score'] = $request['integrity-score'];
        $integrity['remark'] = $request['integrity-remark'];
        $integrity['recommendation'] = $request['integrity-recommendation'];

        $seamlessness['score'] = $request['seamlessness-score'];
        $seamlessness['remark'] = $request['seamlessness-remark'];
        $seamlessness['recommendation'] = $request['seamlessness-recommendation'];

        $excellence['score'] = $request['excellence-score'];
        $excellence['remark'] = $request['excellence-remark'];
        $excellence['recommendation'] = $request['excellence-recommendation'];

        $emotional_intelligence['score'] = $request['emotional_intelligence-score'];
        $emotional_intelligence['remark'] = $request['emotional_intelligence-remark'];
        $emotional_intelligence['recommendation'] = $request['emotional_intelligence-recommendation'];

        $balance['score'] = $request['balance-score'];
        $balance['remark'] = $request['balance-remark'];
        $balance['recommendation'] = $request['balance-recommendation'];

        $brilliance['score'] = $request['brilliance-score'];
        $brilliance['remark'] = $request['brilliance-remark'];
        $brilliance['recommendation'] = $request['brilliance-recommendation'];

        $others = [];
        if(!empty($request['others-role'])) {
            $i = 0;
            foreach($request['others-role'] as $key => $role) {
                $others[$i]['role'] = $role;
                $others[$i]['description'] = $request['others-description'][$key];
                $others[$i]['score'] = $request['others-score'][$key];
                $others[$i]['remark'] = $request['others-remark'][$key];
                $others[$i]['recommendation'] = $request['others-recommendation'][$key];
                $i++;
            }
        }

        $goal = [];
        $goal['previous'] = $request['previous'];
        $goal['new'] = $request['new'];

        $result = [];
        $result['score'] = $request['result-score'];
        $result['talent'] = $request['result-talent'];
        $result['recommendation'] = $request['result-recommendation'];

        $development = new Development();
        $development->employee_id = $employee->id;
        $development->superior_id = Auth::user()->id;
        $development->courtesy = json_encode($courtesy);
        $development->ownership = json_encode($ownership);
        $development->nurture = json_encode($nurture);
        $development->collaboration = json_encode($collaboration);
        $development->integrity = json_encode($integrity);
        $development->seamlessness = json_encode($seamlessness);
        $development->excellence = json_encode($excellence);
        $development->emotional_intelligence = json_encode($emotional_intelligence);
        $development->balance = json_encode($balance);
        $development->brilliance = json_encode($brilliance);
        $development->others = json_encode($others);
        $development->goal = json_encode($goal);
        $development->result = json_encode($result);

        if($development->save()) {
            $first = substr(time(), 2);
            $second = substr(md5($development->id), -4);
            $third = substr(uniqid(), -4);
            $fourth = substr(rand(), -4);
            $fifth = generateRandomString();

            $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
            $development->slug = $slug;
            $development->save();

            $upcoming = DevelopmentUpcoming::where('employee_id', $employee->id)->first();
            if(!empty($upcoming)) {
                $upcoming->delete();
            }

            $emp = $this->getDetails($employee);

            $data['user'] = $emp->first_name;
            $data['tenure'] = strtolower($emp->year_string);
            $data['url'] = url("development/{$slug}");

            // SentEmailArchives::where('employee_id', $request->employee_id)->whereRaw("mail_type LIKE '%YEARLY_DEV%'")->update(['status' => 1]);

            // Mail::to($employee->email)->send(new DevelopmentSubmitted($data));

            return redirect($data['url'])->with('success', "Yearly Development Successfully Submitted!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function draft(Request $request) {
        $employee = User::find($request->employee_id);
        if(empty($employee)) {
            redirect('/404');
            exit;
        }

        $from = date('Y-').date('m-d', strtotime($employee->hired_date. '-20 days'));
        $to = date('Y-').date('m-d', strtotime($employee->hired_date));
        $item = Development::where('employee_id', $employee->id)->whereRaw("NOW() BETWEEN '{$from}' AND '{$to}'")->first();

        if(!empty($item)) {
            $message = 'A Yearly Development Form is already submitted for this employee';
            if($item->draft) { $message = 'A Draft - Yearly Development Form is already created for this employee'; }

            return back()->with('error', $message);
        }

        $courtesy['score'] = $request['courtesy-score'];
        $courtesy['remark'] = $request['courtesy-remark'];
        $courtesy['recommendation'] = $request['courtesy-recommendation'];

        $ownership['score'] = $request['ownership-score'];
        $ownership['remark'] = $request['ownership-remark'];
        $ownership['recommendation'] = $request['ownership-recommendation'];

        $nurture['score'] = $request['nurture-score'];
        $nurture['remark'] = $request['nurture-remark'];
        $nurture['recommendation'] = $request['nurture-recommendation'];

        $collaboration['score'] = $request['collaboration-score'];
        $collaboration['remark'] = $request['collaboration-remark'];
        $collaboration['recommendation'] = $request['collaboration-recommendation'];

        $integrity['score'] = $request['integrity-score'];
        $integrity['remark'] = $request['integrity-remark'];
        $integrity['recommendation'] = $request['integrity-recommendation'];

        $seamlessness['score'] = $request['seamlessness-score'];
        $seamlessness['remark'] = $request['seamlessness-remark'];
        $seamlessness['recommendation'] = $request['seamlessness-recommendation'];

        $excellence['score'] = $request['excellence-score'];
        $excellence['remark'] = $request['excellence-remark'];
        $excellence['recommendation'] = $request['excellence-recommendation'];

        $emotional_intelligence['score'] = $request['emotional_intelligence-score'];
        $emotional_intelligence['remark'] = $request['emotional_intelligence-remark'];
        $emotional_intelligence['recommendation'] = $request['emotional_intelligence-recommendation'];

        $balance['score'] = $request['balance-score'];
        $balance['remark'] = $request['balance-remark'];
        $balance['recommendation'] = $request['balance-recommendation'];

        $brilliance['score'] = $request['brilliance-score'];
        $brilliance['remark'] = $request['brilliance-remark'];
        $brilliance['recommendation'] = $request['brilliance-recommendation'];

        $others = [];
        if(!empty($request['others-role'])) {
            $i = 0;
            foreach($request['others-role'] as $key => $role) {
                $others[$i]['role'] = $role;
                $others[$i]['description'] = $request['others-description'][$key];
                $others[$i]['score'] = $request['others-score'][$key];
                $others[$i]['remark'] = $request['others-remark'][$key];
                $others[$i]['recommendation'] = $request['others-recommendation'][$key];
                $i++;
            }
        }

        $goal = [];
        $goal['previous'] = $request['previous'];
        $goal['new'] = $request['new'];

        $result = [];
        $result['score'] = $request['result-score'];
        $result['talent'] = $request['result-talent'];
        $result['recommendation'] = $request['result-recommendation'];

        $development = new Development();
        $development->employee_id = $employee->id;
        $development->superior_id = Auth::user()->id;
        $development->courtesy = json_encode($courtesy);
        $development->ownership = json_encode($ownership);
        $development->nurture = json_encode($nurture);
        $development->collaboration = json_encode($collaboration);
        $development->integrity = json_encode($integrity);
        $development->seamlessness = json_encode($seamlessness);
        $development->excellence = json_encode($excellence);
        $development->emotional_intelligence = json_encode($emotional_intelligence);
        $development->balance = json_encode($balance);
        $development->brilliance = json_encode($brilliance);
        $development->others = json_encode($others);
        $development->goal = json_encode($goal);
        $development->result = json_encode($result);
        $development->draft = 1;

        if($development->save()) {
            $first = substr(time(), 2);
            $second = substr(md5($development->id), -4);
            $third = substr(uniqid(), -4);
            $fourth = substr(rand(), -4);
            $fifth = generateRandomString();

            $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
            $development->slug = $slug;
            $development->save();

            $upcoming = DevelopmentUpcoming::where('employee_id', $employee->id)->first();
            if(!empty($upcoming)) {
                $upcoming->status = 1;
                $upcoming->save();
            }

            $data['url'] = url("development/{$slug}");

            return redirect($data['url'])->with('success', "Draft - Yearly Development Successfully Created!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function show($id)
    {
        $item = Development::where('slug', $id)->first();
        $employee = User::where('id', $item->employee_id)->first();
        
        if(!Auth::user()->isAdmin() && $employee->supervisor_id != Auth::user()->id){
            if((Auth::user()->usertype == 1 && $employee->id == Auth::user()->id) || (Auth::user()->team_name == 'Organizational Development') || (Auth::user()->usertype == 3)){
            }else {
                return redirect('404');
            }
            
        }
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        if($item->employee_id == Auth::user()->id) {
            $item->read = 1;
            $item->save();
        }

        $employee = User::withTrashed()->find($item->employee_id);

        $data['item'] = $this->distribute($item);
        $data['employee'] = $this->getDetails($employee);

        return view('development.show', $data);
    }

    private static function itemDecode($item)
    {
        $data = $item;
        if(!is_object($item)) {
            $data = json_decode($item);
        }

        $talent = '';
        $cls_talent = '';
        switch($data->score) {
            case 1:
                $talent = 'Core';
                $cls_talent = 'bg-core';
                break;
            case 3:
                $talent = 'Growth';
                $cls_talent = 'bg-growth';
                break;
            case 5:
                $talent = 'High Talent';
                $cls_talent = 'bg-high';
                break;
            default:
                $talent = 'To Develop';
                $cls_talent = 'bg-develop';
                break;
        }

        $data->talent = $talent;
        $data->cls_talent = $cls_talent;

        return $data;
    }

    public function distribute($item)
    {
        $item->courtesy = $this->itemDecode($item->courtesy);
        $item->ownership = $this->itemDecode($item->ownership);
        $item->nurture = $this->itemDecode($item->nurture);
        $item->collaboration = $this->itemDecode($item->collaboration);
        $item->integrity = $this->itemDecode($item->integrity);
        $item->seamlessness = $this->itemDecode($item->seamlessness);
        $item->excellence = $this->itemDecode($item->excellence);
        $item->emotional_intelligence = $this->itemDecode($item->emotional_intelligence);
        $item->balance = $this->itemDecode($item->balance);
        $item->brilliance = $this->itemDecode($item->brilliance);
        $item->goal = json_decode($item->goal);
        $item->result = json_decode($item->result);

        $others = json_decode($item->others);
        if(!empty($others)) {
            foreach($others as $other) {
                $this->itemDecode($other);
            }
        }

        $item->others = $others;
        $item->count = count($others);

        return $item;
    }

    public function updateDraft(Request $request)
    {
        $item = Development::find($request->employee_id);
        if(empty($item)) {
            redirect('/404');
            exit;
        }

        $courtesy['score'] = $request['courtesy-score'];
        $courtesy['remark'] = $request['courtesy-remark'];
        $courtesy['recommendation'] = $request['courtesy-recommendation'];

        $ownership['score'] = $request['ownership-score'];
        $ownership['remark'] = $request['ownership-remark'];
        $ownership['recommendation'] = $request['ownership-recommendation'];

        $nurture['score'] = $request['nurture-score'];
        $nurture['remark'] = $request['nurture-remark'];
        $nurture['recommendation'] = $request['nurture-recommendation'];

        $collaboration['score'] = $request['collaboration-score'];
        $collaboration['remark'] = $request['collaboration-remark'];
        $collaboration['recommendation'] = $request['collaboration-recommendation'];

        $integrity['score'] = $request['integrity-score'];
        $integrity['remark'] = $request['integrity-remark'];
        $integrity['recommendation'] = $request['integrity-recommendation'];

        $seamlessness['score'] = $request['seamlessness-score'];
        $seamlessness['remark'] = $request['seamlessness-remark'];
        $seamlessness['recommendation'] = $request['seamlessness-recommendation'];

        $excellence['score'] = $request['excellence-score'];
        $excellence['remark'] = $request['excellence-remark'];
        $excellence['recommendation'] = $request['excellence-recommendation'];

        $emotional_intelligence['score'] = $request['emotional_intelligence-score'];
        $emotional_intelligence['remark'] = $request['emotional_intelligence-remark'];
        $emotional_intelligence['recommendation'] = $request['emotional_intelligence-recommendation'];

        $balance['score'] = $request['balance-score'];
        $balance['remark'] = $request['balance-remark'];
        $balance['recommendation'] = $request['balance-recommendation'];

        $brilliance['score'] = $request['brilliance-score'];
        $brilliance['remark'] = $request['brilliance-remark'];
        $brilliance['recommendation'] = $request['brilliance-recommendation'];

        $others = [];
        if(!empty($request['others-role'])) {
            $i = 0;
            foreach($request['others-role'] as $key => $role) {
                $others[$i]['role'] = $role;
                $others[$i]['description'] = $request['others-description'][$key];
                $others[$i]['score'] = $request['others-score'][$key];
                $others[$i]['remark'] = $request['others-remark'][$key];
                $others[$i]['recommendation'] = $request['others-recommendation'][$key];
                $i++;
            }
        }

        $goal = [];
        $goal['previous'] = $request['previous'];
        $goal['new'] = $request['new'];

        $result = [];
        $result['score'] = $request['result-score'];
        $result['talent'] = $request['result-talent'];
        $result['recommendation'] = $request['result-recommendation'];

        $item->courtesy = json_encode($courtesy);
        $item->ownership = json_encode($ownership);
        $item->nurture = json_encode($nurture);
        $item->collaboration = json_encode($collaboration);
        $item->integrity = json_encode($integrity);
        $item->seamlessness = json_encode($seamlessness);
        $item->excellence = json_encode($excellence);
        $item->emotional_intelligence = json_encode($emotional_intelligence);
        $item->balance = json_encode($balance);
        $item->brilliance = json_encode($brilliance);
        $item->others = json_encode($others);
        $item->goal = json_encode($goal);
        $item->result = json_encode($result);

        if($item->save()) {
            return back()->with('success', 'Draft - Successfully Updated!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function submitDraft(Request $request)
    {
        $item = Development::find($request->employee_id);
        if(empty($item)) {
            redirect('/404');
            exit;
        }

        $courtesy['score'] = $request['courtesy-score'];
        $courtesy['remark'] = $request['courtesy-remark'];
        $courtesy['recommendation'] = $request['courtesy-recommendation'];

        $ownership['score'] = $request['ownership-score'];
        $ownership['remark'] = $request['ownership-remark'];
        $ownership['recommendation'] = $request['ownership-recommendation'];

        $nurture['score'] = $request['nurture-score'];
        $nurture['remark'] = $request['nurture-remark'];
        $nurture['recommendation'] = $request['nurture-recommendation'];

        $collaboration['score'] = $request['collaboration-score'];
        $collaboration['remark'] = $request['collaboration-remark'];
        $collaboration['recommendation'] = $request['collaboration-recommendation'];

        $integrity['score'] = $request['integrity-score'];
        $integrity['remark'] = $request['integrity-remark'];
        $integrity['recommendation'] = $request['integrity-recommendation'];

        $seamlessness['score'] = $request['seamlessness-score'];
        $seamlessness['remark'] = $request['seamlessness-remark'];
        $seamlessness['recommendation'] = $request['seamlessness-recommendation'];

        $excellence['score'] = $request['excellence-score'];
        $excellence['remark'] = $request['excellence-remark'];
        $excellence['recommendation'] = $request['excellence-recommendation'];

        $emotional_intelligence['score'] = $request['emotional_intelligence-score'];
        $emotional_intelligence['remark'] = $request['emotional_intelligence-remark'];
        $emotional_intelligence['recommendation'] = $request['emotional_intelligence-recommendation'];

        $balance['score'] = $request['balance-score'];
        $balance['remark'] = $request['balance-remark'];
        $balance['recommendation'] = $request['balance-recommendation'];

        $brilliance['score'] = $request['brilliance-score'];
        $brilliance['remark'] = $request['brilliance-remark'];
        $brilliance['recommendation'] = $request['brilliance-recommendation'];

        $others = [];
        if(!empty($request['others-role'])) {
            $i = 0;
            foreach($request['others-role'] as $key => $role) {
                $others[$i]['role'] = $role;
                $others[$i]['description'] = $request['others-description'][$key];
                $others[$i]['score'] = $request['others-score'][$key];
                $others[$i]['remark'] = $request['others-remark'][$key];
                $others[$i]['recommendation'] = $request['others-recommendation'][$key];
                $i++;
            }
        }

        $goal = [];
        $goal['previous'] = $request['previous'];
        $goal['new'] = $request['new'];

        $result = [];
        $result['score'] = $request['result-score'];
        $result['talent'] = $request['result-talent'];
        $result['recommendation'] = $request['result-recommendation'];

        $item->courtesy = json_encode($courtesy);
        $item->ownership = json_encode($ownership);
        $item->nurture = json_encode($nurture);
        $item->collaboration = json_encode($collaboration);
        $item->integrity = json_encode($integrity);
        $item->seamlessness = json_encode($seamlessness);
        $item->excellence = json_encode($excellence);
        $item->emotional_intelligence = json_encode($emotional_intelligence);
        $item->balance = json_encode($balance);
        $item->brilliance = json_encode($brilliance);
        $item->others = json_encode($others);
        $item->goal = json_encode($goal);
        $item->result = json_encode($result);
        $item->draft = 0;

        if($item->save()) {
            $employee = User::withTrashed()->find($item->employee_id);
            $emp = $this->getDetails($employee);

            $data['user'] = $emp->first_name;
            $data['tenure'] = strtolower($emp->year_string);
            $data['url'] = url("development/{$item->slug}");

            $upcoming = DevelopmentUpcoming::where('employee_id', $item->employee_id)->first();
            if(!empty($upcoming)) {
                $upcoming->delete();
            }

            // SentEmailArchives::where('employee_id', $item->employee_id)->whereRaw("mail_type LIKE '%YEARLY_DEV%'")->update(['status' => 1]);

            // Mail::to($employee->email)->send(new DevelopmentSubmitted($data));

            return redirect($data['url'])->with('success', "Yearly Development Successfully Submitted!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function history(Request $request)
    {
        $id = Auth::user()->id;

        $data['items'] = Development::getDevelopment("(supervisor_id={$id} OR manager_id={$id})");
        return view('development.history', $data);
    }

    public function update(Request $request)
    {
        $item = Development::find($request->employee_id);
        if(empty($item)) {
            redirect('/404');
            exit;
        }

        $courtesy['score'] = $request['courtesy-score'];
        $courtesy['remark'] = $request['courtesy-remark'];
        $courtesy['recommendation'] = $request['courtesy-recommendation'];

        $ownership['score'] = $request['ownership-score'];
        $ownership['remark'] = $request['ownership-remark'];
        $ownership['recommendation'] = $request['ownership-recommendation'];

        $nurture['score'] = $request['nurture-score'];
        $nurture['remark'] = $request['nurture-remark'];
        $nurture['recommendation'] = $request['nurture-recommendation'];

        $collaboration['score'] = $request['collaboration-score'];
        $collaboration['remark'] = $request['collaboration-remark'];
        $collaboration['recommendation'] = $request['collaboration-recommendation'];

        $integrity['score'] = $request['integrity-score'];
        $integrity['remark'] = $request['integrity-remark'];
        $integrity['recommendation'] = $request['integrity-recommendation'];

        $seamlessness['score'] = $request['seamlessness-score'];
        $seamlessness['remark'] = $request['seamlessness-remark'];
        $seamlessness['recommendation'] = $request['seamlessness-recommendation'];

        $excellence['score'] = $request['excellence-score'];
        $excellence['remark'] = $request['excellence-remark'];
        $excellence['recommendation'] = $request['excellence-recommendation'];

        $emotional_intelligence['score'] = $request['emotional_intelligence-score'];
        $emotional_intelligence['remark'] = $request['emotional_intelligence-remark'];
        $emotional_intelligence['recommendation'] = $request['emotional_intelligence-recommendation'];

        $balance['score'] = $request['balance-score'];
        $balance['remark'] = $request['balance-remark'];
        $balance['recommendation'] = $request['balance-recommendation'];

        $brilliance['score'] = $request['brilliance-score'];
        $brilliance['remark'] = $request['brilliance-remark'];
        $brilliance['recommendation'] = $request['brilliance-recommendation'];

        $others = [];
        if(!empty($request['others-role'])) {
            $i = 0;
            foreach($request['others-role'] as $key => $role) {
                $others[$i]['role'] = $role;
                $others[$i]['description'] = $request['others-description'][$key];
                $others[$i]['score'] = $request['others-score'][$key];
                $others[$i]['remark'] = $request['others-remark'][$key];
                $others[$i]['recommendation'] = $request['others-recommendation'][$key];
                $i++;
            }
        }

        $goal = [];
        $goal['previous'] = $request['previous'];
        $goal['new'] = $request['new'];

        $result = [];
        $result['score'] = $request['result-score'];
        $result['talent'] = $request['result-talent'];
        $result['recommendation'] = $request['result-recommendation'];


        $item->courtesy = json_encode($courtesy);
        $item->ownership = json_encode($ownership);
        $item->nurture = json_encode($nurture);
        $item->collaboration = json_encode($collaboration);
        $item->integrity = json_encode($integrity);
        $item->seamlessness = json_encode($seamlessness);
        $item->excellence = json_encode($excellence);
        $item->emotional_intelligence = json_encode($emotional_intelligence);
        $item->balance = json_encode($balance);
        $item->brilliance = json_encode($brilliance);
        $item->others = json_encode($others);
        $item->goal = json_encode($goal);
        $item->result = json_encode($result);

        if($item->save()) {
            return back()->with('success', 'Successfully Updated!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function personal(Request $request)
    {
        $id = Auth::user()->id;

        $data['items'] = Development::getDevelopment("employee_id={$id} AND draft=0");
        $data['is_leader'] = $this->isLeader(Auth::user()->id);

        return view('development.personal', $data);
    }

    public function upcoming(Request $request){
        if(Auth::user()->isAdmin()){
            $data['items'] = DevelopmentUpcoming::getUpcoming();

          
        }else {
           return redirect('404');
        }



        return view('development.upcoming', $data);
    }
}
