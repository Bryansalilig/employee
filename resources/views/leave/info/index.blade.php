<!--
  Info Page for Leave Request

  Handles the Information of a specific Leave Request.

  @version 1.0
  @since 2024-07-02

  Changes:
  • 2024-07-02: File creation
-->
@extends('layout.main')
@include('leave.info.style')
@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('leave') }}">Leave Request</a></li>
    <li class="breadcrumb-item">{{ formatName(Auth::user()->fullname2()) }}</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Return button -->
    <a href="{{ route('leave') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      @include('leave.info.photo')
    </div>
    <div class="col-lg-9 col-md-8">
      @include('leave.info.content')
      @include('leave.info.button')
    </div>
  </div>
</div>
@endsection
