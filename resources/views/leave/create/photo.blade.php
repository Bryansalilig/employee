<div class="ibox ibox-danger">
  <div class="ibox-body text-center">
    <div class="m-t-20 img-profile">
      <div class="img-circle">
        <img src="{{ Auth::user()->profile_img }}" alt="{{ formatName(Auth::user()->fullname2()) }}">
      </div>
    </div>
    <h5 class="font-strong m-b-10 m-t-10">{{ formatName(Auth::user()->fullname2()) }}</h5>
    <div class="text-muted">{{ Auth::user()->position_name }}</div>
    <div class="text-muted">{{ Auth::user()->team_name }}</div>
  </div>
</div>
