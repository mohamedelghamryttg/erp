<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Opportunities Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="opportunityForm" action="<?php echo base_url()?>sales/opportunity" method="get" enctype="multipart/form-data">
			 	<?php 
				   if(isset($_REQUEST['project_name'])){
                    $project_name = $_REQUEST['project_name'];
                   }else{
                    $project_name = "";
                   }
					if(isset($_REQUEST['id'])){
						$id = $_REQUEST['id'];
					}else{
						$id = "";
					}
					if(isset($_REQUEST['customer'])){
						$customer = $_REQUEST['customer'];
					}else{
						$customer = "";
					}
					if(isset($_REQUEST['project_status'])){
						$project_status = $_REQUEST['project_status'];
					}else{
						$project_status = "";
					}
					if(isset($_REQUEST['created_by'])){
						$created_by = $_REQUEST['created_by'];
					}else{
						$created_by = "";
					}
				?>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Project Name</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control"value="<?=$project_name?>" name="project_name">
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Customer</label>

                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" />
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectExistingCustomerBySam($customer,$user,$permission,$this->brand)?>
                        </select>
                    </div>

                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Project Status</label>
					<div class="col-lg-3">
                        <select name="project_status" class="form-control m-b" id="project_status"/>
                                 <option value="">-- Select Status --</option>
                                 <?=$this->sales_model->SelectProjectStatus($project_status)?>
                        </select>
                    </div>
					<label class="col-lg-2 control-label" for="role Task Type">Created By</label>
					<div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by"/>
                                 <option value="">-- Select SAM --</option>
                                 <?=$this->customer_model->selectAllSam($created_by,$this->brand)?>
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
                    <label class="col-lg-2 control-label" for="role name">Opportunity Number</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value="<?=$id?>" name="id">
                    </div>
                </div>   
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                  		<button class="btn btn-success" onclick="var e2 = document.getElementById('opportunityForm'); e2.action='<?=base_url()?>sales/exportOpportunity'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
					  <a href="<?=base_url()?>sales/opportunity" class="btn btn-warning">(x) Clear Filter</a> 

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
				Opportunities
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
							<a href="<?=base_url()?>sales/addOpportunity" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
							  <tr>
								<th>Opportunity Number</th>
								<th>Project Name</th>
								<th>Project Status</th>
								<th>Customer</th>
								<th>Brand</th>
								<th>Region</th>
								<th>Country</th>
                              	<th>PM</th>
                                <th>Status</th>
                                <th>Assign</th>
                                <th>Tickets</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($opportunity->result() as $row)
								{
									$leadData = $this->customer_model->getLeadDataByCustomer($row->lead);
                              		$customerData = $this->db->get_where('customer',array('id' => $row->customer))->row();
                            		$jobs = $this->db->get_where('job',array('opportunity'=>$row->id))->num_rows();
						?>
									<tr class="">
										<td><?php echo $row->id ;?></td> 
										<td><a href="<?=base_url()?>sales/viewOpportunityJob?t=<?=base64_encode($row->id)?>"><abbr title="<?=$row->project_name?>"><?=character_limiter($row->project_name,10)?></abbr></a></td>
										<td><?php echo $this->sales_model->getProjectStatus($row->project_status) ;?></td>
										<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
										<td><?php echo $this->admin_model->getBrand($customerData->brand);?></td>
										<td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
										<td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
                                    	<td><?php echo $this->admin_model->getAdmin($row->pm) ;?></td>
                                      	<td>
                                      		<?php 
                                      		if($row->saved == 0 && $row->assigned == 1){
                                      			echo '<span class="badge badge-danger p-2" style="background-color: #07199b">Still Not Saved</span>';
                                      		}else if($row->saved == 1){
                                      			echo '<span class="badge badge-danger p-2" style="background-color: #07b817">Saved As A project</span>';
                                      		}elseif ($row->saved == 2) {
                                      			echo '<span class="badge badge-danger p-2" style="background-color: #fb0404">Opportunity Rejected</span>';
                                      		}
                                      		?>
                                      	</td>
										<td>
                                         	<?php if($row->project_status == 1 && $jobs >= 1){ ?>
                                         	<?php if($row->assigned == 0 || $row->saved == 2){ ?>
                                         		<a class="btn btn-primary" onclick="return confirm('Are you sure you want to Assign this Opportunity to PM ?');" href="<?php echo base_url()?>sales/assignOpportunity?t=<?php echo base64_encode($row->id); ?>&lead=<?=base64_encode($row->lead)?>" title="Assign" style="color:#fff">
                                                Assign
                                                </a>
                                            <?php }else{ ?>
                                            	Opportunity Assigned 
                                            <?php } ?>
                                            <?php } ?>
                                      	</td>
                                      	<td>
                                      		<?php if($row->assigned == 0 || $row->saved == 2){ ?>
                                         		<a class="btn btn-primary" href="<?php echo base_url()?>vendor/vmTicket?t=<?php echo base64_encode($row->id); ?>" title="Add Tickets" style="color:#fff">
                                                Add Tickets
                                                </a>
                                            <?php } ?>
                                      	</td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<?php if($permission->edit == 1 && $row->assigned == 0){ ?>
											<a href="<?php echo base_url()?>sales/editOpportunity?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if($permission->delete == 1 && $row->assigned == 0){ ?>
											<a href="<?php echo base_url()?>sales/deleteOpportunity?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Opportunity ?');">
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