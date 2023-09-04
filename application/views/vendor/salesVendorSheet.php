<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Filter
			</header>

			<div class="panel-body">
				<form class="cmxform form-horizontal " action="<?php echo base_url() ?>vendor/salesVendorSheet"
					method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role Task Type">Dialect</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" name="dialect">
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
							<?= $this->admin_model->selectLanguage() ?>
							</select>
						</div>

						<label class="col-lg-2 control-label" for="role Task Type">Target</label>

						<div class="col-lg-3">
							<select name="target_lang" class="form-control m-b" id="target" />
							<option disabled="disabled" selected="selected">-- Select Target Language --</option>
							<?= $this->admin_model->selectLanguage() ?>
							</select>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role Task Type">Service</label>

						<div class="col-lg-3">
							<select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
							<option disabled="disabled" selected=""></option>
							<?= $this->admin_model->selectServices() ?>
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
						<label class="col-lg-2 control-label" for="role rate">Rate </label>

						<div class="col-lg-3">
							<input type="text" class="form-control" value="<?= $rate ?>" name="rate"
								placeholder="less than or equal">
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label" for="role Subject Matter">Subject Matter</label>

						<div class="col-lg-3">
							<select name="subject" class="form-control m-b" id="subject">
								<option disabled="disabled" value="" selected="selected">-- Select Subject --</option>
								<?= $this->admin_model->selectFields($vendor_subject) ?>
							</select>
						</div>
						<label class="col-lg-2 control-label" for="role Tools">Tools</label>

						<div class="col-lg-3">
							<select name="tools" class="form-control m-b" id="tools">
								<option disabled="disabled" value="" selected="selected">-- Select Tools --</option>
								<?= $this->sales_model->selectTools($vendor_tools) ?>
							</select>
						</div>
					</div>

			</div>
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-6">
					<button class="btn btn-primary" name="search" type="submit">Search</button>
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
								<th>Country of Residence</th>
								<th>Mother Tongue</th>
								<th>Type</th>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach ($vendor->result() as $row) {
								?>
								<tr class="">
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
										$subjects = explode(",", $row->vendor_subject);
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
										$tools = explode(",", $row->vendor_tools);
										for ($i = 0; $i < count($tools); $i++) {
											if ($i > 0) {
												echo " - ";
											}
											echo $this->sales_model->getToolName($tools[$i]);
										}
										?>
									</td>
									<td>
										<?= $this->admin_model->getCountry($row->country) ?>
									</td>
									<td>
										<?= $row->mother_tongue ?>
									</td>
									<td>
										<?php echo $this->vendor_model->getVendorType($row->type); ?>
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