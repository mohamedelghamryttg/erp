<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Service</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>admin/doEditService" method="post"
				enctype="multipart/form-data">
				<div class="card-body">

					<input type="text" name="id" value="<?= base64_encode($services->id) ?>" hidden="">
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Service</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $services->name ?>" name="name"
								required>

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Abbreviations</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" data-maxlength="3"
								value="<?= $services->abbreviations ?>" name="abbreviations" id="abbreviations">

						</div>
					</div>
				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>admin/services"
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