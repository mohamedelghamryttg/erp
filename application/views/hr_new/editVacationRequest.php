<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Vacation Request</h3>
				
			</div>
			<div></div>
			<!--begin::Form-->
			<form class="form"id="form"action="<?php echo base_url()?>hr/doEditVacationRequest" method="post"onsubmit="onAddVacationRequest()" name="editVacatin" enctype="multipart/form-data">
				 <div class="card-body">
                       <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                       <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right'>Type Of Vacation</label>
                                <div class='col-lg-6'>
                                    <select name='type_of_vacation'class='form-control'id="type_of_vacation" onchange="calculateAvailableVacationDays(1);"value="" required="">
                                    <?= $this->hr_model->selectAllVacationTypies($row->type_of_vacation) ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'id="relative_degree_div" style="display: none;">
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Relative Degree</label>
                                <div class='col-lg-6'>
                                    <select name='relative_degree'class='form-control'id="relative_degree" onchange="calculateAvailableVacationDays();"value="">
                                    <?php if($row->relative_degree == 1){ ?>
                                             <option value="" >-- Select --</option>
                                             <option value="1" selected="" >First</option>
                                             <option value="2" >Second</option>
                                   <?php }elseif ($row->relative_degree == 2) { ?>
                                             <option value="" >-- Select --</option>
                                             <option value="1" >First</option>
                                             <option value="2"selected="" >Second</option>
                                   <?php }else{ ?>
                                        <option value="" selected=''>-- Select --</option>
                                        <option value="1" >First</option>
                                         <option value="2" >Second</option>
                                   <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group row" id="available_days_div">
                                <label class="col-lg-3 col-form-label text-right" >Available Days</label>
                                 <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="available_days" value = "" id="available_days" data-maxlength="300" placeholder="Available days" readonly>
                                    <input type="text" class="form-control" value =" " name="availableDays" id="availableDays" data-maxlength="300" placeholder="Available days" hidden="">
                                </div>
                            </div>
                            <div class="form-group row" id="requested_days_div" >
                                <label class="col-lg-3 col-form-label text-right" >Requested Days</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control"  value ="<?= $row->requested_days?> " name="requested_days" id="requested_days" data-maxlength="300"  placeholder="Requested days" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Start</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control date_sheet" value="<?= $row->start_date?>" name="start_date"autocomplete="off" onblur="onBlur();showEndDate()" id="start_date" data-maxlength="300"  placeholder="Number Of Days" required="">
                                </div>
                            </div>
                            <div class="form-group row" id="end_date_div">
                                <label class="col-lg-3 col-form-label text-right" >End</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control date_sheet" value="<?= $row->end_date?>" name="end_date"autocomplete="off" onblur="onBlur()" id="end_date" data-maxlength="300"  placeholder="End Date" required="">

                                    <input style="display: none;" type="text"value="<?= $row->end_date?>" class=" form-control"  value =" " name="show_end_date" id="show_end_date" data-maxlength="300" readonly>
                                   
                                </div>
                            </div>
                            <div class="form-group row" id="sick_leave_file" style="display: none;">
                                <label class="col-lg-3 col-form-label text-right" >Sick Leave Document</label>

                                <div class="col-lg-6">
                                    
                                     <input type="file" id="file"name="file" value="<?=$row->sick_leave_file ?>" > 
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
    //hagar 6/3/2020
 window.onload = function() {
   var type_of_vacation = $("#type_of_vacation").val();
     if(type_of_vacation == 4 || type_of_vacation == 5 || type_of_vacation == 6 || type_of_vacation == 7){
             //$("#end_date_div").hide();
             $("#requested_days_div").hide();
             $("#end_date").removeAttr("required");
             
              if(type_of_vacation == 4){ 
                 $("#available_days").val("5");
               }
               if(type_of_vacation == 5){ 
                 $("#available_days").val("90");
               }
             if(type_of_vacation == 6){ 
                     if( $("#relative_degree").val() == 1){
                       $("#available_days").val("3");
                     }else if( $("#relative_degree").val() == 2){
                       $("#available_days").val("1");
                     }
                $("#relative_degree_div").show();
             }else{
                 $("#relative_degree_div").hide();
             } 
             if(type_of_vacation == 7){ 
                 $("#available_days").val("30");
               }
    }else{  
           calculateAvailableVacationDays(1);
             $("#end_date_div").show();
             $("#requested_days_div").show();
             $("#relative_degree_div").hide();
    }
  };
</script>