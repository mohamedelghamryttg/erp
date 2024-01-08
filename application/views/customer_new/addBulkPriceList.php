<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Bulk Data</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>customer/doAddBulkPriceList" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Upload Excel Sheet</label>
							<div class="col-lg-6">
								<input type="file" class=" form-control" name="file" required>
								
							</div>
						</div>
						
						<div class="form-group row mt-5">
                                                    <label class="col-lg-3 col-form-label text-dark-50">File Simple</label>
                                                   <div class="col-lg-12">
                                                   <img alt="Logo" src="<?php echo base_url(); ?>assets/images/pricelistbulk.png" class="logo-default max-w-100" />
						</div>
						</div>
						
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>customer/priceList" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>