<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Vendor Data
			</header>
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">

					<div class="space15"></div>

					<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Contact</th>
								<th>Phone Number</th>
								<th>Country of Residence</th>
								<th>Mother Tongue</th>
								<th>Profile</th>
								<th>Subject Matter</th>
								<th>Tools</th>
								<th>CV</th>
							</tr>
						</thead>

						<tbody>
							<tr class="">
								<td>
									<?= $vendor->name ?>
								</td>
								<td>
									<?= $vendor->email ?>
								</td>
								<td>
									<?= $vendor->contact ?>
								</td>
								<td>
									<?= $vendor->phone_number ?>
								</td>
								<td>
									<?= $this->admin_model->getCountry($vendor->country) ?>
								</td>
								<td>
									<?= $vendor->mother_tongue ?>
								</td>
								<td>
									<?= $vendor->profile ?>
								</td>
								<td>
									<?php
									$subjects = explode(",", $vendor->subject);
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
									$tools = explode(",", $vendor->tools);
									for ($i = 0; $i < count($tools); $i++) {
										if ($i > 0) {
											echo " - ";
										}
										echo $this->sales_model->getToolName($tools[$i]);
									}
									?>
								</td>
								<td>
									<?php if (strlen($vendor->cv ?? '') > 1) { ?><a
											href="<?= base_url() ?>assets/uploads/vendors/<?= $vendor->cv ?>">Download</a>
									<?php } ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<section class="panel">

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

			<header class="panel-heading">
				Vendor Pairs
			</header>
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">

					<div class="space15"></div>

					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
								<th>Name</th>
								<th>Source Language</th>
								<th>Target Language</th>
								<th>Dialect</th>
								<th>Service</th>
								<th>Task Type</th>
								<th>Unit</th>
								<th>Rate</th>
								<th>Currency</th>
								<th>Edit</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($vendorSheet as $vendorSheet) { ?>
								<tr class="">
									<td>
										<?= $this->vendor_model->getVendorName($vendorSheet->vendor) ?>
									</td>
									<td>
										<?= $this->admin_model->getLanguage($vendorSheet->source_lang) ?>
									</td>
									<td>
										<?= $this->admin_model->getLanguage($vendorSheet->target_lang) ?>
									</td>
									<td>
										<?= $vendorSheet->dialect ?>
									</td>
									<td>
										<?= $this->admin_model->getServices($vendorSheet->service) ?>
									</td>
									<td>
										<?= $this->admin_model->getTaskType($vendorSheet->task_type) ?>
									</td>
									<td>
										<?= $this->admin_model->getUnit($vendorSheet->unit) ?>
									</td>
									<td>
										<?= $vendorSheet->rate ?>
									</td>
									<td>
										<?= $this->admin_model->getCurrency($vendorSheet->currency) ?>
									</td>
									<td>
										<?php if ($permission->edit == 1) { ?>
											<a href="<?php echo base_url() ?>vendor/editVendorSheet?t=<?= base64_encode($vendorSheet->id) ?>"
												class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Vendor Skills <a href="<?= base_url() ?>vendor/editVendorSkills?t=<?= base64_encode($vendor->id) ?>"
					class="ml-2 text-danger"><i class="fa fa-pencil"></i></a>
			</header>
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">

					<div class="space15"></div>

					<table class="table table-striped table-hover table-bordered" id="">
						<tbody>
							<tr>
								<td><b>Strong Fields : </b>
									<?= $this->admin_model->getMultiFields($vendorSkills->strong_fields ?? '') ?>
								</td>
								<td><b>Services : </b>
									<?= $this->admin_model->getMultiServices($vendorSkills->services ?? '') ?>
								</td>
								<td><b>Capacity : </b>
									<?= $vendorSkills->capacity ?? '' ?>
								</td>
							</tr>
							<tr>
								<td><b>Support with the voice over ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->voice_over ?? '') ?>
								</td>
								<td><b>Have A Sample ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->voice_over_sample ?? '') ?>
								</td>
								<td><b>Studio or non-studio ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->voice_over_studio ?? '', 'Studio') ?>
								</td>
							</tr>
							<tr>
								<td colspan="3"><b>- Does the vendor have samples in Trans-creation ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->trans_creation_sample ?? '') ?>
								</td>

							</tr>
							<tr>
								<td><b>- can handle DTP ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->dtp ?? '') ?>
								</td>
								<td colspan="2"><b>DTP Tools : </b>
									<?= $this->admin_model->getMultiDTPApplication($vendorSkills->dtp_tools ?? '') ?>
								</td>
							</tr>
							<tr>
								<td><b>- can handle sworn translation ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->sworn_translation ?? '') ?>
								</td>
								<th colspan="2">
									<?php if (strlen($vendorSkills->sworn_translation_certificate ?? '') > 1 && $vendorSkills->sworn_translation == 1) { ?>
										<a class="text-danger"
											href="<?= base_url() ?>assets/uploads/vendors/<?= $vendorSkills->sworn_translation_certificate ?>">Download
											Certificate</a>
									<?php } ?>
								</th>
							</tr>
							<tr>
								<td><b>- vendor holds other certificates (ATA,..) ? </b>
									<?= $this->admin_model->getRadioData($vendorSkills->other_certificates ?? '') ?>
								</td>
								<th colspan="2">
									<?php if (strlen($vendorSkills->other_certificates_files ?? '') > 1 && $vendorSkills->other_certificates == 1) { ?>
										<a class="text-danger"
											href="<?= base_url() ?>assets/uploads/vendors/<?= $vendorSkills->other_certificates_files ?? '' ?>">Download
											Other Certificate</a>
									<?php } ?>
								</th>
							</tr>
						</tbody>

					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Vendor Feedback <a
					href="<?= base_url() ?>vendor/viewAllVendorFeedback?t=<?= base64_encode($vendor->id) ?>"
					class="ml-2 text-danger"><i class="fa fa-list"></i> View All</a>
			</header>
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">

					<div class="space15"></div>

					<table class="table table-striped table-hover table-bordered" id="">
						<tbody>
							<?php if ($feedback == 0) { ?>
								<tr>
									<td><b>No Feedback Yet </b>
									</td>
								</tr>
							<?php } else { ?>
								<tr>
									<td>
										<b>Total Reviews :

											<?= $feedback ?>
										</b>
									</td>
								</tr>
								<tr>
									<td>
										<b>Quality Avg. : </b>
										<?php $quality = $this->vendor_model->getVendorFeedbackAVG("quality", $id);
										for ($i = 1; $i <= $quality; $i++) { ?>
											<i class="fa fa-star text-warning"></i>
										<?php } ?>
										<?= "(" . $quality . ")" ?>
									</td>
								</tr>
								<tr>
									<td>
										<b>Communication Avg. : </b>
										<?php $communication = $this->vendor_model->getVendorFeedbackAVG("communication", $id);
										for ($i = 1; $i <= $communication; $i++) { ?>
											<i class="fa fa-star text-warning"></i>
										<?php } ?>
										<?= "( " . $communication . ")" ?>
									</td>
								</tr>
								<tr>
									<td>
										<b>Price Avg. : </b>
										<?php $price = $this->vendor_model->getVendorFeedbackAVG("price", $id);
										for ($i = 1; $i <= $price; $i++) { ?>
											<i class="fa fa-star text-warning"></i>
										<?php } ?>
										<?= "( " . $price . ") " ?>
									</td>
								</tr>
							<?php } ?>

						</tbody>

					</table>
				</div>
			</div>
		</section>
	</div>
</div>