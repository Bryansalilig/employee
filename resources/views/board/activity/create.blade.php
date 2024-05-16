<!--
  Add Page for Board > Activity Module

  Handles the Creation Form of Activity.

  @version 1.0
  @since 2024-03-27

  Changes:
  • 2024-03-27: File creation
-->
@extends('layout.main')

@section('style')
<!-- Include custom style for this view -->
@include($view.'.style')
@endsection

@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Board</li>
    <li class="breadcrumb-item"><a href="{{ route('activities') }}">Activities</a></li>
    <li class="breadcrumb-item">Add</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Return button -->
    <a href="{{ route('activities') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <!-- Include form -->
      @include($view.'.photo')
    </div>
    <div class="col-lg-9 col-md-8">
      <!-- Creation Form -->
      <form method="POST" action="{{ route('activity.store') }}" enctype="multipart/form-data" autocomplete="off">
      @csrf
        <div class="ibox ibox-info">
          <div class="ibox-head">
            <div class="ibox-title">New Activity</div>
          </div>
          <div class="ibox-body">
            <!-- Include form -->
            @include($view.'.form')
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 text-right">
            <button class="btn btn-info btn-rounded btn-submit"><span class="fa fa-floppy-o"></span> &nbsp;Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<!-- Include custom javascript for this view -->
@include($view.'.script')
@endsection
