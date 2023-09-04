<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"  action="<?php echo base_url()?>vendor/doAddVendorSheet" method="post"  onsubmit="return disableAddButton();" enctype="multipart/form-data">
				 <div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Search Vendor Name :</label>
						<div class="col-lg-6">
							<input class="form-control"name="vendor_name" onkeypress="searchOptions()" id="vendor_name"/>
							
						</div>
					</div>
                      <div class="form-group row" style="display: none;">
                            <div class="col-lg-6" >
                                <select onchange="ticketReqType()" class="form-control" id="vendorList">
                                     <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                     <?=$this->vendor_model->selectVendor(0,$brand)?>
                                </select>
                            </div>
                        </div> 
                         

                       <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Source Language:</label>

                            <div class="col-lg-6">
                                <select  class="form-control" name="source_lang" id="source" required >
                                      <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                </select>
                            </div>
                        </div> 


                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Target Language:</label>

                            <div class="col-lg-6">
                                <select  class="form-control" name="target_lang" id="target" required >
                                    <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                </select>
                            </div>
                        </div> 

                          <div class="form-group row">
								<label class="col-lg-3 col-form-label text-right">Dialect:</label>
								<div class="col-lg-6">
									<input class="form-control" name="dialect" id="dialect" />
									
								</div>
						  </div>
                          <div class="form-group row">
	                            <label class="col-lg-3 col-form-label text-right" >Services:</label>

	                            <div class="col-lg-6">
	                                <select  class="form-control" name="service" onchange="getTaskType()" id="service" required >
	                                      <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices()?>
	                                </select>
	                            </div>
                           </div> 

                           <div class="form-group row">
		                            <label class="col-lg-3 col-form-label text-right" >Task Type:</label>

		                            <div class="col-lg-6">
		                                <select  class="form-control" name="task_type" id="task_type" required  >
		                                    <option disabled="disabled" selected=""></option>
		                                </select>
		                            </div>
                           </div> 
                           
                           <div class="form-group row">
	                            <label class="col-lg-3 col-form-label text-right" > Unit:</label>

	                            <div class="col-lg-6">
	                                <select  class="form-control" name="unit" id="unit" required>
	                                        <option disabled="disabled" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit()?>
	                                </select>
	                            </div>
                           </div>

                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Rate:</label>

                            <div class="col-lg-6">
                              <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" value="0" id="rate" step="any" required />
                            </div>
                        </div> 

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Currency:</label>

                            <div class="col-lg-6">
                                <select  class="form-control" name="currency" id="currency" required >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency()?>
                                </select>
                            </div>
                        </div> 

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Subject Matter:</label>

                            <div class="col-lg-6">
                                <select  class="form-control" name="subject[]" multiple id="subject" required >
                                     <?=$this->admin_model->selectFields()?>
                                </select>
                            </div>
                        </div> 
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Tools:</label>

                            <div class="col-lg-6">
                                <select  class="form-control" name="tools[]" multiple id="tools" required >
                                      <?=$this->sales_model->selectTools()?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Comment:</label>
							<div class="col-lg-6">
								<textarea  name="comment" class="form-control" value="" rows="6"></textarea>
								
							</div>
						</div>


					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Save</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>vendor/vendorSheet"class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>