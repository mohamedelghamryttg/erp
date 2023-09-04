<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Lost Opportunity</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>sales/doEditLostOpportunity" method="post" enctype="multipart/form-data">
                <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                     <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>lostOpportunity" hidden>
                     <?php } ?>
            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">

                <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value="<?= $row->project_name ?>" name="project_name" id="project_name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer</label>
                            <div class="col-lg-6">
                                  <select name="customer" class="form-control m-b" id="customer"  onchange="getLostOpportunityPM();CustomerData()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                            <?=$this->customer_model->selectCustomerBySam($row->customer,$sam,$permission,$brand)?>
                                    </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="LeadData">
                            	<?=$this->customer_model->getLeadData($row->lead,$row->customer,$sam)?>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Contact Method</label>
                            <div class="col-lg-6">
                                 <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts();" required />
                                         <option value="" selected="selected">-- Contact Method --</option>
                                          <?=$this->sales_model->selectContactMethod($row->contact_method)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" style="overflow-x: auto;height: 200px;" id="customerContact">
                                <?=$this->customer_model->getCustomerContact($row->lead,$row->contact_id)?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Services</label>
                            <div class="col-lg-6">
                                <select name="service" class="form-control m-b" onchange="getTaskType()" id="service" required />
                                            <option disabled="disabled"></option>
                                            <?=$this->admin_model->selectServices($row->service)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row" id="lost_reasons">
                            <label class="col-lg-3 col-form-label text-right">Lost Reasons</label>
                            <div class="col-lg-6">
                                <select name="lost_reasons" class="form-control m-b"   />
                                             <option disabled="disabled" selected="selected">-- Select Lost Reasons --</option>
                                              <?=$this->sales_model->SelectLostReasons($row->lost_reasons)?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Product Line</label>
                            <div class="col-lg-6">
                               <select name="product_line" class="form-control m-b" id="product_line"   />
                                             <option disabled="disabled" selected="selected">-- Select Product Line --</option>
                                             <?= $this->sales_model->SelectAllProductLines($row->product_line) ?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Source Language</label>
                            <div class="col-lg-6">
                               <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->source)?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Target Language</label>
                            <div class="col-lg-6">
                                 <select name="target" class="form-control m-b" id="target" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->target)?>
                                    </select>
                            </div>
                        </div>
                    
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Task Type</label>
                            <div class="col-lg-6">
                                <select name="task_type" class="form-control m-b" id="task_type" required />
                                  <?php echo $this->admin_model->selectTaskType($row->task_type,$row->service)?>                                    </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Unit</label>
                            <div class="col-lg-6">
                                <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($row->unit)?>
                                    </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Volume</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" onblur="CalculateTotalRevenueForLostOpportunities()" value="<?= $row->volume ?>" name="volume" id="volume"data-maxlength="300"  required>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Currency</label>
                            <div class="col-lg-6">
                                <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($row->currency)?>
                                    </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Assign PM</label>
                            <div class="col-lg-6">
                                <select name="pm" class="form-control m-b" id="pm" />
                                             <?=$this->customer_model->getAssignedPM($row->lead,$row->pm);?>
                                    </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Total Revenue</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" readonly name="total_revenue" id="total_revenue" value="<?= $row->rate * $row->volume ?>">
                            </div>
                        </div>
                         <input type="text" class=" form-control" value="<?= $row->lead ?>" name="lead_value"id="lead_value" data-maxlength="300" value="" hidden>
                    </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>sales/lostOpportunity" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>