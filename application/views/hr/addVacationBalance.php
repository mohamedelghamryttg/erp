<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Employee
			</header>
			
			<div class="panel-body">
				<div class="form">
			<form class="cmxform form-horizontal " onsubmit="return disableAddButton();" id="form"action="<?php echo base_url()?>hr/doAddVacationBalance" method="post" enctype="multipart/form-data">
                           <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Select Employee Name</label>
                                <div class='col-lg-6'>
                                    <select name='employee'class='form-control m-b'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->hr_model->selectEmployeeForVT(0); ?>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" >Balance</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="" name="current_year"  data-maxlength="300" required>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Double Days Balance</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="" name="double_days"  data-maxlength="300" required>
                                </div>
                            </div> 
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Sick Leave</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="" name="sick_leave"  data-maxlength="300" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Marriage</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="" name="marriage"  data-maxlength="300" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Maternity Leave</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="" name="maternity_leave"  data-maxlength="300" required>
                                </div>
                            </div>
                          
                           
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>hr/vacationBalance" class="btn btn-danger" type="button">Cancel</a>
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
        });
    </script>