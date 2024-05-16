<!--
  Edit Page for Board > Activity Module

  Handles the Update Form of Activity.

  @version 1.0
  @since 2024-03-27

  Changes:
  • 2024-03-27: File creation
-->
@extends('layout.main')

@section('style')
<!-- Include custom style for this view -->
@include($view.'.style')
@endsection

@section('content')
<!-- Page Heading -->
<div class="page-heading my-2">
  <!-- Breadcrumb navigation -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item">Board</li>
    <li class="breadcrumb-item"><a href="{{ route('activities') }}">Activities</a></li>
    <li class="breadcrumb-item">Edit</li>
  </ol>
</div>

<!-- Action buttons -->
<div class="row">
  <div class="col-12 text-right">
    <!-- Show history button if there are logs -->
    @if(!empty($logs))
    <a href="#" id="btn-history" class="btn btn-warning btn-rounded" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i>&nbsp;&nbsp;History</a>
    @endif
    <!-- Return button -->
    <a href="{{ route('activities') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <!-- Include form -->
      @include($view.'.photo')
    </div>
    <div class="col-lg-9 col-md-8">
      <!-- Updating Form -->
      <form method="POST" action="{{ route('activity.update', ['id' => $item->id]) }}" enctype="multipart/form-data" autocomplete="off">
      @csrf
      @method('PUT')
        <div class="ibox ibox-info">
          <div class="ibox-head">
            <div class="ibox-title">{{ $item->title }}</div>
          </div>
          <div class="ibox-body">
            <!-- Include form -->
            @include($view.'.form')
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 text-right">
            <button class="btn btn-danger btn-rounded btn-delete" data-id="{{ $item->id }}" data-view="1" data-url="{{ route('activity.destroy') }}"><span class="fa fa-trash"></span> &nbsp;Delete</button>
            <button class="btn btn-info btn-rounded btn-submit"><span class="fa fa-refresh"></span> &nbsp;Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal History -->
<div class="modal fade" id="modal-history" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h6 class="modal-title">History</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="media-list media-list-divider m-0">
        @foreach($logs as $log)
          @if($log->employee_id == Auth::user()->id)
          <li class="media text-right">
            <div class="media-body">
              <div class="media-heading">{{ $log->first_name }}  <small class="float-left text-muted">{{ $log->created_at }}</small></div>
              <div class="font-13">{!! $log->message !!}</div>
            </div>
            <div class="media-img">
              <div class="img-circle" style="background-image: url('{{ $log->profile_img }}');"></div>
            </div>
          </li>
          @else
          <li class="media">
            <div class="media-img">
              <div class="img-circle" style="background-image: url('{{ $log->profile_img }}');"></div>
            </div>
            <div class="media-body">
              <div class="media-heading">{{ $log->first_name }}  <small class="float-right text-muted">{{ $log->created_at }}</small></div>
              <div class="font-13">{!! $log->message !!}</div>
            </div>
          </li>
          @endif
        @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<!-- Include custom javascript for this view -->
@include($view.'.script')
@endsection
