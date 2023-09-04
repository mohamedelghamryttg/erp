<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New User</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>admin/doAddUser" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">First Name</label>
							<div class="col-lg-6">
								<input name="first_name" id="first_name" class="form-control" data-maxlength="300" required/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Last Name</label>
							<div class="col-lg-6">
								<input name="last_name" id="last_name" class="form-control" data-maxlength="300" required/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Username</label>
							<div class="col-lg-6">
								<input name="user_name" id="user_name" class="form-control" data-maxlength="300" required/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Abbreviations</label>
							<div class="col-lg-6">
								<input name="abbreviations" id="abbreviations" class="form-control" data-maxlength="3">
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email</label>
							<div class="col-lg-6">
								<input name="email" id="email" placeholder="E-mail" class="form-control" required/>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Password</label>
							<div class="col-lg-6">
								<input type="password" name="password" id="password" placeholder="Password" class="form-control" required/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Role</label>
							<div class="col-lg-6">
								 <select name="role" class="form-control m-b" id="role">
                                        <option></option>
                                        <?=$this->admin_model->selectRole()?>
                                    </select>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Employee Name</label>
							<div class="col-lg-6">
								 <select name="employees" class="form-control m-b" id="employees">
                                        <option></option>
                                        <?=$this->admin_model->selectEmployees()?>
                                    </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">phone</label>
							<div class="col-lg-6">
								<input type="number" name="phone" id="phone" required="" data-maxlength="15" class="form-control"/>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Brand</label>
							<div class="col-lg-6">
								<select name="brand" class="form-control m-b" id="brand">
                                     <option></option>
                                     <?=$this->admin_model->selectBrand()?>
                                    </select>
							</div>
						</div>

						

					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>admin/users" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>