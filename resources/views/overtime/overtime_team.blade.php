@extends('layout.main')
@include('overtime.style')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading my-2">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Timekeeping</li>
    <li class="breadcrumb-item">Overtime</li>
    <li class="breadcrumb-item">Team Overtime</li>
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
      <select class="form-control" id="filter-level" style="margin-left:15px;">
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
    <a href="{{ route('overtime') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a> &nbsp;
  </div>
</div>

<div class="page-content fade-in-up">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">Team Overtime</div>
      </div>
      <div class="ibox-body p-3">
        <div class="btn-group d-none" style="position:absolute;z-index:99;margin-left:15px;">
          <button class="btn btn-info">Status</button>
          <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
          <ul class="dropdown-menu">
            <li style="display: <?= (Auth::user()->usertype == 3) ? : 'none'?>">
              <a href="" data-target="#approvemodal" data-toggle="modal">Approve</a>
            </li>
            <li>
              <a href="" data-target="#recommendmodal" data-toggle="modal">Recommend</a>
            </li>
            <li>
              <a href="" data-target="#cancelmodal" data-toggle="modal">Cancelled</a>
            </li>
            <li>
              <a href="" data-target="#complete" data-toggle="modal">Complete</a>
            </li>
          </ul>
        </div>
        <div class="table-responsive">
            <table class="table" id="employeeTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                          <label class="ui-checkbox">
                              <input type="checkbox" id="selectAll">
                              <span class="input-span"></span>
                            </label>
                        </th>
                        <th>Employee</th>
                        <th style="width:25%;">Reason</th>
                        <th>Date</th>
                        <th style="width:16%">Estimated No. of Hrs</th>
                        <th>Status</th>
                        <?php
                          if(Auth::user()->isAdmin() && $type == 'completed') {
                        ?>
                          <th>Date Completed</th>
                          <th>Tracking No.</th>
                        <?php
                            } else {
                        ?>
                        <th>Date Requested</th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($overtime_request as $no => $request)
                    <tr>
                        <td id="aligned">
                            <label class="ui-checkbox">
                                <input type="checkbox" class="rowCheckbox" value="<?= $request->id?>">
                                <span class="input-span"></span>
                            </label>
                        </td>
                        <td id="aligned"><a href="<?= url("overtime/{$request->slug}") ?>">{{ $request->first_name }} {{ $request->last_name }}</a></td>
                        <td title="{{ htmlentities($request->reason) }}">{{ stringlimit($request->reason, 50) }}</td>
                        <td id="aligned"><span class="d-none">{{ strtotime($request->dates[0]) }}</span> {!! implode('<br>', $request->dates) !!}</td>
                        <td id="aligned" style="text-align:center">{{ array_sum($request->no_of_hours) }} <?= (array_sum($request->no_of_hours) > 1) ? "hrs." : "hr."?></td>
                        <td id="aligned"><span class="badge <?= 
                          (timekeepingStatus($request) == 'Pending') ? 'bg-primary' : 
                          ((timekeepingStatus($request) == 'Approved') ? 'bg-success' : 
                          ((timekeepingStatus($request) == 'Verifying') ? 'bg-warning' : 
                          ((timekeepingStatus($request) == 'Verified') ? 'bg-purple' : 
                          ((timekeepingStatus($request) == 'Completed') ? 'bg-info' :
                          ((timekeepingStatus($request) == 'Declined' || timekeepingStatus($request) == 'Not Approve' || timekeepingStatus($request) == 'Reverted') ? 'bg-danger' :
                          ''))))) ?>"><?= timekeepingStatus($request) ?></span>
                        </td>
                        @if (Auth::user()->isAdmin() && $type == 'completed')
                        <!-- <td>
                          <span class="d-none" id="aligned">{{ strtotime($request->completed_date) }}</span>{{ date('M d, Y', strtotime($request->completed_date)) }}
                        </td> -->
                        <td id="aligned">{{ $request->id }}</td>
                        @else
                        <td id="aligned">
                          <span class="d-none">{{ strtotime($request->created_at) }}</span>{{ date('M d, Y', strtotime($request->created_at)) }}
                        </td>
                        @endif
                        </td>
                    </tr>
                  @endforeach     
                </tbody>
            </table>
        </div>
        
        

      </div>
   </div>
</div>
@endsection
@section('script')
<script src="<?= URL::to('vendors/DataTables/datatables.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var table;
    // Initialize DataTable if not already initialized
    if (!$.fn.DataTable.isDataTable('#employeeTable')) {
      table = $('#employeeTable').DataTable({
        "paging": true,
        "pageLength": 50,
        "lengthChange": false,
        "info": false,
        "columnDefs": [
          {
            "targets": 0, // Index of the column (0-based) that contains the checkbox
            "orderable": false
          }
        ]
      });
    } else {
      table = $('#employeeTable').DataTable();
    }

    var selectedRows = {}; // Object to store selected rows per page
        var currentPage; // Variable to store the current page

        // Single checkbox click
        $('#employeeTable tbody').on('click', '.rowCheckbox', function (e) {
            e.stopPropagation();
            var pageIndex = table.page();
            var rowIndex = table.row($(this).closest('tr')).index();
            
            if (!selectedRows[pageIndex]) {
                selectedRows[pageIndex] = [];
            }

            if ($(this).prop('checked')) {
                selectedRows[pageIndex].push(rowIndex);
            } else {
                selectedRows[pageIndex] = selectedRows[pageIndex].filter(index => index !== rowIndex);
            }
            showHideSelection();
      });

      // Select all rows
      $('#selectAll').click(function () {
            var isChecked = $(this).prop('checked');
            
            // Store the current page
            currentPage = table.page();

            $('.rowCheckbox', table.rows({ page: 'current' }).nodes()).prop('checked', isChecked);

            var pageIndex = table.page();
            if (isChecked) {
                selectedRows[pageIndex] = table.rows({ page: 'current' }).indexes().toArray();
            } else {
                selectedRows[pageIndex] = [];
            }
            showHideSelection();
        });

         // Function to show/hide the selection dropdown
         function showHideSelection() {
            var selectedRowsCount = Object.values(selectedRows).flat().length;
            if (selectedRowsCount > 0) {
                $('.btn-group').removeClass('d-none');
            } else {
                $('.btn-group').addClass('d-none');
            }
        }

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