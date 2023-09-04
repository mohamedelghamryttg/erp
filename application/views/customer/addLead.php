<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Lead 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/doAddLead" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer" required />
                                             <option disabled="disabled" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerLead(0,$brand)?>
                                    </select>
                                </div>
                            </div>
                  
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Region">Region</label>
                                <div class="col-lg-6">
                                    <select name="region" class="form-control m-b" id="region" onchange="getCountries()" required />
                                             <option disabled="disabled" selected="selected">-- Select Region --</option>
                                             <?=$this->admin_model->selectRegion()?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Country">Country</label>
                                <div class="col-lg-6">
                                    <select name="country" class="form-control m-b" id="country" required />
                                             <option disabled="disabled" selected="selected">-- Select Country --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Type">Type</label>
                                <div class="col-lg-6">
                                    <select name="type" class="form-control m-b" id="type" required />
                                             <option disabled="disabled" selected="selected">-- Select Type --</option>
                                             <?=$this->customer_model->selectType()?>
                                    </select>
                                </div>
                            </div>
                            <?php if($permission->follow == 3 || $permission->follow == 2){ ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Status</label>

                                <div class="col-lg-6">
                                      <select name="status" class="form-control m-b" id="status" required />
                                             <option disabled="disabled" selected="selected">-- Select Status --</option>
                                             <?=$this->customer_model->SelectStatus()?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Source">Source</label>

                                <div class="col-lg-6">
                                    <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source --</option>
                                             <?=$this->customer_model->selectSource()?>
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
                                    <a href="<?php echo base_url()?>admin/permission" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>