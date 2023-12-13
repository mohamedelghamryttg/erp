<style>
	.blocked,
	.blocked a,
	.blocked td {
		background-color: darkgray !important;
		color: white !important;
		font-weight: bold;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Filter
			</header>

			<div class="panel-body">
				<form class="cmxform form-horizontal " id="vendorForm" action="<?php echo base_url() ?>vendor/vendorSheet" method="get" enctype="multipart/form-data">
					<?php
					if (isset($_REQUEST['vendor'])) {
						$vendorName = $_REQUEST['vendor'];
					} else {
						$vendorName = "";
					}
					if (isset($_REQUEST['dialect'])) {
						$dialect = $_REQUEST['dialect'];
					} else {
						$dialect = "";
					}
					if (isset($_REQUEST['source_lang'])) {
						$source_lang = $_REQUEST['source_lang'];
					} else {
						$source_lang = "";
					}
					if (isset($_REQUEST['target_lang'])) {
						$target_lang = $_REQUEST['target_lang'];
					} else {
						$target_lang = "";
					}
					if (isset($_REQUEST['service'])) {
						$service = $_REQUEST['service'];
					} else {
						$service = "";
					}
					if (isset($_REQUEST['task_type'])) {
						$task_type = $_REQUEST['task_type'];
					} else {
						$task_type = "";
					}
					?>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role name">Vendor Name</label>

						<div class="col-lg-3">
							<select name="vendor" class="form-control m-b" id="vendor" />
							<option disabled="disabled" selected="selected">-- Select Vendor --</option>
							<?= $this->vendor_model->selectVendor($vendorName, $brand) ?>
							</select>
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Dialect</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" value="<?= $dialect ?>" name="dialect">
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role Task Type">Source</label>

						<div class="col-lg-3">
							<select name="source_lang" class="form-control m-b" id="source" />
							<option disabled="disabled" selected="selected">-- Select Source Language --</option>
							<?= $this->admin_model->selectLanguage($source_lang) ?>
							</select>
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Target</label>

						<div class="col-lg-3">
							<select name="target_lang" class="form-control m-b" id="target" />
							<option disabled="disabled" selected="selected">-- Select Target Language --</option>
							<?= $this->admin_model->selectLanguage($target_lang) ?>
							</select>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role Task Type">Service</label>

						<div class="col-lg-3">
							<select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
							<option disabled="disabled" selected=""></option>
							<?= $this->admin_model->selectServices($service) ?>
							</select>
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Task Type</label>

						<div class="col-lg-3">
							<select name="task_type" class="form-control m-b" id="task_type" />
							<option disabled="disabled" selected=""></option>
							</select>
						</div>

					</div>
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-6">
							<button class="btn btn-primary" name="search" type="submit">Search</button>
							<button class="btn btn-success" onclick="var e2 = document.getElementById('vendorForm'); e2.action='<?= base_url() ?>vendor/exportAllVendors'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
								Excel</button>
							<a href="<?= base_url() ?>vendor/vendorSheet" class="btn btn-warning">(x) Clear Filter</a>

						</div>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Vendors Sheet
			</header>
			<?php if ($this->session->flashdata('true')) { ?>
				<div class="alert alert-success" role="alert">
					<span class="fa fa-check-circle"></span>
					<span><strong>
							<?= $this->session->flashdata('true') ?>
						</strong></span>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger" role="alert">
					<span class="fa fa-warning"></span>
					<span><strong>
							<?= $this->session->flashdata('error') ?>
						</strong></span>
				</div>
			<?php } ?>

			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
							<?php if ($permission->add == 1) { ?>
								<a href="<?= base_url() ?>vendor/addVendorSheet" class="btn btn-primary ">Add New Record</a>
								</br></br></br>
							<?php } ?>
						</div>

					</div>

					<div class="space15"></div>

					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Source Language</th>
								<th>Target Language</th>
								<th>Dialect</th>
								<th>Service</th>
								<th>Task Type</th>
								<th>Unit</th>
								<th>Rate</th>
								<th>Currency</th>
								<th>Subject Matter</th>
								<th>Tools</th>
								<th>Num. Of Tasks</th>
								<th>Blocked/Num. of Bad Review</th>
								<th>Rank</th>
								<th>Created By</th>
								<th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach ($vendor->result() as $row) {
							?>
								<tr class="">
									<td>
										<?= $row->id ?>
									</td>
									<td><a href="<?= base_url() ?>vendor/vendorProfile?t=<?= base64_encode($row->vendor) ?>" target="_blank"><?= $this->vendor_model->getVendorName($row->vendor) ?></a></td>
									<td>
										<?= $this->admin_model->getLanguage($row->source_lang) ?>
									</td>
									<td>
										<?= $this->admin_model->getLanguage($row->target_lang) ?>
									</td>
									<td>
										<?= $row->dialect ?>
									</td>
									<td>
										<?= $this->admin_model->getServices($row->service) ?>
									</td>
									<td>
										<?= $this->admin_model->getTaskType($row->task_type) ?>
									</td>
									<td>
										<?= $this->admin_model->getUnit($row->unit) ?>
									</td>
									<td>
										<?= $row->rate ?>
									</td>
									<td>
										<?= $this->admin_model->getCurrency($row->currency) ?>
									</td>
									<td>
										<?php
										$subjects = explode(",", $row->subject ?? '');
										for ($i = 0; $i < count($subjects); $i++) {
											if ($i > 0) {
												echo " - ";
											}
											echo $this->admin_model->getFields($subjects[$i]);
										}
										?>
									</td>
									<td>
										<?php
										$tools = explode(",", $row->tools ?? '');
										for ($i = 0; $i < count($tools); $i++) {
											if ($i > 0) {
												echo " - ";
											}
											echo $this->sales_model->getToolName($tools[$i]);
										}
										?>
									</td>
									<td>
										<?= $this->vendor_model->getVendorTaskCount($row->vendor); ?>
									</td>
									<td>
										<?php
										if ($this->vendor_model->getVendorData($row->vendor)) {
											if ($this->vendor_model->getVendorData($row->vendor)->ev_block == 1) {
												echo 'YES';
												if ($this->vendor_model->getVendorData($row->vendor)->ev_block_count > 0) {
													echo ' (' . $this->vendor_model->getVendorData($row->vendor)->ev_block_count . ')';
												}
											} else {
												echo 'NO';
												if ($this->vendor_model->getVendorData($row->vendor)->ev_block_count > 0) {
													echo $this->vendor_model->getVendorData($row->vendor)->ev_block_count;
												}
											}
										}

										?>
									</td>
									<td>

										<?php
										if ($this->vendor_model->getVendorRank($row->vendor) > 0) {
											echo $this->vendor_model->getVendorRank($row->vendor) . '%';
										}
										?>
									</td>
									<td>
										<?php echo $this->admin_model->getAdmin($row->created_by); ?>
									</td>
									<td>
										<?php echo $row->created_at; ?>
									</td>
									<td>
										<?php if ($permission->edit == 1) { ?>
											<a href="<?php echo base_url() ?>vendor/editVendorSheet?t=<?= base64_encode($row->id) ?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
										<?php } ?>
									</td>
									<td>
										<?php if ($permission->delete == 1) { ?>
											<a href="<?php echo base_url() ?>vendor/deleteVendorSheet?t=<?= base64_encode($row->id) ?>" title="delete" class="" onclick="return confirm('Are you sure you want to delete this Record ?');">
												<i class="fa fa-times text-danger text"></i> Delete
											</a>
										<?php } ?>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
					<nav class="text-center">
						<?= $this->pagination->create_links() ?>
					</nav>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>