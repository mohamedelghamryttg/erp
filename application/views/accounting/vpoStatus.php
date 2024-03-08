<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        VPO Filter
      </header>

      <div class="panel-body">
        <form class="cmxform form-horizontal " id="vpoStatus" action="<?php echo base_url() ?>accounting/vpoStatus" method="post" enctype="multipart/form-data">
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">PO Number</label>

            <div class="col-lg-3">

              <input class="form-control" type="text" name="code" autocomplete="off">
            </div>

          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="role Task Type">PM Name</label>
            <div class="col-lg-3">
              <select name="created_by" class="form-control m-b" id="created_by" />
              <option value="">-- Select PM --</option>
              <?= $this->admin_model->selectAllPm('', $this->brand) ?>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role name">Vendor Name</label>
            <div class="col-lg-3">
              <select name="vendor" class="form-control m-b" id="vendor" />
              <option disabled="disabled" selected="selected">-- Select Vendor --</option>
              <?= $this->vendor_model->selectVendor(0, $brand) ?>
              </select>
            </div>
          </div>
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Vpo Status</label>

            <div class="col-lg-3">

              <select name="status" class="form-control m-b" id="status" />
              <option disabled="disabled" selected="selected">-- Select Status --</option>
              <option value="3">Running</option>
              <option value="1">Delivered</option>
              <option value="2">Canceled</option>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role date">Invoice Status</label>

            <div class="col-lg-3">
              <select name="invoice_status" class="form-control m-b" id="invoice_status" />
              <option disabled="disabled" selected="selected">-- Select Status --</option>
              <option value="1">Verified</option>
              <option value="2">Not Verified</option>
              </select>
            </div>

          </div>
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Payment Status</label>

            <div class="col-lg-3">

              <select name="payment_status" class="form-control m-b" id="payment_status" />
              <option disabled="disabled" selected="selected">-- Select Status --</option>
              <option value="1">Paid</option>
              <option value="2">Not Paid</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button>
              <button class="btn btn-success" onclick="var e2 = document.getElementById('vpoStatus'); e2.action='<?= base_url() ?>accounting/exportvpoStatus'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        All VPOs
      </header>

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

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
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
                <th></th>
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
          <nav class="text-center">
            <?= $this->pagination->create_links() ?>
          </nav>
        </div>
      </div>
    </section>
  </div>
</div>