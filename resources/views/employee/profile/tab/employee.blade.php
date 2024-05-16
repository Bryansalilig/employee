<form action="{{ route('employee.update') }}" method="post" autocomplete="off">
{{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $employee->id }}">
  <input type="hidden" name="info" value="employee">
  <div class="row">
    <div class="col-12">
      <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-user"></i> Basic Information</h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>First Name <span class="text-danger">*</span></label>
      <input class="form-control" type="text" name="first_name" placeholder="First Name" value="{{ old('first_name', $employee->first_name) }}" required>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Middle Name</label>
      <input class="form-control" type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name', $employee->middle_name) }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Last Name <span class="text-danger">*</span></label>
      <input class="form-control" type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name', $employee->last_name) }}" required>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Employee ID</label>
      <input class="form-control" type="text" name="eid" placeholder="ESCC-xxxxxxx" value="{{ $employee->eid }}" disabled>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Phone Name</label>
      <input class="form-control" type="text" name="alias" placeholder="Phone Name" value="{{ old('alias', $employee->alias) }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Birthdate</label>
      <input class="form-control mdate" type="text" name="birth_date" placeholder="YYYY-MM-DD" value="{{ old('birth_date', date('Y-m-d', strtotime($employee->birth_date))) }}" required>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Contact Number</label>
      <input class="form-control" type="text" name="contact_number" placeholder="xxxx-xxx-xxxx" value="{{ old('contact_number', $employee->contact_number) }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Gender</label>
      <select class="form-control" name="gender_id" required>
        <option value="1" {{ (old('gender_id', $employee->gender) == 1) ? "selected" : "" }}>Male</option>
        <option value="2" {{ (old('gender_id', $employee->gender) == 2) ? "selected" : "" }}>Female</option>
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Civil Status</label>
      <select class="form-control" name="civil_status" required>
        <option value="1" {{ (old('civil_status', $employee->civil_status) == 1) ? "selected" : "" }}>Single</option>
        <option value="2" {{ (old('civil_status', $employee->civil_status) == 2) ? "selected" : "" }}>Married</option>
        <option value="3" {{ (old('civil_status', $employee->civil_status) == 3) ? "selected" : "" }}>Separated</option>
        <option value="4" {{ (old('civil_status', $employee->civil_status) == 4) ? "selected" : "" }}>Anulled</option>
        <option value="5" {{ (old('civil_status', $employee->civil_status) == 5) ? "selected" : "" }}>Divorced</option>
      </select>
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Avega Number</label>
      <input class="form-control" type="text" name="avega_num" placeholder="xx-xx-xxxxx-xxxxx-xx" value="{{ @old('avega_num', $details->avega_num) }}" required>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-12 form-group">
      <label>City Address</label>
      <textarea name="address" class="form-control" rows="4">{{ old('address', $employee->address) }}</textarea>
    </div>
    <div class="col-md-6 col-12 form-group">
      <label>Home Town Address</label>
      <textarea name="town_address" class="form-control" rows="4">{{ @old('town_address', $details->town_address) }}</textarea>
    </div>
  </div>
  <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-users"></i> Family Details</h5>
  <div class="row">
    <div class="col-sm-6 col-12 form-group">
      <label>Father's Name</label>
      <input class="form-control" type="text" name="fathers_name" placeholder="Father's Name" value="{{ @old('fathers_name', $details->fathers_name) }}">
    </div>
    <div class="col-sm-6 col-12 form-group">
      <label>Father's Birthday</label>
      <input class="form-control mdate" type="text" name="fathers_bday" value="{{ (isset($details->fathers_bday) && $details->fathers_bday != '1970-01-01') ? date('Y-m-d', strtotime($details->fathers_bday )) : '' }}" placeholder="YYYY-MM-DD">
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6 col-12 form-group">
      <label>Complete Mother's Maiden Name</label>
      <input class="form-control" type="text" name="mothers_name" placeholder="Mother's Maiden Name" value="{{ isset($details->mothers_name) ? $details->mothers_name : '' }}">
    </div>
    <div class="col-sm-6 col-12 form-group">
      <label>Mother's Birthday</label>
      <input class="form-control mdate" type="text" name="mothers_bday" value="{{ (isset($details->mothers_bday) && $details->mothers_bday != '1970-01-01') ? date('Y-m-d', strtotime($details->mothers_bday )) : '' }}" placeholder="YYYY-MM-DD">
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6 col-12 form-group">
      <label>Spouse's Name</label>
      <input class="form-control" type="text" name="spouse_name" placeholder="Spouse's Name" value="{{ isset($details->spouse_name) ? $details->spouse_name : '' }}">
    </div>
    <div class="col-sm-6 col-12 form-group">
      <label>Spouse's Birthday</label>
      <input class="form-control mdate" type="text" name="spouse_bday" value="{{ (isset($details->spouse_bday) && $details->spouse_bday != '1970-01-01') ? date('Y-m-d', strtotime($details->spouse_bday )) : '' }}" placeholder="YYYY-MM-DD">
    </div>
  </div>
  <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-user-plus"></i> Dependents</h5>
  <div class="row">
    <div class="col-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Dependents Name</th>
            <th>Birthday</th>
            <th>Generali Number</th>
            <th width="90px">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($dependents as $key=>$dependent)
          <tr>
            <td>
              <input type="text" class="form-control" name="dependent_name[]" value="{{ $dependent->dependent }}" placeholder="Dependent's Name">
            </td>
            <td>
              <input type="text" class="form-control mdate" name="dependent_bday[]" value="{{ ($dependent->bday == '1970-01-01') ? '' : $dependent->bday }}" placeholder="YYYY-MM-DD">
            </td>
            <td>
              <input type="text" class="form-control" name="generali_num[]" value="{{ $dependent->generali_num }}" placeholder="xxxx-xxx-xxxx">
            </td>
            <td>
              @if($key == 0)
              <button class="btn btn-primary btn-block btn-add-dependent"><span class="fa fa-plus"></span></button>
              @else
              <button class="btn btn-danger btn-block btn-remove-dependent"><span class="fa fa-remove"></span></button>
              @endif
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-medkit"></i> In Case of Emergency</h5>
  <div class="row">
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Name</label>
      <input class="form-control" type="text" name="em_con_name" placeholder="Name" value="{{ empty($details->em_con_name) ? '' : $details->em_con_name }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Relationship</label>
      <input class="form-control" type="text" name="em_con_rel" placeholder="Relationship" value="{{ empty($details->em_con_rel) ? '' : $details->em_con_rel }}">
    </div>
    <div class="col-md-4 col-sm-6 col-12 form-group">
      <label>Contact Number</label>
      <input class="form-control" type="text" name="em_con_num" placeholder="Relationship" value="{{ empty($details->em_con_num) ? '' : $details->em_con_num }}">
    </div>
    <div class="col-12 form-group">
      <label>Address</label>
      <textarea class="form-control" name="em_con_address" rows="4">{{ empty($details->em_con_address) ? '' : $details->em_con_address }}</textarea>
    </div>
  </div>
  <div class="form-group">
    <button class="btn btn-info btn-submit" type="submit">Update Information</button>
  </div>
</form>

<script type="text/javascript">
$(function() {
  $('.btn-add-dependent').click(function(e) {
      e.preventDefault();

      var obj = $(this);
      var parent = obj.closest('tbody');
      var entry = parent.find('tr:first');
      var entry_last = parent.find('tr:last');

      var new_entry = entry.clone().insertAfter(entry_last);

      new_entry.find('.btn-add-dependent').html('<span class="fa fa-remove"></span>');
      new_entry.find('.btn-add-dependent').removeClass('btn-primary').addClass('btn-danger');
      new_entry.find('.btn-add-dependent').removeClass('btn-add-dependent').addClass('btn-remove-dependent');
      new_entry.find('input').val('');
      new_entry.find('.btn-remove-dependent').click(function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
      });
      new_entry.find('.mdate').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', maxDate: new Date(), time: false, clearButton: true });
  });

  $('.btn-remove-dependent').click(function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
  });
});
</script>
