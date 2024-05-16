<div class="row">
  <div class="col-12">
    <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-history"></i> History</h5>
  </div>
</div>
<ul class="media-list media-list-divider m-0" id="media-log">
@foreach($logs as $log)
  @if($log->employee_id == Auth::user()->id)
  <li class="media text-right">
    <div class="media-body">
      <div class="media-heading">{{ formatName($log->first_name.' '.$log->lastname) }} <small class="float-left text-muted">{{ $log->created_at }}</small></div>
      <div class="font-13">{{ $log->message }}</div>
    </div>
    <div class="media-img">
      <div class="img-circle" style="background-image: url('{{ $log->profile_img }}');"></div>
      <!-- <i class="ti-user font-18 text-muted"></i> -->
    </div>
  </li>
  @else
  <li class="media">
    <div class="media-img">
      <div class="img-circle" style="background-image: url('{{ $log->profile_img }}');"></div>
    </div>
    <div class="media-body">
      <div class="media-heading">{{ formatName($log->first_name.' '.$log->lastname) }} <small class="float-right text-muted">{{ $log->created_at }}</small></div>
      <div class="font-13">{{ $log->message }}</div>
    </div>
  </li>
  @endif
@endforeach
</ul>
<div class="row">
  <div class="col-12">
    <div class="text-center mt-2">
      <a href="javascript:;" id="btn-load-more">Load More...</a>
      <span class="fa fa-spinner" id="loading" style="display: none;"></span>
    </div>
  </div>
</div>

<script type="text/javascript">
var current_page = 2;
$(function() {
  $('#btn-load-more').click(function(){
    $('#loading').show();
    $('#btn-load-more').hide();
    $.ajax({
      url: "{{ route('log.load') }}" + "?page=" + current_page + "&employee_id=" + '{{ $employee->id }}',
      success: function(result){
        setTimeout(function(){
          $('#loading').hide();
          $('#btn-load-more').show();

          if(result === '') {
            $('#btn-load-more').hide();
          } else {
            $('#media-log li:last-of-type').after(result);
          }
        }, 1500);
        current_page++;
      }, error: function(){
        $('#loading').hide(); 
        $('#btn-load-more').show();
      }
    });
  });
})
</script>
