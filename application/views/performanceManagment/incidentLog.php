
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
<?php if ($this->session->flashdata('true')) { ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong><?= $this->session->flashdata('true') ?></strong></span>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?> 
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong><?= $this->session->flashdata('error') ?></strong></span>
    </div>
<?php } ?>

            <!-- start search form card --> 
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Incidents Log</h3>
                </div>             
                <form class="form" id="kpiFilter" action="<?php echo base_url() ?>performanceManagment/incidentLog" method="get" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group row">

                             <label class="col-lg-1 col-form-label text-lg-right">Month:</label>
                            <div class="col-lg-3">
                                <select name="month" class="form-control m-b" id="month"/>
                                <option value="">-- Select Month --</option>
                                <?= $this->accounting_model->selectMonth($month?$month:''); ?>
                                </select>
                            </div>
                           <div class="col-lg-2 pl-0">
                            <select name="year" class="form-control m-b" id="year" >
                            <option value="">-- Select Year --</option>
                            <?= $this->accounting_model->selectYear($year? $year : ''); ?>
                            </select>
                        </div>
                            <?php if ($permission->add == 1 && $this->admin_model->checkIfUserIsManager($this->user)) { ?>
                            <label class="col-lg-2 col-form-label text-lg-right" for="role name">Employee Name:</label>
                            <div class="col-lg-4">
                                <select name="employee_name" class="form-control m-b" id="employee_name"/>
                                <option value="">-- Select Employee --</option>
                                <?php if ($permission->view == 1 ){?>
                                    <?= $this->hr_model->getEmployeesNameByManager('',$employee_name) ?>
                                <?php } else{?>
                                       <?= $this->hr_model->getEmployeesNameByManager($emp_id,$employee_name) ?>
                                <?php } ?>
                                </select>
                            </div>
                              <?php }?>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-success mr-2" name="search" type="submit"onclick="var e2 = document.getElementById('vacationBalanceFilter'); e2.action = '<?= base_url() ?>performanceManagment/kpi'; e2.submit();">Search</button>	
                                    <a href="<?= base_url() ?>performanceManagment/incidentLog" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                    <h3 class="card-label">Incidents Log</h3>
                </div>
                <div class="card-toolbar">

                    <!--begin::Button-->
                    <?php if ($permission->add == 1 && $this->admin_model->checkIfUserIsManager($this->user)) { ?>
                        <a href="<?= base_url() ?>performanceManagment/addLog" class="btn btn-primary font-weight-bolder"> 

                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add New Log</a>
                    <?php } ?>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" s>

                    <thead>
                        <tr>
                            <th>Employee NAme</th>
                            <th>title</th>
                            <th>Date</th>                                                 
                            <th>Created At</th>     
                            <th>Confirmed</th>                           
                            <th></th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs->result() as $row) { ?>
                            <tr> 
                                <td><?= $this->hr_model->getEmployee($row->emp_id); ?></td>                                
                                <td><?= character_limiter($row->title, 30,'...') ?></td>  
                                <td><?= $row->date ?></td>                               
                                <td><?= $row->created_at ?></td> 
                                <td><?php if($row->confirmed == 1){?>
                                    <span class="label label-outline-success label-inline mr-2">
                                        Confirmed
                                    </span>
                                <?php }else{?>
                                    --
                                <?php }?>
                                </td>
                                <td><button type="button" class="btn btn-dark btn-sm mr-5" data-toggle="modal" data-target="#Modal_<?= $row->id ?>">View</button></td>                              
                            </tr>
                            <div class="modal fade" id="Modal_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title"><?= $row->title ?></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p class='text-danger'><?= $this->hr_model->getEmployee($row->emp_id); ?></p>
                                      <p class='text-danger'><?= $row->date ?></p>
                                      <p><?= $row->title ?></p>                                     
                                      <p><?= $row->comment ?></p>                                      
                                      <p>Attached File : <?=$row->file?"<a href=".base_url()."assets/uploads/performanceManagment/".$row->file." target='_blank'>Click Here</a>":'No File'?></p>
                                      <?php if(!empty($row->kpi_sub_id)){?>
                                      <hr/> 
                                      <p><span class="font-weight-bold text-danger">Kpi Core : </span><?= $this->hr_model->getCoreName($row->kpi_core_id) ?>
                                          <i class="fa fa-sm fa-arrow-circle-right text-danger"></i> <?= $this->hr_model->getSubCoreName($row->kpi_sub_id) ?></p>
                                      <?php }?>
                                      <hr/>
                                      <p><span class="font-weight-bold text-danger">Created By : </span><?= $this->admin_model->getUser($row->created_by) ?>
                                      <span class="font-weight-bold text-danger"> At : </span><?= $row->created_at ?></p>
                                      <?php if($this->emp_id == $row->emp_id){?>
                                        <form class='mt-10' action="<?php echo base_url() ?>performanceManagment/changeLogStatus" method="post"> 
                                            <input name="id" value="<?= $row->id ?>" type="hidden" />                
                                                                                 
                                            <button class="btn btn-dark  btn-block"  type="submit" ><i class="fa fa-check-circle fa-sm"></i>Confirm</button>
                                        </form>
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">                                      
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        <?php } ?>

                    </tbody>
                </table>
                <!--end: Datatable-->
                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <?= $this->pagination->create_links() ?>  
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