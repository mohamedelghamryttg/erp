<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit One Forma Accounts</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" id="form"action="<?php echo base_url()?>oneForma/doEditOneFormaAccounts" method="post" name="editOneFormaAccounts" enctype="multipart/form-data">
				 <div class="card-body">
                     <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                     <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>oneFormaAccounts" hidden>
                    <?php } ?>
                      
                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">First Name:</label>
							<div class="col-lg-6">
								<input class="form-control"  name="first_name" value="<?=$row->first_name?>"/>
								
							</div>
						</div>
						 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Last Name:</label>
							<div class="col-lg-6">
								<input class="form-control"  name="last_name" value="<?=$row->last_name?>"/>
								
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Username:</label>
							<div class="col-lg-6">
								<input class="form-control" name="username" value="<?=$row->username?>"/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email:</label>
							<div class="col-lg-6">
								<input class="form-control" name="email" value="<?=$row->email?>"/>
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Password:</label>
							<div class="col-lg-6">
								<input class="form-control" name="password" value="<?=$row->password?>"/>
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Country:</label>
							<div class="col-lg-6">
								<input class="form-control" name="country" value="<?=$row->country?>"/>
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Language:</label>
							<div class="col-lg-6">
								<input class="form-control" name="language" value="<?=$row->language?>"/>
								
							</div>
						</div> 
						 <div class="form-group row ">
                            <label class="col-lg-3 col-form-label text-right" >PMs:</label>

                            <div class="col-lg-6">
                                <select name="redirect_to[]" id="redirect_to" class="form-control" multiple="multiple" style="display: none;">
                                	<?=$this->admin_model->selectMultiplePm($row->redirect_to,$this->brand)?>
                                </select>
                            </div>
                        </div> 
						
					</div> 
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>oneForma/oneFormaAccounts" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>