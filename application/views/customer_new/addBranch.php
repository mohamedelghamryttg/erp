<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Branch</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>customer/doAddBranch" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Customer</label>
							<div class="col-lg-6">
								<select name="customer" class="form-control m-b" id="customer" required />
                                             <option disabled="disabled" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerExisting(0,$brand)?>
                                    </select>
								
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
							<label class="col-lg-3 col-form-label text-right">Type</label>
							<div class="col-lg-6">
								<select name="type" class="form-control m-b" id="type" required />
                                             <option disabled="disabled" selected="selected">-- Select Type --</option>
                                             <?=$this->customer_model->selectType()?>
                                    </select>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Source</label>
							<div class="col-lg-6">
								<select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source --</option>
                                             <?=$this->customer_model->selectSource()?>
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
							<a class="btn btn-secondary" href="<?php echo base_url()?>customer/customerBranch" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>