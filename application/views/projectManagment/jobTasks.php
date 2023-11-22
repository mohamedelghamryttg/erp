<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	function hideDiv() {
		// $("#dtpTasks").hide();
      	// $("#vendorTasks").hide();
      	// $("#translationTasks").hide();
      	// $("#leTasks").hide();
	}
	window.onload = hideDiv;
</script>

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Job Tasks
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
							<span class=" btn-primary" style="">
								Job Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                 <th>Job Code</th>
                             	 <th>Product Line</th>
                             	 <th>Service</th>
                             	 <th>Source</th>
                             	 <th>Target</th>
                             	 <th>Volume</th>
                             	 <th>Rate</th>
                             	 <th>Total Revenue</th>
                             	 <th>Currency</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                             	 <th>Status</th>
                             	 <th>Closed Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
							</tr>
						</thead>
						<tbody>
                          	<?php $total_revenue = $this->sales_model->calculateRevenueJob($job_data->id,$job_data->type,$job_data->volume,$priceList->id); ?>
							<tr class="">
                                <td><a href="<?=base_url()?>projectManagment/projectJobs?t=<?=base64_encode($job_data->project_id)?>"><?=$job_data->code?></a></td>
								<td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
								<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
								<?php if($job_data->type == 1){ ?>
				                <td><?php echo $job_data->volume ;?></td>
				                <?php }elseif ($job_data->type == 2) { ?>
				                <td><?php echo $total_revenue / $priceList->rate ;?></td>
				                <?php } ?>
								<td><?php echo $priceList->rate ;?></td>
								<td><?=$total_revenue?></td>
								<td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
								<td><?php echo $job_data->start_date ;?></td>
								<td><?php echo $job_data->delivery_date ;?></td>
								<td><?php echo $this->projects_model->getJobStatus($job_data->status) ;?></td>
								<td><?php echo $job_data->closed_date ;?></td>
								<td><?php echo $this->admin_model->getAdmin($job_data->created_by) ;?></td>
								<td><?php echo $job_data->created_at ;?></td>
							</tr>
						</tbody>
					</table>
				</div>
          </div>

</div>

</div>


<?php if($priceList->service == 23){ ?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter2" onclick="showAndHide('dtpTasks','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
				DTP Tasks
			</header>

			<div id="dtpTasks" class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $job_data->status == 0){ ?>
								<a href="<?=base_url()?>projectManagment/dtpRequest?t=<?=base64_encode($job)?>" class="btn btn-primary ">DTP Request</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Task Code</th>
                              	<th>Task Subject</th>
                              	<th>Task Type</th>
                              	<th>Unit</th>
                              	<th>Volume</th>
                              	<th>Source Language Direction</th>
                              	<th>Target Language Direction</th>
                              	<th>Source Application</th>
                              	<th>Target Application</th>
                              	<th>Translatio In</th>
                              	<th>Rate</th>
                                <th>Work Hours</th>
                                    <th>Overtime Hours</th>
                                    <th>Double Paid Hours</th>
                              	<th>Total Cost in $</th>
                              	<th>File Attachment</th>
                             	<th>Start Date</th>
                             	<th>Delivery Date</th>
                             	<th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>View Task</th>
								<th>Edit</th>
                            	<th>Cancel </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php 
                           if(isset($dtp_request)){
                           foreach ($dtp_request->result() as $row) {
                           	    $dateArray = explode("-", $row->created_at);
                                $year = $dateArray[0];
                                $rateProduction = $this->db->get_where('production_team_cost',array('unit'=>$row->unit,'year'=> $year,'brand'=>$this->brand,'team'=> 3))->row()->rate;
                                $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1,2,$row->created_at,$rateProduction),2);
                      ?>
							<tr>
								<td>DTP-<?=$row->id?></td>
								<td><?=$row->task_name?></td>
								<td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
								<td><?=$this->admin_model->getUnit($row->unit)?></td>
								<td><?=$row->volume?></td>
								<td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->source_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->target_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->translation_in)?></td>
								<td><?=$row->rate?></td>
                                                                <td><?= $row->work_hours ?></td>
                                                                <td><?= $row->overtime_hours ?></td>
                                                                <td><?= $row->doublepaid_hours ?></td>                                           
                                                                <td><?= round($this->projects_model->getTaskCost(3,$row),2) ?></td>
								<!--<td><?php echo $rateTrnasfared*$row->volume; ?></td>-->
								<td><?php if (strlen($row->file) > 1) { ?>
                                                                        <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/dtpRequest/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                                                    <?php } else{
                                                                        if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                                                            <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                                                    <?php }} ?>
                                                                </td>
								<td><?=$row->start_date?></td>
								<td><?=$row->delivery_date?></td>
								<td><?=$this->projects_model->getDTPTaskStatus($row->status)?></td>
								<td><?=$this->admin_model->getAdmin($row->created_by)?></td>
								<td><?=$row->created_at?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>projectManagment/dTPTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && ($row->status == 1 || $row->status == 5)){ ?>
									<a href="<?php echo base_url()?>projectManagment/editDtpTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
                            	<td>
									<?php if($permission->edit == 1 && ($row->status == 1 || $row->status == 5)){ ?>
									<a href="<?php echo base_url()?>projectManagment/cancelDTPRequest?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="Cancel" 
									class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
										<i class="fa fa-times text-danger text"></i> Cancel
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<!-- <a href="<?php echo base_url()?>projectManagment/deleteTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a> -->
									<?php } ?>
								</td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
</div>
<?php } ?>

