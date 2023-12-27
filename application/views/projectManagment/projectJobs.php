<style>
    .modal-dialog {
        max-width: 900px !important;
        width: 900px !important;
    }

    .nav-link {
        padding: 5px 12px !important;
    }

    #list-example {
        min-height: auto;
        border: 1px #185898 solid;
        border-left: 10px #185898 solid;
        font-weight: bold;
        border-radius: 0;
    }

    ul li {
        list-style-type: initial;
    }

    .has-switch {
        width: auto;
        display: inline-block;
        margin-left: 5px;
    }

    .modal-dialog {
        max-width: 1024px !important;
        width: 1024px !important;
    }
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong><?= $this->session->flashdata('true'); ?></strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong><?= $this->session->flashdata('error'); ?></strong></span>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-10">
        <nav id="list-example" class="navbar navbar-light bg-light px-3">

            <ul class="nav nav-pills" style="width:100%">
                <li class="nav-item">
                    <a class="nav-link" href="#close_jobs">Close Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#project_jobs">Project Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#vendor_tasks">Vendor Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#vendor_tasks_offers">Vendor Offers List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#translation_tasks">Translation Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#dtp_tasks">DTP Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#le_tasks">LE Requests</a>
                </li>

            </ul>
        </nav>
        <section class="panel" id="close_jobs">
            <header class="panel-heading">
                Notes
            </header>
            <div class="panel-body">
                <ul>
                    <li><b>You have to Add Client PM to each job before close jobs.</b></li>
                    <li><b>You have to Add Q.C. to each job before close jobs.</b></li>
                    <li><b>You have to Add Vendor Evaluation to each vendor Task before close jobs.</b></li>
                </ul>
                <?php $this->view('projectManagment/projectJobs_includes'); ?>
            </div>
        </section>

        <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="scrollspy-example" tabindex="0">
            <form class="cmxform form-horizontal " action="<?php echo base_url(); ?>ProjectManagment/closeJob" onsubmit="return checkJobVerifyForm();" method="post" enctype="multipart/form-data">
                <section class="panel" id="close_jobs">
                    <header class="panel-heading">
                        Close Jobs
                    </header>
                    <div class="panel-body">
                        <input type="text" name="project_id" value="<?= base64_encode($project_data->id); ?>" hidden="">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="role File Attachment">CPO Attachment</label>

                            <div class="col-lg-3">
                                <input type="file" class=" form-control" name="cpo_file" id="cpo_file" required="" accept="'application/zip'">
                            </div>
                            <label class="col-lg-2 control-label">PO Number</label>

                            <div class="col-lg-3">
                                <input type="text" class=" form-control" name="po" id="po" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 text-center" style="margin-top: 1rem;">
                                <input type="submit" style="margin-right: 5rem;" name="save" value="Save Changes" class="btn btn-primary">
                                <a class="btn btn-success " onclick="checkAll()" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                                <a class="btn btn-danger " onclick="unCheckAll()" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="panel" id="project_jobs">
                    <header class="panel-heading">
                        Project Jobs
                    </header>
                    <div class="panel-body">
                        <div class="adv-table editable-table " style="overflow-y: scroll;">
                            <div class="clearfix">
                                <div class="btn-group">
                                    <?php if ($permission->add == 1 && $project_data->status == 0) { ?>
                                        <a href="<?= base_url(); ?>projectManagment/addJob?t=<?= base64_encode($project); ?>" class="btn btn-primary ">Add New Job</a>
                                        </br></br></br>
                                    <?php } ?>

                                </div>

                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Code</th>
                                        <th>Job Name</th>
                                        <th>Product Line</th>
                                        <th>Service</th>
                                        <th>Source</th>
                                        <th>Target</th>
                                        <th>Volume</th>
                                        <th>Rate</th>
                                        <th>Total Revenue</th>
                                        <th>Currency</th>
                                        <th>Start Date</th>
                                        <th>Delivery Date</th>
                                        <th>Status</th>
                                        <th>PO Number</th>
                                        <th>CPO File</th>
                                        <th>PO Status</th>
                                        <th>PO Status Date</th>
                                        <th>Has Error</th>
                                        <th>Closed Date</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Job Files</th>
                                        <th>Email Attachment</th>
                                        <th>Client PM</th>
                                        <th>Q.C. Log</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($job->result() as $row) {
                                        $priceList     = $this->projects_model->getJobPriceListData($row->price_list);
                                        $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
                                        $check         = $this->projects_model->checkCloseJob($row->id);
                                        $poData        = $this->projects_model->getJobPoData($row->po);
                                        // get qc type depend on price list service
                                        $qc_type       = $this->projects_model->getQCTypeByService($priceList->service);
                                        $job_qc_exists = $this->projects_model->checkJobQC($row->id);
                                        // vendor evaluation
                                        $job_evalution_exists = $this->projects_model->checkJobEvaluationTasks($row->id);

                                    ?>
                                        <tr>
                                            <td>
                                                <?php //if(($check || $row->job_type == 1) && $row->status != 1){ 
                                                if ($row->status != 1 && !empty($row->client_pm_id) && ($job_qc_exists == true || empty($qc_type)) && $job_evalution_exists == true) { ?>
                                                    <input type="checkbox" class="checkPo" name="select[]" value="<?= $row->id; ?>">
                                                <?php } ?>
                                            </td>
                                            <td><a href="<?= base_url(); ?>projectManagment/jobTasks?t=<?= base64_encode($row->id); ?>"><?= $row->code; ?></a>
                                                <?php
                                                if ($row->job_type == "1") {
                                                    echo "<p class='text-center mt-2'><span class='label label-danger'>Free Job</span></p>";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $this->customer_model->getProductLine($priceList->product_line); ?></td>
                                            <td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                                            <td>
                                                <?php if ($row->type == 1) {
                                                    echo $row->volume;
                                                } elseif ($row->type == 2) {
                                                    if ($priceList->rate != 0) {
                                                        echo $total_revenue / $priceList->rate;
                                                    } else {
                                                        echo 0;
                                                    }
                                                } ?>
                                            </td>
                                            <td><?php echo $priceList->rate; ?></td>
                                            <td><?= $total_revenue; ?></td>
                                            <td><?php echo $this->admin_model->getCurrency($priceList->currency); ?></td>
                                            <td><?php echo $row->start_date; ?></td>
                                            <td><?php echo $row->delivery_date; ?></td>
                                            <td><?php echo $this->projects_model->getJobStatus($row->status); ?></td>
                                            <td><?php if (isset($poData)) {
                                                    echo $poData->number;
                                                } ?></td>
                                            <td><?php if (isset($poData)) { ?><a href="<?= base_url(); ?>assets/uploads/cpo/<?= $poData->cpo_file; ?>" target="_blank">Click Here</a><?php } ?></td>
                                            <td><?php if (isset($poData)) {
                                                    $this->accounting_model->getPOStatus($poData->verified);
                                                } ?></td>
                                            <td><?= $poData->verified_at ?? ''; ?></td>
                                            <td>
                                                <?php
                                                if (isset($poData)) {
                                                    if ($poData->verified == 2) {
                                                        $errors = explode(",", $poData->has_error);
                                                        for ($i = 0; $i < count($errors); $i++) {
                                                            if ($i > 0) {
                                                                echo " - ";
                                                            }
                                                            echo $this->accounting_model->getError($errors[$i]);
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php if ($row->status == 0) { ?>
                                                <td> </td>
                                            <?php } elseif ($row->status == 1) { ?>
                                                <td><?php echo $row->closed_date; ?></td>
                                            <?php } ?>
                                            <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                            <td><?php echo $row->created_at; ?></td>
                                            <td> <?php if (strlen($row->job_file ?? '') > 1) { ?><a href="<?= base_url(); ?>assets/uploads/jobFile/<?= $row->job_file; ?>" target="_blank"><?= $row->job_file_name; ?></a><?php } ?></td>
                                            <td> <?php if (strlen($row->attached_email ?? '') > 1 && $row->job_type == "1") { ?><a href="<?= base_url(); ?>assets/uploads/jobFile/<?= $row->attached_email; ?>" target="_blank">Click Here..</a><?php } ?></td>
                                            <td><?= $this->projects_model->getClientPM($row->client_pm_id); ?></td>
                                            <td>
                                                <!--qc log-->
                                                <?php if ($row->status == 0 && $qc_type != null && $job_qc_exists == false) { ?>
                                                    <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#qcModal_<?= $row->id; ?>">
                                                        <i class="fa fa-plus-circle"></i> Add Q.C.
                                                    </a>
                                                <?php } elseif ($row->status == 0 && $qc_type != null && $job_qc_exists == true) { ?>
                                                    <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#qcEditModal_<?= $row->id; ?>">
                                                        <i class="fa fa-pencil"></i> Edit Q.C.
                                                    </a>
                                                <?php } elseif ($row->status == 1 && $qc_type != null && $job_qc_exists == true) { ?>
                                                    <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#qcListModal_<?= $row->id; ?>">
                                                        <i class="fa fa-list"></i> View Q.C.
                                                    </a>
                                                <?php }
                                                ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-cogs mr-2"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="<?= base_url(); ?>projectManagment/jobTasks?t=<?= base64_encode($row->id); ?>" class="dropdown-item">
                                                        <i class="fa fa-tasks"></i> Tasks</a>

                                                    <?php if ($permission->edit == 1 && $row->status == 1 && $poData->verified != 1) { ?>
                                                        <a href="<?php echo base_url(); ?>ProjectManagment/reopenJob?t=<?php
                                                                                                                        echo
                                                                                                                        base64_encode($row->id);
                                                                                                                        ?>&p=<?= base64_encode($poData->id); ?>" class="dropdown-item" onclick="return confirm('Are you sure you want to Re-open this Job ?');">
                                                            <i class="fa fa-undo"></i> Re-open
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($permission->edit == 1 && $row->status == 0) { ?>
                                                        <a href="<?php echo base_url(); ?>projectManagment/editJob?t=<?php
                                                                                                                        echo
                                                                                                                        base64_encode($row->id);
                                                                                                                        ?>&p=<?= base64_encode($row->project_id); ?>" class="dropdown-item">
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($permission->delete == 1 && $row->status == 0) { ?>
                                                        <a href="<?php echo base_url(); ?>projectManagment/deleteJob?t=<?php
                                                                                                                        echo
                                                                                                                        base64_encode($row->id);
                                                                                                                        ?>&p=<?= base64_encode($row->project_id); ?>" title="delete" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this Project ?');">
                                                            <i class="fa fa-times text-danger text"></i> Delete
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($permission->add == 1 && $row->status == 0) {
                                                    ?>
                                                        <a href="<?php echo base_url(); ?>projectManagment/addTaskVendorModule?t=<?=
                                                                                                                                    base64_encode($row->id);
                                                                                                                                    ?>" title="send" class="dropdown-item">
                                                            <i class="fa fa-envelope-o"></i> Assign To Vendor
                                                        </a>
                                                        <?php if ($priceList->service == 1) { ?>
                                                            <a href="<?php echo base_url(); ?>projectManagment/addTranslationTask?t=<?=
                                                                                                                                    base64_encode($row->id);
                                                                                                                                    ?>" title="send" class="dropdown-item">
                                                                <i class="fa fa-sort-alpha-asc"></i> Send Request To Translation
                                                            </a>
                                                        <?php }
                                                        if ($priceList->service == 23) { ?>
                                                            <a href="<?= base_url(); ?>projectManagment/dtpRequest?t=<?= base64_encode($row->id); ?>" title="send" class="dropdown-item">
                                                                <i class="fa fa-font"></i> Send Request To DTP
                                                            </a>
                                                        <?php } ?>
                                                        <a href="<?php echo base_url(); ?>projectManagment/addLeTask?t=<?=
                                                                                                                        base64_encode($row->id);
                                                                                                                        ?>" title="send" class="dropdown-item">
                                                            <i class="fa fa-font"></i> Send Request To LE
                                                        </a>

                                                    <?php } ?>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </form>

            <section class="panel" id="vendor_tasks">
                <header class="panel-heading">
                    Vendor Tasks
                </header>
                <div id="vendorTasks" class="panel-body">
                    <div class="adv-table editable-table " style="overflow-y: scroll;">

                        <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>Task Code</th>
                                    <th>Task Subject</th>
                                    <th>Task Type</th>
                                    <th>Vendor</th>
                                    <th>Count</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Total Cost</th>
                                    <th>Currency</th>
                                    <th>Start Date</th>
                                    <th>Delivery Date</th>
                                    <th>Time Zone</th>
                                    <th>Task File</th>
                                    <th>Vendor Attachment</th>
                                    <th>Status</th>
                                    <th>Closed Date</th>
                                    <th>VPO Status</th>
                                    <th>Has Error</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Re-open</th>
                                    <th>View </th>
                                    <th>Edit </th>
                                    <th>Vendor Evaluation </th>
                                    <th>Delete</th>
                                    <th>Cancel Task</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks->result() as $task) {
                                    $task_ev_exists = $this->projects_model->checkTaskEvaluationExists($task->id);
                                    $job_data       = $this->projects_model->getJobData($task->job_id);
                                    $job_status     = $job_data->status;
                                ?>
                                    <tr>
                                        <td><a href="<?= base_url(); ?>projects/taskPage?t=<?= base64_encode($task->id); ?>"><?= $task->code; ?></a></td>
                                        <td><?php echo $task->subject; ?></td>
                                        <td><?php echo $this->admin_model->getTaskType($task->task_type); ?></td>
                                        <td><?php echo $this->vendor_model->getVendorName($task->vendor); ?></td>
                                        <td><?php echo $task->count; ?></td>
                                        <td><?php echo $this->admin_model->getUnit($task->unit); ?></td>
                                        <td><?php echo $task->rate; ?></td>
                                        <td><?php echo $task->rate * $task->count; ?></td>
                                        <td><?php echo $this->admin_model->getCurrency($task->currency); ?></td>
                                        <td><?php echo $task->start_date; ?></td>
                                        <td><?php echo $task->delivery_date; ?></td>
                                        <td><?= $this->admin_model->getTimeZone($task->time_zone); ?></td>
                                        <td><?php if (strlen($task->file ?? '') > 1) { ?>
                                                <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/taskFile/", $task->file, $task->start_after_type); ?>" target="_blank">Click Here</a>
                                                <?php } else {
                                                if ($task->start_after_id != null && $task->start_after_type == "Vendor") { ?>
                                                    <?= $this->projects_model->getTaskVendorNotes($task->start_after_id); ?>
                                            <?php }
                                            } ?>
                                        </td>
                                        <td><?php if (strlen($task->vendor_attachment ?? '') > 1) { ?><a href="<?= $this->projects_model->getNexusLinkByBrand(); ?>/assets/uploads/jobTaskVendorFiles/<?= $task->vendor_attachment; ?>" target="_blank">Click Here ..</a><?php } ?></td>
                                        <td>
                                            <?php echo $this->projects_model->getJobStatus($task->status);
                                            if (!empty($task->start_after_id)) {
                                                echo "<br/><span>Start After Task : " . $task->start_after_type . "-" . $task->start_after_id . "<span>";
                                            } ?>
                                            <?php if ($permission->view == 1 && $task->job_portal == 1 && $task->status == 5) { ?>
                                                <p class="text-center"> <a href="<?php echo base_url(); ?>ProjectManagment/pmDirectConfirm?task_id=<?php
                                                                                                                                                    echo
                                                                                                                                                    base64_encode($task->id);
                                                                                                                                                    ?>" class="btn btn-sm btn-default mt-2" onclick="return confirm('Are you sure you want to Confirm this Task ?');">
                                                        <i class="fa fa-check-circle  text-success text"></i> Confirm
                                                    </a></p>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $task->closed_date; ?></td>
                                        <td><?= $this->accounting_model->getPOStatus($task->verified); ?></td>
                                        <td>
                                            <?php
                                            if ($task->verified == 2) {
                                                $errors = explode(",", $task->has_error);
                                                for ($i = 0; $i < count($errors); $i++) {
                                                    if ($i > 0) {
                                                        echo " - ";
                                                    }
                                                    echo $this->accounting_model->getError($errors[$i]);
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $this->admin_model->getAdmin($task->created_by); ?></td>
                                        <td><?php echo $task->created_at; ?></td>
                                        <td>
                                            <?php $job_data = $this->projects_model->getJobData($task->job_id);
                                            if ($permission->edit == 1 && $task->status == 1 && $task->verified != 1 && $job_data->status == 0 && $this->automation_model->checkIfSoftwareMember($this->emp_id)) { ?>
                                                <a href="<?php echo base_url(); ?>projectManagment/reopenTask?t=<?php
                                                                                                                echo
                                                                                                                base64_encode($task->id);
                                                                                                                ?>&p=<?= base64_encode($job_data->status); ?>" class="" onclick="return confirm('Are you sure you want to Re-open this Task ?');">
                                                    <i class="fa fa-undo"></i> Re-open
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->view == 1 && $task->job_portal == 1) { ?>
                                                <a href="<?php echo base_url(); ?>ProjectManagment/viewTask?t=<?php
                                                                                                                echo
                                                                                                                base64_encode($task->id);
                                                                                                                ?>&j=<?= base64_encode($task->job_id); ?>" class="">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1 && ($task->status == 0 || $task->status == 4 || $task->status == 3)) { ?>
                                                <a href="<?php echo base_url(); ?>ProjectManagment/editTask?t=<?=
                                                                                                                base64_encode($task->id);
                                                                                                                ?>&j=<?= base64_encode($task->job_id); ?>" class="">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <!--Task Evaluation -->
                                            <?php if ($task->status == 1 && $task_ev_exists == false && $job_status == 0) { ?>
                                                <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#evAddModal_<?= $task->id; ?>">
                                                    <i class="fa fa-plus-circle"></i> Add
                                                </a>
                                            <?php } elseif ($task->status == 1 && $task_ev_exists == true && $job_status == 0) { ?>
                                                <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#evEditModal_<?= $task->id; ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            <?php } elseif ($task_ev_exists == true && $job_status == 1) { ?>
                                                <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#evModal_<?= $task->id; ?>">
                                                    <i class="fa fa-list"></i> View
                                                </a>
                                            <?php }
                                            $this->view('projectManagment/projectJobs_includes2'); ?>
                                        </td>
                                        <!--                                        <td>
                                                                                                                                                                                               <?php
                                                                                                                                                                                                $feedback = $this->db->get_where('task_feedback', array('task_id' => $task->id))->num_rows();
                                                                                                                                                                                                if ($permission->edit == 1 && ($task->status == 1 && $feedback == 0)) { ?>
                                                                                                                                                                                                                                                                                                                                <a href="<?php echo base_url(); ?>projectManagment/addTaskFeedback?t=<?php echo
                                                                                                                                                                                                                                                                                                                                                                                                        base64_encode($task->id); ?>" class="">
                                                                                                                                                                                                                                                                                                                                        <i class="fa fa-star"></i> Add Feedback
                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                <?php } ?>
                                                                                                                                                             </td>-->

                                        <td>
                                            <?php if ($permission->delete == 1 && $task->status != 1) { ?>
                                                <a href="<?php echo base_url(); ?>ProjectManagment/deleteTask?t=<?php
                                                                                                                echo
                                                                                                                base64_encode($task->id);
                                                                                                                ?>&j=<?= base64_encode($task->job_id); ?>" title="delete" class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
                                                    <i class="fa fa-times text-danger text"></i> Delete
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1 && $task->status != 1) { ?>
                                                <a href="<?php echo base_url(); ?>ProjectManagment/cancelTask?t=<?php
                                                                                                                echo
                                                                                                                base64_encode($task->id);
                                                                                                                ?>&j=<?= base64_encode($task->job_id); ?>" title="Cancel" class="" onclick="return confirm('Are you sure you want to Cancel this Task ?');">
                                                    <i class="fa fa-times text-danger text"></i> Cancel
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1 && ($task->status == 8 || $task->status == 6)) { ?>
                                                <a href="<?php echo base_url(); ?>projectPlanning/startVendorTask?t=<?= base64_encode($task->id); ?>" class="" onclick="return confirm('Are you sure you want to Start this Task Now ?');">
                                                    <i class="fa fa-clock-o"></i> Start Now
                                                </a>
                                            <?php } ?>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel" id="vendor_tasks_offers">

                <header class="panel-heading">
                    <button id="button_filter2" onclick="showAndHide('vendorTasksOffers','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>

                    Vendor Offers List
                </header>
                <div id="vendorTasksOffers" class="panel-body">
                    <div class="adv-table editable-table " style="overflow-y: scroll;">

                        <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task Subject</th>
                                    <th>Task Type</th>
                                    <th>Count</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Total Cost</th>
                                    <th>Currency</th>
                                    <th>Start Date</th>
                                    <th>Delivery Date</th>
                                    <th>Time Zone</th>
                                    <th>Task File</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>View </th>
                                    <th>Cancel Task</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks_offers->result() as $task) {
                                ?>
                                    <tr>
                                        <td><?php echo $task->id; ?></td>
                                        <td><?php echo $task->subject; ?></td>
                                        <td><?php echo $this->admin_model->getTaskType($task->task_type); ?></td>
                                        <td><?php echo $task->count; ?></td>
                                        <td><?php echo $this->admin_model->getUnit($task->unit); ?></td>
                                        <td><?php echo $task->rate; ?></td>
                                        <td><?php echo $task->rate * $task->count; ?></td>
                                        <td><?php echo $this->admin_model->getCurrency($task->currency); ?></td>
                                        <td><?php echo $task->start_date; ?></td>
                                        <td><?php echo $task->delivery_date; ?></td>
                                        <td><?= $this->admin_model->getTimeZone($task->time_zone); ?></td>
                                        <td><?php if (strlen($task->file ?? '') > 1) { ?>
                                                <a href="<?= base_url(); ?>assets/uploads/taskFile/<?= $task->file; ?>" target="_blank">Click Here</a>
                                            <?php } ?>
                                        </td>
                                        <td> <?php echo $this->projects_model->getVendorOfferStatus($task->status);
                                                if (!empty($task->start_after_id)) {
                                                    echo "<br/><span>Start After Task : " . $task->start_after_type . "-" . $task->start_after_id . "<span>";
                                                } ?>
                                        </td>

                                        <td><?php echo $this->admin_model->getAdmin($task->created_by); ?></td>
                                        <td><?php echo $task->created_at; ?></td>
                                        <td>
                                            <?php if ($permission->view == 1 && $task->job_portal == 1) { ?>
                                                <a href="<?php echo base_url(); ?>ProjectManagment/viewOffer?t=<?php
                                                                                                                echo
                                                                                                                base64_encode($task->id);
                                                                                                                ?>&j=<?= base64_encode($task->job_id); ?>" class="">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1 && $task->status == 4) { ?>
                                                <a href="<?php echo base_url(); ?>ProjectManagment/cancelOffer?t=<?=
                                                                                                                    base64_encode($task->id);
                                                                                                                    ?>&j=<?= base64_encode($task->job_id); ?>" title="Cancel" class="" onclick="return confirm('Are you sure you want to Cancel this Task ?');">
                                                    <i class="fa fa-times text-danger text"></i> Cancel
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel" id="translation_tasks">

                <header class="panel-heading">
                    <button id="button_filter3" onclick="showAndHide('translationTasks','button_filter3');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
                    Translation Tasks
                </header>
                <div id="translationTasks" class="panel-body">
                    <div class="adv-table editable-table " style="overflow-y: scroll;">
                        <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>Task Code</th>
                                    <th>Task Subject</th>
                                    <th>Task Type</th>
                                    <th>Count</th>
                                    <th>TM</th>
                                    <th>Net word count</th>
                                    <th>Unit</th>
                                    <th>Work Hours</th>
                                    <th>Overtime Hours</th>
                                    <th>Double Paid Hours</th>
                                    <th>Total Cost in $</th>
                                    <th>Start Date</th>
                                    <th>Delivery Date</th>
                                    <th>Task File</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>View Task</th>
                                    <th>Edit </th>
                                    <th>Cancel </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($translation_request)) {
                                    foreach ($translation_request->result() as $row) {
                                        $dateArray      = explode("-", $row->created_at);
                                        $year           = $dateArray[0];
                                        $rateProduction = $this->db->get_where('production_team_cost', array('task_type' => $row->task_type, 'unit' => $row->unit, 'year' => $year, 'team' => 1))->row()->rate ?? '';
                                        $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 2);
                                ?>
                                        <tr>
                                            <td>Translation-<?= $row->id; ?></a></td>
                                            <td><?php echo $row->subject; ?></td>
                                            <td><?php echo $this->admin_model->getTaskType($row->task_type); ?></td>
                                            <td><?php echo $row->count; ?></td>
                                            <td><?php echo $row->tm; ?></td>
                                            <td><?php echo $row->count - $row->tm; ?></td>
                                            <td><?php echo $this->admin_model->getUnit($row->unit); ?></td>
                                            <td><?= $row->work_hours ?></td>
                                            <td><?= $row->overtime_hours ?></td>
                                            <td><?= $row->doublepaid_hours ?></td>
                                            <!--<td><?php echo number_format(floatval($rateTrnasfared) * floatval($row->count), 2); ?></td>-->
                                            <td><?= round($this->projects_model->getTaskCost(2, $row), 2) ?></td>
                                            <td><?php echo $row->start_date; ?></td>
                                            <td><?php echo $row->delivery_date; ?></td>
                                            <td><?php if (strlen($row->file ?? '') > 1) { ?>
                                                    <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/translationRequest/", $row->file, $row->start_after_type); ?>" target="_blank">Click Here</a>
                                                    <?php } else {
                                                    if ($row->start_after_id != null && $row->start_after_type == "Vendor") { ?>
                                                        <?= $this->projects_model->getTaskVendorNotes($row->start_after_id); ?>
                                                <?php }
                                                } ?>
                                            </td>
                                            <td><?php echo $this->projects_model->getTranslationTaskStatus($row->status);
                                                if (!empty($row->start_after_id)) {
                                                    echo "<br/><span>Start After Task : " . $row->start_after_type . "-" . $row->start_after_id . "<span>";
                                                } ?>
                                            </td>
                                            <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                            <td><?php echo $row->created_at; ?></td>
                                            <td>
                                                <?php if ($permission->edit == 1) { ?>
                                                    <a href="<?php echo base_url(); ?>projectManagment/translationTask?t=<?php echo
                                                                                                                            base64_encode($row->id);
                                                                                                                            ?>" class="">
                                                        <i class="fa fa-eye"></i> View Task
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projectManagment/editTranslationTask?t=<?php echo
                                                                                                                                base64_encode($row->id);
                                                                                                                                ?>&j=<?= base64_encode($row->job_id); ?>" class="">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projectManagment/cancelTranslationRequest?t=<?php echo
                                                                                                                                    base64_encode($row->id);
                                                                                                                                    ?>" title="Cancel" class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
                                                        <i class="fa fa-times text-danger text"></i> Cancel
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 8 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projectPlanning/startTranslationTask?t=<?= base64_encode($row->id); ?>" class="" onclick="return confirm('Are you sure you want to Start this Task Now ?');">
                                                        <i class="fa fa-clock-o"></i> Start Now
                                                    </a>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel" id="dtp_tasks">
                <header class="panel-heading">
                    <button id="button_filter2" onclick="showAndHide('dtpTasks','button_filter4');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
                    DTP Tasks
                </header>
                <div id="dtpTasks" class="panel-body">
                    <div class="adv-table editable-table " style="overflow-y: scroll;">
                        <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>Task Code</th>
                                    <th>Task Subject</th>
                                    <th>Task Type</th>
                                    <th>Unit</th>
                                    <th>Volume</th>
                                    <th>Source Language Direction</th>
                                    <th>Target Language Direction</th>
                                    <th>Source Application</th>
                                    <th>Target Application</th>
                                    <th>Translatio In</th>
                                    <th>Rate</th>
                                    <th>Work Hours</th>
                                    <th>Overtime Hours</th>
                                    <th>Double Paid Hours</th>
                                    <th>Total Cost in $</th>
                                    <th>File Attachment</th>
                                    <th>Start Date</th>
                                    <th>Delivery Date</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>View Task</th>
                                    <th>Edit</th>
                                    <th>Cancel </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($dtp_request)) {
                                    foreach ($dtp_request->result() as $row) {
                                        $dateArray      = explode("-", $row->created_at);
                                        $year           = $dateArray[0];
                                        $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $row->unit, 'year' => $year, 'brand' => $this->brand, 'team' => 3))->row()->rate;
                                        $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 2);
                                ?>
                                        <tr>
                                            <td>DTP-<?= $row->id; ?></td>
                                            <td><?= $row->task_name; ?></td>
                                            <td><?= $this->admin_model->getDTPTaskType($row->task_type); ?></td>
                                            <td><?= $this->admin_model->getUnit($row->unit); ?></td>
                                            <td><?= $row->volume; ?></td>
                                            <td><?= $this->admin_model->getDTPDirection($row->source_direction); ?></td>
                                            <td><?= $this->admin_model->getDTPDirection($row->target_direction); ?></td>
                                            <td><?= $this->admin_model->getDTPApplication($row->source_application); ?></td>
                                            <td><?= $this->admin_model->getDTPApplication($row->target_application); ?></td>
                                            <td><?= $this->admin_model->getDTPApplication($row->translation_in); ?></td>
                                            <td><?= $row->rate; ?></td>
                                            <td><?= $row->work_hours ?></td>
                                            <td><?= $row->overtime_hours ?></td>
                                            <td><?= $row->doublepaid_hours ?></td>
                                            <td><?= round($this->projects_model->getTaskCost(3, $row), 2) ?></td>
                                            <!--<td><?php echo $rateTrnasfared * $row->volume; ?></td>-->
                                            <td><?php if (strlen($row->file ?? '') > 1) { ?>
                                                    <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/dtpRequest/", $row->file, $row->start_after_type); ?>" target="_blank">Click Here</a>
                                                    <?php } else {
                                                    if ($row->start_after_id != null && $row->start_after_type == "Vendor") { ?>
                                                        <?= $this->projects_model->getTaskVendorNotes($row->start_after_id); ?>
                                                <?php }
                                                } ?>
                                            </td>
                                            <td><?= $row->start_date; ?></td>
                                            <td><?= $row->delivery_date; ?></td>
                                            <td><?php echo $this->projects_model->getDTPTaskStatus($row->status);
                                                if (!empty($row->start_after_id)) {
                                                    echo "<br/><span>Start After Task : " . $row->start_after_type . "-" . $row->start_after_id . "<span>";
                                                } ?>
                                            </td>
                                            <td><?= $this->admin_model->getAdmin($row->created_by); ?></td>
                                            <td><?= $row->created_at; ?></td>
                                            <td>
                                                <?php if ($permission->edit == 1) { ?>
                                                    <a href="<?php echo base_url(); ?>projects/dTPTask?t=<?php echo
                                                                                                            base64_encode($row->id);
                                                                                                            ?>&j=<?= base64_encode($row->job_id); ?>" class="">
                                                        <i class="fa fa-eye"></i> View Task
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projects/editDtpTask?t=<?php echo
                                                                                                                base64_encode($row->id);
                                                                                                                ?>&j=<?= base64_encode($row->job_id); ?>" class="">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projects/cancelDTPRequest?t=<?php echo
                                                                                                                    base64_encode($row->id);
                                                                                                                    ?>&j=<?= base64_encode($row->job_id); ?>" title="Cancel" class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
                                                        <i class="fa fa-times text-danger text"></i> Cancel
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 8 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projectPlanning/startDTPTask?t=<?= base64_encode($row->id); ?>" class="" onclick="return confirm('Are you sure you want to Start this Task Now ?');">
                                                        <i class="fa fa-clock-o"></i> Start Now
                                                    </a>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="panel" id="le_tasks">

                <header class="panel-heading">
                    <button id="button_filter1" onclick="showAndHide('leTasks','button_filter1');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
                    LE Tasks
                </header>

                <div id="leTasks" class="panel-body">
                    <div class="adv-table editable-table " style="overflow-y: scroll;">

                        <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>Task Code</th>
                                    <th>Task Subject</th>
                                    <th>Task Type</th>
                                    <th>Subject Matter</th>
                                    <th>Work Hours</th>
                                    <th>Overtime Hours</th>
                                    <th>Double Paid Hours</th>
                                    <th>Total Cost in $</th>
                                    <th>Start Date</th>
                                    <th>Delivery Date</th>
                                    <th>Task File</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>View Task</th>
                                    <th>Edit </th>
                                    <th>Cancel </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($le_request)) {
                                    foreach ($le_request->result() as $row) {
                                        $dateArray      = explode("-", $row->created_at);
                                        $year           = $dateArray[0];
                                        $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $row->unit, 'year' => $year, 'team' => 2))->row()->rate ?? '';
                                        $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 2);
                                ?>
                                        <tr>
                                            <td>LE-<?= $row->id; ?></td>
                                            <td><?php echo $row->subject; ?></td>
                                            <td><?php echo $this->admin_model->getLETaskType($row->task_type); ?></td>
                                            <td><?php echo $this->admin_model->getLESubject($row->subject_matter); ?></td>
                                            <td><?= $row->work_hours ?></td>
                                            <td><?= $row->overtime_hours ?></td>
                                            <td><?= $row->doublepaid_hours ?></td>
                                            <td><?= round($this->projects_model->getTaskCost(4, $row), 2) ?></td>
                                            <!--                                            <td><?php echo $rateTrnasfared * $row->volume; ?></td>-->
                                            <td><?php echo $row->start_date; ?></td>
                                            <td><?php echo $row->delivery_date; ?></td>
                                            <td><?php if (strlen($row->file ?? '') > 1) { ?>
                                                    <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/leRequest/", $row->file, $row->start_after_type); ?>" target="_blank">Click Here</a>
                                                    <?php } else {
                                                    if ($row->start_after_id != null && $row->start_after_type == "Vendor") { ?>
                                                        <?= $this->projects_model->getTaskVendorNotes($row->start_after_id); ?>
                                                <?php }
                                                } ?>
                                            </td>
                                            <td><?php echo $this->projects_model->getLETaskStatus($row->status);
                                                if (!empty($row->start_after_id)) {
                                                    echo "<br/><span>Start After Task : " . $row->start_after_type . "-" . $row->start_after_id . "<span>";
                                                } ?>
                                            </td>
                                            <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                            <td><?php echo $row->created_at; ?></td>
                                            <td>
                                                <?php if ($permission->edit == 1) { ?>
                                                    <a href="<?php echo base_url(); ?>projects/leTask?t=<?php echo
                                                                                                        base64_encode($row->id);
                                                                                                        ?>" class="">
                                                        <i class="fa fa-eye"></i> View Task
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projects/editLeTask?t=<?php echo
                                                                                                            base64_encode($row->id);
                                                                                                            ?>&j=<?= base64_encode($row->job_id); ?>" class="">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projects/cancelLERequest?t=<?php echo
                                                                                                                    base64_encode($row->id);
                                                                                                                    ?>&j=<?= base64_encode($row->job_id); ?>" title="Cancel" class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
                                                        <i class="fa fa-times text-danger text"></i> Cancel
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($permission->edit == 1 && ($row->status == 8 || $row->status == 6)) { ?>
                                                    <a href="<?php echo base_url(); ?>projectPlanning/startLeTask?t=<?= base64_encode($row->id); ?>" class="" onclick="return confirm('Are you sure you want to Start this Task Now ?');">
                                                        <i class="fa fa-clock-o"></i> Start Now
                                                    </a>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <div class="col-sm-2">
        <section class="panel">
            <p style="border: 1px #185898 solid;padding: 10px;border-left: 10px #185898 solid;font-weight: bold"> Project Status : <?= $this->projects_model->getNewProjectStatus($project_data->status, $project_data->id); ?></p>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Project Data
            </header>
            <div class="panel-body">
                <h5 class="text-dark font-weight-bold mb-2">Project Code</h5>
                <p class="ml-2"><?= $project_data->code; ?></p>

                <h5 class="text-dark font-weight-bold">Project Name</h5>
                <p class="ml-2"><?= $project_data->name; ?></p>

                <h5 class="text-dark font-weight-bold mb-2">Client</h5>
                <p class="ml-2"><?= $this->customer_model->getCustomer($project_data->customer); ?></p>

                <h5 class="text-dark font-weight-bold mb-2">Product Line</h5>
                <p class="ml-2"><?= $this->customer_model->getProductLine($project_data->product_line); ?></p>
                <?php if ($this->brand == 1) { ?>
                    <h5 class="text-dark font-weight-bold mb-2">TTG Branch Name</h5>
                    <p class="ml-2"><?= $this->projects_model->getTTGBranchName($project_data->branch_name); ?></p>
                <?php } ?>
                <h5 class="text-dark font-weight-bold mb-2">Created By</h5>
                <p class="ml-2"><?= $this->admin_model->getAdmin($project_data->created_by); ?></p>

                <h5 class="text-dark font-weight-bold mb-2">Created At</h5>
                <p class="ml-2"><?= $project_data->created_at; ?></p>
                <hr />
                <h5 class="text-dark font-weight-bold mb-2">Project Revenue </h5>
                <p class="ml-2"><?= round($this->projects_model->getProjectRevenue($project_data->id), 2) . ' $' ?></p>
                <h5 class="text-dark font-weight-bold mb-2">Project Cost </h5>
                <p class="ml-2"><?= round($this->projects_model->getProjectCost($project_data->id), 2) . ' $' ?></p>
                <h5 class="text-dark font-weight-bold mb-2">Project Profit </h5>
                <p class="ml-2"><?= round($this->projects_model->getProjectProfit($project_data->id), 2) . ' $' ?></p>
                <h5 class="text-dark font-weight-bold mb-2">Project Profit Percentage % </h5>
                <p class="ml-2"><?= round($this->projects_model->getProjectProfitPercentage($project_data->id), 2) . ' %' ?></p>
                <h5 class="text-dark font-weight-bold mb-2">Minimum Project Profit Percentage % </h5>
                <p class="ml-2"><?= $project_data->min_profit_percentage ?? '--' ?> %</p>
                <?php if (!empty($project_data->approval_by)) { ?>
                    <h5 class="text-dark font-weight-bold mb-2">approval By </h5>
                    <p class="ml-2"><?= $this->admin_model->getAdmin($project_data->approval_by); ?></p>
                    <h5 class="text-dark font-weight-bold mb-2">approval At </h5>
                    <p class="ml-2"><?= $project_data->approval_at; ?></p>
                <?php }
                if ($permission->edit == 1 && $project_data->status == 0 && $this->projects_model->checkManagerAccess($project_data->id) == TRUE) { ?>
                    <p>
                        <a href="<?php echo base_url() ?>projectManagment/editProjectPercentage?t=<?= base64_encode($project_data->id); ?>" class=" btn btn-primary font-size-xs">
                            <i class="fa fa-pencil"></i> Edit Min. Percentage
                        </a>
                    </p>
                <?php } ?>

            </div>
        </section>
        <?php if ($project_data->status == 0) { ?>
            <section class="panel">
                <a class="btn btn-primary center-block" href="<?php echo base_url(); ?>vendor/vmPmTicket?t=<?php echo base64_encode($project_data->id); ?>" title="Add Tickets" style="color:#fff">View Tickets</a>
            </section>
        <?php } ?>
    </div>
</div>
<script>
    $(document).on("click", ".qc_default", function() {
        var id = $(this).attr('id').replace('btn_', '');
        var model_body = $(this).closest(".modal").find(".modal-body")
        model_body.html($("#default_" + id).html());
        $(this).remove();
    });

    $(document).on("change", "#myRange", function() {
        var value = $(this).val();
        if (value < 5) {
            var model_body = $("#pm_setup").html();
            $(".bad_review").html(model_body);
        } else {
            $(".bad_review").html('');
        }

    });
</script>