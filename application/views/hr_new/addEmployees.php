<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New Employee </h3> 
			</div>
<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doAddEmployees" onsubmit="retunr disableAddButton();" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                   
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Employee Data</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Positioning Data</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Communcation Info</a>
                            </li>
                        </ul>




                         <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show in" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <br>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Name">Name</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="name" data-maxlength="300" id="name" required="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Birth Date">Date of Birth</label>

                                    <div class="col-lg-6">
                                       <input size="16" type="text" class="form-control date_sheet"  name="birth_date" id="birth_date" required="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Gender">Gender</label>

                                    <div class="col-lg-6">
                                        <select name="gender" class="form-control" id="gender" required="">
                                            <option disabled="disabled" selected="selected">-- Select Gender --</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="National ID">National ID/Passport ID</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="national_id" id="national_id" required=""> 
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <br>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="Division">Division</label>

                                <div class="col-lg-6">
                                    <select name="division" onchange="getDepartment()" class="form-control" id="division" required="">
                                        <option disabled="disabled" selected="" value=""> -- Select Division --</option>
                                        <?=$this->hr_model->selectDivision()?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="Function">Function</label>

                                <div class="col-lg-6">
                                    <select name="department" onchange="getTitle()" class="form-control" id="department" required />
                                        <option></option>
                                        <?=$this->hr_model->selectDepartment()?> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="Position">Position</label>

                                <div class="col-lg-6">
                                    <select name="title" onchange="getTitleData();getDirectManagerByTitle();" class="form-control" id="title" required />
                                            <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="data"></label>
                                <div class="col-lg-6" id="titleData"></div>
                            </div>
                    
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="Direct Manager">Direct Manager</label>

                                <div class="col-lg-6">
                                    <select name="manager" class="form-control" id="manager">
                                            <option disabled="disabled" selected="">-- Select Manager --</option>
                                    </select>
                                </div>
                            </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Time Zone">Time Zone</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="time_zone" data-maxlength="300" id="time_zone" required="" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Office Location">Office Location</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="office_location" data-maxlength="300" id="office_location" required="" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right"> Hiring Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="form-control date_sheet"  name="hiring_date" id="hiring_date" required="">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right"> Probationay Period</label>
                                    <div class="col-lg-6">
                                       <input type="text" class=" form-control" name="prob_period" data-maxlength="300" id="prob_period" readonly="" >
                                        
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right"> Contract Date</label>
                                    <div class="col-lg-6">
                                       <input size="16" type="text" class="form-control date_sheet"  name="contract_date" id="contract_date" >
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Contract Type">Contract Type</label>

                                    <div class="col-lg-6">
                                        <select name="contract_type" class="form-control" id="contract_type" required="">
                                            <option disabled="disabled" selected="selected">-- Select Contract Type --</option>
                                            <option value="1">Full Time</option>
                                            <option value="2">Part Time</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Employee Status">Employee Status</label>

                                    <div class="col-lg-6">
                                        <select name="status" class="form-control" onchange="employeeStatus()" id="status" required="">
                                            <option disabled="disabled" selected="selected">-- Select Employee Status --</option>
                                            <option value="0">Working</option>
                                            <option value="1">Resigned</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="form-group row" id="employeeResignation">
                                    <label class="col-lg-3 col-form-label text-right">Resignation Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="form-control date_sheet"  name="resignation_date" id="resignation_date" required="">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Email">Email</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="email" data-maxlength="300" id="email" required="" >
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Phone Number">Phone Number</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="phone" data-maxlength="300" id="phone" required="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="Emergency Contact">Emergency Contact</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="emergency" data-maxlength="300" id="emergency">
                                    </div>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <div class="col-lg-offset-3 col-lg-6">
                                        <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>hr/employees" class="btn btn-default" type="button">Cancel</a>
                                    </div>
                                </div>
                        </div>



                 </div>
                 <!-- end card body -->
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>