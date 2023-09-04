<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Resource 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doEditticketResource" method="post" enctype="multipart/form-data">
                            <input name="ticket" type="hidden" value="<?=$ticket?>" readonly="">
                            <input name="id" type="hidden" value="<?=$id?>" readonly="">
                            <input name="ticket_response_type" type="hidden" value="<?=$ticket_resources->type?>" readonly="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Resource Type :
                                    <?php if($ticket_resources->type == 1){echo "New Resource";}
                                      if($ticket_resources->type == 2){echo "Select Existing Resource";}
                                      if($ticket_resources->type == 3){echo "Select Existing Resource & Adding New Pair";}
                                ?>
                                </label>
                            </div>
                            <?php if($ticket_resources->type == 1){ ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role name">Name</label>

                                <div class="col-lg-3">
                                    <input type="text" class=" form-control" value="<?=$resource->name?>" name="name" id="name" required="">
                                </div>

                                <input type="text" name="id" id="id"value="<?=base64_encode($resource->id)?>" hidden="">

                                <label class="col-lg-2 control-label" for="role name">Email</label>

                                <div class="col-lg-3">
                                    <input type="email" class=" form-control" onchange="vendoremailedit()" name="email" value="<?=$resource->email?>" id="vendorEmailEdit" required="">
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role name">Contact</label>

                                <div class="col-lg-3">
                                    <input type="text" class=" form-control" name="contact" value="<?=$resource->contact?>" id="contact" required="">
                                </div>
                                <label class="col-lg-2 control-label" for="role name">Country of Residence</label>

                                <div class="col-lg-3">
                                    <select name="country" class="form-control m-b" id="country" required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Country --</option>
                                             <?=$this->admin_model->selectAllCountries($resource->country)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role name">Mother Tongue</label>

                                <div class="col-lg-3">
                                    <input type="text" class=" form-control" name="mother_tongue" value="<?=$resource->mother_tongue?>" id="mother_tongue" required="">
                                </div>
                                <label class="col-lg-2 control-label" for="role name">Dialect</label>

                                <div class="col-lg-3">
                                    <input type="text" class=" form-control" name="dialect" value="<?=$sheet->dialect?>" id="dialect" required="">
                                </div>
                            </div>
              
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Profile">Profile</label>

                                <div class="col-lg-3">
                                    <input type="text" class=" form-control" name="profile" value="<?=$resource->profile?>" id="profile">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-3">
                                    <select name="source_lang" class="form-control m-b" id="source"  required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($sheet->source_lang)?>
                                    </select>
                                </div>
                                <label class="col-lg-2 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-3">
                                    <select name="target_lang" class="form-control m-b" id="target"  required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($sheet->target_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Service">Service</label>

                                <div class="col-lg-3">
                                    <select name="service" class="form-control m-b" onchange="getTaskType()" id="service"  required=""/>
                                            <option disabled="disabled" selected=""></option>
                                             <?=$this->admin_model->selectServices($sheet->service)?>
                                    </select>
                                </div>
                                <label class="col-lg-2 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-3">
                                    <select name="unit" class="form-control m-b" id="unit"  required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($sheet->unit)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-3">
                                    <select name="task_type" class="form-control m-b" id="task_type"  required=""/>
                                            <option disabled="disabled" selected=""></option>
                                             <?=$this->admin_model->selectTaskType($sheet->task_type,$sheet->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-2 control-label" for="rate"> Rate</label>

                               <div class="col-lg-3">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" id="rate" value="<?=$sheet->rate?>" step="any" required="">
                               </div>
                                <label class="col-lg-2 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-3">
                                    <select name="currency" class="form-control m-b" id="currency" required="" />
                                             <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($sheet->currency)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-3">
                                    <select name="subject[]" multiple class="form-control m-b" id="subject"  required=""/>
                                             <option disabled="disabled">-- Select Subject --</option>
                                             <?=$this->admin_model->selectMultiFields($sheet->subject)?>
                                    </select>
                                </div>
                                <label class="col-lg-2 control-label" for="role Tools">Tools</label>

                                <div class="col-lg-3">
                                    <select name="tools[]" multiple class="form-control m-b" id="tools"  required=""/>
                                             <option disabled="disabled">-- Select Tools --</option>
                                             <?=$this->sales_model->selectMultiTools($sheet->tools)?>
                                    </select>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Color</label>

                                <div class="col-lg-6">
                                    <select name="color" class="form-control m-b" id="type"><option value="" selected="selected">-- Blank --</option><?=$this->vendor_model->selectVendorColor($row->color)?></select>
                                </div>
                            </div>

                            <?php if(strlen(trim($resource->cv)) > 0){ ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">CV Download</label>

                                <div class="col-lg-6">
                                    <a href="<?=base_url()?>assets/uploads/vendors/<?=$resource->cv?>">Click Here ..</a>
                                </div>
                            </div>
                            <?php }else{ ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">CV Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file">
                                </div>
                            </div>
                            <?php } ?>
                            </div>
                            <?php } ?>
                            
                            <?php if($ticket_resources->type == 2){ ?>
                            <div id="resource">
                                <div class="form-group">
                                  <label class="col-lg-3 control-label" for="role Target">Vendor</label>

                                  <div class="col-lg-6">
                                      <select name="vendor" class="form-control m-b" id="target" required />
                                               <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                               <?=$this->vendor_model->selectVendorByMail($resource->id,$brand)?>
                                      </select>
                                  </div>
                              </div>
                              </div>
                            <?php } ?>

                            <?php if($ticket_resources->type == 3){ ?>
                            <div id="resource">
                                <div class="form-group">
                                  <label class="col-lg-3 control-label" for="role Target">Vendor</label>

                                  <div class="col-lg-6">
                                      <select name="vendor" class="form-control m-b" id="target" required />
                                               <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                               <?=$this->vendor_model->selectVendorByMail($resource->id,$brand)?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label" for="role name">Dialect</label>

                                <div class="col-lg-3">
                                    <input type="text" class=" form-control" name="dialect" value="<?=$sheet->dialect?>" id="dialect" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-3">
                                    <select name="source_lang" class="form-control m-b" id="source"  required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($sheet->source_lang)?>
                                    </select>
                                </div>
                                <label class="col-lg-2 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-3">
                                    <select name="target_lang" class="form-control m-b" id="target"  required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($sheet->target_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Service">Service</label>

                                <div class="col-lg-3">
                                    <select name="service" class="form-control m-b" onchange="getTaskType()" id="service"  required=""/>
                                            <option disabled="disabled" selected=""></option>
                                             <?=$this->admin_model->selectServices($sheet->service)?>
                                    </select>
                                </div>
                                <label class="col-lg-2 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-3">
                                    <select name="unit" class="form-control m-b" id="unit"  required=""/>
                                             <option disabled="disabled" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($sheet->unit)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-3">
                                    <select name="task_type" class="form-control m-b" id="task_type"  required=""/>
                                            <option disabled="disabled" selected=""></option>
                                             <?=$this->admin_model->selectTaskType($sheet->task_type,$sheet->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-2 control-label" for="rate"> Rate</label>

                               <div class="col-lg-3">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" id="rate" value="<?=$sheet->rate?>" step="any" required="">
                               </div>
                                <label class="col-lg-2 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-3">
                                    <select name="currency" class="form-control m-b" id="currency" required="" />
                                             <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($sheet->currency)?>
                                    </select>
                                </div>
                            </div>

                            </div>
                            <?php } ?>
                            <hr>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>vendor/vmTicketView?t=<?=base64_encode($ticket)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>