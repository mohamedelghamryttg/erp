<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title"> Add New Job </h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>dtp/doAddJob" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="text" name="request_id" value="<?= base64_encode($task->id) ?>" hidden="">
                    <!--begin::Card-->
                    <div class="card">

                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                                <thead>
                                    <tr>
                                        <th>Task Code</th>
                                        <th>PM</th>
                                        <th>Task Name</th>
                                        <th>Task Type</th>
                                        <th>Product line</th>
                                        <th>Volume</th>
                                        <th>Unit</th>
                                        <th>Source Language</th>
                                        <th>Source Language Direction</th>
                                        <th>Target Language</th>
                                        <th>Target Language Direction</th>
                                        <th>Source Application</th>
                                        <th>Target Application</th>
                                        <th>Translatio In</th>
                                        <th>Rate</th>
                                        <th>File Attachment</th>
                                        <th>Start Delivery</th>
                                        <th>Delivery Date</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Task Started At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($task->source_language == 0) {
                                        $source = $priceListData->source;
                                        $target = $priceListData->target;
                                    } else {
                                        $source = $task->source_language;
                                        $target = $task->target_language;
                                    }
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo base_url() ?>dtp/dtpJobs?t=<?php echo base64_encode($task->id); ?>" class="">DTP-<?= $task->id ?></a></td>
                                        <td><?= $this->admin_model->getAdmin($task->created_by) ?></td>
                                        <td><?= $task->task_name ?></td>
                                        <td><?= $this->admin_model->getDTPTaskType($task->task_type) ?></td>
                                        <td><?php echo $this->customer_model->getProductLine($priceListData->product_line); ?></td>
                                        <td><?= $task->volume ?></td>
                                        <td><?= $this->admin_model->getUnit($task->unit) ?></td>
                                        <td><?= $this->admin_model->getLanguage($source) ?></td>
                                        <td><?= $this->admin_model->getDTPDirection($task->source_direction) ?></td>
                                        <td><?= $this->admin_model->getLanguage($target) ?></td>
                                        <td><?= $this->admin_model->getDTPDirection($task->target_direction) ?></td>
                                        <td><?= $this->admin_model->getDTPApplication($task->source_application) ?></td>
                                        <td><?= $this->admin_model->getDTPApplication($task->target_application) ?></td>
                                        <td><?= $this->admin_model->getDTPApplication($task->translation_in) ?></td>
                                        <td><?= $task->rate ?></td>
                                        <td><?php if (strlen($task->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/dtpRequest/<?= $task->file ?>" target="_blank">Click Here</a><?php } ?></td>
                                        <td><?= $task->start_date ?></td>
                                        <td><?= $task->delivery_date ?></td>
                                        <td><?= $task->created_at ?></td>
                                        <td><?= $this->projects_model->getDTPTaskStatus($task->status) ?></td>
                                        <td><?= $this->admin_model->getAdmin($task->status_by) ?></td>
                                        <td><?= $task->status_at ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end: Datatable-->
                        </div>
                    </div>
                    <!--end::Card-->
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">DTP :</label>

                        <div class="col-lg-6">
                            <select name="dtp" class="form-control" id="dtp" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectAllDTP($this->brand) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Task Type :</label>

                        <div class="col-lg-6">
                            <select name="task_type" class="form-control" id="task_type" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectDTPTaskType($task->task_type) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Volume :</label>
                        <div class="col-lg-6">
                            <input class="form-control" name="volume" value="<?= $task->volume ?>" onkeypress="return numbersOnly(event)" id="volume" />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Unit :</label>

                        <div class="col-lg-6">
                            <select name="unit" class="form-control" id="unit" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectUnit($task->unit) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Source Language Direction :</label>

                        <div class="col-lg-6">
                            <select name="source_direction" class="form-control" id="source_direction" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectDTPDirection($task->source_direction) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Target Language Direction :</label>

                        <div class="col-lg-6">
                            <select name="target_direction" class="form-control" id="target_direction" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectDTPDirection($task->target_direction) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Source Application :</label>

                        <div class="col-lg-6">
                            <select name="source_application" class="form-control" id="source_application" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectDTPApplication($task->source_application) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Target Application :</label>

                        <div class="col-lg-6">
                            <select name="target_application" class="form-control" id="target_application" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectDTPApplication($task->target_application) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Translatio In :</label>

                        <div class="col-lg-6">
                            <select name="translation_in" class="form-control" id="translation_in" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->admin_model->selectDTPApplication($task->translation_in) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">File Attachment :</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" name="file" id="file" accept="'application/zip'" />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Start Date :</label>
                        <div class="col-lg-6">
                            <input onchange="checkDate('start_date')" value="<?= date("Y-m-d H:i:s") ?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="" />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Delivery Date :</label>
                        <div class="col-lg-6">
                            <input onchange="checkDate('delivery_date')" value="<?= $task->delivery_date ?>" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="" />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Cleint Instructions :</label>
                        <div class="col-lg-6">
                            <textarea name="insrtuctions" class="form-control ckeditor" rows="6"></textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <input class="btn btn-success mr-2" type="submit" name="submit" value="Save">
                            </div>
                        </div>
                    </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>