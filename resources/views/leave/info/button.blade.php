<div class="row">
  <div class="col-sm-12 text-right">
  	@if($item->approve_status_id == 0 && (Auth::user()->isAdmin() || $employee->supervisor_id == Auth::user()->id || $employee->manager_id || Auth::user()->id))
    <a href="#" class="btn btn-warning btn-rounded btn-action" data-id="{{ $item->id }}" data-url="{{ route('leave.recommend') }}" data-title="Are you sure you want to recommend this leave request?" data-type="info"><span class="fa fa-thumbs-o-up"></span>&nbsp; Recommend</a>
    @endif

  	@if($item->approve_status_id != 1 && (Auth::user()->isAdmin() || $employee->manager_id == Auth::user()->id || $employee->approver_id || Auth::user()->id))
    <a href="#" class="btn btn-primary btn-rounded btn-action" data-id="{{ $item->id }}" data-url="{{ route('leave.approve') }}" data-title="Are you sure you want to approve this leave request?" data-type="info"><span class="fa fa-check"></span>&nbsp; Approve</a>
    @endif

    @if(Auth::user()->isAdmin())
    <a href="{{ route('leave.edit', ['slug' => $item->slug]) }}" class="btn btn-info btn-rounded"><span class="fa fa-edit"></span>&nbsp; Edit</a>
    @endif

    <a href="#" class="btn btn-danger btn-rounded btn-action" data-id="{{ $item->id }}" data-url="{{ route('event.destroy') }}" data-title="Are you sure you want to cancel this leave request?" data-color="#DD6B55"><span class="fa fa-remove"></span>&nbsp; Cancel</a>
  </div>
</div>
