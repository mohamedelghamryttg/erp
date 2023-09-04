<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Customer Contacts</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>customer/doAddLeadContacts?t=<?=base64_encode($id)?>" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Name</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="name" data-maxlength="300" id="name" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="email" data-maxlength="300" id="email" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Phone</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="phone" data-maxlength="300" id="phone" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Skype Account</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="skype_account" data-maxlength="300" id="skype" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Job Title</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="job_title" data-maxlength="300" id="title" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Location</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="location" data-maxlength="300" id="title" required>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Comment</label>
							<div class="col-lg-6">
								<textarea name="comment" class="form-control" rows="6"></textarea>
								
							</div>
						</div>
						
						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>customer/leadContacts?t=<?=base64_encode($id)?>" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>