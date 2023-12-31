<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Job
            </header>

            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>projectManagment/doAddJob" method="post" onsubmit="return checkPriceListForm();disableAddButton();" enctype="multipart/form-data">
                        <input type="text" name="project_id" value="<?= base64_encode($project) ?>" hidden="">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role Project Data">Project Data</label>

                            <div class="col-lg-6">
                                <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Project Name</th>
                                            <th>Project Code</th>
                                            <th>Product Line</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $this->customer_model->getCustomer($project_data->customer) ?></td>
                                            <td><?= $project_data->name ?></td>
                                            <td><?= $project_data->code ?></td>
                                            <td><?= $this->customer_model->getProductLine($project_data->product_line) ?><input type="text" name="product_line" id="product_line" value="<?= $project_data->product_line ?>" hidden=""></td>
                                            <input type="text" name="lead" id="lead" value="<?= $project_data->lead ?>" hidden="">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="project name">Job Name</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value="<?= $project_data->name ?>" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="project name">Job Type</label>

                            <div class="col-lg-6">
                                <select name="job_type" class="form-control m-b" id="job_type" required onchange="getJobTypeInputs()">
                                    <option value="" disabled="" selected=''>-- Select Type --</option>
                                    <option value="0">Real Job</option>
                                    <option value="1">Free Job</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="attachedEmail" style='display: none'>
                            <label class="col-lg-3 control-label" for="role File Attachment">Email Attachment
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="This file is required as it's free job"></i>
                            </label>

                            <div class="col-lg-6">
                                <input type="file" class=" form-control" name="attached_email" id="attached_email" accept="'application/zip'" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role Services">Services</label>

                            <div class="col-lg-6">
                                <select name="service" onchange="getPriceListByService()" class="form-control m-b" id="service" required />
                                <option disabled="disabled" value="" selected=""></option>
                                <?= $this->admin_model->selectServices() ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12" id="PriceList" style="overflow: scroll;max-height: 300px;">
                                <?= $this->sales_model->getPriceListByLead($project_data->lead, 0, $project_data->product_line) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role name"></label>
                            <div class="col-lg-6" id="fuzzy">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Total Revenue</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" readonly="readonly" name="total_revenue" id="total_revenue" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-3"> Start Date</label>
                            <div class="col-lg-6">
                                <input class="form_datetime form-control" type="text" value="<?= date("Y-m-d H:i:s") ?>" name="start_date" autocomplete="off" onchange="checkDate('start_date')" id="start_date" required="">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-3"> Delivery Date</label>
                            <div class="col-lg-6">
                                <input class="form_datetime form-control" type="text" name="delivery_date" autocomplete="off" onchange="checkDate('delivery_date')" id="delivery_date" required="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role File Attachment">File Attachment
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="This file will be shown in every task in this job"></i>
                            </label>

                            <div class="col-lg-6">
                                <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                            </div>
                        </div>
                        <div class="form-group" id="add_clientPm">
                            <label class="col-lg-3 control-label">Client PM</label>
                            <div class="col-lg-6">
                                <select name="client_pm_id" class="form-control m-b" id="client_pm" required>
                                    <option disabled="disabled" value="" selected=""></option>
                                    <?= $this->projects_model->selectClientPM($project_data->customer) ?>
                                </select>
                            </div>
                            <a class="btn btn-dark btn-sm font-weight-bolder text-white" data-toggle="modal" data-target="#addModal">
                                <i class="fa fa-plus-circle"></i> add
                            </a>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                <a href="<?php echo base_url() ?>ProjectManagment/projectJobs?t=<?= base64_encode($project) ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal-->
    <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="cmxform form-horizontal " id="savePM" action="<?= base_url() ?>projectManagment/doAddClientPm" method="post" enctype="multipart/form-data">

                    <div class="modal-body">
                        <input type="hidden" name="job" value="1">
                        <input type="hidden" name="customer" class="form-control m-b" id="customer" value="<?= $project_data->customer ?>">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Name</label>
                            <div class="col-lg-9">
                                <input type="text" class=" form-control" name="name" id="name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Email</label>
                            <div class="col-lg-9">
                                <input type="email" class=" form-control" name="email" id="email" autocomplete="off" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                        <button type="button" class="close_btn btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end Modal-->
</div>

<script>
    $(document).on("submit", "#savePM", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status == "success") {
                    alert('The data has been added successfully');
                    $("#client_pm").append('<option value="' + data.id + '">' + data.text + '</option>');
                    $("#client_pm").val(data.id);
                    $("#client_pm").trigger('change');
                } else {
                    alert('Error, This Email Already Exists...');
                }
                $("#addModal").modal('hide');
                $('.close').trigger("click");
                $('#savePM').trigger("reset");
            }
        });


    });
</script>