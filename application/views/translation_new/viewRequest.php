<style>
    span.select2 {
        width: 100% !important;
    }
    .btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled), .btn.btn-clean:focus:not(.btn-text), .btn.btn-clean.focus:not(.btn-text){
        background-color: transparent!important;
        border-color: transparent;
    }
</style>
<script>tinymce.init({selector: 'textarea'});</script>  
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h4 class="card-label">View Request</h4>
                        <p class="w-100 font-weight-bold"><span class="text-danger font-weight-bolder">Note  </span>:&nbsp; Team Leader Can Change Request Status From Closed to Running.</p>
                   
                    </div>
                    <?php if($task->status == 3 && ($this->role == 21 || $this->role == 28 )){?>
                            <form class="mt-n5"action="<?php echo base_url() ?>translation/updateClosedTranslationRequestToRunning" method="post" >
                            <input name="id" type="hidden" value="<?= base64_encode($task->id) ?>" readonly="">
                                 <button type="submit" class="btn btn-sm btn-light-dark mr-2" onclick="return confirm('Are You Sure ... ?')">Update Request Status From Closed to Running</button>
                            </form>
                 <?php   }?>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                                <th colspan="2">PM</th>
                                <td colspan="2"><?= $this->admin_model->getAdmin($task->created_by) ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Task Code</td>
                                <td>Translation-<?= $task->id ?></td>
                                <td>Task Name</td>
                                <td><?= $task->subject ?></td>
                            </tr>
                            <tr>
                                <td>Task Type</td>
                                <td><?= $this->admin_model->getTaskType($task->task_type) ?></td>
                                <td>Product line</td>
                                <td><?php echo $this->customer_model->getProductLine($priceListData->product_line); ?></td>
                            </tr>
                            <tr>
                                <td>Volume</td>
                                <td><?= $task->count ?></td>
                                <td>Unit</td>
                                <td><?= $this->admin_model->getUnit($task->unit) ?></td>
                            </tr>
                            <tr>
                                <td>Source Language</td>
                                <td><?= $this->admin_model->getLanguage($priceListData->source) ?></td>
                                <td>Target Language</td>
                                <td><?= $this->admin_model->getLanguage($priceListData->target) ?></td>
                            </tr>
                            <tr>
                                <td>File Attachment</td>
                                <td colspan="3">
                                    <?php if (strlen($task->file) > 1) { ?>
                                        <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/translationRequest/", $task->file, $task->start_after_type) ?>" target="_blank">Click Here</a>
                                    <?php } else {
                                        if ($task->start_after_id != null && $task->start_after_type == "Vendor") {
                                            ?>
                                            <?= $this->projects_model->getTaskVendorNotes($task->start_after_id) ?>
    <?php }
} ?>
                                </td>                                    
                            </tr>
                            <tr>
                                <td>Start Delivery</td>
                                <td><?= $task->start_date ?></td>
                                <td>Delivery Date</td>
                                <td><?= $task->delivery_date ?></td>
                            </tr>
                            <tr>
                                <td>Request Date</td>
                                <td><?= $task->created_at ?></td>
                                <td>Status</td>
                                <td><?= $this->projects_model->getTranslationTaskStatus($task->status) ?></td>
                            </tr>
                            <tr>
                                <td>Created By</td>
                                <td><?= $this->admin_model->getAdmin($task->status_by) ?></td>
                                <td>Task Started At</td>
                                <td><?= $task->created_at ?></td>
                            </tr>  
                            <tr>
                                <td>Instructions</td>
                                <td colspan="3"><?= $task->insrtuctions ?></td>
                            </tr> 
