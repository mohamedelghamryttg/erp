<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add Sales VM Ticket </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"  action="<?php echo base_url()?>vendor/doAddSalesVmTicket" onsubmit="return checkResouceNumber()" method="post" enctype="multipart/form-data">
				 <div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Ticket Subject:</label>
						<div class="col-lg-6">
							<input class="form-control" value="" name="ticket_subject" />
							
						</div>
					</div>
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Request Type:</label>

                            <div class="col-lg-6">
                                <select name="request_type" onchange="ticketReqType()" class="form-control" id="request_type" required="">
                                    <option value="" disabled='' selected=''>--Request Type --</option>
                                       <?=$this->vendor_model->selectSalesTicketType()?>
                                </select>
                            </div>
                        </div> 

                        
						 <div class="form-group row" id="resouceNumber">
							<label class="col-lg-3 col-form-label text-right">Number Of Resources:</label>
							<div class="col-lg-6">
								<input class="form-control" onblur="return checkResouceNumber()" name="number_of_resource" id="number_of_resource" onkeypress="return numbersOnly(event)" required />
								
							</div>
						</div>
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Services:</label>

                            <div class="col-lg-6">
                                <select name="service" value="" onchange="getTaskType()" class="form-control" id="service" required>
                                    <option value="" disabled='' selected=''>--Request Type --</option>
                                       <?=$this->admin_model->selectServices()?>
                                </select>
                            </div>
                        </div> 
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Task Type:</label>

                            <div class="col-lg-6">
                                <select name="task_type" class="form-control" id="task_type" required>
                                    <option disabled="disabled" value="" selected=""></option>
                                </select>
                            </div>
                        </div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Rate:</label>
							<div class="col-lg-6">
								<input type="number" onkeypress="return rateCode(event)" class=" form-control" name="rate" data-maxlength="300" id="rate" step="any" required>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Count:</label>
							<div class="col-lg-6">
								<input type="number" onkeypress="return rateCode(event)" class=" form-control" name="count" data-maxlength="300" id="count" step="any" required>
								
							</div>
						</div>
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Unit:</label>

                            <div class="col-lg-6">
                                <select name="unit" class="form-control" id="unit" required>
                                    <option value="" disabled='' selected=''>--Request Type --</option>
                                       <?=$this->admin_model->selectUnit()?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Currency:</label>

                            <div class="col-lg-6">
                                <select name="currency" class="form-control" id="currency" required>
                                    <option value="" disabled='' selected=''>--Select Currency --</option>
                                       <?=$this->admin_model->selectCurrency()?>
                                </select>
                            </div>
                        </div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Source Language:</label>
							<div class="col-lg-6">
								<select name="source_lang" class="form-control" id="source_lang" required>
                                    <option value="" disabled='' selected=''>-- Select Source Language --</option>
                                      <?=$this->admin_model->selectLanguage()?>
                                </select>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Target Language:</label>
							<div class="col-lg-6">
								<select name="target_lang" class="form-control" id="target_lang" required >
                                    <option value="" disabled='' selected=''>-- Select Target Language --</option>
                                      <?=$this->admin_model->selectLanguage()?>
                                </select>
								
							</div>
						</div>

                       <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Start Date:</label>
							<div class="col-lg-6">
								<input type="text" required="" value="<?=date("Y-m-d H:i:s")?>" autocomplete="off" class="form_datetime form-control" onchange="checkDate('start_date');" name="start_date" id="start_date">
								
							</div>
						</div>


                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Delivery Date:</label>
							<div class="col-lg-6">
								<input  type="text" required="" autocomplete="off" class="form_datetime form-control" onchange="checkDate('delivery_date');" name="delivery_date" id="delivery_date">
								
							</div>
						</div>
<!--						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Due Date:</label>
							<div class="col-lg-6">
								<input  type="text"  autocomplete="off" class="form_datetime form-control" onchange="checkDate('due_date');" name="due_date" id="due_date">
								
							</div>
						</div>-->

                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Subject Matter:</label>
							<div class="col-lg-6">
								<select name="subject" class="form-control" id="subject" required  >
                                    <option value="" disabled='' selected=''>-- Select Subject --</option>
                                       <?=$this->admin_model->selectFields()?>
                                </select>
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Software:</label>
							<div class="col-lg-6">
								<select name="software" class="form-control" id="software" required >
                                    <option value="" disabled='' selected=''></option>
                                      <?=$this->sales_model->selectTools()?>
                                </select>
								
							</div>
						</div>


						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Attachment:</label>
							<div class="col-lg-6">
								<input type="file" class=" form-control" name="file" id="file">
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Comment:</label>
							<div class="col-lg-6">
								<textarea name="comment" class="form-control" rows="6"></textarea>
								
							</div>
						</div>



					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Save</button>
							<a class="btn btn-secondary"  href="<?php echo base_url()?>vendor/salesVmTickets" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>