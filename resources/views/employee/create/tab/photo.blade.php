<div class="row">
	<div class="col-12">
    <div class="m-t-20 mb-4 img-profile">
      <div class="img-circle" id="displayImagePreview" style="background-image: url('{{ URL::to('public/img/nobody_m.original.jpg') }}');"></div>
      <div class="img-upload">
        <img src="{{ URL::to('public/img/camera-icon.png') }}" alt="Camera Icon">
      </div>
      <input type="file" name="profile_img" class="d-none" id="image_url" onchange="delayedDisplayImagePreview()" accept="image/*">
    </div>
    <div class="text-dark text-center">Image is not required</div>
    <div class="text-danger text-center">Recommended Dimension: 500 x 500</div>
	</div>
</div>
<div class="form-group mt-3 text-right">
  <button class="btn btn-default btn-tab" data-tab="government">Previous</button>
  <button class="btn btn-info btn-submit" id="btn-submit" type="submit">Add Employee</button>
</div>

<script type="text/javascript">
function delayedDisplayImagePreview() {
  var preview = document.getElementById('displayImagePreview');
  var button = document.getElementById('btn-submit');

  preview.style.backgroundImage = 'url(\'{{ URL::to("img/loading.gif") }}\')';
  button.disabled = true;

  setTimeout(function() {
    displayImagePreview();
  }, 2000);
}

function displayImagePreview() {
  var input = document.getElementById('image_url');
  var preview = document.getElementById('displayImagePreview');
  var button = document.getElementById('btn-submit');

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      var img = document.createElement('img');
      img.src = e.target.result;

      preview.style.backgroundImage = 'url(' + img.src + ')';
      button.disabled = false;
    }

    reader.readAsDataURL(input.files[0]);
  }
}
$(function() {
	$('.img-upload').click(function(e) {
		e.preventDefault();

		$('#image_url').click();
	});
});
</script>