<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Social Insurance </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doEditSocialInsurance" method="post" enctype="multipart/form-data">
				 <div class="card-body">
						 <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                         <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>socialInsurance" hidden>
                    <?php } ?>

                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Select Employee Name:</label>

                            <div class="col-lg-6">
                                <select name='employee' id="employee"class='form-control'value="" onchange="getGenderAndDateOfBirth();" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                     <option value="<?= $row->employee_id?>"  selected=''><?= $this->db->query("SELECT name FROM employees WHERE id = '$row->employee_id'")->row()->name;?></option>
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
                             <input class="datepicker form-control" value="<?=$row->activation_date ?>"name="activation_date"type="text" id="activation_date"autocomplete="off" >
                        </div>
                </div> 
                  <div class="form-group row">
                       <label class="col-lg-3 col-form-label text-right" for="role date">Deactivation Date </label>

                        <div class="col-lg-6">
                             <input class="datepicker form-control"name="deactivation_date"type="text" value="<?=$row->deactivation_date ?>" autocomplete="off">
                        </div>
                </div>  
                <div class="form-group row"> 
                       <label class="col-lg-3 col-form-label text-right" for="role date">Basic</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="basic"type="text" value="<?=$row->basic ?>" onblur="calculateTotalDeduction();" id="basic"autocomplete="off" >
                        </div>
                </div> 
                <div class="form-group row"> 
                       <label class="col-lg-3 col-form-label text-right" for="role date"> Variable</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control" value="<?=$row->variable ?>"onblur="calculateTotalDeduction();" name="variable"type="text" id="variable"autocomplete="off" >
                        </div>
                </div>  
                <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="type">Year</label>

                                <div class="col-lg-6">
                                    <select name="year" class="form-control" id="year" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectYear($row->year)?>
                                    </select>
                                </div>
                            </div>
					  <div class="form-group row ">
                       <label class="col-lg-3 col-form-label text-right" for="role date">Insurance Number</label>

                        <div class="col-lg-5">
                             <input class=" form-control" name="1" value="<?=$insurance_number[0]?>" type="text" style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="2"value="<?=$insurance_number[1]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="3" value="<?=$insurance_number[2]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="4" value="<?=$insurance_number[3]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="5"value="<?=$insurance_number[4]?>" type="text" style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="6"value="<?=$insurance_number[5]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="7"value="<?=$insurance_number[6]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="8" value="<?=$insurance_number[7]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                             <input class=" form-control" name="9"value="<?=$insurance_number[8]?>" type="text"style="width: 50px; float: left;" maxlength="1" required="">
                        </div>
                </div>          
                <div class ="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Currency</label>
                                <div class='col-lg-6'>
                                    <select name='currency'class='form-control'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectCurrency($row->currency); ?>
                                    </select>
                                </div>
                 </div>    
                 <div class="form-group row ">
                                <label class="col-lg-3 col-form-label text-right" for="Country">Country</label>
                                <div class="col-lg-6">
                                    <select name="country" class="form-control "  required />
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectAllCountries($row->country); ?>
                                    </select>
                                </div>
                  </div>            
                  <div class="form-group row "> 
                       <label class="col-lg-3 col-form-label text-right" for="role date">Total Deductions</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="total_deductions" value="<?= $row->total_deductions ?>" id="total_deductions" type="text" readonly="" autocomplete="off" >
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