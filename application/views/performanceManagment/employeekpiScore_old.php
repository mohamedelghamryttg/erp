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
              
                ?>
                <form class="form" id="kpiFilter" action="<?php echo base_url() ?>performanceManagment/employeekpiScore" method="get" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label text-lg-right">Month:</label>
                            <div class="col-lg-3">
                                <select name="month" class="form-control m-b" id="month"/>
                                <option value="">-- Select Month --</option>
                                <?= $this->accounting_model->selectMonth($month); ?>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-success mr-2" name="search" type="submit">Search</button>	
                                    <a href="<?= base_url() ?>performanceManagment/employeekpiScore" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                                    <a href="<?php echo base_url() ?>performanceManagment/viewSingleEmployeeKpiScore/<?=$row->id?>" class="">
                                        <i class="fa fa-eye"></i> View Kpi
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