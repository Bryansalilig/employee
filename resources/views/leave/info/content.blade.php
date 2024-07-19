<div class="ibox">
  <div class="ibox-body">
    <ul class="nav nav-tabs tabs-line nav-fill">
      <li class="nav-item">
        <a class="nav-link active" href="#tab-info" data-toggle="tab"><i class="fa fa-user"></i> Leave Application</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#tab-history" data-toggle="tab"><i class="fa fa-sticky-note-o"></i> Log</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="tab-info">
        @include('leave.info.tab.info')
      </div>
      <div class="tab-pane fade" id="tab-history">
        @include('leave.info.tab.history')
      </div>
    </div>
  </div>
</div>
