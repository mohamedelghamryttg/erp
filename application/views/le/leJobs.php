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
							    <th>PM</th>
                                <th>Task Code</th>
                              	<th>Task Name</th>
                              	<th>Task Type</th>
                              	<th>Linguist Format</th>
								<th>Deliverable Format</th>
								<th>Unit</th>
								<th>Volume</th>
                                
								<th>Source Language</th>
								<th>Target Language</th>
                             	 <th>Task File</th>
                             	 <th>Status</th>
                             	 <th>Requested By</th>
								<th>View Request</th>
							</tr>
						</thead>
						
						<tbody>

							<?php
                            if($task->job_id == 0){
                                $product_line = $task->product_line;
                                $source_language = $task->source_language;
                                $target_language = $task->target_language;
                            } else{
                                $jobData = $this->projects_model->getJobData($task->job_id);
                                $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                                $product_line = $priceListData->product_line;
                                $source_language = $priceListData->source;
                                $target_language = $priceListData->target;
                            }
                            ?>

							<tr class="">
								 <td><?=$this->admin_model->getAdmin($task->created_by)?></td>
                             	<td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($task->id) ;?>" class="">LE-<?=$task->id?></a></td>
                              	<td><?php echo $task->subject ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($task->task_type);?></td>
								
							<?php if(is_numeric($task->linguist) && is_numeric($task->deliverable)){ ?>
								<td><?php echo $this->admin_model->getLeFormat($task->linguist);?></td>
								<td><?php echo $this->admin_model->getLeFormat($task->deliverable);?></td>
							<?php }else{ ?>
								<td><?=$task->linguist ?></td>
								<td><?=$task->deliverable ?></td>
							<?php } ?>	
								<td><?php echo $this->admin_model->getUnit($task->unit);?></td>
								<td><?=$task->volume?></td>
								
                            
								<td><?php echo $this->admin_model->getLanguage($source_language);?></td>
								<td><?php echo $this->admin_model->getLanguage($target_language);?></td>
								
								<td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationTaskStatus($task->status) ;?></td>
								
								<td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
								
								<td>
									<a href="<?php echo base_url()?>le/viewRequest?t=<?php echo 
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
				LE Jobs
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
								<a href="<?=base_url()?>le/addJob?t=<?=base64_encode($task->id)?>" class="btn btn-primary ">Add New Job</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
							    <th>PM</th>
                                <th>Job Code</th>
                                <th>Assigned LE</th>
                              	<th>Task Type</th>
                              
                              	<th>Linguist Format</th>
								<th>Deliverable Format</th>
								
                             	 <th>Task File</th>
                             	 <th>Status</th>
                              
                             	 <th>View Job</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job->result() as $row) {
							if($row->job_id == 0){
								$product_line = $task->product_line;
								$source_language = $task->source_language;
                                $target_language = $task->target_language;
							} else{
								$jobData = $this->projects_model->getJobData($task->job_id);
								$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
								$product_line = $priceListData->product_line;
								$source_language = $priceListData->source;
                                $target_language = $priceListData->target;
							}
							?>
							<tr class="">
							   <td><?=$this->admin_model->getAdmin($task->created_by)?></td>
                             	<td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($task->id) ;?>" class="">LE-<?=$task->id?>-<?=$row->id?></a></td>
								<td><?php echo $this->admin_model->getAdmin($row->le) ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
								
								<?php if(is_numeric($row->linguist) && is_numeric($row->deliverable)){ ?>
								<td><?php echo $this->admin_model->getLeFormat($row->linguist);?></td>
								<td><?php echo $this->admin_model->getLeFormat($row->deliverable);?></td>
							<?php }else{ ?>
								<td><?=$row->linguist ?></td>
								<td><?=$row->deliverable ?></td>
							<?php } ?>	
								
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
								
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>le/viewLETask?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Job
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && ($row->status == 0 || $row->status == 3)){ ?>
									<a href="<?php echo base_url()?>le/editJob?t=<?php echo 
									base64_encode($task->id) ;?>&j=<?=base64_encode($row->id)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>le/deleteJob?t=<?php echo 
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