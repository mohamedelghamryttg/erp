<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:"#content" });</script>
<script>tinymce.init({ selector:"#feedback" });</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Feedback</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>projects/doAddCustomerFeedback" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Customer Email</label>
							<div class="col-lg-6">
								<textarea name="emails"style="width: 700px"></textarea>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Feedback</label>
							<div class="col-lg-6">
								<textarea name="feedback" id="content"></textarea>
								
							</div>
						</div>

					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>projects/customerFeedback" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>