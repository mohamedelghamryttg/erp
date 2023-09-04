<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Task Type</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>admin/doEditTaskType/<?=$task_type->id?>" method="post" enctype="multipart/form-data">
				<div class="card-body">

					    <input type="text" name="id" value="<?=base64_encode($task_type->id)?>" hidden="">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Task Type</label>
							<div class="col-lg-6">
								<input type="text" class=" form-control" value="<?=$task_type->name?>" name="name" data-maxlength="300" id="first_name" required>
								
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Services</label>
							<div class="col-lg-6">
								<select name="parent" class="form-control m-b" id="role">
                                        <option></option>
                                        <?=$this->admin_model->selectServices($task_type->parent)?>
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