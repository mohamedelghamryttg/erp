<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New Structure </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doAddStructure" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				 <div class="card-body">

						
                      

                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Title:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="title" required="" />
								
							</div>
						</div>
						
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Division:</label>

                            <div class="col-lg-6">
                                <select name="division" onchange="getDepartment()" class="form-control" id="division" required="">
                                    <option></option>
                                        <?=$this->hr_model->selectDivision()?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Department:</label>

                            <div class="col-lg-6">
                                <select name="department" class="form-control" id="department" required="">
                                    <option disabled="disabled" selected=""></option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Track:</label>

                            <div class="col-lg-6">
                                <select name="track" class="form-control" id="track" required="">
                                      <option disabled="" selected="selected">-- Select Track --</option>
                                        <?=$this->hr_model->selectTrack()?>                              
                                </select>
                            </div>
                        </div> 
						
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Parent:</label>

                            <div class="col-lg-6">
                                <select name="parent" class="form-control" id="parent" required="">
                                     <option  selected="selected" value="">N/A</option>
                                        <?=$this->hr_model->selectTitle()?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Grand Parent:</label>

                            <div class="col-lg-6">
                                <select name="grand_parent" class="form-control" id="grand_parent" required="">
                                      <option  selected="selected" value="">N/A</option>
                                        <?=$this->hr_model->selectTitle()?>                              
                                </select>
                            </div>
                        </div> 


					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/structure" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>