@extends('layout.main')
@include('employee.list.style')
@section('content')
<div class="row">
  <div class="col-md-8">
    @include('employee.list.filter')
  </div>
  <div class="col-md-4">
    @include('employee.list.action')
  </div>
</div>
<div class="page-content fade-in-up">
  @if(count($employees) == 0)
    @include('employee.list.no-result')
  @else
    @include('employee.list.result')
  @endif
</div>
@if($employees->appends(request()->except('page'))->hasPages())
<div class="row">
  <div class="col-md-12">
    <div class="pagination-data">
      {!! $employees->appends(request()->except('page'))->links() !!}
    </div>
  </div>
</div>
@endif
@endsection
