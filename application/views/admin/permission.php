<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Permissions
			</header>
			<?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
			<?php  } ?>
			<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
			<?php  } ?>
			
			<div class="panel-body">
				<div class="adv-table editable-table ">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>admin/addPermission" class="btn btn-primary ">Add New Permission</a>
						</br></br></br>
						<?php } ?>
						Show / Hide:
						<a href="" class="toggle-vis" data-column="0">ID</a> - 
						<a href="" class="toggle-vis" data-column="1">Screen</a> -
						<a href="" class="toggle-vis" data-column="2">Role</a> -
						<a href="" class="toggle-vis" data-column="3">Follow-Up</a> -
						<a href="" class="toggle-vis" data-column="4">Can View</a> -
						<a href="" class="toggle-vis" data-column="5">Can Add</a> -
						<a href="" class="toggle-vis" data-column="6">Can Edit</a> -
						<a href="" class="toggle-vis" data-column="7">Can Delete</a> -
						<a href="" class="toggle-vis" data-column="8">Edit</a> -
						<a href="" class="toggle-vis" data-column="9">Delete</a>
						</br></br></br>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Screen</th>
								<th>Role</th>
								<th>Follow-Up</th>
								<th>Can View</th>
								<th>Can Add</th>
								<th>Can Edit</th>
								<th>Can Delete</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
							// if(count($permissions->num_rows())>0)
							// {
								foreach($permissions->result() as $row)
								{
									?>
									<tr class="">
										<td><?php echo $row->id ;?></td>
										<td><?php echo $this->admin_model->getScreenName($row->screen);?></td>
										<td><?php echo $this->admin_model->getRole($row->role);?></td>
										<td><?php echo $this->admin_model->getFollowUp($row->follow);?></td>
										<td><?php if($row->view == 2){echo "View Only Assigned";}elseif($row->view == 1){echo "View ALL";}else{echo "No";}?></td>
										<td><?php if($row->add == 1){echo "Yes";}else{echo "No";}?></td>
										<td><?php if($row->edit == 1){echo "Yes";}else{echo "No";}?></td>
										<td><?php if($row->delete == 1){echo "Yes";}else{echo "No";}?></td>
										<td>
											<?php if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>admin/editPermission/<?php echo 
											$row->id ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										
										<td>
											<?php if($permission->delete == 1){ ?>
											<a href="<?php echo base_url()?>admin/deletePermission/<?php echo $row->id ?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Permission ?');">
												<i class="fa fa-times text-danger text"></i> Delete
											</a>
											<?php } ?>
										</td>
									</tr>
									<?php
								}
							// }
							// else
							// {
								?>
								<!-- <tr><td colspan="7">There is no users to list</td></tr> -->
								<?php
							// }
							?>								
						</tbody>
					</table>
					<nav class="text-center">
                      <?=$this->pagination->create_links()?>
                    </nav>
				</div>
			</div>
		</section>
	</div>
</div>