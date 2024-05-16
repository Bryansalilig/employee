<div class="row">
  <div class="col-12">
    <a href="javascript:;" data-toggle="modal" data-target="#modal-add-movement" class="btn btn-info pull-right">Add Movement</a>
    <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-arrows"></i> Staff Position Movements</h5>
  </div>
</div>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Date of Transfer</th>
      <th>Department</th>
      <th>Position</th>
    </tr>
  </thead>
  <tbody>
    @if(count($movements) == 0)
    <tr>
      <td colspan="3" class="text-center">No Results Found</td>
    </tr>
    @endif
    @foreach($movements as $no=>$movement)
    <tr>
      <td>{{ date('m/d/Y', strtotime($movement->mv_transfer_date)) }}</td>
      <td>{{ $movement->department_name }}</td>
      <td>{{ $movement->mv_position }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div id="modal-add-movement" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('movement.store') }}" method="post" autocomplete="off">
      {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $employee->id }}">
        <div class="ibox ibox-info mb-0">
          <div class="ibox-head">
            <div class="ibox-title">Employee Movement</div>
            <div class="ibox-tools">
              <a data-dismiss="modal"><i class="fa fa-times"></i></a>
            </div>
          </div>
          <div class="ibox-body">
            <div class="row">
              <div class="col-md-6 col-12 form-group">
                <label>Date <span class="text-danger">*</span></label>
                <input type="text" class="form-control mdate" name="movement_date" placeholder="YYYY-MM-DD" required>
              </div>
              <div class="col-md-6 col-12 form-group">
                <label>Department <span class="text-danger">*</span></label>
                <select class="form-control select2" name="movement_department" required>
                  <option value="">-- Department --</option>
                  @foreach($departments as $department)
                  <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 form-group mb-0">
                <label>Position <span class="text-danger">*</span></label>
                <select class="form-control select2" id="select-position">
                  <option value="">-- Position --</option>
                  @foreach($positions as $position)
                  <option value="{{ $position->position_name }}">{{ $position->position_name }}</option>
                  @endforeach
                  <option value="Others">Others</option>
                </select>
                <input type="text" class="form-control d-none mt-2" name="movement_position" id="input-position" placeholder="New Position" required>
              </div>
            </div>
          </div>
          <div class="ibox-footer pull-right px-4">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-submit">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function(e) {
  $('#select-position').change(function(e) {
    e.preventDefault();

    if($(this).val() == 'Others') {
      $('#input-position').val('').removeClass('d-none');
    } else {
      $('#input-position').val($(this).val()).addClass('d-none');
    }
  });
});
</script>
