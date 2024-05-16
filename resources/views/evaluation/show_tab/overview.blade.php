<style>
  .eval-info{
    font-size: 15px;
  }
</style>
<div class="row">
  <div class="col-md-12 m-t-10">
    <h5 class="text-default text-center m-b-10 m-t-2">
    <img src="<?= asset('img/elink-logo-site.png') ?>" alt="eLink Systems & Concepts Corp." style="width:50px;height:50px"> 
    <strong>&nbsp;eLink Systems & Concepts Corp.</strong></h5>
    
   <h4 class="text-default text-center" style="text-transform:uppercase"><b>{{ $item->title }}</b></h4>
   <br>
   <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th class="text-center">CRITERIA</th>
                  <th class="text-center">% WEIGHT</th>
                  <th class="text-center">RATING</th>
                  <th class="text-center">EQUIVALENT</th>
               </tr>
            </thead>
            <tbody>
            <?php $final = 0; ?>
               <tr class="text-center <?= ($item->job_knowledge->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Job knowledged</strong></td>
                <td>20%</td>
                <td>{{ $item->job_knowledge->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->job_knowledge->score * 20) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->dependability->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Dependability</strong></td>
                <td>15%</td>
                <td>{{ $item->dependability->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->dependability->score * 15) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->problem_solving->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Problem Solving</strong></td>
                <td>5%</td>
                <td>{{ $item->problem_solving->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->problem_solving->score * 5) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->efficiency->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Efficency</strong></td>
                <td>5%</td>
                <td>{{ $item->efficiency->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->efficiency->score * 5) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->work_attitude->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Work Attitude</strong></td>
                <td>15%</td>
                <td>{{ $item->work_attitude->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->work_attitude->score * 15) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->initiative->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Initiative</strong></td>
                <td>5%</td>
                <td>{{ $item->initiative->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->initiative->score * 5) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->attendance->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Attendance</strong></td>
                <td>10%</td>
                <td>{{ $item->attendance->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->attendance->score * 10) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->cooperation->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Cooperation</strong></td>
                <td>15%</td>
                <td>{{ $item->cooperation->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->cooperation->score * 15) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
               <tr class="text-center <?= ($item->proactiveness->score < 3) ? 'text-danger' : '' ?>">
                <td class="text-left"><strong>Proactiveness</strong></td>
                <td>10%</td>
                <td>{{ $item->proactiveness->score }}</td>
                <td class="text-center equiv">
                  <?php
                      $equiv = ($item->proactiveness->score * 10) / 100;
                      echo $equiv;
                      $final += $equiv;
                  ?>
                </td>
               </tr>
            </tbody>
            <tfoot>
              <tr>
                  <td></td>
                  <td></td>
                  <td class="text-right"><b>FINAL RATING</b></td>
                  <td class="text-center total <?= ($final > 2.99) ? '' : 'text-danger' ?>"><b><?= $final ?></b></td>
              </tr>
            </tfoot>
         </table>
         <div class="row">
         <?php if(!empty($item->reactions)) { ?>
              <div class="col-md-6">
                  <label>Appraisee's Comments:</label>
                  <p><?= $item->reactions ?></p>
              </div>
          <?php } ?>
          <?php if(!empty($item->manager_notes)) { ?>
              <div class="col-md-6">
                  <label>Manager Notes:</label>
                  <p><?= $item->manager_notes ?></p>
              </div>
          <?php } ?>
          </div>
         <br>
         <div class="row">
          <div class="col-md-4">
              <h5 class="m-b-10 m-t-10 eval-info">Evaluator:</h5>
              <p class="mb-2">{{ strtoupper($superior->first_name. ' ' .$superior->last_name). ' ' .(($superior->id == Auth::user()->id) ? '(You)' : '') }}</p>
              <small>{{ $superior->position_name }}</small><br>
              <small>{{ prettyDate($item->created_at) }}</small>
            </div>
          <div class="col-md-4">
            <h5 class="m-b-10 m-t-10 eval-info">Appraisee:</h5>
            <p class="mb-2">{{ strtoupper($employee->first_name. ' ' .$employee->last_name). ' ' .(($employee->id == Auth::user()->id) ? '(You)' : '') }}</p>
            <small>{{ $employee->position_name }}</small><br>
            <small class="{{ ($item->is_acknowledged) ? 'text-success' : ''}}">{{ ($item->is_acknowledged) ? prettyDate($item->acknowledged_date) : 'Not Acknowledge' }}</small>
          </div>
          <div class="col-md-4">
            <h5 class="m-b-10 m-t-10 eval-info">Manager:</h5>
            <p class="mb-2">{{ (!empty($manager) ? strtoupper($manager->first_name. ' ' .$manager->last_name) : 'NO MANAGER'). ' ' .((!empty($manager) && $manager->id == Auth::user()->id) ? '(You)' : '') }}</p>
            <small>{{ (!empty($manager) ? $manager->position_name : '-')}}</small><br>
            <small class="{{ (!empty($item->manager_notes)) ? 'text-success' : ''}}">{{ (!empty($item->manager_notes)) ? prettyDate($item->notes_date) : 'Not Remarks' }}</small>
          </div>
        </div>
  </div>
</div>
<div class="form-group text-right m-t-20">
  <div class="dropdown d-inline">
      <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Print <span class="caret"></span></button>
      <ul class="dropdown-menu">
          <li><a href="<?= url("excel-evaluation/{$item->slug}") ?>">Excel</a></li>
          <li><a href="<?= url("pdf-evaluation/{$item->slug}") ?>">PDF</a></li>
      </ul>
  </div>
  @if ($item->employee_id == Auth::user()->id && $item->is_acknowledged == 0)
  <button class="btn btn-info btn-tab">Acknowledge</button>
  @endif
 
  @if (!empty($manager) && $employee->manager_id == Auth::user()->id)
  <button class="btn btn-tab bg-teal">Notes</button>
  @if ($item->eval_approval == 0)
  <button class="btn btn-primary btn-tab">Approve</button>
    @endif
  @endif
</div>
<script type="text/javascript">
  $(function (){
    var totalValue = $('.text-center.total b').text();

    // Update the text content of the <b> tag
    $('.btn-block b').text('{{ $final }}');

    // Check the condition
    if (parseFloat(totalValue) > 2.99) {
        // Remove the 'btn-danger' class
        $('.btn-block').removeClass('btn-danger');
        
        // Add the 'btn-success' class
        $('.btn-block').addClass('btn-success');
    }else {
      // Remove the 'btn-danger' class
      $('.btn-block').removeClass('btn-success');
        
        // Add the 'btn-success' class
        $('.btn-block').addClass('btn-danger');
    }
  });
</script>