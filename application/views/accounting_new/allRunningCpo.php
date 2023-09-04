<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Jobs</h3>
        </div>
        <?php
        if (!empty($_REQUEST['code'])) {
          $code = $_REQUEST['code'];
        } else {
          $code = "";
        }
        if (!empty($_REQUEST['product_line'])) {
          $product_line = $_REQUEST['product_line'];
        } else {
          $product_line = "";
        }
        if (!empty($_REQUEST['customer'])) {
          $customer = $_REQUEST['customer'];
        } else {
          $customer = "";
        }
        if (!empty($_REQUEST['service'])) {
          $service = $_REQUEST['service'];
        } else {
          $service = "";
        }
        if (!empty($_REQUEST['source'])) {
          $source = $_REQUEST['source'];
        } else {
          $source = "";
        }
        if (!empty($_REQUEST['target'])) {
          $target = $_REQUEST['target'];
        } else {
          $target = "";
        }
        if (!empty($_REQUEST['status'])) {
          $status = $_REQUEST['status'];
        } else {
          $status = "";
        }
        if (isset($_REQUEST['created_by'])) {
          $created_by = $_REQUEST['created_by'];
        } else {
          $created_by = "";
        }
        ?>
        <form class="form" id="cpofilter" action="<?php echo base_url() ?>accounting/allRunningCpo" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Job Code</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="code" value="<?= $code ?>">

              </div>



              <label class="col-lg-2 col-form-label text-lg-right">Client</label>
              <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" />
                <option value="" disabled="disabled" selected="selected">-- Select Client --</option>
                <?= $this->customer_model->selectCustomerByPm($customer, $this->user, $permission, $this->brand) ?>
                </select>
              </div>

            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Status</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status">
                  <option value="">-- Select Status --</option>
                  <option value="2" <?= isset($_REQUEST['status']) && $_REQUEST['status'] == 2 ? " selected" : "" ?>>
                    Running</option>
                  <option value="1" <?= isset($_REQUEST['status']) && $_REQUEST['status'] == 1 ? " selected" : "" ?>>
                    Delivered
                  </option>
                </select>
              </div>
              <label class="col-lg-2 col-form-label text-lg-right" for="role date">Po Status</label>

              <div class="col-lg-3">
                <select name="verified" class="form-control m-b" id="verified">
                  <option value="" selected="selected">-- Select Status --</option>
                  <option value="1" <?= $_REQUEST['verified'] == 1 ? " selected" : "" ?>>Verified</option>
                  <option value="3" <?= $_REQUEST['verified'] == 3 ? " selected" : "" ?>>Not Verified</option>
                  <option value="2" <?= $_REQUEST['verified'] == 2 ? " selected" : "" ?>>Has Error</option>

                </select>
              </div>

            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                  <button class="btn btn-success" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>accounting/allRunningCpo" class="btn btn-warning"><i
                      class="la la-trash"></i>Clear Filter</a>

                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('cpofilter'); e2.action='<?= base_url() ?>accounting/exportRunningCpo'; e2.submit();"
                    name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
                    Excel</button>

                </div>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- end search form -->

    <!--begin::Card-->
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <h3 class="card-label">All Jobs</h3>
        </div>

      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>Job Code</th>
              <th>Client Name</th>
              <th>Service</th>
              <th>Source</th>
              <th>Target</th>
              <th>Volume</th>
              <th>Rate</th>
              <th>Total Revenue</th>
              <th>Currency</th>
              <th>Status</th>
              <th>PO Number</th>
              <th>CPO File</th>
              <th>PO Status</th>
              <th>PO Status Date</th>
              <th>Has Error</th>
              <th>Start Date</th>
              <th>Delivery Date</th>
              <th>Closed Date</th>
              <th>Email Attachment</th>
              <th>Created By</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($job->result() as $row) {
              $priceList = $this->projects_model->getJobPriceListData($row->price_list);
              $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
              $poData = $this->projects_model->getJobPoData($row->po);
              ?>
              <tr>
                <td>
                  <?= $row->code ?>
                </td>

                <td>
                  <?php echo $this->customer_model->getCustomer($row->customer); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getServices($row->service); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->source); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->target); ?>
                </td>
                <?php if ($row->type == 1) { ?>
                  <td>
                    <?php echo $row->volume; ?>
                  </td>
                <?php } elseif ($row->type == 2) { ?>
                  <td>
                    <?php if ($row->rate > 0) {
                      echo ($total_revenue / $row->rate);
                    } else {
                      echo '';
                    } ?>
                  </td>
                <?php } ?>
                <td>
                  <?php echo $row->rate; ?>
                </td>
                <td>
                  <?= $total_revenue ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCurrency($row->currency); ?>
                </td>
                <td>
                  <?php echo $this->projects_model->getJobStatus($row->status); ?>
                </td>
                <td>
                  <?php if (isset($poData)) {
                    echo $poData->number;
                  } ?>
                </td>
                <td>
                  <?php
                  if (isset($poData)) { ?><a href="<?= base_url() ?>assets/uploads/cpo/<?= $poData->cpo_file ?>"
                      target="_blank">Click Here</a>
                  <?php } ?>
                </td>
                <td>
                  <?php if (isset($poData)) {
                    $this->accounting_model->getPOStatus($poData->verified);
                  } ?>
                </td>
                <?php if (isset($poData->verified_at)) { ?>
                  <td>
                    <?= $poData->verified_at ?>
                  </td>
                <?php } elseif (empty($poData->verified_at)) { ?>
                  <td> </td>
                <?php } ?>
                <td>
                  <?php if (isset($poData)) {
                    if ($poData->verified == 2) {
                      $errors = explode(",", $poData->has_error);
                      for ($i = 0; $i < count($errors); $i++) {
                        if ($i > 0) {
                          echo " - ";
                        }
                        echo $this->accounting_model->getError($errors[$i]);
                      }
                    }
                  } ?>
                </td>
                <td>
                  <?php echo $row->start_date; ?>
                </td>
                <td>
                  <?php echo $row->delivery_date; ?>
                </td>
                <?php if ($row->status == 0) { ?>
                  <td> </td>
                <?php } elseif ($row->status == 1) { ?>
                  <td>
                    <?php echo $row->closed_date; ?>
                  </td>
                <?php } ?>
                <td>
                  <?php if (strlen($row->attached_email ?? '') > 1 && $row->job_type == "1") { ?><a
                    href="<?= base_url() ?>assets/uploads/jobFile/<?= $row->attached_email ?>" target="_blank">Click
                    Here..</a>
                <?php } ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?php echo $row->created_at; ?>
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
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->