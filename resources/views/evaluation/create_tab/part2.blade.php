<div class="row">
  <div class="col-md-12" style="border-right: 1px solid #eee;">
    <h3><b>DEVELOPMENTAL AND TRAINING NEEDS</b></h3>
    <p class="text-default m-b-10 m-t-10">
     • (List at least 2 competencies that the employee needs to improve)
    </p>
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
    <div class="row row-entry">
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control" name="needs[]" required>
                    <option value="">Select</option>
                    <option value="job knowledge">Job Knowledge</option>
                    <option value="dependability">Dependability</option>
                    <option value="problem solving">Problem Solving</option>
                    <option value="efficiency">Efficiency</option>
                    <option value="work attitude">Work Attitude</option>
                    <option value="initiative">Initiative</option>
                    <option value="attendance">Attendance</option>
                    <option value="cooperation">Cooperation</option>
                    <option value="pro activeness">Pro Activeness</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control" name="activity[]" placeholder="Activity" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control" name="reason[]" placeholder="Reason" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <button class="btn btn-primary btn-add">
                    <span class="fa fa-plus"></span>
                </button>
            </div>
        </div>
    </div>
</div>

    <div class="form-group text-right m-t-20">
      <button class="btn btn-default btn-tab" data-tab="competency">Previous</button>
      <button class="btn btn-info btn-tab" data-tab="suggestion" id="next">Next</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function () {
  function listCompetenciesToImprove() {
    if ($('input[name="affixed_name"]').length <= 0) {
      // Check if at least 2 competencies are selected
      if ($('select[name="needs[]"]').length < 2) {
        $('#next').attr('data-tab', 'Invalid');
        alert('Developmental and Training Need\n Requires at least 2 competencies');
        return false;
      }
    }
    $('a[href="#tab-suggestion"]').css({
      'pointer-events': 'auto'
    }).removeClass('inactive').click();
  }

  function validateForm() {
    var allFieldsValid = true;

    $('select[required]').each(function () {
      if ($(this).val().trim() === '') {
        allFieldsValid = false;
        return false; // exit the loop early if a required field is empty
      }
    });

    if (allFieldsValid) {
      // Call listCompetenciesToImprove only if validation passes
      listCompetenciesToImprove();
    }
  }

  // Attach the function to the button click event outside the validateForm function
  $('#next').on('click', function () {
    validateForm();
  });

  $('.btn-add').click(function (e) {
    e.preventDefault();
    $('#next').attr('data-tab', 'suggestion');
    var obj = $(this),
      parent = obj.closest('.entry-content'),
      entry = parent.find('.row-entry:first'),
      entry_last = parent.find('.row-entry:last');

    var new_entry = entry.clone().insertAfter(entry_last);
    new_entry.find('.btn-add').html('<span class="fa fa-minus"></span>');
    new_entry.find('.btn-add').removeClass('btn-primary').addClass('btn-danger');
    new_entry.find('.btn-add').removeClass('btn-add').addClass('btn-remove');
    new_entry.find('input').val('');
    new_entry.find('textarea').val('');
    new_entry.find('.btn-remove').click(function (e) {
      e.preventDefault();
      $(this).closest('.row-entry').remove();
    });
  });

  $('.btn-remove').click(function (e) {
    e.preventDefault();
    $(this).closest('.row-entry').remove();
  });
});
</script>