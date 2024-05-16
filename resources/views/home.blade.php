@extends('layout.main')
@section('content')
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
</style>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div id="homeCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                    @foreach($posts as $key=>$post)
                        <li data-target="#homeCarousel" data-slide-to="{{ $key }}" class="{{ ($key == 0) ? 'active' : '' }}"></li>
                    @endforeach
                    </ol>
                    <div class="carousel-inner">
                    @foreach($posts as $key=>$post)
                        <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                            <img src="{{ $post->image }}" class="d-block w-100" alt="...">
                        </div>
                    @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#homeCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#homeCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="ibox ibox-info">
                <div class="ibox-head">
                    <div class="ibox-title">Mission</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    To provide our employees the career growth opportunities they aspire, and our customers the facilities, technologies, and services they deserve.
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ibox ibox-info">
                <div class="ibox-head">
                    <div class="ibox-title">Vision</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    To become the premier vendor of choice for advanced, standardized, and world-class outsourcing solutions.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="ibox ibox-info">
                <div class="ibox-head">
                    <div class="ibox-title">New Hires</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <ul class="timeline">
                    @foreach($new_hires as $employee)
                        <li class="timeline-list">
                            <div class="timeline-badge">
                                <img src="{{ $employee->profile_img }}" alt="{{ $employee->fullname() }}">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5 class="timeline-title">{{ $employee->fullname() }}</h5>
                                    <p><small class="text-muted"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp; {{ prettyDate($employee->prod_date, 'M d, Y') }}</small></p>
                                </div>
                                <div class="timeline-body">
                                    <p>Joined the <b>{{ $employee->team_name }}</b> as <b>{{ ucwords(strtolower($employee->position_name)) }}</b></p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                    <div class="text-center mt-5">
                        <button class="btn btn-default" id="more_new_hires"><i class="fa fa-arrow-down"></i> View More</button>
                        <span class="fa fa-spinner" id="new_hire_loader" style="display: none;"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ibox ibox-info">
                <div class="ibox-head">
                    <div class="ibox-title">Birthday Celebrants for {{ date('F') }}</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <ul class="media-list list-unstyled">
                    @foreach($birthdays as $employee)
                        <li class="media">
                            <div class="img-circle" style="width: 50px;height: 50px;overflow: hidden; margin-right: 14px; background: #eee;">
                                <img src="{{ $employee->profile_img }}" style="width:50px;">
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">{{ $employee->fullname2() }}</h6><small>{{ prettyDate($employee->birth_date, 'F d') }}</small></div>
                            <div class="media-right"><i class="fa fa-gift font-16 color-red"></i></div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
		<div class="col-md-4">
		    <div class="ibox ibox-info">
		        <div class="ibox-head">
		            <div class="ibox-title">eLinkgagement Activities</div>
		            <div class="ibox-tools">
		                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
		            </div>
		        </div>
		        <div class="ibox-body text-center">
		        @foreach($engagements as $engagement)
		        	<div class="card engagement" data-img="{{ $engagement->image_url }}">
	                    <img class="card-img-top" src="{{ $engagement->image_url }}">
	                    <div class="card-body">
	                        <h4 class="card-title">{{ $engagement->title }}</h4>
	                        <div class="text-muted card-subtitle">{{ $engagement->subtitle }}</div>
	                        <p class="card-text">{{ date('m/d/Y', strtotime($engagement->activity_date)) }}</p>
	                    </div>
	                </div>
	            @endforeach
		        </div>
		    </div>
		</div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
var current_page = 2;
$(function() {
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
})
</script>
@endsection
