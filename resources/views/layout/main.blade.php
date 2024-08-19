<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Human Resources</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="<?= URL::to('img/logo.png') ?>">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?= URL::to('vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('vendors/themify-icons/css/themify-icons.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('vendors/select2/dist/css/select2.min.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('vendors/datetimepicker/datetimepicker.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('css/sweetalert.min.css') ?>" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?= URL::to('css/main.css') ?>" rel="stylesheet" />
    <!-- CORE PLUGINS-->
    <script src="<?= URL::to('vendors/jquery/dist/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/popper.js/dist/umd/popper.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/bootstrap/dist/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/metisMenu/dist/metisMenu.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/jquery-slimscroll/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/select2/dist/js/select2.full.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/datetimepicker/moment.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/datetimepicker/datetimepicker.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('js/sweetalert.min.js') ?>" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?= URL::to('js/app.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('js/main.js') ?>"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <?php if (Auth::check()) { ?>
      <script>
        // Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
var pusher = new Pusher(
  '4b3d19212d902a3e44e3',
  {
    cluster: 'ap1'
  });
var channel = pusher.subscribe(
  'overtime-channel');
channel.bind('overtime-event', function(
  data)
{
  var notifId = data.notif_Id;
  var result = data.employee;
  var message = data.message;
  var reason = data.reason;
  var url = data.url;
  var id = $('#user-id').attr(
    'data-id');
  var condition = '';
  var notif_mess = '';
  // Split first name by spaces
  var firstNameParts = result
    .first_name.split(' ');
  // Split last name by spaces
  var lastNameParts = result
    .last_name.split(' ');
  // Capitalize the first letter of each word in first name
  var capitalizedFirstName =
    firstNameParts.map(function(
      word)
    {
      return word.charAt(0)
        .toUpperCase() + word
        .slice(1).toLowerCase();
    }).join(' ');
  // Capitalize the first letter of each word in last name
  var capitalizedLastName =
    lastNameParts.map(function(
      word)
    {
      return word.charAt(0)
        .toUpperCase() + word
        .slice(1).toLowerCase();
    }).join(' ');
  if (message == "Approved")
  {
    condition = result.id == id;
    notif_mess =
      "Your Overtime has been Approved.";
  }
  else
  {
    condition = result
      .supervisor_id == id || result
      .manager_id == id;
    notif_mess = message + ' : ' +
      capitalizedFirstName +
      capitalizedLastName;
  }
  if (condition)
  {
    // Show Toastify notification
    Toastify(
    {
      text: "New message arrived ",
      duration: 5000, // Duration in milliseconds
      gravity: "top", // Position of the notification: 'top', 'bottom', 'left', 'right'
      close: true // Whether to enable the close button
    }).showToast();
    // Add the 'notify-signal' class to the <span> tag inside the bell icon
    $('.fa.fa-bell-o.rel > span')
      .addClass('notify-signal');
    // Get the current time
    var currentTime = new Date();
    $('.no_notif').addClass(
      'd-none');
    // Append new result to list
    var listItem = $(`
<a class="list-group-item">
  <div class="media">
    <i class="fa fa-circle" aria-hidden="true" style="font-size:8px;color:red;position:absolute;margin-left:27px;margin-top:-4px"></i>
    <div class="media-img">
      <span class="badge badge-warning badge-big"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
    </div>
    <div class="media-body">
      <div class="font-13" style="color:black">
        <form action="<?= url('overtime/updateUnread') ?>" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="Id" value="${notifId}">
          <input type="hidden" name="Url" value="${url}">
          <button type="submit" style="background-color:transparent;border:none;text-align:left;cursor: pointer;"><b>${notif_mess}</b><small class="text-muted" style="margin-left:5px"></small></button>
        </form>
      </div>
      <!-- Display time ago -->
    </div>
  </div>
</a>
`);
    // Calculate the time difference for this item
    var dataTime = new Date();
    var timeDifference = Math.floor(
      (currentTime.getTime() -
        dataTime
        .getTime()) / (1000 * 60));
    var timeAgo = (
        timeDifference === 0 ||
        timeDifference === -1) ?
      'just now' : timeDifference +
      ' mins ago';
    listItem.find('.text-muted')
      .text(timeAgo);
    // Append the item to the list if total results are less than 5
    var tres = $(
      '.list-group-item-dy').find(
      'a.list-group-item').length;
    if (tres < 5)
    {
      $('.list-group-item-dy')
        .prepend(listItem);
    }
    var totalResults = $(
        '.list-group-item-dy').find(
        'a.list-group-item')
      .length;
    var count = parseInt($('.count')
      .text()
    ); // Parse the text content to an integer
    var totalCount = totalResults +
      count;
    // Count total results and update the .total element
    $('.total').text(totalCount);
    $('.envelope-badge').text(
      totalCount);
    // Update time every minute
    setInterval(function()
      {
        currentTime = new Date();
        timeDifference = Math
          .floor((currentTime
            .getTime() -
            dataTime
            .getTime()) / (
            1000 * 60));
        timeAgo = (timeDifference === 0 || timeDifference === -1) ? 'just now' : timeDifference + ' mins ago';
        listItem.find(
          '.text-muted').text(
          timeAgo);
      },
      60000); // Update every minute (60 seconds)
  }
});
// Define the updateTime() function, which updates the displayed time
function updateTime()
{
  // Select all elements with the class "createdAt"
  const timestamps = document
    .querySelectorAll(".createdAt");
  // Iterate over each element with the class "createdAt"
  timestamps.forEach(
    timestampElement =>
    {
      // Get the timestamp from the "data-timestamp" attribute
      const timestamp =
        timestampElement.dataset
        .timestamp;
      // Parse the timestamp string into a Date object
      const createdAt = new Date(
        timestamp);
      // Get the current time
      const current_time = new Date();
      // Calculate the time difference between the current time and the timestamp
      const time_diff = current_time -
        createdAt;
      // Calculate the time difference in minutes, hours, days, months, and years
      const minutes = Math.floor(
        time_diff / (1000 * 60));
      const hours = Math.floor(minutes / 60);
      const days = Math.floor(hours / 24);
      const months = Math.floor(days / 30);
      const years = Math.floor(days / 365);
      // Update the text content of the next sibling element with the calculated time
      if (minutes < 60)
      {
        // Display "X minutes ago" if less than an hour
        if (minutes === 0)
        {
          timestampElement
            .nextElementSibling
            .innerText = "Just now";
        }
        else if (minutes === 1)
        {
          timestampElement
            .nextElementSibling
            .innerText =
            "1 minute ago";
        }
        else
        {
          timestampElement
            .nextElementSibling
            .innerText = minutes +
            " minutes ago";
        }
      }
      else if (hours < 24)
      {
        // Display "X hours ago" if less than a day
        if (hours === 1)
        {
          timestampElement
            .nextElementSibling
            .innerText = "1 hour ago";
        }
        else
        {
          timestampElement
            .nextElementSibling
            .innerText = hours +
            " hours ago";
        }
      }
      else if (days < 30)
      {
        // Display "X days ago" if less than a month
        if (days === 1)
        {
          timestampElement
            .nextElementSibling
            .innerText = "1 day ago";
        }
        else
        {
          timestampElement
            .nextElementSibling
            .innerText = days +
            " days ago";
        }
      }
      else if (months < 12)
      {
        // Display "X months ago" if less than a year
        if (months === 1)
        {
          timestampElement
            .nextElementSibling
            .innerText =
            "1 month ago";
        }
        else
        {
          timestampElement
            .nextElementSibling
            .innerText = months +
            " months ago";
        }
      }
      else
      {
        // Display "X years ago" for longer durations
        if (years === 1)
        {
          timestampElement
            .nextElementSibling
            .innerText = "1 year ago";
        }
        else
        {
          timestampElement
            .nextElementSibling
            .innerText = years +
            " years ago";
        }
      }
      // Store the calculated "X minutes ago" or "X hours ago" value in local storage
      localStorage.setItem(timestamp,
        timestampElement
        .nextElementSibling
        .innerText);
    });
}
// Call updateTime() when the page loads
window.addEventListener('load',
  updateTime);
// Update time every minute using setInterval
setInterval(updateTime,
  60000); // 60000 milliseconds = 1 minute

      </script>
    <?php } ?>
    <!-- PAGE LEVEL STYLES-->
    @yield('style')
    <style>
      @font-face {
      font-family: "Cervo";
      font-weight: normal;
      src: url('<?= URL::to(' fonts/Cervo-Regular.otf') ?>') format("opentype");
      }
      @font-face {
      font-family: "Seconda Round";
      font-weight: 900;
      src: url('<?= URL::to(' fonts/SecondaRound-Black.ttf') ?>') format("truetype");
      }
      .dtp-btn-cancel {
      display: none !important;
      }
      .dtp-btn-clear {
      margin-right: 10px !important;
      }
      .btn {
      cursor: pointer;
      }
      select,
      .select2 {
      height: auto !important;
      cursor: pointer;
      }
      .select2 {
      width: 100% !important;
      }
    </style>
  </head>
  <body class="fixed-layout">
    <div class="page-wrapper">
      <!-- START HEADER-->
      <header class="header">
        <div class="page-brand">
          <a class="link" href="index.html">
          <span style="font-family:'Cervo';font-weight:normal;color:#3abae5;">
          <img src="<?= URL::to('img/logo.png') ?>" style="width: 40px; margin-top: -10px"> HR
          </span>
          <span style="font-family:'Seconda Round';color:#fff;font-size:18px;">GATEWAY</span>
          </a>
        </div>
        <div class="flexbox flex-1">
          <!-- START TOP-LEFT TOOLBAR-->
          <ul class="nav navbar-toolbar">
            <li>
              <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
            </li>
          </ul>
          <!-- END TOP-LEFT TOOLBAR-->
          <!-- START TOP-RIGHT TOOLBAR-->
          <ul class="nav navbar-toolbar">
            <li class="dropdown dropdown-notification">
              <!-- <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o rel"><span class=""></span></i></a> -->
              <?php $userId = Auth::check() ? Auth::user()->id : 0; ?>
              <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o" style="font-size:20px;"></i>
              <span class="badge badge-primary envelope-badge" style="background-color: red">{{ Auth::check() ? notificationCount(Auth::user()->id) : 0 }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                <li class="dropdown-menu-header">
                  <div>
                    <span class="count" style="display:none">{{ notificationCount($userId) }}</span>
                    <span><strong><span
                      class="total">{{ Auth::check() ? notificationCount(Auth::user()->id) : 0 }}</span>
                    Unread</strong> Notifications</span>
                    <a class="pull-right" href="{{ route('overtime_notification')}}">view all</a>
                  </div>
                </li>
                <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                  <div>
                    <a class="list-group-item-dy">
                    </a>
                    @php
                    if (Auth::check()) {
                    $notificationsData = getNotifications(Auth::user()->id);
                    } else {
                    $notificationsData = null;
                    }
                    @endphp
                    @if ($notificationsData)
                    @foreach ($notificationsData['notifications'] as $index => $notification)
                    <?php $recommend_data = $notificationsData['recommend_data'][$index] ?? 0?>
                    <a class="list-group-item">
                      <div class="media">
                        <i class="fa fa-circle" aria-hidden="true"
                          style="font-size:8px;color:red;position:absolute;margin-left:27px;margin-top:-4px"></i>
                        <div class="media-img">
                          <span class="badge badge-warning badge-big">
                          <i class="fa fa-clock-o" aria-hidden="true"></i></span>
                        </div>
                        <div class="media-body">
                          <div class="font-13">
                            <span class="noti">
                              <form action="<?= url('overtime/updateUnread') ?>" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="notifId"
                                  value="{{ $notificationsData['notifId'][$index] }}">
                                <input type="hidden" name="Url"
                                  value="{{ $notificationsData['url'][$index] }}">
                                <button type="submit"
                                  style="background-color:transparent;border:none;text-align:left;cursor: pointer;"><b>{{ $notification }}</b>
                                <span class="createdAt" style="margin-left:5px"
                                  data-timestamp="{{ $notificationsData['createdAt'][$index] }}"></span>
                                {{-- @if ($recommend_data)
                                <small class="text-muted" style=""></small>
                                <span style="font-size: 10px;">(Approval)</span>
                                @else
                                <small class="text-muted" style=""></small>
                                <span style="font-size: 10px;">(Recommendation / Approval)</span>
                                @endif --}}
                                <small class="text-muted" style=""></small>
                                </button>
                              </form>
                            </span>
                          </div>
                        </div>
                      </div>
                    </a>
                    @endforeach
                    @else
                    <div>
                      <p style="text-align:center;margin-top:100px" class="no_notif">No notification</p>
                    </div>
                    @endif
                  </div>
                </li>
              </ul>
            </li>
            <li class="dropdown dropdown-user">
              @auth
              <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
              <img src="{{ Auth::user()->profile_img }}" />
              <span id="user-id"
                data-id="{{ Auth::user()->id }}"></span>{{ ucfirst(strtolower(Auth::user()->first_name)) }}
              <i class="fa fa-angle-down m-l-5"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile.html"><i class="fa fa-user"></i>Profile</a>
                <a class="dropdown-item" href="profile.html"><i class="fa fa-cog"></i>Settings</a>
                <a class="dropdown-item" href="javascript:;"><i class="fa fa-support"></i>Support</a>
                <li class="dropdown-divider"></li>
                <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-power-off"></i>Logout</a>
              </ul>
              @endauth
              @guest
              <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
              <img src="<?= URL::to('img/nobody_m.original.jpg') ?>" />
              <span></span>Guest
              <i class="fa fa-angle-down m-l-5"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('login') }}"><i class="fa fa-sign-in"></i>Login</a>
              </ul>
              @endguest
            </li>
          </ul>
          <!-- END TOP-RIGHT TOOLBAR-->
        </div>
      </header>
      <!-- END HEADER-->
      <!-- START SIDEBAR-->
      <nav class="page-sidebar" id="sidebar">
        <div id="sidebar-collapse">
          @auth
          <div class="admin-block d-flex">
            <div class="bg-white rounded-circle" style="overflow: hidden;">
              <img src="{{ Auth::user()->profile_img }}" style="width:45px; height:45px;" />
            </div>
            <div class="admin-info">
              <div class="font-strong">{{ ucfirst(strtolower(Auth::user()->fullname2())) }}</div>
              <small>{{ Auth::user()->position_name }}</small>
            </div>
          </div>
          @endauth
          @guest
          <div class="admin-block d-flex">
            <div class="bg-white rounded-circle" style="overflow: hidden;">
              <img src="img/nobody_m.original.jpg" style="width:45px; height: 45px;" />
            </div>
            <div class="admin-info">
              <div class="font-strong">Guest</div>
              <small>Guest</small>
            </div>
          </div>
          @endguest
          @include('layout.menu')
        </div>
      </nav>
      <!-- END SIDEBAR-->
      <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        @yield('content')
        <!-- END PAGE CONTENT-->
        <footer class="page-footer text-center">
          <div class="col-md-12">© Copyright {{ date('Y') }} © <b>eLink Systems & Concepts Corpss</b></div>
          <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
        </footer>
      </div>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
      <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE SCRIPTS-->
    <script type="text/javascript">
      $(function() {
        if ($('#_fixedlayout').is(':checked')) {
          $('body').addClass('fixed-layout');
          $('#sidebar-collapse').slimScroll({
            height: '100%',
            railOpacity: '0.9',
          });
        }
      });
    </script>
    <!-- Modal Success -->
    <div id="messageModal" class="modal fade" role="dialog">
      <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-content">
          <div class="ibox ibox-info">
            <div class="ibox-head">
              <div class="ibox-title">Delete Post</div>
              <div class="ibox-tools">
                <a data-dismiss="modal"><i class="fa fa-times"></i></a>
              </div>
            </div>
            <div class="ibox-body">Are you sure you want to delete the post ?
            </div>
          </div>
          <div style="text-align: right;padding-right:15px">
            <form action="{{ url('employee_info/') }}" method="POST" class="delete_form">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Yes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    @yield('script')
    @if (session('success'))
    <script type="text/javascript">
      $(function() {
        $.messageHandler.customMessage('success', "{{ session('success') }}");
      });
    </script>
    @endif
    @if (session('error'))
    <script type="text/javascript">
      $(function() {
        $.messageHandler.customMessage('warning', "{{ session('error') }}");
      });
    </script>
    @endif
  </body>
</html>
