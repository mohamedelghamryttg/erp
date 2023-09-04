<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
           Customer Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="customerfilter" action="<?php echo base_url()?>customer/" method="get" enctype="multipart/form-data">
			   <?php 
			      if(isset($_REQUEST['customer_name'])){
                    $customerName = $_REQUEST['customer_name'];
                }else{
                    $customerName = "";
                }
                if(isset($_REQUEST['website'])){
                    $website = $_REQUEST['website'];
                }else{
                    $website = "";
                }
                if(isset($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = "";
                }
                if(isset($_REQUEST['status'])){
                    $status = $_REQUEST['status'];
                }else{
                    $status = "";
                }
                if(isset($_REQUEST['alias'])){
                    $alias = $_REQUEST['alias'];
                }else{
                    $alias = "";
                }  
			   ?>
			    <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer Name</label>

                    <div class="col-lg-3">
                      <input class="form-control" type="text" value = "<?=$customerName ?>" name="customer_name" autocomplete="off">
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Website</label>

                    <div class="col-lg-3">
                      <input class="form-control" type="text"value = "<?=$website ?>" name="website" autocomplete="off">
                    </div>

                </div> 
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Status</label>

                    <div class="col-lg-3">
                        <select name="status"  class="form-control m-b"/>
                                 <option value="">-- Select status --</option>
                            <?php 
								if(isset($_REQUEST['status'])){?>
									<?=$this->customer_model->SelectStatus($_REQUEST['status'])?>
								<?php }else{?>
									<?=$this->customer_model->SelectStatus(0)?>
							<?php }?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Created by</label>

                    <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" />
                                 <option value="">-- Select Sam --</option>
								 <?=$this->customer_model->selectAllSam($created_by,$this->brand)?>

                        </select>
                    </div>

                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer Alias</label>

                    <div class="col-lg-3">
                      <input class="form-control" type="text" value = "<?=$alias ?>" name="alias" autocomplete="off">
                    </div>
                </div> 

                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('customerfilter'); e2.action='<?=base_url()?>customer/exportcustomer'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
					  <a href="<?=base_url()?>customer" class="btn btn-warning">(x) Clear Filter</a> 

				  </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<!-- -->
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Customers
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
				<div class="adv-table editable-table ">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>customer/addCustomer" class="btn btn-primary ">Add New Customer</a>
							</br></br></br>
						<?php } ?>
            			Show / Hide:
						<a href="" class="toggle-vis" data-column="0">ID</a> - 
						<a href="" class="toggle-vis" data-column="1">Name</a> - 
						<a href="" class="toggle-vis" data-column="2">Website</a> - 
						<a href="" class="toggle-vis" data-column="3">Status</a> - 
						<a href="" class="toggle-vis" data-column="4">Brand</a> -  
						<a href="" class="toggle-vis" data-column="5">Customer Alias</a> - 
						<a href="" class="toggle-vis" data-column="6">Payment Terms</a> - 
						<a href="" class="toggle-vis" data-column="7">Created By</a> - 
						<a href="" class="toggle-vis" data-column="8">Created At</a>  - 
						<a href="" class="toggle-vis" data-column="9">Edit</a>  - 
						<a href="" class="toggle-vis" data-column="10">Delete</a>
						</br></br></br>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Website</th>
								<th>Status</th>
                              	<th>Brand</th>
                              	<th>Customer Alias</th>
                              	<th>Payment terms</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Edit</th>
                                <th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($customer->result() as $row)
								{
						?>
									<tr class="">
										<td><?=$row->id?></td>
										<td><a href="<?=base_url()?>customer/customerPortal?t=<?=base64_encode($row->id)?>"><?php echo $row->name;?></a></td>
										<td><?php echo $row->website ;?></td>
										<td><?php if($row->status == 1){ echo "Lead"; }elseif ($row->status == 2){ echo "Existing"; } ?></td>
                                        <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td>
										<td><?php echo $row->alias ;?></td>
										<td><?php echo $row->payment ;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<!--  if(($permission->edit == 1 && $permission->follow == 2) || ($permission->edit == 1 && $row->created_by == $user)) -->
											<?php if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>customer/editCustomer?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
											<a href="<?php echo base_url()?>customer/deleteCustomer/?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Customer ?');">
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