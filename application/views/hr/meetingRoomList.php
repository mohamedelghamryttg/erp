<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Meetings List
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
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>hr/addMeeting" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
							  <tr>
								<th>Title</th>
								<th>Attendees</th>
								<th>Description</th>
								<th>Start Date</th>
								<th>End Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($meeting->result() as $row)
								{
						?>
									<tr class="">
										<td><?php echo $row->title ;?></td> 
										<td><?php echo $row->attendees ;?></td> 
										<td><?php echo $row->description ;?></td> 
										<td><?php echo $row->start ;?></td> 
										<td><?php echo $row->end ;?></td> 
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<?php if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>hr/editMeeting?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if($permission->delete == 1){ ?>
											<a href="<?php echo base_url()?>hr/deleteMeeting/<?php echo $row->id ?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this user?');">
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
                         <?=$this->pagination->create_links()?>
                    </nav>
				</div>
			</div>
		</section>
	</div>
</div>