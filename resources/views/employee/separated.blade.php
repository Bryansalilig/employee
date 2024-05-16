@extends('layout.main')
<style type="text/css">
   .dataTables_length {
   display: none;
   }
   /* Increase the font size of pagination links */
.dataTables_paginate a {
    font-size: 16px; /* Adjust the font size as needed */
}
.rounded-circle-container {
  max-width: 80px;
  max-height: 80px;
  width: 80px;
  height: 80px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #FF9999;
  border-radius: 50%;
  overflow: hidden;
  transition: box-shadow 0.3s; /* Add a transition effect to the box shadow */
}

.rounded-circle-container img {
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
}

.rounded-circle-container:hover {
  box-shadow: 0 0 10px #FF6666; /* Apply a box shadow to brighten the border on hover */
}



   .alphabet-search{
   display: inline-flex;
   list-style: none;
   padding-left: 0;
   margin-bottom: 10px;
   }
   .alphabet-search li{
   margin-right: 10px;
   }
   .alphabet-search li.m-t-5{
   margin-top: -5px
   }
   .alphabet-search form button{
   height: 35px;
   margin: 1px 0 0;
   }
   .alphabet-search #search_employee{
   padding: 5px;
   }
   .alphabet-search select{
   cursor: pointer !important;
   padding: 7px; 
   border-radius: 0px !important; 
   font-size: 11px !important;
   }
   .alphabet-search select.d-none{
   display: none;
   }
   .alphabet-search select#month_list{
   width: 200px; 
   }
   .alphabet-search .fa-filter{
   color: #777; 
   font-size: 18px; 
   padding: 5px;
   }
   .alphabet-search .btn-clear{
   margin: 0px;
   height: 30px;
   }
   .alphabet{
   font-weight: 500 !important;
   }
   .alphabet.selected{
   font-weight: bold !important;
   }

</style>
@section('content')
<div class="page-content fade-in-up">
<div class="row">
   <div class="col-lg-12">
      <div class="panel-heading">
         <div class="col-md-12">
         <i class="fa fa-home text-success"></i> / Employees > <span style="color:#3498db">Separated Employees</span><br><br>
         <ul class="alphabet-search">
            <li>
                
               <form>
                  <input type="hidden" name="alphabet" value="<?= $request->alphabet ?>">
                  <input type="hidden" name="department" value="<?= $request->department ?>">
                  <input type="text" placeholder="Search by name" id="search_employee" name="keyword" value="<?= $request->keyword ?>">
                  <button class="btn btn-primary">
                  <span class="fa fa-search" style="cursor:pointer"></span>
                  </button>
               </form>
            </li>
         </ul>
         </div>
         <div class="ibox-body">
            <table class="bg-white table" id="record_table" cellspacing="0" width="100%">
               <thead>
                  <tr style="display:none">
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($employees as $employee)
                  <tr>
                     <td>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="emp-profile">
                                 <div class="row d-flex">
                                    <div class="col-md-1">
                                    <div class="bg-white rounded-circle-container">
                                       <img src="{{ $employee->profile_img }}" alt="{{ $employee->fullname() }}">
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                          <a class="fullname" href="{{ url("employee_info/{$employee->slug}") }}" >{{ $employee->fullname() }}</a>
                                       <h5 style="font-size:15px;font-weight:450"><?= $employee->position_name ?></h5>
                                       <p class="employee-account" style="font-size:12px;font-weight:500">{{ $employee->team_name }} {{ isset($employee->account) ? "- ". $employee->account->account_name : "" ; }}</p>
                                    </div>
                                    <div class="col-md-3">
                                       <p>
                                          <span class="fa fa-id-card" title="Employee ID">&nbsp;&nbsp;</span>
                                          <span class="employee-description" style="font-size:15px"><?= $employee->eid ?></span>
                                       </p>
                                       <p class="employee-email-description">
                                          <span class="fa fa-envelope" title="Email Address">&nbsp;&nbsp;</span>
                                          <span class="employee-description employee-email" style="color:#0c59a2;font-size:15px" title="<?= $employee->email ?>"><?= $employee->email ?></span>
                                       </p>
                                       <?php
                              if(isset($employee->ext) && $employee->ext != '--' && $employee->ext != '') {
                                  ?>
                                       <h5>
                                          <span class="fa fa-phone" title="Extension Number">&nbsp;&nbsp;</span>
                                          <span class="employee-description" ><?= $employee->ext ?></span>
                                       </h5>
                                       <?php
                              }
                              if(isset($employee->alias) && $employee->alias != '--' && $employee->alias != '') {
                                  ?>
                                       <h5>
                                          <span class="fa fa-mobile" title="Phone Name">&nbsp;&nbsp;</span>
                                          <span class="employee-description" style="font-size:15px"><?= $employee->alias ?></span>
                                       </h5>
                                       <?php
                              }
         ?>
                                    </div>
                                    <div class="col-md-3">
                                       <p>
                                          <span class="fa fa-user" title="Supervisor"></span>
                                          <span class="name-format" style="color:#777;font-size:14px">Immediate Superior: </span>
                                          <span style="font-size:14px"><?= $employee->supervisor_name ?></span>
                                       </p>
                                       <p>
                                          <span class="fa fa-user" title="Manager"></span>
                                          <span class="name-format" style="color:#777;font-size:14px">Manager: </span>
                                          <span style="font-size:14px"><?= $employee->manager_name ?></span>
                                       </p>
                                    </div>
                                    <div class="col-md-1">
                                       <div class="options">
                                          <a href="<?= url("employee_info/{$employee->slug}") ?>" title="View">
                                          <i class="fa fa-eye"></i>
                                          </a>&nbsp;&nbsp;    
                                          <a href="<?= url("employees/{$employee->slug}/reactivate") ?>" title="Reactivate Employee" style="color:#008000" data-id="<?= $employee->id ?>">
                                            <i class="fa fa-user-plus"></i>
                                         </a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
   $(function() {
       $('#record_table').DataTable({
           pageLength: 10,
           lengthMenu: false,
           "bFilter": false,
       });
   })
