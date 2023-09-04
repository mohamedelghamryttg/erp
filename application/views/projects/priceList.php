<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Price List Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="priceListForm" action="<?php echo base_url()?>projects/priceList" method="post" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer</label>
                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" />
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerByPm(0,$user,$permission,$this->brand)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Product Line</label>

                    <div class="col-lg-3">
                    	<select name="product_line" class="form-control m-b" id="product_line" />
                                 <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine(0,$this->brand)?>
                        </select>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Source Language</label>
					<div class="col-lg-3">
                        <select name="source" class="form-control m-b" id="source" />
                                 <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                                 <option value="0">Empty</option>
                                 <?=$this->admin_model->selectLanguage()?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label" for="role Task Type">Target Language</label>
					<div class="col-lg-3">
                        <select name="target" class="form-control m-b" id="target" />
                                 <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                                 <option value="0">Empty</option>
                                 <?=$this->admin_model->selectLanguage()?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Service</label>
					<div class="col-lg-3">
                        <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectServices()?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label" for="role Task Type">Task Type</label>
					<div class="col-lg-3">
                        <select name="task_type" class="form-control m-b" id="task_type" />
                                <option disabled="disabled" selected=""></option>
                        </select>
                    </div>
                </div>  
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
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
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>customer/addPriceList" class="btn btn-primary ">Add New</a>
							</br></br></br>
							<a href="<?=base_url()?>customer/addBulkPriceList" class="btn btn-success ">Import Bulk Data <i class="fa fa-upload" aria-hidden="true"></i> </a>
              				</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
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
							  <th>Created By</th>
							  <th>Created At</th>
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
										<td><?php echo $row->rate ;?></td>
										<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->source) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->target) ;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
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