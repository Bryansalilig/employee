<!--
  List View for Board > Activity Module

  Handles the List of Activities.

  @version 1.0
  @since 2024-04-20

  Changes:
  • 2024-04-20: File creation
  • 2024-04-23:
    - Add RSlides 
  • 2024-05-15:
    - Update Mission & Vision 
    - Update New Hires 
-->
@extends('layout.main')

@section('content')
<link href="<?= URL::to('vendors/rslides/responsiveslides.css')?>" rel="stylesheet" />
<link href="<?= URL::to('vendors/owlcarousel/owl.carousel.min.css')?>" rel="stylesheet" />
<link href="<?= URL::to('vendors/owlcarousel/owl.theme.default.min.css')?>" rel="stylesheet" />
<style type="text/css">
  .timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
  }

  .timeline:before {
    top: 0;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 3px;
    background-color: #eeeeee;
    left: 25px;
    margin-left: -1.5px;
  }

  .timeline > li {
    margin-bottom: 20px;
    position: relative;
  }

  .timeline > li:before,
  .timeline > li:after {
    content: " ";
    display: table;
  }

  .timeline > li:after {
    clear: both;
  }

  .timeline > li:before,
  .timeline > li:after {
    content: " ";
    display: table;
  }

  .timeline > li:after {
    clear: both;
  }

  .timeline > li > .timeline-panel {
    width: calc( 100% - 75px );
    float: right;
    border: 1px solid #d4d4d4;
    border-radius: 2px;
    padding: 20px;
    position: relative;
    -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  }

  .timeline > li > .timeline-panel:before {
    position: absolute;
    top: 26px;
    left: -15px;
    display: inline-block;
    border-top: 15px solid transparent;
    border-right: 15px solid #ccc;
    border-left: 0 solid #ccc;
    border-bottom: 15px solid transparent;
    content: " ";
  }

  .timeline > li > .timeline-panel:after {
    position: absolute;
    top: 27px;
    left: -14px;
    display: inline-block;
    border-top: 14px solid transparent;
    border-right: 14px solid #fff;
    border-left: 0 solid #fff;
    border-bottom: 14px solid transparent;
    content: " ";
  }

  .timeline > li > .timeline-badge {
    color: #fff;
    width: 50px;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
    text-align: center;
    position: absolute;
    top: 16px;
    left: 0px;
    margin-right: -25px;
    background-color: #999999;
    z-index: 100;
    border-top-right-radius: 50%;
    border-top-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-bottom-left-radius: 50%;
    overflow: hidden;
  }

  .timeline-title {
    margin-top: 0;
    color: inherit;
  }

  .timeline-body > p,
  .timeline-body > ul {
    margin-bottom: 0;
  }

  .timeline-body > p + p {
    margin-top: 5px;
  }

  #section-mission-vision h4:before {
    display: block;
    width: 100px;
    height: 100px;
    content: "";
    background-size: cover;
    margin: 0 auto 20px;
  }

  .text-mission:before {
    background: url('<?= URL::to('img/mission-icon.png')?>') no-repeat center center;
  }

  .text-vision:before {
    background: url('<?= URL::to('img/vision-icon.png')?>') no-repeat center center;
  }

  .img-circle{
    width: 80%;
    border: 4px solid #337ab7;
    background-size: cover;
    background-position: center;
    aspect-ratio: 1 / 1;
    margin: 0 auto;
  }

  .img-circle{
    transition: ease transform 300ms;
    background-size: unset;
    background-position: unset;
    overflow: hidden;
    position: relative;
  }

  .img-circle img{
    width: 110%;
    height: auto;
    transform: translate(-50%,-50%);
    position: absolute;
    left: 50%;
    top: 50%;
    object-fit: cover;
    max-width: 110%;
  }

  #section-new-hires .ibox-body .ibox-head{
    height: 30px;
    padding: 0 10px;
    background: #337ab7 !important;
  }

  #section-new-hires .ibox-body .ibox-title{
    font-size: 12px;
  }

  #section-new-hires .ibox .ibox-body, #section-birthday .ibox-body .ibox-body{
    padding: 10px 15px 15px 15px;
  }

  #section-new-hires .ibox h5{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 36px;
  }

  #section-new-hires .ibox .text-position{
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 39px;
  }

  #section-new-hires .owl-theme .owl-nav{
    margin: -20px !important;
  }

  #section-new-hires .owl-carousel .nav-button {
    width: 25px;
    cursor: pointer;
    position: absolute;
    top: 50% !important;
    transform: translateY(-50%);
  }

  #section-new-hires .owl-carousel .owl-prev {
    left: -20px;
  }

  #section-new-hires .owl-carousel .owl-next {
    right: -20px;
  }

  #section-new-hires .owl-theme .owl-nav [class*=owl-] {
    color: #ffffff;
    font-size: 39px;
    background: #000000;
    border-radius: 3px;
  }

  #section-new-hires .owl-carousel .prev-carousel:hover {
    background-position: 0px -53px;
  }

  #section-new-hires .owl-carousel .next-carousel:hover {
    background-position: -24px -53px;
  }

  #section-birthday .ibox-body .ibox {
    box-shadow: none !important;
  }

  #section-birthday .ibox-body .ibox-head {
    background: #fff !important;
    color: #000 !important;
    height: 30px;
    padding: 0 10px !important;
    border: 0;
    text-align: center;
    display: block;
  }

  #section-birthday .ibox h5{
    height: 36px;
  }
