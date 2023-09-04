<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Vacation Plan </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" id="form"action="<?php echo base_url()?>hr/doEditLEVacationPlan" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                     <input type="text" name="id" id="id" hidden="" value="<?=base64_encode($id)?>">
                     <input type="" name="group_id" id="group_id" hidden value="<?=$group_id?>"> 
                     <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>leVacationPlan" hidden>
                    <?php } ?>


                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Vacation From:</label>
							<div class="col-lg-6">
								<input name="date_from"type="text" id="date_from"autocomplete="off" value="<?=$row->date_from?>" required=""class="form-control date_sheet_plan"  onchange="checkStartAndEndOfQuarter(document.getElementById('date_from').value);checkForPmsVacationPlansAtSameRegion(1);onAddVacationPlan(1);"  />
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Vacation TO:</label>
							<div class="col-lg-6">
								<input name="date_to"type="text" id="date_to"autocomplete="off" value="<?=$row->date_to?>" required=""class="form-control date_sheet_plan" onchange="checkStartAndEndOfQuarter(document.getElementById('date_to').value);checkForPmsVacationPlansAtSameRegion(1);onAddVacationPlan(1);" />
								
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
        $("#date_from").datepicker().on('changeDate', function(ev) { checkStartAndEndOfQuarter(document.getElementById('date_from').value);checkForPmsVacationPlansAtSameRegion(1);onAddVacationPlan(1); });
        $("#date_to").datepicker().on('changeDate', function(ev) { checkStartAndEndOfQuarter(document.getElementById('date_to').value);checkForPmsVacationPlansAtSameRegion(1);onAddVacationPlan(1); });
        });
</script>