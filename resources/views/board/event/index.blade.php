<!--
  List View for Board > Event Module

  Handles the List of Events.

  @version 1.0
  @since 2024-04-03

  Changes:
  • 2024-04-03: File creation
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
    <li class="breadcrumb-item">Board</li>
    <li class="breadcrumb-item">Events</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <a href="{{ route('events.calendar') }}" class="btn btn-primary btn-rounded"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Calendar</a>
    <!-- Add new activity button -->
    <a href="{{ route('event.create') }}" class="btn btn-danger btn-rounded"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">List of Events</div>
    </div>
    <div class="ibox-body p-3">
      <!-- Events table -->
      <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Color</th>
            <th>Name</th>
            <th>Description</th>
            <th>Start</th>
            <th>End</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Iterate through each event -->
          @foreach($events as $key=>$item)
          <tr>
            <td>{{ ++$key }}</td>
            <!-- Display event color -->
            <td class="text-center">
              <div class="tip-color" style="background-color: {{$item->event_color}}; width: 20px; height: 20px;"></div>
            </td>
            <!-- Display event name -->
            <td data-toggle="tooltip" data-original-title="{{ $item->event_name }}">
              <a href="{{ route('event.edit', ['slug' => $item->slug]) }}" class="font-bold">{{ stringLimit($item->event_name, 100) }}</a>
            </td>
            <!-- Display event description -->
            <td data-toggle="tooltip" data-original-title="{{ $item->event_description }}">{{ ($item->event_description) ? stringLimit($item->event_description) : '' }}</td>
            <!-- Display event start date -->
            <td>{{ date('m/d/Y', strtotime($item->start_date)) }}</td>
            <!-- Display event end date -->
            <td>{{ date('m/d/Y', strtotime($item->end_date)) }}</td>
            <!-- Action buttons -->
            <td>
              <!-- Button to delete activity -->
              <a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" data-url="{{ route('event.destroy') }}" data-toggle="tooltip" data-original-title="Delete Event"><i class="fa fa-trash"></i></a>
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
});
</script>
@endsection
