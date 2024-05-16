<!--
  List View for Board > Activity Module

  Handles the List of Activities.

  @version 1.0
  @since 2024-03-27

  Changes:
  • 2024-03-27: File creation
  • 2024-04-02:
    - Add Show Image Modal
-->
@extends('layout.main')

@section('style')
<!-- Include DataTables CSS -->
<link href="<?= URL::to('public/vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
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
    <li class="breadcrumb-item">Activities</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Add new activity button -->
    <a href="{{ route('activity.create') }}" class="btn btn-danger btn-rounded"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">List of Activities</div>
    </div>
    <div class="ibox-body p-3">
      <!-- Activities table -->
      <table class="table table-striped table-bordered table-hover" id="example-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Date</th>
            <th>Message</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Iterate through each activity -->
          @foreach($items as $key=>$item)
          <tr>
            <td>{{ ++$key }}</td>
            <!-- Display activity title -->
            <td data-toggle="tooltip" data-original-title="{{ $item->title }}">
              <a href="{{ route('activity.edit', ['slug' => $item->slug]) }}" class="font-bold">{{ stringLimit($item->title, 30) }}</a>
            </td>
            <!-- Display activity subtitle -->
            <td data-toggle="tooltip" data-original-title="{{ $item->subtitle }}">{{ stringLimit($item->subtitle, 30) }}</td>
            <!-- Display activity date -->
            <td>{{ date('m/d/Y', strtotime($item->activity_date)) }}</td>
            <!-- Display message -->
            <td data-toggle="tooltip" data-original-title="{{ $item->message }}">{{ ($item->message) ? stringLimit($item->message, 40) : '' }}</td>
            <!-- Action buttons -->
            <td>
              <!-- Button to show image -->
              <a href="javascript:;" class="btn btn-info btn-sm btn-show-image mr-1" data-toggle="tooltip" data-original-title="Show Image" data-title="{{ $item->title }}" data-url="{{ $item->image_url }}"><i class="fa fa-file-image-o"></i></a>
              <!-- Button to delete activity -->
              <a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" data-url="{{ route('activity.destroy') }}" data-toggle="tooltip" data-original-title="Delete Activity"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Show Image -->
<div class="modal fade" id="modal-show-image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h6 class="modal-title"></h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
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

  // Show image modal on button click
  $('.btn-show-image').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var url = obj.data('url');
    var title = obj.data('title');

    $('#modal-show-image').find('.modal-title').text(title);
    $('#modal-show-image').find('.modal-body').html('<img src="' + url + '" >');
    $('#modal-show-image').modal('show');
  });
})
</script>
@endsection
