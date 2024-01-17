<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->

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
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                    <!--begin::Profile Card-->
                    <div class="card card-custom card-stretch">
                        <!--begin::Body-->
                        <div class="card-body pt-4">
                            <!--begin::Nav-->
                            <div class="navi navi-bold navi-hover navi-active navi-link-rounded">

                                <?php
                                for ($i = 5; $i >= -5; $i--) {

                                    $this_month = date('m', strtotime("-$i month"));
                                    $this_year = date('Y', strtotime("-$i month"));
                                    ?>
                                    <div class="navi-item mb-2">
                                        <a href="<?= base_url() ?>payroll/?employee_name=&month=<?= $this_month ?>&yearValue=<?= $this_year ?>&search="
                                            class="navi-link <?= ($month == $this_month && $yearVal == $this_year) ? 'active' : '' ?>">
                                            <span class="navi-icon mr-4">
                                                <span class="svg-icon svg-icon-lg">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                            <path
                                                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                                fill="#000000" fill-rule="nonzero"></path>
                                                            <path
                                                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text font-weight-bolder font-size-lg">
                                                <?= date('F, Y', strtotime("-$i month")) ?>
                                            </span>

                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Profile Card-->
                </div>
                <!--end::Aside-->

                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <div class="container-fluid">
                        <div class=" card card-custom gutter-b example example-compact">
                            <div class="card-header">
                                <div class="card-title btn_lightgray">
                                    <h3 class="card-label">Search Payroll</h3>
                                </div>
                                <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');"
                                    class="btn btn-clean "><i
                                        class="fa <?= (isset($_GET['search']) && !isset($_REQUEST['yearValue'])) ? 'fa-chevron-up' : 'fa-chevron-down' ?>"></i></button>

                            </div>

                            <div class="card-body" id="filter11"
                                style="<?= (isset($_GET['search']) && !isset($_REQUEST['yearValue'])) ? 'display:block' : 'display:none' ?>">

                                <form class="form" id="payrollFilter" action="<?php echo base_url() ?>payroll"
                                    method="get" enctype="multipart/form-data">

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label text-lg-right" for="role name">Employee
                                            Name:</label>
                                        <div class="col-lg-4">
                                            <select name="employee_name" class="form-control m-b" id="employee_name" />
                                            <option value="">-- Select Employee --</option>
                                            <?= $this->hr_model->selectEmployee($employee_name) ?>
                                            </select>
                                        </div>
                                        <label class="col-lg-2 col-form-label text-lg-right"
                                            for="role name">Action:</label>
                                        <div class="col-lg-4">
                                            <select name="action" class="form-control m-b" id="action" />
                                            <option value="" selected=''>-- Select --</option>
                                            <?= $this->hr_model->selectPayrollActions($action); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2  mb-5 col-form-label text-lg-right">Month:</label>
                                        <div class="col-lg-4">
                                            <select name="month" class="form-control " id="month"
                                                onchange="FormInputs();">
                                                <option value="">-- Select Month --</option>
                                                <?= $this->accounting_model->selectMonth($month); ?>
                                            </select>
                                        </div>
                                        <label class="col-lg-2 mb-5 col-form-label text-lg-right">Year:</label>
                                        <div class="col-lg-4 ">
                                            <select name="year" class="form-control " id="year" />
                                            <option value="">-- Select year --</option>
                                            <?= $this->hr_model->selectYear($year ? $year : ''); ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-9">
                                                <button class="btn btn-success mr-2" name="search" type="submit"><i
                                                        class="la la-search"></i>Search</button>
                                                <a href="<?= base_url() ?>payroll" class="btn btn-warning"><i
                                                        class="la la-trash"></i>Clear Filter</a>

                                                <button class="btn btn-secondary"
                                                    onclick="var e2 = document.getElementById('payrollFilter'); e2.action='<?= base_url() ?>payroll/exportPayroll'; e2.submit();"
                                                    name="export" type="submit"><i class="fa fa-download"
                                                        aria-hidden="true"></i> Export To Excel</button>

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
                                    <h3 class="card-label">Payroll | <span class="text-dark-50 font-weight-bold"
                                            style="font-size: 14px !important;">
                                            <?= $total_rows ?> Total
                                        </span></h3>
                                </div>
                                <div class="card-toolbar">
                                    <?php if ($permission->add == 1) { ?>
                                        <a href="<?= base_url() ?>payroll/addCard"
                                            class="btn btn-primary font-weight-bolder">

                                            <span class="svg-icon svg-icon-md">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                                        <path
                                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>Add </a>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <table class="table table-separate table-head-custom table-checkable table-hover"
                                    id="kt_datatable2">

                                    <thead>
                                        <tr>
                                            <th>Employee NAme</th>
                                            <th>Payroll Month</th>
                                            <th>Till</th>
                                            <th>action</th>
                                            <th>amount / Monthly Installment</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($logs->result() as $row) { ?>
                                            <tr>

                                                <td>
                                                    <?php echo $this->hr_model->getEmployee($row->emp_id); ?>
                                                </td>
                                                <td>
                                                    <?= date_format(date_create($row->start_date), 'F Y'); ?>
                                                </td>
                                                <td>
                                                    <?= $row->end_date ? date_format(date_create($row->end_date), 'F Y') : '-'; ?>
                                                </td>
                                                <td><p>
                                                    <?= $this->hr_model->getPayrollActions($row->action); ?>
                                                     <?php if($row->action == 2){?>
                                                    <br/>
                                                    <span class="label label-square label-light-info font-size-xs text-dark w-auto p-1">
                                                          <?=  "Total Amount: " . $row->amount ?> 
                                                    </span>                                                  
                                                     <?php }?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <?php if(!empty($row->monthly_installment)){?>
                                                    <?= $row->monthly_installment . ' ' . $this->hr_model->getPayrollUnits($row->unit) ?>
                                                    <?php }else{?>
                                                    <?= $row->amount . ' ' . $this->hr_model->getPayrollUnits($row->unit) ?>
                                                   
                                                     <?php }?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url() ?>payroll/viewCard/<?= $row->id ?>"
                                                        class="btn btn-sm btn-clean btn-icon" title="View Details">
                                                        <i class="fa fa-file-alt"></i>
                                                    </a>

                                                    <a href="<?= base_url() ?>payroll/editCard/<?= $row->id ?>"
                                                        class="btn btn-sm btn-clean btn-icon" title="Edit">
                                                        <i class="fa fa-pen"></i>
                                                    </a>

                                                    <a href="<?= base_url() ?>payroll/deleteCard/<?= $row->id ?>"
                                                        class="btn-sm btn-clean btn-icon" title="Delete"
                                                        onclick="return confirm('Are You Sure?')">
                                                        <i class="fa fa-trash"></i>
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

<script>
    function FormInputs() {
        var month = $("#month").find(":selected").val();
        if (month >= 1) {
            $("#year").prop('required', true);
        } else {
            $("#year").prop('required', false);
        }
    }
    $("#filter").show();

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