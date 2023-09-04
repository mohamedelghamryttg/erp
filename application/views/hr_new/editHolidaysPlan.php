<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">  Edit Holiday</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doEditHolidaysPlan" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                            <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                         <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>holidaysPlan" hidden>
                         <?php } ?>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Holiday Name:</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" name="holiday_name" data-maxlength="300" id="name" value="<?= $row->holiday_name?>" required>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Holiday Date:</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control date_sheet" name="holiday_date" type="text" onblur="validateHolidayDate(0);" id="holiday_date" autocomplete="off"value="<?= $row->holiday_date?>" required>
                            </div>
                        </div> 

                      
					</div> 
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/holidaysPlan" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>