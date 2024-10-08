@extends('layout.main')
@section('style')
<!-- Include DataTables CSS -->
<link href="<?= asset('vendors/DataTables/datatables.min.css') ?>" rel="stylesheet" />
<!-- Include Mailbox CSS -->
<link href="{{ asset('pages/mailbox.css') }}" rel="stylesheet" />
<script src="https://cdn.lordicon.com/lordicon.js"></script>
@include('notification.overtime_notification.style');
@endsection
@section('content')
<!-- START PAGE CONTENT-->
<div class="page-heading">
  <h1 class="page-title">Mailbox</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="index.html"><i class="la la-home font-20"></i></a>
    </li>
    <li class="breadcrumb-item">Mailbox</li>
  </ol>
</div>
<div class="page-content fade-in-up">
<div class="row">
  <div class="col-lg-3 col-md-4">
    <a class="btn btn-info btn-block" href="mail_compose.html"><i class="fa fa-edit"></i> Compose</a><br>
    <h6 class="m-t-10 m-b-10">FOLDERS</h6>
    <ul class="list-group list-group-divider inbox-list">
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-inbox"></i> Inbox (6)
        <span class="badge badge-warning badge-square pull-right">17</span>
        </a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-envelope-o"></i> Sent</a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-star-o"></i> Important
        <span class="badge badge-success badge-square pull-right">2</span>
        </a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-file-text-o"></i> Drafts</a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-trash-o"></i> Trash</a>
      </li>
    </ul>
    <h6 class="m-t-10 m-b-10">LABELS</h6>
    <ul class="list-group list-group-divider inbox-list">
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-circle-o font-13 text-success"></i> Support</a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-circle-o font-13 text-warning"></i> Business</a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-circle-o font-13 text-info"></i> Work</a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-circle-o font-13 text-danger"></i> System</a>
      </li>
      <li class="list-group-item">
        <a href="javascript:;"><i class="fa fa-circle-o font-13 text-muted"></i> Social</a>
      </li>
    </ul>
  </div>
  <div class="col-lg-9 col-md-8">
    <div class="ibox" id="mailbox-container">
      <div class="mailbox-header">
        <div class="d-flex justify-content-between">
          <h5 class="d-lg-block inbox-title"><i class="fa fa-envelope-o m-r-5"></i> Unread (<?= notificationCount(Auth::user()->id)?>)</h5>
          <div>
            <span class="p-r-10"><img src="<?= URL::to('img/overtime.png') ?>" alt="" class="img-icon"
              srcset=""></span>
          </div>
        </div>
      </div>
      <div class="mailbox clf">
        <table class="table table-hover table-inbox" id="table-inbox">
          <tbody class="rowlinkx" data-link="row">
            @if ($notifications)
            @foreach ($notifications as $notification)
            <tr data-id="1">
              <td class="check-cell rowlink-skip">
                <img src="<?= URL::to('img/admin-avatar.png') ?>" class="img-notif" alt="" srcset="">
              </td>
              <td>
                <form action="<?= url('overtime/updateUnread') ?>" method="post" class="notification-form">
                  {{ csrf_field() }}
                  <input type="hidden" name="notifId" value="{{ $notification->notif_id }}">
                  <input type="hidden" name="Url" value="{{ $notification->url }}">
                <a href="#" class="submit-trigger"><b>{{ $notification->sender }}</b></a>
                @if ($notification->manager_id == Auth::user()->id)
                  @if ($notification->manager_status == 1)
                    <br>
                    <span class="read-sms">
                    <span style="color: rgb(15, 19, 17);">Reason:</span>
                    <span class="submit-trigger" title="{{ htmlentities($notification->reason) }}">
                    {{ stringLimit($notification->reason, 168) }}
                    </span>
                    </span>
                  @else
                    <i class="fa fa-circle" aria-hidden="true"
                    style="font-size:8px;color:red;position:absolute;margin-left:5px;margin-top:4px;">
                    </i>
                    <br>
                    <span class="unread-sms">
                    <span style="color: rgb(15, 19, 17);">Reason:</span>
                    <span class="submit-trigger" title="{{ htmlentities($notification->reason) }}">
                    {{ stringLimit($notification->reason, 168) }}
                    </span>
                    </span>
                  @endif
                  @if ($notification->recommend_date)
                    <br>
                    <span style="font-size: 10px;"><b>(Approval)</b></span>
                  @else
                    <br>
                    <span style="font-size: 10px;"><b>(Recommendation / Approval)</b></span>
                  @endif
                @elseif ($notification->supervisor_id == Auth::user()->id)
                  @if ($notification->supervisor_status == 1)
                    <br>
                    <span class="read-sms">
                    <span style="color: rgb(15, 19, 17);">Reason:</span>
                    <span class="submit-trigger" title="{{ htmlentities($notification->reason) }}">
                    {{ stringLimit($notification->reason, 168) }}
                    </span>
                    </span>
                  @else
                    <i class="fa fa-circle" aria-hidden="true"
                      style="font-size:8px;color:red;position:absolute;margin-left:5px;margin-top:4px;">
                    </i>
                    <br>
                    <span class="unread-sms">
                    <span style="color: rgb(15, 19, 17);">Reason:</span>
                    <span class="submit-trigger" title="{{ htmlentities($notification->reason) }}">
                    {{ stringLimit($notification->reason, 168) }}
                    </span>
                    </span>
                  @endif
                  @if ($notification->recommend_date)
                    <br>
                    <span style="font-size: 10px;"><b>(Approval)</b></span>
                  @else
                    <br>
                    <span style="font-size: 10px;"><b>(Recommendation / Approval)</b></span>
                  @endif
                @elseif ($notification->sender_id == Auth::user()->id)
                  @if ($notification->sender_status == 1)
                    <br>
                    <span class="read-sms">
                    <span style="color: rgb(15, 19, 17);">Reason:</span>
                    <span class="submit-trigger" title="{{ htmlentities($notification->reason) }}">
                    {{ stringLimit($notification->reason, 168) }}
                    </span>
                    </span>
                  @else
                    <i class="fa fa-circle" aria-hidden="true"
                      style="font-size:8px;color:red;position:absolute;margin-left:5px;margin-top:4px;">
                    </i>
                    <br>
                    <span class="unread-sms">
                    <span class="submit-trigger" title="{{ htmlentities($notification->reason) }}">
                    {{ stringLimit($notification->reason, 168) }}
                    </span>
                    </span>
                  @endif
                  <span style="color: rgb(124, 143, 137);" class="createdAt"
                  data-timestamp="{{ date('Y-m-d\TH:i:s\Z', strtotime($notification['created_at'])) }}"></span>
                  @if ($notification->approved_date)
                    <br>
                    <span style="font-size: 10px;"><b>(For Timekeeping)</b></span>
                  @endif
                @endif
                <span style="color: rgb(124, 143, 137);" class="createdAt"
                  data-timestamp="{{ date('Y-m-d\TH:i:s\Z', ($notification->sender_id == Auth::user()->id) ? strtotime($notification['approved_date']) : strtotime($notification['created_at'])) }}"></span>
                <small class="text-muted" style="float: right"></small>
                </form>
              </td>
            </tr>
            @endforeach
            @else
            <tr>
              <td style="text-align: center;">
                <img src="<?= URL::to('img/output-onlinegiftools.gif') ?>" alt="" srcset="">
                <br>
                <h5>No Notifications</h5>
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<!-- Include DataTables JS -->
<script src="<?= asset('vendors/DataTables/datatables.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript"></script>
<script>
  // JavaScript function to handle form submission
  function handleSubmit(event) {
    event.preventDefault(); // Prevent default behavior (e.g., following a link)
    // Find the closest form element and submit it
    const form = event.target.closest('form');
    if (form) {
      form.submit();
    }
  }

  // Attach event listeners to all elements with the class 'submit-trigger'
  document.querySelectorAll('.submit-trigger').forEach(element => {
    element.addEventListener('click', handleSubmit);
  });
</script>
@endsection
