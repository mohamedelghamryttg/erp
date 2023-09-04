<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Activity 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doAddActivity" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam(0,$sam,$permission,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                    
                                </div>
                            </div>  

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Contact Method">Contact Method</label>
                                <div class="col-lg-6">
                                    <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod()?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="customerContact">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Contact Status">Contact Status</label>
                                <div class="col-lg-6">
                                    <select name="status" class="form-control m-b" id="status" onchange="getLeadStatus()" required />
                                             <option value="" selected="selected">-- Contact Status --</option>
                                             <?=$this->sales_model->selectActivityStatus()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Feedback">Feedback</label>
                                <div class="col-lg-6">
                                    <select name="feedback" class="form-control m-b" id="feedback" required />
                                             <option value="" selected="selected">-- Feedback --</option>
                                             <?=$this->sales_model->SelectFeedback()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="rolled_status">
                                <label class="col-lg-3 control-label" for="Rolled In">Rolled In</label>
                                <div class="col-lg-6">
                                    <select name="rolled_in" class="form-control m-b" id="rolled_in" onchange="getPayment()" required />
                                             <option value="" selected="selected">-- Rolled In --</option>
                                             <option value="1">Yes</option>
                                             <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                            <div id="payment_method">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Revenue USD">Payment Terms</label>

                                    <div class="col-lg-5">
                                        <input type="number" class=" form-control" id="payment" name="payment" required="" onkeypress="return numbersOnly(event)" data-maxlength="300"  id="paymnet" step="any"  >
                                    </div>
                                    <label class="col-lg-1 control-label" for="">Days</label>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Select PM">Select PM</label>
                                    <div class="col-lg-6">
                                        <select name="pm" class="form-control m-b" id="pm" required />
                                                 <option value="" selected="selected">-- Select PM --</option>
                                                 <?=$this->sales_model->selectPm(0,$brand)?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" value="" rows="6"></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>sales/salesActivity" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>