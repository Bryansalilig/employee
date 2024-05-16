@extends('layout.main')
@section('content')
<link href="<?= URL::to('vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
<div class="page-heading">
   <h1 class="page-title">Job Referral</h1>
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
      <li class="breadcrumb-item">Referral</li>
   </ol>
</div>
<div class="page-content fade-in-up">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">List of Job Referral </div>
         <div class="pull-right">

            <a href="{{ route('referral/create') }}" class="btn bg-primary text-white"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Referral</a>
            @if(!empty($logs))
            <a href="#" class="btn bg-warning text-white"><i class="fa fa-history" aria-hidden="true"></i>&nbsp;&nbsp; History</a>
            @endif
         </div>
      </div>
      <div class="ibox-body p-3">
         <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th style="min-width: 50px;">#</th>
                  <th style="width: 150px;">Position Applied</th>
                  <th style="width: 100px;">Referral Name</th>
                  <th>Contact Number</th>
                  <th>Email</th>
                  <th style="width: 100px;">Referred By</th>
                  <th style="width: 100px;">Referred Date</th>
                  <th style="width: 80px;">Option</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($referrals as $no => $referral)
                <tr{{ ($referral->acknowledged == 0) ? ' class="unacknowledged"' : '' }}>
                    <td><?= ++$no ?></td>
                    <td>{{ $referral->position_applied }}</td>
                    <td>{{ $referral->getReferralFullName() }}</td>
                    <td>{{ $referral->referral_contact_number }}</td>
                    <td>{{ $referral->referral_email }}</td>
                    <td>{{ $referral->getReferrerFullName() }}</td>
                    <td><span>{{ strtotime($referral->created_at) }}</span> {{ prettyDate($referral->created_at) }}</td>
                    <td class="text-center">
                        <a href="<?= url("referral/{$referral->slug}") ?>">
                            <i class="fa fa-eye"></i>
                        </a>
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
   });
</script>
@endsection