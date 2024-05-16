<!--
  Event Module Form

  This form is used for creating or editing events.

  @version 1.0
  @since 2024-04-03

  Changes:
  • 2024-04-03: File creation
-->
<div class="row">
  <!-- Title field -->
  <div class="col-md-4 col-sm-6 col-12 form-group">
    <label>Event Name <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="event_name" placeholder="Event Name" value="{{ (!empty($item)) ? $item->event_name : '' }}" maxlength="255" data-label="Event Name" required>
  </div>
  <!-- Start Date field -->
  <div class="col-md-3 col-sm-6 col-12 form-group">
    <label>Start Date <span class="text-danger">*</span></label>
    <input class="form-control mdatetime" type="text" name="start_date" placeholder="YYYY-MM-DD HH:MM" value="{{ (!empty($item)) ? date('Y-m-d H:i', strtotime($item->start_date)) : '' }}" data-label="Start Date" required>
  </div>
  <!-- End Date field -->
  <div class="col-md-3 col-sm-6 col-12 form-group">
    <label>End Date <span class="text-danger">*</span></label>
    <input class="form-control mdatetime" type="text" name="end_date" placeholder="YYYY-MM-DD HH:MM" value="{{ (!empty($item)) ? date('Y-m-d H:i', strtotime($item->end_date)) : '' }}" data-label="End Date" required>
  </div>
  <!-- Event Color field -->
  <div class="col-md-2 col-sm-6 col-12 form-group">
    <div class="minicolors-theme-bootstrap minicolors-position-bottom minicolors-position-left">
      <label>Event Color</label><br>
      <input class="minicolors w-100" name="event_color" type="text" style="height:31px;" value="{{ (!empty($item)) ? $item->event_color : '' }}">
    </div>
  </div>
  <!-- Event Description field -->
  <div class="col-12 form-group">
    <label>Description</label>
    <textarea class="form-control" name="event_description" rows="5" placeholder="Description...">{{ (!empty($item)) ? $item->event_description : '' }}</textarea>
  </div>
</div>