<?php if($priceList->service == 1){ ?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter3" onclick="showAndHide('translationTasks','button_filter3');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
				Translation Tasks
			</header>

			<div id="translationTasks" class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $job_data->status == 0){ ?>
								<a href="<?=base_url()?>projectManagment/addTranslationTask?t=<?=base64_encode($job)?>" class="btn btn-primary ">Translation Request</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                        <th>Task Code</th>
                     	<th>Task Subject</th>
                     	<th>Task Type</th>
                    	   <th>Count</th>
                    	   <th>TM</th>
                    	   <th>Net word count</th>
                    	   <th>Unit</th>
                           <th>Work Hours</th>
                                    <th>Overtime Hours</th>
                                    <th>Double Paid Hours</th>
                    	   <th>Total Cost in $</th>
                    	   <th>Start Date</th>
                    	   <th>Delivery Date</th>
                    	   <th>Task File</th>
                    	   <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>View Task</th>
					         <th>Edit </th>
                   	   <th>Cancel </th>
					         <th>Delete</th>
							</tr>
						</thead>
						<tbody>
                    <?php 
                     if(isset($translation_request)){
                       foreach ($translation_request->result() as $row) { 
					
                  $dateArray = explode("-", $row->created_at);
                  $year = $dateArray[0];
                  $rateProduction = $this->db->get_where('production_team_cost',array('task_type'=>$row->task_type,'unit'=>$row->unit,'year'=> $year,'team'=> 1))->row()->rate;
                  $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1,2,$row->created_at,$rateProduction),2);

						?>
							<tr>
								<td>Translation-<?=$row->id?></a></td>
                        <td><?php echo $row->subject ;?></td>
								<td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
								<td><?php echo $row->count ;?></td>
								<td><?php echo $row->tm ;?></td>
								<td><?php echo $row->count - $row->tm ;?></td>
								<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                                                                 <td><?= $row->work_hours ?></td>
                                                                <td><?= $row->overtime_hours ?></td>
                                                                <td><?= $row->doublepaid_hours ?></td>                                           
                                                                <td><?= round($this->projects_model->getTaskCost(2,$row),2) ?></td>
								<!--<td><?php echo number_format($rateTrnasfared*$row->count,2); ?></td>-->
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								 <td><?php if (strlen($row->file) > 1) { ?>
                                                                        <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/translationRequest/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                                                    <?php } else{
                                                                         if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                                                             <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                                                     <?php }} ?>
                                                                 </td>
								<td><?php echo $this->projects_model->getTranslationTaskStatus($row->status) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>projectManagment/translationTask?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && ($row->status == 1 || $row->status == 5)){ ?>
									<a href="<?php echo base_url()?>projectManagment/editTranslationTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
    							<td>
									<?php if($permission->edit == 1 && ($row->status == 1 || $row->status == 5)){ ?>
									<a href="<?php echo base_url()?>projectManagment/cancelTranslationRequest?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="Cancel" 
									class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
										<i class="fa fa-times text-danger text"></i> Cancel
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<!-- <a href="<?php echo base_url()?>projectManagment/deleteTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a> -->
									<?php } ?>
								</td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
</div>
<?php } ?>


