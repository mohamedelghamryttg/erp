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
				Job Requests
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
                             	<th>Created By</th>
                                <th>Created At</th>
							</tr>
						</thead>
						<tbody>
                          	<?php $total_revenue = $this->sales_model->calculateRevenueJob($job_data->id,$job_data->type,$job_data->volume,$priceList->id); ?>
							<tr class="">
                                <td><a href="<?=base_url()?>projectPlanning/projectJobs?t=<?=base64_encode($job_data->plan_id)?>"><?=$job_data->name?></a></td>
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
						<?php if($permission->add == 1 && $job_data->status == 7){ ?>
								<a href="<?=base_url()?>projectPlanning/adddtpRequest?t=<?=base64_encode($job)?>" class="btn btn-primary ">DTP Request</a>
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
                                                            <th>Total Cost in $</th>
                                                            <th>File Attachment</th>
                                                            <th>Start Date</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Created By</th>
                                                            <th>Created At</th>
                                                            <th>View Task</th>							
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
								<td><?php echo $rateTrnasfared*$row->volume; ?></td>
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
									<a href="<?php echo base_url()?>projects/dTPTask?t=<?php echo 
									base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
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
                                        <?php if($permission->add == 1 && $job_data->status == 7){ ?>
                                                        <a href="<?=base_url()?>projectPlanning/addTranslationPlan?t=<?=base64_encode($job)?>" class="btn btn-primary ">Translation Request</a>
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
                                            <th>Total Cost in $</th>
                                            <th>Start Date</th>
                                            <th>Delivery Date</th>
                                            <th>Task File</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>View Task</th>                                                                                     
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
								<td><?php echo number_format($rateTrnasfared*$row->count,2); ?></td>
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
									<a href="<?php echo base_url()?>projects/translationTask?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
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
						<?php if($permission->add == 1 && $job_data->status == 7 ){ ?>
								<a href="<?=base_url()?>projectPlanning/addVendorRequest?t=<?=base64_encode($job)?>" class="btn btn-primary ">Add New Task</a>
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
                                                             <th>Status</th> 
                                                            <th>Created By</th>
                                                            <th>Created At</th>                                                            
								<th>View </th>
								
                                
							</tr>
						</thead>
						<tbody>
						<?php foreach ($task->result() as $row) { 
						?>
							<tr>
								<td><a href="<?=base_url()?>projects/taskPage?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
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
                                                                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?> </td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>                                                                   <td>
                                                                    <?php if($permission->view == 1 && $row->job_portal == 1 ){ ?>
                                                                     <a href="<?php echo base_url()?>projects/viewTask?t=<?php echo 
                                                                    base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
                                                                            <i class="fa fa-eye"></i> View
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
						<?php if($permission->add == 1 && $job_data->status == 7){ ?>
								<a href="<?=base_url()?>projectPlanning/addLeRequest?t=<?=base64_encode($job)?>" class="btn btn-primary ">LE Request</a>
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
                                                            <th>Total Cost in $</th>
                                                            <th>Start Date</th>
                                                            <th>Delivery Date</th>
                                                            <th>Task File</th>
                                                            <th>Status</th>
                                                            <th>Created By</th>
                                                            <th>Created At</th>
                                                            <th>View Task</th>								
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
								<td><?php echo $rateTrnasfared*$row->volume; ?></td>
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
									<a href="<?php echo base_url()?>projects/leTask?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
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

</div>
<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>