<div class="row">
	<div class="col-sm-12">
		<section class="panel">

			<header class="panel-heading">
				Screens
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
								<a href="<?= base_url() ?>admin/addScreen" class="btn btn-primary ">Add New Screen</a>
								</br></br></br>
							<?php } ?>
							Show / Hide:
							<a href="" class="toggle-vis" data-column="0">ID</a> -
							<a href="" class="toggle-vis" data-column="1">Groups</a> -
							<a href="" class="toggle-vis" data-column="2">Name</a> -
							<a href="" class="toggle-vis" data-column="3">URL</a> -
							<a href="" class="toggle-vis" data-column="4">Menue</a> -
							<a href="" class="toggle-vis" data-column="5">Edit</a> -
							<a href="" class="toggle-vis" data-column="6">Delete</a>
							</br></br></br>
						</div>

					</div>

					<div class="space15"></div>

					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Groups</th>
								<th>Name</th>
								<th>URL</th>
								<th>Menue</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>

						<tbody>
							<?php
							if ($screen->num_rows() > 0) {
								foreach ($screen->result() as $row) {
									?>
									<tr class="">
										<td>
											<?php echo $row->id; ?>
										</td>
										<td>
											<?php echo $this->admin_model->getGroup($row->groups)->name; ?>
										</td>
										<td>
											<?php echo $row->name; ?>
										</td>
										<td>
											<?php echo $row->url; ?>
										</td>
										<td>
											<?php if ($row->menu == 1) {
												echo "1";
											} else {
												echo "0";
											} ?>
										</td>
										<td>
											<?php if ($permission->edit == 1) { ?>
												<a href="<?php echo base_url() ?>admin/editScreen/<?php echo
												  	$row->id; ?>" class="">
													<i class="fa fa-pencil"></i> Edit
												</a>
											<?php } ?>
										</td>

										<td>
											<?php if ($permission->delete == 1) { ?>
												<a href="<?php echo base_url() ?>admin/deleteScreen/<?php echo $row->id ?>"
													title="delete" class=""
													onclick="return confirm('Are you sure you want to delete this Permission ?');">
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
								<td colspan="7">There is no screens to list</td>
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