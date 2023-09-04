<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="businessReviewsForm" action="<?php echo base_url()?>sales/businessReviews" method="get" enctype="multipart/form-data">
			 	<?php 
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
                if(isset($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = "";
                }
                
				?>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Number #</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control"value = "<?= $id ?>" name="id">
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Customer</label>

                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" />
                                 <option value="" >-- Select Customer --</option>
                                 <?php if($permission->view == 1){ ?>
                                 <?=$this->customer_model->selectExistingCustomerBySam($customer,$this->user,$permission,$this->brand)?>
                                 <?php }else{
                                    if($this->role == 2){
                                        echo $this->customer_model->selectCustomerByPm($customer,$this->user,$permission,$this->brand);
                                    }elseif($this->role == 3){
                                        echo $this->customer_model->selectExistingCustomerBySam($customer,$this->user,$permission,$this->brand);
                                    }
                                    ?>
                                 <?php } ?>
                        </select>
                    </div>

                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Type</label>
					<div class="col-lg-3">
                        <select name="type" class="form-control m-b" id="type"/>
						  <option value="">-- Select Type --</option>
							<?php 
							if($_REQUEST['type'] == 1 ){?>
								<option selected="" value = "<?=$_REQUEST['type']?>">SLA</option>
								<option  value = "2">SIP</option>
							<?php }elseif($_REQUEST['type'] == 2){ ?>
									<option selected="" value = "<?=$_REQUEST['type']?>">SIP</option>
									<option  value = "1">SLA</option>

							<?php }else{?>
								<option  value = "1">SLA</option>
								<option  value = "2">SIP</option>

							<?php }?>
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
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                         <button class="btn btn-success" onclick="var e2 = document.getElementById('businessReviewsForm'); e2.action='<?=base_url()?>sales/exportBusinessReviews'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
 						 <a href="<?=base_url()?>sales/businessReviews" class="btn btn-warning">(x) Clear Filter</a> 

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
				Business Reviews
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
							<a href="<?=base_url()?>sales/addBusinessReviews" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
							  <tr>
								<th>Number #</th>
								<th>Customer</th>
								<th>Region</th>
								<th>Country</th>
								<th>Contact Name</th>
								<th>Contact Method</th>
								<th>Type</th>
								<th>SLA Reason</th>
								<th>SLA Attachment</th>
								<th>SIP Issue</th>
								<th>SIP Reason</th>
								<th>SIP Improvement Owner</th>
								<th>SIP Proposed Solution</th>
								<th>SIP Due Date For Final Feedback</th>
								<th>SIP Status Of Resolution</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($business->result() as $row)
								{
									$leadData = $this->customer_model->getLeadDataByCustomer($row->lead);
									$contactData = $this->db->get_where('customer_contacts',array('id'=>$row->contact_id))->row();
						?>
									<tr class="">
										<td><?php echo $row->id ;?></td> 
										<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
										<td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
										<td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
										<td><?=$contactData->name?></td>
										<td><?=$this->sales_model->getContactMethod($row->contact_method)?></td>
										<td><?php if($row->type == 1){echo "SLA";}elseif ($row->type == 2) {echo "SIP";}?></td>
										<td><?=$this->sales_model->getSlaReason($row->sla_reason)?></td>
										<td><?php if(strlen($row->sla_attachment) > 0){ echo "<a href=".base_url()."assets/uploads/slaAttachment/".$row->sla_attachment.">Click Me</a>"; }?></td>
										<td><?=$this->sales_model->getSipIssue($row->sip_issue)?></td>
										<td><?php echo $row->sip_reason ;?></td>
										<td><?=$this->admin_model->getUsersByMail($row->sip_improvement_owner)?></td>
										<td><?php echo $row->sip_proposed_solution ;?></td>
										<td><?php echo $row->sip_due_date ;?></td>
										<td><?php if($row->sip_status_resolution == 1){echo "Opened";}elseif ($row->sip_status_resolution == 2) {echo "Closed";}?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<?php if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>sales/editBusinessReviews?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if($permission->delete == 1){ ?>
											<!-- <a href="<?php echo base_url()?>sales/deleteOpportunity?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Opportunity ?');">
												<i class="fa fa-times text-danger text"></i> Delete
											</a> -->
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