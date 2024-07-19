<div class="row">
  <div class="col-12">
    <table class="table table-striped table-hover" id="table-planned">
      <thead>
        <tr>
          <th>(Planned) Leave Date</th>
          <th>Length</th>
          <th>With/Without Pay</th>
          <th width="90px">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <input type="text" class="form-control mdateplanned" name="planned_date[]" placeholder="YYYY-MM-DD" data-label="Leave Date">
          </td>
          <td>
            <select class="form-control select-length" name="planned_length[]" required>
              <option value="1">Whole Day</option>
              <option value="0.5">Half Day</option>
            </select>
          </td>
          <td>
            <select class="form-control select-pay-type" name="planned_pay_type[]" required>
              <option value="0">Without Pay</option>
              <option value="1">With Pay</option>
            </select>
          </td>
          <td>
            <button class="btn btn-primary btn-block btn-add-planned"><span class="fa fa-plus"></span></button>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-striped table-hover d-none" id="table-unplanned">
      <thead>
        <tr>
          <th>(Unplanned) Leave Date</th>
          <th>Length</th>
          <th>With/Without Pay</th>
          <th width="90px">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <input type="text" class="form-control mdateunplanned" name="unplanned_date[]" placeholder="YYYY-MM-DD" data-label="Leave Date">
          </td>
          <td>
            <select class="form-control select-length" name="unplanned_length[]" required>
              <option value="1">Whole Day</option>
              <option value="0.5">Half Day</option>
            </select>
          </td>
          <td>
            <select class="form-control select-pay-type" name="unplanned_pay_type[]" required>
              <option value="0">Without Pay</option>
              <option value="1">With Pay</option>
            </select>
          </td>
          <td>
            <button class="btn btn-primary btn-block btn-add-unplanned"><span class="fa fa-plus"></span></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('.mdateplanned').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', minDate: new Date('<?= date('Y-m-d', strtotime('+14 days')) ?>'), time: false, clearButton: true });

  $('.btn-add-planned').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var parent = obj.closest('tbody');
    var entry = parent.find('tr:first');
    var entry_last = parent.find('tr:last');

    var new_entry = entry.clone().insertAfter(entry_last);

    new_entry.find('.btn-add-planned').html('<span class="fa fa-remove"></span>');
    new_entry.find('.btn-add-planned').removeClass('btn-primary').addClass('btn-danger');
    new_entry.find('.btn-add-planned').removeClass('btn-add-planned').addClass('btn-remove-planned');
    new_entry.find('input').val('');
    new_entry.find('.btn-remove-planned').click(function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
    });
    new_entry.find('.mdateplanned').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', minDate: new Date('<?= date('Y-m-d', strtotime('+14 days')) ?>'), time: false, clearButton: true });
  });

  $('.btn-remove-planned').click(function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
  });

  $('.mdateunplanned').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', time: false, clearButton: true });


  $('.btn-add-unplanned').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var parent = obj.closest('tbody');
    var entry = parent.find('tr:first');
    var entry_last = parent.find('tr:last');

    var new_entry = entry.clone().insertAfter(entry_last);

    new_entry.find('.btn-add-unplanned').html('<span class="fa fa-remove"></span>');
    new_entry.find('.btn-add-unplanned').removeClass('btn-primary').addClass('btn-danger');
    new_entry.find('.btn-add-unplanned').removeClass('btn-add-unplanned').addClass('btn-remove-unplanned');
    new_entry.find('input').val('');
    new_entry.find('.btn-remove-unplanned').click(function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
    });
    new_entry.find('.mdateunplanned').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', time: false, clearButton: true });
  });
});
</script>
