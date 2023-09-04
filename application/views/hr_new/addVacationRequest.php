<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
    <!--begin::Card-->
        <div class="card card-custom example example-compact" >
            <div class="card-header">
                <h3 class="card-title">Select Vacation Type</h3>
            </div>
              <div class="card-body">
                 <div class='form-group row' >
                        <label class='col-lg-3 col-form-label text-right' >Day Type</label>
                        <div class='col-lg-6'>
                            <select name='day_type'class='form-control' onchange="view();" id="day_type">
                                <option value="" selected=''>-- Select --</option>
                                <option value="0" >Full Day</option>
                                 <option value="1" >Half Day</option>
                            </select>
                        </div> 
                    </div>
                </div>
        </div>
        <!--end::Card-->
      <!--begin::Card-->
		<div class="card card-custom example example-compact" id="full_day" style="display: none;">
			<div class="card-header">
				<h3 class="card-title"> Add Vacation Request </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" id="form"action="<?php echo base_url()?>hr/doAddVacationRequest" method="post" onsubmit="return onAddVacationRequest();"name="addVacatin" enctype="multipart/form-data">
				 <div class="card-body">

						<div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Type Of Vacation</label>
                                <div class='col-lg-6'>
                                    <select name='type_of_vacation'class='form-control 'id="type_of_vacation" onchange="calculateAvailableVacationDays(0);"value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                       <?= $this->hr_model->selectAllVacationTypies() ?>
                                    </select>
                                </div> 
                            </div> 
                             <div class='form-group row'id="relative_degree_div" style="display: none;">
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Relative Degree</label>
                                <div class='col-lg-6'>
                                    <select name='relative_degree'class='form-control'id="relative_degree" onchange="calculateAvailableVacationDays();">
                                        <option value="" selected=''>-- Select --</option>
                                        <option value="1" >First</option>
                                         <option value="2" >Second</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Available Days</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control"value =" " name="available_days" id="available_days" data-maxlength="300"  placeholder="Available days" readonly>
                                    <input type="text" class="form-control" value =" " name="availableDays" id="availableDays" data-maxlength="300" placeholder="Available days" hidden="">
                                </div>
                            </div>
                            <div class="form-group row" id="requested_days_div" >
                                <label class="col-lg-3 col-form-label text-right" >Requested Days</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control"  value =" " name="requested_days" id="requested_days" data-maxlength="300"  placeholder="Requested days" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Start</label>

                                <div class="col-lg-6">
                                    <input type="text" class="form-control date_sheet" name="start_date" autocomplete="off" onblur="onBlur();" id="start_date" data-maxlength="300" placeholder="Start Date" required="">
                                </div>
                            </div>  
                            <div class="form-group row" id="end_date_div">
                                <label class="col-lg-3 col-form-label text-right" >End</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control date_sheet" name="end_date"autocomplete="off" onblur="onBlur()" id="end_date" data-maxlength="300"  placeholder="End Date" required="">
                                    <input style="display: none;" type="text" class=" form-control"  value =" " name="show_end_date" id="show_end_date" data-maxlength="300"  placeholder="End Date" readonly>
                                   
                                </div>
                            </div>
                           <div class="form-group row" id="sick_leave_file" style="display: none;">
                                <label class="col-lg-3 col-form-label text-right" >Sick Leave Document</label>

                                <div class="col-lg-6">
                                    
                                     <input type="file" id="file"name="file" > 
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


         <!--begin::Card-->
        <div class="card card-custom example example-compact" id="half_day"style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Request Half Day</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>hr/doHalfDay" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                <div class="card-body">
                     <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Select Date</label>

                                <div class="col-lg-6">
                                    <input type="text" class="form-control date_sheet" name="half_day_date" autocomplete="off"  id="half_day_date" data-maxlength="300" placeholder="Start Date">
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
    function view (){
        var day_type =  $("#day_type").val();
        if(day_type == 0){
             $("#full_day").show();
             $('#half_day').hide();
        }else if(day_type == 1){
            $('#half_day').show();
            $("#full_day").hide();
        }
    }
</script>