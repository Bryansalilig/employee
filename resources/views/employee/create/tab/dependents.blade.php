<div class="row">
  <div class="col-12">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Dependents Name</th>
          <th>Birthday</th>
          <th>Generali Number</th>
          <th width="90px">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <input type="text" class="form-control" name="dependent_name[]" placeholder="Dependent's Name">
          </td>
          <td>
            <input type="text" class="form-control mdate" name="dependent_bday[]" placeholder="YYYY-MM-DD">
          </td>
          <td>
            <input type="text" class="form-control" name="generali_num[]" placeholder="xxxx-xxx-xxxx">
          </td>
          <td>
            <button class="btn btn-primary btn-block btn-add-dependent"><span class="fa fa-plus"></span></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="form-group text-right">
  <button class="btn btn-default btn-tab" data-tab="family">Previous</button>
  <button class="btn btn-info btn-tab" data-tab="emergency">Next</button>
</div>

<script type="text/javascript">
$(function() {
  $('.btn-add-dependent').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var parent = obj.closest('tbody');
    var entry = parent.find('tr:first');
    var entry_last = parent.find('tr:last');

    var new_entry = entry.clone().insertAfter(entry_last);

    new_entry.find('.btn-add-dependent').html('<span class="fa fa-remove"></span>');
    new_entry.find('.btn-add-dependent').removeClass('btn-primary').addClass('btn-danger');
    new_entry.find('.btn-add-dependent').removeClass('btn-add-dependent').addClass('btn-remove-dependent');
    new_entry.find('input').val('');
    new_entry.find('.btn-remove-dependent').click(function(e) {
      e.preventDefault();
      $(this).closest('tr').remove();
    });
    new_entry.find('.mdate').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', maxDate: new Date(), time: false, clearButton: true });
  });

  $('.btn-remove-dependent').click(function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
  });
});
</script>
