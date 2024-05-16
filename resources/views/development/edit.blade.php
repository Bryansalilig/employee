@extends('layout.main')
@include('evaluation.style')
@include('development.style')
@section('content')
<div class="page-heading">
  <h1 class="page-title">Yearly Development</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('team-development') }}"> Yearly Development</a></li>
    <li class="breadcrumb-item">Employee Edit</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <div class="ibox ibox-danger">
        <div class="ibox-body text-center">
          <div class="m-t-20 img-profile">
            <div class="img-circle circle-danger">
              <img src="{{ $employee->profile_img }}" id="profile-img">
            </div>
          </div>
          <h5 class="font-strong m-b-5 m-t-10" id="fullname">{{ $employee->last_name }}, {{ $employee->first_name }}</h5>
          <div class="text-muted m-b-10" id="position">{{ $employee->position_name }}</div>
          <!-- <div class="m-t-10" id="hired_date">{{ \Carbon\Carbon::parse($employee->hired_date)->format('d-M-y') }}</div>
          <div class="text-muted" id="position">Hired Date</div> -->
          <table class="table-bordered table-striped table-competency" id="table-result" width="100%">
            <?php $talent = '';
              switch($item->result->talent) {
                case 'Core': $talent = 'result_core';
                  break;
                case 'Growth': $talent = 'result_growth';
                  break;
                case 'High Talent': $talent = 'result_high';
                  break;
                default: $talent = 'result_develop';
                  break;
              }
            ?>
              <thead>
                  <tr>
                      <th colspan="2">Talent Score</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="result_score">{{ $item->result->score }}</td>
                      <td class="result_talent {{ $talent }}">{{ $item->result->talent }}</td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
       
          <form id="developmentId" method="post" enctype="multipart/form-data" autocomplete="off">
          {{ csrf_field() }}
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" href="#tab-appraisee" data-toggle="tab"><i class="fa fa-user"></i> Evaluation</a>
                </li>
              </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-appraisee">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-bordered table-hover" id="table-guide" cellspacing="0" width="100%">
                    <thead class="accordion-toggle">
                      <tr>
                        <th class="text-center" colspan="3">
                          Scoring Guide
                          <span class="pull-right clickable">
                          <em class="fa fa-toggle-down"></em>
                          </span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="text-center accordion-content" style="display:none">
                      <tr>
                        <td class="bg bg-core">Core</td>
                        <td class="bg bg-growth">Growth</td>
                        <td class="bg bg-high">High Talent</td>
                      </tr>
                      <tr>
                        <td>The competency/skill is observed on an infrequent basis, there is a clear development opportunity here.</td>
                        <td>This competency/skill is observed, please continue to focus on it so that it is observed constantly without exception.</td>
                        <td>This competency/skill is observed on a constant basis; everyone in contact with this person would observe excellence in this area.</td>
                      </tr>
                      <tr>
                        <td>An employee with low potential and high performance who is effective at their role but has likely reached the limit for career potential. These employees can benefit from mentoring to boost performance.</td>
                        <td>An employee with medium potential and high performance who has reached their career potential in the organization and who benefits from delegation.</td>
                        <td> An employee with high potential and high performance who performs consistently and is self-motivated. These employees are typically identified by upper management as having leadership potential within the organization.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12">
                  <table class="table-bordered table-competency" id="table-score">
                  <input type="hidden" name="employee_id" value="<?= $item->id ?>" />
                    <thead>
                      <tr>
                        <th style="width: 100px;" class="text-center">Values</th>
                        <th style="width: 160px;" class="text-center">Description</th>
                        <th style="width: 200px;" class="text-center bg bg-core">Meets</th>
                        <th style="width: 200px;" class="text-center bg bg-growth">Exceeds</th>
                        <th style="width: 200px;" class="text-center bg bg-high">Always Exceeds</th>
                        <th style="width: 200px;" class="text-center">Recommendation to advance</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr>
                      <td class="bg bg-qualities">
                        <input type="hidden" class="rating" name="courtesy-score" value="<?= $item->courtesy->score ?>">
                        <textarea class="remark" name="courtesy-remark" style="display: none;"><?= $item->courtesy->remark ?></textarea>
                        <textarea class="recommendation" name="courtesy-recommendation" rows="5" style="display:none"><?= $item->courtesy->recommendation ?></textarea>
                        Courtesy
                      </td>
                      <td>Carries respect and professionalism to clients, authors, and colleagues at all times. Treats all individuals in eLink with fairness and equality.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->courtesy->score == 1) ? $item->courtesy->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->courtesy->score == 3) ? $item->courtesy->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->courtesy->score == 5) ? $item->courtesy->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->courtesy->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->courtesy->recommendation?>" <?= (empty($item->courtesy->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="ownership-score" value="<?= $item->ownership->score ?>">
                          <textarea class="remark" name="ownership-remark" style="display: none;"><?= $item->ownership->remark ?></textarea>
                          <textarea class="recommendation" name="ownership-recommendation" style="display: none;"><?= $item->ownership->recommendation ?></textarea>
                          Ownership
                      </td>
                      <td>Knows and understands job obligations,  actions, and job roles inside and outside of eLink.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->ownership->score == 1) ? $item->ownership->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->ownership->score == 3) ? $item->ownership->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->ownership->score == 5) ? $item->ownership->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->ownership->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->ownership->recommendation ?>" <?= (empty($item->ownership->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="nurture-score" value="<?= $item->nurture->score ?>">
                        <textarea class="remark" name="nurture-remark" style="display: none;"><?= $item->nurture->remark ?></textarea>
                        <textarea class="recommendation" name="nurture-recommendation" style="display: none;"><?= $item->nurture->recommendation ?></textarea>
                        Nurture
                      </td>
                      <td>Empowers, inspires, motivates, and encourages growth and development, personally and professionally, puts the needs of others first and helps people develop and perform as highly as possible.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->nurture->score == 1) ? $item->nurture->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->nurture->score == 3) ? $item->nurture->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->nurture->score == 5) ? $item->nurture->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->nurture->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->nurture->recommendation ?>" <?= (empty($item->nurture->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="collaboration-score" value="<?= $item->collaboration->score ?>">
                        <textarea class="remark" name="collaboration-remark" style="display: none;"><?= $item->collaboration->remark ?></textarea>
                        <textarea class="recommendation" name="collaboration-recommendation" style="display: none;"><?= $item->collaboration->recommendation ?></textarea>
                        Collaboration
                      </td>
                      <td>Working together and fostering healthy relationships and solving problems to reach eLink goals.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->collaboration->score == 1) ? $item->collaboration->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->collaboration->score == 3) ? $item->collaboration->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->collaboration->score == 5) ? $item->collaboration->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->collaboration->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->collaboration->recommendation ?>" <?= (empty($item->collaboration->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="integrity-score" value="<?= $item->integrity->score ?>">
                        <textarea class="remark" name="integrity-remark" style="display: none;"><?= $item->integrity->remark ?></textarea>
                        <textarea class="recommendation" name="integrity-recommendation" style="display: none;"><?= $item->integrity->recommendation ?></textarea>
                        Integrity
                      </td>
                      <td>Honest and showing uncompromising adherence to strong moral and ethical principles and upholds eLink values.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->integrity->score == 1) ? $item->integrity->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->integrity->score == 3) ? $item->integrity->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->integrity->score == 5) ? $item->integrity->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->integrity->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->integrity->recommendation ?>" <?= (empty($item->integrity->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="seamlessness-score" value="<?= $item->seamlessness->score ?>">
                        <textarea class="remark" name="seamlessness-remark" style="display: none;"><?= $item->seamlessness->remark ?></textarea>
                        <textarea class="recommendation" name="seamlessness-recommendation" style="display: none;"><?= $item->seamlessness->recommendation ?></textarea>
                        Seamlessness
                      </td>
                      <td>Adheres to eLink quality standards, processes, and guidelines to achieve our eLink promise.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->seamlessness->score == 1) ? $item->seamlessness->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->seamlessness->score == 3) ? $item->seamlessness->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->seamlessness->score == 5) ? $item->seamlessness->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->seamlessness->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->seamlessness->recommendation ?>" <?= (empty($item->seamlessness->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="excellence-score" value="<?= $item->excellence->score ?>">
                        <textarea class="remark" name="excellence-remark" style="display: none;"><?= $item->excellence->remark ?></textarea>
                        <textarea class="recommendation" name="excellence-recommendation" style="display: none;"><?= $item->excellence->recommendation ?></textarea>
                        Excellence
                      </td>
                      <td>Strives to do more and be great even if that means making errors along the way. Shows the desire to learn, grow, and evolve to achieve best-in-class service.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->excellence->score == 1) ? $item->excellence->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->excellence->score == 3) ? $item->excellence->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->excellence->score == 5) ? $item->excellence->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->excellence->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->excellence->recommendation ?>" <?= (empty($item->excellence->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-qualities">
                      <input type="hidden" class="rating" name="emotional_intelligence-score" value="<?= $item->emotional_intelligence->score ?>">
                        <textarea class="remark" name="emotional_intelligence-remark" style="display: none;"><?= $item->emotional_intelligence->remark ?></textarea>
                        <textarea class="recommendation" name="emotional_intelligence-recommendation" style="display: none;"><?= $item->emotional_intelligence->recommendation ?></textarea>
                        Emotional Intelligence
                      </td>
                      <td>Ability to perceive, interpret, demonstrate, control, evaluate, and use emotions to communicate with and relate to others effectively and constructively.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->emotional_intelligence->score == 1) ? $item->emotional_intelligence->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->emotional_intelligence->score == 3) ? $item->emotional_intelligence->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->emotional_intelligence->score == 5) ? $item->emotional_intelligence->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->emotional_intelligence->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->emotional_intelligence->recommendation ?>" <?= (empty($item->emotional_intelligence->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-technical">
                      <input type="hidden" class="rating" name="balance-score" value="<?= $item->balance->score ?>">
                        <textarea class="remark" name="balance-remark" style="display: none;"><?= $item->balance->remark ?></textarea>
                        <textarea class="recommendation" name="balance-recommendation" style="display: none;"><?= $item->balance->recommendation ?></textarea>
                        Balance
                      </td>
                      <td>Is flexible, able to plan, know what to prioritize, and reduces distractions to boost focus on tasks.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->balance->score == 1) ? $item->balance->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->balance->score == 3) ? $item->balance->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->balance->score == 5) ? $item->balance->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->balance->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->balance->recommendation ?>" <?= (empty($item->balance->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <tr>
                      <td class="bg bg-technical">
                      <input type="hidden" class="rating" name="brilliance-score" value="<?= $item->brilliance->score ?>">
                        <textarea class="remark" name="brilliance-remark" style="display: none;"><?= $item->brilliance->remark ?></textarea>
                        <textarea class="recommendation" name="brilliance-recommendation" style="display: none;"><?= $item->brilliance->recommendation ?></textarea>
                        Brilliance
                      </td>
                      <td>Ability to learn, adapt, unlearn, and relearn to keep up with constantly changing conditions and teach new knowledge to others.</td>
                      <td data-score="1" class="bg-remark"><?= ($item->brilliance->score == 1) ? $item->brilliance->remark : '' ?></td>
                      <td data-score="3" class="bg-remark"><?= ($item->brilliance->score == 3) ? $item->brilliance->remark : '' ?></td>
                      <td data-score="5" class="bg-remark"><?= ($item->brilliance->score == 5) ? $item->brilliance->remark : '' ?></td>
                      <td class="bg-recommend"><?= $item->brilliance->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $item->brilliance->recommendation ?>" <?= (empty($item->brilliance->recommendation)) ? 'required' : '' ?>></textarea></td>
                    </tr>
                    <?php $i = 0; ?>
                    <?php foreach($item->others as $key=>$custom) { ?>
                        <tr style="height: 100px;">
                            <td class="bg bg-technical">
                                <input type="hidden" name="others-role[<?= $i ?>]" value="<?= $custom->role ?>">
                                <input type="hidden" name="others-description[<?= $i ?>]" value="<?= $custom->description ?>">
                                <input type="hidden" class="rating" name="others-score[<?= $i ?>]" value="<?= $custom->score ?>">
                                <textarea class="remark" name="others-remark[<?= $i ?>]" style="display: none;"><?= $custom->remark ?></textarea>
                                <textarea class="recommendation" name="others-recommendation[<?= $i ?>]" style="display: none;"><?= $custom->recommendation ?></textarea>
                                <span class="fa fa-remove close btn btn-danger"></span>
                                <?= $custom->role ?>
                            </td>
                            <td><?= $custom->description ?></td>
                            <td data-score="1" class="bg-remark"><?= ($custom->score == 1) ? $custom->remark : '' ?></td>
                            <td data-score="3" class="bg-remark"><?= ($custom->score == 3) ? $custom->remark : '' ?></td>
                            <td data-score="5" class="bg-remark"><?= ($custom->score == 5) ? $custom->remark : '' ?></td>
                            <td class="bg-recommend"><?= $custom->recommendation ?><textarea class="form-control recommendation d-none" rows="5" value="<?= $custom->recommendation ?>" <?= (empty($custom->recommendation)) ? 'required' : '' ?>></textarea></td>
                        </tr>
                    <?php } ?>
                    <?php $i++; ?>
                      <tr id="row-entry"></tr>
                    </tbody>
                  </table>
                  <hr>
                  <br>
                  <div class="row text-center">
                    <div class="col-md-3">
                      <div class="form-group">
                        <strong>Custom Role</strong>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group">
                        <strong>Role Description</strong>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group" style="margin:0;">
                        <input type="text" class="form-control" name="role-name" placeholder="Role-specific 1" />
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group" style="margin:0;">
                        <input type="text" class="form-control" name="role-description" placeholder="Role-specific 1 description..." />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group" style="margin:0;">
                        <button class="btn btn-primary btn-add">
                        <span class="fa fa-plus"></span>
                        </button>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <h4 class="text-center font-bold" style="margin: 0 auto 15px;font-size: 17px;">Remember your GOALS must be SMART - SPECIFIC. MEASURABLE. ACHIEVABLE. RELEVANT. TIME-BASED</h4>
                      <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 50%;">Previous Goals</th>
                            <th class="text-center" style="width: 50%;">New Goals</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                          <td>
                              <textarea class="form-control" name="previous" rows="5" placeholder="Previous Goals" required><?= $item->goal->previous ?></textarea>
                          </td>
                          <td>
                              <textarea class="form-control" name="new" rows="5" placeholder="New Goals" required><?= $item->goal->new ?></textarea>
                          </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group text-right m-t-20">
              <input type="hidden" name="result-score" value="<?= $item->result->score ?>">
              <input type="hidden" name="result-talent" value="<?= $item->result->talent ?>">
              <input type="hidden" name="result-recommendation" value="<?= $item->result->recommendation ?>">
              <?php if($item->draft){?>
                <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development/update-draft') ?>">Draft</button>
                <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development/submit-draft') ?>">Submit</button>
              <?php } else {?>
                <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development/update') ?>">Update</button>
              <?php } ?>
              </div>
                    </div>
                </div>
              </div>
              </div>
            </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@include('development.script')
