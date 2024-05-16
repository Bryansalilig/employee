<!--
  Edit Page for Board > Event Module

  Handles the Update Form of Event.

  @version 1.0
  @since 2024-04-04

  Changes:
  • 2024-04-04: File creation
-->
@extends('layout.main')

@section('style')
<link href="<?= URL::to('public/vendors/jquery-minicolors/jquery.minicolors.css')?>" rel="stylesheet" />
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
    <li class="breadcrumb-item"><a href="{{ route('events') }}">Events</a></li>
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
    <a href="{{ route('events') }}" class="btn btn-danger btn-rounded"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
  </div>
</div>

<!-- Page content -->
<div class="page-content fade-in-up">
  <!-- Creation Form -->
  <form role="form" method="POST" action="{{ route('event.update', ['id' => $item->id]) }}" novalidate="novalidate" enctype="multipart/form-data" autocomplete="off">
  @csrf
  @method('PUT')
    <div class="ibox ibox-info">
      <div class="ibox-head">
        <div class="ibox-title">{{ $item->event_name }}</div>
      </div>
      <div class="ibox-body">
        <!-- Include form -->
        @include($view.'.form')
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 text-right">
        <button class="btn btn-danger btn-rounded btn-delete" data-id="{{ $item->id }}" data-view="1" data-url="{{ route('event.destroy') }}"><span class="fa fa-trash"></span> &nbsp;Delete</button>
        <button class="btn btn-info btn-rounded btn-submit"><span class="fa fa-refresh"></span> &nbsp;Update</button>
      </div>
    </div>
  </form>
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
<script src="<?= URL::to('public/vendors/jquery-minicolors/jquery.minicolors.min.js')?>" type="text/javascript"></script>
<!-- Include custom javascript for this view -->
@include($view.'.script')
@endsection
