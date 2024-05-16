@extends('layout.main')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading" style="margin-left:20px;">
   <h1 class="page-title">Yearly Development</h1>
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
      <li class="breadcrumb-item">Yearly Development</li>
   </ol>
</div>
<div class="page-content fade-in-up" style="margin-left:20px;">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">Yearly Development List</div>
         <div class="pull-right">
            @if(Auth::user()->isAdmin() || Auth::user()->team_name == 'Organizational Development')
            <a href="{{ route('upcoming-development') }}" class="btn bg-danger text-white"><i class="fa fa-birthday-cake"></i>&nbsp;&nbsp;Upcoming Anniversaries</a>
            @endif
            @if($is_leader && (!Auth::user()->isAdmin() && Auth::user()->team_name != 'Organizational Development'))
            <a href="{{ route('team-development') }}" class="btn bg-primary text-white"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp; Team Development</a>
            @endif
            <a href="{{ route('personal-development') }}" class="btn bg-ebony text-white"><i class="fa fa-user"></i>&nbsp;&nbsp; Personal</a>
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
                  <th>Filed by</th>
                  <th style="width:80px;">Options</th>
               </tr>
            </thead>
            <tbody>
            @foreach ($items as $no => $item)
               <tr>
                  <td>{{ ++$no }}</td>
                  <td>{{ $item->last_name }}, {{ $item->first_name }}</td>
                  <td>{{ date('Y-m-d', strtotime($item->hired_date)) }}</td>
                  <td>{{ ($item->draft) ? 'Draft' : 'Completed'}}</td>
                  <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                  <td>{{ $item->superior }}</td>
                  <td>
                  @if ($item->superior_id == Auth::user()->id || Auth::user()->isAdmin())
                  <a href="{{ route('development/edit', ['id' => $item->slug]) }}" title="Edit">
                     <span class="fa fa-edit"></span>
                  </a>
                  @endif
                  <a href="{{ route('development', ['id' => $item->slug]) }}" title="View">
                     <span class="fa fa-eye"></span>
                  </a>
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