<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add Social Insurance </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doAddSocialInsurance" method="post" enctype="multipart/form-data">
				 <div class="card-body">

						
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Select Employee Name:</label>

                            <div class="col-lg-6">
                                <select name='employee' id="employee"class='form-control'value="" onchange="getGenderAndDateOfBirth();" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?=$this->hr_model->selectEmployeeForSocialInsurance(0); ?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Gender:</label>
							<div class="col-lg-6">
								<input class="form-control" name="gender"type="text" id="gender"autocomplete="off" readonly="" />
								
							</div>
						</div>
						 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Date OF Birth:</label>
							<div class="col-lg-6">
								<input class="form-control" name="dateOfBirth"type="text" id="dateOfBirth"autocomplete="off" readonly="" />
								
							</div>
						</div>
						 <div class="form-group row"> 
                       <label class="col-lg-3 col-form-label text-right" for="role date">Activation Date</label>

                        <div class="col-lg-6">
                             <input class="datepicker form-control"name="activation_date"type="text" id="activation_date"autocomplete="off" >
                        </div>
                </div> 
                  <div class="form-group row">
                       <label class="col-lg-3 col-form-label text-right" for="role date">Deactivation Date </label>

                        <div class="col-lg-6">
                             <input class="datepicker form-control"name="deactivation_date"type="text" autocomplete="off">
                        </div>
                </div>  
                <div class="form-group row"> 
                       <label class="col-lg-3 col-form-label text-right" for="role date">Basic</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="basic"type="text" onblur="calculateTotalDeduction();" id="basic"autocomplete="off" >
                        </div>
                </div> 
                <div class="form-group row"> 
                       <label class="col-lg-3 col-form-label text-right" for="role date"> Variable</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control" onblur="calculateTotalDeduction();" name="variable"type="text" id="variable"autocomplete="off" >
                        </div>
                </div>  
                <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="type">Year</label>

                                <div class="col-lg-6">
                                    <select name="year" class="form-control" id="year" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectYear()?>
                                    </select>
                                </div>
                            </div>
					  <div class="form-group row ">
                       <label class="col-lg-3 col-form-label text-right" for="role date">Insurance Number</label>

                        <div class="col-lg-5">
                             <input class=" form-control" name="1" type="text" style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="2" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="3" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="4" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="5" type="text" style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="6" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="7" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="8" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="9" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                        </div>
                </div>          
                <div class ="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Currency</label>
                                <div class='col-lg-6'>
                                    <select name='currency'class='form-control'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectCurrency(0); ?>
                                    </select>
                                </div>
                 </div>    
                 <div class="form-group row ">
                                <label class="col-lg-3 col-form-label text-right" for="Country">Country</label>
                                <div class="col-lg-6">
                                    <select name="country" class="form-control "  required />
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectAllCountries(0); ?>
                                    </select>
                                </div>
                  </div>            
                  <div class="form-group row "> 
                       <label class="col-lg-3 col-form-label text-right" for="role date">Total Deductions</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="total_deductions" id="total_deductions" type="text" readonly="" autocomplete="off" >
                        </div>
                </div> 

					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary"  href="<?php echo base_url()?>hr/socialInsurance" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>