<!--
  Add Page for Board > Event Module

  Handles the Creation Form of Event.

  @version 1.0
  @since 2024-04-03

  Changes:
  • 2024-04-03: File creation
-->
@extends('layout.main')

@section('style')
<link href="<?= URL::to('public/vendors/jquery-minicolors/jquery.minicolors.css')?>" rel="stylesheet" />
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
    <li class="breadcrumb-item"><a href="{{ route('events') }}">Events</a></li>
    <li class="breadcrumb-item">Add</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Return button -->
    <a href="{{ route('events') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <!-- Creation Form -->
  <form role="form" method="POST" action="{{ route('event.store') }}" novalidate="novalidate" enctype="multipart/form-data" autocomplete="off">
  @csrf
    <div class="ibox ibox-info">
      <div class="ibox-head">
        <div class="ibox-title">New Event</div>
      </div>
      <div class="ibox-body">
        <!-- Include form -->
        @include($view.'.form')
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 text-right">
        <button class="btn btn-info btn-rounded btn-submit" type="button"><span class="fa fa-floppy-o"></span> &nbsp;Submit</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('script')
<script src="<?= URL::to('public/vendors/jquery-minicolors/jquery.minicolors.min.js')?>" type="text/javascript"></script>
<!-- Include custom javascript for this view -->
@include($view.'.script')
@endsection