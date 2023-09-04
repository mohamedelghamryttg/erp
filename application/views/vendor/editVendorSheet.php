<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Vendor Record 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doEditVendorSheet" method="post" enctype="multipart/form-data">
							<input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">
                    
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Search Vendor name">Search Vendor Name ...</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="vendor_name" onkeypress="searchOptions()" id="vendor_name">
                                </div>
                            </div>
                            <div style="display: none;">
                            <select class="form-control m-b" id="vendorList"/>
                                     <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                     <?=$this->vendor_model->selectVendor(0,$brand)?>
                            </select>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Vendor">Vendor</label>

                                <div class="col-lg-6">
                                    <select name="vendor" class="form-control m-b" id="vendor" required />
                                             <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                             <?=$this->vendor_model->selectVendor($row->vendor,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_lang" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->source_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_lang" class="form-control m-b" id="target" required />
                                             <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->target_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Dialect">Dialect</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="dialect" value="<?=$row->dialect?>" id="dialect">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices($row->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTaskType($row->task_type,$row->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($row->unit)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate"> Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" value="<?=$row->rate?>" class=" form-control" name="rate" data-maxlength="300" value="0" id="rate" step="any" required>
                               </div>
                             </div>

							<div class="form-group">
                               <label class="col-lg-3 control-label" for="rate">Special Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" value="<?=$row->special_rate?>" class=" form-control" name="special_rate" data-maxlength="300" value="0" id="special_rate" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($row->currency)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" rows="6"><?=$row->comment?></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>vendor/vendorSheet" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
