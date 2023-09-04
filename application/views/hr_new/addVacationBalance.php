<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New Employee </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" onsubmit="return disableAddButton();" id="form"action="<?php echo base_url()?>hr/doAddVacationBalance" method="post" enctype="multipart/form-data">
				 <div class="card-body">

						
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Select Employee Name:</label>

                            <div class="col-lg-6">
                                <select name="employee" class="form-control" id="employee" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->hr_model->selectEmployeeForVT(0); ?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Balance:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="current_year" />
								
							</div>
						</div>
						 
					<!--	<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Double Days Balance:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="double_days" />
								
							</div>
						</div>-->
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Sick Leave:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="sick_leave" />
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Marriage:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="marriage" />
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Maternity Leave:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="maternity_leave" />
								
							</div>
						</div>
						

					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/vacationBalance" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>