<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Product Line</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>customer/doEditProductLine?id=<?=base64_encode($row->id)?>" method="post" enctype="multipart/form-data">
			<?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>customer/productLines" hidden>
                   <?php } ?>
				<div class="card-body">

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Product Line Name</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" name="name" value="<?=$row->name?>" required>	
							</div>
						</div>
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>customer/productLines" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>