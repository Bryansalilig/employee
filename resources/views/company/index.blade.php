<!--
  List View for Company Policy

  Handles the List of Company Policies on a PDF Attachment.

  @version 1.0
  @since 2024-04-26

  Changes:
  • 2024-04-26: File creation
-->
@extends('layout.main')

@section('style')
<!-- Include Mailbox CSS -->
<link href="<?= URL::to('public/pages/mailbox.css')?>" rel="stylesheet" />
@endsection

@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Company Policy</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Add new banner button -->
    <a href="{{ route('company.list') }}" class="btn btn-danger btn-rounded"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;List</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="row">
    @foreach($items as $item)
    <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="card mb-3">
        <div>
          <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" style="max-height: 200px;">
        </div>
        <div class="card-body">
          <h4 class="card-title">{{ $item->title }}</h4>
          <span>{{ $item->subtitle }}</span>
          <a class="btn btn-default btn-xs float-right" href="{{ $item->file_url }}" download="{{ $item->subtitle }}"><i class="fa fa-download"></i></a>
          <a class="btn btn-default btn-xs float-right" href="{{ $item->file_url }}" target="_blank"><i class="fa fa-eye"></i></a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
