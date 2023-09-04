<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Commission</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>projects/doAddCommission" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<input type="text" name="job_id" value="<?=base64_encode($job)?>" hidden="">
                <input type="text" name="volume" value="<?=$job_data->volume?>" hidden="">
				<div class="card-body">
					
						<div class="form-group row">
							<div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                                        <thead>
                                            <tr>
                                                 <th>Job Code</th>
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
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr class="">
                                                <td><?=$job_data->code?></td>
                                                <td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
                                                <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                                                <td><?php echo $job_data->volume ;?></td>
                                                <td><?php echo $priceList->rate ;?></td>
                                                <td><?=$this->sales_model->calculateRevenueJob($job_data->id,$job_data->type,$job_data->volume,$priceList->id)?></td>
                                                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                                                <td><?php echo $this->admin_model->getAdmin($job_data->created_by) ;?></td>
                                                <td><?php echo $job_data->created_at ;?></td>
                                            </tr>
                                        </tbody>
                                    </table>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Name</label>
							<div class="col-lg-6">
								<select name="commission" id="commission" class="form-control m-b" onchange="getCommissionEmail();getCommissionRate();" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->projects_model->selectCommission(0,$brand)?>
                                    </select>			
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email</label>
							<div class="col-lg-6" id="email">
									
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Rate</label>
							<div class="col-lg-6">
								<input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" id="rate" step="any" required>	
							</div>
						</div>
						
						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>projects" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>