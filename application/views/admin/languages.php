<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Languages Filter
			</header>

			<div class="panel-body">
				<form class="cmxform form-horizontal " action="<?php echo base_url() ?>admin/languages" method="post"
					id="languages" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-lg-2 control-label" for="languages">Language</label>

						<div class="col-lg-3">
							<input type="text" class="form-control" name="name">
						</div>


					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label" for="role date">Date From</label>
						<div class="col-lg-3">
							<input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
						</div>
						<label class="col-lg-2 control-label" for="role date">Date To</label>
						<div class="col-lg-3">
							<input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
						</div>
					</div>


					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-6">
							<button class="btn btn-primary" name="search" type="submit">Search</button>
							<button class="btn btn-success"
								onclick="var e2 = document.getElementById('languages'); e2.action='<?= base_url() ?>admin/exportLanguages'; e2.submit();"
								name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
								Excel</button>
							<a href="<?= base_url() ?>admin/languages" class="btn btn-warning">(x) Clear Filter</a>
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
				Users
			</header>
			<?php if ($this->session->flashdata('true')) { ?>
				<div class="alert alert-success" role="alert">
					<span class="fa fa-check-circle"></span>
					<span><strong><?= $this->session->flashdata('true') ?></strong></span>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger" role="alert">
					<span class="fa fa-warning"></span>
					<span><strong><?= $this->session->flashdata('error') ?></strong></span>
				</div>
			<?php } ?>

			<div class="panel-body">
				<div class="adv-table editable-table ">
					<div class="clearfix">
						<div class="btn-group">
							<?php if ($permission->add == 1) { ?>
								<a href="<?= base_url() ?>admin/addLanguage" class="btn btn-primary ">Add New Language</a>
								</br></br></br>
							<?php } ?>
							Show / Hide:
							<a href="" class="toggle-vis" data-column="0">ID</a> -
							<a href="" class="toggle-vis" data-column="1">Language</a> -
							<a href="" class="toggle-vis" data-column="9">Created By</a> -
							<a href="" class="toggle-vis" data-column="10">Created At</a> -
							<a href="" class="toggle-vis" data-column="2">Edit</a> -
							<a href="" class="toggle-vis" data-column="3">Delete</a>
							</br></br></br>
						</div>

					</div>

					<div class="space15"></div>

					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Language</th>
								<th>Created By</th>
								<th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>

							</tr>
						</thead>

						<tbody>
							<?php
							if ($languages->num_rows() > 0) {
								foreach ($languages->result() as $row) {
									?>
									<tr class="">
										<td>
											<?php echo $row->id; ?>
										</td>
										<td>
											<?php echo $row->name; ?>
										</td>
										<td>
											<?php echo $this->admin_model->getAdmin($row->created_by); ?>
										</td>
										<td><?= $row->created_at ?></td>
										<td>
											<?php if ($permission->edit == 1) { ?>
												<a href="<?php echo base_url() ?>admin/editLanguage?t=<?php echo base64_encode($row->id); ?>"
													class="">
													<i class="fa fa-pencil"></i> Edit
												</a>
											<?php } ?>
										</td>

										<td>
											<?php if ($permission->delete == 1) { ?>
												<a href="<?php echo base_url() ?>admin/deleteLanguage/<?php echo $row->id ?>"
													title="delete" class=""
													onclick="return confirm('Are you sure you want to delete this user?');">
													<i class="fa fa-times text-danger text"></i> Delete
												</a>
											<?php } ?>
										</td>
									</tr>
									<?php
								}
							} else {
								?>
							<tr>
								<td colspan="7">There is no Languages to list</td>
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