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
								<a href="<?= base_url() ?>admin/addUser" class="btn btn-primary ">Add New User</a>
								</br></br></br>
							<?php } ?>
							Show / Hide:
							<a href="" class="toggle-vis" data-column="0">ID</a> -
							<a href="" class="toggle-vis" data-column="1">Username</a> -
							<a href="" class="toggle-vis" data-column="2">Email</a> -
							<a href="" class="toggle-vis" data-column="3">Brand</a> -
							<a href="" class="toggle-vis" data-column="4">Role</a> -
							<a href="" class="toggle-vis" data-column="5">Abbreviations</a> -
							<a href="" class="toggle-vis" data-column="6">Status</a> -
							<a href="" class="toggle-vis" data-column="7">Edit</a> -
							<a href="" class="toggle-vis" data-column="8">Delete</a>
							</br></br></br>
						</div>

					</div>

					<div class="space15"></div>

					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Username</th>
								<th>Email</th>
								<th>Brand</th>
								<th>Role</th>
								<th>Abbreviations</th>
								<th>Status</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>

						<tbody>
							<?php
							if ($users->num_rows() > 0) {
								foreach ($users->result() as $row) {
									?>
									<tr class="">
										<td>
											<?php echo $row->id; ?>
										</td>
										<td>
											<?php echo $row->user_name; ?>
										</td>
										<td>
											<?php echo $row->email; ?>
										</td>
										<td>
											<?php echo $this->admin_model->getBrand($row->brand); ?>
										</td>
										<td>
											<?php echo $this->admin_model->getRole($row->role); ?>
										</td>
										<td>
											<?php echo $row->abbreviations; ?>
										</td>
										<td>
											<?php if ($row->status == 1) {
												echo "Active";
											} elseif ($row->status == 0) {
												echo "Deactive";
											} ?>
										</td>
										<td>
											<?php if ($permission->edit == 1) { ?>
												<a href="<?php echo base_url() ?>admin/edituser?t=<?php echo base64_encode($row->id); ?>"
													class="">
													<i class="fa fa-pencil"></i> Edit
												</a>
											<?php } ?>
										</td>

										<td>
											<?php if ($permission->delete == 1) { ?>
												<a href="<?php echo base_url() ?>admin/deleteUser/<?php echo $row->id ?>"
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
								<td colspan="7">There is no users to list</td>
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