<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Opportunity 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doAddOpportunity" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Project Name/Email subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="project_name" id="project_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam(0,$this->user,$permission,$this->brand)?>
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
                                <div class="col-lg-6" style="overflow-x: auto;height: 200px;" id="customerContact">
                                    
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Status Of Project">Status Of Project</label>
                                <div class="col-lg-6">
                                    <select name="project_status" class="form-control m-b" onchange="getProductLineByLead()" id="project_status" required />
                                             <option value="" selected="selected">-- Status Of Project --</option>
                                             <?=$this->sales_model->SelectProjectStatus()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Product Lines</label>

                                <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" onchange="getAssignedPM();" required />
                                             <option disabled="disabled" selected="selected">-- Select Product Line --</option>
                                    </select>
                                </div> 
                            </div>                                                             
                                                                                            
							<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Assign PM">Assign PM</label>

                                <div class="col-lg-6">
                                    <select name="pm" class="form-control m-b" id="pm" required />
                                             <option disabled="disabled" selected="selected">-- Select PM --</option>
                                    </select>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>sales/opportunity" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>