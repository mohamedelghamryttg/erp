<form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/closeJob" onsubmit="return checkJobVerifyForm();" method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Close Jobs
			</header>
			
			<div class="panel-body">
			 	<input type="text" name="project_id" value="<?=base64_encode($project_data->id)?>" hidden="">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role File Attachment">CPO Attachment</label>

                    <div class="col-lg-3">
                        <input type="file" class=" form-control" name="cpo_file" id="cpo_file" required="" accept="'application/zip'">
                    </div>
                    <label class="col-lg-2 control-label">PO Number</label>

                    <div class="col-lg-3">
                        <input type="text" class=" form-control" name="po" id="po" required>
                    </div>
            	</div>
                <div class="form-group">
                	<div class="col-lg-4"></div>
                    <div class="col-lg-6">
                        <input type="submit" style="margin-right: 5rem;" name="save" value="Save Changes" class="btn btn-primary">
                        <a class="btn btn-success " onclick="checkAll()" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
						<a class="btn btn-danger " onclick="unCheckAll()" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                    </div>
                	<div class="col-lg-2"></div>
                </div>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Project Jobs
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
								Project Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                 <th>Project Code</th>
                              	 <th>Project Name</th>
                             	 <th>Client</th>
                             	 <th>Product Line</th>
                             	 <th>View Tickets</th>
                             	 <th>Created By</th>
                                 <th>Created At</th>
							</tr>
						</thead>
						
						<tbody>
							<tr class="">
                              <td><?php echo $project_data->code?></td>
                              <td><?php echo $project_data->name?></td>
                              <td><?php echo $this->customer_model->getCustomer($project_data->customer);?></td>
                              <td><?php echo $this->customer_model->getProductLine($project_data->product_line);?></td>
                              <td>
                              	<?php if($project_data->status == 0){ ?>
									<a class="btn btn-primary" href="<?php echo base_url()?>vendor/vmPmTicket?t=<?php echo base64_encode($project_data->id); ?>" title="Add Tickets" style="color:#fff">View Tickets</a>
								<?php } ?>
								</td>
                              <td><?php echo $this->admin_model->getAdmin($project_data->created_by);?></td>
                              <td><?php echo $project_data->created_at ;?></td>
							</tr>
						</tbody>
					</table>
				</div>
          </div>
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1 && $project_data->status == 0){ ?>
								<a href="<?=base_url()?>projects/addJob?t=<?=base64_encode($project)?>" class="btn btn-primary ">Add New Job</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
								<th>#</th>
                              	<th>Job Code</th>
                              	<th>Job Name</th>
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
                             	 <th>PO Number</th>
                             	 <th>CPO File</th>
                              	<th>PO Status</th>
                              	<th>PO Status Date</th>
	                         	 <th>Has Error</th>
                             	 <th>Closed Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            	<th>Re-open</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($job->result() as $row) { 
							$priceList = $this->projects_model->getJobPriceListData($row->price_list);
  							$total_revenue = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
							//$check = $this->projects_model->checkCloseJob($row->id);
							$poData = $this->projects_model->getJobPoData($row->po);
						?>
							<tr>
								<td>
								<?php //if(($check || $row->job_type == 1) && $row->status != 1){ 
								if($row->status != 1){ ?>
									<input type="checkbox" class="checkPo" name="select[]" value="<?=$row->id?>">
								<?php } ?>
								</td>
								<td><a href="<?=base_url()?>projects/jobTasks?t=<?=base64_encode($row->id)?>"><?=$row->code?></a>
                                                                <?php if($row->job_type=="1"){
                                                                    echo "<p class='text-center mt-2'><span class='label label-danger'>Free Job</span></p>";
                                                                    if(strlen($row->attached_email) > 1 && $row->job_type == "1"){ 
                                                                        echo '<p class="text-center"><a href="<?=base_url()?>assets/uploads/jobFile/<?=$row->attached_email?>" target="_blank">Email Attachment</a></p>';
                                                                    }
                                                                }?></td>
                              	<td><?php echo $row->name ;?></td>
								<td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
								<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
								<?php if($row->type == 1){ ?>
				                <td><?php echo $row->volume ;?></td>
				                <?php }elseif ($row->type == 2) { ?>
				                <td><?php echo $total_revenue / $priceList->rate ;?></td>
				                <?php } ?>
								<td><?php echo $priceList->rate ;?></td>
								<td><?=$total_revenue?></td>
								<td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								<td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
								<td><?php if(isset($poData)){ echo $poData->number; }?></td>
								<td><?php 
								if(isset($poData)){ ?><a href="<?=base_url()?>assets/uploads/cpo/<?=$poData->cpo_file?>" target="_blank">Click Here</a><?php } ?></td>
                              	<td><?php if(isset($poData)){$this->accounting_model->getPOStatus($poData->verified); } ?></td>
                              	<td><?= $poData->verified_at ?></td>
								<td>
								<?php if(isset($poData)){
										if($poData->verified == 2){
											$errors = explode(",", $poData->has_error);
											for ($i=0; $i < count($errors); $i++) { 
												if($i > 0){echo " - ";}
											 	echo $this->accounting_model->getError($errors[$i]);
											 }
										 }} ?>
								</td> 
									<?php if($row->status == 0) { ?>
					                    <td> </td>
					                 <?php }elseif ($row->status == 1) { ?>
					                    <td><?php echo $row->closed_date ;?></td>
					                <?php } ?>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
                            	<td>
									<?php if($permission->edit == 1 && $row->status == 1 && $poData->verified != 1){ ?>
									<a href="<?php echo base_url()?>projects/reopenJob?t=<?php echo 
									base64_encode($row->id) ;?>&p=<?=base64_encode($poData->id)?>" class="" onclick="return confirm('Are you sure you want to Re-open this Job ?');">
										<i class="fa fa-undo"></i> Re-open
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>projects/editJob?t=<?php echo 
									base64_encode($row->id) ;?>&p=<?=base64_encode($row->project_id)?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>projects/deleteJob?t=<?php echo 
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