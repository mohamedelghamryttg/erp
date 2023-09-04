<?php if($task_data->status == 0){ ?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Close Task
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/closeTask" method="post" enctype="multipart/form-data">
			 	<input type="text" name="id" value="<?=base64_encode($task_data->id)?>" hidden="">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Close Task</label>

                     <div class="col-lg-3">
                        <select name="status" class="form-control m-b" id="status" required=""/>
                                 <option disabled="disabled" selected="selected" value="">-- Close Task --</option>
                                 <option value="1">Delivered</option>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role File Attachment">Vendor Task File</label>

                    <div class="col-lg-3">
                        <input type="file" class=" form-control" name="vendor_task_file" id="vendor_task_file" required="" accept="'application/zip'">
                    </div>
                </div>

                <div class="form-group">
                	<div class="col-lg-3">
                        <button class="btn btn-primary" name="save" type="submit">Save Changes</button>
                    </div>
                </div>
              </form>
			</div>
		</section>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Task Page
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
          		<div class="adv-table editable-table " style="overflow: scroll;">
					<div class="clearfix">
						<div class="btn-group">
							<span class=" btn-primary" style="">
								Task Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
						<thead>
							<tr>
                                 <th>Task Code</th>
                              	<th>Task Type</th>
                             	 <th>Vendor</th>
                             	 <th>Count</th>
                             	 <th>Unit</th>
                             	 <th>Rate</th>
                             	 <th>Total Cost</th>
                             	 <th>Currency</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                             	 <th>Task File</th>
                              	 <th>Vendor Task File</th>
                             	 <th>Status</th>
                             	 <th>Closed Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
							</tr>
						</thead>
						
						<tbody>
							<tr class="">
                                <td><a href="<?=base_url()?>projects/jobTasks?t=<?=base64_encode($task_data->job_id)?>"><?=$task_data->code?></a></td>
								<td><?php echo $this->admin_model->getTaskType($task_data->task_type);?></td>
								<td><?php echo $this->vendor_model->getVendorName($task_data->vendor);?></td>
								<td><?php echo $task_data->count ;?></td>
								<td><?php echo $this->admin_model->getUnit($task_data->unit) ;?></td>
								<td><?php echo $task_data->rate ;?></td>
								<td><?php echo $task_data->rate * $task_data->count;?></td>
								<td><?php echo $this->admin_model->getCurrency($task_data->currency) ;?></td>
								<td><?php echo $task_data->start_date ;?></td>
								<td><?php echo $task_data->delivery_date ;?></td>
								<td><?php if(strlen($task_data->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/taskFile/<?=$task_data->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php if(strlen($task_data->vendor_task_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/vendorTaskFile/<?=$task_data->vendor_task_file?>" target="_blank">Click Here</a><?php } ?></td>
                              	<td><?php echo $this->projects_model->getJobStatus($task_data->status) ;?>
                                 <?php if($permission->view == 1 && $task_data->job_portal == 1 && $task_data->status == 5 ){ ?>
                                                                    <p class="text-center">   <a href="<?php echo base_url()?>projects/pmDirectConfirm?task_id=<?php echo 
                                                                    base64_encode($task_data->id) ;?>" class="btn btn-sm btn-default mt-2"onclick="return confirm('Are you sure you want to Confirm this Task ?');">
                                                                            <i class="fa fa-check-circle  text-success text"></i> Confirm
                                                                        </a></p>
                                                                    <?php } ?>
                                </td>
								<td><?php echo $task_data->closed_date ;?></td>
								<td><?php echo $this->admin_model->getAdmin($task_data->created_by) ;?></td>
								<td><?php echo $task_data->created_at ;?></td>
							</tr>
						</tbody>
					</table>
				</div>
          </div>
			
		</section>
	</div>
</div>

<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>