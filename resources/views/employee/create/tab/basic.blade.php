<div class="row">
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>First Name <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Middle Name</label>
    <input class="form-control" type="text" name="middle_name" placeholder="Middle Name">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Last Name <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Employee ID <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="eid" id="eid" placeholder="ESCC-xxxxxxx" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Phone Name</label>
    <input class="form-control" type="text" name="alias" placeholder="Phone Name">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Birthdate <span class="text-danger">*</span></label>
    <input class="form-control mdate" type="text" name="birth_date" placeholder="YYYY-MM-DD" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Contact Number</label>
    <input class="form-control" type="text" name="contact_number" placeholder="xxxx-xxx-xxxx">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Gender <span class="text-danger">*</span></label>
    <select class="form-control" name="gender_id" id="gender_id" required>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Civil Status <span class="text-danger">*</span></label>
    <select class="form-control" name="civil_status" required>
      <option value="1">Single</option>
      <option value="2">Married</option>
      <option value="3">Separated</option>
      <option value="4">Anulled</option>
      <option value="5">Divorced</option>
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Avega Number</label>
    <input class="form-control" type="text" name="avega_num" placeholder="xx-xx-xxxxx-xxxxx-xx">
  </div>
</div>
<div class="row">
  <div class="col-md-6 col-12 form-group">
    <label>City Address</label>
    <textarea name="address" class="form-control" rows="4"></textarea>
  </div>
  <div class="col-md-6 col-12 form-group">
    <label>Home Town Address</label>
    <textarea name="town_address" class="form-control" rows="4"></textarea>
  </div>
</div>
<div class="form-group text-right">
  <button class="btn btn-info" data-tab="family" id="btn-basic">Next</button>
</div>

<script type="text/javascript">
$(function() {
  $('#gender_id').change(function(e) {
    e.preventDefault();

    if($('#image_url').val() !== '') return false;

    if($(this).val() == 1) {
      $('.img-circle').css({'background-image' : 'url(\'{{ URL::to("img/nobody_m.original.jpg") }}\')'});
    } else {
      $('.img-circle').css({'background-image' : 'url(\'{{ URL::to("img/nobody_f.original.jpg") }}\')'});
    }
  });

  $('#btn-basic').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var tab = obj.closest('.tab-pane');

    if (obj.text() === 'Next' && !$.requestHandler.checkRequirement(obj.closest('.tab-pane'))) return false;

    $.get("{{ route('employee.duplicate') }}", { 'field' : 'eid', value : $('#eid').val() }, function(data) {
      if(data.ret) {
        $('a[href="#tab-' + obj.data('tab') + '"]').css({'pointer-events':'auto'}).removeClass('inactive').click();
        $('a[href="#' + tab.attr('id') + '"]').css({'pointer-events':'auto'});
        $('#eid').removeClass('border-warning');
      } else {
        $.messageHandler.customMessage('warning', data.msg);
        $('#eid').addClass('border-warning');
      }
    });
  });
});
</script>
