<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Payment 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/doAddPayment" onsubmit="return checkAddPayment();disableAddButton();" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Payment Date</label>

                                <div class="col-lg-6">
                                    <input class="form-control date_sheet" type="text" name="payment_date" id="payment_date" onblur="getClientInvoicedPOs();getAdvancedPayments();getCreditNotePayment();" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Payment Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOs();getAdvancedPayments();getCreditNotePayment();" required />
                                             <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency()?>
                                    </select>
                                </div>
                            </div>                            

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Client</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="getClientInvoicedPOs();getAdvancedPayments();getCreditNotePayment();" required />
                                             <option value="" selected="selected" disabled="">-- Select Client --</option>
                                             <?=$this->customer_model->selectCustomerBranches(0,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-6">
                                    <a class="btn btn-success " onclick="checkPoPayment();getPymentTotal()" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                                    <a class="btn btn-danger " onclick="uncheckPoPayment();getPymentTotal()" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                                </div>
                                <div class="col-lg-2"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="invoicedPOs">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Deductions</label>

                                <div class="col-lg-2">
                                    <input type="text" class=" form-control" onkeypress="return rateCode(event)" onchange="checkDeductionPaymentValue();getPymentTotal();" name="deductions" id="deductions" required value="0">
                                </div>
                                <label class="col-lg-3 control-label">Reason</label>

                                <div class="col-lg-2">
                                    <select name="deduction_reason" class="form-control m-b" id="deduction_reason" required />
                                        <?=$this->accounting_model->selectPaymentDeductions(1)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="advancedPayments">
                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Payment In Advance</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onkeypress="return rateCode(event)" onchange="getPymentTotal();" name="advanced_payment" id="advanced_payment" value="0" required>
                                </div>
                            </div>
        
        					<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="creditNote">
                                    
                                </div>
                            </div>
        					
        					<div class="form-group">
                                <label class="col-lg-3 control-label">Credit Note Total</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" readonly="readonly" onchange="getPymentTotal();" name="total_credit_note" id="total_credit_note" value="0" required>
                                </div>
                            </div>

                  			<div class="form-group">
                                <label class="col-lg-3 control-label">Net Amount</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" readonly="readonly" name="net_amount" id="net_amount" value="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Payment Method</label>

                                <div class="col-lg-6">
                                    <select name="payment_method" class="form-control m-b" id="payment_method"  required />
                                             <option value="" selected="selected" disabled="">-- Select Payment Method --</option>
                                             <?=$this->accounting_model->selectPaymentMethod(0,$brand)?>
                                    </select>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>accounting/payments" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>