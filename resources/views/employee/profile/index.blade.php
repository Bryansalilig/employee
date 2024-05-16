@extends('layout.main')

@include('employee.profile.style')

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
      @include('employee.profile.photo')
    </div>
    <div class="col-lg-9 col-md-8">
      @include('employee.profile.content')
    </div>
  </div>
</div>
@endsection
