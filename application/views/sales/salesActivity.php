<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Activities Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="activityForm" action="<?php echo base_url()?>sales/salesActivity" method="get" enctype="multipart/form-data">
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
                    <label class="col-lg-2 control-label" for="role name">Customer</label>

                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" />
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerBySam($customer,$user,$permission,$this->brand)?>
                        </select>
                    </div>
             	
               		<?php if($permission->view == 1){ ?>
                    <label class="col-lg-2 control-label" for="role Task Type">Created By</label>
					<div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by"/>
                                 <option value="">-- Select SAM --</option>
                                 <?=$this->customer_model->selectAllSam($created_by,$this->brand)?>
                        </select>
                    </div>
              		<?php } ?>
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
		            <label class="col-lg-2 control-label" for="role date">Activity Number</label>
		            <div class="col-lg-3">
		                 <input class="form-control" type="text"  value="<?=$id?>" name="id" autocomplete="off">
		            </div>
		        </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('activityForm'); e2.action='<?=base_url()?>sales/exportActivities'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                       <a href="<?=base_url()?>sales/salesActivity" class="btn btn-warning">(x) Clear Filter</a> 
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
				Sales Activities
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
								<a href="<?=base_url()?>sales/addSalesActivity" class="btn btn-primary ">Add New Activity</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;" style="diplay:block;">
						<thead>
							<tr>
                              <th>Activity Number</th>
								<th>Customer</th>
                                 <th>Region</th>
                                 <th>Country</th>
                             	 <th>Customer Type</th>
                                 <th>Rolled In</th>
                                 <th>Contact Method</th>
                                 <th>Call Status</th>  
                                 <th>Assigned PM</th>  
								 <!-- <th>Contact Name</th> -->
                                <th>Created BY</th>
                                <th>Created At</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
							if($sales->num_rows() > 0)
							{
								foreach($sales->result() as $row)
								{
									$leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
                                  	$customerData = $this->db->get_where('customer',array('id'=>$row->customer))->row();
									?>
									<tr class="">
                                    	<td><?=$row->id?></td>
										<td>
                                          <a href="<?php echo base_url()?>sales/followUp?t=<?php echo base64_encode($row->id); ?>
											"><?php echo $this->customer_model->getCustomer($row->customer) ;?></a>
                                      </td>
                                      <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                                      <td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
                                      <td><?php echo $this->customer_model->getType($leadData->type);?></td>
                                      <td><?php if($row->rolled_in == 1){echo "Yes";}else if($row->rolled_in == 2){echo "No";}else{}?></td>
                                      <td><?php echo $this->sales_model->getContactMethod($row->contact_method);?></td>
                                      <td><?php echo $this->sales_model->getActivityStatus($row->status);?></td>
									  <!-- <td><?php echo $row->contact_id;?></td> -->
                                      <td><?php echo $this->admin_model->getAdmin($row->pm)?></td>
                                      <td><?php echo $this->admin_model->getAdmin($row->created_by)?></td>
                                      <td><?php echo $row->created_at?></td>
                                      <td>
                                        <?php if(($permission->edit == 1 && $permission->follow == 2) || ($permission->edit == 1 && $row->created_by == $user)){ ?>
											<a href="<?php echo base_url()?>sales/editSalesActivity?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
										<?php } ?>
                                      </td>
                                      <td>
                                        <?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
											<a href="<?php echo base_url()?>sales/deleteSalesActivity?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this activity ?');">
												<i class="fa fa-times text-danger text"></i> Delete
											</a>
										<?php } ?>
                                      </td>
									</tr>
									<?php
								}
							}
							else
							{
								?><tr><td colspan="7">There is no Activties in your list</td></tr><?php
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