</style>

<!-- Page content -->
<div class="page-content fade-in-up">
  <!-- Row for Banner Slider -->
  <div class="row" id="section-slider">
    <div class="col-lg-12">
      <div class="ibox">
        <ul class="rslides">
        @foreach($banners as $key=>$banner)
          <li>
            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
            <p class="caption">{{ $banner->title }}</p>
          </li>
        @endforeach
        </ul>
      </div>
    </div>
  </div>

  <!-- Row for Vision & Mission -->
  <div class="row" id="section-mission-vision">
    <div class="col-12">
      <div class="ibox ibox-info">
        <div class="ibox-head">
          <div class="ibox-title">Mission & Vision</div>
        </div>
        <div class="ibox-body text-center">
          <div class="row">
            <!-- Mission Section -->
            <div class="col-md-6">
              <h4 class="text-mission">Mission</h4>
              <i>To provide our employees the career growth opportunities they aspire, and our customers the facilities, technologies, and services they deserve.</i>
            </div>

            <!-- Vision Section -->
            <div class="col-md-6">
              <h4 class="text-vision">Vision</h4>
              <i>To become the premier vendor of choice for advanced, standardized, and world-class outsourcing solutions.</i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row for New Hires -->
  <div class="row" id="section-new-hires">
    <div class="col-12">
      <div class="ibox ibox-info">
        <div class="ibox-head">
          <div class="ibox-title">New Hires</div>
        </div>
        <div class="ibox-body">
          <div class="owl-carousel owl-theme">
          @foreach($new_hires as $employee)
            <div class="item">
              <div class="ibox ibox-primary">
                <div class="ibox-head">
                  <div class="ibox-title"><span class="fa fa-calendar-o"></span>&nbsp; {{ date('F d, Y', strtotime($employee->prod_date)) }}</div>
                </div>
                <div class="ibox-body text-center">
                  <div class="img-profile m-b-10">
                    <div class="img-circle">
                      <img class="owl-lazy" data-src="{{ $employee->profile_img }}" alt="{{ formatName($employee->fullname()) }}">
                    </div>
                  </div>
                  <h5 class="font-strong m-b-10">{{ formatName($employee->fullname2()) }}</h5>
                  <div class="text-muted text-department">{{ $employee->team_name }}</div>
                  <div class="m-b-10 text-muted text-position">{{ $employee->position_name }}</div>
                </div>
              </div>
            </div>
          @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row for New Hires -->
  <div class="row" id="section-birthday">
    <div class="col-12">
      <div class="ibox ibox-info">
        <div class="ibox-head">
          <div class="ibox-title">Birthday Celebrants for {{ date('F') }}</div>
        </div>
        <div class="ibox-body">
          @if(count($today_birthdays) > 0)
          <div class="row justify-content-center">
            <div class="col-12 text-center">
              <h1 class="font-bold mb-2">Happy Birthday</h1>
              <h5 class="font-bold mb-4"><span class="fa fa-gift color-red"></span> {{ date('M d') }}</h5>
            </div>
            @foreach($today_birthdays as $employee)
            <div class="col-md-3">
              <div class="ibox ibox-info mb-0">
                <div class="ibox-body text-center">
                  <div class="img-profile m-b-10">
                    <div class="img-circle">
                      <img src="{{ $employee->profile_img }}" alt="{{ formatName($employee->fullname()) }}">
                    </div>
                  </div>
                  <h5 class="font-strong mb-0">{{ formatName($employee->fullname2()) }}</h5>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <hr class="text-dark">
          @endif
          <div class="row justify-content-center">
          @foreach($birthdays as $employee)
            @if(date('d') !== date('d', strtotime($employee->birth_date)))
            <div class="col-md-3">
              <div class="ibox ibox-info mb-0">
                <div class="ibox-head">
                  <div class="ibox-title"><span class="fa fa-gift color-red"></span> {{ date('M d', strtotime($employee->birth_date)) }}</div>
                </div>
                <div class="ibox-body text-center">
                  <div class="img-profile m-b-10">
                    <div class="img-circle">
                      <img src="{{ $employee->profile_img }}" alt="{{ formatName($employee->fullname()) }}">
                    </div>
                  </div>
                  <h5 class="font-strong mb-0">{{ formatName($employee->fullname2()) }}</h5>
                </div>
              </div>
            </div>
            @endif
          @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="<?= URL::to('vendors/rslides/responsiveslides.min.js')?>" type="text/javascript"></script>
