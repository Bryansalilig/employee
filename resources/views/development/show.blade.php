@extends('layout.main')
@include('evaluation.style')
@include('development.style')
@section('content')
<div class="page-heading">
  <h1 class="page-title"><?= $item->draft ? 'Draft - ' : ''?>Yearly Development</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('team-development') }}"> Yearly Development</a></li>
    <li class="breadcrumb-item">Employee View</li>
  </ol>
</div>
<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-lg-3 col-md-4">
      <div class="ibox ibox-danger">
        <div class="ibox-body text-center">
          <div class="m-t-20 img-profile">
            <div class="img-circle circle-danger">
              <img src="{{ $employee->profile_img }}" id="profile-img">
            </div>
          </div>
          <h5 class="font-strong m-b-5 m-t-10" id="fullname">{{ $employee->last_name }}, {{ $employee->first_name }}</h5>
          <div class="text-muted m-b-10" id="position">{{ $employee->position_name }}</div>
          <!-- <div class="m-t-10" id="hired_date">{{ \Carbon\Carbon::parse($employee->hired_date)->format('d-M-y') }}</div>
          <div class="text-muted" id="position">Hired Date</div> -->
          <table class="table-bordered table-striped table-competency" id="table-result" style="width:100%;display:<?= (Auth::user()->usertype == 1) ? 'none' : ''?>">
            <?php $talent = '';
              switch($item->result->talent) {
                case 'Core': $talent = 'result_core';
                  break;
                case 'Growth': $talent = 'result_growth';
                  break;
                case 'High Talent': $talent = 'result_high';
                  break;
                default: $talent = 'result_develop';
                  break;
              }
            ?>
              <thead>
                  <tr>
                      <th colspan="2">Talent Score</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="result_score">{{ $item->result->score }}</td>
                      <td class="result_talent {{ $talent }}">{{ $item->result->talent }}</td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8">
      <div class="ibox">
        <div class="ibox-body">
       
          <form id="developmentId" method="post" enctype="multipart/form-data" autocomplete="off">
         
          {{ csrf_field() }}
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                  <a class="nav-link active" href="#tab-appraisee" data-toggle="tab"><i class="fa fa-user"></i> Evaluation</a>
                </li>
              </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-appraisee">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-bordered table-hover" id="table-guide" cellspacing="0" width="100%">
                    <thead class="accordion-toggle">
                      <tr>
                        <th class="text-center" colspan="3">
                          Scoring Guide
                          <span class="pull-right clickable">
                          <em class="fa fa-toggle-down"></em>
                          </span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="text-center accordion-content" style="display:none">
                      <tr>
                        <td class="bg bg-core">Core</td>
                        <td class="bg bg-growth">Growth</td>
                        <td class="bg bg-high">High Talent</td>
                      </tr>
                      <tr>
                        <td>The competency/skill is observed on an infrequent basis, there is a clear development opportunity here.</td>
                        <td>This competency/skill is observed, please continue to focus on it so that it is observed constantly without exception.</td>
                        <td>This competency/skill is observed on a constant basis; everyone in contact with this person would observe excellence in this area.</td>
                      </tr>
                      <tr>
                        <td>An employee with low potential and high performance who is effective at their role but has likely reached the limit for career potential. These employees can benefit from mentoring to boost performance.</td>
                        <td>An employee with medium potential and high performance who has reached their career potential in the organization and who benefits from delegation.</td>
                        <td> An employee with high potential and high performance who performs consistently and is self-motivated. These employees are typically identified by upper management as having leadership potential within the organization.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12">
                  <table class="table-bordered table-competency" id="table-score">
                    <thead>
                      <tr>
                        <th style="width: 100px;" class="text-center">Values</th>
                        <th style="width: 160px;" class="text-center">Description</th>
                        <th style="width: 200px;" class="text-center bg bg-core">Meets</th>
                        <th style="width: 200px;" class="text-center bg bg-growth">Exceeds</th>
                        <th style="width: 200px;" class="text-center bg bg-high">Always Exceeds</th>
                        <th style="width: 200px;" class="text-center">Recommendation to advance</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr>
                        <td class="bg bg-qualities">
                          Courtesy
                        </td>
                        <td>Carries respect and professionalism to clients, authors, and colleagues at all times. Treats all individuals in eLink with fairness and equality.</td>
                        <td><?= ($item->courtesy->score == 1) ? $item->courtesy->remark : '' ?></td>
                        <td><?= ($item->courtesy->score == 3) ? $item->courtesy->remark : '' ?></td>
                        <td><?= ($item->courtesy->score == 5) ? $item->courtesy->remark : '' ?></td>
                        <td><?= $item->courtesy->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Ownership
                        </td>
                        <td>Knows and understands job obligations,  actions, and job roles inside and outside of eLink.</td>
                        <td><?= ($item->ownership->score == 1) ? $item->ownership->remark : '' ?></td>
                        <td><?= ($item->ownership->score == 3) ? $item->ownership->remark : '' ?></td>
                        <td><?= ($item->ownership->score == 5) ? $item->ownership->remark : '' ?></td>
                        <td><?= $item->ownership->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Nurture
                        </td>
                        <td>Empowers, inspires, motivates, and encourages growth and development, personally and professionally, puts the needs of others first and helps people develop and perform as highly as possible.</td>
                        <td><?= ($item->nurture->score == 1) ? $item->nurture->remark : '' ?></td>
                        <td><?= ($item->nurture->score == 3) ? $item->nurture->remark : '' ?></td>
                        <td><?= ($item->nurture->score == 5) ? $item->nurture->remark : '' ?></td>
                        <td><?= $item->nurture->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Collaboration
                        </td>
                        <td>Working together and fostering healthy relationships and solving problems to reach eLink goals.</td>
                        <td><?= ($item->collaboration->score == 1) ? $item->collaboration->remark : '' ?></td>
                        <td><?= ($item->collaboration->score == 3) ? $item->collaboration->remark : '' ?></td>
                        <td><?= ($item->collaboration->score == 5) ? $item->collaboration->remark : '' ?></td>
                        <td><?= $item->collaboration->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Integrity
                        </td>
                        <td>Honest and showing uncompromising adherence to strong moral and ethical principles and upholds eLink values.</td>
                        <td><?= ($item->integrity->score == 1) ? $item->integrity->remark : '' ?></td>
                        <td><?= ($item->integrity->score == 3) ? $item->integrity->remark : '' ?></td>
                        <td><?= ($item->integrity->score == 5) ? $item->integrity->remark : '' ?></td>
                        <td><?= $item->integrity->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Seamlessness
                        </td>
                        <td>Adheres to eLink quality standards, processes, and guidelines to achieve our eLink promise.</td>
                        <td><?= ($item->seamlessness->score == 1) ? $item->seamlessness->remark : '' ?></td>
                        <td><?= ($item->seamlessness->score == 3) ? $item->seamlessness->remark : '' ?></td>
                        <td><?= ($item->seamlessness->score == 5) ? $item->seamlessness->remark : '' ?></td>
                        <td><?= $item->seamlessness->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Excellence
                        </td>
                        <td>Strives to do more and be great even if that means making errors along the way. Shows the desire to learn, grow, and evolve to achieve best-in-class service.</td>
                        <td><?= ($item->excellence->score == 1) ? $item->excellence->remark : '' ?></td>
                        <td><?= ($item->excellence->score == 3) ? $item->excellence->remark : '' ?></td>
                        <td><?= ($item->excellence->score == 5) ? $item->excellence->remark : '' ?></td>
                        <td><?= $item->excellence->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-qualities">
                          Emotional Intelligence
                        </td>
                        <td>Ability to perceive, interpret, demonstrate, control, evaluate, and use emotions to communicate with and relate to others effectively and constructively.</td>
                        <td><?= ($item->emotional_intelligence->score == 1) ? $item->emotional_intelligence->remark : '' ?></td>
                        <td><?= ($item->emotional_intelligence->score == 3) ? $item->emotional_intelligence->remark : '' ?></td>
                        <td><?= ($item->emotional_intelligence->score == 5) ? $item->emotional_intelligence->remark : '' ?></td>
                        <td><?= $item->emotional_intelligence->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-technical">
                          Balance
                        </td>
                        <td>Is flexible, able to plan, know what to prioritize, and reduces distractions to boost focus on tasks.</td>
                        <td><?= ($item->balance->score == 1) ? $item->balance->remark : '' ?></td>
                        <td><?= ($item->balance->score == 3) ? $item->balance->remark : '' ?></td>
                        <td><?= ($item->balance->score == 5) ? $item->balance->remark : '' ?></td>
                        <td><?= $item->balance->recommendation ?></td>
                      </tr>
                      <tr>
                        <td class="bg bg-technical">
                          Brilliance
                        </td>
                        <td>Ability to learn, adapt, unlearn, and relearn to keep up with constantly changing conditions and teach new knowledge to others.</td>
                        <td><?= ($item->brilliance->score == 1) ? $item->brilliance->remark : '' ?></td>
                        <td><?= ($item->brilliance->score == 3) ? $item->brilliance->remark : '' ?></td>
                        <td><?= ($item->brilliance->score == 5) ? $item->brilliance->remark : '' ?></td>
                        <td><?= $item->brilliance->recommendation ?></td>
                      </tr>
                      <?php $i = 0; ?>
                            <?php foreach($item->others as $key => $custom) { ?>
                                <tr style="height:100px">
                                    <td class="bg bg-technical"><?= $custom->role ?></td>
                                    <td><?= $custom->description ?></td>
                                    <td><?= ($custom->score == 1) ? $custom->remark : '' ?></td>
                                    <td><?= ($custom->score == 3) ? $custom->remark : '' ?></td>
                                    <td><?= ($custom->score == 5) ? $custom->remark : '' ?></td>
                                    <td><?= $custom->recommendation ?></td>
                                </tr>
                            <?php } ?>
                            <?php $i++; ?>
                      <tr id="row-entry"></tr>
                    </tbody>
                  </table>
                  <hr>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <h4 class="text-center font-bold" style="margin: 0 auto 15px;font-size: 17px;">Remember your GOALS must be SMART - SPECIFIC. MEASURABLE. ACHIEVABLE. RELEVANT. TIME-BASED</h4>
                      <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 50%;">Previous Goals</th>
                            <th class="text-center" style="width: 50%;">New Goals</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?= $item->goal->previous ?></td>
                            <td><?= $item->goal->new ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="form-group text-right m-t-20">
                <input type="hidden" name="result-score" value="0">
                <input type="hidden" name="result-talent" value="To Develop">
                <input type="hidden" name="result-recommendation" value="Not Ready">
                <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development/draft') ?>">Draft</button>
                <button type="submit" class="btn btn-info btn-tab" data-action="<?= url('development') ?>">Submit</button>
              </div> -->
                    </div>
                </div>
              </div>
              </div>
            </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@include('development.script')
@endsection