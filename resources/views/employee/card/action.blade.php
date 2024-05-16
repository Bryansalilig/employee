<div class="ibox ibox-info mb-0 mt-4 collapsed-mode">
  <div class="ibox-head" style="height: 40px;">
    <div class="ibox-title" style="font-size: 14px;"><i class="fa fa-hand-pointer-o mr-1"></i>&nbsp; Action</div>
    <div class="ibox-tools">
      <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
    </div>
  </div>
  <div class="ibox-body p-3" style="display: none;">
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <a href="{{ route('employee.create') }}" class="btn btn-primary btn-block"><i class="fa fa-user-plus"></i> Add Employee</a>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <a href="javascript:;" class="btn btn-success btn-block"><i class="fa fa-download"></i> Download</a>
        </div>
      </div>
      <div class="col-12">
        <a href="{{ route('employees.card') }}" class="btn btn-info btn-block"><i class="fa fa-id-card"></i> Card View</a>
      </div>
    </div>
  </div>
</div>
