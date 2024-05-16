<div class="row">
  <div class="col-md-6" style="border-right: 1px solid #eee;">
    <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-bar-chart"></i> Statistics</h5>
    <ul class="list-group list-group-full list-group-divider">
      <li class="list-group-item">Getting To Know You
        <span class="pull-right color-orange">{{ $session_gtky }}</span>
      </li>
      <li class="list-group-item">Goal Settings
        <span class="pull-right color-orange">{{ $session_gs }}</span>
      </li>
      <li class="list-group-item">Skill Building
        <span class="pull-right color-orange">{{ $session_sb }}</span>
      </li>
      <li class="list-group-item">Skill Development Activities
        <span class="pull-right color-orange">{{ $session_sda }}</span>
      </li>
      <li class="list-group-item">Quick Link
        <span class="pull-right color-orange">{{ $session_ql }}</span>
      </li>
      <li class="list-group-item">Cementing Expectation
        <span class="pull-right color-orange">{{ $session_ce }}</span>
      </li>
      <li class="list-group-item">Accountability Settings
        <span class="pull-right color-orange">{{ $session_as }}</span>
      </li>
    </ul>
  </div>
  <div class="col-md-6">
  @if(count($employees) > 0)
    <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-user-plus"></i> Recent Addition</h5>
    <ul class="media-list media-list-divider m-0">
      @foreach($employees as $emp)
      <li class="media">
        <a class="media-img" href="javascript:;">
          <div class="img-circle" style="background-image: url('{{ $emp->profile_img }}');"></div>
        </a>
        <div class="media-body">
          <div class="media-heading">{{ formatName($emp->fullname2()) }} <small class="float-right text-muted">{{ date('Y-m-d', strtotime($emp->hired_date)) }}</small></div>
          <div class="font-13">
            {{ $emp->position_name }}<br>
            <a href="mailto:{{ $emp->email }}">{{ $emp->email }}</a>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
  @else
    @if($manager)
    <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-file"></i> Reports To</h5>
    <ul class="media-list media-list-divider m-0">
      @if($reports_to)
      <li class="media">
        <a class="media-img" href="javascript:;">
          <div class="img-circle" style="background-image: url('{{ $manager->profile_img }}');"></div>
        </a>
        <div class="media-body">
          <div class="media-heading">{{ formatName($manager->fullname2()) }}</div>
          <div class="font-13">
            {{ $manager->position_name }}<br>
            <a href="mailto:{{ $manager->email }}">{{ $manager->email }}</a>
          </div>
        </div>
      </li>
      @else
        @if($manager)
        <li class="media">
          <a class="media-img" href="javascript:;">
            <div class="img-circle" style="background-image: url('{{ $manager->profile_img }}');"></div>
          </a>
          <div class="media-body">
            <div class="media-heading">{{ formatName($manager->fullname2()) }}</div>
            <div class="font-13">
              {{ $manager->position_name }}<br>
              <a href="mailto:{{ $manager->email }}">{{ $manager->email }}</a>
            </div>
          </div>
        </li>
        @endif
        @if($supervisor)
        <li class="media">
          <a class="media-img" href="javascript:;">
            <div class="img-circle" style="background-image: url('{{ $supervisor->profile_img }}');"></div>
          </a>
          <div class="media-body">
            <div class="media-heading">{{ formatName($supervisor->fullname2()) }}</div>
            <div class="font-13">
              {{ $supervisor->position_name }}<br>
              <a href="mailto:{{ $supervisor->email }}">{{ $supervisor->email }}</a>
            </div>
          </div>
        </li>
        @endif
      @endif
    </ul>
    @endif
  @endif
  </div>
</div>
<h4 class="text-info m-b-20 m-t-20"><i class="fa fa-calendar"></i> Latest Leave Request</h4>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th width="200px">Reason</th>
      <th>Type</th>
      <th>Dates</th>
      <th>No. of Days</th>
      <th>Status</th>
      <th>Date Filed</th>
    </tr>
  </thead>
  <tbody>
    @if(count($leave_requests) == 0)
    <tr>
      <td colspan="7" class="text-center">No Results Found</td>
    </tr>
    @endif
    @foreach($leave_requests as $no=>$leave)
      @php
        $days = 0;
        $dates = [];
        foreach($leave->leave_details as $detail) {
          if($detail->status == 3) { continue; }
          array_push($dates, date('m/d/Y', strtotime($detail->date)));
          $days += $detail->length;
        }

        $leave_status = "Pending";
        $badge = "primary";
        switch($leave->approve_status_id) {
          case 1:
            $leave_status = 'Approved';
            $badge = 'success';
          break;
          case 2:
            $leave_status = 'Not Approved';
            $badge = 'danger';
          break;
          case 3:
            $leave_status = "Recommended";
            $badge = "warning";
          break;
        }

        $leave_type = "<span class='badge bg-purple'>Unplanned</span>";
        if($leave->pay_type_id == 1) { $leave_type = "<span class='badge badge-info'>Planned</span>"; }
      @endphp
    <tr>
      <td>{{ ++$no }}</td>
      <td><a href="{{ url("leave/{$leave->slug}") }}" title="{!! $leave->reason !!}">{!! stringLimit($leave->reason, 50) !!}</a></td>
      <td>{!! $leave_type !!}</td>
      <td>{!! implode("<br>", $dates) !!}</td>
      <td>{{ $days }}</td>
      <td>
        <span class="badge badge-{{ $badge }}">{{ $leave_status }}</span>
      </td>
      <td>{{ date('m/d/Y', strtotime($leave->date_filed)) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
