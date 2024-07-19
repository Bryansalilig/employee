<div class="ibox">
  <div class="ibox-body">
    <ul class="nav nav-tabs tabs-line nav-fill">
      <li class="nav-item">
        <a class="nav-link active" href="#tab-employee" data-toggle="tab"><i class="fa fa-user"></i> Employee</a>
      </li>
      <li class="nav-item">
        <a class="nav-link inactive" href="#tab-type" data-toggle="tab"><i class="fa fa-plane"></i> Leave Type</a>
      </li>
      <li class="nav-item">
        <a class="nav-link inactive" href="#tab-dates" data-toggle="tab"><i class="fa fa-calendar"></i> Leave Dates</a>
      </li>
      <li class="nav-item">
        <a class="nav-link inactive" href="#tab-others" data-toggle="tab"><i class="fa fa-paragraph"></i> Others</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="tab-employee">
        @include('leave.create.tab.employee')
      </div>
      <div class="tab-pane fade" id="tab-type">
        @include('leave.create.tab.type')
      </div>
      <div class="tab-pane fade" id="tab-dates">
        @include('leave.create.tab.dates')
      </div>
      <div class="tab-pane fade" id="tab-others">
        @include('leave.create.tab.others')
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('a.nav-link').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var tab = obj.attr('href').replace("#tab-", "");

    $('[id^="button"]').each(function() {
      $(this).addClass('d-none');
    });

    $('#button-' + tab).removeClass('d-none');
  });
});
</script>
