<style>
    .dataTables_scrollHeadInner{
        width:100%!important;
    }
    .btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled), .btn.btn-clean:focus:not(.btn-text), .btn.btn-clean.focus:not(.btn-text) {
        background-color: transparent!important;
        border-color: transparent;
    }
    .label-rounded{
        width:40px!important;
    }
</style>
<!--begin::Card-->
<div class="container-fluid"> 
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h3 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">LE</h3>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">Requests</a>
                        </li>											
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->          
        </div>
    </div>
    <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success mt-2" role="alert">
            <span class="fa fa-check-circle"></span>
            <span><strong><?= $this->session->flashdata('true') ?></strong></span>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger mt-2" role="alert">
            <span class="fa fa-warning"></span>
            <span><strong><?= $this->session->flashdata('error') ?></strong></span>
        </div>
    <?php } ?>
    <div class="card card-custom gutter-b">
        <!--begin::Body-->
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap py-3">
            <!--begin::Info-->
            <div class="d-flex align-items-center mr-2 py-2">               
                <!--begin::Navigation-->
                <div class="d-flex mr-3">
                    <!--begin::Navi-->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-1" data-toggle="tab" href="#card-1">                           
                                <span class="nav-text">All Requests <span class="label label-rounded label-light-danger font-weight-bolder "><?= $total_rows ?></span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2" data-toggle="tab" href="#card-2">    
                                <span class="nav-text">LE Requests Waiting Confimation <span class="label label-rounded label-light-danger font-weight-bolder "><?= $newTasks->num_rows() ?></span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-3" data-toggle="tab" href="#card-3">    
                                <span class="nav-text">Heads Up Requests Waiting Confimation <span class="label label-rounded label-light-danger font-weight-bolder "> <?= $tasksPlan->num_rows() ?></span></span>
                            </a>
                        </li>

                    </ul>
                    <!--end::Navi-->               
                </div>
                <!--end::Navigation-->
            </div>
            <!--end::Info-->      
        </div>
        <!--end::Body-->
    </div>
    <div class="tab-content mt-5" id="myTabContent2">
        <div class="tab-pane fade show active" id="card-1" role="tabpanel" aria-labelledby="home-tab-2">           
            <!-- start search form card --> 
            <div class="card"> 
                <div class="card card-custom gutter-b m-5">
                    <div class="card-header">
                        <div class="card-title btn_lightgray">
                            <h3 class="card-label">Filter
                            </h3> 
                        </div>
                        <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');" class="btn btn-clean "><i class="fa <?= (isset($_GET['search'])) ? 'fa-chevron-up' : 'fa-chevron-down' ?>"></i></button>

                    </div>
                    <div class="card-body" id="filter11" style="<?= (isset($_GET['search'])) ? 'display:block' : 'display:none' ?>">

                        <?php
                        if (!empty($_REQUEST['code'])) {
                            $code = $_REQUEST['code'];
                        } else {
                            $code = "";
                        }

                        if (!empty($_REQUEST['pm'])) {
                            $pm = $_REQUEST['pm'];
                        } else {
                            $pm = "";
                        }

                        if (!empty($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                        } else {
                            $date_to = "";
                            $date_from = "";
                        }
                        ?>
                        <form class="form" id="leRequestForm" action="<?php echo base_url() ?>le/" method="get" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label class="col-lg-2 control-label text-lg-right" for="role name">Request Code:</label>
                                <div class="col-lg-3">
                                    <input class="form-control " type="text" name="code" value="<?= $code ?>"> 
                                </div>
                                <label class="col-lg-2 control-label text-lg-right" for="role name">Requestor Name:</label>
                                <div class="col-lg-3">
                                    <select name="pm" class="form-control m-b" id="pm"/>
                                    <option value="" disabled="disabled" selected="selected">-- Select Requestor --</option>
                                    <?= $this->admin_model->selectAllPm($pm, $this->brand) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 control-label text-lg-right" for="role date">Date From :</label>
                                <div class="col-lg-3">
                                    <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off"> 
                                </div>
                                <label class="col-lg-2 control-label text-lg-right" for="role date">Date To :</label>
                                <div class="col-lg-3">
                                    <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-10">
                                        <button class="btn btn-primary" name="search" type="submit">Search</button>
                                        <button class="btn btn-success" onclick="var e2 = document.getElementById('leRequestForm'); e2.action = '<?= base_url() ?>le/exportRequests'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                                        <a href="<?= base_url() ?>le" class="btn btn-warning">(x) Clear Filter</a>



                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- end search form -->
                </div>

                <!--begin::Card-->
                <div class="card card-custom gutter-b m-5">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">All Requests | <span class="text-dark-50 font-weight-bold" style="font-size: 14px !important;"><?= $total_rows ?></span></h3>
                        </div>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                            <thead>
                                <tr>
                                    <th>Task Code</th>
                                    <th>Task Name</th>
                                    <th>Task Type</th>
                                    <th>Linguist Format</th>
                                    <th>Deliverable Format</th>
                                    <th>Unit</th>
                                    <th>Volume</th>
                                    <th>Complexicty</th>
                                    <th>Rate</th>
                                    <th>Source Language</th>
                                    <th>Target Language</th>
                                    <th>Task File</th>
                                    <th>Status</th>
                                    <th>Requested By</th>
                                    <th>View Jobs</th>
                                    <th>View Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($le_request->result() as $row) {
                                    if ($row->job_id == 0) {
                                        $product_line = $row->product_line;
                                        $source_language = $row->source_language;
                                        $target_language = $row->target_language;
                                    } else {
                                        $jobData = $this->projects_model->getJobData($row->job_id);
                                        $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                                        $product_line = $priceListData->product_line;
                                        $source_language = $priceListData->source;
                                        $target_language = $priceListData->target;
                                    }
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo base_url() ?>le/leJobs?t=<?php echo base64_encode($row->id); ?>" class="">LE-<?= $row->id ?></a></td>
                                        <td><abbr title="<?= $row->subject ?>"><?= character_limiter($row->subject, 10) ?></abbr></td>
                                        <td><?php echo $this->admin_model->getLETaskType($row->task_type); ?></td>

                                        <?php if (is_numeric($row->linguist) && is_numeric($row->deliverable)) { ?>
                                            <td><?php echo $this->admin_model->getLeFormat($row->linguist); ?></td>
                                            <td><abbr title="<?= $row->deliverable ?>"><?php echo character_limiter($this->admin_model->getLeFormat($row->deliverable), 10); ?></abbr></td>
                                        <?php } else { ?>
                                            <td><?= $row->linguist ?></td>
                                            <td><abbr title="<?= $row->deliverable ?>"><?= character_limiter($row->deliverable, 10) ?></abbr></td>
                                        <?php } ?>  
                                        <td><?php echo $this->admin_model->getUnit($row->unit); ?></td>
                                        <td><?= $row->volume ?></td>
                                        <td><?= $this->projects_model->getLeComplexicty($row->complexicty); ?></td>   <td><?= $row->rate ?></td>

                                        <td><?php echo $this->admin_model->getLanguage($source_language); ?></td>
                                        <td><?php echo $this->admin_model->getLanguage($target_language); ?></td>
                                        <td><?php if (strlen($row->file) > 1) { ?>
                                                <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/leRequest/", $row->file, $row->start_after_type) ?>" target="_blank">Click Here</a>
                                            <?php
                                            } else {
                                                if ($row->start_after_id != null && $row->start_after_type == "Vendor") {
                                                    ?>
                                                    <?= $this->projects_model->getTaskVendorNotes($row->start_after_id) ?>
                                                <?php }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $this->projects_model->getTranslationTaskStatus($row->status); ?></td>
                                        <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                        <td>
                                            <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>le/leJobs?t=<?php
                                           echo
                                           base64_encode($row->id);
                                                ?>" class="">
                                                    <i class="fa fa-eye"></i> View Jobs
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                               <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>le/viewRequest?t=<?php
                                           echo
                                           base64_encode($row->id);
                                           ?>" class="">
                                                    <i class="fa fa-eye"></i> View Request
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
        </div>
        <div class="tab-pane fade" id="card-2" role="tabpanel" aria-labelledby="profile-tab-2">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title btn_lightgray">
                        <h4 class="card-label">LE Requests Waiting Confimation | <span class="text-dark-50 font-weight-bold" style="font-size: 14px !important;"><?= $newTasks->num_rows() ?></span>

                        </h4>
                    </div>                
                </div>
                <div class="card-body" >
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                                <th>PM</th>
                                <th>Task Type</th>
                                <th>Product line</th>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Created Date</th>
                                <th>View Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($newTasks->result() as $row) {
                                if ($row->job_id == 0) {
                                    $product_line = $row->product_line;
                                } else {
                                    $jobData = $this->projects_model->getJobData($row->job_id);
                                    $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                                    $product_line = $priceListData->product_line;
                                }
                                ?>
                                <tr>
                                    <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>
                                    <td><?= $this->admin_model->getLETaskType($row->task_type) ?></td>
                                    <td><?php echo $this->customer_model->getProductLine($product_line); ?></td>
                                    <td><?= $row->subject ?></td>
                                    <td><?= $row->start_date ?></td>
                                    <td><?= $row->delivery_date ?></td>
                                    <td><?= $row->created_at ?></td>
                                    <td>
    <?php if ($permission->add == 1) { ?>
                                            <a href="<?php echo base_url() ?>le/saveRequest?t=<?php
                                            echo
                                            base64_encode($row->id);
                                            ?>" class="">
                                                <i class="fa fa-eye"></i> View Task
                                            </a>
    <?php } ?>
                                    </td>
                                </tr>
<?php } ?>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <div class="tab-pane fade" id="card-3" role="tabpanel" aria-labelledby="contact-tab-2">
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title btn_lightgray">
                        <h4 class="card-label">LE "Heads Up" Requests Waiting Confimation | <span class="text-dark-50 font-weight-bold" style="font-size: 14px !important;"><?= $tasksPlan->num_rows() ?></span>

                        </h4> 
                    </div>
                    <div class="card-toolbar">


                    </div>
                </div>
                <div class="card-body" >
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover"id="kt_datatable2">
                        <thead>
                            <tr>
                                <th>PM</th>
                                <th>Task Type</th>
                                <th>Product line</th>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Created Date</th>
                                <th>View Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tasksPlan->result() as $row) {
                                if ($row->job_id == 0) {
                                    $product_line = $row->product_line;
                                } else {
                                    $jobData = $this->projects_model->getJobData($row->job_id);
                                    $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                                    $product_line = $priceListData->product_line;
                                }
                                ?>
                                <tr>
                                    <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>
                                    <td><?= $this->admin_model->getLETaskType($row->task_type) ?></td>
                                    <td><?php echo $this->customer_model->getProductLine($product_line); ?></td>
                                    <td><?= $row->subject ?></td>
                                    <td><?= $row->start_date ?></td>
                                    <td><?= $row->delivery_date ?></td>
                                    <td><?= $row->created_at ?></td>
                                    <td>
                                        <?php if ($permission->add == 1) { ?>
                                            <a href="<?php echo base_url() ?>le/saveRequestPlan?t=<?php
                                    echo
                                    base64_encode($row->id);
                                            ?>" class="">
                                                <i class="fa fa-eye"></i> View Task
                                            </a>
    <?php } ?>
                                    </td>
                                </tr>
<?php } ?>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>

</div>
