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
                    <h3 class="card-title">Search Kpi score</h3>
                </div>
                <?php
                if (isset($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                } else {
                    $month = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                } else {
                    $employee_name = "";
                }
                ?>
                <form class="form" id="kpiFilter" action="<?php echo base_url() ?>performanceManagment/teamkpiScore" method="get" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label text-lg-right">Month:</label>
                            <div class="col-lg-3">
                                <select name="month" class="form-control m-b" id="month"/>
                                <option value="">-- Select Month --</option>
                                <?= $this->accounting_model->selectMonth($month); ?>
                                </select>
                            </div>

                            <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name:</label>

                            <div class="col-lg-3">
                                <select name="employee_name" class="form-control m-b" id="employee_name"/>
                                <option value="">-- Select Employee --</option>
                                <?= $this->hr_model->selectEmployee($employee_name) ?>
                                </select>


                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-success mr-2" name="search" type="submit">Search</button>	
                                    <a href="<?= base_url() ?>performanceManagment/kpiScore" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                    <h3 class="card-label">Employees KPIs</h3>
                </div>
                <div class="card-toolbar">

                    <!--begin::Button-->
                    <?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>performanceManagment/addKpiScore" class="btn btn-primary font-weight-bolder"> 

                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add New Score </a>
                    <?php } ?>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">

                    <thead>
                        <tr>
                            <th>Employee NAme</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Status</th>
                            <th>viewKpi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kpis->result() as $row) { ?>
                            <tr> 
                                <td><?php echo $this->hr_model->getEmployee($row->emp_id); ?></td>
                                <td><?php echo $this->hr_model->getYear($row->year); ?></td>
                                <td><?php echo $this->accounting_model->getMonth($row->month); ?></td>
                                 <td><?php echo $this->hr_model->getScoreStatus($row->id); ?></td>
                                <td>
                                    <a href="<?php echo base_url() ?>performanceManagment/viewSingleKpiScore/<?=$row->id?>" class="">
                                        <i class="fa fa-eye"></i> View Kpi
                                    </a>
                                     <a href="<?php echo base_url() ?>performanceManagment/copyEmployeeKpiScore/<?=$row->id?>" class="ml-5">
                                        <i class="fa fa-copy"></i> Copy
                                    </a>
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