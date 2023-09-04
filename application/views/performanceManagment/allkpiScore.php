<?php if ($this->session->flashdata('true')) { ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong>
                <?= $this->session->flashdata('true') ?>
            </strong></span>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong>
                <?= $this->session->flashdata('error') ?>
            </strong></span>
    </div>
<?php } ?>
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">


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
                <form class="form" id="kpiFilter" action="<?php echo base_url() ?>performanceManagment/kpiScore"
                    method="get" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right">Year:</label>
                            <div class="col-lg-4 ">
                                <select name="year" class="form-control " id="year" />
                                <option value="">-- Select year --</option>
                                <?= $this->hr_model->selectYear($year ? $year : ''); ?>
                                </select>
                            </div>
                            <label class="col-lg-2  col-form-label text-lg-right">Month:</label>
                            <div class="col-lg-4">
                                <select name="month" class="form-control" id="month" />
                                <option value="">-- Select Month --</option>
                                <?= $this->accounting_model->selectMonth($month); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php if ($permission->add == 1) {
                                if ($permission->view == 1 && $permission->follow != 2) { ?>

                                    <label class="col-lg-2 col-form-label text-lg-right" for="role name">Function</label>
                                    <div class="col-lg-4">
                                        <select name="department" class="form-control m-b" id="department"
                                            onchange="getEmployeesByDepartment()" />
                                        <option value="" selected="">-- Select Department --</option>
                                        <?= $this->hr_model->selectDepartmentKpi($department) ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 col-form-label text-lg-right" for="role name">Employee Name:</label>
                                    <div class="col-lg-4">
                                        <select name="employee_name" class="form-control m-b" id="employee_name" />
                                        <option value="">-- Select Employee --</option>
                                        <?= $department ? $this->hr_model->selectEmployeesByDepartment($department, $employee_name) : $this->hr_model->selectEmployee($employee_name) ?>
                                        </select>
                                    </div>
                                <?php } else { ?>
                                    <label class="col-lg-2 col-form-label text-lg-right" for="role name">Employee Name:</label>
                                    <div class="col-lg-4">
                                        <select name="employee_name" class="form-control m-b" id="employee_name" />
                                        <option value="">-- Select Employee --</option>
                                        <?= $this->hr_model->selectAllEmployeesByManagerID($this->emp_id, $employee_name) ?>
                                        </select>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right" for="role name">Performance Matrix :
                            </label>

                            <div class="col-lg-4">
                                <select name="matrix" class="form-control m-b" id="matrix" />
                                <option value="" selected="">-- Select --</option>
                                <?= $this->hr_model->selectPerformanceMatrix($matrix) ?>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label text-lg-right" for="role name">Status : </label>

                            <div class="col-lg-4">
                                <select name="status" class="form-control m-b" id="status" />
                                <option value="" selected="">-- Select --</option>
                                <?= $this->hr_model->selectKpiScoreStatus($status) ?>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                                    <a href="<?= base_url() ?>performanceManagment/kpiScore" class="btn btn-warning"><i
                                            class="la la-trash"></i>Clear Filter</a>

                                    <button class="btn btn-secondary"
                                        onclick="var e2 = document.getElementById('kpiFilter'); e2.action='<?= base_url() ?>performanceManagment/exportAllKpiScore'; e2.submit();"
                                        name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i>
                                        Export To Excel</button>

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
                    <?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>performanceManagment/addKpiScore"
                            class="btn btn-primary font-weight-bolder">

                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add New Score </a>
                    <?php } ?>

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
                            <th>Score%</th>
                            <th>Performance Matrix</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kpis->result() as $row) {
                            $score_data = $this->db->query("SELECT sum(score) as sum From kpi_score_data WHERE kpi_score_id = '$row->id'")->row();
                            $score = $score_data->sum;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $this->hr_model->getEmployee($row->emp_id); ?>
                                </td>
                                <td>
                                    <?php echo $this->hr_model->getYear($row->year); ?>
                                </td>
                                <td>
                                    <?php echo $this->accounting_model->getMonth($row->month); ?>
                                </td>
                                <td><span
                                        class="label label-square label-<?= $this->hr_model->performanceMatrix($score, $row->year)['color'] ?>"><?= number_format((float) $score, 2, '.', '') ?>%</span></td>
                                <td><span
                                        class="label label-square label-<?= $this->hr_model->performanceMatrix($score, $row->year)['color'] ?>"><?php echo $this->hr_model->performanceMatrix($score, $row->year)['grade']; ?></span></td>
                                <td>
                                    <?php echo $this->hr_model->getScoreStatus($row->id); ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>performanceManagment/viewSingleKpiScore/<?= $row->id ?>"
                                        class="">
                                        <i class="fa fa-file-alt"></i> View Card
                                    </a>
                            
                                    <?php if ($permission->add == 1 && $row->created_by == $this->user) { ?>
                                        <a title='Clone'
                                            href="<?= base_url() ?>performanceManagment/copyEmployeeKpiScore?score_id=<?= base64_encode($row->id) ?>"
                                            class="ml-5">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                        <a title='Export To Excel'
                                            href="<?= base_url() ?>performanceManagment/exportViewSingleKpiScore?score_id=<?= base64_encode($row->id) ?>"
                                            class="ml-5 pr-7">
                                            <i class="fa fa-file-download text-dark"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if ($permission->delete == 1 && $this->role == 21) { ?>
                                        <a title='Delete'
                                            href="<?= base_url() ?>performanceManagment/deleteKpiScore/<?= $row->id ?>"
                                            class="pr-10" onclick="return confirm('are you sure?')">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    <?php } ?>
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
<style>
    .label {
        width: auto;
        padding: 10px;
    }

    .label-yellow {
        background-color: yellow;
        color: #000;
    }

    .label-primary {
        background-color: #003eff !important;
    }
</style>
<script>
    function getEmployeesByDepartment() {
        var department = $("#department").val();
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "performanceManagment/getEmployeesByDepartment", { department: department }, function (data) {
            $('#loading').hide();
            $("#employee_name").html(data);
        });
    }
</script>