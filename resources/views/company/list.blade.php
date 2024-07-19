<!--
  Table List for Company Policy

  Handles the List of Company Policies on a PDF Attachment.

  @version 1.0
  @since 2024-04-26

  Changes:
  • 2024-06-04: File creation
  • 2024-06-27: Add Back Button
-->
@extends('layout.main')


@section('style')
<!-- Include DataTables CSS -->
<link href="<?= URL::to('public/vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
@endsection

@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('company') }}">Company Policy</a></li>
    <li class="breadcrumb-item">List</li>
  </ol>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Add new banner button -->
    <a href="{{ route('company.create') }}" class="btn btn-warning btn-rounded"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>

    <!-- Return button -->
    <a href="{{ route('company') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">List of Company Policy</div>
    </div>
    <div class="ibox-body p-3">
      <!-- Banner table -->
      <table class="table table-striped table-bordered table-hover" id="example-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Filename</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Iterate through each company policy -->
          @foreach ($items as $key => $item)
          <tr>
            <td>{{ ++$key }}</td>
            <!-- Display company policy title -->
            <td data-toggle="tooltip" data-original-title="{{ $item->title }}">
              <a href="{{ route('company.edit', ['slug' => $item->slug]) }}" class="font-bold">{{ stringLimit($item->title) }}</a>
            </td>
            <!-- Display company policy subtitle -->
            <td>{{ $item->subtitle }}</td>
            <!-- Display company policy status -->
            <td>
              @if($item->status)
              <span class="badge bg-success">Active</span>
              @else
              <span class="badge bg-danger">Inactive</span>
              @endif
            </td>
            <td>
              <!-- Button to show image -->
              <a href="{{ $item->file_url }}" class="btn btn-success btn-sm mr-1" data-toggle="tooltip" data-original-title="Download Policy" data-title="{{ $item->title }}" download="{{ $item->subtitle }}"><i class="fa fa-download"></i></a>

              <!-- Button to delete company policy -->
              <a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" data-url="{{ route('company.destroy') }}" data-toggle="tooltip" data-original-title="Delete Policy"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('script')
<!-- Include DataTables JS -->
<script src="<?= URL::to('public/vendors/DataTables/datatables.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
  // Initialize DataTables
  $('#example-table').DataTable();
})
</script>
@endsection
