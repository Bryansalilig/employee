<form action="{{ route('employee.update') }}" method="post" autocomplete="off">
{{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $employee->id }}">
  <input type="hidden" name="info" value="job">
  <input type="hidden" name="status_id" value="{{ $employee->status || 1 }}" />
  <div class="row">
    <div class="col-12">
      <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-building-o"></i> Job Information</h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Position</label>
      <input class="form-control" type="text" name="position_name" placeholder="Position" value="{{ $employee->position_name }}" disabled>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Account</label>
      <select class="form-control select2" name="account_id" required>
        @foreach($accounts as $account)
        <option value="{{ $account->id }}" {{ $employee->account_id == $account->id ? " selected" : "" }}><?= $account->account_name ?></option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label class="d-block">Department</label>
      <input class="form-control" type="text" name="team_name" placeholder="Department" value="{{ $employee->team_name }}" disabled>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label class="d-block">Manager</label>
      <select class="form-control select2" name="manager_id" required>
        <option value="0">-- Select Manager --</option>
        @foreach($supervisors as $supervisor)
        <option value="{{ $supervisor->id }}"{{ $supervisor->id == $employee->manager_id ? " selected" : "" }}>{{ $supervisor->fullname() }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label class="d-block">Immediate Superior</label>
      <select class="form-control select2" name="supervisor_id" required>
        <option value="0">-- Select Immediate Superior --</option>
        @foreach($supervisors as $supervisor)
        <option value="{{ $supervisor->id }}"{{ $supervisor->id == $employee->supervisor_id ? " selected" : "" }}>{{ $supervisor->fullname() }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label class="d-block">Employee Type</label>
      <select class="form-control select2" name="is_regular" required>
        <option value="0"{{ $employee->is_regular == 0 ? ' selected' : '' }}>Probationary</option>
        <option value="1"{{ $employee->is_regular == 1 ? ' selected' : '' }}>Regular</option>
        <option value="2"{{ $employee->is_regular == 2 ? ' selected' : '' }}>Project Based</option>
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label class="d-block">Employee Category</label>
      <select class="form-control select2" name="employee_category" required>
        <option value="1"{{ $employee->employee_category == 1 ? ' selected' : '' }}>Manager</option>
        <option value="2"{{ $employee->employee_category == 2 ? ' selected' : '' }}>Supervisor</option>
        <option value="3"{{ $employee->employee_category == 3 ? ' selected' : '' }}>Support</option>
        <option value="4"{{ $employee->employee_category == 4 ? ' selected' : '' }}>Rank</option>
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Hired Date</label>
      <input class="form-control mdate" type="text" name="hired_date" value="{{ (isset($employee->hired_date) && $employee->hired_date != '1970-01-01') ? date('Y-m-d', strtotime($employee->hired_date)) : '' }}" placeholder="YYYY-MM-DD" required>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Production Date</label>
      <input class="form-control mdate" type="text" name="prod_date" value="{{ (isset($employee->prod_date) && $employee->prod_date != '1970-01-01') ? date('Y-m-d', strtotime($employee->prod_date)) : '' }}" placeholder="YYYY-MM-DD">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Regularization Date</label>
      <input class="form-control mdate" type="text" name="regularization_date" value="{{ (isset($employee->regularization_date) && $employee->regularization_date != '1970-01-01') ? date('Y-m-d', strtotime($employee->regularization_date)) : '' }}" placeholder="YYYY-MM-DD">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>EXT</label>
      <input class="form-control" type="text" name="ext" placeholder="EXT" value="{{ $employee->ext }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Wave</label>
      <input class="form-control" type="text" name="wave" placeholder="Wave" value="{{ $employee->wave }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Resignation Date</label>
      <input class="form-control mdate" type="text" name="resignation_date" value="{{ (isset($details->resignation_date) && $details->resignation_date != '1970-01-01') ? date('Y-m-d', strtotime($details->resignation_date)) : '' }}" placeholder="YYYY-MM-DD">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label class="d-block">Rehirable</label>
      <select class="form-control select2" name="rehirable">
        <option value="1" {{ (isset($details->rehirable) && $details->rehirable == 1) ? "selected" : "" }}>Yes</option>
        <option value="0" {{ (isset($details->rehirable) && $details->rehirable == 0) ? "selected" : "" }}>No</option>
      </select>
    </div>
    <div class="col-12 form-group">
      <label>Reason</label>
      <input class="form-control" type="text" name="rehire_reason" placeholder="State your reason..." value="{{ isset($details->rehire_reason) ? $details->rehire_reason : '' }}">
    </div>
    <div class="col-12 form-group">
      <label>Notes</label>
      <textarea name="notes" class="form-control" rows="4" placeholder="Notes">{{ isset($employee->notes) ? $employee->notes : '' }}</textarea>
    </div>
  </div>
  <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-university"></i> Government Numbers</h5>
  <div class="row">
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>SSS Number</label>
      <input class="form-control" type="text" name="sss" placeholder="xx-xxxxxxx-x" value="{{ $employee->sss }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Pag-ibig/HDMF</label>
      <input class="form-control" type="text" name="pagibig" placeholder="xxxx-xxxx-xxxx" value="{{ $employee->pagibig }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Philhealth Number</label>
      <input class="form-control" type="text" name="philhealth" placeholder="xx-xxxxxxxxx-x" value="{{ $employee->philhealth }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>TIN ID</label>
      <input class="form-control" type="text" name="tin" placeholder="xxx-xxx-xxx-xxx" value="{{ $employee->tin }}">
    </div>
  </div>
  <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-key"></i> Login Credentials</h5>
  <div class="row">
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Company Email</label>
      <input class="form-control" type="email" name="email" placeholder="email@elink.com.ph" value="{{ $employee->email }}" required>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Personal Email</label>
      <input class="form-control" type="email" name="email2" placeholder="personal@email.com" value="{{ $employee->email2 }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Secondary Email</label>
      <input class="form-control" type="email" name="email3" placeholder="secondary@email.com" value="{{ $employee->email3 }}">
    </div>
  </div>
  <div class="form-group">
    <button class="btn btn-info" type="submit">Update Information</button>
  </div>
</form>
