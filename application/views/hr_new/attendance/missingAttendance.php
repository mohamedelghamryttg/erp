 <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">          
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container-fluid">                
                <div class="d-flex align-items-center mr-1">
                    <?php if($this->session->flashdata('true')){ ?>
                        <div class="alert alert-success col-lg-12" role="alert">
                            <span class="fa fa-check-circle"></span>
                            <span><strong><?=$this->session->flashdata('true')?></strong></span>
                        </div>
                    <?php  } ?>
                    <?php if($this->session->flashdata('error')){ ?>
                        <div class="alert alert-danger col-lg-12" role="alert">
                            <span class="la la-warning icon-lg"></span>
                            <span><strong><?=$this->session->flashdata('error')?></strong></span>
                        </div>
                     <?php  } ?>
                </div>

              <!-- start search form card --> 
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                      <h3 class="card-title"> Missing Attendance Filter</h3>
                    </div>
                     <?php 
              
                if(isset($_REQUEST['employee_name'])){
                    $employee_name = $_REQUEST['employee_name'];
                }else{
                    $employee_name = "";
                }
         ?>
            <form class="form" id="missingAttendance" action="<?php echo base_url()?>hr/missingAttendance" method="get" enctype="multipart/form-data">
             <div class="card-body">

                <div class="form-group row">

                   <label class="col-lg-2 control-label text-lg-right">Date:</label>
                   <div class="col-lg-3">
                    <input type="text" class="form-control date_sheet" name="date"  />
                   </div>  
                    <?php if($this->role == 31 || $this->role == 46 || $this->role == 21){ ?>
                    <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>

                    <div class="col-lg-4">
                        <select name="employee_name" class="form-control ">
                                <option value="">-- Select --</option>
                              <?=$this->hr_model->selectEmployee($employee_name)?>
                        </select> 
                    </div>
                    <?php } ?>
                </div>

             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search" type="submit">Search</button> 
                           <a href="<?=base_url()?>hr/missingAttendance" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                      <h3 class="card-label">  Missing Attendance List </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                     <?php if($permission->add == 1){ ?>
                  <a href="<?=base_url()?>hr/addmissingAttendance" class="btn btn-primary btn-sm font-weight-bolder mr-2"><i class="flaticon-add-circular-button" aria-hidden="true"></i> Add Missing Access Request</a>
             
                <?php } if($this->role == 31 || $this->role == 46 || $this->role == 21){?>
                      <a href="<?=base_url()?>hr/addMissingAttendanceForEmployee" class="btn btn-info btn-sm font-weight-bolder " ><i class="flaticon2-avatar" aria-hidden="true"></i> Add Missing Access For Employee</a>

                <?php } ?> 
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table  table-head-custom table-hover" >
                         <thead>
              <tr>             
                     <th>ID</th>
                     <th>Employee ID</th>
                     <th>Employee Name</th>
                     <th>Date </th>
                     <th>Sign In/Out</th>
                      <th>Location</th>
                     <th>Created At</th>
                     <th>Manager Approval</th>                    
                     <th>Edit</th>
                     <th>Delete</th>
              </tr>
            </thead>
           <tbody>
            <?php
              foreach($missingAttendance->result() as $row)
                {
            ?>
              <tr>
                <td><?=$row->id ?></td>
                <td><?=$row->USRID ?></td>
                <td><?=$this->hr_model->getEmployee($row->USRID)?></td>
                <td><?= $row->SRVDT?></td>
                  <?php if($row->TNAKEY == 1){ ?>
                      <td><?php echo "Sign In";?></td>
                  <?php }elseif($row->TNAKEY == 2){?>
                     <td><?php echo "Sign Out";?></td>
                   <?php }?>
                       <td><?= $this->hr_model->getLocationType($row->location)?></td>
                <td><?= $row->created_at?></td>
                      <td><?=$this->hr_model->getVacationStatus($row->manager_approval);?></td>
                   
                 <td>
                    <?php if($permission->edit == 1){ ?>
                        <?php if ($row->manager_approval == 0 ){ ?>
                         <a href="<?php echo base_url()?>hr/editMissingAttendance?i=<?php echo base64_encode($row->id);?>" class="btn btn-sm btn-clean btn-icon">
                          <i class="la la-edit"></i>
                              <?php } ?> 
                          </a>
                    <?php } ?>
                </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                        <?php if ($row->manager_approval == 0){ ?>
                  <a href="<?php echo base_url()?>hr/deleteMissingAttendance?i=<?php echo base64_encode($row->id);?>" title="delete" 
                 class="btn btn-sm btn-clean btn-icon" onclick="return confirm('Are you sure you want to delete this record ?');">
                         <i class="la la-trash"></i>

                        <?php } ?> 
                      </a>
                      <?php } ?>
                    </td>
              </tr>
              <?php
                }
            ?>    
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