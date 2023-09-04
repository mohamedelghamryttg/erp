<form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/closeJob" onsubmit="return checkJobVerifyForm();" method="post" enctype="multipart/form-data">

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				DTP Request
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
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Task Code</th>
                              	<th>PM</th>
                                <th>Task Name</th>
                                <th>Task Type</th>
                                <th>Product line</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Source Language</th>
                                <th>Source Language Direction</th>
                                <th>Target Language</th>
                                <th>Target Language Direction</th>
                                <th>Source Application</th>
                                <th>Target Application</th>
                                <th>Translatio In</th>
                                <th>Rate</th>
                                <th>File Attachment</th>
                                <th>Start Delivery</th>
                                <th>Delivery Date</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Task Started At</th>
                                <th>View Jobs</th>
								<th>View Request</th>
							</tr>
						</thead>
						<tbody>
                        	<?php
								if($task->source_language == 0){
                                	$source = $priceListData->source;
                                	$target = $priceListData->target;
                                }else{
                                	$source = $task->source_language;
                                	$target = $task->target_language;
                                }
                        	?>
							<tr>
								<td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($task->id) ;?>" class="">DTP-<?=$task->id?></a></td>
								<td><?=$this->admin_model->getAdmin($task->created_by)?></td>
								<td><?=$task->task_name?></td>
								<td><?=$this->admin_model->getDTPTaskType($task->task_type)?></td>
								<td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
								<td><?=$task->volume?></td>
								<td><?=$this->admin_model->getUnit($task->unit)?></td>
								<td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
								<td><?=$this->admin_model->getUnit($task->unit)?></td>
								<td><?=$this->admin_model->getDTPDirection($task->source_direction)?></td>
								<td><?=$this->admin_model->getDTPDirection($task->target_direction)?></td>
								<td><?=$this->admin_model->getDTPApplication($task->source_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($task->target_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($task->translation_in)?></td>
								<td><?=$task->rate?></td>
								<td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?=$task->start_date?></td>
								<td><?=$task->delivery_date?></td>
								<td><?=$task->created_at?></td>
								<td><?=$this->projects_model->getDTPTaskStatus($task->status)?></td>
								<td><?=$this->admin_model->getAdmin($task->status_by)?></td>
								<td><?=$task->status_at?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo 
										base64_encode($task->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Jobs
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>dtp/viewRequest?t=<?php echo 
										base64_encode($task->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Request
									</a>
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
			
			<header class="panel-heading">
				DTP Jobs
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
								<a href="<?=base_url()?>dtp/addJob?t=<?=base64_encode($task->id)?>" class="btn btn-primary ">Add New Job</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                                <th>Task Code</th>
                                <th>Assigned DTP</th>
                              	<th>Task Type</th>
                                <th>Volume</th>
                                <th>Updated Volume</th>
                                <th>Unit</th>
                                <th>Source Language</th>
                                <th>Source Language Direction</th>
                                <th>Target Language</th>
                                <th>Target Language Direction</th>
                                <th>Source Application</th>
                                <th>Target Application</th>
                                <th>Translatio In</th>
                                <th>File Attachment</th>
                                <th>Start Delivery</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                             	 <th>View Job</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job->result() as $row) { ?>
							<tr class="">
                             	<td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($task->id) ;?>" class="">DTP-<?=$task->id?>-<?=$row->id?></a></td>
								<td><?php echo $this->admin_model->getAdmin($row->dtp) ;?></td>
								<td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
								<td><?=$row->volume?></td>
								<td><?=$row->updated_count?></td>
								<td><?=$this->admin_model->getUnit($row->unit)?></td>
								<td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
								<td><?=$this->admin_model->getLanguage($priceListData->target)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->source_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->target_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->translation_in)?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpJob/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?=$row->start_date?></td>
								<td><?=$row->delivery_date?></td>
								<td><?=$this->projects_model->getTranslationJobStatus($row->status)?></td>
								<td><?=$this->admin_model->getAdmin($row->created_by)?></td>
								<td><?=$row->created_at?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>dtp/viewDtpTask?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Job
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && ($row->status == 0 || $row->status == 3)){ ?>
									<a href="<?php echo base_url()?>dtp/editJob?t=<?php echo 
									base64_encode($task->id) ;?>&j=<?=base64_encode($row->id)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>dtp/deleteJob?t=<?php echo 
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