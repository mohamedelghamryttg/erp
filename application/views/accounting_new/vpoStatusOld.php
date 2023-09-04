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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search</h3>
        </div>

        <form class="form" id="vpoStatus" method="post" action="<?php echo base_url() ?>accounting/vpoStatus"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">PO Number</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" name="code" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">PM Name</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by" />
                <option value="">-- Select PM --</option>
                <?= $this->admin_model->selectAllPm('', $this->brand) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Vendor Name</label>
              <div class="col-lg-3">
                <select name="vendor" class="form-control m-b" id="vendor" />
                <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                <?= $this->vendor_model->selectVendor(0, $brand) ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Vpo Status</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status" />
                <option disabled="disabled" selected="selected">-- Select Status --</option>
                <option value="3">Running</option>
                <option value="1">Delivered</option>
                <option value="2">Canceled</option>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Invoice Status</label>
              <div class="col-lg-3">
                <select name="invoice_status" class="form-control m-b" id="invoice_status" />
                <option disabled="disabled" selected="selected">-- Select Status --</option>
                <option value="1">Verified</option>
                <option value="2">Not Verified</option>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Payment Status</label>
              <div class="col-lg-3">
                <select name="payment_status" class="form-control m-b" id="payment_status" />
                <option disabled="disabled" selected="selected">-- Select Status --</option>
                <option value="1">Paid</option>
                <option value="2">Not Paid</option>
                </select>
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-primary" name="search" type="submit">Search</button>
                  <button class="btn btn-success"
                    onclick="var e2 = document.getElementById('vpoStatus'); e2.action='<?= base_url() ?>accounting/exportvpoStatus'; e2.submit();"
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
            </tr>
          </thead>
          <tbody>
            <?php if (isset($task)) {
              foreach ($task->result() as $row) {
                $job = $this->db->get_where('job', array('id' => $row->job_id))->row();
                $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                $po = $this->db->get_where('po', array('id' => $job->po))->row()
                  ?>
                <tr>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td><?= $row->code ?></td>
                  <td>
                    <?php echo $this->projects_model->getJobStatus($row->status); ?>
                  </td>
                  <td>
                    <?php if ($po->verified == 1) {
                      echo "Verified";
                    } else {
                      echo "";
                    } ?>
                  </td>
                  <td>
                    <?php if ($po->verified == 1) {
                      echo $po->verified_at;
                    } else {
                      echo "";
                    } ?>
                  </td>
                  <td>
                    <?php echo $row->closed_date; ?>
                  </td>
                  <td>
                    <?php echo $this->vendor_model->getVendorName($row->vendor); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getLanguage($priceList->source); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getLanguage($priceList->target); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getTaskType($row->task_type); ?>
                  </td>
                  <td>
                    <?php echo $row->count; ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getUnit($row->unit); ?>
                  </td>
                  <td>
                    <?php echo $row->rate; ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getCurrency($row->currency); ?>
                  </td>
                  <td>
                    <?php echo $row->rate * $row->count; ?>
                  </td>
                  <td><?= $this->accounting_model->getPOStatus($row->verified) ?></td>
                  <td>
                    <?php echo $row->verified_at; ?>
                  </td>
                  <td>
                    <?php if ($row->verified == 1) {
                      echo date("Y-m-d", strtotime($row->verified_at . " +45 days"));
                    } ?>
                  </td>
                  <td>
                    <?php if ($row->verified == 1) {
                      echo date("Y-m-d", strtotime($row->verified_at . " +60 days"));
                    } ?>
                  </td>
                  <td>
                    <?php if ($row->payment_status == 1) {
                      echo "Paid";
                    } else {
                      echo "Not Paid";
                    } ?>
                  </td>
                  <td><?= $row->payment_date ?></td>
                  <td><?= $this->accounting_model->getPaymentMethod($row->payment_method) ?></td>
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
</div>
<!--end::Content-->