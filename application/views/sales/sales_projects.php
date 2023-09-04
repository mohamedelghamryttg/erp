<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/projects" id="sales_project" method="get" enctype="multipart/form-data">
			 	<?php 
                     if(isset($_REQUEST['project_name'])){
                    $project_name = $_REQUEST['project_name'];
                }else{
                    $project_name = "";
                }
                if(isset($_REQUEST['customer'])){
                    $customer = $_REQUEST['customer'];
                }else{
                    $customer = "";
                }
                if(isset($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = 0;
                }
			 	?>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Project Name</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value="<?=$project_name ?>" name="project_name">
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Customer</label>

                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer"/>
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectExistingCustomerBySam($customer,$user,$permission,$this->brand)?>
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
              	<?php if($permission->view == 1){ ?>
				<div class="form-group">
					<label class="col-lg-2 control-label" for="role Task Type">Created By</label>
					<div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by"/>
                                 <option value="">-- Select SAM --</option>
                                 <?=$this->customer_model->selectAllSam($created_by,$this->brand)?>
                        </select>
                    </div>
                </div>  
          		<?php } ?>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('sales_project'); e2.action='<?=base_url()?>sales/exportProjects'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
  					  <a href="<?=base_url()?>sales/projects" class="btn btn-warning">(x) Clear Filter</a> 

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
				Projects
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
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
                             	<th>SAM Name</th>
				                <th>PM Name</th>
				                <th>Opportunity Number</th>
                             	<th>Project Code</th>
				                <th>Project Name</th>
				                <th>Client</th>
				                <th>Region</th>
				                <th>Rolled In Date</th>
				                <th>Product Line</th>
				                <th>Job Code</th>
				                <th>Job Name</th>
				             	<th>Service</th>
				               <th>Source</th>
				               <th>Target</th>
				               <th>Volume</th>
				                <th>Unit</th>
				               <th>Rate</th>
				               <th>Total Revenue</th>
				               <th>Total Revenue In $</th>
				               <th>Currency</th>
				               <th>Status</th>
				               <th>Start Date</th>
				                <th>Delivery Date</th>
				                <th>Closed Date</th>
				                <th>Job Created At</th>	                         	
							</tr>
						</thead>
						<tbody>
						<?php foreach ($project->result() as $row) { 
							$priceList = $this->projects_model->getJobPriceListData($row->price_list);
  							$total_revenue = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
  							$rolled = $this->db->get_where('sales_activity',array('customer'=>$row->customer,'rolled_in'=>1))->row();
  							$leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
						?>
							<tr>
								<td><?php echo $this->admin_model->getAdmin($row->assigned_sam) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?=$row->opportunity?></td>
								<td><?=$row->project_code?></td>
								<td><?=$row->project_name?></td>
								<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
								<td><?php echo $this->admin_model->getRegion($leadData->region) ;?></td>
								<td><?php if(isset($rolled->created_at)){echo $rolled->created_at;}?></td>
                              	<td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
								<td><?=$row->code?></td>
								<td><?=$row->name?></td>
								<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
				                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
				                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
				                 <?php if($row->type == 1){ ?>
				                <td><?php echo $row->volume ;?></td>
				                <?php }elseif ($row->type == 2) { ?>
				                <td><?php echo $total_revenue / $priceList->rate ;?></td>
				                <?php } ?>
				                <td><?php echo $this->admin_model->getUnit($priceList->unit) ;?></td>
				                <td><?=$priceList->rate?></td>
				                <td><?=$total_revenue?></td>
                            	<td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$row->created_at,$total_revenue),2)?></td>
				                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
				                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
				                <td><?=$row->start_date?></td>
				                <td><?=$row->delivery_date?></td>
				                <td><?=$row->closed_date?></td>
				                <td><?=$row->created_at?></td>
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