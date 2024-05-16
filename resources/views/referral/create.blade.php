@extends('layout.main')
@section('content')
<div class="page-heading">
  <h1 class="page-title">Job Referral</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Add Referral</li>
  </ol>
</div>
<form role="form" method="POST" action="{{ route('referral.store') }}" novalidate="novalidate" enctype="multipart/form-data" autocomplete="off">
      @csrf
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">Referrer Information (You)</div>
      <a href="{{ url('referral') }}" class="btn btn-danger pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
    </div>
    <div class="ibox-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
            <div class="input-group-icon right">
              <div class="input-icon d-none"><i class="fa fa-exclamation"></i></div>
              <input class="form-control" type="text" name="first_name" placeholder="Your First Name..." required>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Middle Name</label>
            <input class="form-control" type="text" name="middle_name" placeholder="Your Middle Name...">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="last_name" placeholder="Your Last Name..." required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label class="col-form-label">Department <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="department_name" placeholder="Your Department Name...">
          </div>
        </div>
      </div>
    </div>
</div>
<div class="page-content fade-in-up" style="margin-top:-45px">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">Referral Information</div>
    </div>
    <div class="ibox-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
            <div class="input-group-icon right">
              <div class="input-icon d-none"><i class="fa fa-exclamation"></i></div>
              <input class="form-control" type="text" name="referral_first_name" placeholder="Referral First Name..." required>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Middle Name </label>
            <input class="form-control" type="text" name="referral_middle_name" placeholder="Referral Middle Name...">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="referral_last_name" placeholder="Referral Last Name..." required>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Contact Number <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="referral_contact_number" placeholder="Referral Contact Number..." required>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Email Address <span class="text-danger">*</span></label>
            <input class="form-control" type="email" name="referral_email" placeholder="Referral Last Name..." required>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="col-form-label">Position Applied <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="position_applied" placeholder="Referral Position Applied..." required>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            Reference Link
          <label class="col-form-label" data-toggle="tooltip" data-placement="bottom" data-offset="0,0" title="Portfolio Link, LinkedIn Profile, etc.">
              <i class="fa fa-question-circle" style="font-size: 17px;" aria-hidden="true"></i>
          </label>
            <input class="form-control" type="text" id="ref_link" placeholder="Referral Reference Link...">
            <input type="hidden" name="ref_link" id="orig_ref_link">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
              Attachment
            <label class="col-form-label" data-toggle="tooltip" data-placement="bottom" data-offset="0,0" title="Resume, CV, bio-data, etc.">
              <i class="fa fa-question-circle" style="font-size: 17px;" aria-hidden="true"></i>
          </label>
            <input class="form-control" type="file" name="file" placeholder="Referral Attachment..." accept=".pdf, .doc, .docx">
            <input type="hidden" name="path_url" value="{{ url('') }}">
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-12 text-right">
          <button class="btn btn-outline-info btn-submit" type="submit">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section('script')
<script>
  $(document).ready(function () {
      $('#ref_link').on('input', function() {
          let originalValue = $(this).val();
          let shortenValue = originalValue.length > 50 ? originalValue.substring(0, 50) + '...' : originalValue;
          $(this).val(shortenValue);
          $('#orig_ref_link').val(originalValue);
      });
  });
</script>
@endsection