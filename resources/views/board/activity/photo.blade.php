<!--
  Activity Module Image Upload

  This handles the image uploading.

  @version 1.0
  @since 2024-04-02

  Changes:
  • 2024-04-02: File creation
-->
<div class="ibox ibox-info">
  <div class="ibox-head">
    <h6 class="ibox-title mb-0">Image</h6>
  </div>
  <div class="ibox-body text-center">
    <div class="m-t-20 img-profile">
      <div class="img-circle img-upload">
        <img src="{{ (!empty($item)) ? $item->image_url : URL::to('public/img/icon-image.png') }}" alt="{{ (!empty($item)) ? $item->title : 'Default Image' }}">
      </div>
    </div>
  </div>
</div>