<script src="<?= URL::to('vendors/owlcarousel/owl.carousel.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
var current_page = 2;
$(function() {
  $(".rslides").responsiveSlides({
    nav: true,    // Boolean: Show navigation, true or false
  });

  $('#more_new_hires').click(function(){
    $('#new_hire_loader').show();
    $('#more_new_hires').hide();
    $.ajax({
      url: "{{ route('newhires') }}" + "?page=" + current_page,
      success: function(result){
        setTimeout(function(){
          $('#new_hire_loader').hide();
          $('#more_new_hires').show();
          result.data.forEach(function(employee) {
            var timeline_list = '<li class="timeline-list">' +
              '<div class="timeline-badge">' +
                '<img src="' + employee.profile_img +'" alt="'+ employee.fullname +'">' +
              '</div>' +
              '<div class="timeline-panel">' +
                '<div class="timeline-heading">' +
                  '<h5 class="timeline-title">'+ employee.fullname +'</h5>' +
                  '<p><small class="text-muted"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp; '+ employee.prod_date +'</small></p>' +
                  '</div>' +
                  '<div class="timeline-body">' +
                    '<p>Joined the <b>'+ employee.team_name +'</b> as <b>'+ employee.position_name +'</b></p>' +
                  '</div>' +
              '</div>' +
            '</li>';

            $('.timeline-list:last-of-type').after(timeline_list);
          });
        }, 1500);
        current_page++;
      }, error: function(){
        $('#new_hire_loader').hide(); 
        $('#more_new_hires').show();
      }
    });
  });

  $('.owl-carousel').owlCarousel({
    autoplay: true,
    loop: true,
    margin: 10,
    nav: true,
    navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
    dots: false,
    items: 4,
    lazyLoad: true,
    lazyLoadEager: 4,
  });
});
</script>
@endsection
