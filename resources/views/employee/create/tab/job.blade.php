<div class="row">
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Position <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="position_name" placeholder="Position" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Account <span class="text-danger">*</span></label>
    <select class="form-control select2" name="account_id" required>
      @foreach($accounts as $account)
      <option value="{{ $account->id }}"><?= $account->account_name ?></option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label class="d-block">Department <span class="text-danger">*</span></label>
    <select class="form-control select2" name="department_id" required>
      @foreach($departments as $department)
      <option value="{{ $department->id }}">{{ $department->department_name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label class="d-block">Manager</label>
    <select class="form-control select2" name="manager_id">
      <option value="0">-- Select Manager --</option>
      @foreach($employees as $employee)
      <option value="{{ $employee->id }}">{{ $employee->fullname() }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label class="d-block">Immediate Superior</label>
    <select class="form-control select2" name="supervisor_id">
      <option value="0">-- Select Immediate Superior --</option>
      @foreach($employees as $employee)
      <option value="{{ $employee->id }}">{{ $employee->fullname() }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label class="d-block">Employee Type <span class="text-danger">*</span></label>
    <select class="form-control select2" name="is_regular" required>
      <option value="0" selected>Probationary</option>
      <option value="1">Regular</option>
      <option value="2">Project Based</option>
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label class="d-block">Employee Category <span class="text-danger">*</span></label>
    <select class="form-control select2" name="employee_category" required>
      <option value="1">Manager</option>
      <option value="2">Supervisor</option>
      <option value="3">Support</option>
      <option value="4" selected>Rank</option>
    </select>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Hired Date <span class="text-danger">*</span></label>
    <input class="form-control mdate" type="text" name="hired_date" placeholder="YYYY-MM-DD" required>
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Production Date</label>
    <input class="form-control mdate" type="text" name="prod_date" placeholder="YYYY-MM-DD">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Regularization Date</label>
    <input class="form-control mdate" type="text" name="regularization_date" placeholder="YYYY-MM-DD">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>EXT</label>
    <input class="form-control" type="text" name="ext" placeholder="EXT">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Wave</label>
    <input class="form-control" type="text" name="wave" placeholder="Wave">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Resignation Date</label>
    <input class="form-control mdate" type="text" name="resignation_date" placeholder="YYYY-MM-DD">
  </div>
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label class="d-block">Rehirable</label>
    <select class="form-control" name="rehirable">
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select>
  </div>
  <div class="col-12 form-group">
    <label>Reason</label>
    <input class="form-control" type="text" name="rehire_reason" placeholder="State your reason...">
  </div>
  <div class="col-12 form-group">
    <label>Notes</label>
    <textarea name="notes" class="form-control" rows="4" placeholder="Notes"></textarea>
  </div>
</div>
<div class="form-group text-right">
  <button class="btn btn-default btn-tab" data-tab="emergency">Previous</button>
  <button class="btn btn-info btn-tab" data-tab="government">Next</button>
</div>
