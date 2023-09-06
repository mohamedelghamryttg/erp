<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit User</h3>

			</div>
			<!--begin::Form-->
			<form class="form" method="post" enctype="multipart/form-data">
				<div class="card-body">

					<input type="text" name="id" value="<?= $id ?>" hidden="">
					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Name</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $row->name ?>" name="name" data-maxlength="300" id="name" readonly>

						</div>
					</div>


					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Email</label>
						<div class="col-lg-6">
							<input type="email" placeholder="E-mail" class=" form-control" value="<?= $row->email ?>" name="email" id="email" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Password</label>
						<div class="col-lg-6">
							<input type="password" id="inputPassword" placeholder="Password" class=" form-control" value="<?= base64_decode($row->password) ?>" name="password" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Status</label>
						<div class="col-lg-6">
							<?php if ($row->status == 1) { ?>
								<input type="text" class=" form-control" value="Active" name="status" data-maxlength="300" id="status" readonly>
							<?php } else { ?>
								<input type="text" class=" form-control" value="deactive" name="status" data-maxlength="300" id="status" readonly>
							<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">

							<a class="btn btn-secondary" href="<?php echo base_url() ?>admin/vendorsAccounts" class="btn btn-default" type="button">Back</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>