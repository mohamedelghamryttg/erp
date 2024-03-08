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
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search</h3>
        </div>
        <?php

        if (!empty($filter['t.code LIKE'])) {
          $code = $filter['t.code LIKE'];
        } else {
          $code = "";
        }
        if (!empty($filter['t.created_by ='])) {
          $created_by = $filter['t.created_by ='];
        } else {
          $created_by = "";
        }
        if (!empty($filter['t.vendor ='])) {
          $vendor = $filter['t.vendor ='];
        } else {
          $vendor = "";
        }
        if (isset($filter['t.status ='])) {
          $status = $filter['t.status ='];
        } else {
          $status = "";
        }
        if (!empty($filter['t.verified ='])) {
          $invoice_status = 1;
        } elseif (!empty($filter['t.verified <>'])) {
          $invoice_status = 2;
        } else {
          $invoice_status = "";
        }
        if (empty($payment_method)) {
          $payment_method = "";
        }
        if (!empty($filter['t.created_at >='])) {
          $date_from = date("m/d/Y", strtotime($filter['t.created_at >=']));
        } else {
          $date_from = "";
        }
        if (!empty($filter['t.created_at <='])) {
          $date_to = date("m/d/Y", strtotime($filter['t.created_at <=']));
        } else {
          $date_to = "";
        }
        // $vpo_status = ["Running", "Delivered", "Canceled"];
        $vpo_status = ["Running", "Delivered", "Cancelled", "Rejected", "Waiting Vendor Acceptance", "Waiting PM Confirmation", "Not Started Yet", "Heads Up", "Heads Up ( Marked as Available )", "Heads Up ( Marked as Not Available )"];

        ?>

        <form class="form" id="vpoStatus" method="post" action="<?php echo base_url() ?>accounting/vpoStatus" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">PO Number</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" name="code" autocomplete="off" value="<?php echo $code ?>">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">PM Name</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by">
                  <option value="">-- Select PM --</option>
                  <?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Vendor Name</label>
              <div class="col-lg-3">
                <select name="vendor" class="form-control m-b" id="vendor">
                  <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                  <?= $this->vendor_model->selectVendor($vendor, $this->brand) ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Vpo Status</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status">
                  <option disabled selected="selected">-- Select Status --</option>
                  <?php
                  for ($i = 0; $i < count($vpo_status); $i++) {
                    if ($status != "" && $status == $i) {
                      $selected = "selected";
                    } else {
                      $selected = "";
                    }
                    echo "<option value='" . $i . "' " . $selected . ">" . $vpo_status[$i] . "</option>";
                  }
                  ?>

                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Invoice Status</label>
              <div class="col-lg-3">
                <select name="invoice_status" class="form-control m-b" id="invoice_status">
                  <option disabled="disabled" selected="selected">-- Select Status --</option>
                  <?php if ($invoice_status == 1) { ?>
                    <option value="1" selected>Verified</option>
                    <option value="2">Not Verified</option>
                  <?php } elseif ($invoice_status == 2) { ?>
                    <option value="1">Verified</option>
                    <option value="2" selected>Not Verified</option>
                  <?php } else { ?>
                    <option value="1">Verified</option>
                    <option value="2">Not Verified</option>
                  <?php } ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Payment Status</label>
              <div class="col-lg-3">
                <select name="payment_status" class="form-control m-b" id="payment_status">
                  <option disabled="disabled" selected="selected">-- Select Status --</option>
                  <?php if ($payment_method == 1) { ?>
                    <option value="1" selected>Paid</option>
                    <option value="2">Not Paid</option>
                  <?php } elseif ($payment_method == 2) { ?>
                    <option value="1">Paid</option>
                    <option value="2" selected>Not Paid</option>
                  <?php } else { ?>
                    <option value="1">Paid</option>
                    <option value="2">Not Paid</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value=<?= $date_from ?>>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" value=<?= $date_to ?>>
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-primary" name="search" type="submit">Search</button>
                  <button class="btn btn-success" onclick="var e2 = document.getElementById('vpoStatus'); e2.action='<?= base_url() ?>accounting/exportvpoStatus'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
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
          <h3 class="card-label">All VPOs</h3>
        </div>

      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>PM Name</th>
              <th>P.O Number</th>
              <th>VPO Status</th>
              <th>CPO Verified</th>
              <th>CPO Verified Date</th>
              <th>VPO Date</th>
              <th>VPO File</th>
              <th>Vendor Name</th>
              <th>Source Language</th>
              <th>Target Language</th>
              <th>Task Type</th>
              <th>Count</th>
              <th>Unit</th>
              <th>Rate</th>
              <th>Currency</th>
              <th>P.O Amount</th>
              <th>Invoice Status</th>
              <th>Invoice Date</th>
              <th>Due Date (45 Days)</th>
              <th>Max Due Date (60 Days)</th>
              <th>Payment Status</th>
              <th>Payment Date</th>
              <th>Payment Method</th>
              <th>System</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($task)) {
              foreach ($task as $row) {
            ?>
                <tr>
                  <td>
                    <?php echo $row->user_name; ?>
                  </td>
                  <td>
                    <?= $row->code ?>
                  </td>
                  <td>
                    <?php echo $vpo_status[$row->status]; ?>
                  </td>
                  <td>
                    <?php if ($row->po_verified == 1) {
                      echo "Verified";
                    } else {
                      echo "";
                    } ?>
                  </td>
                  <td>
                    <?php if ($row->po_verified == 1) {
                      echo $row->po_verified_at;
                    } else {
                      echo "";
                    } ?>
                  </td>
                  <td>
                    <?php echo $row->closed_date; ?>
                  </td>
                  <td>
                    <?php if (strlen($row->vpo_file) > 1 && $row->job_portal == 1) { ?>
                      <a href="<?= $this->projects_model->getNexusLinkByBrand() ?>/assets/uploads/invoiceVendorFiles/<?= $row->vpo_file ?>" target="_blank">Click Here</a>
                    <?php } elseif (strlen($row->vpo_file) > 1 && $row->job_portal == 0) { ?>
                      <a href="<?= base_url() ?>assets/uploads/vpo/<?= $row->vpo_file ?>" target="_blank">Click Here</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php echo $row->vendor_name; ?>
                  </td>
                  <td>
                    <?php echo $row->source_lang; ?>
                  </td>
                  <td>
                    <?php echo $row->target_lang; ?>
                  </td>
                  <td>
                    <?php echo $row->task_type_name; ?>
                  </td>
                  <td>
                    <?php echo $row->count; ?>
                  </td>
                  <td>
                    <?php echo $row->unit_name; ?>
                  </td>
                  <td>
                    <?php echo $row->rate; ?>
                  </td>
                  <td>
                    <?php echo $row->currency_name; ?>
                  </td>
                  <td>
                    <?php echo $row->rate * $row->count; ?>
                  </td>
                  <td>
                    <?= $this->accounting_model->getPOStatus($row->verified) ?>
                  </td>
                  <td>
                    <?php echo $row->invoice_date; ?>
                  </td>
                  <td>
                    <?php if ($row->verified == 1) {
                      echo date("Y-m-d", strtotime($row->invoice_date . " +45 days"));
                    } ?>
                  </td>
                  <td>
                    <?php if ($row->verified == 1) {
                      echo date("Y-m-d", strtotime($row->invoice_date . " +60 days"));
                    } ?>
                  </td>
                  <td>
                    <?php if (!empty($row->payment_status) && $row->payment_status == 1) {
                      echo "Paid";
                    } else {
                      echo "Not Paid";
                    } ?>
                  </td>
                  <td>
                    <?php if (!empty($row->payment_date)) {
                      echo $row->payment_date;
                    } ?>
                  </td>
                  <td>
                    <?php if (!empty($row->payment_method_name)) {
                      echo $row->payment_method_name;
                    } ?>
                  </td>
                  <td>
                    <?php if ($row->job_portal == 1) { ?>
                      Nexus System
                    <?php } ?>
                  </td>
                </tr>
            <?php }
            } ?>

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
<!--end::Content-->