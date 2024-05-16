@extends('layout.main')

@include('employee.create.style')

@section('content')
<div class="page-heading">
  <h1 class="page-title">Add Employee</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ url('employees') }}">Employees</a></li>
    <li class="breadcrumb-item">Add Employee</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-12">
      @include('employee.create.content')
    </div>
  </div>
</div>
@endsection
