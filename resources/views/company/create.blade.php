<!--
  Add Page for Company Policy

  Handles the Creation Form of Company Policy.

  @version 1.0
  @since 2024-04-26

  Changes:
  • 2024-06-04: File creation
-->
@extends('layout.main')

@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('company') }}">Company Policy</a></li>
    <li class="breadcrumb-item">Add</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Return button -->
    <a href="{{ route('company.list') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <!-- Include form -->
  <form role="form" method="POST" action="{{ route('company.store') }}" novalidate="novalidate" enctype="multipart/form-data" autocomplete="off">
  @csrf
    <div class="ibox ibox-info">
      <div class="ibox-head">
        <div class="ibox-title">New Company Policy</div>
      </div>
      <div class="ibox-body">
        <!-- Include form -->
        @include('company.form')
      </div>
    </div>
    <div class="row">
      <div class="col-12 text-right">
        <button class="btn btn-info btn-rounded btn-submit"><span class="fa fa-floppy-o"></span> &nbsp;Submit</button>
      </div>
    </div>
  </form>
</div>
@endsection
