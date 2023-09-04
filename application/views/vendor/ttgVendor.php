<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Vendors Filter
			</header>

			<div class="panel-body">
				<form class="cmxform form-horizontal " action="<?php echo base_url() ?>vendor/ttgVendor" method="get"
					enctype="multipart/form-data">
					<?php
					if (isset($_REQUEST['email'])) {
						$email = $_REQUEST['email'];
					} else {
						$email = "";
					}
					if (isset($_REQUEST['name'])) {
						$name = $_REQUEST['name'];
					} else {
						$name = "";
					}
					if (isset($_REQUEST['contact'])) {
						$contact = $_REQUEST['contact'];
					} else {
						$contact = "";
					}
					if (isset($_REQUEST['country'])) {
						$country = $_REQUEST['country'];
					} else {
						$country = "";
					}
					if (isset($_REQUEST['type'])) {
						$type = $_REQUEST['type'];
					} else {
						$type = "";
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
					if (isset($_REQUEST['unit'])) {
						$unit = $_REQUEST['unit'];
					} else {
						$unit = "";
					}
					?>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role name">Name</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" value="<?= $name ?>" name="name">
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Email</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" value="<?= $email ?>" name="email">
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role Task Type">Contact</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" value="<?= $contact ?>" name="contact">
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Country of Residence</label>

						<div class="col-lg-3">
							<select name="country" class="form-control m-b" id="country" />
							<option disabled="disabled" selected="selected">-- Select Country --</option>
							<?= $this->admin_model->selectAllCountries($country) ?>
							</select>
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
						<label class="col-lg-2 control-label" for="role Task Type">Unit</label>

						<div class="col-lg-3">
							<select name="unit" class="form-control m-b" id="unit" />
							<option disabled="disabled" selected=""></option>
							<?= $this->admin_model->selectUnit($unit) ?>
							</select>
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Vendor Type</label>
						<div class="col-lg-3">
							<select name="type" class="form-control m-b" id="type" />
							<option selected="selected" disabled="disabled">-- Select Type --</option>
							<?php
							if (isset($_REQUEST['type']) && $_REQUEST['type'] == 0) { ?>
								<?= $this->vendor_model->selectVendorType($type) ?>
							<?php } elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 1) { ?>
								<?= $this->vendor_model->selectVendorType($type) ?>
							<?php } else { ?>
								<?= $this->vendor_model->selectVendorType(25) ?>
							<?php } ?>
							</select>
						</div>

					</div>
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-6">
							<button class="btn btn-primary" name="search" type="submit">Search</button>
							<a href="<?= base_url() ?>vendor/ttgVendor" class="btn btn-warning">(x) Clear Filter</a>
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
				Vendors List
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
				<div class="adv-table editable-table ">
					<div class="space15"></div>

					Show / Hide:
					<a href="" class="toggle-vis" data-column="0">ID</a> -
					<a href="" class="toggle-vis" data-column="1">Name</a> -
					<a href="" class="toggle-vis" data-column="2">Email</a> -
					<a href="" class="toggle-vis" data-column="3">Source Language</a> -
					<a href="" class="toggle-vis" data-column="4">Target Language</a> -
					<a href="" class="toggle-vis" data-column="5">Dialect</a> -
					<a href="" class="toggle-vis" data-column="6">Service</a> -
					<a href="" class="toggle-vis" data-column="7">Task Type</a> -
					<a href="" class="toggle-vis" data-column="8">Unit</a> -
					<a href="" class="toggle-vis" data-column="9">Rate</a> -
					<a href="" class="toggle-vis" data-column="10">Special Rate</a> -
					<a href="" class="toggle-vis" data-column="11">Currency</a> -
					<a href="" class="toggle-vis" data-column="12">Contact</a> -
					<a href="" class="toggle-vis" data-column="13">Country of Residence</a> -
					<a href="" class="toggle-vis" data-column="14">Mother Tongue</a> -
					<a href="" class="toggle-vis" data-column="15">Profile</a> -
					<a href="" class="toggle-vis" data-column="16">CV</a> -
					<a href="" class="toggle-vis" data-column="17">Subject Matter</a> -
					<a href="" class="toggle-vis" data-column="18">Tools</a> -
					<a href="" class="toggle-vis" data-column="19">Type</a> -
					<a href="" class="toggle-vis" data-column="20">Created By</a> -
					<a href="" class="toggle-vis" data-column="21">Created At</a> -
					<a href="" class="toggle-vis" data-column="22">Copy</a>
					</br></br></br>

					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Source Language</th>
								<th>Target Language</th>
								<th>Dialect</th>
								<th>Service</th>
								<th>Task Type</th>
								<th>Unit</th>
								<th>Rate</th>
								<th>Special Rate</th>
								<th>Currency</th>
								<th>Contact</th>
								<th>Country of Residence</th>
								<th>Mother Tongue</th>
								<th>Profile</th>
								<th>CV</th>
								<th>Subject Matter</th>
								<th>Tools</th>
								<th>Type</th>
								<th>Created By</th>
								<th>Created At</th>
								<th>Copy</th>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach ($vendor->result() as $row) {
								if ($row->color == "1") {
									$style = 'background-color: red;color: white;';
								} elseif ($row->color == "2") {
									$style = 'background-color: yellow;';
								} else {
									$style = '';
								}
								?>
								<tr style="<?= $style ?>" class="">
									<td>
										<?= $row->id ?>
									</td>
									<td><a href="<?= base_url() ?>vendor/vendorProfile?t=<?= base64_encode($row->id) ?>"
											target="_blank"><?= $row->name ?></a></td>
									<td>
										<?= $row->email ?>
									</td>
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
										<?= $row->special_rate ?>
									</td>
									<td>
										<?= $this->admin_model->getCurrency($row->currency) ?>
									</td>
									<td>
										<?= $row->contact ?>
									</td>
									<td>
										<?= $this->admin_model->getCountry($row->country) ?>
									</td>
									<td>
										<?= $row->mother_tongue ?>
									</td>
									<td>
										<?= $row->profile ?>
									</td>
									<td>
										<?php if (strlen($row->cv ?? '') > 1) { ?><a
												href="<?= base_url() ?>assets/uploads/vendors/<?= $row->cv ?>">Download</a>
										<?php } ?>
									</td>
									<td>
										<?php
										$subjects = explode(",", $row->subject);
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
										$tools = explode(",", $row->tools);
										for ($i = 0; $i < count($tools); $i++) {
											if ($i > 0) {
												echo " - ";
											}
											echo $this->sales_model->getToolName($tools[$i]);
										}
										?>
									</td>
									<td>
										<?php echo $this->vendor_model->getVendorType($row->type); ?>
									</td>
									<td>
										<?php echo $this->admin_model->getAdmin($row->sheetCreatedBy); ?>
									</td>
									<td>
										<?php echo $row->sheetCreatedAt; ?>
									</td>
									<td>
										<?php if ($permission->add == 1) {
											if ($row->copied == 0) { ?>
												<a href="<?php echo base_url() ?>vendor/copyTTGVendor?t=<?= base64_encode($row->sheetId) ?>"
													class=""
													onclick="return confirm('Are you sure you want to copy this vendor?');">
													<i class="fa fa-pencil"></i> Copy
												</a>
											<?php }
										} ?>
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
				</div>
			</div>
		</section>
	</div>
</div>