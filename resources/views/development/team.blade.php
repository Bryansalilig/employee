@extends('layout.main')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading" style="margin-left:20px;">
  <h1 class="page-title">Yearly Development</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Team - Yearly Development</li>
  </ol>
</div>
<div class="page-content fade-in-up" style="margin-left:20px;">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">Team - Yearly Development</div>
      <div class="pull-right">
        @if(Auth::user()->isAdmin())
        <a href="{{ route('development') }}" class="btn bg-primary text-white"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp; Back</a>
        @else 
        <a href="{{ route('history-development') }}" id="btn-history" class="btn bg-warning text-white"><i class="fa fa-history"></i>&nbsp;&nbsp;History</a>  
        <a href="{{ route('personal-development') }}" class="btn bg-ebony text-white"><i class="fa fa-edit"></i>&nbsp;&nbsp; Personal</a>
        @endif
      </div>
    </div>
    <div class="ibox-body p-3">
      <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="min-width:50px;">#</th>
            <th>Employee</th>
            <th>Hired Date</th>
            <th>Status</th>
            <th>Date Filed</th>
            <th style="width:80px;">Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $no=>$item)
          @php
          $hired = date('Y').date('-m-d', strtotime($item->hired_date))
          @endphp
          <tr <?= ($hired < date('Y-m-d')) ? 'style="background:#f5c6cb !important;"' : '' ?>>
            <td><?= ++$no ?></td>
            <td><?= empty($item->data) ? '<i class="fa fa-warning text-warning" title="Not Filed"></i>&nbsp;' : '' ?> <?= $item->last_name.', '.$item->first_name ?></td>
            <td><?= date('Y-m-d', strtotime($item->hired_date)) ?></td>
            <td><?= empty($item->data) ? '' : (($item->data->draft) ? 'Draft' : 'Completed') ?></td>
            <td><?= empty($item->data) ? '' : date('Y-m-d', strtotime($item->data->created_at)) ?></td>
            <td class="text-center">
              <?php if(empty($item->data)) { ?>
               <a href="{{ route('development.create', ['record' => $item->slug]) }}" title="Create" class="btn_view">
                  <span class="fa fa-plus-square-o"></span>
               </a>
              <?php } else { ?>
              <a href="<?= url("development/{$item->data->slug}/edit") ?>" title="Edit" class="btn_view">
              <span class="fa fa-edit"></span>
              </a>
              <a href="<?= url("development/{$item->data->slug}") ?>" title="View" class="btn_view">
              <span class="fa fa-eye"></span>
              </a>
              <?php } ?>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-show-image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h6 class="modal-title">Modal title</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="<?= URL::to('vendors/DataTables/datatables.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
      $('#example-table').DataTable({
          pageLength: 10,
          //"ajax": 'demo/data/table_data.json',
          /*"columns": [
              { "data": "name" },
              { "data": "office" },
              { "data": "extn" },
              { "data": "start_date" },
              { "data": "salary" }
          ]*/
      });
  })
</script>
@endsection