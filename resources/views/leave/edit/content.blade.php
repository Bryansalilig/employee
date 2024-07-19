<div class="ibox ibox-{{ $item->getStatus('badge') }}">
  <div class="ibox-head">
    <div class="ibox-title">Leave Application Form</div>
  </div>
  <div class="ibox-body">
    <div class="row">
      <div class="col-12">
        <h5 class="text-info m-b-20 m-t-10"><i class="fa fa-user"></i> Basic Information</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-12 form-group">
        <label>Date Filed</label>
        <input class="form-control" type="text" name="date_filed" value="{{ date('Y-m-d', strtotime($item->date_filed)) }}" readonly>
      </div>
    </div>
  </div>
</div>
