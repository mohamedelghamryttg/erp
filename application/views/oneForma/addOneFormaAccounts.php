<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add One Forma Accounts </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" onsubmit="return disableAddButton();" id="form"action="<?php echo base_url()?>oneForma/doAddOneFormaAccounts" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Initial:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="initial" />
								
							</div>
						</div>
						 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Password:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="password" />
								
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Country:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="country" />
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Language:</label>
							<div class="col-lg-6">
								<input class="form-control" value="" name="language" />
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">From:</label>
							<div class="col-lg-6">
								<input class="form-control" value=""type="number" name="num_from" />
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">TO:</label>
							<div class="col-lg-6">
								<input class="form-control" value=""type="number" name="num_to" />
								
							</div>
						</div>
						
                        <div class="form-group row ">
                            <label class="col-lg-3 col-form-label text-right" >PMs:</label>

                            <div class="col-lg-6">
                                <select name="redirect_to[]" id="redirect_to" class="form-control" multiple="multiple" style="display: none;">
                                     <?=$this->admin_model->selectMultiplePm(0,$this->brand)?>
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
