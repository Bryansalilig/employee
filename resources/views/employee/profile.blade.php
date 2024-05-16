@extends('layout.main')
@section('style')
<style>
.img-circle{
  width: 100%;
  border: 4px solid #87ceeb;
  background-size: cover;
  background-position: center;
  aspect-ratio: 1 / 1;
}

select, .select2 {
  width: 100% !important;
  height: auto !important;
}

a.media-img .img-circle{
  width: 40px;
  border: 1px solid #87ceeb;
}

div.media-img .img-circle{
  width: 60px;
  border: 1px solid #87ceeb;
}

.profile-social a {
  font-size: 16px;
  margin: 0 10px;
  color: #999;
}

.profile-social a:hover {
  color: #485b6f;
}

.profile-stat-count {
  font-size: 22px
}
</style>
@endsection
@section('content')
<div class="page-heading">
  <h1 class="page-title">Profile</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ url('employees') }}">Active Employees</a></li>
    <li class="breadcrumb-item">Employee Profile</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <div class="ibox">
        <div class="ibox-body text-center">
          <div class="m-t-20">
            <div class="img-circle" style="background-image: url('{{ $employee->profile_img }}');"></div>
          </div>
          <h5 class="font-strong m-b-10 m-t-10">{{ ucwords(strtolower($employee->fullname2())) }}</h5>
          <div class="text-muted">{{ $employee->position_name }}</div>
          <div class="m-b-20 text-muted">{{ $employee->team_name }}</div>
          <div class="profile-social m-b-20">
            @php
            function getEmail($email) {
              $icon = 'envelope-open';
              $title = 'Outlook';
              if (strpos($email, 'gmail.com') !== false) {
                $icon = 'google';
                $title = 'GMail';
              } elseif (strpos($email, 'yahoo.com') !== false) {
                $icon = 'yahoo';
                $title = 'Yahoo';
              }

              return array('icon'=>$icon, 'title'=>$title);
            }
            @endphp
            <a href="mailto::{{ $employee->email }}" title="Business Email"><i class="fa fa-envelope-open"></i></a>
            @if($employee->email2)
            <a href="mailto::{{ $employee->email2 }}" title="{{ getEmail($employee->email2)['title'] }}"><i class="fa fa-{{ getEmail($employee->email2)['icon'] }}"></i></a>
            @endif
            @if($employee->email3)
            <a href="mailto::{{ $employee->email3 }}" title="{{ getEmail($employee->email3)['title'] }}"><i class="fa fa-{{ getEmail($employee->email3)['icon'] }}"></i></a>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
          <ul class="nav nav-tabs tabs-line">
            @php
              $tab = 'overview';
              if(session('employee')) { $tab = 'employee'; }
              if(session('job')) { $tab = 'job'; }
            @endphp
            <li class="nav-item">
              <a class="nav-link {{ ($tab == 'overview') ? 'active' : '' }}" href="#tab-overview" data-toggle="tab"><i class="ti-bar-chart"></i> Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ ($tab == 'employee') ? 'active' : '' }}" href="#tab-employee-info" data-toggle="tab"><i class="ti-id-badge"></i> Employee Info</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ ($tab == 'job') ? 'active' : '' }}" href="#tab-job-info" data-toggle="tab"><i class="ti-briefcase"></i> Job Info</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tab-log" data-toggle="tab"><i class="ti-notepad"></i> Log</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tab-movement" data-toggle="tab"><i class="ti-exchange-vertical"></i> Movement</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade {{ ($tab == 'overview') ? 'show active' : '' }}" id="tab-overview">
              @include('employee.tab.overview')
            </div>
            <div class="tab-pane fade {{ ($tab == 'employee') ? 'show active' : '' }}" id="tab-employee-info">
              @include('employee.tab.employee')
            </div>
            <div class="tab-pane fade {{ ($tab == 'job') ? 'show active' : '' }}" id="tab-job-info">
              @include('employee.tab.job')
            </div>
            <div class="tab-pane fade" id="tab-log">
              @include('employee.tab.log')
            </div>
            <div class="tab-pane fade" id="tab-movement">
              @include('employee.tab.movement')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(function() {
  $('.select2').select2();
  $('.mdate').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', maxDate: new Date(), time: false, clearButton: true });

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
@endsection