</script>
<script type="text/javascript">
function rfc3986EncodeURIComponent (str) {  
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);
}
$(function() {
    var name_h = 21;
    var position_h = 13;
    var team_h = 13;

    // activeMenu($('#menu-active-employees'));

    $('#employee-card .col-md-3').each(function(key){
        var row = $(this).data('row'),
            name = $(this).find('h4.card-title'),
            position = $(this).find('h6.card-position'),
            team = $(this).find('h6.card-team');

        if(name_h != name.height()) {
            var h = (name_h > name.height()) ? name_h : name.height();

            $('#employee-card .col-md-3[data-row="'+row+'"]').find('h4.card-title').addClass('text-align-center').height(h);
        }

        if(position_h != position.height()) {
            var h = (position_h > position.height()) ? position_h : position.height();

            $('#employee-card .col-md-3[data-row="'+row+'"]').find('h6.card-position').addClass('text-align-center').height(h);
        }

        if(team_h != team.height()) {
            var h = (team_h > team.height()) ? team_h : team.height();

            $('#employee-card .col-md-3[data-row="'+row+'"]').find('h6.card-team').addClass('text-align-center').height(h);
        }
    });

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Employee');
        $('#messageModal #message').html('Are you sure you want to delete the employee ?');

        $('#messageModal .delete_form').attr('action', "<?= url('employee_info') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });

    $('#sort_option_list').change(function(){
        switch($(this).val()){
            case '1':
                $('#departments_list').show();
                $('#position_list').hide();
                $('#month_list').hide();
            break;
            case '2':
                $('#departments_list').hide();
                $('#position_list').show();
                $('#month_list').hide();
            break;
            case '3':
                $('#departments_list').hide();
                $('#position_list').hide();
                $('#month_list').show();
            break;
        }
    });

    $('#departments_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var keyword = "keyword=" + $("#search_employee").val();
        var alphabet = "alphabet=" + $('input[name=alphabet]').val();
        var department = "department=" + rfc3986EncodeURIComponent($(this).val());
        url += "?" + keyword + "&" + alphabet + "&" + department;
        window.location.replace(url);
    });

    $('#month_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var birthmonth = "birthmonth=" + $(this).val();
        url += "?" + birthmonth;
        window.location.replace(url);
    });

    $('#position_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var keyword = "keyword=" + $("#search_employee").val();
        var alphabet = "alphabet=" + $('input[name=alphabet]').val();
        var position = "position=" + rfc3986EncodeURIComponent($(this).val());
        url += "?" + keyword + "&" + alphabet + "&" + position;
        window.location.replace(url);
    });

    $('#inactive_employees').change(function(){
        if($(this).is(':checked')){
            var url = '{{ url("employees/separated") }}';
            window.location.replace(url);
        }
    });

    $('#no_profile_images').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        if($(this).is(':checked')){
            var no_profile_images = "no_profile_images=" + true;
            url += "?" + no_profile_images;
            window.location.replace(url);
        }
    });

    $('#invalid_birth_date').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        if($(this).is(':checked')){
            var no_profile_images = "invalid_birth_date=" + true;
            url += "?" + no_profile_images;
            window.location.replace(url);
        } else{
            window.location.replace(url);
        }
    });
});
</script>
@endsection

