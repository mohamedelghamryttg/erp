
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">           
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
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
              <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Vacation List </h3>
                    </div>                   
                  </div>
                  <div class="card-body pt-2">
                         <!--begin::Button-->
                          <?php if($permission->add == 1){ ?>
                         <a href="<?=base_url()?>hr/addVacation" class="btn btn-primary btn-sm font-weight-bolder mr-3"><i class="flaticon-file-1"></i> Add New Vacation Request</a>
              <?php if($permission->role == 31 || $permission->role == 21 ||$permission->role == 46){ ?>
                  <a href="<?=base_url()?>hr/addVacationForEmployees" class="btn btn-info btn-sm font-weight-bolder"><i class="fa fa-users"></i>  Add New Vacation For Employees</a>
       
            <?php }} ?>
                    <!--begin: Datatable-->
                    <table class="table mt-10" >
                        <thead>
        
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Direct Manager</th>
                <th>Type of vacation</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($vacation->result() as $row) { ?>
                  <tr class="">
                    <td><?= $row->id ;?></td>
                    <td><?= $this->hr_model->getEmpName($row->emp_id) ;?></td>
                    <td><?= $this->hr_model->getEmpName($this->hr_model->getManagerId($this->emp_id)) ;?></td>                  
                    <td><?= $this->hr_model->getAllVacationTypies($row->type_of_vacation) ;?></td>
                    <td><?= $row->start_date;?></td>
                    <td><?= $row->end_date;?></td>
                    <td><?= $this->hr_model->getVacationStatus($row->status);?></td>
                      <td><?php if($row->status == 0){ ?> <a href="<?php echo base_url()?>hr/editVacationRequest?i=<?php echo base64_encode($row->id);?>" class="btn btn-sm btn-clean btn-icon">
                         <i class="la la-edit"></i>
                      </a><?php } ?></td>
                      <td><?php if($row->status == 0){ ?> <a href="<?php echo base_url()?>hr/deleteVacationRequest?i=<?php echo base64_encode($row->id);?>" class="btn btn-sm btn-clean btn-icon">
                         <i class="la la-trash"></i>
                      </a><?php } ?></td>
                  </tr>
                      <?php } ?>          
            </tbody>
                        
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->

                <div class="clear-fix"></div>
                <?php if($this->admin_model->checkIfUserIsManager($this->user)){?>
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header flex-wrap border-1 pt-5 pb-5">
                        <div class="card-title btn_lightgray">
                            <h3 class="card-label">Vacation Requests List | 
                                  <span class="text-dark-50 font-weight-bold"style="font-size: 14px !important;">
                                      <?=$requests->num_rows()?> Total
                                  </span>
                            </h3> 
                        </div>
                        <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');" class="btn btn-clean "><i class="fa fa-chevron-down"></i></button>                         
                    </div>
                  <div class="card-body" id="filter11">
                    <!--begin: Datatable-->
                    <table class="table table-striped">
                      <thead>

              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Direct Manager</th>
                <th>Type of vacation</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Manager Approval</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($requests->result() as $request) { 
                 if($request->status == 0){ 
                ?>
                  <tr class="">
                    <td><?= $request->id ;?></td>
                    <td><?= $this->hr_model->getEmpName($request->emp_id) ;?></td>
                    <td><?= $this->hr_model->getEmpName($this->hr_model->getManagerId($request->emp_id));?></td>
                    <td><?= $this->hr_model->getAllVacationTypies($request->type_of_vacation) ;?></td>
                    <td><?= $request->start_date;?></td>
                    <td><?= $request->end_date;?></td>
                    <td><?=$this->hr_model->getVacationStatus($request->status);?></td>
                    <td>
                        <?php if($this->hr_model->checkThisUserIsEmployeeManager($request->emp_id) || ($this->role == 31 && ($this->hr_model->getManagerId($request->emp_id) == 13 || $this->hr_model->getManagerId($request->emp_id) == 14))){?>
                         <a href="<?php echo base_url()?>hr/responseToVacation?i=<?php echo base64_encode($request->id);?>" class="font-weight-bold">
                        <i class="flaticon2-sheet"></i> Take Action
                      </a>
                 <?php }?>
                    </td>

                  </tr>
                      <?php } } ?>          
            </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
                <?php }?>

        </div>
      </div>
    </div>