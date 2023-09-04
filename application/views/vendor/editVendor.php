<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Vendor 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doEditVendor" method="post" enctype="multipart/form-data">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>vendor" hidden>
                    <?php } ?>
                            <input type="text" name="id" id="id"value="<?=base64_encode($id)?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->name?>" name="name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Email</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onblur="vendoremailedit()" id="vendorEmailEdit" value="<?=$row->email?>" name="email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Contact</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->contact?>" name="contact" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Phone Number</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" pattern="^[0-9-+\s()]*$" value="<?=$row->phone_number?>" name="phone_number" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Country of Residence</label>

                                <div class="col-lg-6">
                                    <select name="country" class="form-control m-b" id="country" required />
                                             <option disabled="disabled" selected="selected">-- Select Country --</option>
                                             <?=$this->admin_model->selectAllCountries($row->country)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Mother Tongue</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->mother_tongue?>" name="mother_tongue" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Profile</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->profile?>" name="profile" required="">
                                </div>
                            </div>
                  
                  			<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Type</label>
                                <div class="col-lg-6">
                                    <select name="type" class="form-control m-b" id="type" required />
                                             <option disabled="disabled" selected="selected">-- Select Type --</option>
                                             <?=$this->vendor_model->selectVendorType($row->type)?>
                                    </select>
                                </div>
                            </div>
            
            				<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Status</label>
                                <div class="col-lg-6">
                                    <select name='status' class="form-control m-b">
                                       <?=$this->vendor_model->selectVendorStatus($row->status)?>
                                    </select>
                                </div>
                            </div>
            
            				<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Color</label>

                            <div class="col-lg-6">
                         <select name="color" class="form-control m-b color" id="color" onchange="colorComment();">
                            <option value="" selected="selected">-- Blank --</option>
                            <?=$this->vendor_model->selectVendorColor($row->color)?>
                         </select>
                                </div>
                            </div>
                              <div class="form-group"id="color_comment" style="display: none;">
                                <label class="col-lg-3 control-label">Color Comment</label>
                                <div class="col-lg-6">
                                   <textarea name="color_comment" class="form-control"  value="" rows="6" ></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">CV Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="cv" id="cv">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Certificate Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="certificate" id="certificate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">NDA Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="NDA" id="NDA">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject[]" multiple class="form-control m-b" id="subject" required />
                                             <?=$this->admin_model->selectMultiFields($row->subject)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Tools">Tools</label>

                                <div class="col-lg-6">
                                    <select name="tools[]" multiple class="form-control m-b" id="tools" required />
                                             <?=$this->sales_model->selectMultiTools($row->tools)?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>vendor" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

   <script type="text/javascript">
       
       
   </script>