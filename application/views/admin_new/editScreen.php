<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Screen</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>admin/doEditScreen" method="post"
				enctype="multipart/form-data">

				<input type="text" name="id" value="<?= base64_encode($screens->id) ?>" hidden="">
				<div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Group</label>
						<div class="col-lg-6">
							<select name="groups" class="form-control" id="groups" required="">
								<option></option>
								<?= $this->admin_model->selectGroup($screens->groups) ?>
							</select>

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Name</label>
						<div class="col-lg-6">
							<input name="name" id="name" data-maxlength="300" class="form-control"
								value="<?= $screens->name; ?>" />

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">URL</label>
						<div class="col-lg-6">
							<input name="url" id="url" data-maxlength="300" class="form-control"
								value="<?= $screens->url; ?>" />

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Menu</label>
						<div class="col-lg-6">
							<select name="menu" class="form-control" id="menu" required="">
								<option></option>
								<option value="1" <?php if ($screens->menu == 1) {
									echo 'selected';
								} ?>>1</option>
								<option value="0" <?php if ($screens->menu == 0) {
									echo 'selected';
								} ?>>0</option>
							</select>

						</div>
					</div>

				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>admin/screens"
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