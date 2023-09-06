<style>
    .dataTables_scrollHeadInner{
        width:100%!important;
    }
    .btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled), .btn.btn-clean:focus:not(.btn-text), .btn.btn-clean.focus:not(.btn-text) {
        background-color: transparent!important;
        border-color: transparent;
    }
    .label-rounded{
        width:40px!important;
    }
</style>
<!--begin::Card-->
<div class="container"> 
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h3 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">Attendance</h3>
                    <!--end::Page Title-->

                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->     
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center flex-wrap">
                <!--begin::Button-->
                <a href="<?= base_url() ?>hr/missingAttendance" class="btn btn-dark btn-shadow  btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                    <i class="flaticon-edit-1"></i>    
                    <span class="d-none d-md-inline">Missing Attendance</span>
                </a>
                <!--end::Button-->
                <!--begin::Button-->
                <a href="<?= base_url() ?>hr/remoteAccess" class="btn btn-primary btn-shadow btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="d-none d-md-inline">Remote Access</span>
                </a>
                <!--end::Button-->                  
                <!--begin::Button-->
                <a href="<?= base_url() ?>hr/timeSheet" class="btn btn-dark btn-shadow  btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                    <i class="flaticon-calendar-with-a-clock-time-tools"></i>   
                    <span class="d-none d-md-inline">Time Sheet</span>
                </a>
                <!--end::Button-->                  

            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success" role="alert">
            <span class="fa fa-check-circle"></span>
            <span><strong><?= $this->session->flashdata('true') ?></strong></span>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
            <span class="la la-warning icon-lg"></span>
            <span><strong><?= $this->session->flashdata('error') ?></strong></span>
        </div>
    <?php } if ($this->admin_model->checkIfUserIsManager($this->user) || ($this->role == 1 or $this->role == 21 or $this->role == 31 or $this->role == 46 )) { ?>
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap py-3">
                <!--begin::Info-->
                <div class="d-flex align-items-center mr-2 py-2">               
                    <!--begin::Navigation-->
                    <div class="d-flex mr-3">
                        <!--begin::Navi-->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-1" data-toggle="tab" href="#card-1">                           
                                    <span class="nav-text">Attendance Log </span>
                                </a>
                            </li>                        
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2" data-toggle="tab" href="#card-2">    
                                    <span class="nav-text">Pending Approval Missing Requests <span class="label label-rounded label-light-danger font-weight-bolder nav-text-count"><?= count($missingRequests) ?></span></span>
                                </a>
                            </li>  
                        </ul>
                        <!--end::Navi-->               
                    </div>
                    <!--end::Navigation-->
                </div>
                <!--end::Info-->      
            </div>
            <!--end::Body-->
        </div>
    <?php } ?>
    <div class="tab-content mt-5" id="myTabContent2">
        <div class="tab-pane fade show active" id="card-1" role="tabpanel" aria-labelledby="home-tab-2">           
            <!-- start search form card --> 
            <div class="card">
                <div class="card card-custom gutter-b m-5">
                    <div class="card-header">
                        <div class="card-title btn_lightgray">
                            <h3 class="card-label">Filter</h3>                               
                        </div>                  
                    </div>
                    <div class="card-body">
                        <form class="cmxform form-horizontal " id="attendance" action="<?php echo base_url() ?>hr/attendance" method="post" enctype="multipart/form-data">
                            <div class=" form-group row">
                                <label class="col-md-2 control-label" for="role date">Date From</label>
                                <div class="col-md-4">
                                    <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="" value="<?= $_REQUEST['date_from'] ?? '' ?>">
                                </div>
                                <label class="col-md-2 control-label text-md-right" for="role date">Date To</label>
                                <div class="col-md-4">
                                    <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="" value="<?= $_REQUEST['date_to'] ?? '' ?>">
                                </div>

                            </div>

                            <?php if ($permission->view == 1) { ?>
                                <?php if ($this->role == 1 or $this->role == 21 or $this->role == 31 or $this->role == 46) { ?>
                                    <div class="form-group row">
                                        <label class="col-md-2 control-label" for="role Task Type">Employee</label>
                                        <div class="col-md-4">
                                            <select name="user" class="form-control m-b" id="user"/>
                                            <option value="">-- Select Employee --</option>
                                            <?= $this->hr_model->selectEmployee($_REQUEST['user'] ?? '') ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 control-label text-md-right" for="role name">Function</label>
                                        <div class="col-md-4">
                                            <select name="department" class="form-control m-b" id="department"/>
                                            <option value="" selected="">-- Select Department --</option>
                                            <?= $this->hr_model->selectDepartmentKpi($department) ?>
                                            </select>
                                        </div> 
                                    </div> 


                                <?php } elseif ($this->admin_model->checkIfUserIsManager($this->user)) { ?> 
                                    <div class="form-group row">
                                        <label class="col-md-2 control-label" for="role Task Type">Employee</label>
                                        <div class="col-md-4">
                                            <select name="user" class="form-control m-b" id="user" required="" >
                                            <option value="">-- Select Employee --</option>
                                            <option value="<?=$this->emp_id?>" <?=$_REQUEST['user'] == $this->emp_id?'selected': ''?>><?=$this->hr_model->getEmployee($this->emp_id)?></option>
                                            <?= $this->hr_model->selectAllEmployeesByManagerID($this->emp_id,$_REQUEST['user'] ?? '') ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }
                            } ?>                           
                            <div class="col-lg-12 mt-10 text-center">
                                <button class="btn btn-primary btn-sm font-weight-bold" name="search" type="submit"><i class="fa fa-search"></i>Search</button> 
                                <button class="btn btn-success btn-sm font-weight-bold" onclick="var e2 = document.getElementById('attendance'); e2.action = '<?= base_url() ?>hr/exportAttendanceLog'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                                <?php if ($permission->add == 1) {?>
                                    <br/>
                                    <a href="<?= base_url() ?>hr/addmissingAttendance" class="btn btn-light btn-hover-dark btn-shadow  btn-sm font-weight-bold mt-3 mr-1"><i class="flaticon-edit-1"></i>Add Missing Attendance</a>
