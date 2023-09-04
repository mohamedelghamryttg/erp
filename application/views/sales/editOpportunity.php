<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Opportunity 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doEditOpportunity" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                            <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                                <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                                <?php }else{ ?>
                                <input type="text" name="referer" value="<?=base_url()?>sales/opportunity" hidden>
                           <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Project Name/Email subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->project_name?>" name="project_name" id="project_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData();getProductLineByLead();" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectExistingCustomerBySam($row->customer,$sam,$permission,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                    <?=$this->customer_model->getLeadData($row->lead,$row->customer,$sam)?>
                                </div>
                            </div> 

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Contact Method">Contact Method</label>
                                <div class="col-lg-6">
                                    <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod($row->contact_method)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="customerContact">
                                    <?=$this->customer_model->getCustomerContact($row->lead,$row->contact_id)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Status Of Project">Status Of Project</label>
                                <div class="col-lg-6">
                                    <select name="project_status" class="form-control m-b" id="project_status" required />
                                             <option value="" selected="selected">-- Status Of Project --</option>
                                             <?=$this->sales_model->SelectProjectStatus($row->project_status)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Product Lines</label>

                                <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" onchange="getAssignedPM()" required />
                                             <option disabled="disabled" selected="selected">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLine($row->product_line,$brand)?>
                                    </select>
                                </div>
                            </div>
  
  							<?php if($row->saved == 2){ ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Reject Reason</label>

                                <div class="col-lg-6">
                                      <p style="font-size: 18px;color: red;"><?=$row->reject_reason?></p>
                                </div>
                            </div>
                            <?php } ?>
    
    						<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Assign PM">Assign PM</label>

                                <div class="col-lg-6">
                                    <select name="pm" class="form-control m-b" id="pm" required />
                                             <?=$this->customer_model->getAssignedPM($row->lead,$row->pm);?>
                                    </select>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>sales/opportunity" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>