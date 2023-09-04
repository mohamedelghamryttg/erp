<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .sticky-col{
        background-color: #F0F0F0;        
        /*background-color: #FFF;*/        
        position: sticky; left: 0;
    }
    .sticky-head{
        position: sticky;
        top: 0;       
         background-color: #F0F0F0;     
        /*background: #FFF;*/
    }
    li::marker{
          color: #F64E60;    
    }
    li span{
       width: 35px;
        display: inline-block;
    }
    
    .two-background{
       background: linear-gradient(
            to right,
            #FFA800  0%,
            #FFA800  50%,
            #1BC5BD  50%,
            #1BC5BD  100%
          );
    }
</style>
<?php if ($this->session->flashdata('true')) { ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong><?= $this->session->flashdata('true') ?></strong></span>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong><?= $this->session->flashdata('error') ?></strong></span>
    </div>
<?php } ?>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!-- start search form card --> 
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Time Sheet</h3>
                </div>
                <div class="card-body">
                    <form class="form" id="time_sheet" action="<?php echo base_url() ?>hr/timeSheet" method="get" enctype="multipart/form-data">

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right">Payroll Month:</label>
                            <div class="col-lg-4">
                                <select name="payroll_month" class="form-control m-b" id="month" onchange="clearDates();">
                                <option value="">-- Select Month --</option>
                                <?= $this->hr_model->selectYearANDMonth($year ? $year : 0, $month ? $month : 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row date_row">
                            <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date From</label>
                            <div class="col-lg-3">
                                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required=""value="<?=$date_from?>" <?=$month?'disabled':''?>>
                            </div>

                            <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date To</label>
                            <div class="col-lg-3">
                                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="" value="<?=$date_to?>" <?=$month?'disabled':''?>>
                            </div>
                            <?php if ($permission->view == 1 ) {?>  
                        </div>
                        <div class="form-group row">
                           <label class="col-lg-2 col-form-label text-lg-right" for="role name">Function</label>
                            <div class="col-lg-3">
                                <select name="department" class="form-control m-b" id="department"/>
                                        <option value="" selected="">-- Select Department --</option>
                                        <?=$this->hr_model->selectDepartmentKpi($department)?>
                                </select>
                            </div>  
                           
                           <label class="col-lg-2 col-form-label text-lg-right" for="role name">Name</label>
                            <div class="col-lg-3">
                                <select name="name" class="form-control m-b" />
                                    <option value="">-- Select Employee --</option>
                                    <?=$this->hr_model->selectEmployee($name)?>
                                </select>
                            </div>  
                            <?php }?>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button class="btn btn-success " name="search" type="submit"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                     <?php if ($permission->view == 1 ) {?> 
                                        <button class="btn btn-warning" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                                     <?php }?>
                                    <a href="<?= base_url() ?>hr/timeSheet" class="btn btn-danger"><i class="la la-trash"></i>Clear Filter</a> 

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- end search form -->

            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">               
                <div class="card-body ">

                    <table class="table table-bordered table-responsive pb-10 "style ="max-height:500px">
                        <thead>
                            <tr class="sticky-head">
                                <!--<th >#ID</th>-->
                                <th class="sticky-col">Employee</th>
                                <?php                               
                                foreach ($days as $key => $day) {
                                    echo "<th class='font-size-xs text-center'style='font-size:11px'>" . $day->format('d M') .
                                       "<br/><span style='font-size:10px;color:#e83e8c'>".$day->format('D').
                                    "</span></th>";
                                }
                                ?>   
                                <th >Total Worked</th>
                                <th >Total WO </th>
                                <th >Total WH</th>
                                <th >Total Off </th>
                                <th >Total Deductions </th>
                                <th >Approval Status </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($employees as $emp) { ?>
                            <tr class="text-center">
                                    <!--<td ><?= $emp->id ?></td>-->
                                    <td class="sticky-col"><?= word_limiter($emp->name, 3, ' ') ?></td>
                                    <?php  $count_deduction = 0;
                                    foreach ($days as $key => $day) {                                       
                                        $status = $this->hr_model->getDayStatus($emp->id, $day->format('Y-m-d'));
                                        if($status=="W"){
                                            $location = $this->hr_model->checkAttendanceLocationDetails($emp->id, $day->format('Y-m-d'));
                                            $status = $status.$location;                                            
                                        }?>
                                        <td class="font-size-sm <?= $this->hr_model->getDayStatusClass($status)?> ">
                                            <span class="status"><?= $status?></span>
                                            <?php if($status == 'A'){
                                                $count_deduction++;?>
                                            <form style="margin:-25px 6px 0;" id="attendance" action="<?php echo base_url() ?>hr/attendance" method="post">
                                                <input class="form-control" type="hidden" name="date_from" value="<?= $day->format('m/d/Y') ?>" readonly>
                                                <input class="form-control" type="hidden" name="date_to" value="<?= $day->format('m/d/Y') ?>" readonly>
                                                <input class="form-control" type="hidden" name="user" value="<?= $emp->id ?>" readonly>
                                                <button class="btn btn-xs btn-icon btn-clean inline" name="search" type="submit" data-toggle="tooltip" title="Check The Attendance Record For This Day"><i class="flaticon-info"></i></button>
                                            </form>
                                            <?php }?>
                                        </td>
                                     <?php } ?>
                                    <td class="worked font-weight-bolder"></td>
                                    <td class="worked_office text-success font-weight-bolder"></td>
                                    <td class="worked_home text-warning font-weight-bolder"></td>
                                    <td class="off font-weight-bolder"></td>
                                    <td class="deduction text-danger font-weight-bolder"></td>
                                    <?php $approval_status = $this->hr_model->checkTimeSheetRowStatus($emp->id,$payroll_month??0,$count_deduction);
                                    if($approval_status['need_approval'] == 1 && $this->hr_model->checkThisUserIsEmployeeManager($emp->id)){
                                   // if($approval_status['need_approval'] == 1 ){
                                    // if need approval & this user is emp manager -> shows approval model else shows ribbon status?>
                                    <td class="font-size-sm">                                       
                                        <a href="#ManagerApproveModal_<?= $emp->id ?>" data-toggle="modal" class="btn btn-sm btn-dark">Manager Approval</a>
                                            <!-- start manager pop up form -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ManagerApproveModal_<?= $emp->id;?>" class="modal fade">
                                                 <div class="modal-dialog min-w-750px">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                              <h4 class="modal-title">Manager Approval</h4>
                                                             <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>                                                            
                                                         </div>
                                                         <div class="modal-body">
                                                             <form action="<?php echo base_url() ?>hr/approveTimeSheet" method="post"> 
                                                                <div class="form-group row" >
                                                                    <input name="emp_id" value="<?= $emp->id ?>" type="hidden" />
                                                                    <input name="payroll_month" value="<?= $payroll_month ?>" type="hidden" />

                                                                    <label class="col-lg-3 control-label text-right" for="role name">Manager Action : </label>  
                                                                    <div class="col-lg-7 text-left" >
                                                                        <select name="manager_approval"  id="manager_approval_<?= $emp->id ?>" class="form-control manager_approval" required="" onchange="checkManagerApproval(this)">
                                                                            <option value="" disabled="" selected="">-- Select status --</option>
                                                                        <option value="1">Approve</option>
                                                                        <option value="2">Reject</option>
                                                                        </select>
                                                                    </div> 
                                                                </div>
                                                                 <div class="form-group row reason_div" style="display:none">                                                     
                                                                    <label class="col-lg-3 control-label text-right" for="role name">Reason : </label>  
                                                                    <div class="col-lg-7" >
                                                                        <textarea name="comment" class="form-control" rows="7" ></textarea>
                                                                    </div> 
                                                                </div>
                                                                <button class="btn btn-danger  btn-block"  type="submit" >Submit</button>
                                                            </form>
                                                   </div>
                                                 </div>
                                               </div>
                                             </div>
                                            <!-- end pop up form -->
                                    </td>
                                    <?php }else{?>
                                    <td class="font-size-sm ribbon ribbon-clip ribbon-right">
                                        <div class="ribbon-target font-weight-bolder " style="top: 12px;">                                            
                                            <span class="ribbon-inner <?=$approval_status['class']?>"></span><?=$approval_status['status']?><i data-toggle="tooltip" title="<?=$approval_status['msg']?>" class="ml-1 fas fa-info-circle text-white"></i>
                                       </div>
                                    </td>
                                     <?php }?>
                                </tr> 
                        <?php } ?>

                        </tbody>
                    </table>
                    <div class="row">
                        <ul class='font-weight-bold'>
                            <li><span><span class="p-1 bg-success mr-1 w-15px"> </span>W  </span>:&nbsp; Working Day
                                <ul>  
                                    <li><span><span class="p-1 bg-success mr-1 w-15px"> </span>O  </span>:&nbsp; Office</li>
                                    <li><span><span class="p-1 bg-warning mr-1 w-15px"> </span>H  </span>:&nbsp; Home</li>
                                </ul>
                            </li>
                            <li><span>H  </span>:&nbsp; Holiday</li>
                            <li><span><span class="p-1 bg-light mr-1 w-15px"> </span>V  </span>:&nbsp; Vacation</li>
                            <li><span>WE </span>:&nbsp; Weekend</li>                           
                            <li><span>MV </span>:&nbsp; Marriage Vacation</li>
                            <li><span>SL </span>:&nbsp; Sick Leave</li>
                            <li><span>RL </span>:&nbsp; Rest Leave</li>                            
                            <li><span><span class="p-1 bg-danger mr-1 w-15px"> </span>A  </span>:&nbsp; Absent Day ( check your  <a href="<?=base_url()?>hr/attendance">attendance log</a> )</li>
                        </ul>                       
                        <p class="w-100 font-weight-bold"><span class="text-danger font-weight-bolder">Note  </span>:&nbsp; Click On "A" Absent Day To View Attendance Record For The Day.</p>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<script>
    $('tr').each(function () {
        var count_worked = 0;
        var count_office_worked = 0;
        var count_home_worked = 0;
        var count_off = 0;
        var count_deduction = 0;
        $(this).find('.status').each(function () {          
            if ($(this).html() == 'W' || $(this).html() == 'WO' || $(this).html() == 'WH') {
                count_worked++;
            } else {
                count_off++;
            }
            if ($(this).html() == 'A') {
                count_deduction++;
            }
            if ($(this).html() == 'WO' ) {
                count_office_worked++;
            }
            if ($(this).html() == 'WH') {
                count_home_worked++;
            }
        });
        $(this).find('.worked').html(count_worked);
        $(this).find('.off').html(count_off);
        $(this).find('.deduction').html(count_deduction);
        $(this).find('.worked_office').html(count_office_worked);
        $(this).find('.worked_home').html(count_home_worked);
    });
    function clearDates() {
        $('.date_sheet').val('');
        $('.date_sheet').attr("disabled", false);
        
        if($("#month").val() == ''){
            $('.date_row').show();
            $('.date_sheet').attr("required", true);
        }
        else{
            $('.date_row').hide();
            $('.date_sheet').attr("required", false);
        }
    }
    
    function checkManagerApproval(ele){
        var reason_div = $(ele).closest(".modal").find(".reason_div");
        if(ele.value  ==  2){
           reason_div.show();
           reason_div.attr("required", true);
        }else{
           reason_div.hide();
           reason_div.attr("required", false);
        }
    }
  
</script>