@extends('layout.main')
@include('evaluation.style')
@section('content')
<div class="page-heading">
  <h1 class="page-title">Performance Evaluation</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
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
              <img id="profile-img">
            </div>
          </div>
          <h5 class="font-strong m-b-10 m-t-10" id="fullname"></h5>
          <div class="text-muted" id="position"></div>
          <div class="m-b-20 text-muted" id="department"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
          <form action="{{ route('evaluation.store') }}" id="createId" method="post" enctype="multipart/form-data" autocomplete="off">
          {{ csrf_field() }}
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" style="pointer-events: none;" href="#tab-appraisee" data-toggle="tab"><i class="fa fa-user"></i> Appraisee</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link inactive" style="pointer-events: none;" href="#tab-competency" data-toggle="tab"><i class="fa fa-users"></i> Part I</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link inactive" style="pointer-events: none;" href="#tab-needs" data-toggle="tab"><i class="fa fa-user-plus"></i> Part II</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link inactive" style="pointer-events: none;" href="#tab-suggestion" data-toggle="tab"><i class="fa fa-medkit"></i> Part III</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link inactive" style="pointer-events: none;" href="#tab-recommendation" data-toggle="tab"><i class="fa fa-building-o"></i> Part IV</a>
                </li>
              </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-appraisee">
                @include('evaluation.create_tab.appraisal')
              </div>
              <div class="tab-pane fade" id="tab-competency">
              @include('evaluation.create_tab.part1')
              </div>
              <div class="tab-pane fade" id="tab-needs">
              @include('evaluation.create_tab.part2')
              </div>
              <div class="tab-pane fade" id="tab-suggestion">
              @include('evaluation.create_tab.part3')
              </div>
              <div class="tab-pane fade" id="tab-recommendation">
              @include('evaluation.create_tab.part4')
              </div>
            </div>
            </form>
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
@endsection