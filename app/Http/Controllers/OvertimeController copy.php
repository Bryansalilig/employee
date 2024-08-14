@extends('layouts.authenticated')
@section('pages')
<div class="container my-4">
  @auth
  <div class="d-flex">
    <h5>File Manager</h5>
    <div class="ms-auto d-flex gap-2">
      <a class="btn btn-sm btn-outline-dark" href="{{ route('folder.create', ['path' => $path]) }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="me-1" fill="currentColor"
          class="bi bi-folder-plus" viewBox="0 0 16 16">
          <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z" />
          <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z" />
        </svg>
        New Folder
      </a>
      <div class="btn-group">
        <a class="btn btn-sm btn-outline-primary pt-1" href="{{ route('file.upload', ['path' => $path]) }}">
          <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
            <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z" />
            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
          </svg>
          File Upload
        </a>
        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split " data-bs-toggle="dropdown" aria-expanded="false">
        <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
          <li>
            <a class="dropdown-item" href="{{ route('link.create', ['path' => $path]) }}">
              <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
              </svg>
              Add Link
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('markups.create', ['path' => $path]) }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-markdown" viewBox="0 0 16 16">
                <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"/>
                <path fill-rule="evenodd" d="M9.146 8.146a.5.5 0 0 1 .708 0L11.5 9.793l1.646-1.647a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 0-.708z"/>
                <path fill-rule="evenodd" d="M11.5 5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 1 .5-.5z"/>
                <path d="M3.56 11V7.01h.056l1.428 3.239h.774l1.42-3.24h.056V11h1.073V5.001h-1.2l-1.71 3.894h-.039l-1.71-3.894H2.5V11h1.06z"/>
              </svg>
              Add Markup
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <hr>
  @endauth
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      @foreach ($urls as $key => $value)
      @if ($key == basename($path))
      <li class="breadcrumb-item {{$key == basename($path)? 'active' : ''}}">{{Str::title(basename($key))}}</li>
      @else
      <li class="breadcrumb-item"><a href="{{route('dashboard',['path' => $value])}}">{{Str::title(basename($key))}}</a></li>
      @endif
      @endforeach
    </ol>
  </nav>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach ($directories as $directory)
    @if (substr(basename($directory),0,1) != ".")
    {{--  || substr(basename($directory),0,4) != "hide" --}}
    <div class="col">
      <div class="card h-100">
        <div class="card-body d-flex">
          <div class="d-flex w-100 gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="28" fill="currentColor"
              class="bi bi-folder" viewBox="0 0 16 16">
              <path
                d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z" />
            </svg>
            {{ basename($directory) }}
            {{-- <a class="stretched-link" href="{{ route('index', ['path' => $directory]) }}"></a> --}}
          </div>
          <div class="dropdown ms-auto">
            <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
              aria-expanded="false" style="">
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item"
                href="{{ route('dashboard', ['path' => $directory]) }}">Open</a></li>
              @auth
              <li><a class="dropdown-item" href="{{ route('folder.delete', ['path' => $directory]) }}"  onclick="return confirm('Are you sure you want to delete this folder?')">Delete</a></li>
              @endauth
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endif
    @endforeach
    @foreach ($files as $file)
    @if (substr(basename($file),0,1) != ".")
    <div class="col">
      <div class="card h-100">
        <div class="card-body d-flex ">
          <div class="d-flex gap-2 " >
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="28" fill="currentColor"
              class="bi bi-file-earmark-text" viewBox="0 0 16 16">
              <path
                d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
              <path
                d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
            </svg>
            <span class="text-break">
            {{ basename($file) }}
            </span>
          </div>
          <div class="dropdown ms-auto">
            <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
              aria-expanded="false" style="">
            </button>
            <ul class="dropdown-menu">
              {{--
              <li><a class="dropdown-item" href="{{Storage::url($file)}}#toolbar=0" target="_blank">Open</a></li>
              --}}
              <form action="{{route('files.open',['path' => $path])}}" method="post">
                @csrf
                <input type="hidden" name="file" value="{{$file}}">
                <button type="submit" class="dropdown-item">Open</button>
              </form>
              @auth
              <li><a class="dropdown-item" href="{{ route('file.downloadFile', ['file' => $file]) }}">Download</a></li>
              <li><a class="dropdown-item" href="{{ route('file.delete', ['file' => $file]) }}"  onclick="return confirm('Are you sure you want to delete this file?')">Delete</a></li>
              @endauth
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endif
    @endforeach
    @foreach ($links as $link)
    <div class="col">
      <div class="card h-100">
        <div class="card-body d-flex ">
          <div class="d-flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="28" fill="currentColor" class="bi bi-browser-chrome" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M16 8a8.001 8.001 0 0 1-7.022 7.94l1.902-7.098a2.995 2.995 0 0 0 .05-1.492A2.977 2.977 0 0 0 10.237 6h5.511A8 8 0 0 1 16 8ZM0 8a8 8 0 0 0 7.927 8l1.426-5.321a2.978 2.978 0 0 1-.723.255 2.979 2.979 0 0 1-1.743-.147 2.986 2.986 0 0 1-1.043-.7L.633 4.876A7.975 7.975 0 0 0 0 8Zm5.004-.167L1.108 3.936A8.003 8.003 0 0 1 15.418 5H8.066a2.979 2.979 0 0 0-1.252.243 2.987 2.987 0 0 0-1.81 2.59ZM8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
            </svg>
            {{ Str::title($link->name) }}
          </div>
          <div class="dropdown ms-auto">
            <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
              aria-expanded="false" style="">
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{$link->url}}" target="_blank">Open</a></li>
              @auth
              <li><a class="dropdown-item" href="{{route('links.edit', ['link' => $link, 'path' => $path])}}">Edit</a></li>
              <li><a class="dropdown-item" href="{{route('link.delete', ['link' => $link])}}" onclick="return confirm('Are you sure you want to delete this link?')">Delete</a></li>
              @endauth
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    @foreach ($markups as $markup)
    <div class="col">
      <div class="card h-100">
        <div class="card-body d-flex ">
          <div class="d-flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-markdown" viewBox="0 0 16 16">
              <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"/>
              <path fill-rule="evenodd" d="M9.146 8.146a.5.5 0 0 1 .708 0L11.5 9.793l1.646-1.647a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 0-.708z"/>
              <path fill-rule="evenodd" d="M11.5 5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 1 .5-.5z"/>
              <path d="M3.56 11V7.01h.056l1.428 3.239h.774l1.42-3.24h.056V11h1.073V5.001h-1.2l-1.71 3.894h-.039l-1.71-3.894H2.5V11h1.06z"/>
            </svg>
            {{ Str::title($markup->name) }}
          </div>
          <div class="dropdown ms-auto">
            <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
              aria-expanded="false" style="">
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('markups.open', ['markup' => $markup, 'path' => $path])}}" >Open</a></li>
              @auth
              <li><a class="dropdown-item" href="{{route('markups.edit', ['markup' => $markup, 'path' => $path])}}">Edit</a></li>
              <li><a class="dropdown-item" href="{{route('markups.delete', ['markup' => $markup])}}" onclick="return confirm('Are you sure you want to delete this link?')">Delete</a></li>
              @endauth
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @if (count($files) <= 0 && count($directories) <= 0 && count($links) <= 0 && count($markups) <= 0)
  <div class="row justify-content-center align-content-center" style="height: 80vh">
    <div class="col-md-4 ">
      <div class="d-flex justify-content-center gap-2">
        <img src="{{ asset('images/empty-folder.png') }}" height="100" width="100" alt="" srcset="">
        {{-- <img src="{{asset('images/readers_magnet.png')}}" height="90" width="90" alt="" srcset=""> --}}
      </div>
      <h6 class="text-center">This directory is empty</h6>
    </div>
  </div>
  @endif
</div>
@endsection
