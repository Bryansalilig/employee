@extends('layout.main')
@section('style')
<style type="text/css">

</style>
@endsection
@section('content')
<div class="page-heading">
  <h1 class="page-title">Department</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Department</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">Add Department</div>
      <a href="{{ url('activities') }}" class="btn btn-danger pull-right"><i class="fa fa-undo"></i>&nbsp;&nbsp;Back</a>
    </div>
    <div class="ibox-body">
      <form role="form" method="POST" action="{{ route('department.store') }}" novalidate="novalidate" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="col-form-label">Department Name <span class="text-danger">*</span></label>
              <div class="input-group-icon right">
                <div class="input-icon d-none"><i class="fa fa-exclamation"></i></div>
                <input class="form-control" type="text" name="department_name" required>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="col-form-label">Department Code <span class="text-danger">*</span></label>
              <div class="input-group-icon right">
                <div class="input-icon d-none"><i class="fa fa-exclamation"></i></div>
                <input class="form-control" type="text" name="department_code" required>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="col-form-label">Division <span class="text-danger">*</span></label>
                <select class="form-control select2" name="division_id">
                  <option value="" selected disabled>Select Division</option>
                  @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                  @endforeach
                </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="col-form-label">Account <span class="text-danger">*</span></label>
                <select class="form-control select2" name="account_id">
                  <option value="" selected disabled>Select Account</option>
                  @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                  @endforeach
                </select>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12 text-right">
            <button class="btn btn-outline-info btn-submit" type="submit">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
@endsection