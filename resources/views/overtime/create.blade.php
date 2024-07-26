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
          <form action="<?= url('overtime/store') ?>" id="" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <ul class="nav nav-tabs tabs-line">
              <li class="nav-item">
                <a class="nav-link active" href="#tab-appraisee" data-toggle="tab"><i class="fa fa-user"></i> Appraisee</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#tab-form" data-toggle="tab"><i class="fa fa-users"></i> Form</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-appraisee">
                <div class="row">
                  <div class="col-md-6" style="border-right: 1px solid #eee;">
                   <label for="appraisess">Appraisee <span class="text-danger">*</span></label>
                    <ul class="list-group list-group-full list-group-divider">
                      <?php if(empty($_GET['record'])){ ?>

                      <select name="employee_id" class="form-control select2" <?= Auth::user()->isAdmin() ? '' : 'disabled' ?> >

                        <?php
                          $i = 0;
                          $position = '';
                          $department = '';
                          $profile_img = '';
                          $fullname = '';
                          $emid = '';
                          foreach($employees as $employee) {
                              ?>
                        <option value="<?= $employee->id ?>" data-position="<?= $employee->position_name ?>" data-department="<?= $employee->team_name ?>" data-photo="<?= $employee->profile_img ?>" data-fullname="<?= $employee->last_name . ', ' . $employee->first_name?>" data-emid="<?= $employee->id?>" <?= Auth::user()->id == $employee->id ? ' selected' : '' ?>><?= strtoupper($employee->first_name . '  ' . $employee->last_name) ?></option>
                        <?php
                          if($i == 0) {
                              $position = $employee->position_name;
                              $department = $employee->team_name;
                              $profile_img = $employee->profile_img;
                              $emid = $employee->id;
                              $fullname = $employee->last_name . ', ' . $employee->first_name;
                          }

                          $i++;
                          }
                          ?>
                      </select>
                      <?php } else {
                        $i = 0;
                        $position = '';
                        $department = '';
                        ?>
                      <input type="hidden" name="employee_id" value="<?= $employee->id ?>" data-position="<?= $employee->position_name ?>" data-department="<?= $employee->team_name ?>" data-photo="<?= $employee->profile_img ?>" data-fullname="<?= $employee->first_name . ' ' . $employee->lastname?>">
                      <input type="text" class="form-control" placeholder="Position" value="<?= $employee->first_name . ' ' . $employee->last_name?>" readonly>
                      <?php
                        if($i == 0) {
                          $position = $employee->position_name;
                          $department = $employee->team_name;
                          $profile_img = $employee->profile_img;
                          $fullname = $employee->fullname;
                        }

                        $i++;
                        } ?>
                    <?php if(!Auth::user()->isAdmin()){?>
                      <input type="hidden" name="employee_id" id="emid">
                    <?php } ?>
                    </ul>
                  </div>
                  <div class="col-md-6">
                  <label for="appraisess">Date Filed <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="<?= date('m/d/Y')?>" readonly>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="tab-form">
                <div class="row">
                  <div class="col-md-12" style="border-right: 1px solid #eee;">
                  <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Overtime Information</h5>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                        <label for="overtime-date">Overtime Date <span class="text-danger">*</span></label>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="appraisess">Estimated No. of Hours <span class="text-danger">*</span></label>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <strong>&nbsp;</strong>
                        </div>
                      </div>
                    </div>
                    <div class="entry-content">
                      <div class="row row-entry">
                        <div class="col-md-4">
                          <div class="form-group" style="margin-top:-10px">
                            <input type="text" name="date[]" class="form-control mdate2 input_none" placeholder="MM/DD/YYYY" autocomplete="off" required />
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group" style="margin-top:-10px">
                            <input type="number" name="no_of_hours[]" class="form-control" value="1.00" min="1" required />
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group" style="margin-top:-10px">
                            <button class="btn btn-primary btn-add" style="width:100%">
                            <span class="fa fa-plus"></span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                      <label for="appraisess">Reason <span class="text-danger">*</span></label>
                      <textarea name="reason" id="" class="form-control" rows="5"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group text-right m-t-20">
                  <button type="submit" class="btn btn-info btn-rounded">Submit</button>
                </div>
                </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type = "text/javascript">
function loadEmployee(img, position, department, fullname, emid)
  {
   $('#profile-img').attr('src', img);
   $('#position').text(position);
   $('#emid').val(emid);
   $('#department').text(department);
   $('#fullname').text(fullname);
  }
  $(function () {
   loadEmployee('{{ $profile_img }}', '{{ $position }}', '{{ $department }}', '{{ $fullname }}', '{{ $emid }}');

   $('.img-upload').click(function (e) {
     e.preventDefault();
     $('#modal-upload-photo').modal('show');
   });

        var obj = $(this);
       var selected = obj.find(':selected');

       var preview = $('#profile-img');
       preview.attr('src', '{{ URL::to("img/loading.gif") }}');


         loadEmployee(selected.data('photo'), selected.data('position'), selected.data('department'), selected.data('fullname'), selected.data('emid'));


   $('.select2').change(function() {
       var obj = $(this);
       var selected = obj.find(':selected');

       var preview = $('#profile-img');
       preview.attr('src', '{{ URL::to("img/loading.gif") }}');

       setTimeout(function() {
         loadEmployee(selected.data('photo'), selected.data('position'), selected.data('department'), selected.data('fullname'), selected.data('emid'));
   }, 2000);
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
            new_entry.find('.mdate2').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD', time: false, clearButton: true });
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
</script>
@endsection
