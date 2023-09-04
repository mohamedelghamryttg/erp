<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Vendor Payment 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/doAddVendorPayment" method="post" enctype="multipart/form-data" onsubmit="return checkAddPayment();disableAddButton();">
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Search Vendor name">Search Vendor Name ...</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="vendor_name" onkeypress="searchOptions()" id="vendor_name">
                                </div>
                            </div>
                            <div style="display: none;">
                            <select class="form-control m-b" id="vendorList"/>
                                     <option disabled="disabled" selected="selected" value="">-- Select Vendor --</option>
                                     <?=$this->vendor_model->selectVendor(0,$brand)?>
                            </select>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Vendor">Vendor</label>

                                <div class="col-lg-6">
                                    <select name="vendor" class="form-control m-b" id="vendor" onchange="getVendorInfo();getVendorVerifiedTasks();" required />
                                             <option disabled="disabled" selected="selected" disabled="">-- Select Vendor --</option>
                                             <?=$this->vendor_model->selectVendor(0,$brand)?>
                                    </select>
                                </div>
                            </div>
            
            				<div class="form-group">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-6">
                                    <a class="btn btn-success " onclick="checkPoPayment();" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                                    <a class="btn btn-danger " onclick="uncheckPoPayment();" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                                </div>
                                <div class="col-lg-2"></div>
                            </div>

                           <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="vendorData">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="tasks">
                                    
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
                                <label class="col-lg-3 control-label" for="role name">Payment Date</label>

                                <div class="col-lg-6">
                                    <input class="form-control date_sheet" type="text" name="payment_date" id="payment_date" autocomplete="off">
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>accounting/vendorPayments" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>