<form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
{{ csrf_field() }}
  <div class="ibox">
    <div class="ibox-body">
      <form>
        <ul class="nav nav-tabs tabs-line">
          <li class="nav-item">
            <a class="nav-link active" href="#tab-basic-info" data-toggle="tab"><i class="fa fa-user"></i> Basic Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-family" data-toggle="tab"><i class="fa fa-users"></i> Family Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-dependents" data-toggle="tab"><i class="fa fa-user-plus"></i> Dependents</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-emergency" data-toggle="tab"><i class="fa fa-medkit"></i> Emergency</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-job" data-toggle="tab"><i class="fa fa-building-o"></i> Job Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-government" data-toggle="tab"><i class="fa fa-university"></i> Government</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-login" data-toggle="tab"><i class="fa fa-key"></i> Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link inactive" href="#tab-photo" data-toggle="tab"><i class="fa fa-file-image-o"></i> Photo</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-basic-info">
            @include('employee.create.tab.basic')
          </div>
          <div class="tab-pane fade" id="tab-family">
            @include('employee.create.tab.family')
          </div>
          <div class="tab-pane fade" id="tab-dependents">
            @include('employee.create.tab.dependents')
          </div>
          <div class="tab-pane fade" id="tab-emergency">
            @include('employee.create.tab.emergency')
          </div>
          <div class="tab-pane fade" id="tab-job">
            @include('employee.create.tab.job')
          </div>
          <div class="tab-pane fade" id="tab-government">
            @include('employee.create.tab.government')
          </div>
          <div class="tab-pane fade" id="tab-login">
            @include('employee.create.tab.login')
          </div>
          <div class="tab-pane fade" id="tab-photo">
            @include('employee.create.tab.photo')
          </div>
        </div>
      </form>
    </div>
  </div>
</form>

<script type="text/javascript">
$(function() {
  $('.btn-tab').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var tab = obj.closest('.tab-pane');

    if (obj.text() === 'Next' && !$.requestHandler.checkRequirement(obj.closest('.tab-pane'))) return false;

    $('a[href="#tab-' + obj.data('tab') + '"]').css({'pointer-events':'auto'}).removeClass('inactive').click();
    $('a[href="#' + tab.attr('id') + '"]').css({'pointer-events':'auto'});
  });
});
</script>
