<div class="ibox ibox-danger">
  @if(!$status)
  <div class="ibox-head">
    <h6 class="ibox-title mb-0">Ressigned</h6>
  </div>
  @endif
  <div class="ibox-body text-center">
    <div class="m-t-20 img-profile">
      <div class="img-circle {{ ($status) ? '' : 'circle-danger' }}" style="background-image: url('{{ $employee->profile_img }}');"></div>
      <div class="img-upload">
        <img src="{{ URL::to('img/camera-icon.png') }}" alt="Camera Icon">
      </div>
    </div>
    <h5 class="font-strong m-b-10 m-t-10">{{ ucwords(strtolower($employee->fullname2())) }}</h5>
    <div class="text-muted">{{ $employee->position_name }}</div>
    <div class="m-b-20 text-muted">{{ $employee->team_name }}</div>
    <div class="profile-social m-b-20">
      @php
      function getEmail($email) {
        $icon = 'envelope-open';
        $title = 'Outlook';
        if (strpos($email, 'gmail.com') !== false) {
          $icon = 'google';
          $title = 'GMail';
        } elseif (strpos($email, 'yahoo.com') !== false) {
          $icon = 'yahoo';
          $title = 'Yahoo';
        }

        return array('icon'=>$icon, 'title'=>$title);
      }
      @endphp
      <a href="mailto::{{ $employee->email }}" title="Business Email"><i class="fa fa-envelope-open"></i></a>
      @if($employee->email2)
      <a href="mailto::{{ $employee->email2 }}" title="{{ getEmail($employee->email2)['title'] }}"><i class="fa fa-{{ getEmail($employee->email2)['icon'] }}"></i></a>
      @endif
      @if($employee->email3)
      <a href="mailto::{{ $employee->email3 }}" title="{{ getEmail($employee->email3)['title'] }}"><i class="fa fa-{{ getEmail($employee->email3)['icon'] }}"></i></a>
      @endif
    </div>
  </div>
</div>

<div id="modal-upload-photo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('employee.upload') }}" method="post" enctype="multipart/form-data" autocomplete="off">
      {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $employee->id }}">
        <div class="ibox ibox-info mb-0">
          <div class="ibox-head">
            <div class="ibox-title">Upload Image</div>
            <div class="ibox-tools">
              <a data-dismiss="modal"><i class="fa fa-times"></i></a>
            </div>
          </div>
          <div class="ibox-body">
            <div class="row">
              <div class="col-12">
                <label>Upload <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="upload" id="image_url" onchange="delayedDisplayImagePreview()" required>
                <label for="image_url" class="uploader-area text-left mt-1" id="border">
                  <span><i class="fa fa-upload"></i></span> Click here to upload.
                </label>
                <div id="displayImagePreview" class="text-center"></div>
              </div>
            </div>
          </div>
          <div class="ibox-footer pull-right px-4">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="btn-upload" disabled>Upload a Photo</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function delayedDisplayImagePreview() {
  var preview = document.getElementById('displayImagePreview');

  // Add loading state
  preview.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
  preview.style.marginTop = '25px';

  setTimeout(function() {
    displayImagePreview();
  }, 2000);
}

function displayImagePreview() {
  var input = document.getElementById('image_url');
  var preview = document.getElementById('displayImagePreview');
  var button = document.getElementById('btn-upload');

  // Disable the button during the loading state
  button.disabled = true;

  while (preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      preview.innerHTML = '';

      var img = document.createElement('img');
      img.src = e.target.result;
      img.style.marginBottom = '20px';

      var fileDetailsParagraph = document.createElement('p');
      var fileName = input.files[0].name;

      var fileType = fileName.split('.').pop();
      fileDetailsParagraph.textContent = (fileName.length > 15 ? fileName.substring(0, 15) + '...' + fileName.substring(fileName.length - 10): fileName);
      fileDetailsParagraph.style.margin = '0';

      preview.appendChild(img);
      preview.appendChild(fileDetailsParagraph);

      button.disabled = false;
      button.innerHTML = 'Save';
    }

    reader.readAsDataURL(input.files[0]);
  }
}
$(function() {
  $('.img-upload').click(function(e) {
    e.preventDefault();

    $('#modal-upload-photo').modal('show');
  });
});
</script>
