 <?php  
$title = $this->db->query(" SELECT title FROM employees WHERE id = '$this->emp_id' ")->row()->title;
    if ($title == 11 or $title == 15 or $title == 16 or $title == 17 or $title == 28 or $title == 37 or $title == 40 or $title == 44 or $title == 48 or $title == 51 or $title == 54 or $title == 56 or $title == 59 or $title == 77 or $title == 93 or $title == 96 or $title == 97 or $title == 98){ 
      $start_date = date("Y-m-d", strtotime("-45 days"));
      $end_date = date("Y-m-d",strtotime("+1 day"));
     $data = $this->hr_model->getMissingAttendanceRequests($this->emp_id,$title,$start_date,$end_date)->result();
     
      ?> 
      <!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Subheader-->
            <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
              <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center mr-1">
                  
                </div>
                <!--end::Info-->
                
              </div>
            </div>
            <!--end::Subheader-->

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              
 <div class="card">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
      <div class="card-title btn_lightgray">
              <button id="missing_requests" onclick="showAndHide('missing_requests_filter','missing_requests');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark">
                <i class="fa fa-chevron-down"></i>
              </button>
              <h5 class="card-label">Pending Approval Requests <span class="btn btn-danger"><span><?php echo count($data) ?></span></span></h5>
      </div>
      <div class="card-toolbar">
       
      
      </div>
    </div>
    <div class="card-body" id="missing_requests_filter" style="display: none;">
      <!--begin: Datatable-->
      <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                 <thead>

              <tr>
                     <th>ID</th>
                     <th>Employee ID</th>
                     <th>Employee Name</th>
                     <th>Date </th>
                     <th>Sign In/Out</th>
                     <th>Manager Approval</th>
                     <th>Hr Approval</th>
              </tr>
            </thead>
            <tbody>
              <?php   foreach($data as $row)  {  ?>
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
                 
                             <?php if($title == 37){ ?>  

                            <td><?= $this->hr_model->getVacationStatus($row->manager_approval);?></td>
                             <?php  if($row->manager_approval == 0 ){ ?>
                              <td><?= $this->hr_model->getVacationStatus($row->hr_approval);?></td>
                                 <?php }else{ ?> 
                                   <td rowspan="" ><a href="#hrModal<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success" >HR Approval</a></td>
                                 <?php  } ?>


                             <?php }else{ ?> 
                              <?php  if($row->manager_approval == 0 ){ ?>
                             <td rowspan="" ><a href="#managerModal<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success" >Manager Approval</a></td>  
                              <?php }else{ ?> 
                                <td><?= $this->hr_model->getVacationStatus($row->manager_approval);?></td>
                               <?php  } ?>

                             <td><?= $this->hr_model->getVacationStatus($row->hr_approval);?></td>
                             <?php } ?>     
              </tr>
               <!-- start manager pop up form -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="managerModal<?php echo $row->id;?>" class="modal fade">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                         <h4 class="modal-title">Manager Approval</h4>
                     </div>
                     <div class="modal-body">
                       
                <div class="form-group" >
                   <label class="col-lg-4 control-label" style="padding: 9px ; margin: 5px;" for="role name">Manager Action</label>
                    <input name="id" id="id_<?=$row->id?>" type="hidden" value="<?php echo $row->id;?>" >

                    <div class="col-lg-7" style="padding: 5px ; margin: 5px;">
                        <select name="manager_approval"  id="manager_approval_<?=$row->id?>" class="form-control m-b"/>
                                 <option value="">-- Select status --</option>
                                  <option value="1">Approve</option>
                                  <option value="2">Reject</option>
                        </select>
                    </div> 
                 </div>
                     <button class="btn btn-danger  btn-block"  type="submit" aria-hidden="true" data-dismiss="modal" class="close" onclick="missingAttendanceApprovalForManager(<?=$row->id?>)">Submit</button>

               </div>
             </div>
           </div>
         </div>
            <!-- end pop up form -->

            <!-- start hr pop up form -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="hrModal<?php echo $row->id;?>" class="modal fade">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                         <h4 class="modal-title">HR Approval</h4>
                     </div>
                     <div class="modal-body">
                       
                <div class="form-group" >
                   <label class="col-lg-4 control-label" style="padding: 9px ; margin: 5px;" for="role name">HR Action</label>
                    <input name="id" id="id_<?=$row->id?>" type="hidden" value="<?php echo $row->id;?>" >

                    <div class="col-lg-7" style="padding: 5px ; margin: 5px;">
                        <select name="hr_approval"  id="hr_approval_<?=$row->id?>" class="form-control m-b"/>
                                 <option value="">-- Select status --</option>
                                  <option value="1">Approve</option>
                                  <option value="2">Reject</option>
                        </select>
                    </div> 
                 </div>
                     <button class="btn btn-danger  btn-block"  type="submit" aria-hidden="true" data-dismiss="modal" class="close" onclick="missingAttendanceApprovalForHR(<?=$row->id?>)">Submit</button>

               </div>
             </div>
           </div>
         </div>
            <!-- end pop up form -->
              <?php  } ?> 

            </tbody>  
      </table>
      <!--end: Datatable-->
    </div>
  </div>
  <!--end::Card-->
  </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->
  <?php  } ?> 


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
                <!--begin::Info-->
                <div class="d-flex align-items-center mr-1">
                  
                </div>
                <!--end::Info-->
                
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
            <h3 class="card-title">Search </h3>
          </div>

            <form class="form" id="attendance" action="<?php echo base_url()?>hr/attendance" method="post" enctype="multipart/form-data">
             <div class="card-body">

               <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role date">Date From :</label>
                <div class="col-lg-3">
                     <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off"> 
                </div>
                <label class="col-lg-2 control-label text-lg-right" for="role date">Date To :</label>
                <div class="col-lg-3">
                     <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                </div>
              </div>
     <?php if($permission->view == 1){ ?>
                   <?php if ($this->role == 12){ ?>
                    <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->customer_model->selectSamEmployeeId()?>
                            </select>
                        </div>
                      </div>
                  <?php } ?>
                  <?php if ($this->role == 15){ ?>
                        <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->accounting_model->selectAccountantEmployeeId()?>
                            </select>
                        </div>
                      </div>
                   <?php } ?>
                  <?php if ($this->role == 16){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->projects_model->selectPmEmployeeId()?>
                            </select>
                        </div>
                      </div>
                  <?php } ?>

                  <?php if ($this->role == 24){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->admin_model->selectDtpEmployeeId()?>
                            </select>
                        </div>
                      </div>
                    <?php } ?>

                    <?php if ($this->role == 28){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->admin_model->selectTranslatorEmployeeId()?>
                            </select>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($this->role == 26){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->admin_model->selectLeEmployeeId()?>
                            </select>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($this->role == 32){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                    <?=$this->vendor_model->selectVmEmployeeId()?>
                            </select>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($this->role == 22){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->admin_model->selectMarketingEmployeeId()?>
                            </select>
                        </div>
                      </div>
                    <?php } ?>
                    <?php if ($this->role == 1 or $this->role == 21 or $this->role == 31 ){ ?>
                     <div class="form-group row">
                       <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>
                        <div class="col-lg-3">
                            <select name="user" class="form-control" id="user"/>
                                     <option value="">-- Select Employee --</option>
                                     <?=$this->hr_model->selectEmployee()?>
                            </select>
                        </div>
                      </div>
                    <?php } ?>
         <?php } ?>
             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                       <button class="btn btn-success mr-2" name="search" type="submit">Search</button> 
                 <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>hr/remoteAccess" class="btn bg-info ">Remote Access</a>
                        <a href="<?=base_url()?>hr/missingAttendance" class="btn btn-danger ">Missing Attendance</a>
                        <button class="btn btn-success" onclick="var e2 = document.getElementById('attendance'); e2.action='<?=base_url()?>hr/exportAttendanceLog'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                          <?php } ?> 

               </div>
              </div>
             </div>
            </form>
                       </div>
                     </div>
                        
              <!-- end search form -->
       <?php if(isset($_POST['search'])){ ?>
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Attendance Log</h3>
                    </div>
                    <div class="card-toolbar">
                     
                   
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                         <thead>
                        <tr>
                         <th>Employee ID</th>
                         <th>Employee Name</th>
                         <th>Sign In</th>
                         <th>Sign Out</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($attendance as $row){ 
                      $signOut = $this->db->query("SELECT SRVDT FROM attendance_log AS log WHERE log.USRID = ".$row->USRID." AND TNAKEY = '2' AND
                                                  ((log.SRVDT BETWEEN '".$row->SignIn."' AND DATE_ADD('".$row->SignIn."', INTERVAL 18 hour)) AND log.SRVDT > '".$row->SignIn."') ORDER BY log.id DESC LIMIT 1")->row();
                      ?>
                        <tr>
                          <td><?=$row->USRID?></td>
                          <td><?=$this->hr_model->getEmployee($row->USRID)?></td>
                          <td><?=$row->SignIn?></td>
                          <td><?=$signOut->SRVDT?></td>
                        </tr>
                      <?php  } ?>
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
          <?php } ?>