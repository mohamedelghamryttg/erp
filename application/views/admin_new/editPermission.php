<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Permission</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>admin/doEditPermission" method="post" enctype="multipart/form-data">
				<div class="card-body">

					    <input type="text" name="id" value="<?=base64_encode($permission->id)?>" hidden="">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Screen</label>
							<div class="col-lg-6">
								<select name="screen" class="form-control m-b" required  id="screen">
                                             <option disabled="disabled" value=""></option>
                                             <?=$this->admin_model->selectScreen($permission->screen)?>
                                    </select>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Role</label>
							<div class="col-lg-6">
								<select name="role" class="form-control m-b" required  id="role">
                                             <option disabled="disabled"></option>
                                             <?=$this->admin_model->selectRole($permission->role)?>
                                    </select>
							</div>
						</div>

					    <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Follow-Up</label>
							<div class="col-lg-6">
								<select name="follow" class="form-control m-b" id="follow">
                                             <option value="0"></option>
                                             <?=$this->admin_model->selectFollowUp($permission->follow)?>
                                    </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">View</label>
							<div class="col-lg-6">
								<?php if($permission->view == "2"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->view == "1"){$s1 = "selected=selected";$s2="";}
                                            else{$s1="";$s2="";} ?>
                                    <select name="view" class="form-control m-b" required  id="view">
                                             <option disabled="disabled"></option>
                                             <option value="2" <?=$s2?>>View only assigned</option>
                                             <option value="1"<?=$s1?>>View ALL</option>
                                    </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Can Add</label>
							<div class="col-lg-6">
								<?php if($permission->add == "1"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->add == "0"){$s1 = "selected=selected";$s2="";} ?>
                                    <select name="add" class="form-control m-b" required  id="add">
                                             <option disabled="disabled"></option>
                                             <option value="1" <?=$s2?>>Yes</option>
                                             <option value="0" <?=$s1?>>No</option>
                                    </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Can Edit</label>
							<div class="col-lg-6">
								<?php if($permission->edit == "1"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->edit == "0"){$s1 = "selected=selected";$s2="";} ?>
                                    <select name="edit" class="form-control m-b" required  id="edit">
                                             <option disabled="disabled"></option>
                                             <option value="1" <?=$s2?>>Yes</option>
                                             <option value="0" <?=$s1?>>No</option>
                                    </select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Can Delete</label>
							<div class="col-lg-6">
								<?php if($permission->delete == "1"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->delete == "0"){$s1 = "selected=selected";$s2="";} ?>
                                    <select name="delete" class="form-control m-b" required  id="delete">
                                             <option disabled="disabled">-- Select Permission --</option>
                                             <option value="1" <?=$s2?>>Yes</option>
                                             <option value="0" <?=$s1?>>No</option>
                                    </select>
							</div>
						</div>
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>admin/permission" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>