<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Group</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>admin/doEditGroup" method="post"
				enctype="multipart/form-data">
				<div class="card-body">

					<input type="text" name="id" value="<?= base64_encode($groupss->id) ?>" hidden="">
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Group</label>
						<div class="col-lg-6">
							<input name="name" id="name" class="form-control" value="<?= $groupss->name ?>" />

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Icon</label>
						<div class="col-lg-6">
							<!-- <input name="icon" id="icon" class="form-control"  > -->
							<textarea name="icon" id="icon" class="form-control" rows="15"
								cols="40"><?= $groupss->icon ?></textarea>

						</div>
					</div>
				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>admin/groups"
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