<!--
  Activity Module Form

  This form is used for creating or editing activities.

  @version 1.0
  @since 2024-03-27

  Changes:
  • 2024-03-27: File creation
  • 2024-04-02:
    - Update Form Image
    - Add data-label on each required fields
    - Add Maxlength
-->
<div class="row">
  <!-- Title field -->
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Title <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="title" placeholder="Activity Title" value="{{ (!empty($item)) ? $item->title : '' }}" maxlength="255" data-label="Title" required>
  </div>
  <!-- Subtitle field -->
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Subtitle <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="subtitle" placeholder="Activity Subtitle" value="{{ (!empty($item)) ? $item->subtitle : '' }}" maxlength="100" data-label="Subtitle" required>
  </div>
  <!-- Date field -->
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Date <span class="text-danger">*</span></label>
    <input class="form-control mdate2" type="text" name="activity_date" placeholder="YYYY-MM-DD" value="{{ (!empty($item)) ? date('Y-m-d', strtotime($item->activity_date)) : '' }}" data-label="Date" required>
  </div>
  <!-- Message field -->
  <div class="col-12 form-group">
    <label>Message</label>
    <textarea class="form-control" name="message" rows="5" placeholder="Activity Message...">{{ (!empty($item)) ? $item->message : '' }}</textarea>
  </div>
  <!-- Image Attachment field -->
  <input type="file" class="form-control" name="image_url" id="image_url" accept="image/*" onchange="displayImagePreview()" data-label="Image" {{ (!empty($item)) ? '' : 'required' }}>
</div>
