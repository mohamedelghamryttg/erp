<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Missing Attendance Request</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doAddMissingAttendance" method="post" onsubmit="return disableAddButton();" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Date Time:</label>
							<div class="col-lg-6">
								<input name="date"type="text" id="date"autocomplete="off" required=""class="form-control"  />
								
							</div>
						</div>
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Signing Type:</label>

                            <div class="col-lg-6">
                                <select name="TNAKEY" id="TNAKEY" required class="form-control">
                                            <option disabled="disabled" selected="selected">-- Select Type --</option>
                                             <option value="1">Sign In</option>
                                             <option value="2">Sign Out</option>
                                </select>
                            </div>
                        </div>
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/missingAttendance" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>