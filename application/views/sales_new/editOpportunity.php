<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Opportunity</h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>sales/doEditOpportunity" method="post"
                enctype="multipart/form-data">
                <input type="text" name="id" hidden="" value="<?= base64_encode($id) ?>">
                <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                    <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
                <?php } else { ?>
                    <input type="text" name="referer" value="<?= base_url() ?>sales/opportunity" hidden>
                <?php } ?>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" value="<?= $row->project_name ?>"
                                name="project_name" id="project_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Customer</label>
                        <div class="col-lg-6">
                            <select name="customer" class="form-control m-b" id="customer"
                                onchange="CustomerData();getProductLineByLead();" required />
                            <option value="" selected="selected">-- Select Customer --</option>
                            <?= $this->customer_model->selectExistingCustomerBySam($row->customer, $sam, $permission, $brand) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right"></label>
                        <div class="col-lg-6" id="LeadData">
                            <?= $this->customer_model->getLeadData($row->lead, $row->customer, $sam) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Contact Method</label>
                        <div class="col-lg-6">
                            <select name="contact_method" class="form-control m-b" id="contact_method"
                                onchange="getContacts()" required />
                            <option value="" selected="selected">-- Contact Method --</option>
                            <?= $this->sales_model->selectContactMethod($row->contact_method) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right"></label>
                        <div class="col-lg-6" id="customerContact">
                            <?= $this->customer_model->getCustomerContact($row->lead, $row->contact_id) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Status Of Project</label>
                        <div class="col-lg-6">
                            <select name="project_status" class="form-control m-b" id="project_status" required />
                            <option value="" selected="selected">-- Status Of Project --</option>
                            <?= $this->sales_model->SelectProjectStatus($row->project_status) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Product Lines</label>
                        <div class="col-lg-6">
                            <select name="product_line" class="form-control m-b" id="product_line"
                                onchange="getAssignedPM()" required />
                            <option disabled="disabled" selected="selected">-- Select Product Line --</option>
                            <?= $this->customer_model->selectProductLine($row->product_line, $brand) ?>
                            </select>
                        </div>
                    </div>

                </div>

                <?php if ($row->saved == 2) { ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Reject Reason</label>
                        <div class="col-lg-6">
                            <p style="font-size: 18px;color: red;">
                                <?= $row->reject_reason ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Assign PM</label>
                    <div class="col-lg-6">
                        <select name="pm" class="form-control m-b" id="pm" required>
                            <?= $this->customer_model->getAssignedPM($row->lead, $row->pm); ?>
                        </select>
                    </div>
                </div>
                <?php if ($this->brand == 1) { ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">TTG Branch Name</label>
                        <div class="col-lg-6">
                            <select name="branch_name" class="form-control m-b" />
                            <option disabled="disabled" selected="selected">-- Select Branch Name --</option>
                            <?= $this->projects_model->selectTTGBranchName($row->branch_name) ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a class="btn btn-secondary" href="<?php echo base_url() ?>sales/opportunity"
                        class="btn btn-default" type="button">Cancel</a>
                </div>
            </div>
        </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
</div>