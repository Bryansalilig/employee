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
  <div class="col-md-6 col-12 form-group">
    <label>Title <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="title" placeholder="Company Policy Title" value="{{ (!empty($item)) ? $item->title : '' }}" maxlength="128" data-label="Title" required>
  </div>
  <!-- Subtitle field -->
  <div class="col-md-6 col-12 form-group">
    <label>Filename <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="subtitle" placeholder="Company Policy Filename" value="{{ (!empty($item)) ? $item->subtitle : '' }}" maxlength="32" data-label="Filename" required>
  </div>
  <!-- Status field -->
  <div class="col-md-6 col-12 form-group">
    <label>Status <span class="text-danger">*</span></label>
    <select class="form-control select2" name="status" required>
      <option value="ACTIVE" {{ (!empty($item)) ? (($item->status == 'ACTIVE') ? 'selected' : '') : 'selected' }}>ACTIVE</option>
      <option value="INACTIVE" {{ (!empty($item)) ? (($item->status == 'INACTIVE') ? 'selected' : '') : '' }}>INACTIVE</option>
    </select>
  </div>
  <!-- File field -->
  <div class="col-md-6 col-12 form-group">
    <label>File {!! (empty($item)) ? '<span class="text-danger">*</span>' : '' !!}</label>
    <input class="form-control" type="file" name="file_url" accept="application/pdf" {{ (empty($item)) ? 'data-label="File" required' : '' }}>
  </div>
</div>
