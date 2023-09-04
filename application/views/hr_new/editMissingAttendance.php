<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Edit Missing Attendance Request</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doEditMissingAttendance" method="post" enctype="multipart/form-data">
				<div class="card-body">
					<input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                  <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>customer" hidden>
                    <?php } ?>
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Date Time:</label>
							<div class="col-lg-6">
								<input name="date"type="text" id="date"autocomplete="off" value="<?= $row->SRVDT?>" required=""class="form-control"  />
								
							</div>
						</div>
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Signing Type:</label>

                            <div class="col-lg-6">
                                <select name="TNAKEY" id="TNAKEY" required class="form-control">
                                            <option disabled="disabled">-- Select Type --</option>
                                     <?php if($row->TNAKEY == 1){ ?>
                                         <option value="1" selected="selected">Sign In</option>
                                         <option value="2">Sign Out</option>
                                     <?php }elseif ($row->TNAKEY == 2) { ?> 
                                          <option value="1">Sign In</option>
                                         <option value="2" selected="selected">Sign Out</option>
                                      <?php }else{ ?> 
                                        <option value="1">Sign In</option>
                                          <option value="2">Sign Out</option>
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