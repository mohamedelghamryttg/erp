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
        <div class="container-fluid">
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
            <!--begin::Profile Account Information-->
            <div class="d-flex flex-row">

                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <div class="card-title btn_lightgray">
                                <h3 class="card-label">Search Kpi Score Report</h3>
                            </div>
                            <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');"
                                class="btn btn-clean "><i class="fa fa-chevron-down"></i></button>

                        </div>

                        <div class="card-body" id="filter11" style="">

                            <form class="form" id="reportFilter"
                                action="<?php echo base_url() ?>performanceManagment/kpiReports" method="get"
                                enctype="multipart/form-data" onsubmit="return FormInputs();">

                                <div class="form-group row">

                                    <label class="col-lg-2 mb-5 col-form-label text-lg-right">From:</label>
                                    <div class="col-lg-4 ">
                                        <select name="start_date" class="form-control " id="start_date" required="" />
                                        <option value="">-- Select Date --</option>
                                        <?= $this->hr_model->selectYearANDMonth($start_year ? $start_year : 0, $start_month ? $start_month : 0); ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 mb-5 col-form-label text-lg-right">To:</label>
                                    <div class="col-lg-4 ">
                                        <select name="end_date" class="form-control " id="end_date" required="" />
                                        <option value="">-- Select Date --</option>
                                        <?= $this->hr_model->selectYearANDMonth($end_year ? $end_year : 0, $end_month ? $end_month : 0); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-lg-2 col-form-label text-lg-right"
                                        for="role name">Function</label>
                                    <div class="col-lg-4">
                                        <select name="department" class="form-control m-b" id="department"
                                            onchange="getEmployeesByDepartment()" />
                                        <option value="" selected="">-- Select Department --</option>
                                        <?= $this->hr_model->selectDepartmentKpi($department) ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 col-form-label text-lg-right" for="role name">Employee
                                        Name:</label>
                                    <div class="col-lg-4">
                                        <select name="employee_name" class="form-control m-b" id="employee_name" />
                                        <option value="">-- Select Employee --</option>
                                        <?= $department ? $this->hr_model->selectEmployeesByDepartment($department, $employee_name) : $this->hr_model->selectEmployee($employee_name) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-9">
                                            <button class="btn btn-success mr-2" name="search" type="submit"><i
                                                    class="la la-search"></i>Search</button>
                                            <button class="btn btn-secondary" name="export" type="submit"><i
                                                    class="fa fa-download" aria-hidden="true"></i> Export To
                                                Excel</button>
                                            <a href="<?= base_url() ?>performanceManagment/kpiReports"
                                                class="btn btn-danger"><i class="la la-trash"></i>Clear Filter</a>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clear-fix"></div>
                    <!--begin::Card-->
                    <div class="card">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Kpi Score Report | <span class="text-dark-50 font-weight-bold"
                                        style="font-size: 14px !important;">
                                        <?= $total_rows ?? 0 ?> Total
                                    </span></h3>
                            </div>

                        </div>
                        <div class="card-body">
                            <table class="table table-separate table-head-custom table-checkable table-hover"
                                id="kt_datatable2">


                                <thead>
                                    <tr class="sticky-head">
                                        <th>#ID</th>
                                        <th class="sticky-col">Employee</th>
                                        <th>AVG.</th>
                                        <th>Total Cards </th>
                                        <?php
                                        foreach ($months_list as $k => $val) {
                                            $year = $this->hr_model->getYear($years_list[$k]);
                                            echo "<th class='font-size-xs text-center'style='font-size:11px'>" . date('F, Y', strtotime("01-$val-$year")) .
                                                "</span></th>";
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employees as $emp) { ?>
                                        <tr>
                                            <td>
                                                <?= $emp ?>
                                            </td>
                                            <td class="sticky-col score_emp_<?= $emp ?>">
                                                <?= $this->hr_model->getEmployee($emp); ?>
                                            </td>
                                            <td class="text-center text-danger" style="font-weight: bold;">
                                                <?= $score_avg[$emp] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $counter[$emp] ?>
                                            </td>
                                            <?php foreach ($months_list as $k => $val) { ?>
                                                <td class="text-center status score_<?= $emp ?>_<?= $k ?>">
                                                    <?= $scores[$emp][$val][$years_list[$k]] ?>
                                                </td>
                                            <?php } ?>


                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--end::Card-->

                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Column Chart</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin::Chart-->
                            <div id="chart"></div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    <!--end::Card-->

                </div>
                <!--end::Content-->
            </div>
            <!--end::Profile Account Information-->

        </div>

        <!-- end search form -->

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->
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
<script>
    function FormInputs() {
        var start_date = "01 " + $("#start_date").find(":selected").text();
        start_date = new Date(start_date.replace('Janaury', 'Jan'));
        var end_date = "01 " + $("#end_date").find(":selected").text();
        end_date = new Date(end_date.replace('Janaury', 'Jan'));
        if (start_date >= end_date) {
            alert("Please Check, End Date must be after start date ");
            return false;
        } else {
            return true;
        }

    }


</script>
<style>
    span.select2 {
        width: 100% !important;
    }

    .btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled),
    .btn.btn-clean:focus:not(.btn-text),
    .btn.btn-clean.focus:not(.btn-text) {
        background-color: transparent !important;
        border-color: transparent;
    }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!--begin::Page Scripts(used by this page)-->
<script src="<?= base_url() ?>assets_new/js/pages/features/charts/apexcharts.js"></script>
<!--end::Page Scripts-->
<script>
    <?php
    $datesArray = array();
    foreach ($employees as $key => $emp) {
        $seriesArray[$key]['name'] = $this->hr_model->getEmployee($emp);

        foreach ($months_list as $k => $val) {
            $empScores = array();
            array_push($empScores, $scores[$emp][$val][$years_list[$k]] != '--' ?? '0');
            if ($key == 0) {
                $year = $this->hr_model->getYear($years_list[$k]);
                array_push($datesArray, date('F-Y', strtotime("01-$val-$year")));
            }
        }
        $empScores = '"' . implode('","', $empScores) . '"';
        $seriesArray[$key]['data'] = $empScores;

    }
    $dates = '"' . implode('","', $datesArray) . '"';
    foreach ($seriesArray as $ser) {
        $series = implode('},{', $seriesArray);
    }
    ?>
    var ItemArray = [];
    <?php foreach ($employees as $key => $emp) {
        foreach ($months_list as $k => $val) {
            ?>
            var name = $(".score_emp_<?= $emp ?>");

            ItemArray.push({
                name: name,
                Item: []
            });
        <?php }
    } ?>
    var KTApexChartsDemo = function () {
        var _demo3 = function () {
            const apexChart = "#chart";

            var options = {
                series: [<?= $series ?>],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {

                    categories: [<?= $dates ?>],
                },
                yaxis: {
                    title: {
                        text: '%'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "" + val + " %"
                        }
                    }
                },
                colors: [primary, success, warning]
            };

            var chart = new ApexCharts(document.querySelector(apexChart), options);
            chart.render();
        }
    }
    jQuery(document).ready(function () {
        KTApexChartsDemo.init();
    });

</script>