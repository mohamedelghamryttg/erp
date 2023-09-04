
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
                    <h3 class="card-title">Search Kpi</h3>
                </div>
                <?php
                if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                } else {
                    $year = "";
                }
                if (isset($_REQUEST['employee_title'])) {
                    $employee_title = $_REQUEST['employee_title'];
                } else {
                    $employee_title = "";
                }
                ?>
                <form class="form" id="kpiFilter" action="<?php echo base_url() ?>performanceManagment/kpi" method="get" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group row">
                           
             
                            <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Title:</label>

                            <div class="col-lg-4">
                                <select name="employee_title" class="form-control m-b" id="employee_title"/>
                                <option value="">-- Select Title --</option>
                                 <?php if($permission->view == 1){?>
                            <?= $this->hr_model->selectAllEmployeesByTitle('none',$employee_title?$employee_title:''); ?>  
                            <?php }else{?>
                            <?= $this->hr_model->selectAllEmployeesByTitleSelf($emp_id,$employee_title?$employee_title:''); ?>
 
                            <?php }?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label text-lg-right" for="role name">Active: </label>

                            <div class="col-lg-4">
                                <select name="active" class="form-control" id="active" >
                                    <option value="">-- Select  --</option>
                                    <option value="1" <?=isset($active)&&$active==1?'selected':''?>>-- YES --</option>
                                    <option value="2" <?=isset($active)&&$active==2?'selected':''?>>-- NO --</option>                           
                        </select>


                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-success mr-2" name="search" type="submit"onclick="var e2 = document.getElementById('vacationBalanceFilter'); e2.action = '<?= base_url() ?>performanceManagment/kpi'; e2.submit();">Search</button>	
                                    <a href="<?= base_url() ?>performanceManagment/kpi" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                    <h3 class="card-label">KPIs Design</h3>
                    <span class="text-dark-50"><i class="fa fa-info-circle"></i> Note That : Only Active Kpi Design Can be Used in adding kpi score <br/>- You don't need to add design for each month 
                        <!--<br/> - If you need to edit KPI design : you can edit it before add score using this design OR you can clone design & edit it before add score using it-->
                    </span>
                </div>
                <div class="card-toolbar">

                    <!--begin::Button-->
                    <?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>performanceManagment/addKpi" class="btn btn-primary font-weight-bolder"> 

                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add New Kpi</a>
                    <?php } ?>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">

                    <thead>
                        <tr>
                            <th>Kpi Title</th>
                            <th>Employee Title</th>
                            <th>Manager</th>
                            <th>Active</th>                           
                            <!--<th>Created At</th>-->                           
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kpis->result() as $row) { ?>
                            <tr> 
                                <td><?= !empty($row->title)?$row->title:"--" ?></td>
                                <td><?php echo $this->hr_model->getTitle($row->employee_title); ?></td>
                                <td><?php echo $this->hr_model->getEmployee($row->manager_id); ?></td>
                                <td ><?=$row->active ==1 ? "<i class='fa fa-check-circle text-success'></i>":"<i class='fa fa-times-circle text-danger'></i>" ?></td>
                                <!--<td><?= $row->created_at?></td>-->
                                <td>
                                    <a href="<?= base_url() .'performanceManagment/viewSingleKpi/'. $row->id ?>" class="">
                                        <i class="fa fa-file-alt"></i> View Kpi
                                    </a>
                                    <a  href="<?= base_url() .'performanceManagment/setKpiActive/'. $row->id ?>" title="Active This Kpi for <?=$this->hr_model->getTitle($row->employee_title)?>" onclick="return confirm('Are you sure?')" class="ml-5">
                                        <i class="fa fa-star"></i>
                                    </a>
                                      <?php   if ($permission->add == 1) {?>
                                        <a title='Clone' href="<?php echo base_url() ?>performanceManagment/copyKpi/<?=$row->id?>" class="ml-5">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                            <a title='Export To Excel' href="<?= base_url() ?>performanceManagment/exportViewSingleKpi?kpi_id=<?=$row->id?>" class="ml-5 pr-7">
                                          <i class="fa fa-file-download text-dark"></i> 
                                      </a>
                                        <?php }if($permission->delete == 1){?>
                                        <a href="<?php echo base_url() ?>performanceManagment/deleteKpiDesign/<?=$row->id?>" onclick="return confirm('Deleting Kpi ... are you sure?')"  class="pr-10"  >
                                            <i class="fa fa-trash text-danger"></i> 
                                        </a>
                                           <?php }?>
                                </td>
                            </tr>
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