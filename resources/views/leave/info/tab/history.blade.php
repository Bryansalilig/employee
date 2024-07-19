<div class="row">
  <div class="col-12 form-group">
    <table class="table table-bordered table-striped mb-4" id="table-history">
      <thead>
        <tr>
          <th>Changed By</th>
          <th>Field</th>
          <th>Old Value</th>
          <th>New Value</th>
          <th>Changed Date</th>
        </tr>
      </thead>
      <tbody>
      @foreach($audits as $audit)
        <tbody>
          <tr>
            <td>
              <img src="{{ $audit->employee->profile_img }}" alt="{{ $audit->employee->fullname() }}">
              {{ $audit->employee->fullname2() }}
            </td>
            @if($audit->name == 'Create')
            <td colspan="3">Created a Leave Request</td>
            @else
            <td>{{ $audit->name }}</td>
            <td>{{ $audit->old }}</td>
            <td>{{ $audit->new }}</td>
            @endif
            <td>{{ date('m/d/Y h:i:s A', strtotime($audit->created_at)) }}</td>
          </tr>
        </tbody>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
