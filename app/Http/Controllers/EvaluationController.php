<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Evaluation;
use App\Models\ElinkActivities;
use App\Models\Employee;
use App\Models\SentEmailArchives;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class EvaluationController extends Controller
{
    private static function getEmployees($id)
    {
        $adtl_lnk = Employee::select('employee_info.id', 'employee_info.first_name', 'employee_info.last_name', 'employee_info.email', 'employee_info.position_name', 'employee_info.team_name', 'employee_info.profile_img')
            ->join('adtl_linkees as lnk', 'lnk.adtl_linkee', '=', 'employee_info.id')
            ->where('employee_info.status', 1)
            ->whereNull('employee_info.deleted_at')
            ->where('lnk.adtl_linker', $id)
            ->orderBy('employee_info.last_name', 'ASC')
            ->get();

        $subordinates = Employee::select('id', 'first_name', 'last_name', 'email', 'position_name', 'team_name', 'profile_img')
            ->whereNull('deleted_at')
            ->where('status', 1)
            ->where(function ($query) use ($id) {
                $query->where('manager_id', $id)
                    ->orWhere('supervisor_id', $id);
            })
            ->get();

        $employees = [];

        foreach ($adtl_lnk->merge($subordinates) as $emp) {
            $arr['id'] = $emp->id;
            $arr['first_name'] = $emp->first_name;
            $arr['last_name'] = $emp->last_name;
            $arr['email'] = $emp->email;
            $arr['position_name'] = $emp->position_name;
            $arr['team_name'] = $emp->team_name;
            $arr['profile_img'] = $emp->profile_img;

            $employees[$emp->id] = (object) $arr;
        }

        return $employees;
    }

    public function evaluation(Request $request)
    {
        $data['items'] = Evaluation::getEvaluations(Auth::user()->id);
        $data['is_leader'] = count($this->getEmployees(Auth::user()->id));
        if(Auth::user()->isAdmin()) {
            $data['items'] = Evaluation::getEvaluations();
        }

        return view('evaluation.evaluation', $data);
    }

    public function create(Request $request)
    {

        if(Auth::user()->isAdmin() || Auth::user()->usertype == 2 || Auth::user()->usertype == 3) {

            $data['employees'] = self::getEmployees(Auth::user()->id);
        } else {
            return redirect('404');
        }

        $data['record'] = '';
        $data['employees'] = self::getEmployees(Auth::user()->id);

        if(!empty($_GET['record'])) {

            $data['employee'] = User::where('slug', $_GET['record'])->first();
        }

        if(Auth::user()->isAdmin()) {
            $data['employees'] = User::AllExceptSuperAdmin()->ActiveEmployees()->orderBy('last_name')->get();
        }

        return view('evaluation.create', $data);
    }

    public function store(Request $request)
    {
        $employee = User::findOrFail($request->employee_id);
        $manager = User::findOrFail($employee->manager_id);
        $superior = User::findOrFail($employee->supervisor_id);

        if(empty($employee)) {
            redirect('/404');
            exit;
        }

        $job_knowledge['score'] = $request->input('score-job-knowledged');
        $job_knowledge['remark'] = $request->input('remark-job-knowledged');

        $dependability['score'] = $request['score-dependability'];
        $dependability['remark'] = $request['remark-dependability'];

        $problem_solving['score'] = $request['score-problem-solving'];
        $problem_solving['remark'] = $request['remark-problem-solving'];

        $efficiency['score'] = $request['score-efficiency'];
        $efficiency['remark'] = $request['remark-efficiency'];

        $work_attitude['score'] = $request['score-work-attitude'];
        $work_attitude['remark'] = $request['remark-work-attitude'];

        $initiative['score'] = $request['score-initiative'];
        $initiative['remark'] = $request['remark-initiative'];

        $attendance['score'] = $request['score-attendance'];
        $attendance['remark'] = $request['remark-attendance'];

        $cooperation['score'] = $request['score-cooperation'];
        $cooperation['remark'] = $request['remark-cooperation'];

        $proactiveness['score'] = $request['score-proactiveness'];
        $proactiveness['remark'] = $request['remark-proactiveness'];

        $developmental = [];
        for($i = 0; $i < count($request->needs); $i++) {
            $developmental[$i]['needs'] = $request->needs[$i];
            $developmental[$i]['activity'] = $request->activity[$i];
            $developmental[$i]['reason'] = $request->reason[$i];
        }

        $evaluation = new Evaluation();
        $evaluation->employee_id = $employee->id;
        $evaluation->superior_id = Auth::user()->id;
        $evaluation->manager_id = $manager->id;
        $evaluation->title = $request->title;
        $evaluation->job_knowledge = json_encode($job_knowledge);
        $evaluation->dependability = json_encode($dependability);
        $evaluation->problem_solving = json_encode($problem_solving);
        $evaluation->efficiency = json_encode($efficiency);
        $evaluation->work_attitude = json_encode($work_attitude);
        $evaluation->initiative = json_encode($initiative);
        $evaluation->attendance = json_encode($attendance);
        $evaluation->cooperation = json_encode($cooperation);
        $evaluation->proactiveness = json_encode($proactiveness);
        $evaluation->developmental_training = json_encode($developmental);
        $evaluation->comments = $request->comments;
        $evaluation->recommendations = implode('|', $request->recommendations);

        $mail_type = '';
        switch($request->type) {
            case '3rd Month Evaluation': $mail_type = 'EVALUATION03';
                break;
            case '5th Month Evaluation': $mail_type = 'EVALUATION05';
                break;
        }

        if($evaluation->save()) {
            $first = substr(time(), 2);
            $second = substr(md5($evaluation->id), -4);
            $third = substr(uniqid(), -4);
            $fourth = substr(rand(), -4);
            $fifth = generateRandomString();

            $slug = $first . '-' . $second . '-' . $third . '-' . $fourth . '-' . $fifth;
            $evaluation->slug = $slug;
            $evaluation->save();

            $data['title'] = $request->title;
            $data['emp_name'] = $employee->first_name . ' ' . $employee->last_name;
            $data['manager_name'] = $manager->first_name;
            $data['supervisor_name'] = $superior->first_name;
            $data['url'] = url("evaluation/{$slug}");

            $superiorEmail = $superior->email;

            if($manager->id == Auth::user()->id) {
                $evaluation->eval_approval = 1;
                $evaluation->save();
                // Mail::to($employee->email)->send(new EvaluationNotification($data));
            } else {
                // Mail::to($manager->email)->send(new EvaluationManagerNotification($data, $superiorEmail));
            }

            $archive = SentEmailArchives::where('employee_id', $employee->id)->where('mail_type', $mail_type)->where('status', 0)->first();
            if(!empty($archive)) {
                $archive->status = 1;
                $archive->save();
            }

            return redirect($data['url'])->with('success', "Evaluation Successfully Submitted!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }

    }

    public function show($slug)
    {
        // Assuming $id is the slug you want to search for
        $item = Evaluation::where('slug', $slug)->first();

        // Check if the evaluation was found
        if ($item) {
            // Find the user based on the employee_id from the evaluation
            $employee = User::find($item->employee_id);

            if (Auth::user()->usertype == 2 || Auth::user()->usertype == 3) {
                if (Auth::user()->isAdmin() || Auth::user()->usertype == 3) {

                } elseif ($employee->supervisor_id != Auth::user()->id) {
                    if (Auth::user()->usertype == 2 || Auth::user()->usertype == 3 && $employee->id == Auth::user()->id) {

                    } else {
                        return redirect('404');
                    }
                }
            } elseif (Auth::user()->usertype == 1 && !Auth::user()->isAdmin()) {
                if (Auth::user()->id != $item->employee_id) {
                    return redirect('404');
                }
            }

            $employee = User::withTrashed()->find($item->employee_id);

            // echo "<pre>";
            // print_r($employee);
            // return;

            $data['item'] = $this->distribute($item);
            $data['employee'] = $employee;
            $data['superior'] = User::withTrashed()->find($item->superior_id);
            $data['manager'] = User::withTrashed()->find($employee->manager_id);

        } else {
            return redirect('404');
        }

        return view('evaluation.show', $data);
    }

    private static function distribute($item)
    {
        $item->job_knowledge = json_decode($item->job_knowledge);
        $item->dependability = json_decode($item->dependability);
        $item->problem_solving = json_decode($item->problem_solving);
        $item->efficiency = json_decode($item->efficiency);
        $item->work_attitude = json_decode($item->work_attitude);
        $item->initiative = json_decode($item->initiative);
        $item->attendance = json_decode($item->attendance);
        $item->cooperation = json_decode($item->cooperation);
        $item->proactiveness = json_decode($item->proactiveness);
        $item->developmental_training = json_decode($item->developmental_training);
        $item->recommendations = explode('|', $item->recommendations);

        return $item;
    }

    public function team(Request $request)
    {

        $data['items'] = Evaluation::getEvaluations(Auth::user()->id, 'team');

        return view('evaluation.team', $data);
    }

    public function update(Request $request)
    {
        $item = Evaluation::find($request->id);

        if(empty($item)) {
            redirect('/404');
            exit;
        }

        $job_knowledge['score'] = $request['score-job-knowledged'];
        $job_knowledge['remark'] = $request['remark-job-knowledged'];

        $dependability['score'] = $request['score-dependability'];
        $dependability['remark'] = $request['remark-dependability'];

        $problem_solving['score'] = $request['score-problem-solving'];
        $problem_solving['remark'] = $request['remark-problem-solving'];

        $efficiency['score'] = $request['score-efficiency'];
        $efficiency['remark'] = $request['remark-efficiency'];

        $work_attitude['score'] = $request['score-work-attitude'];
        $work_attitude['remark'] = $request['remark-work-attitude'];

        $initiative['score'] = $request['score-initiative'];
        $initiative['remark'] = $request['remark-initiative'];

        $attendance['score'] = $request['score-attendance'];
        $attendance['remark'] = $request['remark-attendance'];

        $cooperation['score'] = $request['score-cooperation'];
        $cooperation['remark'] = $request['remark-cooperation'];

        $proactiveness['score'] = $request['score-proactiveness'];
        $proactiveness['remark'] = $request['remark-proactiveness'];

        $developmental = [];
        for($i = 0; $i < count($request->needs); $i++) {
            $developmental[$i]['needs'] = $request->needs[$i];
            $developmental[$i]['activity'] = $request->activity[$i];
            $developmental[$i]['reason'] = $request->reason[$i];
        }

        $item->title = $request->title;
        $item->job_knowledge = json_encode($job_knowledge);
        $item->dependability = json_encode($dependability);
        $item->problem_solving = json_encode($problem_solving);
        $item->efficiency = json_encode($efficiency);
        $item->work_attitude = json_encode($work_attitude);
        $item->initiative = json_encode($initiative);
        $item->attendance = json_encode($attendance);
        $item->cooperation = json_encode($cooperation);
        $item->proactiveness = json_encode($proactiveness);
        $item->developmental_training = json_encode($developmental);
        $item->comments = $request->comments;
        $item->recommendations = implode('|', $request->recommendations);

        if($item->save()) {
            return back()->with('success', 'Evaluation Successfully Updated!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function excel($slug)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');

        $item = Evaluation::where('slug', $slug)->first();
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        $item = $this->distribute($item);
        $employee = User::withTrashed()->find($item->employee_id);
        $superior = User::withTrashed()->find($item->superior_id);
        $filename = "{$employee->last_name} - {$item->title}.xlsx";
        $idx = 28;

        $spreadsheet = IOFactory::load('public/excel/evaluation.xlsx');
        $worksheet = $spreadsheet->getSheetByName('Summary');
        $worksheet->setCellValue('B10', $employee->first_name . ' ' . $employee->last_name);
        $worksheet->setCellValue('F10', $employee->position_name);
        $worksheet->setCellValue('B11', $superior->first_name . ' ' . $superior->last_name);
        $worksheet->setCellValue('F11', date('Y-m-d', strtotime($item->created_at)));
        $worksheet->setCellValue('B37', $superior->position_name);

        $worksheet2 = $spreadsheet->getSheetByName('Evaluation Form');
        $worksheet2->setCellValue('C8', $employee->team_name);
        $worksheet2->setCellValue('E27', $item->job_knowledge->score);
        $worksheet->setCellValue('E15', "='Evaluation Form'!E27:L27");
        $job_knowledge_remark = $this->linesArray($item->job_knowledge->remark);

        if(count($job_knowledge_remark) < 3) {
            if(!empty($job_knowledge_remark[1])) {
                foreach($job_knowledge_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $job_knowledge_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($job_knowledge_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($job_knowledge_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->dependability->score);
        $worksheet->setCellValue('E16', "='Evaluation Form'!E{$idx}:L{$idx}");
        $dependability_remark = $this->linesArray($item->dependability->remark);
        $idx++;

        if(count($dependability_remark) < 3) {
            if(!empty($dependability_remark[1])) {
                foreach($dependability_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $dependability_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($dependability_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($dependability_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->problem_solving->score);
        $worksheet->setCellValue('E17', "='Evaluation Form'!E{$idx}:L{$idx}");
        $problem_solving_remark = $this->linesArray($item->problem_solving->remark);
        $idx++;

        if(count($problem_solving_remark) < 3) {
            if(!empty($problem_solving_remark[1])) {
                foreach($problem_solving_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $problem_solving_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($problem_solving_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($problem_solving_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->efficiency->score);
        $worksheet->setCellValue('E18', "='Evaluation Form'!E{$idx}:L{$idx}");
        $efficiency_remark = $this->linesArray($item->efficiency->remark);
        $idx++;

        if(count($efficiency_remark) < 3) {
            if(!empty($efficiency_remark[1])) {
                foreach($efficiency_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $efficiency_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($efficiency_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($efficiency_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->work_attitude->score);
        $worksheet->setCellValue('E19', "='Evaluation Form'!E{$idx}:L{$idx}");
        $work_attitude_remark = $this->linesArray($item->work_attitude->remark);
        $idx++;

        if(count($work_attitude_remark) < 3) {
            if(!empty($work_attitude_remark[1])) {
                foreach($work_attitude_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $work_attitude_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($work_attitude_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($work_attitude_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->initiative->score);
        $worksheet->setCellValue('E20', "='Evaluation Form'!E{$idx}:L{$idx}");
        $initiative_remark = $this->linesArray($item->initiative->remark);
        $idx++;

        if(count($initiative_remark) < 3) {
            if(!empty($initiative_remark[1])) {
                foreach($initiative_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $initiative_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($initiative_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($initiative_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->attendance->score);
        $worksheet->setCellValue('E21', "='Evaluation Form'!E{$idx}:L{$idx}");
        $attendance_remark = $this->linesArray($item->attendance->remark);
        $idx++;

        if(count($attendance_remark) < 3) {
            if(!empty($attendance_remark[1])) {
                foreach($attendance_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $attendance_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($attendance_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($attendance_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->cooperation->score);
        $worksheet->setCellValue('E22', "='Evaluation Form'!E{$idx}:L{$idx}");
        $cooperation_remark = $this->linesArray($item->cooperation->remark);
        $idx++;

        if(count($cooperation_remark) < 3) {
            if(!empty($cooperation_remark[1])) {
                foreach($cooperation_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $cooperation_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($cooperation_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($cooperation_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 11;
        $worksheet2->setCellValue("E{$idx}", $item->proactiveness->score);
        $worksheet->setCellValue('E23', "='Evaluation Form'!E{$idx}:L{$idx}");
        $proactiveness_remark = $this->linesArray($item->proactiveness->remark);
        $idx++;

        if(count($proactiveness_remark) < 3) {
            if(!empty($proactiveness_remark[1])) {
                foreach($proactiveness_remark as $key => $remark) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                    $idx++;
                }
            } else {
                $worksheet2->setCellValue("A{$idx}", $proactiveness_remark[0]);
                $idx = $idx + 2;
            }
        } else {
            foreach($proactiveness_remark as $key => $remark) {
                if($key == 0) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } elseif($key == max(array_keys($proactiveness_remark))) {
                    $worksheet2->setCellValue("A{$idx}", $remark);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("A{$idx}:L{$idx}");
                    $worksheet2->setCellValue("A{$idx}", $remark);
                }
                $idx++;
            }
        }

        $idx = $idx + 4;

        if(count($item->developmental_training) < 5) {
            $i = $idx;
            foreach($item->developmental_training as $training) {
                $worksheet2->setCellValue("B{$i}", $training->needs);
                $worksheet2->setCellValue("H{$i}", $training->activity);
                $i++;
            }

            $idx = $idx + 4;
        } else {
            foreach($item->developmental_training as $key => $training) {
                if($key == 0) {
                    $worksheet2->setCellValue("B{$idx}", $training->needs);
                    $worksheet2->setCellValue("H{$idx}", $training->activity);
                } elseif($key == 1) {
                    $worksheet2->setCellValue("B{$idx}", $training->needs);
                    $worksheet2->setCellValue("H{$idx}", $training->activity);
                } elseif($key == 2) {
                    $worksheet2->setCellValue("B{$idx}", $training->needs);
                    $worksheet2->setCellValue("H{$idx}", $training->activity);
                } elseif($key == max(array_keys($item->developmental_training))) {
                    $worksheet2->setCellValue("B{$idx}", $training->needs);
                    $worksheet2->setCellValue("H{$idx}", $training->activity);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->mergeCells("H{$idx}:L{$idx}");
                    $worksheet2->setCellValue("B{$idx}", $training->needs);
                    $worksheet2->setCellValue("H{$idx}", $training->activity);
                }
                $idx++;
            }
        }

        $idx = $idx + 2;
        $comments = $this->linesArray($item->comments, 85);

        if(count($comments) < 5) {
            $i = $idx;
            foreach($comments as $comment) {
                $worksheet2->setCellValue("B{$i}", $comment);
                $i++;
            }

            $idx = $idx + 4;
        } else {
            foreach($comments as $key => $comment) {
                if($key == 0) {
                    $worksheet2->setCellValue("B{$idx}", $comment);
                } elseif($key == 1) {
                    $worksheet2->setCellValue("B{$idx}", $comment);
                } elseif($key == 2) {
                    $worksheet2->setCellValue("B{$idx}", $comment);
                } elseif($key == max(array_keys($comments))) {
                    $worksheet2->setCellValue("B{$idx}", $comment);
                } else {
                    $worksheet2->insertNewRowBefore("{$idx}");
                    $worksheet2->setCellValue("B{$idx}", $comment);
                }
                $idx++;
            }
        }

        $idx = $idx + 3;

        if(in_array('REGULARIZATION', $item->recommendations)) {
            $worksheet2->setCellValue("B{$idx}", 'x');
        }
        if(in_array('PROMOTION', $item->recommendations)) {
            $worksheet2->setCellValue("G{$idx}", 'x');
        }

        $idx++;

        if(in_array('TERMINATE PROBATION', $item->recommendations)) {
            $worksheet2->setCellValue("B{$idx}", 'x');
        }
        if(in_array('SALARY INCREASE', $item->recommendations)) {
            $worksheet2->setCellValue("G{$idx}", 'x');
        }

        $idx++;

        if(in_array('EXTEND PROBATION', $item->recommendations)) {
            $worksheet2->setCellValue("B{$idx}", 'x');
        }

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename);
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setPreCalculateFormulas(false);
        $writer->setOffice2003Compatibility(true);
        $writer->save('php://output');
    }

    public function pdf($slug)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');

        $item = Evaluation::where('slug', $slug)->first();
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        $employee = User::withTrashed()->find($item->employee_id);

        $data['item'] = $this->distribute($item);
        $data['employee'] = $employee;
        $data['superior'] = User::withTrashed()->find($item->superior_id);
        $data['manager'] = User::withTrashed()->find($employee->manager_id);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('page-size', 'letter');
        $options->set('chroot', '/var/www/vhosts/clouddir.elink.corp/httpdocs/');
        $dompdf = new Dompdf($options);

        $html = View::make('evaluation.pdf', $data)->render();
        $filename = "{$employee->last_name} - {$item->title}.pdf";

        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream($filename, ['Attachment' => true]);
    }
}
