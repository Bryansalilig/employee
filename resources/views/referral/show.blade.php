@extends('layout.main')
@section('content')
<div class="page-heading">
   <h1 class="page-title">Job Referral</h1>
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><a ef="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
      <li class="breadcrumb-item">Referral</li>
   </ol>
</div>
<div class="page-content fade-in-up">
   <div class="ibox ibox-info">
      <div class="ibox-head">
         <div class="ibox-title">View Job Referral </div>
         <div class="pull-right">
         <a href="{{ url('referral') }}" class="btn btn-danger pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
         </div>
      </div>
      <div class="ibox-body p-3">
        <div class="row">
          <div class="col-md-4">
            <label for="">Referral Name</label>
            <h4>{{ $referral->getReferralFullName() }}</h4>
          </div>
          <div class="col-md-4">
            <label for="">Position Applied</label>
            <h4>{{ $referral->position_applied }}</h4>
          </div>
          <div class="col-md-4">
            <label for="">Contact Number</label>
            <h4>{{ $referral->referral_contact_number }}</h4>
            <br>
          </div>
          <div class="col-md-4">
            <label for="">Email Address</label>
            <h4>{{ $referral->referral_email }}</h4>
          </div>
          <div class="col-md-4">
            <label for="">Referrer Name</label>
            <h4>{{ $referral->getReferrerFullName() }}</h4>
            <br>
          </div>
          <div class="col-md-4">
            <label for="">Referrer Department</label>
            <h4>{{ $referral->referrer_department }}</h4>
            <br>
          </div>
          <div class="col-md-4">
            <label for="">Submitted Date</label>
            <h4>{{ prettyDate($referral->created_at) }}</h4>
            <br>
          </div>
          <?php if(!empty($referral->attachment)){?>
          <div class="col-md-4">
            <label for="">Attachment</label>
            <?php 
            $fullUrl = $referral->attachment;
            // Use basename to extract the filename
            $filename = basename($fullUrl);
            ?>
            <h5>
            <a href="<?= route('download', ['filename' => $filename]) ?>">
            <i class="fa fa-download" aria-hidden="true"></i> Download
            </a>
            </h5>
            <br>
          </div>
          <?php } 
          if (!empty($referral->reference_link)) {
          ?>
          <div class="col-md-4">
            <label for="">Reference Link</label>
            <h5>
            <a href="<?= $referral->reference_link?>" target="_blank">
            <i class="fa fa-link" aria-hidden="true"></i> Click Link
            </a>
            </h5>
            <br><br><br><br><br>
          </div>
          <?php } ?>
        </div>
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
@endsection