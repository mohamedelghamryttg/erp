<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add Social Insurance
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddSocialInsurance" method="post" enctype="multipart/form-data">
            <div class='form-group'>
                    <label class='col-lg-3 control-label' for='inputPassword'>Select Employee Name</label>
                    <div class='col-lg-6'>
                        <select name='employee' id="employee"class='form-control m-b'value="" onchange="getGenderAndDateOfBirth();" required="">
                            <option value="" disabled='' selected=''>-- Select --</option>
                            <?=$this->hr_model->selectEmployeeForSocialInsurance(0); ?>
                        </select>
                    </div>
                </div>
            	<div class="form-group"> 
                       <label class="col-lg-3 control-label" for="role date">Gender</label>

                        <div class="col-lg-6">
                             <input size="16" class=" form-control"name="gender"type="text" id="gender"autocomplete="off" readonly="">
                        </div>
                </div> 
                <div class="form-group"> 
                       <label class="col-lg-3 control-label" for="role date">Date OF Birth</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="dateOfBirth"type="text" id="dateOfBirth"autocomplete="off" readonly="">
                        </div>
                </div> 
              
                <div class="form-group"> 
                       <label class="col-lg-3 control-label" for="role date">Activation Date</label>

                        <div class="col-lg-6">
                             <input size="16" class="datepicker form-control"name="activation_date"type="text" id="activation_date"autocomplete="off" >
                        </div>
                </div> 
                  <div class="form-group">
                       <label class="col-lg-3 control-label" for="role date">Deactivation Date </label>

                        <div class="col-lg-5">
                            <input size="16" class="datepicker form-control"name="deactivation_date" id="deactivation_date"type="text" autocomplete="off">
                            
                        </div>
                        <div class="col-lg-1">
                            <a class="clearDate btn btn-sm btn-dark text-white"><i class="fa fa-times pr-1"></i>Clear</a>
                        </div>
                </div>  
                <div class="form-group"> 
                       <label class="col-lg-3 control-label" for="role date">Basic</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="basic"type="text" onblur="calculateTotalDeduction();" id="basic"autocomplete="off" >
                        </div>
                </div> 
                <div class="form-group"> 
                       <label class="col-lg-3 control-label" for="role date"> Variable</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control" onblur="calculateTotalDeduction();" name="variable"type="text" id="variable"autocomplete="off" >
                        </div>
                </div>  
                <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Year</label>

                                <div class="col-lg-6">
                                    <select name="year" class="form-control m-b" id="year" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectYear()?>
                                    </select>
                                </div>
                            </div>
                <div class="form-group">
                       <label class="col-lg-3 control-label" for="role date">Insurance Number</label>

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
                <div class='form-group'>
                                <label class='col-lg-3 control-label'>Currency</label>
                                <div class='col-lg-6'>
                                    <select name='currency'class='form-control m-b'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectCurrency(0); ?>
                                    </select>
                                </div>
                 </div>    
                 <div class="form-group">
                                <label class="col-lg-3 control-label" for="Country">Country</label>
                                <div class="col-lg-6">
                                    <select name="country" class="form-control m-b"  required />
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectAllCountries(0); ?>
                                    </select>
                                </div>
                  </div>            
                  <div class="form-group"> 
                       <label class="col-lg-3 control-label" for="role date">Total Deductions</label>

                        <div class="col-lg-6">
                             <input size="16" class="form-control"name="total_deductions" id="total_deductions" type="text" readonly="" autocomplete="off" >
                        </div>
                </div> 
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-6">
                        <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/socialInsurance" class="btn btn-default" type="button">Cancel</a>
                    </div>
                </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
     <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
            $('.clearDate').on('click', function(){            
                $('#deactivation_date').val('');               
            });
            
        });
    </script>