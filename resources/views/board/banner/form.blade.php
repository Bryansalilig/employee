<!--
  Banner Module Form

  This form is used for creating or editing a banner.

  @version 1.0
  @since 2024-04-23

  Changes:
  • 2024-04-23: File creation
-->
<div class="row">
  <!-- Title field -->
  <div class="col-md-8 col-12 form-group">
    <label>Title <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="title" placeholder="Banner Title" value="{{ (!empty($item)) ? $item->title : '' }}" maxlength="255" data-label="Title" required>
  </div>
  <!-- Subtitle field -->
  <div class="col-md-4 col-12 form-group">
    <label>Status <span class="text-danger">*</span></label>
    <select class="form-control select2" name="status" required>
      <option value="1" {{ (!empty($item)) ? (($item->status == 1) ? 'selected' : '') : 'selected' }}>ACTIVE</option>
      <option value="0" {{ (!empty($item)) ? (($item->status == 0) ? 'selected' : '') : '' }}>INACTIVE</option>
    </select>
  </div>
  <!-- Image Attachment field -->
  <div class="col-12 form-group">
    <label>Image Attachment  <span class="text-danger">Recommended (1920 x 1080)</span></label>
    <input type="file" name="image_url" id="image_url" onchange="displayImagePreview()" accept="image/*" data-label="Image" {{ (!empty($item)) ? '' : 'required' }}>
    <label for="image_url" class="uploader-area text-left mt-1" id="border">
      <span><i class="fa fa-upload"></i></span> Click here to upload.
    </label>
    <div id="displayImagePreview" class="mt-3">
    @if (!empty($item))
      <img src="{{ $item->image_url }}" style="max-width: 100%;">
    @endif
    </div>
  </div>
</div>

@section('script')
<script>
function displayImagePreview() {
  var input = document.getElementById('image_url');
  var preview = document.getElementById('displayImagePreview');

  // Clear previous preview
  while (preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  if (input.files && input.files[0]) {
    var img = new Image();

    img.onload = function() {
      // Image dimensions are correct
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          // Create image element
          var img = document.createElement('img');
          img.src = e.target.result;
          img.style.maxWidth = '100%';

          preview.appendChild(img);
        }

        // Read file content
        reader.readAsDataURL(input.files[0]);
      }
    };

    img.src = URL.createObjectURL(input.files[0]);
  }
}
</script>
@endsection

