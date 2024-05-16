@extends('layout.main')

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel-heading">
                <i class="fa fa-home text-success"></i> / Blog Post > <span style="color:#3498db">Events</span>    
                <a href="<?= url('events/create') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Event</a>
                <a href="<?= url('events/calendar') ?>" class="btn btn-info pull-right" style="margin-right:10px"><i class="fa fa-calendar"></i> Calendar View</a>
            
                    
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
        $(function() {
            $('#record_table').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
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
