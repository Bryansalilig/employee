<div class="row" id="button-employee">
  <div class="col-sm-12 text-right">
    <button class="btn btn-info btn-rounded btn-next" type="button" data-tab="type">Next &nbsp;<span class="fa fa-caret-right"></span></button>
  </div>
</div>
<div class="row d-none" id="button-type">
  <div class="col-sm-12 text-right">
    <button class="btn btn-info btn-rounded btn-prev" type="button" data-tab="employee"><span class="fa fa-caret-left"></span>&nbsp; Prev</button>
    <button class="btn btn-info btn-rounded btn-next" type="button" data-tab="dates" data-pane="type">Next &nbsp;<span class="fa fa-caret-right"></span></button>
  </div>
</div>
<div class="row d-none" id="button-dates">
  <div class="col-sm-12 text-right">
    <button class="btn btn-info btn-rounded btn-prev" type="button" data-tab="type"><span class="fa fa-caret-left"></span>&nbsp; Prev</button>
    <button class="btn btn-info btn-rounded btn-next" type="button" data-tab="others" data-pane="dates">Next &nbsp;<span class="fa fa-caret-right"></span></button>
  </div>
</div>
<div class="row d-none" id="button-others">
  <div class="col-sm-12 text-right">
    <button class="btn btn-info btn-rounded btn-prev" type="button" data-tab="dates"><span class="fa fa-caret-left"></span>&nbsp; Prev</button>
    <button class="btn btn-info btn-rounded btn-submit" type="submit"><span class="fa fa-floppy-o"></span>&nbsp; Submit</button>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('.btn-prev').click(function(e) {
    e.preventDefault();

    var obj = $(this);

    $('a[href="#tab-' + obj.data('tab') + '"]').click();
  });

  $('.btn-next').click(function(e) {
    e.preventDefault();

    var obj = $(this);

    if (!$.requestHandler.checkRequirement($('#tab-' + obj.data('pane')))) return false;

    $('a[href="#tab-' + obj.data('tab') + '"]').css({'pointer-events':'auto'}).removeClass('inactive').click();
    $('a[href="#' + obj.data('pane') + '"]').css({'pointer-events':'auto'});
  });
});
</script>
