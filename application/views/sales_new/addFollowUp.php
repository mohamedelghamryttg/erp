<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Follow Up</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>sales/doAddFollowUp" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				<input name="id" type="hidden" value="<?=$id?>" >
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Follow UP Date</label>
							<div class="col-lg-6">
								<input size="16" type="text" class="form_datetime form-control" onchange="checkDate('follow_up')" name="follow_up" id="follow_up">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Customer Status</label>
							<div class="col-lg-6">
								 <select name="call_status" class="form-control m-b" id="call_status" required />
                                             <option value="" selected="selected">-- Customer Status --</option>
                                             <?=$this->sales_model->selectActivityStatus()?>
                                    </select>		
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Next Action</label>
							<div class="col-lg-6">
								<input size="16" type="text" class="form_datetime form-control" onchange="checkDate('new_hitting')" name="new_hitting" id="new_hitting">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Comment</label>
							<div class="col-lg-6">
								<textarea name="comment" class="form-control" rows="6"></textarea>
							</div>
						</div>
						
						</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>sales/followUp?t=<?=base64_encode($id)?>" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>