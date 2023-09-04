<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Price List Filter
			</header>
         <?php
			 if(!empty($_REQUEST['product_line'])){
                    $product_line = $_REQUEST['product_line'];
                    
                }else{
                    $product_line = "";
                }
                if(!empty($_REQUEST['customer'])){
                    $customer = $_REQUEST['customer'];
                    
                }else{
                    $customer = "";
                }
                if(!empty($_REQUEST['source'])){
                    $source = $_REQUEST['source'];
                    
                }else{
                    $source = "";
                }
                if(!empty($_REQUEST['target'])){
                    $target = $_REQUEST['target'];
                    
                }else{
                    $target = "";
                }
                if(!empty($_REQUEST['service'])){
                    $service = $_REQUEST['service'];
                   
                }else{
                    $service = "";
                }
                if(!empty($_REQUEST['task_type'])){
                    $task_type = $_REQUEST['task_type'];
                    
                }else{
                    $task_type = "";
                }
                if(!empty($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                    
                }else{
                    $created_by = "";
                }

                ?>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="priceListForm" action="<?php echo base_url()?>customer/priceList" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer</label>
                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer"/>
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerBySam($customer,$this->user,$permission,$this->brand)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Product Line</label>

                    <div class="col-lg-3">
                    	<select name="product_line" class="form-control m-b" id="product_line" />
                                 <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine($product_line,$this->brand)?>
                        </select>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Source Language</label>
					<div class="col-lg-3">
                        <select name="source" class="form-control m-b" id="source" />
                                 <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                                 <option value="0">Empty</option>
                                 <?=$this->admin_model->selectLanguage($source)?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label" for="role Task Type">Target Language</label>
					<div class="col-lg-3">
                        <select name="target" class="form-control m-b" id="target" />
                                 <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                                 <option value="0">Empty</option>
                                 <?=$this->admin_model->selectLanguage($target)?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Service</label>
					<div class="col-lg-3">
                        <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                                <option value="" disabled="disabled" selected="selected">-- Select Service --</option>
                                <?=$this->admin_model->selectServices($service)?>
                        </select>
                    </div>
            <label class="col-lg-2 control-label" for="role Task Type">Task Type</label>

            <div class="col-lg-3">
                <select name="task_type" class="form-control m-b" id="task_type" />
                        <option value="" disabled="disabled" selected="selected">-- Select Task Type --</option>
                        <?=$this->admin_model->selectAllTaskType($task_type)?>
                </select>
            </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Created By</label>
					<div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by"/>
                                 <option value="">-- Select SAM --</option>
                                 <?=$this->customer_model->selectAllSam($created_by,$this->brand)?>
                        </select>
                    </div>
                </div>   
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('priceListForm'); e2.action='<?=base_url()?>customer/exportPriceList'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                      <a href="<?=base_url()?>customer/priceList" class="btn btn-warning">(x) Clear Filter</a>
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
				Customers Price List
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
							<a href="<?=base_url()?>customer/addPriceList" class="btn btn-primary ">Add New</a>
							</br></br></br>
							<a href="<?=base_url()?>customer/addBulkPriceList" class="btn btn-success ">Import Bulk Data <i class="fa fa-upload" aria-hidden="true"></i> </a>
              				</br></br></br>
						<?php } ?>
            Show / Hide:
            <a href="" class="toggle-vis" data-column="0">Customer</a> - 
            <a href="" class="toggle-vis" data-column="1">Regione</a> - 
            <a href="" class="toggle-vis" data-column="2">Country</a> - 
            <a href="" class="toggle-vis" data-column="3">Product Line</a> - 
            <a href="" class="toggle-vis" data-column="4">Service</a> -  
            <a href="" class="toggle-vis" data-column="5">Task Type</a> - 
            <a href="" class="toggle-vis" data-column="6">Rate</a> - 
            <a href="" class="toggle-vis" data-column="7">Unit</a> - 
            <a href="" class="toggle-vis" data-column="8">Source</a>  - 
            <a href="" class="toggle-vis" data-column="9">Target</a>  - 
            <a href="" class="toggle-vis" data-column="10">Dialect</a> -
            <a href="" class="toggle-vis" data-column="11">Created At</a>  - 
            <a href="" class="toggle-vis" data-column="12">Created By</a> -
            <a href="" class="toggle-vis" data-column="13">Edit</a>  -
            <a href="" class="toggle-vis" data-column="14">Delete</a>
            </br></br></br>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
							  <th>Customer</th>
                <th>Region</th>
							  <th>Country</th>
							  <th>Product Line</th>
                <th>Service</th>
							  <th>Task Type</th>
                <th>Rate</th>
                <th>Unit</th>
                <th>Source</th>  
							  <th>Target</th>
                <th>Dialect</th>
							  <th>Created By</th>
							  <th>Created At</th>
							  <th>Edit </th>
							  <th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($priceList->result() as $row)
								{
                              		$leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
						?>
									<tr class="">
										<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                                      	<td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
										<td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
										<td><?php echo $this->customer_model->getProductLine($row->product_line) ;?></td>
                                        <td><?php echo $this->admin_model->getServices($row->service) ;?></td>
										<td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
										<td><?php echo $row->rate ;?> <?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
										<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->source) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->target) ;?></td>
                                      	<td><?php echo $row->dialect ;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
										<?php  if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>customer/editPriceList?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
										<?php } ?>
										</td>
										<td>
										<?php  if($permission->delete == 1){ ?>
											<a href="<?php echo base_url()?>customer/deletePriceList?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Price List ?');">
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