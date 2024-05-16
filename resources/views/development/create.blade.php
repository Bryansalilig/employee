@extends('layout.main')
@include('evaluation.style')
@include('development.style')
@section('content')
<div class="page-heading">
  <h1 class="page-title">Yearly Development</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('team-development') }}">Team Yearly Development</a></li>
    <li class="breadcrumb-item">Create Yearly Development</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="row">
  <?php
      $i = 0;
      $id = 0;
      $name = '';
      $position = '';
      $supervisor = '';
      $hired = '';
      $tenure = '';
      $img = '';
      foreach($employees as $employee) {
        if($i == 0) {
            $id = $employee->id;
            $name = strtoupper($employee->last_name.', '.$employee->first_name);
            $position = $employee->position_name;
            $supervisor = $employee->superior_name;
            $hired = date('d-M-y', strtotime($employee->hired_date));
            $tenure = $employee->tenure;
            $img = $employee->profile_img;
        }

        if($employee->slug == $record) {
            $id = $employee->id;
            $name = strtoupper($employee->last_name.', '.$employee->first_name);
            $position = $employee->position_name;
            $supervisor = $employee->superior_name;
            $hired = date('d-M-y', strtotime($employee->hired_date));
            $tenure = $employee->tenure;
            $img = $employee->profile_img;
        }

      $i++;
      }
    ?>
    <div class="col-lg-3 col-md-4">
      <div class="ibox ibox-danger">
        <div class="ibox-body text-center">
          <div class="m-t-20 img-profile">
            <div class="img-circle circle-danger">
              <img src="{{ $img }}" id="profile-img">
            </div>
          </div>
          <h5 class="font-strong m-b-10 m-t-10" id="fullname">{{ $name }}</h5>
          <div class="text-muted" id="position">{{ $position }}</div>
          <div class="m-t-10" id="department">{{ $hired }}</div>
          <div class="text-muted" id="position">Hired Date</div>
          <hr>
          <table class="table-bordered table-striped table-competency" id="table-result" width="100%">
              <thead>
                  <tr>
                      <th colspan="2">Talent Score</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="result_score">0.00</td>
                      <td class="result_talent result_develop">To Develop</td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
          <form id="developmentId" method="post" enctype="multipart/form-data" autocomplete="off">
          {{ csrf_field() }}
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" href="#tab-appraisee" data-toggle="tab"><i class="fa fa-user"></i> Evaluation</a>
                </li>
              </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-appraisee">
                @include('development.development_eval')
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

  });
</script>
@endsection