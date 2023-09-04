<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Opportunity Jobs
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
						<?php if($permission->add == 1 && $opportunity_data->assigned == 0){ ?>
							<a href="<?=base_url()?>sales/addOpportunityJob?t=<?=base64_encode($opportunity)?>" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
							  <tr>
								<th>Product Line</th>
                             	 <th>Service</th>
                             	 <th>Source</th>
                             	 <th>Target</th>
                             	 <th>Volume</th>
                             	 <th>Rate</th>
                             	 <th>Total Revenue</th>
                             	 <th>Currency</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit </th>
							</tr>
							</tr>
						</thead>
						
						<tbody>
						<?php foreach ($job->result() as $row) { 
							$priceList = $this->projects_model->getJobPriceListData($row->price_list);
						?>
							<tr>
								<td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
								<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
								<td><?php echo $row->volume ;?></td>
								<td><?php echo $priceList->rate ;?></td>
								<td><?=$this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id)?></td>
								<td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td>
									<?php if($permission->edit == 1 && $opportunity_data->assigned == 0){ ?>
									<a href="<?php echo base_url()?>sales/editOpportunityJob?t=<?php echo 
									base64_encode($row->id) ;?>&o=<?=base64_encode($row->opportunity)?>" class="">
										<i class="fa fa-pencil"></i> Edit
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