@extends('layout.main')
@include('overtime.style')
@section('content')

<script>

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('4b3d19212d902a3e44e3', {
  cluster: 'ap1'
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  alert(JSON.stringify(data));
});
</script>
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading my-2">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Timekeeping</li>
    <li class="breadcrumb-item">Overtime</li>
    <?php
    function capitalizeFirstLetter($str) {
        return ucfirst($str);
    }
    $capitalizedString = capitalizeFirstLetter($status_filter);
    ?>
    <li class="breadcrumb-item"><?= ($status_filter == "") ? 'Pending' : $capitalizedString?> List</li>
  </ol>
</div>
<div class="row">
  <div class="col-md-6 col-12">
    <div class="form-inline">
      <select class="form-control" id="filter-level">
        <option value="">PENDING</option>
        <option value="approved" <?= ($status_filter == "approved") ? 'selected' : ''?>>APPROVED</option>
        <option value="verifying" <?= ($status_filter == "verifying") ? 'selected' : ''?>>VERIFYING</option>
        <option value="verified" <?= ($status_filter == "verified") ? 'selected' : ''?>>VERIFIED</option>
        <option value="completed" <?= ($status_filter == "completed") ? 'selected' : ''?>>COMPLETED</option>
        <option value="declined" <?= ($status_filter == "declined") ? 'selected' : ''?>>DECLINED</option>
      </select>
    </div>
  </div>
  <div class="col-md-6 col-12 text-right">
  <?php
    if($is_leader > 0) {
  ?>
    <a href="{{ route('team-overtime') }}" class="btn btn-primary btn-rounded"><i class="fa fa-users" aria-hidden="true"></i> Team Overtime</a>
  <?php } ?>
    <a href="{{ route('overtime/create') }}" class="btn btn-primary btn-rounded"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> File Overtime</a> &nbsp;
  </div>
</div>
<div class="page-content fade-in-up">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">Overtime</div>
      </div>
      <div class="ibox-body p-3">
         <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width:10px;">#</th>
                <th style="width:150px;">Employee</th>
                <th>Reason</th>
                <th style="width:100px;">Date</th>
                <th style="width:100px;">Estimated<br> No. Of Hours</th>
                <th style="width:100px;">Status</th>
                <?php
                    if(Auth::user()->isAdmin() && $type == 'completed') {
                ?>
                  <th>Date<br> Completed</th>
                  <th style="width:50px;">Tracking No.</th>
                <?php
                    } else {
                ?>
                <th>Date<br> Requested</th>
                <?php
                    }
                ?>
              </tr>
            </thead>
            <tbody>
              @foreach ($overtime_request as $no => $request)
              <tr>
                <td>{{ ++$no }}</td>
                <td style="vertical-align:middle"><a href="<?= url("overtime/{$request->slug}") ?>">{{ $request->first_name }} {{ $request->last_name }}</a></td>
                <td title="{{ htmlentities($request->reason) }}">{{ stringlimit($request->reason) }}</td>
                <td style="vertical-align:middle"><span class="d-none">{{ (count($request->dates) > 0) ? strtotime($request->dates[0]) : 0 }}</span> {!! implode('<br>', $request->dates) !!}</td>
                <td style="text-align:center;vertical-align:middle">{{ array_sum($request->no_of_hours) }}</td>
                <td style="vertical-align:middle">
                  <?php if($request->recommend_id && empty($request->approved_id) && empty($request->declined_id)) { ?>
                    <span class="badge" style="background-color:#3CB371">
                    Recommended
                  </span>
                  <?php } else { ?>
                    <span class="badge <?=
                    (timekeepingStatus($request) == 'Pending') ? 'bg-primary' :
                    ((timekeepingStatus($request) == 'Approved') ? 'bg-success' :
                    ((timekeepingStatus($request) == 'Verifying') ? 'bg-warning' :
                    ((timekeepingStatus($request) == 'Verified') ? 'bg-purple' :
                    ((timekeepingStatus($request) == 'Completed') ? 'bg-info' :
                    ((timekeepingStatus($request) == 'Declined' || timekeepingStatus($request) == 'Not Approve' || timekeepingStatus($request) == 'Reverted') ? 'bg-danger' :
                    ''))))) ?>">
                    <?= timekeepingStatus($request) ?>
                  </span>
                  <?php } ?>
                </td>

                @if (Auth::user()->isAdmin() && $type == 'completed')
                <td><span class="d-none">{{ strtotime($request->completed_date) }}</span>{{ date('M d, Y', strtotime($request->completed_date)) }}</td>
                <td>{{ $request->id }}</td>
                @else
                <td><span class="d-none">{{ strtotime($request->created_at) }}</span>{{ date('M d, Y', strtotime($request->created_at)) }}</td>
                @endif
              </tr>
              @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="<?= URL::to('vendors/DataTables/datatables.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
   $(function() {
      $('#filter-level').change(function() {
          var selectedStatus = $(this).val();
          if(selectedStatus == ""){
            window.location.href = "{{ route('overtime') }}";
          }else {
            window.location.href = "{{ route('overtime') }}?status=" + selectedStatus;
          }
      });

       $('#example-table').DataTable({
           pageLength: 50,
           lengthMenu: [25, 50, 100],
       });
   });
</script>
@endsection
