<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				POs List Filter
			</header>

			<div class="panel-body">
				<form class="cmxform form-horizontal " action="<?php echo base_url() ?>accounting/cpoStatus" id="poList" method="get" enctype="multipart/form-data">
					<?php
					if (isset($_REQUEST['customer'])) {
						$customer = $_REQUEST['customer'];
					} else {
						$customer = "";
					}
					if (isset($_REQUEST['po'])) {
						$po = $_REQUEST['po'];
					} else {
						$po = "";
					}
					if (isset($_REQUEST['verified'])) {
						$verified = $_REQUEST['verified'];
					} else {
						$verified = "";
					}
					if (isset($_REQUEST['invoiced'])) {
						$invoiced = $_REQUEST['invoiced'];
					} else {
						$invoiced = "";
					}
					?>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="role name">Client</label>

						<div class="col-lg-3">
							<select name="customer" class="form-control m-b" id="customer" />
							<option disabled="disabled" selected="selected">-- Select Client --</option>
							<?= $this->customer_model->selectCustomerBranches($customer, $brand) ?>
							</select>
						</div>

						<label class="col-lg-2 control-label" for="role name">PO Number</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" value="<?= $po ?>" name="po">
						</div>
					</div>
					<div class="form-group">

						<label class="col-lg-2 control-label" for="role date">Po Status</label>

						<div class="col-lg-3">
							<select name="verified" class="form-control m-b" id="verified">
								<option value="" disabled="disabled" selected="selected">-- Select Status --</option>

								<option value="1" <?= $verified == 1 ? " selected" : "" ?>>Verified</option>
								<option value="3" <?= $verified == 3 ? " selected" : "" ?>>Not Verified</option>
								<option value="2" <?= $verified == 2 ? " selected" : "" ?>>Has Error</option>

							</select>
						</div>

						<label class="col-lg-2 control-label" for="role date">Invoice Status</label>

						<div class="col-lg-3">
							<select name="invoiced" class="form-control m-b" id="invoiced" />
							<option disabled="disabled" selected="selected">-- Select --</option>
							<?php
							if ($_REQUEST['invoiced'] == 1) { ?>
								<option selected="" value="<?= $_REQUEST['invoiced'] ?>">Invoiced</option>
								<option value="2">Not Invoiced</option>
							<?php } elseif ($_REQUEST['invoiced'] == 2) { ?>
								<option selected="" value="<?= $_REQUEST['invoiced'] ?>">Not Invoiced</option>
								<option value="1">Invoiced</option>
							<?php } else { ?>
								<option value="1">Invoiced</option>
								<option value="2">Not Invoiced</option>

							<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-6">
							<button class="btn btn-primary" name="search" type="submit">Search</button>
							<!-- <button class="btn btn-success" onclick="var e2 = document.getElementById('poList'); e2.action='<?= base_url() ?>accounting/exportPOList'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> -->
							<a href="<?= base_url() ?>accounting/cpoStatus" class="btn btn-warning">(x) Clear Filter</a>

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
				POs List
			</header>
			<?php if ($this->session->flashdata('true')) { ?>
				<div class="alert alert-success" role="alert">
					<span class="fa fa-check-circle"></span>
					<span><strong><?= $this->session->flashdata('true') ?></strong></span>
				</div>
			<?php  } ?>
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger" role="alert">
					<span class="fa fa-warning"></span>
					<span><strong><?= $this->session->flashdata('error') ?></strong></span>
				</div>
			<?php  } ?>
			<div class="panel-body" style="overflow:scroll;">
				<div class="adv-table editable-table ">
					<form class="cmxform form-horizontal " onsubmit="return checkPoVerifyForm()" action="<?php echo base_url() ?>accounting/verifyMultiPos" method="post" enctype="multipart/form-data">
						<div class="clearfix">
							<div class="btn-group">
							</div>

						</div>
						<div class="space15"></div>

						<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
							<thead>
								<tr>
									<th>Client Name</th>
									<th>PO Number</th>
									<th>CPO File</th>
									<th>Closed Date</th>
									<th>PM Name</th>
									<th>Verified</th>
									<th>Verified At</th>
									<th>Has Error</th>
									<th>Invoiced</th>
									<th>Paid</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$x = 0;
								foreach ($cpo->result() as $row) {
									$jobs = $this->db->get_where('job', array('po' => $row->id))->result();
								?>
									<tr>
										<td><?php echo $this->customer_model->getCustomer($row->customer); ?></td>
										<td><?php echo $row->number; ?></td>
										<td><a href="<?= base_url() ?>assets/uploads/cpo/<?= $row->cpo_file ?>" target="_blank">Click Here</a></td>
										<td><?php echo $row->created_at; ?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
										<td><?php if ($row->verified == 1) {
												echo "Verified";
											} elseif ($row->verified == 2) {
												echo "Has Error";
											} else {
												echo "Not Verified";
											} ?></td>
										<td><?php if ($row->verified == 1) {
												echo $row->verified_at;
											} ?></td>
										<td>
											<?php
											if ($row->verified == 2) {
												$errors = explode(",", $row->has_error);
												for ($i = 0; $i < count($errors); $i++) {
													if ($i > 0) {
														echo " - ";
													}
													echo $this->accounting_model->getError($errors[$i]);
												}
											} ?>
										</td>
										<td><?php if ($row->invoiced == 1) {
												echo "Invoiced";
											} else {
												echo "Not Invoiced";
											} ?></td>
										<td><?php if ($row->paid == 1) {
												echo "paid";
											} else {
												echo "Not paid";
											} ?></td>
									</tr>
									<tr>
										<td colspan="4">
											<table class="table table-striped table-hover table-bordered">
												<thead>
													<th>Job Code</th>
													<th>Service</th>
													<th>Source</th>
													<th>Target</th>
													<th>Volume</th>
													<th>Rate</th>
													<th>Currency</th>
													<th>Total Revenue</th>
													<th>Status</th>
													<th>Closed Date</th>
													<th>Created By</th>
												</thead>
												<tbody>
													<?php
													$total = 0;
													foreach ($jobs as $job) {
														$priceList = $this->projects_model->getJobPriceListData($job->price_list);
														$jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
														$total = $total + $jobTotal;
													?>
														<tr>
															<td><?= $job->code ?></td>
															<td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
															<td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
															<td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
															<?php if ($job->type == 1) { ?>
																<td><?php echo $job->volume; ?></td>
															<?php } elseif ($job->type == 2) { ?>
																<td><?php echo $jobTotal / $priceList->rate; ?></td>
															<?php } ?>
															<td><?php echo $priceList->rate; ?></td>
															<td><?php echo $this->admin_model->getCurrency($priceList->currency); ?></td>
															<td><?php echo $jobTotal; ?></td>
															<td><?php echo $this->projects_model->getJobStatus($job->status); ?></td>
															<td><?php echo $job->closed_date; ?></td>
															<td><?php echo $this->admin_model->getAdmin($job->created_by); ?></td>
														</tr>
													<?php } ?>
													<tr>
														<td colspan="7">Project Total Revenue</td>
														<td><?= $total ?></td>
														<td colspan="3"></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<nav class="text-center">
							<?= $this->pagination->create_links() ?>
						</nav>
					</form>
					<?php foreach ($cpo->result() as $modal) { ?>
						<!-- form of adding POs Error-->
						<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal<?php echo $modal->id; ?>" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
										<h4 class="modal-title">Has Error PO</h4>
									</div>
									<div class="modal-body">

										<form method="post" action="<?php echo base_url() ?>accounting/HasErrorPos">
											<input type="text" name="po" value="<?= base64_encode($modal->id) ?>" hidden="">
											<select class="form-control m-b" name="has_error[]" id="has_error" required="" multiple>
												<?= $this->accounting_model->selectHasError() ?>
											</select></br>

											<button type="submit" class="btn btn-default">Save</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</section>
	</div>
</div>