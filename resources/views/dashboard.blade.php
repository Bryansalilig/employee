@extends('layout.main')
@section('content')
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-success color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">HIRES</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_hires }}</span> <sub>(<span class="counter">{{ $old_hires }}</span>)</sub></h2>
          <i class="fa fa-user-plus widget-stat-icon"></i>
          <div><?= widgetPercentage($new_hires, $old_hires) ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-danger color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">ATTRITIONS</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_attrition }}</span> <sub>(<span class="counter">{{ $old_attrition }}</span>)</sub></h2>
          <i class="fa fa-user-times widget-stat-icon"></i>
          <div><?= widgetPercentage($new_attrition, $old_attrition) ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-primary color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">LEAVE REQUEST</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_leave }}</span> <sub>(<span class="counter">{{ $old_leave }}</span>)</sub></h2>
          <i class="fa fa-calendar widget-stat-icon"></i>
          <div><?= widgetPercentage($new_leave, $old_leave) ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-pink color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">INFRACTIONS</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_infraction }}</span> <sub>(<span class="counter">{{ $old_infraction }}</span>)</sub></h2>
          <i class="fa fa-warning widget-stat-icon"></i>
          <div><?= widgetPercentage($new_infraction, $old_infraction) ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-ebony color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">REFERRALS</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_referral }}</span> <sub>(<span class="counter">{{ $old_referral }}</span>)</sub></h2>
          <i class="fa fa-users widget-stat-icon"></i>
          <div><?= widgetPercentage($new_referral, $old_referral) ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-warning color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">OVERTIME REQUEST</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_overtime }}</span> <sub>(<span class="counter">{{ $old_overtime }}</span>)</sub></h2>
          <i class="fa fa-clock-o widget-stat-icon"></i>
          <div><?= widgetPercentage($new_overtime, $old_overtime) ?></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="ibox bg-info color-white widget-stat">
        <div class="ibox-body">
          <div class="m-b-5">UNDERTIME REQUEST</div>
          <h2 class="m-b-5 font-strong"><span class="counter">{{ $new_undertime }}</span> <sub>(<span class="counter">{{ $old_undertime }}</span>)</sub></h2>
          <i class="fa fa-circle-o widget-stat-icon"></i>
          <div><?= widgetPercentage($new_undertime, $old_undertime) ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="ibox">
        <div class="ibox-body">
          <div class="flexbox mb-4">
            <div>
              <h3 class="m-0">Hires</h3>
              <div>This Year VS Last Year</div>
            </div>
          </div>
          <div>
            <canvas id="chart-hires" style="height:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="ibox">
        <div class="ibox-body">
          <div class="flexbox mb-4">
            <div>
              <h3 class="m-0">Attritions</h3>
              <div>This Year VS Last Year</div>
            </div>
          </div>
          <div>
            <canvas id="chart-attrition" style="height:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="<?= URL::to('js/chart.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
new Chart(document.getElementById("chart-hires").getContext("2d"), {
  type: "line",
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    datasets: [{
      label: "{{ date('Y') }}",
      borderColor: '#3498db',
      backgroundColor: '#3498db',
      borderWidth: 2, // Adjust border width if needed
      lineTension: 0.4, // Adjust line tension for smoother curves
      pointRadius: 2, // Adjust point radius to make dots smaller
      data: <?= $hires['current'] ?>
    },{
      label: "{{ date('Y') - 1 }}",
      borderColor: "#ff6384",
      backgroundColor: '#ff6384',
      borderWidth: 2, // Adjust border width if needed
      lineTension: 0.4, // Adjust line tension for smoother curves
      pointRadius: 2, // Adjust point radius to make dots smaller
      data: <?= $hires['previous'] ?>
    }]
  },
  options: {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
      tooltip: {
        mode: 'index',
        intersect: false,
      },
    },
  },
});

new Chart(document.getElementById("chart-attrition").getContext("2d"), {
  type: "line",
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    datasets: [{
      label: "{{ date('Y') }}",
      borderColor: '#3498db',
      backgroundColor: '#3498db',
      borderWidth: 2, // Adjust border width if needed
      lineTension: 0.4, // Adjust line tension for smoother curves
      pointRadius: 2, // Adjust point radius to make dots smaller
      data: <?= $attrition['current'] ?>
    },{
      label: "{{ date('Y') - 1 }}",
      borderColor: "#ff6384",
      backgroundColor: '#ff6384',
      borderWidth: 2, // Adjust border width if needed
      lineTension: 0.4, // Adjust line tension for smoother curves
      pointRadius: 2, // Adjust point radius to make dots smaller
      data: <?= $attrition['previous'] ?>
    }]
  },
  options: {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
      tooltip: {
        mode: 'index',
        intersect: false,
      },
    },
  },
});

$.fn.animateValue = function() {
  return this.each(function() {
    const obj = $(this);
    const start = 0;
    const end = parseInt(obj.text().replace(/,/g, ''));
    const duration = 2500;
    let startTimestamp = null;

    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / duration, 1);
      const counterValue = Math.floor(progress * (end - start) + start).toLocaleString();
      obj.text(counterValue);
      if (progress < 1) {
        window.requestAnimationFrame(step);
      }
    };

    window.requestAnimationFrame(step);
  });
};

$(function() {
  $('.counter').animateValue();
});
</script>
@endsection
