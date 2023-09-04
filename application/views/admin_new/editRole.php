<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Role</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>admin/doEditRole" method="post"
				enctype="multipart/form-data">
				<div class="card-body">
					<input type="hidden" class=" form-control" value="<?= base64_encode($role->id); ?>" name="id">
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Role</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $role->name ?>" name="name" required>

						</div>
					</div>

				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>admin/role"
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