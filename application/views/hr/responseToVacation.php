<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Response Vacation Request
			</header> 
			
			<div class="panel-body">
				<div class="form">
			<form class="cmxform form-horizontal "onsubmit="return responseVactionRequest(); "  id="form"action="<?php echo base_url()?>hr/doUpdateVacationStatus" method="post" name="addVacatin" enctype="multipart/form-data">
                <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                <input type="text" name="return" id="return" hidden="" value="1" >
                 <input type="text" name="return_available_days" id="return_available_days" hidden="" value="1" >
                            <div class='form-group'>
                                <label class='col-lg-3 control-label'>Name</label>
                                <div class='col-lg-6'>
                                <input type="text" class=" form-control" name="emp_id"  data-maxlength="300" value="<?=$this->hr_model->getEmployee($row->emp_id)?>" placeholder="Name" readonly>
                                <input type="text" class=" form-control"id="emp_id_" name="emp_id_"  data-maxlength="300" value="<?=$row->emp_id?>" placeholder="Name" hidden readonly>
                                </div>
                            </div>
                           <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Type Of Vacation</label>
                                <div class='col-lg-6'>
                                <input type="text" class=" form-control" name="type_of_vacation" id="type_of_vacation" data-maxlength="300" value="<?=$this->hr_model->getAllVacationTypies($row->type_of_vacation),$row->requested_days == 0.5?' (½ Day) ':'';?>" placeholder="Type Of Vacation" readonly>
                                <input type="text" class=" form-control" name="type_of_vacation_" id="type_of_vacation_" data-maxlength="300" value="<?=$row->type_of_vacation?>" placeholder="Type Of Vacation" hidden readonly>
                                <input type="text" class=" form-control" name="day_type" id="day_type"  value="<?=$row->requested_days == 0.5?'1':'0'?>" placeholder="Type Of Vacation" hidden readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Start</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control datepicker" value="<?=$row->start_date?>" name="start_date"  id="start_date" data-maxlength="300"  placeholder="Number Of Days" required=""readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >End</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control datepicker"value="<?=$row->end_date?>" name="end_date" onblur="checkVacationCredite();" id="end_date" data-maxlength="300"  placeholder="Number Of Days" required=""readonly>
                                </div>
                            </div>
                             <div class="form-group" id="medical_document" style="display: none;">
                                <label class="col-lg-3 control-label" >Medical Document</label>

                                <div class="col-lg-6">
                                    <?php if(strlen($row->sick_leave_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/sickLeaveDocument/<?=$row->sick_leave_file?>" target="_blank">Download Document</a><?php } ?>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Status</label>
                                <div class='col-lg-6'>
                                    <select name='status'class='form-control m-b'id="status" value="<?=$row->status?>" required="" onchange="onApprove(); onApproveGetAvailableDays();">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <option  value='1'>Approve</option>
                                        <option  value='2'>Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary"name="save" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>hr/vacation" class="btn btn-danger" type="button">Cancel</a>
                                </div>
                            </div>
                            
                        </form> 
                    </div>
                </div> 
            </section>
        </div>
    </div> 



   <script type="text/javascript"> 
 window.onload = function() {
   var type_of_vacation = $("#type_of_vacation_").val();
        if(type_of_vacation == 3){
            $("#medical_document").show();
        }
    
  };
</script>
    

    