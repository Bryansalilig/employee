<div class="ibox ibox-info mb-0 mt-4 collapsed-mode">
  <div class="ibox-head" style="height: 40px;">
    <div class="ibox-title" style="font-size: 14px;"><i class="fa fa-filter mr-1"></i>&nbsp; Filter</div>
    <div class="ibox-tools">
      <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
    </div>
  </div>
  @php
    $display = false;

    if(isset($request->department) || isset($request->position) || isset($request->birthmonth) || isset($request->keyword)) { $display = true; }
  @endphp
  <div class="ibox-body p-3" style="{{ $display ? '' : 'display: none;' }}">
    <div class="row">
      <div class="form-group col-12">
        <div class="input-group">
          {{ csrf_field() }}
          <input class="form-control" id="search_employee" type="text" placeholder="Search..." value="{{ $request->keyword }}">
          <div class="input-group-btn">
            <button class="btn btn-primary" type="button" style="cursor: pointer;" id="search">Search</button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-sm-4 col-12">
        <select class="form-control" id="sort_option_list" style="height: auto;">
          <option value="1" {{ isset($request->department) ? "selected" : "" }}>Department</option>
          <option value="2" {{ isset($request->position) ? "selected" : "" }}>Position</option>
          <option value="3" {{ isset($request->birthmonth) ? "selected" : "" }}>Birth Month</option>
        </select>
      </div>
      <div class="form-group col-sm-8 col-12">
        <select class="form-control" id="departments_list" style="height: auto;display: none;">
          <option disabled selected>Search by Department:</option>
          @foreach($departments as $department)
          <option value="{{ $department->department_name }}" {{ $request->department == $department->department_name ? "selected" : "" }}>{{ $department->department_name }}</option>
          @endforeach
        </select>
        <select class="form-control" id="position_list" style="height: auto;display: none;">
          <option disabled selected>Search by Position:</option>
          @foreach($positions as $position)
          <option value="{{ $position->position_name }}" {{ $request->position == $position->position_name ? "selected" : "" }}>{{ $position->position_name }}</option>
          @endforeach
        </select>
        <select class="form-control" id="month_list" style="height: auto;display: none;">
          <option disabled selected>Search by Birth Month:</option>
          @for($m = 1; $m <= 12; $m++)
          <option value="<?= $m ?>" {{ $request->birthmonth == $m ? " selected" : "" }}>{{ date('F', mktime(0, 0, 0, $m, 1, date('Y'))) }}</option>
          @endfor
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <a href="javascript:;" class="btn btn-danger btn-block" id="no_profile_images"><i class="fa fa-file-image-o"></i> No Profile Image</a>
      </div>
      <div class="col-md-4 col-12">
        <a href="javascript:;" class="btn btn-danger btn-block" id="invalid_birth_date"><i class="fa fa-calendar-times-o"></i> Invalid Birthdate</a>
      </div>
      <div class="col-md-4 col-12">
        <a href="{{ url('employees-card') }}" class="btn btn-default btn-block" id="invalid_birth_date"><i class="fa fa-filter"></i> Clear Filter</a>
      </div>
    </div>
  </div>
</div>

@section('script')
<script type="text/javascript">
function rfc3986EncodeURIComponent (str) {  
  return encodeURIComponent(str).replace(/[!'()*]/g, escape);
}
function filterList(value)
{
  switch(value){
    case '1':
      $('#departments_list').show();
      $('#position_list').hide();
      $('#month_list').hide();
    break;
    case '2':
      $('#departments_list').hide();
      $('#position_list').show();
      $('#month_list').hide();
    break;
    case '3':
      $('#departments_list').hide();
      $('#position_list').hide();
      $('#month_list').show();
    break;
  }
}
function filterData(filter)
{
  var url = location.protocol + '//' + location.host + location.pathname;

  url += "?" + filter;
  window.location.replace(url);
}
$(function() {
  filterList($('#sort_option_list').val());

  $('#sort_option_list').change(function(){
    filterList($(this).val());
  });

  $('#departments_list').change(function(){
    var filter = "department=" + rfc3986EncodeURIComponent($(this).val());

    filterData(filter);
  });

  $('#month_list').change(function(){
      var filter = "birthmonth=" + $(this).val();

      filterData(filter);
  });

  $('#position_list').change(function(){
    var filter = "position=" + rfc3986EncodeURIComponent($(this).val());

    filterData(filter);
  });

  $('#no_profile_images').click(function(){
    var filter = "no_profile_images=" + true;

    filterData(filter);
  });

  $('#invalid_birth_date').click(function(){
    var filter = "invalid_birth_date=" + true;

    filterData(filter);
  });

  $('#search').click(function(){
    var filter = "keyword=" + rfc3986EncodeURIComponent($('#search_employee').val());

    if($('#search_employee').val() === '') {
      $('#search_employee').focus();
      return false;
    }

    filterData(filter);
  });

  $('#search_employee').keyup(function(e) {
    e.preventDefault();

    if(e.keyCode === 13) {
      $('#search').click();
    }
  });
});
</script>
@endsection
