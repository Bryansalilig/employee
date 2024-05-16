<div class="row">
  <div class="col-md-12">
    <table class="table table-striped table-bordered table-hover" id="table-guide" cellspacing="0" width="100%">
      <thead class="accordion-toggle">
        <tr>
          <th class="text-center" colspan="3">
            <b>Scoring Guide</b>
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
    <input type="hidden" name="employee_id" value="<?= $id ?>" />
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
            <input type="hidden" class="rating" name="courtesy-score" value="0">
            <textarea class="remark" name="courtesy-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="courtesy-recommendation" rows="5" style="display:none"></textarea>
            Courtesy
          </td>
          <td>Carries respect and professionalism to clients, authors, and colleagues at all times. Treats all individuals in eLink with fairness and equality.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="ownership-score" value="0">
            <textarea class="remark" name="ownership-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="ownership-recommendation" rows="5" style="display:none"></textarea>
            Ownership
          </td>
          <td>Knows and understands job obligations,  actions, and job roles inside and outside of eLink.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="nurture-score" value="0">
            <textarea class="remark" name="nurture-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="nurture-recommendation" rows="5" style="display:none"></textarea>
            Nurture
          </td>
          <td>Empowers, inspires, motivates, and encourages growth and development, personally and professionally, puts the needs of others first and helps people develop and perform as highly as possible.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="collaboration-score" value="0">
            <textarea class="remark" name="collaboration-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="collaboration-recommendation" rows="5" style="display:none"></textarea>
            Collaboration
          </td>
          <td>Working together and fostering healthy relationships and solving problems to reach eLink goals.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"> <textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="integrity-score" value="0">
            <textarea class="remark" name="integrity-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="integrity-recommendation" rows="5" style="display:none"></textarea>
            Integrity
          </td>
          <td>Honest and showing uncompromising adherence to strong moral and ethical principles and upholds eLink values.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="seamlessness-score" value="0">
            <textarea class="remark" name="seamlessness-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="seamlessness-recommendation" rows="5" style="display:none"></textarea>
            Seamlessness
          </td>
          <td>Adheres to eLink quality standards, processes, and guidelines to achieve our eLink promise.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="excellence-score" value="0">
            <textarea class="remark" name="excellence-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="excellence-recommendation" rows="5" style="display:none"></textarea>
            Excellence
          </td>
          <td>Strives to do more and be great even if that means making errors along the way. Shows the desire to learn, grow, and evolve to achieve best-in-class service.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-qualities">
            <input type="hidden" class="rating" name="emotional_intelligence-score" value="0">
            <textarea class="remark" name="emotional_intelligence-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="emotional_intelligence-recommendation" rows="5" style="display:none"></textarea>
            Emotional Intelligence
          </td>
          <td>Ability to perceive, interpret, demonstrate, control, evaluate, and use emotions to communicate with and relate to others effectively and constructively.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-technical">
            <input type="hidden" class="rating" name="balance-score" value="0">
            <textarea class="remark" name="balance-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="balance-recommendation" rows="5" style="display:none"></textarea>
            Balance
          </td>
          <td>Is flexible, able to plan, know what to prioritize, and reduces distractions to boost focus on tasks.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
        <tr>
          <td class="bg bg-technical">
            <input type="hidden" class="rating" name="brilliance-score" value="0">
            <textarea class="remark" name="brilliance-remark" style="display: none;"></textarea>
            <textarea class="recommendation" name="brilliance-recommendation" rows="5" style="display:none"></textarea>
            Brilliance
          </td>
          <td>Ability to learn, adapt, unlearn, and relearn to keep up with constantly changing conditions and teach new knowledge to others.</td>
          <td data-score="1" class="bg-remark"></td>
          <td data-score="3" class="bg-remark"></td>
          <td data-score="5" class="bg-remark"></td>
          <td class="bg-recommend"><textarea class="form-control recommendation d-none" rows="5" required></textarea></td>
        </tr>
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
                <textarea class="form-control" name="previous" rows="5" required></textarea>
              </td>
              <td>
                <textarea class="form-control" name="new" rows="5" required></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="form-group text-right m-t-20">
  <input type="hidden" name="result-score" value="0">
  <input type="hidden" name="result-talent" value="To Develop">
  <input type="hidden" name="result-recommendation" value="Not Ready">
  <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development/draft') ?>">Draft</button>
  <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development') ?>">Submit</button>
</div>
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
  }
});
</script>
@endsection