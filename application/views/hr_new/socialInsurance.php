   <?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
	<?php  } ?>
	<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
   <?php  } ?>
<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								
								
							</div>
						</div>
						<!--end::Subheader-->

						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
							

						  <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
					<div class="card-header">
						<h3 class="card-title">Social Insurance Filter</h3>
					</div>
                    <?php 
               if(isset($_REQUEST['insurance_number'])){
                    $insurance_number = $_REQUEST['insurance_number'];
                }else{
                    $insurance_number = "";
                }
                if(isset($_REQUEST['employee_name'])){
                    $employee_name = $_REQUEST['employee_name'];
                }else{
                    $employee_name = "";
                }
         ?>
						<form class="form" id="socialInsurance" action="<?php echo base_url()?>hr/socialInsurance" method="get" enctype="multipart/form-data">
						 <div class="card-body">

						  <div class="form-group row">
                <label class="col-lg-2 control-label" for="role name">Employee Name</label>
                        <div class="col-lg-3">
                            <select name="employee_name" class="form-control m-b"/>
                                    <option value="">-- Select Employee --</option>
                                  <?=$this->hr_model->selectEmployee(0)?>
                            </select>
                        </div>
						   <label class="col-lg-2 col-form-label text-lg-right">Social Insurance Number:</label>
      						   <div class="col-lg-3">
      						       <input type="text" class="form-control" value = "<?= $insurance_number ?>" name="insurance_number" autocomplete="off" />
      						   </div> 

						  
						  </div>

						 
						 <div class="card-footer">
						  <div class="row">
						   <div class="col-lg-2"></div>
						   <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search" type="submit">Search</button>	
                           <button class="btn btn-secondary" onclick="var e2 = document.getElementById('socialInsurance'); e2.action='<?=base_url()?>hr/exportSocialInsurance'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>	
                    	   <a href="<?=base_url()?>hr/socialInsurance" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

						   </div>
						  </div>
						 </div>
						</form>
                       </div>
                     </div>
                        
						  <!-- end search form -->
						
								<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Social Insurance </h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>hr/addSocialInsurance_test" class="btn btn-primary font-weight-bolder"> 
						<?php } ?>
						<span class="svg-icon svg-icon-md">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24" />
									<circle fill="#000000" cx="9" cy="15" r="6" />
									<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>Add Social Insurance</a>
						<!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
              <tr>
                    <th>#ID</th>
                    <th>Employee</th>
                    <th>Gender</th>
                    <th>Basic</th>
                    <th>Variable</th>
                    <th colspan="9" >Insurance Number</th>
                    <th>Currency</th>
                    <th>Country</th>
                    <th>Total Deductions</th>
                    <th>Bitrh Date</th>
                    <th>Activation Date</th>
                    <th>Deactivation Date</th>
                    <th>Year</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Edit</th>
                    <th>Delete</th> 
              </tr>
            </thead>
           <tbody>
           <?php foreach ($socialInsurance->result() as $row) { ?>
              <tr> 
                   
                    <td><?=$row->id ?></td>
                    <td><?= $this->db->query("SELECT name FROM employees WHERE id = '$row->employee_id'")->row()->name;?></td>
                    <td>
                    	<?php 
                    	 $gender = $this->db->query("SELECT gender FROM employees WHERE id = '$row->employee_id'")->row()->gender;  
                    	 if($gender == 1){
                    	 	echo "Male";
                    	 }elseif($gender == 2){
                    	 	echo "Female";
                    	 }
                    	?>
                    		
                    </td>
                  
                    <td><?=$row->basic ?></td>
                    <td><?=$row->variable ?></td>
                   
                       
                          <?php  $insuranceNumber = explode(" ", $row->insurance_number); ?>
                           <td width="3px"><?=$insuranceNumber[0]?></td>
                           <td width="3px"><?=$insuranceNumber[1]?></td>
                           <td width="3px"><?=$insuranceNumber[2]?></td>
                           <td width="3px"><?=$insuranceNumber[3]?></td>
                           <td width="3px"><?=$insuranceNumber[4]?></td>
                           <td width="3px"><?=$insuranceNumber[5]?></td>
                           <td width="3px"><?=$insuranceNumber[6]?></td>
                           <td width="3px"><?=$insuranceNumber[7]?></td>
                           <td width="3px"><?=$insuranceNumber[8]?></td>
                    <td><?= $this->admin_model->getCurrency($row->currency) ?></td>
                    <td><?= $this->admin_model->getCountry($row->country) ?></td>
                    <td><?= $row->total_deductions ?></td>
                    <td><?=$this->db->query("SELECT birth_date FROM employees WHERE id = '$row->employee_id'")->row()->birth_date;?></td>
                    <td><?=$row->activation_date ?></td>
                    <td><?=$row->deactivation_date?></td>
                    <td><?php echo $this->hr_model->getYear($row->year);?></td>
                    <td><?=$row->created_at ?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                         <a href="<?php echo base_url()?>hr/editSocialInsurance?i=<?php echo base64_encode($row->id);?>"  class="btn btn-sm btn-clean btn-icon" title="Edit details">
									                  <i class="la la-edit"></i> 
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>hr/deleteSocialInsurance?i=<?php echo base64_encode($row->id);?>" title="delete" 
                     class="btn btn-sm btn-clean btn-icon" onclick="return confirm('Are you sure you want to delete this Department?');">
						<i class="la la-trash"></i>
                      </a>
                      <?php } ?>
                    </td>
              </tr>
              <?php }?>
                  
            </tbody>
                    </table>
                    <!--end: Datatable-->
                    <!--begin::Pagination-->
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                         <?=$this->pagination->create_links()?>  
                  </div>
                  <!--end:: Pagination-->
                  </div>
                </div>
                <!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->