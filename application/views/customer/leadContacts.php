<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<?php echo $this->customer_model->getCustomer($lead->customer);?> - <?php echo $this->admin_model->getCountry($lead->country);?> - Contacts
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
							<a href="<?=base_url()?>customer/addLeadContacts?t=<?=base64_encode($id)?>" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
                              	<th>Job Title</th>
                                <th>Location</th>
                                <th>Skype Account</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
						<?php foreach($contacts->result() as $row) { ?>
									<tr class="">
										<td><?php echo $row->name ;?></td>
										<td><?php echo $row->email ;?></td>
										<td><?php echo $row->phone ;?></td>
										<td><?php echo $row->job_title ;?></td>
										<td><?php echo $row->location ;?></td>
										<td><?php echo $row->skype_account ;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<?php if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>customer/editLeadContacts?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
											<a href="<?php echo base_url()?>customer/deleteLeadContacts?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Customer ?');">
												<i class="fa fa-times text-danger text"></i> Delete
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