<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter1" onclick="showAndHide('vendorTasks','button_filter1');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
				Vendor Tasks
			</header>
			<div id="vendorTasks" class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $job_data->status == 0 ){ ?>
								<a href="<?=base_url()?>projectManagment/addTaskVendorModule?t=<?=base64_encode($job)?>" class="btn btn-primary ">Add New Task</a>
							</br></br></br>
						
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Task Code</th>
                              	<th>Task Subject</th>
                              	<th>Task Type</th>
                             	 <th>Vendor</th>
                             	 <th>Count</th>
                             	 <th>Unit</th>
                             	 <th>Rate</th>
                             	 <th>Total Cost</th>
                             	 <th>Currency</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                              	 <th>Time Zone</th>
                             	 <th>Task File</th>
                              	 <th>Vendor Task File</th>
                             	 <th>Status</th>
                             	 <th>Closed Date</th>
                             	 <th>VPO Status</th>
                             	 <th>Has Error</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            	<th>Re-open</th>
                                <th>View </th>
                                <th>Edit </th>
                                <th>Feedback </th>
                                <th>Delete</th>
                                <th>Cancel Task</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($task->result() as $row) { 
						?>
							<tr>
								<td><a href="<?=base_url()?>projectManagment/taskPage?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
                              	<td><?php echo $row->subject ;?></td>
								<td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
								<td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
								<td><?php echo $row->count ;?></td>
								<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
								<td><?php echo $row->rate ;?></td>
								<td><?php echo $row->rate * $row->count;?></td>
								<td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
                              	<td><?=$this->admin_model->getTimeZone($row->time_zone)?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/taskFile/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                              	<td><?php if(strlen($row->vendor_task_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/vendorTaskFile/<?=$row->vendor_task_file?>" target="_blank">Click Here</a><?php } ?></td>
								<td>
                                                                    <?php echo $this->projects_model->getJobStatus($row->status) ;?>
                                                                    
                                                                 <?php if($permission->view == 1 && $row->job_portal == 1 && $row->status == 5 ){ ?>
                                                                    <p class="text-center">   <a href="<?php echo base_url()?>projectManagment/pmDirectConfirm?task_id=<?php echo 
                                                                    base64_encode($row->id) ;?>" class="btn btn-sm btn-default mt-2"onclick="return confirm('Are you sure you want to Confirm this Task ?');">
                                                                            <i class="fa fa-check-circle  text-success text"></i> Confirm
                                                                        </a></p>
                                                                    <?php } ?>
                                                                </td>
								<td><?php echo $row->closed_date ;?></td>
								<td><?=$this->accounting_model->getPOStatus($row->verified)?></td>
								<td>
								<?php if($row->verified == 2){
										$errors = explode(",", $row->has_error);
										for ($i=0; $i < count($errors); $i++) { 
											if($i > 0){echo " - ";}
										 	echo $this->accounting_model->getError($errors[$i]);
										 } 
									 } ?>
								</td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>                                                               
                                                                <td>
                                                                    <?php if($permission->edit == 1 && $row->status == 1 && $row->verified != 1 && $job_data->status == 0){ ?>
                                                                    <a href="<?php echo base_url()?>projectManagment/reopenTask?t=<?php echo 
                                                                    base64_encode($row->id) ;?>&p=<?=base64_encode($job_data->status)?>" class="" onclick="return confirm('Are you sure you want to Re-open this Task ?');">
                                                                            <i class="fa fa-undo"></i> Re-open
                                                                    </a>
                                                                    <?php } ?>
								</td>								
                                                                 <td>
                                                                    <?php if($permission->view == 1 && $row->job_portal == 1 ){ ?>
                                                                     <a href="<?php echo base_url()?>projectManagment/viewTask?t=<?php echo 
                                                                    base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
                                                                            <i class="fa fa-eye"></i> View
                                                                    </a>
                                                                    <?php } ?>
								</td>
								<td>
                                                                    <?php if($permission->edit == 1 && ( $row->status == 0 || $row->status == 4 || $row->status == 3)){ ?>
                                                                    <a href="<?php echo base_url()?>projectManagment/editTask?t=<?php echo 
                                                                    base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
                                                                            <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    <?php } ?>
								</td>
								<td>
                                                                    <?php 
                                                                    $feedback = $this->db->get_where('task_feedback',array('task_id'=>$row->id))->num_rows();
                                                                    if($permission->edit == 1 && ( $row->status == 1 && $feedback == 0)){ ?>
                                                                    <a href="<?php echo base_url()?>projectManagment/addTaskFeedback?t=<?php echo 
                                                                    base64_encode($row->id) ;?>" class="">
                                                                            <i class="fa fa-star"></i> Add Feedback
                                                                    </a>
                                                                    <?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status != 1){ ?>
									<a href="<?php echo base_url()?>projectManagment/deleteTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a>
									<?php } ?>
								</td>								<td>
									<?php if($permission->edit == 1 && $row->status != 1){ ?>
									<a href="<?php echo base_url()?>projectManagment/cancelTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="Cancel" 
									class="" onclick="return confirm('Are you sure you want to Cancel this Task ?');">
										<i class="fa fa-times text-danger text"></i> Cancel
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

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter2" onclick="showAndHide('leTasks','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
				LE Tasks
			</header>

			<div id="leTasks" class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $job_data->status == 0){ ?>
								<a href="<?=base_url()?>projectManagment/addLeTask?t=<?=base64_encode($job)?>" class="btn btn-primary ">LE Request</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Task Code</th>
                              	<th>Task Subject</th>
                              	<th>Task Type</th>
                              	<th>Subject Matter</th>
                                <th>Work Hours</th>
                                <th>Overtime Hours</th>
                                <th>Double Paid Hours</th>
                              	<th>Total Cost in $</th>
                              	<th>Start Date</th>
                             	<th>Delivery Date</th>
                             	<th>Task File</th>
                             	<th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Task</th>
                                <th>Edit </th>
                            	<th>Cancel </th>
				<th>Delete</th>
							</tr>
						</thead>
						<tbody>
                <?php 
                    if(isset($le_request)){
                    foreach ($le_request->result() as $row) { 
                    	$dateArray = explode("-", $row->created_at);
                        $year = $dateArray[0];
                        $rateProduction = $this->db->get_where('production_team_cost',array('unit'=>$row->unit,'year'=> $year,'team'=> 2))->row()->rate;
                        $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1,2,$row->created_at,$rateProduction),2);
                    ?>
							<tr>
								<td>LE-<?=$row->id?></td>
                              	<td><?php echo $row->subject ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
								<td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
								<!--<td><?php echo $rateTrnasfared*$row->volume; ?></td>-->
                                                                 <td><?= $row->work_hours ?></td>
                                            <td><?= $row->overtime_hours ?></td>
                                            <td><?= $row->doublepaid_hours ?></td>                                            
                                            <td><?= round($this->projects_model->getTaskCost(4,$row),2) ?></td>
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								 <td><?php if (strlen($row->file) > 1) { ?>
                                                                        <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/leRequest/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                                                    <?php } else{
                                                                        if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                                                            <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                                                    <?php }} ?>
                                                                </td>
								<td><?php echo $this->projects_model->getLETaskStatus($row->status) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>projectManagment/leTask?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && ($row->status == 1 || $row->status == 5)){ ?>
									<a href="<?php echo base_url()?>projectManagment/editLeTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
    							<td>
									<?php if($permission->edit == 1 && ($row->status == 1 || $row->status == 5)){ ?>
									<a href="<?php echo base_url()?>projectManagment/cancelLERequest?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="Cancel" 
									class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
										<i class="fa fa-times text-danger text"></i> Cancel
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<!-- <a href="<?php echo base_url()?>projectManagment/deleteTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a> -->
									<?php } ?>
								</td>
							</tr>
						<?php }} ?>
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
				<button id="button_filter2" onclick="showAndHide('Commission','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
				Commission
			</header>

			<div id="leTasks" class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $job_data->status == 0){ ?>
								<a href="<?=base_url()?>projectManagment/addCommission?t=<?=base64_encode($job)?>" class="btn btn-primary ">Add Commission</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>ID</th>
                              	<th>Name</th>
                              	<th>Rate</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($project_comission->result() as $row) { 
						?>
							<tr>
								<td><?=$row->id?></td>
                              	<td><?php echo $this->projects_model->getCommissionName($row->commission) ;?></td>
                              	<td><?php echo $row->rate ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>projectManagment/editCommission?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1){ ?>
									<!-- <a href="<?php echo base_url()?>projectManagment/deleteTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a> -->
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

</div>

</div>
<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>