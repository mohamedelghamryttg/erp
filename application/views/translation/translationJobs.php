<form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/closeJob" onsubmit="return checkJobVerifyForm();" method="post" enctype="multipart/form-data">

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Translation Request
			</header>
			<div class="panel-body">
          		<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
							<span class=" btn-primary" style="">
								Request Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                <th>Task Code</th>
                              	<th>Task Subject</th>
                              	<th>Task Type</th>
                             	 <th>Count</th>
                             	 <th>Unit</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                             	 <th>Task File</th>
                             	 <th>Status</th>
                             	 <th>Request Date</th>
                             	 <th>Requested By</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Request</th>
							</tr>
						</thead>
						
						<tbody>
							<tr class="">
                             	<td><a href="<?php echo base_url()?>translation/viewRequest?t=<?php echo 
										base64_encode($task->id) ;?>" class="">Translation-<?=$task->id?></a></td>
                              	<td><?php echo $task->subject ;?></td>
								<td><?php echo $this->admin_model->getTaskType($task->task_type);?></td>
								<td><?php echo $task->count ;?></td>
								<td><?php echo $this->admin_model->getUnit($task->unit) ;?></td>
								<td><?php echo $task->start_date ;?></td>
								<td><?php echo $task->delivery_date ;?></td>
								<td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationTaskStatus($task->status) ;?></td>
								<td><?php echo $task->created_at ;?></td>
								<td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($task->status_by) ;?></td>
								<td><?php echo $task->status_at ;?></td>
								<td>
									<a href="<?php echo base_url()?>translation/viewRequest?t=<?php echo 
										base64_encode($task->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Request
									</a>
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
			
			<header class="panel-heading">
				Translation Jobs
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
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $task->status == 2){ ?>
								<a href="<?=base_url()?>translation/addJob?t=<?=base64_encode($task->id)?>" class="btn btn-primary ">Add New Job</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                                <th>Task Code</th>
                                <th>Assigned Translator</th>
                              	<th>Task Type</th>
                             	 <th>Count</th>
                             	 <th>Updated Count</th>
                             	 <th>Unit</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                             	 <th>Task File</th>
                             	 <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                             	 <th>Closed Date</th>
                             	 <th>View Job</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job->result() as $row) { ?>
							<tr class="">
                             	<td><a href="<?php echo base_url()?>translation/TranslationJobs?t=<?php echo base64_encode($task->id) ;?>" class="">Translation-<?=$task->id?>-<?=$row->id?></a></td>
								<td><?php echo $this->admin_model->getAdmin($row->translator) ;?></td>
								<td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
								<td><?php echo $row->count ;?></td>
								<td><?php if($row->status == 4){ echo $row->updated_count ;} ?></td>
								<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationJob/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td><?php echo $row->closed_date ;?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>translation/viewTranslatorTask?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Job
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && ($row->status == 0 || $row->status == 3)){ ?>
									<a href="<?php echo base_url()?>translation/editJob?t=<?php echo 
									base64_encode($task->id) ;?>&j=<?=base64_encode($row->id)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>translation/deleteJob?t=<?php echo 
									base64_encode($row->id) ;?>&p=<?=base64_encode($row->project_id)?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Project ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>