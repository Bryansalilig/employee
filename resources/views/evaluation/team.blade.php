@extends('layout.main')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading" style="margin-left:20px;">
   <h1 class="page-title">Performance Evaluation</h1>
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="{{ route('evaluation.evaluation') }}">Evaluation</a></li>
      <li class="breadcrumb-item">Team Evaluation</li>
   </ol>
</div>
<div class="page-content fade-in-up" style="margin-left:20px;">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">Team - Performance Evaluation</div>
         <div class="pull-right">
            @if(!empty($logs))
            <a href="#" id="btn-history" class="btn bg-warning text-white" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i>&nbsp;&nbsp;History</a>
            @endif
            <a href="{{ route('evaluation.evaluation') }}" class="btn bg-ebony text-white"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp; Back</a>
         </div>
      </div>
      <div class="ibox-body p-3">
         <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th style="min-width:50px;">#</th>
                  <th style="width: 200px">Employee</th>
                  <th style="width: 200px">Title</th>
                  <th>Acknowledge<br> Date</th>
                  <th>Action</th>
                  <th>Date Filed</th>
                  <th style="width:80px;">Options</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  $i = 1;
                  foreach($items as $item) {
                      $in_status = 'Not Acknowledged';
                      $in_class = true;
                      if($item->is_acknowledged) {
                          $in_status = 'Acknowledged';
                          $in_class = false;
                      }
                  ?>
               <tr <?= ($in_class && $item->employee_id == Auth::user()->id) ? 'class="unacknowledged"' : '' ?>>
                  <?php if(Auth::user()->isAdmin()){?>
                  <?php if(Auth::user()->id == $item->manager_id && $item->eval_approval == 0){?>
                  <td style="font-weight:bold"><?= $i ?></td>
                  <td style="font-weight:bold"><?= $item->first_name . ' ' . $item->last_name ?></td>
                  <td style="font-weight:bold" title="<?= $item->title ?>"><?= $item->title ?></td>
                  <td style="font-weight:bold"><span class="d-none"><?= empty($item->acknowledged_date) ? '' : strtotime($item->acknowledged_date) ?></span> <?= empty($item->acknowledged_date) ? '' : \Carbon\Carbon::parse($item->acknowledged_date)->format('m/d/Y') ?></td>
                  <td style="font-weight:bold"><span class="badge <?= ($in_status == "Acknowledged") ? 'badge-success' : 'badge-warning' ?>"><?= $in_status ?></span></td>
                  <td style="font-weight:bold"><span><?= strtotime($item->created_at) ?></span> {{ \Carbon\Carbon::parse($item->acknowledged_date)->format('m/d/Y') }}</td>
                  <td class="text-center">
                     <a href="<?= url("evaluation/{$item->slug}") ?>" title="View" class="btn_view">
                     <span class="fa fa-eye"></span>
                     </a>
                  </td>
                  <?php } else { ?>
                  <td><?= $i ?></td>
                  <td><?= $item->first_name . ' ' . $item->last_name ?></td>
                  <td title="<?= $item->title ?>"><?= $item->title ?></td>
                  <td><span class="d-none"><?= empty($item->acknowledged_date) ? '' : strtotime($item->acknowledged_date) ?></span> <?= empty($item->acknowledged_date) ? '' : \Carbon\Carbon::parse($item->acknowledged_date)->format('m/d/Y') ?></td>
                  <td><span class="badge <?= ($in_status == "Acknowledged") ? 'badge-success' : 'badge-warning' ?>"><?= $in_status ?></span></td>
                  <td><span class="d-none"><?= strtotime($item->created_at) ?></span> {{ \Carbon\Carbon::parse($item->created_at)->format('m/d/Y') }}</td>
                  <td class="text-center">
                     <a href="<?= url("evaluation/{$item->slug}") ?>" title="View" class="btn_view">
                     <span class="fa fa-eye"></span>
                     </a>
                  </td>
                  <?php } ?>
                  <?php } else {?>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>"><?= $i ?></td>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>"><?= $item->first_name . ' ' . $item->last_name ?></td>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>" title="<?= $item->title ?>"><?= $item->title ?></td>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>"><span class="d-none"><?= empty($item->acknowledged_date) ? 0 : strtotime($item->acknowledged_date) ?></span> <?= empty($item->acknowledged_date) ? '' : date('M d, Y', strtotime($item->acknowledged_date)) ?></td>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>"><span class="badge <?= ($in_status == "Acknowledged") ? 'badge-success' : 'badge-warning' ?>"><?= $in_status ?></span></td>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>"><span><?= strtotime($item->created_at) ?></span> {{ \Carbon\Carbon::parse($item->created_at)->format('m/d/Y') }}</td>
                  <td style="display:<?= $item->eval_approval == 0 ? 'none' : ''?>" class="text-center">
                     <a href="<?= url("evaluation/{$item->slug}") ?>" title="View" class="btn_view">
                     <span class="fa fa-eye"></span>
                     </a>
                  </td>
                  <?php } ?>
               </tr>
               <?php 
                  $i++;
                  }
                  ?>
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
   
       $('.btn-show-image').click(function(e) {
           e.preventDefault();
   
           var obj = $(this);
           var url = obj.attr('data-url');
           var title = obj.attr('data-title');
   
           $('#modal-show-image').find('.modal-title').text(title);
           $('#modal-show-image').find('.modal-body').html('<img src="'+url+'" >');
           $('#modal-show-image').modal('show');
       });
   })
</script>
@endsection