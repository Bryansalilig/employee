<!--
  Add Page for Leave Request

  Handles the Creation Form of Leave Request.

  @version 1.0
  @since 2024-06-28

  Changes:
  • 2024-06-28: File creation
  • 2024-07-02:
    - Separate Files
    - Add Button for Next and Previous
-->
@extends('layout.main')
@include('leave.create.style')
@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('leave') }}">Leave Request</a></li>
    <li class="breadcrumb-item">Add</li>
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
  <!-- Include form -->
  <form action="{{ route('leave.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
  {{ csrf_field() }}
    <div class="row">
      <div class="col-lg-3 col-md-4">
        @include('leave.create.photo')
      </div>
      <div class="col-lg-9 col-md-8">
        @include('leave.create.content')
        @include('leave.create.button')
      </div>
    </div>
  </form>
</div>
@endsection
