@extends('layout.main')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading" style="margin-left:20px;">
   <h1 class="page-title">Departments</h1>
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
      <li class="breadcrumb-item">Departments</li>
   </ol>
</div>
<div class="page-content fade-in-up" style="margin-left:20px;">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">List of Departments </div>
         <div class="pull-right">
          
            <a href="{{ route('department/create') }}" class="btn bg-primary text-white"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Department</a>
            @if(!empty($logs))
            <a href="#" class="btn bg-warning text-white"><i class="fa fa-history" aria-hidden="true"></i>&nbsp;&nbsp; History</a>
            @endif
         </div>
      </div>
      <div class="ibox-body p-3">
         <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Department Code</th>
                    <th style="max-width: 250px;">Department Name</th>
                    <th>Division</th>
                    <th>Account</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($departments as $no=>$department) {
            ?>
                <tr> 
                    <td><?= ++$no ?></td>
                    <td><?= $department->department_code ?></td>
                    <td><h6><?= $department->department_name ?></h6></td>
                    <td><?= (isset($department->division)) ? $department->division->division_name : 'N/A' ?></td>
                    <td><?= (isset($department->account)) ? $department->account->account_name : 'N/A' ?></td>
                    <td class="text-center">
                        <a href="<?= url("department/{$department->slug}/edit") ?>" title="Edit">
                          <i class="fa fa-pencil"></i>
                        </a>&nbsp;&nbsp;
                        <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $department->id ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php
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