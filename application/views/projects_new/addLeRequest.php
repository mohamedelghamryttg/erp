<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add LE Request</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>projects/doAddLeRequest" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Task Name</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control"  name="subject" id="subject" required>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Task Type</label>
							<div class="col-lg-6">
								 <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLETaskType()?>
                                    </select>			
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Subject Matter</label>
							<div class="col-lg-6">
								 <select name="subject_matter" class="form-control m-b" id="subject_matter" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLESubject()?>
                                    </select>		
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Product Line</label>
							<div class="col-lg-6">
								 <select name="product_line" class="form-control m-b" id="product_line" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->customer_model->selectProductLine(0,$this->brand)?>
                                    </select>		
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Source Language</label>
							<div class="col-lg-6">
								 <select name="source_language" class="form-control m-b" id="source_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLanguage()?>
                                    </select>	
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Target Language</label>
							<div class="col-lg-6">
								  <select name="target_language" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLanguage()?>
                                    </select>	
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Linguist Format</label>
							<div class="col-lg-6">
								<select name="linguist_format" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLeFormat()?>
                                    </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Deliverable Format</label>
							<div class="col-lg-6">
								 <select name="deliverable_format" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLeFormat()?>
                                    </select>	
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Unit</label>
							<div class="col-lg-6">
								 <select name="unit" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLEUnit()?>
                                    </select>	
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Volume</label>
							<div class="col-lg-6">
								   <input type="text" name="volume" class="form-control" rows="6"></input>		
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Complexicty</label>
							<div class="col-lg-6">
							<input class="form-check-input" type="radio" required name="complexicty" value="1">
                            <label>Low</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="complexicty" value="2">
                            <label>Mid</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="complexicty" value="3" >
                            <label>High</label>		
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Start Date</label>
							<div class="col-lg-6">
								 <input size="16" type="text" onchange="checkDate('start_date')" value="<?=date("Y-m-d H:i:s")?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="">	
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Delivery Date</label>
							<div class="col-lg-6">
								 <input size="16" type="text" onchange="checkDate('delivery_date')" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">File Attachment</label>
							<div class="col-lg-6">
								 <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">	
							</div>
						</div>
                         
                         <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">TTG TM usage</label>
							<div class="col-lg-6">
								  <select name="tm_usage" class="form-control m-b" id="tm_usage" required />
                                            <option disabled="disabled" selected=""></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                    </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Instructions</label>
							<div class="col-lg-6">
								   <textarea name="insrtuctions" class="form-control" rows="6"></textarea>	
							</div>
						</div>

						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>projects/pmLERequest" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>