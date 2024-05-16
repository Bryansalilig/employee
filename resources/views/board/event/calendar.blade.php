<!--
  Calendar Page for Board > Event Module

  Handles the Calendar of Events.

  @version 1.0
  @since 2024-04-04

  Changes:
  • 2024-04-04: File creation
-->
@extends('layout.main')

@section('style')
<link href="<?= URL::to('vendors/fullcalendar/dist/fullcalendar.min.css')?>" rel="stylesheet" />
<link href="<?= URL::to('vendors/fullcalendar/dist/fullcalendar.print.min.css')?>" rel="stylesheet" media="print" />
<!-- Include custom style for this view -->
<style>
  #myModal {
    margin-top:200px;
  }
  #eventTitle {
    text-transform: uppercase;
  }
  #eventDate {
    color: white;
  }
  #eventColor {
    display: inline-block;
    vertical-align: middle;
    width: 15px;
    height: 15px;
    border-radius: 3px;
  }
  #eventImage {
    max-height: 300px;
    display: block;
    margin: 0 auto;
  }
</style>
@endsection

@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Board</li>
    <li class="breadcrumb-item"><a href="{{ route('events') }}">Events</a></li>
    <li class="breadcrumb-item">Calendar</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Return button -->
    <a href="{{ route('events') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="ibox ibox-info">
    <div class="ibox-head">
      <div class="ibox-title">Calendar of Events</div>
    </div>
    <div class="ibox-body p-3">
      <div class="row">
        <div class="col-md-12">
          <div class="ibox">
            <div class="ibox-body">
              <!-- Calendar Data -->
              <div id="eventCalendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal History -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h6 class="modal-title" id="eventDate"></h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="mb-3"><span id="eventColor"></span> <span id="eventTitle"></span></h4>
        <p class="mb-0" id="eventDescription"></p>
        <img src="" id="eventImage" alt="" class="mt-3 d-none">
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="<?= URL::to('vendors/fullcalendar/dist/fullcalendar.min.js')?>" type="text/javascript"></script>
<script src="<?= URL::to('vendors/jquery-ui/jquery-ui.min.js')?>" type="text/javascript"></script>
<script>
$(function() {
  // Get the current date
  var currentDate = new Date();
  var events = <?= json_encode($events); ?>;

  // Calculate the current week number
  var currentWeekNumber = moment(currentDate).isoWeek();

  // Initialize FullCalendar with the events
  $('#eventCalendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,basicWeek,basicDay'
    },
    defaultView: 'month', // Set the default view to week
    defaultDate: currentDate, // Set the default date to the present date
    navLinks: true,
    events: events,
    eventRender: function(event, element) {
      // Set the background color of each event based on its properties
      element.css('background-color', event.event_color);
    },
    eventClick: function (event) {
      // Assuming you have a modal with the id "myModal"
      $('#myModal').modal('show');

      // Populate modal content based on the clicked event
      $('#eventTitle').text(event.title);
      $('#eventDescription').text(event.event_description);

      if (event.image_url != 'none') {
        $('#eventImage').attr('src', event.image_url).attr('title', event.title).removeClass('d-none');
        $('#myModal').css('margin-top', '100px');
      } else {
        $('#eventImage').attr('title', event.title).addClass('d-none');
      }

      if (event.event_color) {
        $('#eventColor').css('background-color', event.event_color);
      }

      // Get the date from the clicked event
      var eventDate = moment(event.start).format('dddd, MMMM D YYYY'); // Using moment.js for date formatting
      $('#eventDate').text(eventDate);
    }
  });
});
</script>
@endsection
