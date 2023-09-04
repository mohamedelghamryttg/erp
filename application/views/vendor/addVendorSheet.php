<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Lead 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doAddVendorSheet" method="post"  onsubmit="return disableAddButton();" enctype="multipart/form-data">

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
                                    <select name="vendor" class="form-control m-b" id="vendor" required onchange="checkCountryEGY();" />
                                             <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                             <?=$this->vendor_model->selectVendor(0,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_lang" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_lang" class="form-control m-b" id="target" required />
                                             <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>
      
      						<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Dialect">Dialect</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="dialect" id="dialect">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate"> Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" value="0" id="rate" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject[]" multiple class="form-control m-b" id="subject" required />
                                             <?=$this->admin_model->selectFields()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Tools">Tools</label>

                                <div class="col-lg-6">
                                    <select name="tools[]" multiple class="form-control m-b" id="tools" required />
                                             <?=$this->sales_model->selectTools()?>
                                    </select>
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
                                    <a href="<?php echo base_url()?>vendor/vendorSheet" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
<script>
        // check if country = egy -> currency = egp
        function checkCountryEGY(){
                         
            var option = $("#vendor option:selected").attr('country');

           if(option == "369"){   
                $('#currency').val("1");                    
                $('#currency').select2().trigger('change');
                $('#currency').attr("readonly",true);
                 $('#currency').select2("readonly",true);
            }else{     
                $('#currency').removeAttr("readonly");
                $('#currency').select2("readonly", false);
            }    
                      
        }        
    
</script>