<!--                                <a href="<?= base_url() ?>hr/remoteAccess" class="btn btn-light btn-hover-dark btn-shadow btn-sm font-weight-bold mt-3 mr-1"><i class="fas fa-sign-in-alt"></i> Remote Access</a>                                    
                                    <a href="<?= base_url() ?>hr/timeSheet" class="btn btn-light btn-hover-dark btn-shadow btn-sm font-weight-bold mt-3"><i class="flaticon-calendar-1"></i> Time Sheet</a>-->
                                <?php } ?> 
                            </div>
                            
                        </form>
                    </div>
                </div>
                <!-- end search form -->
                <div class="card card-custom gutter-b m-5">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label"> Attendance Log </h3>
                        </div>
                        <div class="card-toolbar">                 
                        </div>
                    </div>
                    <div class="card-body">
                    <?php if (isset($_POST['search'])) { ?>
                            <!--begin: table-->
                            <div class="table-responsive-lg">
                                <table class="table table-bordered  table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Sign In</th>
                                            <th>Sign Out</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($attendance as $row) {
                                        try {
                                            $signin = $this->db->query("SELECT id FROM attendance_log AS `log` WHERE log.USRID = " . $row->USRID . " AND `TNAKEY` = '1' AND `SRVDT` = '" . $row->SignIn  . "' ORDER BY log.id ASC LIMIT 1")->row();
                                        } catch (\Throwable $th) {
                                                //throw $th;
                                            }    
                                         try {
                                        $signOut = $this->db->query("SELECT `SRVDT`,`id` FROM attendance_log AS log WHERE log.USRID = " . $row->USRID . " AND `TNAKEY` = '2' AND
                                                  ((log.SRVDT BETWEEN '" . $row->SignIn . "' AND DATE_ADD('" . $row->SignIn . "', INTERVAL 18 hour)) AND log.SRVDT > '" . $row->SignIn . "') ORDER BY log.id DESC LIMIT 1")->row();
                                        } catch (\Throwable $th) {
                                                //throw $th;
                                            }    
                                        
                                         ?>
                                            <tr>
                                                <td><?= $row->USRID ?></td>
                                                <td><?= $this->hr_model->getEmployee($row->USRID) ?></td>
                                                <td><?= $row->SignIn ?? '' ?></td>
                                                <td><?= $signOut->SRVDT ?? '' ?></td>
                                                <td><?= $this->hr_model->checkAttendanceLocation($signin->id ?? '', $signOut->id ?? '') ?? '' ?></td>
                                            </tr>
    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!--end: table-->
<?php } ?>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Card-->
        </div>
<?php if ($this->admin_model->checkIfUserIsManager($this->user) || ($this->role == 1 or $this->role == 21 or $this->role == 31 or $this->role == 46 )) { ?>
            <div class="tab-pane fade" id="card-2" role="tabpanel" aria-labelledby="profile-tab-2">
                <!--begin::Card-->
                <div class="card">        
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title btn_lightgray">
                            <h4 class="card-label">Pending Approval Missing Requests | <span class="text-dark-50 font-weight-bold card-label-count" style="font-size: 14px !important;"><?= count($missingRequests) ?></span>                        
                            </h4> 
                        </div>               
                    </div>
                    <div class="card-body" id="missing_requests_filter">
                        <!--begin: Datatable-->
                        <table class="table table-head-custom table-hover"width='100%' id="approval">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <!--<th>Employee ID</th>-->
                                    <th>Employee Name</th>
                                    <th>Date </th>
                                    <th>Sign In/Out</th>
                                    <th>Location</th>
                                    <th>Manager Approval</th>                     
                                </tr>
                            </thead>
                            <tbody>
    <?php foreach ($missingRequests as $row) { ?>
                                    <tr>
                                        <td><?= $row->id ?></td>
                                        <!--<td><?= $row->USRID ?></td>-->
                                        <td><?= $this->hr_model->getEmployee($row->USRID) ?></td>
                                        <td><?= $row->SRVDT ?></td>
                                        <?php if ($row->TNAKEY == 1) { ?>
                                            <td><?php echo "Sign In"; ?></td>
                                        <?php } elseif ($row->TNAKEY == 2) { ?>
                                            <td><?php echo "Sign Out"; ?></td>
                                        <?php } ?>
                                        <td><?= $this->hr_model->getLocationType($row->location) ?></td>                       
                                        <?php if ($this->hr_model->checkThisUserIsEmployeeManager($row->USRID) && $row->manager_approval == 0) { ?>
                                            <td><a href="#managerModal<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success" >Manager Approval</a></td>  
                                        <?php } else { ?> 
                                            <td><?= $this->hr_model->getVacationStatus($row->manager_approval); ?></td>
        <?php } ?>     
                                    </tr>
                                    <!-- start manager pop up form -->
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="managerModal<?php echo $row->id; ?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">Manager Approval</h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group" >
                                                    <label class="col-lg-4 control-label" style="padding: 9px ; margin: 5px;" for="role name">Manager Action</label>
                                                    <input name="id" id="id_<?= $row->id ?>" type="hidden" value="<?php echo $row->id; ?>" >

                                                    <div class="col-lg-7" style="padding: 5px ; margin: 5px;">
                                                        <select name="manager_approval"  id="manager_approval_<?= $row->id ?>" class="form-control m-b"/>
                                                        <option value="">-- Select status --</option>
                                                        <option value="1">Approve</option>
                                                        <option value="2">Reject</option>
                                                        </select>
                                                    </div> 
                                                </div>
                                                <button class="btn btn-danger  btn-block"  type="submit" aria-hidden="true" data-dismiss="modal" class="close" onclick="missingAttendanceApprovalForManager(<?= $row->id ?>)">Submit</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end pop up form -->

    <?php } ?> 

                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>

                    <!--end::Card-->
                </div>
            </div>   
<?php } ?>
    </div>



</div>

