<div class="text-center mb-4">
  <img src="{{ URL::to('public/img/elink-text.png') }}">
</div>
<h3 class="text-center font-bold mb-4">LEAVE APPLICATION REQUEST</h3>
<hr>
<div class="row">
  <div class="col-md-4 col-12 form-group">
    <label>Date Filed: </label>
    <h6>{{ date('F d, Y', strtotime($item->date_filed)) }}</h6>
  </div>
  <div class="col-md-4 col-12 ml-md-auto form-group">
    <label>Status: </label><br>
    <span class="badge bg-{{ $item->getStatus('badge') }}">{{ $item->getStatus() }}</span>
  </div>
  <div class="col-12 form-group">
    <table class="table table-bordered table-striped table-hovered mb-4">
      <thead>
        <tr>
          <th>Date</th>
          <th>Length</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      @foreach($details as $detail)
        <tbody>
          <tr>
            <td><b>{{ date('F d, Y', strtotime($detail->date)) }}</b></td>
            <td>{!! ($detail->length == 1) ? '<div class="alert alert-info d-inline-block p-1">Whole Day</div>' : '<div class="alert alert-warning d-inline-block p-1">Half Day</div>' !!}</div>
            <td>{!! ($detail->pay_type == 1) ? '<div class="alert alert-success d-inline-block p-1">With Pay</div>' : '<div class="alert alert-danger d-inline-block p-1">Without Pay</div>' !!}</div>
            </td>
          </tr>
        </tbody>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="col-md-4 col-12 form-group">
    <label>Number of Days: </label>
    <h6>{{ number_format($item->number_of_days) }}</h6>
  </div>
  <div class="col-md-4 col-12 ml-md-auto form-group">
    <label>Category: </label><br>
    {!! $item->getCategory() !!}
  </div>
  <div class="col-md-4 col-12 form-group">
    <label>Type: </label>
    <h6><?= (empty($type) ? 'Vacation + CTO Leave' : $type->leave_type_name) ?></h6>
  </div>
  <div class="col-md-4 col-12 form-group">
    <label>Contact Number: </label>
    <h6>{{ $item->contact_number }}</h6>
  </div>
  <div class="col-md-4 col-12 form-group">
    <label>Report Date: </label>
    <h6>{{ date('D | F d, Y', strtotime($item->report_date)) }}</h6>
  </div>
  <div class="col-12 form-group">
    <label>Reason: </label>
    <h6>{{ $item->reason }}</h6>
  </div>
</div>
