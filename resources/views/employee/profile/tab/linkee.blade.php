<div class="row">
  <div class="col-12">
    <a href="javascript:;" data-toggle="modal" data-target="#modal-add-linkee" class="btn btn-info pull-right">Add Linkee</a>
    <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-cogs"></i> Linkees</h5>
  </div>
</div>
@php $link = [] @endphp
@if(count($linkees) > 0)
<ul class="media-list media-list-divider m-0 row">
  @foreach($linkees as $key=>$linkee)
  @php $link[] = $linkee->id @endphp
  <li class="media col-6 px-2 {{ ($key == 1) ? 'border-0' : '' }}" data-emp-id="{{ $linkee->id }}">
    <div class="media-img">
      <div class="img-circle" style="background-image: url('{{ $linkee->profile_img }}');"></div>
    </div>
    <div class="media-body">
      <div class="media-heading">
        {{ formatName($linkee->first_name.' '.$linkee->last_name) }}

        <a href="javascript:;" class="text-danger pull-right btn-delete-linkee" data-id="{{ $linkee->id }}"><i class="fa fa-remove"></i></a>
      </div>
      <div class="font-13">
        <a href="mailto:{{ $linkee->email }}">{{ $linkee->email }}</a><br>
        {{ $linkee->position_name }}
      </div>
    </div>
  </li>
  @endforeach
</ul>
@else
<div class="row">
  <div class="col-md-12">
    <br>
    <br>
    <div class="text-center">
      <h3>No linkees found.</h3>
    </div>
  </div>
</div>
@endif

<div id="modal-add-linkee" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('linking.store') }}" method="post" autocomplete="off">
      {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $employee->id }}">
        <div class="ibox ibox-info mb-0">
          <div class="ibox-head">
            <div class="ibox-title">Add Linkee</div>
            <div class="ibox-tools">
              <a data-dismiss="modal"><i class="fa fa-times"></i></a>
            </div>
          </div>
          <div class="ibox-body">
            <div class="row">
              <div class="col-12 form-group">
                <label>Linkee <span class="text-danger">*</span></label>
                <select class="form-control select2" name="linkee" id="select-linkee" required>
                  <option value="">-- Employee List --</option>
                  @foreach($supervisors as $supervisor)
                  @if(!in_array($supervisor->id, $link))
                  <option value="{{ $supervisor->id }}" data-name="{{ formatName($supervisor->fullname()) }}" data-profile-img="{{ $supervisor->profile_img }}" data-position-name="{{ $supervisor->position_name }}" data-email="{{ $supervisor->email }}">{{ $supervisor->fullname() }}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <ul class="media-list media-list-divider m-0" id="media-employee"></ul>
              </div>
            </div>
          </div>
          <div class="ibox-footer pull-right px-4">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-submit">Add</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function showLoading()
{
  $('#media-employee').addClass('text-center');
  $('#media-employee').html('<i class="fa fa-spinner fa-spin"></i>');
}
$(function() {
  $('#select-linkee').change(function(e) {
    showLoading();

    if($(this).val()) {
      html = '<li class="media">';
      html += '<div class="media-img">';
      html += '<div class="img-circle" style="background-image: url(\''+$(this).find(':selected').attr('data-profile-img')+'\');"></div>';
      html += '</div>';
      html += '<div class="media-body">';
      html += '<div class="media-heading">'+$(this).find(':selected').attr('data-name')+'</div>';
      html += '<div class="font-13">';
      html += '<a href="mailto:'+$(this).find(':selected').attr('data-email')+'">'+$(this).find(':selected').attr('data-email')+'</a><br>';
      html += $(this).find(':selected').attr('data-position-name');
      html += '</div>';
      html += '</div>';
      html += '</li>';

      setTimeout(function() {
        $('#media-employee').removeClass('text-center');
        $('#media-employee').html(html);
      }, 500);

      return false;
    }

    $('#media-employee').empty();
  });

  $('.btn-delete-linkee').click(function(e) {
    e.preventDefault();

    var obj = $(this);
    var parent = obj.closest('li');
    var id = parent.data('emp-id');

    swal({
      title: 'Are you sure you want to remove this linkee?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55'
    }, function() {
      $.post('{{ route("linking.delete") }}', {'_token':$('input[name="_token"]').val(), 'linker':'{{ $employee->id }}', 'linkee':obj.data('id')}, function(data) {
        if (data.ret == 1) {
          swal({
            title: 'Deleted!',
            text: data.msg,
            type: 'success'
          }, function() {
            parent.hide(500);
          });
        }
      }, 'json');
    });

    return false;
  });
});
</script>
