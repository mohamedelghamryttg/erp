<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Vacation Plan</h3>
				
			</div> 
			<!--begin::Form--> 
			<form class="form" action="<?php echo base_url()?>hr/doAddPmVacationPlan" method="post"onsubmit="" enctype="multipart/form-data">
				<div class="card-body">
					<input type="" name="group_id" id="group_id" hidden value="<?=$group_id?>"> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Vacation From:</label>
							<div class="col-lg-6">
								<input name="date_from"type="text" id="date_from" autocomplete="off" onchange="" required=""class="form-control date_sheet_plan"  />
								
							</div> 
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Vacation TO:</label>
							<div class="col-lg-6">
								<input name="date_to"type="text" id="date_to" autocomplete="off" required=""class="form-control date_sheet_plan" onchange=""  />
								
							</div>
						</div>
						
					</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/pmVacationPlan" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
             $(function() {
               $('.date_sheet_plan').datepicker({ format: 'yyyy-mm-dd' });
        	   $("#date_from").datepicker().on('changeDate', function(ev) { checkStartAndEndOfQuarter(document.getElementById('date_from').value);checkForPmsVacationPlansAtSameRegion(0);onAddVacationPlan(0); });
        	   $("#date_to").datepicker().on('changeDate', function(ev) { checkStartAndEndOfQuarter(document.getElementById('date_to').value);checkForPmsVacationPlansAtSameRegion(0);onAddVacationPlan(0); });
             });
        </script>