<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Activity</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>sales/doAddActivity" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Customer</label>
							<div class="col-lg-6">
								<select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam(0,$sam,$permission,$brand)?>
                                    </select>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right"></label>
							<div class="col-lg-6" id="LeadData">		
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Contact Method</label>
							<div class="col-lg-6">
								  <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod()?>
                                    </select>
							</div>
						</div>
					<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right"></label>
							<div class="col-lg-6" id="customerContact">		
							</div>
						</div>
					<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Contact Status</label>
							<div class="col-lg-6">
								  <select name="status" class="form-control m-b" id="status" onchange="getLeadStatus()" required />
                                             <option value="" selected="selected">-- Contact Status --</option>
                                             <?=$this->sales_model->selectActivityStatus()?>
                                    </select>
							</div>
						</div>

					<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Feedback</label>
							<div class="col-lg-6">
								<select name="feedback" class="form-control m-b" id="feedback" required />
                                             <option value="" selected="selected">-- Feedback --</option>
                                             <?=$this->sales_model->SelectFeedback()?>
                                    </select>
							</div>
						</div>
					
					<div class="form-group row" id="rolled_status">
							<label class="col-lg-3 col-form-label text-right">Rolled In</label>
							<div class="col-lg-6">
								  <select name="rolled_in" class="form-control m-b" id="rolled_in" onchange="getPayment()" required />
                                             <option value="" selected="selected">-- Rolled In --</option>
                                             <option value="1">Yes</option>
                                             <option value="2">No</option>
                                    </select>
							</div>
						</div>
						<div id="payment_method">
                            <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Payment Terms</label>
							<div class="col-lg-5">
								   <input type="number" class=" form-control" id="payment" name="payment" required="" onkeypress="return numbersOnly(event)" data-maxlength="300"  id="paymnet" step="any"  >
							</div>
							<label class="col-lg-1 control-label" for="">Days</label>
						</div>
                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Select PM</label>
							<div class="col-lg-6">
								<select name="pm" class="form-control m-b" id="pm" required />
                                                 <option value="" selected="selected">-- Select PM --</option>
                                                 <?=$this->sales_model->selectPm(0,$brand)?>
                                        </select>
							</div>
						</div>
                       </div>
                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Comment</label>
							<div class="col-lg-6">
								<textarea name="comment" class="form-control" value="" rows="6"></textarea>
							</div>
						</div>

						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>sales/salesActivity" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>