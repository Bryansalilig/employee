@extends('layouts.main')
@section('title')
Evaluation > Edit
@endsection
@section('head')
<style type="text/css">
@include('evaluation.style');
</style>
@endsection
@section('breadcrumb')
Evaluation <span>></span> Performance Appraisal
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                PERFORMANCE EVALUATION

                <a href="<?= url("evaluation/{$item->slug}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="flex-center position-ref full-height">
                    <form enctype="multipart/form-data" action="<?= url('evaluation/update') ?>" method="post">
                    {{ csrf_field() }}
                        <input type="hidden" name="id" value="<?= $item->id ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Appraisee: </strong>
                                    <input type="text" name="employee_id" class="form-control" placeholder="Appraisee" value="<?= strtoupper($employee->first_name.' '.$employee->last_name) ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position: </strong>
                                    <input type="text" name="position" class="form-control" placeholder="Position" value="<?= $employee->position_name ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Department: </strong>
                                    <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= $employee->team_name ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Date Filed: </strong>
                                    <input type="text" value="<?= date('m/d/Y', strtotime($item->created_at)) ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Evaluation Title: </strong>
                                    <select class="form-control select-title" name="type">
                                        <option value="3rd Month Evaluation"<?= ($item->title == '3rd Month Evaluation') ? ' selected' : '' ?>>3rd Month Evaluation</option>
                                        <option value="5th Month Evaluation"<?= ($item->title == '5th Month Evaluation') ? ' selected' : '' ?>>5th Month Evaluation</option>
                                        <option value="Others"<?= ($item->title != '3rd Month Evaluation' && $item->title != '5th Month Evaluation') ? ' selected' : '' ?>>Others</option>
                                    </select>
                                    <input type="text" name="title" class="form-control <?= ($item->title != '3rd Month Evaluation' && $item->title != '5th Month Evaluation') ? ' ' : 'd-none' ?>" maxlength="255" placeholder="Title..." value="<?= $item->title ?>" required>
                                </div> 
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3><b>PART I. COMPETENCY</b></h3>
                                <p>INSTRUCTIONS: Listed below are the competencies a successful employee should have. Beside each item is the description of how the company defines each competency. To evaluate your team member, choose the competency rating that best equates to the performance of your Team Member.</p>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-job-knowledge">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>JOB KNOWLEDGE</b></h4>
                                                Employees understanding of  the responsibilities specific to a job, as well as the ongoing capacity to stay abreast of changes in job functions.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->job_knowledge->score >= 4.1 && $item->job_knowledge->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Exceptional mastery of work and goes beyond what is required from him/her. Employee does not require constant  supervision or assistance in carrying out his/her tasks.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->job_knowledge->score >= 3.6 && $item->job_knowledge->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Employee has the mastery of his/her assigned tasks and responsibilities. Employee just needs minimal supervision.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->job_knowledge->score >= 3 && $item->job_knowledge->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Employee has a thorough understanding of almost all aspects of his job.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->job_knowledge->score >= 2 && $item->job_knowledge->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Employee has a good understanding of this job however requires assistance in carrying out his tasks most of the time.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->job_knowledge->score >= 1 && $item->job_knowledge->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Employee has insufficient knowledge of this job and requires frequent attention and assistance.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-job-knowledged" value="<?= $item->job_knowledge->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-job-knowledged" rows="3" required><?= $item->job_knowledge->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-dependability">
                
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>DEPENDABILITY</b></h4>
                                                The ability to complete accurate and quality work in a timely manner without the need of supervision.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->dependability->score >= 4.1 && $item->dependability->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>The employee is highly reliable and conscientious, consistently performing beyond their assigned tasks.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->dependability->score >= 3.6 && $item->dependability->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Employee can be relied upon to do his/her tasks even without supervision.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->dependability->score >= 3 && $item->dependability->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Dependable under most prescribed situations. Requires minimal supervision through random checking.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->dependability->score >= 2 && $item->dependability->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Average reliability. Delivers work without the need of special attention.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->dependability->score >= 1 && $item->dependability->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Employee may sometime be unreliable. Needs constant checking and reminding to complete tasks assigned to him.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-dependability" value="<?= $item->dependability->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-dependability" rows="3" required><?= $item->dependability->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-problem-solving">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>PROBLEM SOLVING</b></h4>
                                                Employee's ability to accurately identify problems and create/carry out a sound action plan to resolve it.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->problem_solving->score >= 4.1 && $item->problem_solving->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Employee can think out of the box and can be relied to give  problem solving solutions.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->problem_solving->score >= 3.6 && $item->problem_solving->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Always offers ideas to solve problems based on good information and sound judgment.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->problem_solving->score >= 3 && $item->problem_solving->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Can zero in on the cause of problems and offer creative solutions.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->problem_solving->score >= 2 && $item->problem_solving->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Often offers workable solutions to problems.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->problem_solving->score >= 1 && $item->problem_solving->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Needs to develop analytical skills necessary to weigh options and choose the best way to deal with situations</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-problem-solving" value="<?= $item->problem_solving->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-problem-solving" rows="3" required><?= $item->problem_solving->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-efficiency">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>EFFICIENCY</b></h4>
                                                Employee's ability to accomplish tasks accurately in the least possible time through the use of available resources.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->efficiency->score >= 4.1 && $item->efficiency->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Employee can be left alone unsupervised, manages his/her time in an very effective manner with excellent results.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->efficiency->score >= 3.6 && $item->efficiency->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Performs tasks in a timely manner without errors and supervision of immediate head.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->efficiency->score >= 3 && $item->efficiency->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Performs tasks in a timely manner without errors but may require occasional supervision of immediate superior.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->efficiency->score >= 2 && $item->efficiency->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Performs tasks in a timely manner but may commit minor errors.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->efficiency->score >= 1 && $item->efficiency->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Delivers acceptable results but constantly misses deadlines.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-efficiency" value="<?= $item->efficiency->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-efficiency" rows="3" required><?= $item->efficiency->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-work-attitude">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>WORK ATTITUDE</b></h4>
                                                The interest the employee has in the work. Shows enthusiasm in accomplishing tasks even in unlikely situations.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->work_attitude->score >= 4.1 && $item->work_attitude->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Employee is the epitome of an employee who cares and spreads positive attitude in the workplace.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->work_attitude->score >= 3.6 && $item->work_attitude->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Shows enthusiasm in work and is very positive in carrying out his/her duties.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->work_attitude->score >= 3 && $item->work_attitude->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Generally shows interest in his/her work.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->work_attitude->score >= 2 && $item->work_attitude->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Shows interest in work but tends to be inconsistent. Enthusiasm depends on work being assigned to him/her.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->work_attitude->score >= 1 && $item->work_attitude->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Indifferent about work and show disinterest in delivering results. Has constantly been a subject of reprimand for violating basic company rules and policies.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-work-attitude" value="<?= $item->work_attitude->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-work-attitude" rows="3" required><?= $item->work_attitude->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-initiative">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>INITIATIVE</b></h4>
                                                Employee's drive to do things without being told and his/her ability to act positively instead of reacting towards works.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->initiative->score >= 4.1 && $item->initiative->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Makes sound decisions and effectively carries out plans in the absence of detailed instruction or direct supervision.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->initiative->score >= 3.6 && $item->initiative->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Makes sound decisions however requires direct supervision in carrying it out.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->initiative->score >= 3 && $item->initiative->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Initiates planning but requires direct supervision in carrying it out.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->initiative->score >= 2 && $item->initiative->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Capable of planning but often hesitates to carry out the plan.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->initiative->score >= 1 && $item->initiative->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Requires detailed instruction and direct supervision when making decisions and materializing laid out plans.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-initiative" value="<?= $item->initiative->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-initiative" rows="3" required><?= $item->initiative->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-attendance">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>ATTENDANCE</b></h4>
                                                Regularity and punctuality in reporting to work and observance of break periods.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->attendance->score >= 4.1 && $item->attendance->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>No absences and or tardiness.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->attendance->score >= 3.6 && $item->attendance->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Always punctual and diligent in observing work hours and breaks.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->attendance->score >= 3 && $item->attendance->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Is rarely absent or late. Observes proper working hours.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->attendance->score >= 2 && $item->attendance->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Average attendance and punctuality.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->attendance->score >= 1 && $item->attendance->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Frequent absences and tardiness.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-attendance" value="<?= $item->attendance->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-attendance" rows="3" required><?= $item->attendance->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-cooperation">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>COOPERATION</b></h4>
                                                Ability to work and deal with people harmoniously inorder to attain the objective of the team.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->cooperation->score >= 4.1 && $item->cooperation->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Employee is the "go to" person, gives support and aids anyone who needs his/her assistance without need to be asked and proactively helps even beyond what is expected of him/her.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->cooperation->score >= 3.6 && $item->cooperation->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Effectively deals with people and a very enthusiastic team worker. Employee has been a big contributor in high team stats.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->cooperation->score >= 3 && $item->cooperation->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>Is a good team worker and is very quick to help others. Employee has performed well inorder to pull up team stats.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->cooperation->score >= 2 && $item->cooperation->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Fairly works with others. Accepts his/her share of group work without question.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->cooperation->score >= 1 && $item->cooperation->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Avoids friction with other but is sometimes unwilling to help others.  Performance has significally pulled down team stats.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-cooperation" value="<?= $item->cooperation->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-cooperation" rows="3" required><?= $item->cooperation->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table-bordered table-striped table-competency" id="table-proactiveness">
                                <thead>
                                        <tr>
                                            <td style="font-weight: bold;">Competency</td>
                                            <td style="font-weight: bold;">Ratings</td>
                                            <td style="font-weight: bold;">Definition</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5" style="width: 400px;">
                                                <h4><b>PRO ACTIVENESS</b></h4>
                                                Ability to take control and make things happen. This refers to an employees drive to act and solve a problem rather than reacting to it.
                                            </td>
                                            <td class="text-center font-bold bg-score <?= ($item->proactiveness->score >= 4.1 && $item->proactiveness->score <= 5) ? 'bg-success' : '' ?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
                                            <td>Employee thinks far ahead of his/her task and can see the bigger picture. He/She can anticipate problems and prepares stop gap measures effectively and efficiently.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->proactiveness->score >= 3.6 && $item->proactiveness->score <= 4) ? 'bg-success' : '' ?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
                                            <td>Employee's drive to prepare for and resolve problems before it even occurs.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->proactiveness->score >= 3 && $item->proactiveness->score <= 3.5) ? 'bg-success' : '' ?>" data-min="3" data-max="3.5">3<br> GOOD</td>
                                            <td>The employee demonstrates the ability to proactively plan for unforeseen situations with the guidance of their immediate supervisor, without needing explicit instructions.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->proactiveness->score >= 2 && $item->proactiveness->score <= 2.9) ? 'bg-danger' : '' ?>" data-min="2" data-max="2.9">2<br> FAIR</td>
                                            <td>Plans and prepare for unlikely situations with the directives of the his/her immediate superior.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center font-bold bg-score <?= ($item->proactiveness->score >= 1 && $item->proactiveness->score <= 1.9) ? 'bg-danger' : '' ?>" data-min="1" data-max="1.9">1<br> POOR</td>
                                            <td>Fails or refuses to create actions plans to resolve probable problems.</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="display:none"><b>REMARKS</b></td>
                                            <td style="display:none"><input type="number" class="form-control rating" name="score-proactiveness" value="<?= $item->proactiveness->score ?>" min="1" max="5" step="1"></td>
                                            <td style="display:none">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>REMARKS</b>
                                                <textarea class="form-control" name="remark-proactiveness" rows="3" required><?= $item->proactiveness->remark ?></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3><b>PART II. DEVELOPMENTAL AND TRAINING NEEDS</b></h3>
                                <p>(List at least 2 competencies that the employee needs to improve)</p>
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>COMPETENCIES</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>TRAINING</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>REASON</strong>
                                </div>
                            </div>
                        </div>
                        <div class="entry-content">
                        <?php foreach($item->developmental_training as $key=>$val) { ?>
                            <div class="row row-entry">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="needs[]" placeholder="Needs" value="<?= $val->needs ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="activity[]" placeholder="Activity" value="<?= $val->activity ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                       <textarea name="reason[]" class="form-control" id="" cols="10" rows="1" placeholder="Reason" value="<?= $val->reason?>" required><?= $val->reason?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn btn-<?= ($key == 0) ? 'primary' : 'danger' ?> btn-<?= ($key == 0) ? 'add' : 'remove' ?>">
                                            <span class="fa fa-<?= ($key == 0) ? 'plus' : 'minus' ?>"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3><b>PART III. COMMENTS AND SUGGESTIONS</b></h3>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="comments" rows="5" required><?= $item->comments ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3><b>PART IV. RECOMMENDATION</b></h3>
                                <p>(Put a check mark on appropriate recommendation)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recommendations[]" value="REGULARIZATION" id="checkbox1" <?= in_array('REGULARIZATION', $item->recommendations) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="checkbox1">REGULARIZATION</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recommendations[]" value="PROMOTION" id="checkbox2" <?= in_array('PROMOTION', $item->recommendations) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="checkbox2">PROMOTION</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recommendations[]" value="TERMINATE PROBATION" id="checkbox3" <?= in_array('TERMINATE PROBATION', $item->recommendations) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="checkbox3">TERMINATE PROBATION</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recommendations[]" value="SALARY INCREASE" id="checkbox4" <?= in_array('SALARY INCREASE', $item->recommendations) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="checkbox4">SALARY INCREASE</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recommendations[]" value="EXTEND PROBATION" id="checkbox5" <?= in_array('EXTEND PROBATION', $item->recommendations) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="checkbox5">EXTEND PROBATION</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" id="register-button" class="btn btn-primary" value="Update">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('evaluation.script')
@endsection
