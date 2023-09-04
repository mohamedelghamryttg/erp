<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Task Type</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>admin/doAddTaskType" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Task Type</label>
							<div class="col-lg-6">
								<input name="name" id="name" class="form-control" data-maxlength="300" />
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Service</label>
							<div class="col-lg-6">
								<select name="parent" class="form-control m-b" id="parent" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectServices()?>
                                    </select>
								
							</div>
						</div>

					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>admin/task_type" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>