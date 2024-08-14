@extends('layout.main')
@include('overtime.style')
@section('content')
<style>
  .select2-selection__arrow {
  display: <?= (Auth::user()->isAdmin()) ? 'block' : 'none' ?>;
  }
</style>
<div class="page-heading my-2">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Timekeeping</li>
    <li class="breadcrumb-item">Overtime</li>
    <li class="breadcrumb-item">File Overtime</li>
  </ol>
</div>
<div class="row">
  <div class="col-12 text-right">
    <a href="{{ route('overtime') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i> Back</a>
  </div>
</div>
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <div class="ibox ibox-danger">
        <div class="text-center">
          <?php
            $status = $overtime->status;
            if($overtime->status == 'APPROVED' && !empty($overtime->approved_reason)) {
                $status = 'REVERTED';
            }
            $lowerStatus = mb_strtolower($status, 'UTF-8');
            $status = ucwords($lowerStatus);
            ?>
          <button class="status-info font-strong <?=
            ($status == 'Pending') ? 'bg-primary' :
            (($status == 'Approved') ? 'bg-success' :
            (($status == 'Verifying') ? 'bg-warning' :
            (($status == 'Verified') ? 'bg-purple' :
            (($status == 'Completed') ? 'bg-info' :
            (($status == 'Declined' || $status == 'Not Approve' || $status == 'Reverted') ? 'bg-danger' :
            ''))))) ?>"><?= $status?></button>
        </div>
        <div class="ibox-body text-center">
          <div class="m-t-20 img-profile">
            <div class="img-circle circle-danger">
              <img id="profile-img">
            </div>
          </div>
          <h5 class="font-strong m-b-10 m-t-10" id="fullname"></h5>
          <div class="text-muted" id="position"></div>
          <div class="m-b-20 text-muted" id="department"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
          <form action="{{ route('overtime.store') }}" id="createId" method="post" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <ul class="nav nav-tabs nav-fill tabs-line">
              <li class="nav-item">
                <a class="nav-link active" href="#tab-appraisee" data-toggle="tab"><i class="fa fa-clock-o fa-1x"></i> Request</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#tab-reviewed" data-toggle="tab"><i class="fa fa-thumbs-o-up fa-1x" aria-hidden="true"></i> Reviewed by</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#tab-timekeeping" data-toggle="tab"><i class="fa fa-calendar-o fa-1x" aria-hidden="true"></i> Timekeeping</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#tab-log" data-toggle="tab"><i class="ti-notepad"></i> Log</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-appraisee">
                <div class="row">
                  <div class="col-md-12" style="border-right: 1px solid #eee;">
                    <?php
                      $i = 0;
                      $position = '';
                      $department = '';
                      $profile_img = '';
                      $fullname = '';
                      if($i == 0) {
                        $position = $overtime->position_name;
                        $department = $overtime->team_name;
                        $profile_img = $employee->profile_img;
                        $fullname = $overtime->last_name . ', ' . $overtime->first_name;
                        }

                      $i++;
                      ?>
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Overtime Date</th>
                          <th class="text-center">No. of Hours (Estimated)</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>No. of Hours(Actual)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach($overtime->dates as $key=>$date){
                          ?>
                        <tr>
                          <td><?= date('F d, Y',strtotime($date)) ?></td>
                          <td class="text-center"><?= $overtime->no_of_hours[$key]?><?= ($overtime->no_of_hours[$key] > 1) ? " hrs" : " hr"?></td>
                          <td><?= empty($overtime->time_in[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_in[$key])) ?></td>
                          <td><?= empty($overtime->time_out[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_out[$key])) ?></td>
                          <td><?= numberOfHours($overtime->time_in[$key], $overtime->time_out[$key], false, true) ?></td>
                        </tr>
                        <?php
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4 form-group info">
                    <br>
                    <label>Date filed:</label>
                    <p class="text-display"><?= slashedDate($overtime->created_at) ?></p>
                  </div>
                  <div class="col-md-4 form-group info">
                    <br>
                    <label>Contact Number:</label>
                    <p class="text-display"><?= $overtime->contact_number ?></p>
                  </div>
                  <div class="col-md-4 form-group info">
                    <br>
                    <label>Total No. of Hours:</label>
                    <p class="text-display"><?= array_sum($overtime->no_of_hours) ?></p>
                  </div>
                  <div class="col-md-6 form-group info">
                    <br>
                    <label>Reason:</label>
                    <p class="text-display"><?= htmlentities($overtime->reason) ?></p>
                  </div>
                  <?php
                    if(!empty($overtime->reverted_reason)) {
                    ?>
                  <div class="col-md-6 form-group info">
                    <br>
                    <label>Revert Reason:</label>
                    <p class="text-display"><?= htmlentities($overtime->reverted_reason) ?></p>
                  </div>
                  <?php
                    }
                    ?>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-reviewed">
                <div class="row">
                  <div class="col-md-12" style="border-right: 1px solid #eee;">
                    <ul class="media-list media-list-divider m-0 row">
                      <li class="media col-6 px-2 flex-wrap" data-emp-id="3828">
                        <h6 class="text-info m-b-10 w-100"><i class="fa fa-check-circle" aria-hidden="true"></i> <?= ($overtime->status == 'DECLINED' && $overtime->declined_by_superior == 'YES') ? 'Declined by' : 'Recommending Approval' ?>:</h6>
                        <div class="media-img">
                          <div class="img-circle" style="background-image: url('{{ $supervisor->profile_img }}');"></div>
                        </div>
                        <div class="media-body">
                          <div class="media-heading">
                            <?= (empty($supervisor) ? 'NO SUPERVISOR' : $supervisor->first_name.' '.$supervisor->last_name.(($supervisor->id == Auth::user()->id) ? ' (You)' : '')) ?>
                          </div>
                          <div class="font-13">
                            <a href="mailto::{{ $supervisor->email }}">{{ $supervisor->email }}</a>
                            <br>
                            <?php
                              if($overtime->status == 'DECLINED' && $overtime->declined_by_superior == 'YES') {
                              ?>
                            Declined last <?= prettyDate($overtime->declined_date) ?>
                            <?php
                              } else {
                              ?>
                            <small <?= (empty($overtime->recommend_date) ? '' : ' class="text-success"') ?>><?= (empty($overtime->recommend_date) ? 'Not yet recommended' : 'Recommended last ' .  prettyDate($overtime->recommend_date)) ?></small>
                            <?php
                              }
                              ?>
                          </div>
                        </div>
                      </li>
                      <li class="media col-6 px-2 flex-wrap">
                        <h6 class="text-info m-b-10 w-100"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Completed by:</h6>
                        <div class="media-img">
                          <div class="img-circle" style="background-image: url('{{ $completer->profile_img }}');"></div>
                        </div>
                        <div class="media-body">
                          <div class="media-heading">
                            <?= (empty($completer) ? 'HR DEPARTMENT' : $completer->first_name.' '.$completer->last_name.(($completer->id == Auth::user()->id) ? ' (You)' : '')) ?>
                          </div>
                          <div class="font-13">
                            <a href="mailto::{{ $completer->email }}">{{ $completer->email }}</a>
                            <br>
                            <small <?= (empty($overtime->completed_date) ? '' : ' class="text-success"') ?>><?= (empty($overtime->completed_date) ? 'Not yet approved' : 'Approved last ' .  prettyDate($overtime->completed_date)) ?></small>
                          </div>
                        </div>
                      </li>
                      <li class="media col-6 px-2 flex-wrap">
                        <h6 class="text-info m-b-10 w-100 m-t-20"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved by:</h6>
                        <div class="media-img">
                          <div class="img-circle" style="background-image: url('{{ $manager->profile_img }}');"></div>
                        </div>
                        <div class="media-body">
                          <div class="media-heading">
                            <?= (empty($manager) ? 'HR DEPARTMENT' : $manager->first_name.' '.$manager->last_name.(($manager->id == Auth::user()->id) ? ' (You)' : '')) ?>
                          </div>
                          <div class="font-13">
                            <a href="mailto::{{ $manager->email }}">{{ $manager->email }}</a>
                            <br>
                            <small <?= (empty($overtime->approved_date) ? '' : ' class="text-success"') ?>><?= (empty($overtime->approved_date) ? 'Not yet approved' : 'Approved last ' .  prettyDate($overtime->approved_date)) ?></small>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-timekeeping">
                <div class="row">
                  <div class="col-md-12" style="border-right: 1px solid #eee;">
                    <?php
                      $i = 0;
                      $position = '';
                      $department = '';
                      $profile_img = '';
                      $fullname = '';
                      if($i == 0) {
                        $position = $overtime->position_name;
                        $department = $overtime->team_name;
                        $profile_img = $employee->profile_img;
                        $fullname = $overtime->last_name . ', ' . $overtime->first_name;
                        }

                      $i++;
                      ?>
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Overtime Date</th>
                          <th class="text-center">No. of Hours (Estimated)</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>No. of Hours(Actual)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach($overtime->dates as $key=>$date){
                          ?>
                        <tr>
                          <td><?= date('F d, Y',strtotime($date)) ?></td>
                          <td class="text-center"><?= $overtime->no_of_hours[$key]?><?= ($overtime->no_of_hours[$key] > 1) ? " hrs" : " hr"?></td>
                          <td><?= empty($overtime->time_in[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_in[$key])) ?></td>
                          <td><?= empty($overtime->time_out[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_out[$key])) ?></td>
                          <td><?= numberOfHours($overtime->time_in[$key], $overtime->time_out[$key], false, true) ?></td>
                        </tr>
                        <?php
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4 form-group info">
                    <br>
                    <label>Date filed:</label>
                    <p class="text-display"><?= slashedDate($overtime->created_at) ?></p>
                  </div>
                  <div class="col-md-4 form-group info">
                    <br>
                    <label>Contact Number:</label>
                    <p class="text-display"><?= $overtime->contact_number ?></p>
                  </div>
                  <div class="col-md-4 form-group info">
                    <br>
                    <label>Total No. of Hours:</label>
                    <p class="text-display"><?= array_sum($overtime->no_of_hours) ?></p>
                  </div>
                  <div class="col-md-12 form-group info">
                    <br>
                    <label>Reason:</label>
                    <p class="text-display"><?= htmlentities($overtime->reason) ?></p>
                  </div>
                  <?php
                    if(!empty($overtime->reverted_reason)) {
                    ?>
                  <div class="col-md-12 form-group info">
                    <br>
                    <label>Revert Reason:</label>
                    <p class="text-display"><?= htmlentities($overtime->reverted_reason) ?></p>
                  </div>
                  <?php
                    }
                    ?>
                  <div class="col-md-12 m-t-20">
                    <h6 class="text-info m-b-10 w-100"><i class="fa fa-calendar-o" aria-hidden="true"></i> Timekeeping Log:</h6>
                  </div>
                  <div class="col-md-6 m-t-10">
                    <label for="time-in">Time In <span class="text-danger">*</span></label>
                    <input type="text" name="date[]" class="form-control mdatetime input_none" placeholder="MM/DD/YYYY" autocomplete="off" required />
                  </div>
                  <div class="col-md-6 m-t-10">
                    <label for="time-out">Time Out <span class="text-danger">*</span></label>
                    <input type="text" name="date[]" class="form-control mdatetime input_none" placeholder="MM/DD/YYYY" autocomplete="off" required />
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-log">
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
              </div>
            </div>
        </div>
      </div>
      </form>
      <div class="form-group pull-right d-flex">
        <?php if((Auth::user()->isAdmin() || Auth::user()->id == $overtime->supervisor_id) && empty($overtime->recommend_date) && $overtime->status == 'PENDING') {?>
        <form action="<?= url('overtime/recommend') ?>" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="<?= $overtime->id ?>" />
          <button type="submit" style="margin-right:5px;" class="btn btn-primary btn-rounded">Recommend</button>
        </form>
        <?php }
          if(Auth::user()->isAdmin() || Auth::user()->usertype == 3 || Auth::user()->position_name == "Associate Manager") {
          if($overtime->status == 'VERIFYING' || $overtime->status == 'COMPLETED') {?>
        <button type="submit" style="margin-right:5px;" class="btn btn-success btn-rounded btn-submit">Revert</button>
        <?php } if($overtime->status == 'VERIFYING') {?>
        <button type="submit" style="margin-right:5px;" class="btn btn-success btn-rounded btn-submit">Verified</button>
        <?php } if($overtime->status == 'VERIFIED') {?>
        <button type="submit" style="margin-right:5px;" class="btn btn-success btn-rounded btn-submit">Complete</button>
        <?php } if(($overtime->status == 'PENDING' || $overtime->status == 'DECLINED') && (Auth::user()->isAdmin() || Auth::user()->id == $overtime->manager_id)) {?>
        <form action="<?= url('overtime/approve') ?>" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="notif_id" value="<?= $notif_detail->notif_id ?>" />
          <input type="hidden" name="url" value="<?= $notif_detail->url ?>" />
          <input type="hidden" name="id" value="<?= $overtime->id ?>" />
          <button type="submit" style="margin-right:5px;" class="btn btn-success btn-rounded btn-submit">Approve</button>
        </form>
        <?php } ?>
        <button type="submit" style="margin-right:5px;" class="btn btn-info btn-rounded btn-submit">Update</button>
        <?php } if($overtime->status == 'PENDING' || $overtime->status == 'APPROVED') {?>
        <button type="submit" style="margin-right:5px;" class="btn btn-danger btn-rounded btn-submit">Decline/Cancel</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
@endsection
@section('script')
<script type = "text/javascript">
  function loadEmployee(img, position, department, fullname)
    {
     $('#profile-img').attr('src', img);
     $('#position').text(position);
     $('#department').text(department);
     $('#fullname').text(fullname);
    }
    $(function () {
    $('.mdatetime').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm', time: true, clearButton: true });

     loadEmployee('{{ $profile_img }}', '{{ $position }}', '{{ $department }}', '{{ $fullname }}');

     $('.img-upload').click(function (e) {
       e.preventDefault();
       $('#modal-upload-photo').modal('show');
     });

    });
    $('.select-title').change(function(e) {
        e.preventDefault();

        var value = $(this).val(),
            title = $('input[name="title"]');
            br = $('#br');

        title.addClass('d-none');
        br.addClass('d-none');

        if(value == 'Others') {
            title.val('');
            title.removeClass('d-none');
            br.removeClass('d-none');
        } else {
            title.val(value);
        }
    });

    $('.btn-add').click(function(e) {
          e.preventDefault();

          var obj = $(this),
              parent = obj.closest('.entry-content'),
              entry = parent.find('.row-entry:first'),
              entry_last = parent.find('.row-entry:last');
   // the reason why it find first and last is the clone the first and insertAfter the last entry
          var new_entry = entry.clone().insertAfter(entry_last);
              new_entry.find('.btn-add').html('<span class="fa fa-minus"></span>');
              new_entry.find('.btn-add').removeClass('btn-primary').addClass('btn-danger');
              new_entry.find('.btn-add').removeClass('btn-add').addClass('btn-remove')
              new_entry.find('.mdate2').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm', time: true, clearButton: true });
              new_entry.find('.mdate2').val('');
              new_entry.find('.input_none').keydown(function(e) {
                  e.preventDefault();
                  return false;
              });
              new_entry.find('input[type="number"]').val('1.00');
              new_entry.find('.btn-remove').click(function(e) {
                  e.preventDefault();
                  $(this).closest('.row-entry').remove();
              });
      });

      $('.btn-remove').click(function(e) {
          e.preventDefault();
          $(this).closest('.row-entry').remove();
      });

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
@endsection
