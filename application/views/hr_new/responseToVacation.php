<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Response Vacation Request </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" onsubmit="return responseVactionRequest(); "  id="form"action="<?php echo base_url()?>hr/doUpdateVacationStatus" method="post" name="addVacatin" enctype="multipart/form-data">
				 <div class="card-body">
                     <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                     <input type="text" name="return" id="return" hidden="" value="1" >
                     <input type="text" name="return_available_days" id="return_available_days" hidden="" value="1" >
						
                    <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right'>Name</label>
                                <div class='col-lg-6'>
                                <input type="text" class=" form-control" name="emp_id"  data-maxlength="300" value="<?=$this->hr_model->getEmployee($row->emp_id)?>" placeholder="Name" readonly>
                                <input type="text" class=" form-control"id="emp_id_" name="emp_id_"  data-maxlength="300" value="<?=$row->emp_id?>" placeholder="Name" hidden readonly>
                                </div>
                            </div>
                           <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Type Of Vacation</label>
                                <div class='col-lg-6'>
                                <input type="text" class=" form-control" name="type_of_vacation" id="type_of_vacation" data-maxlength="300" value="<?=$this->hr_model->getAllVacationTypies($row->type_of_vacation)?>" placeholder="Type Of Vacation" readonly>
                                <input type="text" class=" form-control" name="type_of_vacation_" id="type_of_vacation_" data-maxlength="300" value="<?=$row->type_of_vacation?>" placeholder="Type Of Vacation" hidden readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Start</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control datepicker" value="<?=$row->start_date?>" name="start_date"  id="start_date" data-maxlength="300"  placeholder="Number Of Days" required=""readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >End</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control datepicker"value="<?=$row->end_date?>" name="end_date" onblur="checkVacationCredite();" id="end_date" data-maxlength="300"  placeholder="Number Of Days" required=""readonly>
                                </div>
                            </div>
                             <div class="form-group row" id="medical_document" style="display: none;">
                                <label class="col-lg-3 col-form-label text-right" >Medical Document</label>

                                <div class="col-lg-6">
                                    <?php if(strlen($row->sick_leave_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/sickLeaveDocument/<?=$row->sick_leave_file?>" target="_blank">Download Document</a><?php } ?>
                                </div>
                            </div>

                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Status</label>
                                <div class='col-lg-6'>
                                    <select name='status'class='form-control 'id="status" value="<?=$row->status?>" required="" onchange="onApprove(); onApproveGetAvailableDays();">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <option  value='1'>Approve</option>
                                        <option  value='2'>Reject</option>
                                    </select>
                                </div>
                            </div>
						
						
						
						

					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/vacation" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
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