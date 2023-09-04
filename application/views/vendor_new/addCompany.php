<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Company</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>vendor/doAddCompany" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Company Name</label>
							<div class="col-lg-6">
                               <input name="name" id="name" class="form-control" required>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email</label>
							<div class="col-lg-6">
                               <input type="text" class=" form-control" name="email" data-maxlength="300" id="email" required>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Region</label>
							<div class="col-lg-6">
								 <select name="region" class="form-control m-b" id="region" onchange="getCountries()" required />
                                             <option disabled="disabled" selected="selected">-- Select Region --</option>
                                             <?=$this->admin_model->selectRegion()?>
                                    </select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Country</label>
							<div class="col-lg-6">
								<select name="country" class="form-control m-b" id="country" required />
                                             <option disabled="disabled" selected="selected">-- Select Country --</option>
                                    </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Comment</label>
							<div class="col-lg-6">
								<textarea name="comment" class="form-control" value="" rows="6"></textarea>
								
							</div>
						</div>
						
						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>vendor/companies" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>