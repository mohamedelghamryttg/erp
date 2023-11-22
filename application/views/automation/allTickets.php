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
<!--begin::Entry-->
<div class="d-flex flex-column-fluid py-5">
    <!--begin::Container-->
    <div class="container-fluid">
        <!-- start search form card -->
        <div class="card card-custom gutter-b example example-compact  mb-0">
            <div class="card-header">
                <h3 class="card-title">Search </h3>
            </div>

            <form class="form" id="Filter" action="<?php echo base_url() ?>automation/tickets" method="get" enctype="multipart/form-data">
                <div class="card-body">
                    <?php
                    if (!empty($_REQUEST['month'])) {
                        $month = $_REQUEST['month'];
                    } else {
                        $month = "";
                    }
                    if (!empty($_REQUEST['employee_name'])) {
                        $employee_name = $_REQUEST['employee_name'];
                    } else {
                        $employee_name = "";
                    }
                    if (!empty($_REQUEST['department'])) {
                        $department = $_REQUEST['department'];
                    } else {
                        $department = "";
                    }
                    if (!empty($_REQUEST['type'])) {
                        $type = $_REQUEST['type'];
                    } else {
                        $type = "";
                    }
                    if (!empty($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                    } else {
                        $id = "";
                    }
                    if (!empty($_REQUEST['status'])) {
                        $status = $_REQUEST['status'];
                    } else {
                        $status = "";
                    }
                    if (!empty($_REQUEST['action_type'])) {
                        $action_type = $_REQUEST['action_type'];
                    } else {
                        $action_type = "";
                    }
                    if (!empty($_REQUEST['approvalStatus'])) {
                        $approvalStatus = $_REQUEST['approvalStatus'];
                    } else {
                        $approvalStatus = "";
                    }
                    ?>
                    <div class="form-group row container">
    <label class="col-lg-2 mb-5 col-form-label text-lg-right" for="role name">Ticket Type</label>
                        <div class="col-lg-4">
                            <select name="type" class="form-control m-b" />
                            <option value="">-- Select Type --</option>
                            <?= $this->automation_model->selectTicketType($type) ?>
                            </select>
                        </div>
                        <label class="col-lg-2 col-form-label text-lg-right">Month</label>
                        <div class="col-lg-2">
                            <select name="month" class="form-control m-b" id="month" />
                            <option value="">-- Select Month --</option>
                            <?= $this->accounting_model->selectMonth($month ? $month : ''); ?>
                            </select>
                        </div>
                              <div class="col-lg-2">
                            <select name="year" class="form-control m-b" id="year" >
                            <option value="">-- Select Year --</option>
                            <?= $this->accounting_model->selectYear($year? $year : ''); ?>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <select name="action_type" id='action_type' class="form-control">
                                <?php switch ($_REQUEST['action_type']) {
                                    case '1':  ?>
                                        <option value="">-- Select Action --</option>
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    <?php break;
                                    case '0':  ?>
                                        <option value="">-- Select Action --</option>
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    <?php break;

                                    default: ?>
                                        <option value="" selected>-- Select Action --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                <?php
                                        break;
                                }
                                ?>

                            </select>
                        </div>

                        <label class="col-lg-2 col-form-label text-lg-right">Approval :</label>
                        <div class="col-lg-4">
                            <select name="approvalStatus" id='approvalStatus' class="form-control">
                                <?php switch ($_REQUEST['approvalStatus']) {
                                    case '0':  ?>
                                        <option value="">-- Select Approval --</option>
                                        <option value="0" selected>NA Approval</option>
                                        <option value="1">Pending Approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Rejected</option>
                                    <?php break;
                                    case '1':  ?>
                                        <option value="">-- Select Approval --</option>
                                        <option value="0">NA Approval</option>
                                        <option value="1" selected>Pending Approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Rejected</option>
                                    <?php break;
                                    case '2':  ?>
                                        <option value="">-- Select Approval --</option>
                                        <option value="0">NA Approval</option>
                                        <option value="1">Pending Approval</option>
                                        <option value="2" selected>Approved</option>
                                        <option value="3">Rejected</option>
                                    <?php break;
                                    case '3':  ?>
                                        <option value="">-- Select Approval --</option>
                                        <option value="0">NA Approval</option>
                                        <option value="1">Pending Approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3" selected>Rejected</option>
                                    <?php break;
                                    default: ?>
                                        <option value="" selected>-- Select Approval --</option>
                                        <option value="0">NA Approval</option>
                                        <option value="1">Pending Approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Rejected</option>
                                <?php
                                        break;
                                }
                                ?>


                            </select>
                        </div>
                    </div>
                       <?php if ($permission->view == 1 ) { ?>
                        
                            <label class="col-lg-2 mb-5 col-form-label text-lg-right" for="role name">Employee Name</label>
                            <div class="col-lg-4">
                                <select name="employee_name" class="form-control m-b" id="employee_name" />
                                <option value="">-- Select Employee --</option>
                                <?= $this->hr_model->selectEmployee($employee_name) ?>
                                </select>
                            </div>
                            <label class="col-lg-2 mb-5 col-form-label text-lg-right" for="role name">Function</label>

                            <div class="col-lg-4">
                                <select name="department" class="form-control m-b" id="department" />
                                <option value="" selected="">-- Select Department --</option>
                                <?= $this->hr_model->selectDepartmentKpi($department) ?>
                                </select>
                            </div>
                        <?php } elseif ($this->admin_model->checkIfUserIsManager($this->user) ) { ?>
                        
                            <label class="col-lg-2 mb-5 col-form-label text-lg-right" for="role name">Employee Name</label>
                            <div class="col-lg-4">
                                <select name="employee_name" class="form-control m-b" id="employee_name" />
                               <option value="">-- Select Employee --</option>
                            <option value="<?=$this->emp_id?>" <?=$employee_name == $this->emp_id?'selected': ''?>><?=$this->hr_model->getEmployee($this->emp_id)?></option>
                            <?= $this->hr_model->selectAllEmployeesByManagerID($this->emp_id,$employee_name ?? '') ?>
                                </select>
                            </div>                    
                        <?php } ?>
                    <div class="form-group row pb-0 pt-0  mb-0">
                        <label class="col-lg-2 col-form-label text-lg-right">Ticket Number</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" value="<?= $id ?? '' ?>" name="id">
                        </div>
                    </div>
                    <div class="card-footer pb-0">
                        <div class="row">

                            <div class="col-lg-12 text-center">
                                <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                                <a href="<?= base_url() ?>automation/tickets" class="btn btn-danger"><i class="la la-trash"></i>Clear Filter</a>
                                <button class="btn btn-warning" onclick="var e2 = document.getElementById('Filter'); e2.action='<?= base_url() ?>automation/exportTickets'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export
                                    To Excel</button>

                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <!-- end search form -->

    <!--begin::Card-->
    <div class="card pt-0 pb-0">
        <div class="card-header flex-wrap border-0 pt-0 pb-0">
            <div class="card-title">
                <h3 class="card-label">Tickets| <span class="text-dark-50 font-weight-bold" style="font-size: 14px !important;">
                        <?= $total_rows ?> Total
                    </span></h3>
            </div>
            <div class="card-toolbar">
                <div class="float-right">
                    <table>
                        <tr>
                            <td class="px-3">
                                <div class="d-flex flex-column w-100px mr-2">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted mr-2 font-size-sm font-weight-bold">
                                            <?= $total_new ?>
                                        </span>
                                        <span class="text-muted font-size-sm font-weight-bold">New</span>
                                    </div>
                                    <div class="progress progress-xs w-100">
                                        <?php if ($total_rows == 0) : ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= 0 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php else : ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $total_new / $total_rows * 100 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3">
                                <div class="d-flex flex-column w-100px mr-2">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted mr-2 font-size-sm font-weight-bold">
                                            <?= $total_progress ?>
                                        </span>
                                        <span class="text-muted font-size-sm font-weight-bold">In Progress</span>
                                    </div>
                                    <div class="progress progress-xs w-100">
                                        <?php if ($total_rows == 0) : ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= 0 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php else : ?>
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $total_progress / $total_rows * 100 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3">
                                <div class="d-flex flex-column w-100px mr-2">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted mr-2 font-size-sm font-weight-bold">
                                            <?= $total_closed ?>
                                        </span>
                                        <span class="text-muted font-size-sm font-weight-bold">Closed</span>
                                    </div>
                                    <div class="progress progress-xs w-100">
                                        <?php if ($total_rows == 0) : ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= 0 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php else : ?>
                                            <div class="progress-bar bg-dark" role="progressbar" style="width: <?= $total_closed / $total_rows * 100 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </td>
                            <td class="px-3">
                                <div class="d-flex flex-column w-100px mr-2">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted mr-2 font-size-sm font-weight-bold">
                                            <?= $total_opened ?>
                                        </span>
                                        <span class="text-muted font-size-sm font-weight-bold">Opened</span>
                                    </div>
                                    <div class="progress progress-xs w-100">
                                        <?php if ($total_rows == 0) : ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= 0 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php else : ?>
                                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $total_opened / $total_rows * 100 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3">
                                <div class="d-flex flex-column w-100px mr-2">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted mr-2 font-size-sm font-weight-bold">
                                            <?= $total_approval ?>
                                        </span>
                                        <span class="text-muted font-size-sm font-weight-bold">For Approval</span>
                                    </div>
                                    <div class="progress progress-xs w-100">
                                        <?php if ($total_rows == 0) : ?>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= 0 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php else : ?>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $total_approval / $total_rows * 100 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php if ($permission->add == 1) { ?>
                    <a href="<?= base_url() ?>automation/addTicket" class="btn btn-primary font-weight-bolder">

                        <i class="fa fa-pen"></i>Send Ticket </a>
                <?php } ?>
            </div>

        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover">

            <thead>
                <tr>
                    <th no-sort>ID</th>
                    <th>Ticket From</th>
                    <th>Ticket Type</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Approval</th>
                    <th>view</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets->result() as $row) { ?>
                    <tr>
                        <td style="padding-left:10px !important;<?php if ($row->status == 0) { ?>padding-left:2px !important;;border-left: 7px double #1bc5bd;<?php } ?>">
                            <?= $row->id ?></td>
                        <td>
                            <?= $this->automation_model->getEmpName($row->emp_id); ?><br /><span class="label label-square label-light-info font-size-xs">
                                <?= $this->automation_model->getEmpDep($row->emp_id); ?>
                            </span>
                        </td>
                        <td>
                            <?= $row->ticket_type ?>
                        </td>
                        <td>
                            <?= word_limiter($row->subject, 5, '...') ?>
                        </td>
                        <td>
                            <?= $row->created_at ?>
                        </td>
                        <td><span class="label label-square label-<?= $this->automation_model->getTicketStatus($row->status)['color'] ?>"><?= $this->automation_model->getTicketStatus($row->status)['status'] ?></span></td>

                        <td><span class="label label-square label-<?= $this->automation_model->getTicketApproval($row->approval)['color'] ?>"><?= $this->automation_model->getTicketApproval($row->approval)['status'] ?></span></td>
                        <td>
                            <a href="<?= base_url() . 'automation/viewTicket?t=' . base64_encode($row->id); ?>" class="">
                                <i class="fa fa-eye"></i> View
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
<style>
    .label {
        width: auto;
        padding: 10px;
    }
</style>