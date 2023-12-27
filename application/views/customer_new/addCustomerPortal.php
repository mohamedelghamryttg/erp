<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
	tinymce.init({
		selector: 'textarea'
	});
</script>
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Customer Portal</h3>

			</div>
			<!--begin::Form-->
			<form class="form" id="myForm" method="post" enctype="multipart/form-data">
				<div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Link</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" name="link" data-maxlength="300" id="link">

						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Portal Name</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" name="portal" data-maxlength="300" id="portal">

						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">User Name</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" name="username" data-maxlength="300" id="username">

						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Password</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" name="password" data-maxlength="300" id="password">

						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Additional Information</label>
						<div class="col-lg-6">
							<textarea name="additional_info" class="form-control" rows="6"></textarea>

						</div>
					</div>
					<?php if ($role != 19) { ?>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Customer Profile</label>
							<div class="col-lg-6">
								<input type="file" class=" form-control" name="customer_profile" accept=".zip,.rar,.7zip">

							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Customer Profile Notes</label>
							<div class="col-lg-6">
								<textarea name="notes" class="form-control" rows="7"></textarea>

							</div>
						</div>
					<?php } ?>
				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button id="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>customer/customerPortal?t=<?= base64_encode($id) ?>" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#myForm").submit(function(e) {
			e.preventDefault();
			$('#submit').disabled = true;
			var url = "<?php echo base_url() ?>customer/doAddCustomerPortal?t=<?= base64_encode($id) ?>";
			var postdata = this;
			$.ajax({
				method: 'POST',
				url: url,
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					if (result === "success") {
						location.href = "<?php echo base_url() ?>customer/customerPortal?t=<?= base64_encode($id) ?>";
					} else {
						alert(result);
						$('#submit').disabled = false;
					}
				},
				error: function() {

				}
			});
		});
	});
</script>