<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Department </h3>
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>hr/doEditDepartment" method="post" enctype="multipart/form-data">
				<div class="card-body">
                         <input type="text" name="id" value="<?=base64_encode($department->id)?>" hidden="">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Department:</label>
							<div class="col-lg-6">
								<input name="name" id="name" class="form-control"value="<?=$department->name?>"  />
								
							</div>
						</div>
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Division:</label>

                            <div class="col-lg-6">
                                <select name="division" class="form-control" id="division" required="">
                                    <option></option>
                                    <?=$this->hr_model->selectDivision($department->division)?>
                                </select>
                            </div>
                        </div>
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary"href="<?php echo base_url()?>hr/department" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>