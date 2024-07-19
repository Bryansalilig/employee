<!--
  List View for Leave Module

  Handles the List of Leave Request.

  @version 1.0
  @since 2024-06-28

  Changes:
  • 2024-06-28: File creation
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
    <li class="breadcrumb-item">Leave Request</li>
    <li class="breadcrumb-item">{{ ucfirst($status) }} Leave</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-md-6 col-12">
    <div class="form-inline">
      <select class="form-control" id="filter-leave">
        <option value="pending" {{ ($status == 'pending') ? 'selected' : '' }}>Pending</option>
        <option value="approve" {{ ($status == 'approve') ? 'selected' : '' }}>Approved</option>
        <option value="cancelled" {{ ($status == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
      </select>
    </div>
  </div>
  <div class="col-md-6 col-12 text-right">
    <!-- Add new leave request button -->
    <a href="{{ route('leave.create') }}" class="btn btn-danger btn-rounded"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">List of Leave Request</div>
    </div>
    <div class="ibox-body p-3">
      <!-- Events table -->
      <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Reason</th>
            <th>Category</th>
            <th>Dates</th>
            <th>No. of Days</th>
            @if($status == 'pending')
            <th>Status</th>
            @endif
            <th>Date Filed</th>
          </tr>
        </thead>
        <tbody>
          <!-- Iterate through each banner -->
          @foreach ($items as $key => $item)
            @php
              $days = 0;
              $dates = [];
              foreach($item->leave_details as $detail) {
                if($detail->status == 3) { continue; }
                array_push($dates, date('m/d/y', strtotime($detail->date)));
                $days += $detail->length;
              }

              $leave_status = "Pending";
              $badge = "primary";
              if ($item->approve_status_id == 3) {
                $leave_status = "Recommended";
                $badge = "warning";
              }

              $leave_type = "<span class='badge bg-purple'>Unplanned</span>";
              if($item->pay_type_id == 1) { $leave_type = "<span class='badge badge-info'>Planned</span>"; }
            @endphp
          <tr>
            <td>{{ ++$key }}</td>
            <!-- Display employee name -->
            <td style="max-width: 150px;">
              <a href="{{ route('leave.show', ['slug' => $item->slug]) }}" class="font-bold">{{ $item->first_name.' '.$item->last_name }}</a>
            </td>
            <!-- Display banner title -->
            <td style="max-width: 200px;" data-toggle="tooltip" data-original-title="{{ $item->reason }}">{!! stringLimit($item->reason) !!}</td>
            <!-- Display leave type -->
            <td>{!! $leave_type !!}</td>
            <!-- Display leave dates -->
            <td>{!! implode("<br>", $dates) !!}</td>
            <!-- Display number of days -->
            <td>{{ $days }}</td>
            @if($status == 'pending')
            <!-- Display leave status -->
            <td>
              <span class="badge badge-{{ $badge }}">{{ $leave_status }}</span>
            </td>
            @endif
            <!-- Display leave date filed -->
            <td>{{ date('m/d/y', strtotime($item->date_filed)) }}</td>
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

  $('#filter-leave').change(function(e) {
    e.preventDefault();

    var url = location.protocol + '//' + location.host + location.pathname;
    var status = "status=" + $(this).val();

    url += "?" + status;

    window.location.replace(url);
  });
});
</script>
@endsection
