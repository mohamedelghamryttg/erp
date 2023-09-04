<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Credit Note 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " onsubmit="return disableAddButton();" action="<?php echo base_url()?>accounting/doAddCreditNote" method="post" enctype="multipart/form-data">
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Type Of Credit Note</label>

                                 <div class="col-lg-6">
                                    <select name="type" class="form-control m-b" id="type" onchange="getTypeForm()" required />
                                             <option value="" selected="selected" disabled="">-- Select Type --</option>
                                             <?=$this->accounting_model->selectCreditNoteType()?>
                                    </select>
                                </div>
                            </div>

                            <div id="typeData">
                                

                            </div>

                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>accounting/creditNote" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript">
        function getTypeForm(){
            var type = $("#type").val();
            if(type == 1 || type == 4){
                $("#typeData").html(`
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Currency</label>
						<div class="col-lg-6">
                            <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOsSingleChoose()" required="" >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                     <?=$this->admin_model->selectCurrency()?>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Client</label>

                         <div class="col-lg-6">
                            <select name="customer" class="form-control m-b" id="customer"  onchange="getClientInvoicedPOsSingleChoose();" required >
                                     <option value="" selected="selected" disabled="">-- Select Client --</option>
                                     <?=$this->customer_model->selectCustomerBranches(0,$this->brand)?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Issue Date</label>

                        <div class="col-lg-6">
                            <input type="text" class="date_sheet form-control" name="issue_date" id="payment_date" onblur="getClientInvoicedPOsSingleChoose();" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name"></label>
                        <div class="col-lg-6" id="invoicedPOs">
                            
                        </div>
                    </div>

					<div class="form-group">
                       <label class="col-lg-3 control-label" for="rate">PO Amount</label>

                       <div class="col-lg-6">
                         <input type="number" onkeypress="return rateCode(event)" class="form-control" name="po_amount" data-maxlength="300" value="0" id="po_amount" step="any" required="" readonly="">
                       </div>
                     </div>

                    <div class="form-group">
                       <label class="col-lg-3 control-label" for="rate">Credit Note Amount</label>

                       <div class="col-lg-6">
                         <input type="number" onkeypress="return rateCode(event)" class="form-control" name="amount" data-maxlength="300" value="0" id="amount" step="any" required="">
                       </div>
                     </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Attachment</label>

                        <div class="col-lg-6">
                            <input type="file" class=" form-control" name="file" id="file" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="description">Description</label>

                        <div class="col-lg-6">
                              <textarea name="description" class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                    `);
            }else if(type == 2 || type == 3){
                $("#typeData").html(`
					<div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Currency</label>
						<div class="col-lg-6">
                            <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOsMultipleChoose()" required="" >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                     <?=$this->admin_model->selectCurrency()?>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Client</label>

                         <div class="col-lg-6">
                            <select name="customer" class="form-control m-b" id="customer" onchange="getClientInvoicedPOsMultipleChoose();" required >
                                     <option value="" selected="selected" disabled="">-- Select Client --</option>
                                     <?=$this->customer_model->selectCustomerBranches(0,$this->brand)?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Issue Date</label>

                        <div class="col-lg-6">
                            <input type="text" class="date_sheet form-control" name="issue_date" id="payment_date" onblur="getClientInvoicedPOsMultipleChoose();" required="">
                        </div>
                    </div>

					<div class="form-group">
                    	<div class="col-lg-4"></div>
                    		<div class="col-lg-6">
                            	<a class="btn btn-success " onclick="checkBoxes('pos');getInvoiceTotal()" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                            	<a class="btn btn-danger " onclick="uncheckBoxes('pos');getInvoiceTotal()" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                    		</div>
                    		<div class="col-lg-2"></div>
                   		</div>

					<div class="form-group">
                        <label class="col-lg-3 control-label" for="role name"></label>
                        <div class="col-lg-6" id="invoicedPOs">
                            
                        </div>
                    </div>

					<div class="form-group">
                       <label class="col-lg-3 control-label" for="rate">POs Amount</label>

                       <div class="col-lg-6">
                         <input type="number" onkeypress="return rateCode(event)" class="form-control" name="total_revenue" data-maxlength="300" value="0" id="total_revenue" step="any" required="" readonly="">
                       </div>
                     </div>

                    <div class="form-group">
                       <label class="col-lg-3 control-label" for="rate">Credit Note Amount</label>

                       <div class="col-lg-6">
                         <input type="number" onkeypress="return rateCode(event)" class="form-control" name="amount" data-maxlength="300" value="0" id="amount" step="any" required>
                       </div>
                     </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Attachment</label>

                        <div class="col-lg-6">
                            <input type="file" class=" form-control" name="file" id="file" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="description">Description</label>

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