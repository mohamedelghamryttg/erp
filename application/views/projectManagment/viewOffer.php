<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>
<style>
    .custom {
        font-weight: 700 !important;
        /*color: #B5B5C3 !important;*/
        text-transform: uppercase;
        letter-spacing: 0.1rem;
    }

    .sendMSG {
        max-height: 40px;
        padding: 7px;
        margin: 15px;
        max-width: 20%;
    }

    input[type="radio"] {
        width: 1.5em;
        height: 1.5rem;
        accent-color: green;
        margin-right: 2px;
    }

    #radioReject {
        accent-color: red;
    }

    .timeline.custom-timeline .timeline-items .timeline-item .timeline-content:before {
        left: -35px;
    }
</style>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong><?= $this->session->flashdata('true') ?></strong></span>
            </div>
        <?php  } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong><?= $this->session->flashdata('error') ?></strong></span>
            </div>
        <?php  } ?>
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Task Info</h3>

            </div>
            <!--begin::Form-->
            <!--begin::Header-->
            <div class="card-header card-header-tabs-line">
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                        <li class="nav-item mr-3">
                            <a class="nav-link active" data-toggle="tab" href="#kt_apps_projects_view_tab_1">
                                <span class="nav-icon mr-2">
                                    <span class="svg-icon mr-3">
                                        <i class="fa fa-info"></i>
                                    </span>
                                </span>
                                <span class="nav-text font-weight-bold">Info</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_2">
                                <span class="nav-icon mr-2">
                                    <span class="svg-icon mr-3">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-weight-bold">Instruction</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_5">
                                <span class="nav-icon mr-2">
                                    <span class="svg-icon mr-3">
                                        <i class="fa fa-list-alt"></i>
                                    </span>
                                </span>
                                <span class="nav-text font-weight-bold">Vendor List</span>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="card-body">
                <div class="tab-content pt-5">
                    <!--begin::Tab Content-->
                    <div class="tab-pane active" id="kt_apps_projects_view_tab_1" role="tabpanel">
                        <div class="task_info">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                                        <thead>
                                            <tr>
                                                <th>Job Code</th>
                                                <th>Product Line</th>
                                                <th>Service</th>
                                                <th>Source</th>
                                                <th>Target</th>
                                                <th>Volume</th>
                                                <th>Rate</th>
                                                <th>Total Revenue</th>
                                                <th>Currency</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr class="">
                                                <td><?= $job_data->code ?></td>
                                                <td><?php echo $this->customer_model->getProductLine($priceList->product_line); ?></td>
                                                <td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                                                <td><?php echo $job_data->volume; ?></td>
                                                <td><?php echo $priceList->rate; ?></td>
                                                <td><?= $this->sales_model->calculateRevenueJob($job_data->id, $job_data->type, $job_data->volume, $priceList->id) ?></td>
                                                <td><?php echo $this->admin_model->getCurrency($priceList->currency); ?></td>
                                                <td><?php echo $this->admin_model->getAdmin($job_data->created_by); ?></td>
                                                <td><?php echo $job_data->created_at; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Mail Subject : </label>
                                <div class="col-lg-6 pt-2">
                                    <p><?= $row->subject ?> </p>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Task Type :</label>
                                <div class="col-lg-6 pt-2">
                                    <p> <?= $this->admin_model->getTaskType($row->task_type) ?> </p>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Rate : </label>
                                <div class="col-lg-6 pt-2">

                                    <?= $row->rate ?> <?= $this->admin_model->getCurrency($row->currency) ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Volume :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $row->count ?> <?= $this->admin_model->getUnit($row->unit) ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Start Date :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $row->start_date ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Delivery Date :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $row->delivery_date ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Time Zone :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $this->admin_model->getTimeZone($row->time_zone) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Task File :</label>
                                <div class="col-lg-6 pt-2">
                                    <?php if (strlen($row->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/taskFile/<?= $row->file ?>" target="_blank">Click Here</a><?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="kt_apps_projects_view_tab_2" role="tabpanel">
                        <form class="form">
                            <div class="form-group">
                                <?= $row->insrtuctions ?>
                            </div>
                        </form>
                    </div>
                    <!--end::Tab Content-->

                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="kt_apps_projects_view_tab_5" role="tabpanel">
                        <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;max-width: 75%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor Name </th>
                                    <th>Email</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($vendor_list as $k => $val) {
                                    $vendor = $this->vendor_model->getVendorData($val);
                                    if ($k + 1 == count($vendor_list))
                                        continue; ?>
                                    <tr>
                                        <td><?= ++$k ?></td>
                                        <td><?= $vendor->name ?></td>
                                        <td><?= $vendor->email ?></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <!--end::Tab Content-->
                </div>
            </div>
        </div>
        <!--end::Card-->

    </div>
</div>