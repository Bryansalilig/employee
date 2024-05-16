<div class="row">
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Company Email <span class="text-danger">*</span></label>
    <input class="form-control" type="email" name="email" id="email" placeholder="email@elink.com.ph" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Personal Email</label>
    <input class="form-control" type="email" name="email2" placeholder="personal@email.com">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Secondary Email</label>
    <input class="form-control" type="email" name="email3" placeholder="secondary@email.com">
  </div>
</div>
<div class="form-group text-right">
  <button class="btn btn-default btn-tab" data-tab="government">Previous</button>
  <button class="btn btn-info" data-tab="photo" id="btn-login">Next</button>
</div>

<script type="text/javascript">
$(function() {
  $('#btn-login').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var tab = obj.closest('.tab-pane');

    if (obj.text() === 'Next' && !$.requestHandler.checkRequirement(obj.closest('.tab-pane'))) return false;

    $.get("{{ route('employee.duplicate') }}", { 'field' : 'email', value : $('#email').val() }, function(data) {
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
