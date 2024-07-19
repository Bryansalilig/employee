<div class="row">
  <div class="col-sm-6 col-12 form-group">
    <label>Employee <span class="text-danger">*</span></label>
    <select class="form-control select2" id="select-employee" name="employee_id" required>
      @foreach($employees as $employee)
      <option value="{{ $employee->id }}" {{ ($employee->id == Auth::user()->id) ? 'selected' : '' }}>{{ formatName($employee->last_name.', '.$employee->first_name) }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-sm-6 col-12 form-group">
    <label>Date Filed</label>
    <input class="form-control" type="text" name="date_filed" value="{{ date('Y-m-d') }}" readonly>
  </div>
</div>
