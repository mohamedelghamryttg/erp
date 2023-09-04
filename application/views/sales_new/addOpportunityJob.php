<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Opportunity Job</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>sales/doOpportunityJob" onsubmit="return checkPriceListForm();disableAddButton();" method="post" enctype="multipart/form-data">
				    <input type="text" name="opportunity" value="<?=base64_encode($opportunity)?>" hidden="">
				    <input type="text" name="product_line" id="product_line" value="<?=$row->product_line?>" hidden=""></td>
                    <input type="text" name="lead" id="lead" value="<?=$row->lead?>" hidden="">

				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Services</label>
							<div class="col-lg-6">
								<select name="service" onchange="getPriceListByService()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled"></option>
                                            <?=$this->admin_model->selectServices()?>
                                    </select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Price List</label>
							<div class="col-lg-6" id="PriceList" style="overflow: scroll;max-height: 300px;width: 700px;">
						    <?=$this->sales_model->getPriceListByLead($row->lead,0,$row->product_line)?>							
						</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right"></label>
							<div class="col-lg-6" id="fuzzy">		
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Total Revenue</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" readonly="readonly" name="total_revenue" id="total_revenue" required>
							</div>
						</div>
					

						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>sales/viewOpportunityJob?t=<?=base64_encode($opportunity)?>" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>