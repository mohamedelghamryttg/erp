<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Vendor</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>vendor/doEditVendor" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>vendor" hidden>
                    <?php } ?>
                            <input type="text" name="id" id="id"value="<?=base64_encode($id)?>" hidden="">

                      
                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Name:</label>
							<div class="col-lg-6">
								<input class="form-control"  value="<?=$row->name?>" name="name"/>
								
							</div>
						</div>
						 <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email:</label>
							<div class="col-lg-6">
								<input class="form-control" onblur="vendoremailedit()" id="vendorEmailEdit" value="<?=$row->email?>" name="email" required />
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Contact:</label>
							<div class="col-lg-6">
								<input class="form-control" value="<?=$row->contact?>" name="contact" required/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Country of Residence:</label>
							<div class="col-lg-6">
                                <select  class="form-control" name="country"id="country" required >
                                            <option disabled="disabled" selected="selected">-- Select Country --</option>
                                             <?=$this->admin_model->selectAllCountries($row->country)?>
                                </select>
                            </div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Mother Tongue:</label>
							<div class="col-lg-6">
								<input class="form-control"  value="<?=$row->mother_tongue?>" name="mother_tongue" required />
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Profile:</label>
							<div class="col-lg-6">
								<input class="form-control" value="<?=$row->profile?>" name="profile" required=""/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Type:</label>
							<div class="col-lg-6">
								<select  class="form-control" name="type"  id="type" required>
                                          <option disabled="disabled" selected="selected">-- Select Type --</option>
                                             <?=$this->vendor_model->selectVendorType($row->type)?>
                                </select>
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Status:</label>
							<div class="col-lg-6">
								<select  class="form-control" name="status" >
                                     <?=$this->vendor_model->selectVendorStatus($row->status)?>

                                </select>
								
							</div>
						</div>  

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Color:</label>
							<div class="col-lg-6">
								<select  class="form-control" name="color" id="color" onchange="colorComment();">
                                     <option value="" selected="selected">-- Blank --</option>
                                       <?=$this->vendor_model->selectVendorColor($row->color)?>

                                </select>
								
							</div>
						</div>  
						<div class="form-group row" id="color_comment" style="display: none;">
							<label class="col-lg-3 col-form-label text-right">Color Comment:</label>
							<div class="col-lg-6">
								<textarea  class="form-control"name="color_comment" value="" rows="6" ></textarea>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">CV Upload:</label>
							<div class="col-lg-6">
								<input class="form-control" type="file"  name="cv" id="cv" />
								
							</div>
						</div>
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Subject Matter:</label>

                            <div class="col-lg-6">
                                <select  name="subject[]" multiple class="form-control " id="subject" required >
                                    <?=$this->admin_model->selectMultiFields($row->subject)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" >Tools:</label>

                            <div class="col-lg-6">
                                <select  name="tools[]" multiple class="form-control" id="tools" required >
                                    <?=$this->sales_model->selectMultiTools($row->tools)?>
                                </select>
                            </div>
                        </div> 

					</div> 
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>vendor" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>