<script>
   $('.btn-tab').click(function (e) {
  e.preventDefault();

  var obj = $(this);
  var tab = obj.closest('.tab-pane');

  if (obj.text() === 'Submit') {
    var allFieldsFilled = true;
    var $requiredTextareas = $('textarea[required]');

    // Variable to store a reference to the first empty required textarea
    var $firstEmptyTextarea = null;

    $requiredTextareas.each(function () {
      if ($(this).val() === '' && $firstEmptyTextarea === null) {
        allFieldsFilled = false;
        // Store a reference to the first empty required textarea
        $firstEmptyTextarea = $(this);
      }

      if ($(this).val() === '') {
        $(this).css('border-color', 'red');
        $(this).removeClass('d-none').addClass('d-show');

        // Attach blur event handler
        $(this).on('blur', function () {
          if ($(this).val() !== '') {
            var inputValue = $(this).val();
            $(this).closest('tr').find('.recommendation').val(inputValue);

            $(this).closest('tr').find('.form-control.recommendation').val(inputValue);

            $(this).parent('td').text(inputValue);

            // Hide the textarea
            $(this).addClass('d-none').removeClass('d-show');
          }
        });
      }
    });

    if (!allFieldsFilled) {
      if ($firstEmptyTextarea !== null) {
        $firstEmptyTextarea.focus();
      }
      alert('Please fill out all required fields.');
    } else {
      // Get the data-action attribute value
      var actionUrl = $(this).data('action');

      // Assuming you have a form with the ID 'yourFormId'
      var $form = $('#developmentId');

      // Set the form action attribute dynamically
      $form.attr('action', actionUrl);

      // Submit the form
      $form.submit();
    }
  } else if (obj.text() === 'Draft') {
    // Get the data-action attribute value
    var actionUrl = $(this).data('action');

    var $form = $('#developmentId');

    $form.attr('action', actionUrl);

    $form.submit();
  } else if (obj.text() === 'Update') {
    // Get the data-action attribute value
    var actionUrl = $(this).data('action');

    var $form = $('#developmentId');

    $form.attr('action', actionUrl);

    $form.submit();
  }
});
</script>
@endsection