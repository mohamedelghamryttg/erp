<script type="text/javascript">
	function hideDiv() {
		$("#filter").hide();
      	$("#filter2").hide();
	}
    window.onload = hideDiv;
</script>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter2" onclick="showAndHide('filter2','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down btn btn-success mr-2"></i></button>
				 DTP Requests Waiting Confimation - <span class="numberCircle"><span><?=$newTasks->num_rows()?></span></span>
			</header>
			
			<div id="filter2" class="panel-body" style="overflow:scroll;">
			 <table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
								<th>PM</th>
								<th>Task Type</th>
                                 <th>Product line</th>
                             	 <th>Task Name</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                             	 <th>Created Date</th>
                                 <th>View Task</th>
							</tr>
						</thead>
							<?php foreach ($newTasks->result() as $row) { 
								$jobData = $this->projects_model->getJobData($row->job_id);
								$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);

							?>
								<tr>
									<td><?=$this->admin_model->getAdmin($row->created_by)?></td>
									<td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
									<td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
									<td><?=$row->task_name?></td>
									<td><?=$row->start_date?></td>
									<td><?=$row->delivery_date?></td>
									<td><?=$row->created_at?></td>
									<td>
									<?php if($permission->add == 1){ ?>
										<a href="<?php echo base_url()?>dtp/saveRequest?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-eye"></i> View Task
										</a>
									<?php } ?>
									</td>
								</tr>
							<?php } ?>
						<tbody>
										
						</tbody>
					</table>
			</div>
		</section>
	</div>
</div>

 <div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button> Request Filter
			</header>
	<?php 
		       if(!empty($_REQUEST['code'])){
                $code = $_REQUEST['code'];
                }else{
                    $code = "";
                }

                if(!empty($_REQUEST['pm'])){
                    $pm = $_REQUEST['pm'];
                }else{
                    $pm = "";
                }

                if(!empty($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                }else{
                    $date_to = "";
                    $date_from = "";
                }

			?>
			
			
			<div id="filter" class="panel-body">
			  <form class="cmxform form-horizontal " id="dtpRequestForm" action="<?php echo base_url()?>dtp/" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Request Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="code" value="<?=$code?>">
                    </div>
                    <label class="col-lg-2 control-label" for="role name">Requestor Name</label>

                     <div class="col-lg-3">
                        <select name="pm" class="form-control m-b" id="pm" />
                                 <option value="" disabled="disabled" selected="selected">-- Select Requestor --</option>
                                 <?=$this->admin_model->selectAllPm($pm,$this->brand)?>
                        </select>
                    </div>
                </div>

         		<div class="form-group">
		            <label class="col-lg-2 control-label" for="role date">Date From</label>
		            <div class="col-lg-3">
		                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
		            </div>
		            <label class="col-lg-2 control-label" for="role date">Date To</label>
		            <div class="col-lg-3">
		                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
		            </div>
		        </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpRequestForm'); e2.action='<?=base_url()?>dtp/exportRequests'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>dtp" class="btn btn-warning">(x) Clear Filter</a> 
                  </div>
              </div>      
              </form>
			</div>
		</section>
	</div>
</div> 
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				All Tasks <span class="numberCircle"><span><?=$total_rows?></span></span>
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
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Task Code</th>
                              	<th>PM</th>
                                <th>Task Name</th>
                                <th>Task Type</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Source Language</th>
                                <th>Target Language</th>
                                <th>File Attachment</th>
                                <th>Status</th>
                                <th>View Jobs</th>
								<th>View Request</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($dtp_request->result() as $row) { 
								$jobData = $this->projects_model->getJobData($row->job_id);
            					$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
								if($row->source_language == 0){
                                	$source = $priceListData->source;
                                	$target = $priceListData->target;
                                }else{
                                	$source = $row->source_language;
                                	$target = $row->target_language;
                                }
							?>
							<tr>
								<td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($row->id) ;?>" class="">DTP-<?=$row->id?></a></td>
								<td><?=$this->admin_model->getAdmin($row->created_by)?></td>
								<td><abbr title="<?=$row->task_name?>"><?=character_limiter($row->task_name,10)?></abbr></td>
								<td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
								<td><?=$row->volume?></td>
								<td><?=$this->admin_model->getUnit($row->unit)?></td>
								<td><?=$this->admin_model->getLanguage($source)?></td>
                            	<td><?=$this->admin_model->getLanguage($target)?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?=$this->projects_model->getDTPTaskStatus($row->status)?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Jobs
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>dtp/viewRequest?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Request
									</a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
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

<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>