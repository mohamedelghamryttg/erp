<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Customer</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>customer/doEditCustomer/<?= $customer->id ?>" method="post"
				enctype="multipart/form-data">
				<div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Name</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $customer->name ?>" name="name" required
								<?= $role == 19 ? 'readonly' : '' ?>>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Website</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $customer->website ?>" name="website"
								required <?= $role == 19 ? 'readonly' : '' ?>>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Customer Alias</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $customer->alias ?>" name="alias"
								required>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Payment Terms</label>
						<div class="col-lg-6">
							<input type="text" class=" form-control" value="<?= $customer->payment ?>" name="payment"
								required>
						</div>
					</div>
					<?php if ($role != 19) { ?>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Client Type</label>
							<div class="col-lg-6">
								<select name="client_type" class="form-control m-b " id="client_type" required>
									<option value="" disabled="disabled" selected="selected">-- Select Type --</option>
									<?= $this->sales_model->selectClientType($customer->client_type) ?>
								</select>
							</div>
						</div>
                                                <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label text-right">Customer Profile</label>
                                                        <div class="col-lg-6">
                                                                <input type="file" class=" form-control" name="customer_profile" accept=".zip,.rar,.7zip">                                                               

                                                        </div>
                                                        <?php if(!empty($customer->customer_profile)){?>
                                                            <div class="col-lg-3">
                                                                <a class="btn btn-sm btn-dark" href="<?=base_url().'assets/uploads/customer_profiles/'.$customer->customer_profile?>">View Profile</a>
                                                            </div>
                                                        <?php }?>
                                                </div>
                                                <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label text-right">Notes</label>
                                                        <div class="col-lg-6">
                                                                 <textarea name="notes" class="form-control" rows="10"><?=$customer->notes?></textarea>

                                                        </div>
                                                </div>
					<?php } ?>

				</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url() ?>customer" class="btn btn-default"
								type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>