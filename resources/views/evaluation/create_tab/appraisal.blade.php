<div class="row">
  <div class="col-md-6" style="border-right: 1px solid #eee;">
    <label for="appraisee">Appraisee <span class="text-danger">*</span></label>
    <ul class="list-group list-group-full list-group-divider">
      <?php if(empty($_GET['record'])){ ?>
      <select name="employee_id" class="form-control select2" <?= Auth::user()->isAdmin() ? '' : 'readonly' ?> >
        <?php
          $i = 0;
          $position = '';
          $department = '';
          $profile_img = '';
          $fullname = '';
          foreach($employees as $employee) {
              ?>
        <option value="<?= $employee->id ?>" data-position="<?= $employee->position_name ?>" data-department="<?= $employee->team_name ?>" data-photo="<?= $employee->profile_img ?>" data-fullname="<?= $employee->last_name . ', ' . $employee->first_name?>" <?= ($i == 0) ? ' selected' : '' ?>><?= strtoupper($employee->last_name . ',  ' . $employee->first_name) ?></option>
        <?php
          if($i == 0) {
              $position = $employee->position_name;
              $department = $employee->team_name;
              $profile_img = $employee->profile_img;
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
    </ul>
  </div>
  <div class="col-md-6">
  <label for="date-filed">Date Filed <span class="text-danger">*</span></label>
    <input type="text" class="form-control" value="<?= date('m/d/Y')?>" readonly>
  </div>
  <div class="col-md-12 m-t-10">
    <label for="evaluation-title">Evaluation Title <span class="text-danger">*</span></label>
    <select class="form-control select-title" name="type">
      <option value="3rd Month Evaluation">3rd Month Evaluation</option>
      <option value="5th Month Evaluation">5th Month Evaluation</option>
      <option value="Others">Others</option>
    </select>
    <br class="d-none" id="br">
    <input type="text" name="title" class="form-control d-none" maxlength="255" placeholder="Title..." value="3rd Month Evaluation" required>
  </div>
</div>
<div class="form-group text-right m-t-20">
  <button class="btn btn-info btn-tab" data-tab="competency">Next</button>
</div>
<script type="text/javascript">
  function loadEmployee(img, position, department, fullname)
  {
   $('#profile-img').attr('src', img);
   $('#position').text(position);
   $('#department').text(department);
   $('#fullname').text(fullname);
  }
  $(function () {
   loadEmployee('{{ $profile_img }}', '{{ $position }}', '{{ $department }}', '{{ $fullname }}');
  
   $('.img-upload').click(function (e) {
     e.preventDefault();
     $('#modal-upload-photo').modal('show');
   });
   $('.select2').change(function() {
       var obj = $(this);
       var selected = obj.find(':selected');
  
       var preview = $('#profile-img');
       preview.attr('src', '{{ URL::to("img/loading.gif") }}');
  
       setTimeout(function() {
         loadEmployee(selected.data('photo'), selected.data('position'), selected.data('department'), selected.data('fullname'));
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
</script>