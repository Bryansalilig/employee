<style>
  .eval-info{
    font-size: 15px;
  }
  label {
    font-family: 'Open Sans', sans-serif;
  }
  .fa-minus-square {
    font-size:17px;
  }
  .fa-check-square {
    font-size:17px;
  }
  .description {
    padding: 5px;
  }
</style>
<div class="row">
  <div class="col-md-12 m-t-10">
    <h5 class="text-default text-center m-b-10 m-t-2">
   <h4 class="text-default text-center" style="text-transform:uppercase"><b>{{ $item->title }}</b></h4>
   <br>
      <h3><b>PART I. COMPETENCY</b></h3>
      <p>INSTRUCTIONS: Listed below are the competencies a successful employee should have. Beside each item is the description of how the company defines each competency. To evaluate your team member, choose the competency rating that best equates to the performance of your Team Member.</p>

    <table class="table-bordered table-striped table-competency" id="table-job-knowledge">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>JOB KNOWLEDGE</b></h4>
            Employees understanding of  the responsibilities specific to a job, as well as the ongoing capacity to stay abreast of changes in job functions.
          </td>
          <td class="text-center font-bold <?= ($item->job_knowledge->score >= 4.1 && $item->job_knowledge->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Exceptional mastery of work and goes beyond what is  from him/her. Employee does not require constant  supervision or assistance in carrying out his/her tasks.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->job_knowledge->score >= 3.6 && $item->job_knowledge->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Employee has the mastery of his/her assigned tasks and responsibilities. Employee just needs minimal supervision.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->job_knowledge->score >= 3 && $item->job_knowledge->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Employee has a thorough understanding of almost all aspects of his job.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->job_knowledge->score >= 2 && $item->job_knowledge->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Employee has a good understanding of this job however requires assistance in carrying out his tasks most of the time.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->job_knowledge->score >= 1 && $item->job_knowledge->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Employee has insufficient knowledge of this job and requires frequent attention and assistance.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-job-knowledged" value="{{ $item->job_knowledge->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-job-knowledged" rows="3" disabled>{{ $item->job_knowledge->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-dependability">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>DEPENDABILITY</b></h4>
            The ability to complete accurate and quality work in a timely manner without the need of supervision.
          </td>
          <td class="text-center font-bold <?= ($item->dependability->score >= 4.1 && $item->dependability->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">The employee is highly reliable and conscientious, consistently performing beyond their assigned tasks.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->dependability->score >= 3.6 && $item->dependability->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Employee can be relied upon to do his/her tasks even without supervision.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->dependability->score >= 3 && $item->dependability->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Dependable under most prescribed situations. Requires minimal supervision through random checking.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->dependability->score >= 2 && $item->dependability->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Average reliability. Delivers work without the need of special attention.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->dependability->score >= 1 && $item->dependability->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Employee may sometime be unreliable. Needs constant checking and reminding to complete tasks assigned to him.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-dependability" value="{{ $item->dependability->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-dependability" rows="3" disabled>{{ $item->dependability->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-problem-solving">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding: 5px">
            <h4><b>PROBLEM SOLVING</b></h4>
            Employee's ability to accurately identify problems and create/carry out a sound action plan to resolve it.
          </td>
          <td class="text-center font-bold <?= ($item->problem_solving->score >= 4.1 && $item->problem_solving->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Employee can think out of the box and can be relied to give  problem solving solutions.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->problem_solving->score >= 3.6 && $item->problem_solving->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Always offers ideas to solve problems based on good information and sound judgment.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->problem_solving->score >= 3 && $item->problem_solving->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Can zero in on the cause of problems and offer creative solutions.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->problem_solving->score >= 2 && $item->problem_solving->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Often offers workable solutions to problems.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->problem_solving->score >= 1 && $item->problem_solving->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Needs to develop analytical skills necessary to weigh options and choose the best way to deal with situations</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-problem-solving" value="{{ $item->problem_solving->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-problem-solving" rows="3" disabled>{{ $item->problem_solving->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-efficiency">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>EFFICIENCY</b></h4>
            Employee's ability to accomplish tasks accurately in the least possible time through the use of available resources.
          </td>
          <td class="text-center font-bold <?= ($item->efficiency->score >= 4.1 && $item->efficiency->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Employee can be left alone unsupervised, manages his/her time in an very effective manner with excellent results.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->efficiency->score >= 3.6 && $item->efficiency->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Performs tasks in a timely manner without errors and supervision of immediate head.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->efficiency->score >= 3 && $item->efficiency->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Performs tasks in a timely manner without errors but may require occasional supervision of immediate superior.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->efficiency->score >= 2 && $item->efficiency->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Performs tasks in a timely manner but may commit minor errors.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->efficiency->score >= 1 && $item->efficiency->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Delivers acceptable results but constantly misses deadlines.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-efficiency" value="{{ $item->efficiency->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-efficiency" rows="3" diabled>{{ $item->efficiency->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-work-attitude">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>WORK ATTITUDE</b></h4>
            The interest the employee has in the work. Shows enthusiasm in accomplishing tasks even in unlikely situations.
          </td>
          <td class="text-center font-bold <?= ($item->work_attitude->score >= 4.1 && $item->work_attitude->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Employee is the epitome of an employee who cares and spreads positive attitude in the workplace.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->work_attitude->score >= 3.6 && $item->work_attitude->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Shows enthusiasm in work and is very positive in carrying out his/her duties.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->work_attitude->score >= 3 && $item->work_attitude->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Generally shows interest in his/her work.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->work_attitude->score >= 2 && $item->work_attitude->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Shows interest in work but tends to be inconsistent. Enthusiasm depends on work being assigned to him/her.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->work_attitude->score >= 1 && $item->work_attitude->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Indifferent about work and show disinterest in delivering results. Has constantly been a subject of reprimand for violating basic company rules and policies.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-work-attitude" value="{{ $item->work_attitude->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-work-attitude" rows="3" disabled>{{ $item->work_attitude->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-initiative">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>INITIATIVE</b></h4>
            Employee's drive to do things without being told and his/her ability to act positively instead of reacting towards works.
          </td>
          <td class="text-center font-bold <?= ($item->initiative->score >= 4.1 && $item->initiative->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Makes sound decisions and effectively carries out plans in the absence of detailed instruction or direct supervision.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->initiative->score >= 3.6 && $item->initiative->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Makes sound decisions however requires direct supervision in carrying it out.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->initiative->score >= 3 && $item->initiative->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Initiates planning but requires direct supervision in carrying it out.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->initiative->score >= 2 && $item->initiative->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Capable of planning but often hesitates to carry out the plan.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->initiative->score >= 1 && $item->initiative->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Requires detailed instruction and direct supervision when making decisions and materializing laid out plans.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-initiative" value="{{ $item->initiative->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-initiative" rows="3" disabled>{{ $item->initiative->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-attendance">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>ATTENDANCE</b></h4>
            Regularity and punctuality in reporting to work and observance of break periods.
          </td>
          <td class="text-center font-bold <?= ($item->attendance->score >= 4.1 && $item->attendance->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">No absences and or tardiness.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->attendance->score >= 3.6 && $item->attendance->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Always punctual and diligent in observing work hours and breaks.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->attendance->score >= 3 && $item->attendance->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Is rarely absent or late. Observes proper working hours.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->attendance->score >= 2 && $item->attendance->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Average attendance and punctuality.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->attendance->score >= 1 && $item->attendance->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Frequent absences and tardiness.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-attendance" value="{{ $item->attendance->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-attendance" rows="3" disabled>{{ $item->attendance->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-cooperation">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>COOPERATION</b></h4>
            Ability to work and deal with people harmoniously inorder to attain the objective of the team.
          </td>
          <td class="text-center font-bold <?= ($item->cooperation->score >= 4.1 && $item->cooperation->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Employee is the "go to" person, gives support and aids anyone who needs his/her assistance without need to be asked and proactively helps even beyond what is expected of him/her.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->cooperation->score >= 3.6 && $item->cooperation->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Effectively deals with people and a very enthusiastic team worker. Employee has been a big contributor in high team status.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->cooperation->score >= 3 && $item->cooperation->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">Is a good team worker and is very quick to help others. Employee has performed well inorder to pull up team status.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->cooperation->score >= 2 && $item->cooperation->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Fairly works with others. Accepts his/her share of group work without question.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->cooperation->score >= 1 && $item->cooperation->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Avoids friction with other but is sometimes unwilling to help others.  Performance has significally pulled down team status.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-cooperation" value="{{ $item->cooperation->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-cooperation" rows="3" disabled>{{ $item->cooperation->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>

    <table class="table-bordered table-striped m-t-20 table-competency" id="table-proactiveness">
      <tbody>
        <tr>
          <td rowspan="5" style="width: 350px;padding:8px">
            <h4><b>PRO ACTIVENESS</b></h4>
            Ability to take control and make things happen. This refers to an employees drive to act and solve a problem rather than reacting to it.
          </td>
          <td class="text-center font-bold <?= ($item->proactiveness->score >= 4.1 && $item->proactiveness->score <= 5) ? 'bg-success' : ''?>" data-min="4.1" data-max="5" style="width: 150px;">5<br> EXCELLENT</td>
          <td class="description">Employee thinks far ahead of his/her task and can see the bigger picture. He/She can anticipate problems and prepares stop gap measures effectively and efficiently.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->proactiveness->score >= 3.6 && $item->proactiveness->score <= 4) ? 'bg-success' : ''?>" data-min="3.6" data-max="4">4<br> VERY GOOD</td>
          <td class="description">Employee's drive to prepare for and resolve problems before it even occurs.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->proactiveness->score >= 3 && $item->proactiveness->score <= 3.5) ? 'bg-success' : ''?>" data-min="3" data-max="3.5">3<br> GOOD</td>
          <td class="description">The employee demonstrates the ability to proactively plan for unforeseen situations with the guidance of their immediate supervisor, without needing explicit instructions.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->proactiveness->score >= 2 && $item->proactiveness->score <= 2.9) ? 'bg-danger' : ''?>" data-min="2" data-max="2.9">2<br> FAIR</td>
          <td class="description">Plans and prepare for unlikely situations with the directives of the his/her immediate superior.</td>
        </tr>
        <tr>
          <td class="text-center font-bold <?= ($item->proactiveness->score >= 1 && $item->proactiveness->score <= 1.9) ? 'bg-danger' : ''?>" data-min="1" data-max="1.9">1<br> POOR</td>
          <td class="description">Fails or refuses to create actions plans to resolve probable problems.</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td style="display:none"><b>REMARKS</b></td>
          <td style="display:none"><input type="number" class="form-control rating" name="score-proactiveness" value="{{ $item->proactiveness->score }}" min="1" max="5" step="1"></td>
          <td style="display:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">
            <b>REMARKS</b>
            <textarea class="form-control" name="remark-proactiveness" rows="3" disabled>{{ $item->proactiveness->remark }}</textarea>
          </td>
        </tr>
      </tfoot>
    </table>
    <hr>
  <br>
      <h3><b>PART II. DEVELOPMENTAL AND TRAINING NEEDS</b></h3>
    <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>COMPETENCY</th>
          <th>ACTIVITY</th>
          <th>REASON</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($item->developmental_training as $key=>$val)
        <tr>
          <td>{{ $val->needs }}</td>
          <td>{{ $val->activity }}</td>
          <td>{{ $val->reason }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <hr>
    <br>
      <h3><b>PART III. SUPERIOR'S COMMENTS AND SUGGESTIONS</b></h3>
      <textarea class="form-control col-md-12" id="" rows="5" disabled>{{ $item->comments }}</textarea>
    <hr>
    <br>
    <div style="border-right: 1px solid #eee;">
    <h3><b>PART IV. SUPERIOR'S RECOMMENDATION</b></h3>
    <br>
    <div class="col-md-12" style="display: flex; flex-wrap: wrap;">
      <div class="col-md-6" style="flex: 0 0 50%;">
      <span class="fa fa-<?= in_array('REGULARIZATION', $item->recommendations) ? 'check-square text-primary' : 'minus-square' ?>"></span>
        <label for="">REGULARIZATION</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
      <span class="fa fa-<?= in_array('PROMOTION', $item->recommendations) ? 'check-square text-primary' : 'minus-square' ?>"></span>
        <label for="checkbox2">PROMOTION</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
      <span class="fa fa-<?= in_array('TERMINATE PROBATION', $item->recommendations) ? 'check-square text-primary' : 'minus-square' ?>"></span>
        <label for="checkbox3">TERMINATE PROBATION</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
      <span class="fa fa-<?= in_array('SALARY INCREASE', $item->recommendations) ? 'check-square text-primary' : 'minus-square' ?>"></span>
        <label for="checkbox4">SALARY INCREASE</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
      <span class="fa fa-<?= in_array('EXTEND PROBATION', $item->recommendations) ? 'check-square text-primary' : 'minus-square' ?>"></span>
        <label for="checkbox5">EXTEND PROBATION</label>
      </div>
    </div>
  </div>
  </div>
</div>
<script type="text/javascript">
   $(function() {
       $('#example-table').DataTable({
           pageLength: 10,
           //"ajax": 'demo/data/table_data.json',
           /*"columns": [
               { "data": "name" },
               { "data": "office" },
               { "data": "extn" },
               { "data": "start_date" },
               { "data": "salary" }
           ]*/
       });
   })
</script>