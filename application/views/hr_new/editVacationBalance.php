<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Employee Balance</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" id="form"action="<?php echo base_url()?>hr/doEditVacationBalance" method="post" name="addVacatin" enctype="multipart/form-data">
				 <div class="card-body">
                     <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                     <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>vacationBalance" hidden>
                    <?php } ?>
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Select Employee Name:</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value="<?=$this->db->query("SELECT name FROM employees WHERE id = '$row->emp_id'")->row()->name?>" name="employee" readonly>
                            </div>
                        </div> 

                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Balance:</label>
							<div class="col-lg-6">
								<input class="form-control"  name="current_year" value="<?=$row->current_year?>"/>
								
							</div>
						</div>
						 
					<!--	<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Double Days Balance:</label>
							<div class="col-lg-6">
								<input class="form-control"  name="double_days" value="<?=$row->double_days?>"/>
								
							</div>
						</div>-->
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Sick Leave:</label>
							<div class="col-lg-6">
								<input class="form-control" name="sick_leave" value="<?=$row->sick_leave?>"/>
								
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Marriage:</label>
							<div class="col-lg-6">
								<input class="form-control" name="marriage" value="<?=$row->marriage?>"/>
								
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Maternity Leave:</label>
							<div class="col-lg-6">
								<input class="form-control" name="maternity_leave"value="<?=$row->maternity_leave?>" />
								
							</div>
						</div>
						
					</div> 
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/vacationBalance" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>