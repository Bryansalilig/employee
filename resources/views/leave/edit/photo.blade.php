<div class="ibox ibox-{{ $item->getStatus('badge') }}">
  <div class="ibox-head">
    <h6 class="ibox-title mb-0">{{ $item->getStatus() }}</h6>
  </div>
  <div class="ibox-body text-center">
    <div class="m-t-20 img-profile">
      <div class="img-circle">
        <img src="{{ $employee->profile_img }}" alt="{{ formatName($employee->fullname2()) }}">
      </div>
    </div>
    <h5 class="font-strong m-b-10 m-t-10">{{ formatName($employee->fullname2()) }}</h5>
    <div class="text-muted">{{ $employee->position_name }}</div>
    <div class="text-muted mb-3">{{ $employee->team_name }}</div>
    <b>Current Credit: {{ $employee->leaveCredit() }}</b>
  </div>
</div>
