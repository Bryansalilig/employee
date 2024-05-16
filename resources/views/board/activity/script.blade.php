<!--
  Activity Module Custom Scripts

  This is used for create and edit page.

  @version 1.0
  @since 2024-03-27

  Changes:
  • 2024-03-27: File creation
  • 2024-04-02:
    - Add function for .img-upload
-->
<script>
function displayImagePreview() {
  var input = document.getElementById('image_url');
  var preview = document.getElementsByClassName('img-upload')[0];
  var errorMessage = document.querySelector('.error-message');

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

          // Append image and file details to the preview div
          preview.appendChild(img);
        }

        // Read file content
        reader.readAsDataURL(input.files[0]);
      }
      errorMessage.val();
    };

    img.src = URL.createObjectURL(input.files[0]);
  } else {
    // Create image element
    var img = document.createElement('img');
    img.src = "{{ URL::to('public/img/icon-image.png') }}";

    // Append image and file details to the preview div
    preview.appendChild(img);
  }
}
$(function() {
  $('.img-upload').click(function(e) {
    e.preventDefault();

    $('#image_url').click();
  });
});
</script>
