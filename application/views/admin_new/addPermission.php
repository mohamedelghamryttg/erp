<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Permission</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>admin/doAddPermission" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Screen</label>
							<div class="col-lg-6">
								<select name="screen" class="form-control" id="screen" required="">
                                    <option></option>
                                    <?=$this->admin_model->selectScreen()?>
                                </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Role</label>
							<div class="col-lg-6">
								<select name="role" class="form-control" id="role" required="">
                                    <option></option>
                                    <?=$this->admin_model->selectRole()?>
                                </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Follow-Up</label>
							<div class="col-lg-6">
								<select name="follow" class="form-control" id="follow" required="">
                                    <option value="0"></option>
                                    <?=$this->admin_model->selectFollowUp()?>
                                </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">View</label>
							<div class="col-lg-6">
								<select name="view" class="form-control" id="view" required="">
                                    <option></option>
                                    <option value="2">View only assigned</option>
                                    <option value="1">View ALL</option>
                                </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Can Add</label>
							<div class="col-lg-6">
								<select name="add" class="form-control" id="add" required="">
                                    <option></option>
                                  <option value="1">Yes</option>
                                 <option value="0">No</option>
                                </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Can Edit</label>
							<div class="col-lg-6">
								<select name="edit" class="form-control" id="edit" required="">
                                    <option></option>
	                                 <option value="1">Yes</option>
	                                 <option value="0">No</option>
                                </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Can Delete</label>
							<div class="col-lg-6">
								<select name="delete" class="form-control" id="delete" required="">
                                    <option></option>
	                                 <option value="1">Yes</option>
	                                 <option value="0">No</option>
                                </select>
								
							</div>
						</div>
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>admin/permission" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>