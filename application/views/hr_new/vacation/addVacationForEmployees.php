   <?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
	<?php  } ?>
	<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
   <?php  } ?>
<!--begin::Content-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact mt-5">
            <div class="card-header">
                <h3 class="card-title">  Add Vacation Request For Employee </h3> 
            </div>
            <div class="card-body">
                <!--begin::Form-->
                <form class="form-horizontal " id="form"action="<?php echo base_url() ?>hr/doAddVacationForEmployees" method="post" onsubmit="return onAddVacationRequest();"name="addVacatin" enctype="multipart/form-data">
                   <div class="form-group row">
                       
                       <label class="col-lg-3 control-label text-right" for="role date">Select Employee Name:</label>

                        <div class="col-lg-6">
                             <select name="emp_id" id="emp_id" class="form-control" onchange="changeVacationType();"value="" required="" >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->getEmployeesNameByManager(); ?> 
                            </select>
                        </div>
                
                    </div>
                    <div id="vacation_div" style="display: none">
                        <div class='form-group row'>
                            <label class='col-lg-3 control-label text-right ' for='inputPassword'>Type Of Vacation</label>
                            <div class='col-lg-6'>
                                <select name='type_of_vacation'class='form-control m-b'id="type_of_vacation" onchange="calculateAvailableVacationDays(0);"value="" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?= $this->hr_model->selectAllVacationTypies() ?>
                                </select>
                            </div> 
                        </div> 
                        <div class='form-group row'id="relative_degree_div" style="display: none;">
                            <label class='col-lg-3 control-label text-right ' for='inputPassword'>Relative Degree</label>
                            <div class='col-lg-6'>
                                <select name='relative_degree'class='form-control m-b'id="relative_degree" onchange="calculateAvailableVacationDays();">
                                    <option value="" selected=''>-- Select --</option>
                                    <option value="1" >First</option>
                                    <option value="2" >Second</option>
                                </select>
                            </div> 
                        </div>  
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-right " >Available Days</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control"value =" " name="available_days" id="available_days" data-maxlength="300"  placeholder="Available days" readonly>
                                <input type="text" class="form-control" value =" " name="availableDays" id="availableDays" data-maxlength="300" placeholder="Available days" hidden="">
                            </div>
                        </div>
                        <div class="form-group row" id="requested_days_div" >
                            <label class="col-lg-3 control-label text-right" >Requested Days</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control"  value =" " name="requested_days" id="requested_days" data-maxlength="300"  placeholder="Requested days" readonly>
                            </div>
                        </div>
                        <div class='form-group row'id="day_type_div" style="display: none;">
                            <label class='col-lg-3 control-label text-right' >Vacation Day Type</label>
                            <div class='col-lg-6'>
                                <select name='day_type'class='form-control m-b'id="day_type" onchange="checkVacationCredite();">                                       
                                    <option value="0" selected=''>Full Day</option>
                                    <option value="1" >½ Day</option>
                                </select>
                            </div> 
                        </div>                          

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-right" >Start</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control date_sheet" name="start_date" autocomplete="off" onblur="onBlur();" id="start_date" data-maxlength="300" placeholder="Start Date" required="">
                            </div>
                        </div>  
                        <div class="form-group row" id="end_date_div">
                            <label class="col-lg-3 control-label text-right" >End</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control date_sheet" name="end_date"autocomplete="off" onblur="onBlur()" id="end_date" data-maxlength="300"  placeholder="End Date" required="">
                                <input style="display: none;" type="text" class=" form-control"  value =" " name="show_end_date" id="show_end_date" data-maxlength="300"  placeholder="End Date" readonly>

                            </div>
                        </div>
                        <div class="form-group row" id="sick_leave_file" style="display: none;">
                            <label class="col-lg-3 control-label text-right" >Sick Leave Document</label>

                            <div class="col-lg-6">

                                <input type="file" id="file"name="file" > 
                            </div>
                        </div>  
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-offset-3 col-lg-6">
                            <button class="btn btn-success"name="save" type="submit">Save</button> 
                            <a href="<?php echo base_url() ?>hr/vacation" class="btn btn-danger" type="button">Cancel</a>
                        </div>
                    </div>


                </form>
                <!--end::Form-->
            </div>
            <!-- end card body -->
        </div>
        <!--end::Card-->
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
      });
    function changeVacationType() { 
        $("#vacation_div").show();
        $("#type_of_vacation").val('1').change();
    }
  
</script>