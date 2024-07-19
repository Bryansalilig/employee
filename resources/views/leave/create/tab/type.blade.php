<div class="row">
  <div class="col-sm-6 col-12 form-group">
    <label>Leave Category <span class="text-danger">*</span></label>
    <select class="form-control" id="pay_type_id" name="pay_type_id" required>
      <option value="1">Planned</option>
      <option value="2">Unplanned</option>
    </select>
  </div>
  <div class="col-sm-6 col-12 form-group">
    <label>Type of Leave</label>
    <select class="form-control" id="leave_type_id" name="leave_type_id" required>
    @foreach($leave_types as $lv)
      @if(Auth::user()->getLinkees() > 0)
        <option value="<?= $lv->id ?>" data-category="<?= $lv->status ?>"><?= $lv->leave_type_name ?></option>
      @else
        <option value="<?= $lv->id ?>" data-category="<?= $lv->status ?>"><?= $lv->leave_type_name ?></option>
      @endif
     @endforeach
    </select>
  </div>
</div>

<script type="text/javascript">
$(function() {
  var types = $('#leave_type_id option').clone();

  $('#pay_type_id').change(function(e) {
    e.preventDefault();

    var obj = $(this);
    var value = $(this).val();
    var filter = types.filter(function() { return $(this).data('category') == value; });

    $('#tab-dates').find('input').val('').removeAttr('required');
    $('#tab-dates').find('.select-length').val(1);
    $('#tab-dates').find('.select-pay-type').val(0);

    if (value == 1) {
      $('#table-planned').removeClass('d-none');
      $('#table-unplanned').addClass('d-none');

      $('#table-planned tbody tr:gt(0)').remove();
      $('#table-planned').find('input').attr('required', true);
    } else {
      $('#table-planned').addClass('d-none');
      $('#table-unplanned').removeClass('d-none');

      $('#table-unplanned tbody tr:gt(0)').remove();
      $('#table-unplanned').find('input').attr('required', true);
    }

    $('#leave_type_id').empty().append(filter);
  });

  $('#pay_type_id').trigger('change');
});
</script>
