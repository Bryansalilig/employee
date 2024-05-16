@extends('layout.main')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading" style="margin-left:20px;">
  <h1 class="page-title">Yearly Development</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">History - Yearly Development</li>
  </ol>
</div>
<div class="page-content fade-in-up" style="margin-left:20px;">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">History - Yearly Development</div>
      <div class="pull-right">
        <a href="{{ route('development') }}" class="btn bg-danger text-white"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp; Back</a>
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
        <?php foreach($items as $no=>$item) { ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $item->last_name.', '.$item->first_name ?></td>
                <td><?= date('Y-m-d', strtotime($item->hired_date)) ?></td>
                <td><?= ($item->draft) ? 'Draft' : 'Completed' ?></td>
                <td><?= date('Y-m-d', strtotime($item->created_at)) ?></td>
                <td class="text-center">
                    <a href="<?= url("development/{$item->slug}/edit") ?>" title="Edit" class="btn_view">
                        <span class="fa fa-edit"></span>
                    </a>
                    <a href="<?= url("development/{$item->slug}") ?>" title="View" class="btn_view">
                        <span class="fa fa-eye"></span>
                    </a>
                </td>
            </tr>
        <?php } ?>
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