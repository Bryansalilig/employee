<div class="ibox">
  <div class="ibox-body">
    <ul class="nav nav-tabs tabs-line">
      @php
        $tab = 'overview';
        if(session('employee')) { $tab = 'employee'; }
        if(session('job')) { $tab = 'job'; }
        if(session('movement')) { $tab = 'movement'; }
        if(session('linking')) { $tab = 'linking'; }
      @endphp
      <li class="nav-item">
        <a class="nav-link {{ ($tab == 'overview') ? 'active' : '' }}" href="#tab-overview" data-toggle="tab"><i class="ti-bar-chart"></i> Overview</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($tab == 'employee') ? 'active' : '' }}" href="#tab-employee-info" data-toggle="tab"><i class="ti-id-badge"></i> Employee Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($tab == 'job') ? 'active' : '' }}" href="#tab-job-info" data-toggle="tab"><i class="ti-briefcase"></i> Job Info</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#tab-log" data-toggle="tab"><i class="ti-notepad"></i> Log</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($tab == 'movement') ? 'active' : '' }}" href="#tab-movement" data-toggle="tab"><i class="ti-exchange-vertical"></i> Movement</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($tab == 'linking') ? 'active' : '' }}" href="#tab-linkee" data-toggle="tab"><i class="ti-link"></i> Linkees</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade {{ ($tab == 'overview') ? 'show active' : '' }}" id="tab-overview">
        @include('employee.profile.tab.overview')
      </div>
      <div class="tab-pane fade {{ ($tab == 'employee') ? 'show active' : '' }}" id="tab-employee-info">
        @include('employee.profile.tab.employee')
      </div>
      <div class="tab-pane fade {{ ($tab == 'job') ? 'show active' : '' }}" id="tab-job-info">
        @include('employee.profile.tab.job')
      </div>
      <div class="tab-pane fade" id="tab-log">
        @include('employee.profile.tab.log')
      </div>
      <div class="tab-pane fade {{ ($tab == 'movement') ? 'show active' : '' }}" id="tab-movement">
        @include('employee.profile.tab.movement')
      </div>
      <div class="tab-pane fade {{ ($tab == 'linking') ? 'show active' : '' }}" id="tab-linkee">
        @include('employee.profile.tab.linkee')
      </div>
    </div>
  </div>
</div>
