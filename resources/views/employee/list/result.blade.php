<div class="ibox" style="background: unset;">
  <div class="ibox-body p-0">
    <div class="candidate-list">
    @foreach($employees as $employee)
      <div class="candidate-list-box card mb-2">
        <div class="p-3 card-body">
          <div class="align-items-center row">
            <div class="col-auto">
              <div class="candidate-list-images">
                <a href="{{ url("employee-info/{$employee->slug}") }}">
                  <div class="avatar-md img-thumbnail rounded-circle" style="background-image: url('{{ $employee->profile_img }}');"></div>
                </a>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="candidate-list-content mt-3 mt-lg-0">
                <h5 class="fs-19 mb-0"> 
                  <a class="primary-link" href="{{ url("employee-info/{$employee->slug}") }}">{{ $employee->fullname() }}</a>
                </h5>
                <p class="text-muted mt-1 mb-0">{{ $employee->position_name }}</p>
                <ul class="list-inline mb-0 text-muted">
                  <li class="list-inline-item">
                    <i class="fa fa-sitemap mr-1"></i> {{ $employee->team_name }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3">
              <span class="badge bg-secondary"><i class="fa fa-id-card align-middle mr-1"></i>{{ $employee->eid }}</span>
              <a href="mailto:{{ $employee->email }}" class="d-block mt-1" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                <span class="badge bg-primary"><i class="fa fa-envelope align-middle mr-1"></i>{{ $employee->email }}</span>
              </a>
              @if(isset($employee->alias) && $employee->alias != '--' && $employee->alias != '')
              <span class="badge bg-warning mt-1"><i class="fa fa-address-book align-middle mr-1"></i>{{ $employee->alias }}</span>
              @endif
            </div>
            <div class="col-lg-auto">
              @if($employee->supervisor_name != 'NO SUPERVISOR')
              <span class="d-block mb-1"><i class="fa fa-user mr-1"></i> <span class="text-muted">Immediate Superior:</span> {{ $employee->supervisor_name }}</span>
              @endif
              @if($employee->manager_name != 'NO MANAGER')
              <span><i class="fa fa-user mr-1"></i> <span class="text-muted">Manager:</span> {{ $employee->manager_name }}</span>
              @endif
            </div>
          </div>
          <div class="favorite-icon"> 
            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(41px, 20px, 0px); top: 0px; left: 0px; will-change: transform;">
              <a class="dropdown-item" href="{{ url("employee-info/{$employee->slug}") }}">Edit</a>
              @if($active)
              <a class="dropdown-item btn-deactivate" href="javascript:;" data-id="{{ $employee->id }}">Deactivate</a>
              @else
              <a class="dropdown-item btn-reactivate" href="javascript:;" data-id="{{ $employee->id }}">Reactivate</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('.btn-reactivate').click(function(e) {
    e.preventDefault();

    var obj = $(this);

    swal({
      title: 'Are you sure you want to reactivate this employee?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#87ceeb'
    }, function() {
      $.post('{{ route("employee.reactivate") }}', {'_token':$('input[name="_token"]').val(), 'id':obj.data('id')}, function(data) {
        if (data.ret == 1) {
          swal({
            title: 'Reactivated!',
            text: data.msg,
            type: 'success'
          }, function() {
            window.location.replace(data.url);
          });
        }
      }, 'json');
    });

    return false;
  });

  $('.btn-deactivate').click(function(e) {
    e.preventDefault();

    var obj = $(this);

    swal({
      title: 'Are you sure you want to deactivate this employee?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e74c3c'
    }, function() {
      $.post('{{ route("employee.deactivate") }}', {'_token':$('input[name="_token"]').val(), 'id':obj.data('id')}, function(data) {
        if (data.ret == 1) {
          swal({
            title: 'Deactivated!',
            text: data.msg,
            type: 'success'
          }, function() {
            window.location.replace(data.url);
          });
        }
      }, 'json');
    });

    return false;
  });
});
</script>
