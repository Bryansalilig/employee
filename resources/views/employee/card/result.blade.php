<div class="row justify-content-center" id="card-data">
@php
  $count = 1;
  $row = 1;
@endphp
@foreach($employees as $employee)
  <div class="col-3" data-row="{{ $row }}">
    <div class="ibox ibox-info" data-id="{{ $employee->id }}" data-eid="{{ $employee->eid }}" data-slug="{{ $employee->slug }}">
      <div class="ibox-head">
        <h6 class="ibox-title mb-0"><span class="fa fa-id-card"></span>&nbsp;&nbsp; {{ $employee->eid }}</h6>
      </div>
      <div class="ibox-body text-center">
        <div class="img-profile m-t-10 m-b-20">
          <div class="img-circle">
            <img src="{{ $employee->profile_img }}" alt="{{ formatName($employee->fullname()) }}">
          </div>
        </div>
        <h5 class="font-strong m-b-10">{{ formatName($employee->fullname()) }}</h5>
        <div class="text-muted text-position">{{ $employee->position_name }}</div>
        <div class="m-b-10 text-muted text-department">{{ $employee->team_name }}</div>
      </div>
    </div>
  </div>
@php
  if($count % 4 == 0) { $row++; }
  $count++;
@endphp
@endforeach
</div>

<div id="modal-view-employee" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="ibox ibox-info mb-0">
        <div class="ibox-head">
          <div class="ibox-title"></div>
          <div class="ibox-tools">
            <a data-dismiss="modal"><i class="fa fa-times"></i></a>
          </div>
        </div>
        <div class="ibox-body" id="modal-employee-body">
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
var name_h = 19.25;
var position_h = 21;
var team_h = 21;

$(function() {
  $('#card-data .col-3').each(function(key){
    var row = $(this).data('row');
    var name = $(this).find('h5');
    var position = $(this).find('.text-position');
    var team = $(this).find('.text-department');

    if(name_h != name.height()) {
      var h = (name_h > name.height()) ? name_h : name.height();
      $('#card-data .col-3[data-row="'+row+'"]').find('h5').addClass('text-align-center').height(h);
    }

    if(position_h != position.height()) {
      var h = (position_h > position.height()) ? position_h : position.height();
      $('#card-data .col-3[data-row="'+row+'"]').find('.text-position').addClass('text-align-center').height(h);
    }

    if(team_h != team.height()) {
      var h = (team_h > team.height()) ? team_h : team.height();
      $('#card-data .col-3[data-row="'+row+'"]').find('.text-department').addClass('text-align-center').height(h);
    }
  });
});
</script>
@if(Auth::user()->isAdmin())
<script type="text/javascript">
$(function() {
  $('#card-data .ibox').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var slug = obj.data('slug');
    var url = location.protocol + '//' + location.host + '/employee-info/' + slug;

    window.location.replace(url);
  });
});
</script>
@else
<script type="text/javascript">
$(function() {
  $('#card-data .ibox').click(function(e) {
    e.preventDefault();

    var obj = $(this);

    $.get("{{ route('employee.view') }}", { id : obj.data('id') }, function(data) {
      if(data.ret) {
        $('#modal-view-employee').modal('show');
        $('#modal-view-employee').find('.ibox-title').html('<span class="fa fa-id-card"></span>&nbsp;&nbsp; ' + obj.data('eid'));
        $('#modal-employee-body').empty();
        $('#modal-employee-body').html(data.html);
      } else {
        $.messageHandler.customMessage('warning', data.msg);
      }
    });
  });
});
</script>
@endif
