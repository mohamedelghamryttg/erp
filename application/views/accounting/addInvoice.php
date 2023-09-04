<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Invoice 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " onsubmit="return checkAddInvoice();disableAddButton();" action="<?php echo base_url()?>accounting/doAddInvoice" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Client</label>

                                 <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="getCustomerDataAccounting();" required />
                                             <option value="" selected="selected" disabled="">-- Select Client --</option>
                                             <?=$this->customer_model->selectCustomerBranches(0,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">

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
                                <div class="col-lg-6" id="VerifiedPOs">
                                    
                                </div>
                            </div>  
                  
                  			<div class="form-group">
                                <label class="col-lg-3 control-label">Total Revenue</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" readonly="readonly" name="total_revenue" id="total_revenue" required>
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
                                <label class="col-lg-3 control-label">Issue Date</label>

                                <div class="col-lg-6">
                                    <input size="16" type="text" class="datepicker form-control" onblur="getPaymentData();" name="issue_date" id="issue_date" required="">
                                </div>
                            </div>
                  
                  			<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="paymentData">

                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>accounting/invoices" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>