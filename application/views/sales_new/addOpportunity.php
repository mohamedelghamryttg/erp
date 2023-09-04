<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Opportunity</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>sales/doAddOpportunity"
				onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" name="project_name" id="project_name" required>

						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Customer</label>
						<div class="col-lg-6">
							<select name="customer" class="form-control m-b" id="customer" onchange="CustomerData()"
								required>
								<option value="" selected="selected">-- Select Customer --</option>
								<?= $this->customer_model->selectCustomerBySam(0, $this->user, $permission, $this->brand) ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right"></label>
						<div class="col-lg-6" id="LeadData">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Contact Method</label>
						<div class="col-lg-6">
							<select name="contact_method" class="form-control m-b" id="contact_method"
								onchange="getContacts()" required>
								<option value="" selected="selected">-- Contact Method --</option>
								<?= $this->sales_model->selectContactMethod() ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right"></label>
						<div class="col-lg-6" style="overflow-x: auto;height: 200px;" id="customerContact">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Status Of Project</label>
						<div class="col-lg-6">
							<select name="project_status" class="form-control m-b" onchange="getProductLineByLead()"
								id="project_status" required>
								<option value="" selected="selected">-- Status Of Project --</option>
								<?= $this->sales_model->SelectProjectStatus() ?>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Product Line</label>
						<div class="col-lg-6">
							<select name="product_line" class="form-control m-b" id="product_line"
								onchange="getAssignedPM();" required>
								<option disabled="disabled" selected="selected">-- Select Product Line --</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Assign PM</label>
						<div class="col-lg-6">
							<select name="pm" class="form-control m-b" id="pm" required>
								<option disabled="disabled" selected="selected">-- Select PM --</option>
							</select>
						</div>
					</div>
					<?php if ($this->brand == 1) { ?>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">TTG Branch Name </label>
							<div class="col-lg-6">
								<select name="branch_name" class="form-control m-b">
									<option disabled="disabled" selected="selected">-- Select Branch Name --</option>
									<?= $this->projects_model->selectTTGBranchName() ?>
								</select>
							</div>
						</div>
					<?php } ?>
				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>sales/opportunity"
								class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>