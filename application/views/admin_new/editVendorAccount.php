<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit User</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>admin/doEditUser" method="post" enctype="multipart/form-data">
				<div class="card-body">

					    <input type="text" name="id" value="<?=$id?>" hidden="">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Name</label>
							<div class="col-lg-6">
								 <input type="text" class=" form-control" value="<?=$row->name?>" name="name" data-maxlength="300" id="name" required>
								
							</div>
						</div>


						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Email</label>
							<div class="col-lg-6">
								<input type="email"  placeholder="E-mail" class=" form-control" value="<?=$row->email?>" name="email" id="email" required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Password</label>
							<div class="col-lg-6">
								<input type="password" id="inputPassword" placeholder="Password" class=" form-control" 
                                    value="<?=base64_decode($row->password)?>" name="password"  required="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Status</label>
							<div class="col-lg-6">
								 <select name="status" class="form-control m-b" id="status">
                                        <option></option>
                                        <?php if($row->status == 1){ ?>
                                        <option value="1" selected="">Active</option>
                                        <option value="0">deactive</option>
                                        <?php }else{ ?>
                                        <option value="1">Active</option>
                                        <option value="0" selected="">deactive</option>
                                        <?php } ?>
                                    </select>
							</div>
						</div>
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>admin/vendorsAccounts" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>