<?php if (strlen($jobData->job_file) > 1) { ?>
                                <tr>
                                    <td>Job Files</td>
                                    <td colspan="3"><a href="<?= base_url() ?>assets/uploads/jobFile/<?= $jobData->job_file ?>" target="_blank"><?= $jobData->job_file_name ?></a></td>
                                </tr>      
<?php } ?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->         
            <?php
            $id = base64_decode($_GET['t']);
            $numOfJobs = $this->db->query("SELECT * FROM translation_request_job WHERE request_id = '$id'")->num_rows();
            if ($numOfJobs == 0) {
                ?>
                <!--begin::Card-->
                <div class="card card-custom mt-5">
                    <div class="card-header">        
                        <div class="card-title btn_lightgray">
                            <h4 class="card-label">Update Request to Waiting Confirmation</h4>                               
                        </div>   
                        <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');"  class="btn btn-clean "><i class="fa fa-chevron-down"></i></button>

                    </div>
                    <div class="card-body" id="filter11" style="display:none;">
                        <!--begin::Form-->
                        <form class="form"action="<?php echo base_url() ?>translation/updateTranslationRequestToWattingConfirmation" method="post" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?= base64_encode($task->id) ?>" readonly="">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" >Action:</label>

                                    <div class="col-lg-6">
                                        <select name="status" class="form-control" id="status" required="">
                                            <option disabled="disabled" selected=""></option>
                                            <option value="1">Waiting Confirmation</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Card--> 
            <?php } ?> 
            <?php if ($this->projects_model->checkCloseTranslationRequest($task->id) && $task->status != 3) { ?> 
                <!--begin::Card-->
                <div class="card card-custom mt-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="card-label"> Request to Close Job</h4>
                        </div>
                        <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');"  class="btn btn-clean "><i class="fa fa-chevron-down"></i></button>
                    </div>
                    <div class="card-body" id="filter11" style="display:none;">
                        <!--begin::Form-->
                        <form class="form"action="<?php echo base_url() ?>translation/closeTranslationRequest" method="post" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?= base64_encode($task->id) ?>" readonly="">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" >Action:</label>

                                    <div class="col-lg-6">
                                        <select name="status" class="form-control" id="status" required="">
                                            <option disabled="disabled" selected=""></option>
                                            <option value="3">Closed</option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" >TM</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" value="<?= $task->tm ?>" name="tm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" >File Attachment:</label>

                                    <div class="col-lg-6">
                                        <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">

                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="comment">Comment:</label>

                                    <div class="col-lg-6">
                                        <textarea name="comment" class="form-control" value="" rows="6" ></textarea>

                                    </div>
                                </div> 

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Card--> 
            <?php }     ?>
            <!--begin::Card-->
            <div class="card mt-5">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h4 class="card-label">Task History</h4>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                            <tr>
                                <th>Status</th>
                                <th>File Link</th>
                                <th>Comment</th>
                                <th>Created At</th>
                                <th>Created By</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                                    <?php foreach ($history as $history) { ?>
                                <tr class="">
                                    <td><?= $this->projects_model->getTranslationTaskStatus($history->status) ?></td>
                                    <td>
    <?php if (strlen($history->file) > 0) { ?>
                                            <a href="<?= base_url() ?>assets/uploads/translationRequest/<?= $history->file ?>">Click Here ..</a>
    <?php } ?>
                                    </td>
                                    <td><?= $history->comment ?></td>
                                    <td><?= $history->created_at ?></td>
                                    <td><?= $this->admin_model->getAdmin($history->created_by) ?></td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card--> 

            <!--begin::Card-->
            <div class="card mt-5">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h4 class="card-label">Task Response</h4>
                    </div>

                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                            <tr>
                                <th>Username</th>
                                <th>Response</th>
                                <th>Created At</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($response as $response) { ?>
                                <tr class="">
                                    <td><?= $this->admin_model->getAdmin($response->created_by) ?></td>
                                    <td><?= $response->response ?></td>
                                    <td><?= $response->created_at ?></td>
                                </tr>
                    <?php } ?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
<?php if ($task->status != 3) { ?>

                        <!--begin::Form-->
                        <form class="form" id="commentForm" action="<?php echo base_url() ?>translation/requestRespone" method="post" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?= base64_encode($task->id) ?>" readonly="">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-right" for="comment">Comment:</label>

                                    <div class="col-lg-6">
                                        <textarea name="comment" class="form-control" value="" rows="6"></textarea> 
                                        <input type="text" class=" form-control" name="flag" value="1" hidden="" >
                                    </div>
                                </div> 

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
<?php } ?>

                </div>
            </div>
            <!--end::Card--> 
        </div>
    </div> 
</div>