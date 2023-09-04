<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New Medical Insurance </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doAddMedicalInsurance" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Employee Name:</label>

                            <div class="col-lg-6">
                                <select name="employee_id" class="form-control" id="employee_id" required="">
                                          <option></option>
                                          <?=$this->hr_model->selectEmployee()?>
                                </select>
                            </div>
                        </div> 
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Year:</label>

                            <div class="col-lg-6">
                                <select name="year" class="form-control" id="year" required="">
                                          <option></option>
                                        <?=$this->hr_model->selectYear()?>
                                </select>
                            </div>
                        </div> 
                    <div id="familyMembers" > 
	                       <div class="form-group row">
								<label class="col-lg-3 col-form-label text-right">CRT:</label>
								<div class="col-lg-1">
									<input type="number" class=" form-control" name="crt" id="crt" required="" />
									
								</div>
								<label class="col-lg-2 col-form-label text-right">Activation date:</label>
								<div class="col-lg-3">
									<input type="text" class="form-control date_sheet" autocomplete="off" name="activation_date" id="activation_date" required="" />
									
								</div>
							</div>
                         <div class="form-group row">
	                            <label class="col-lg-3 col-form-label text-right">Detect from Salary:</label>

	                            <div class="col-lg-6">
	                                <select name="deduction" class="form-control" id="deduction" required="">
                                        			<option value="1">Yes</option>
                                        			<option value="2">No</option>
                                    </select>
	                            </div>
                         </div> 
                         <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Family Members Num:</label>
							<div class="col-lg-6">
								<input type="number" value="0" onchange="addFamilyMember()" class=" form-control" name="members" data-maxlength="300" id="members" required="">
								
							</div>
						</div>

                    </div>

                                <div id="familyMembersData">
                                    
                                </div> 


                

					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/medicalInsurance" class="btn btn-default" type="button">Cancel</a>
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
        function viewFamilyMembers(){
            var insured = $("#insured").val();
            if(insured == 1){
                $("#familyMembers").show();
            }else if(insured == 2){
                $("#familyMembers").hide();
            }
        }
    
        function addFamilyMember(){
            var members = $("#members").val();
            $("#familyMembersData").html("");
            for(var i=1;i<=members;i++){
                $("#familyMembersData").append(`
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Member `+i+`:">Member `+i+`:</label>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Name">Name:</label>

                    <div class="col-lg-6">
                        <input type="text" class=" form-control" name="name_`+i+`" id="name_`+i+`" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Date Of Birth">Date Of Birth:</label>

                    <div class="col-lg-6">
                        <input type="text" class="form-control date_sheet" autocomplete="off" name="birth_date_`+i+`" id="birth_date_`+i+`" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Activation Date">Activation Date:</label>

                    <div class="col-lg-2">
                        <input type="text" class="form-control date_sheet" autocomplete="off" name="activation_date_`+i+`" id="activation_date_`+i+`" required="">
                    </div>
                    
                    <label class="col-lg-2 col-form-label text-right" for="Type">Type:</label>
                    <div class="col-lg-2">
                        <select name="type_`+i+`" class="form-control" id="type_`+i+`" required="">
                            <option disabled="disabled" selected="selected">Select Contract Type</option>
                            <option value="1">Supose</option>
                            <option value="2">Child</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Annual Fees">Annual Fees:</label>

                    <div class="col-lg-6">
                        <input type="number" class=" form-control" name="fees_`+i+`" id="fees_`+i+`" required="">
                    </div>
                </div>
            `);
            }
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        }
    </script>