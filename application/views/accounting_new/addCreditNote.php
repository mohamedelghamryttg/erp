<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Credit Note</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>accounting/doAddCreditNote" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Type Of Credit Note</label>
							<div class="col-lg-6">
								<select name="type" class="form-control m-b" id="type" onchange="getTypeForm()" required />
                                             <option value="" selected="selected" disabled="">-- Select Type --</option>
                                             <?=$this->accounting_model->selectCreditNoteType()?>
                                    </select>
							</div>
						</div>

						<div id="typeData">
                               
                            </div>

						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>accounting/creditNote" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>

 <script type="text/javascript">
        function getTypeForm(){
            var type = $("#type").val();
            if(type == 1 || type == 4){
                $("#typeData").html(`
                	<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Currency</label>
							<div class="col-lg-6">
								 <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOsSingleChoose()" required="" >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                     <?=$this->admin_model->selectCurrency()?>
                            </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Client</label>
							<div class="col-lg-6">
								 <select name="customer" class="form-control m-b" id="customer"  onchange="getClientInvoicedPOsSingleChoose();" required >
                                     <option value="" selected="selected" disabled="">-- Select Client --</option>
                                     <?=$this->customer_model->selectCustomerBranches(0,$this->brand)?>
                            </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Issue Date</label>
							<div class="col-lg-6">
								 <input type="text" class="date_sheet form-control" name="issue_date" id="payment_date" onblur="getClientInvoicedPOsSingleChoose();" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right"></label>
							<div class="col-lg-6" id="invoicedPOs">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">PO Amount</label>
							<div class="col-lg-6">
								 <input type="number" onkeypress="return rateCode(event)" class="form-control" name="po_amount" data-maxlength="300" value="0" id="po_amount" step="any" required="" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Credit Note Amount</label>
							<div class="col-lg-6">
								 <input type="number" onkeypress="return rateCode(event)" class="form-control" name="amount" data-maxlength="300" value="0" id="amount" step="any" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Attachment</label>
							<div class="col-lg-6">
								 <input type="file" class=" form-control" name="file" id="file" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Description</label>
							<div class="col-lg-6">
								 <textarea name="description" class="form-control" rows="6"></textarea>
							</div>
						</div>
						 `);
            }else if(type == 2 || type == 3){
                $("#typeData").html(`
                	<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Currency</label>
							<div class="col-lg-6">
								 <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOsSingleChoose()" required="" >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                     <?=$this->admin_model->selectCurrency()?>
                            </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Client</label>
							<div class="col-lg-6">
								 <select name="customer" class="form-control m-b" id="customer"  onchange="getClientInvoicedPOsSingleChoose();" required >
                                     <option value="" selected="selected" disabled="">-- Select Client --</option>
                                     <?=$this->customer_model->selectCustomerBranches(0,$this->brand)?>
                            </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Issue Date</label>
							<div class="col-lg-6">
								 <input type="text" class="date_sheet form-control" name="issue_date" id="payment_date" onblur="getClientInvoicedPOsSingleChoose();" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right"></label>
							<div class="col-lg-6" id="invoicedPOs">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">PO Amount</label>
							<div class="col-lg-6">
								 <input type="number" onkeypress="return rateCode(event)" class="form-control" name="po_amount" data-maxlength="300" value="0" id="po_amount" step="any" required="" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Credit Note Amount</label>
							<div class="col-lg-6">
								 <input type="number" onkeypress="return rateCode(event)" class="form-control" name="amount" data-maxlength="300" value="0" id="amount" step="any" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Attachment</label>
							<div class="col-lg-6">
								 <input type="file" class=" form-control" name="file" id="file" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Description</label>
							<div class="col-lg-6">
								 <textarea name="description" class="form-control" rows="6"></textarea>
							</div>
						</div>
						`);
            }else if(type == 2 || type == 3){
                $("#typeData").html(`
                	<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Currency</label>
							<div class="col-lg-6">
								 <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOsSingleChoose()" required="" >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                     <?=$this->admin_model->selectCurrency()?>
                            </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Client</label>
							<div class="col-lg-6">
								 <select name="customer" class="form-control m-b" id="customer"  onchange="getClientInvoicedPOsSingleChoose();" required >
                                     <option value="" selected="selected" disabled="">-- Select Client --</option>
                                     <?=$this->customer_model->selectCustomerBranches(0,$this->brand)?>
                            </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Issue Date</label>
							<div class="col-lg-6">
								 <input type="text" class="date_sheet form-control" name="issue_date" id="payment_date" onblur="getClientInvoicedPOsSingleChoose();" required="">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-lg-4"></div>
							<div class="col-lg-6">
								<a class="btn btn-success " onclick="checkBoxes('pos');getInvoiceTotal()" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                            	<a class="btn btn-danger " onclick="uncheckBoxes('pos');getInvoiceTotal()" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
							</div>
							<div class="col-lg-2"></div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right"></label>
							<div class="col-lg-6" id="invoicedPOs">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">PO Amount</label>
							<div class="col-lg-6">
								 <input type="number" onkeypress="return rateCode(event)" class="form-control" name="po_amount" data-maxlength="300" value="0" id="po_amount" step="any" required="" readonly="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Credit Note Amount</label>
							<div class="col-lg-6">
								 <input type="number" onkeypress="return rateCode(event)" class="form-control" name="amount" data-maxlength="300" value="0" id="amount" step="any" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Attachment</label>
							<div class="col-lg-6">
								 <input type="file" class=" form-control" name="file" id="file" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Description</label>
							<div class="col-lg-6">
								 <textarea name="description" class="form-control" rows="6"></textarea>
							</div>
						</div>
						 `);
            }else {
                $("#typeData").html(``);
            }

            $("select").removeClass( "form-control");
            $("select").select2();
        	$('.date_sheet').datepicker({ dateFormat: 'dd-mm-yy' }).val();
        	tinymce.init({ selector:'textarea' })
        }
    </script>





