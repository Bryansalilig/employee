@extends('layout.main')
@include('evaluation.style')
@section('content')
<div class="page-heading">
  <h1 class="page-title">Performance Evaluation</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('team-evaluation') }}">Team Evaluation</a></li>
    <li class="breadcrumb-item">Performance Appraisal</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <div class="ibox ibox-danger">
        <div class="ibox-body text-center">
          <div class="m-t-20 img-profile">
            <div class="img-circle circle-danger">
              <!-- <img src="{{ asset($employee->profile_img) }}" id="profile-img"> -->
              <img src="" alt="" srcset="" id="profile-img">
            </div>
          </div>
          <h5 class="font-strong m-b-10 m-t-10" id="fullname">{{ $employee->last_name }}, {{ $employee->first_name }}</h5>
          <div class="text-muted" id="position">{{ $employee->position_name }}</div>
          <div class="m-b-20 text-muted" id="department">{{ $employee->team_name }}</div>
          <span class="btn btn-danger btn-block" style="font-size:18px"><b></b></span>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" href="#tab-overview" data-toggle="tab"><i class="fa fa-address-card-o" aria-hidden="true"></i> Overview</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tab-breakdown" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Breakdown</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tab-update" data-toggle="tab"><i class="fa fa-pencil" aria-hidden="true"></i> Update</a>
                </li>
              </ul>
            <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-overview">
              @include('evaluation.show_tab.overview')
            </div>
            <div class="tab-pane fade" id="tab-breakdown">
              @include('evaluation.show_tab.breakdown')
            </div>
            <div class="tab-pane fade" id="tab-update">
            <form action="{{ route('evaluation.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            @include('evaluation.show_tab.update')
            </form>
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type = "text/javascript">  
  $(function() {
  $('.btn-tabs').click(function(e) {
   e.preventDefault();
  
   var obj = $(this);
   var tab = obj.closest('.tab-pane');
  
  //  if (obj.text() === 'Next' && !$.requestHandler.checkRequirement(obj.closest('.tab-pane'))) return false;
  
   $('a[href="#tab-' + obj.data('tab') + '"]').css({'pointer-events':'auto'}).removeClass('inactive').click();
   $('a[href="#' + tab.attr('id') + '"]').css({'pointer-events':'auto'});
  });
  });
</script>
@endsection