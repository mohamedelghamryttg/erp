<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        VPO Filter
      </header>

      <div class="panel-body">
        <form class="cmxform form-horizontal " id="vpoForm" action="<?php echo base_url() ?>accounting/vendorPayments"
          method="get" enctype="multipart/form-data">

          <div class="form-group">
            <?php
            if (isset($_REQUEST['code'])) {
              $code = $_REQUEST['code'];
            } else {
              $code = "";
            }
            if (isset($_REQUEST['vendor'])) {
              $vendor = $_REQUEST['vendor'];
            } else {
              $vendor = "";
            }
            ?>
            <label class="col-lg-2 control-label" for="role date">PO Number</label>

            <div class="col-lg-3">

              <input class="form-control" type="text" value="<?= $code ?>" name="code" autocomplete="off">
            </div>
            <label class="col-lg-2 control-label" for="role name">Vendor Name</label>
            <div class="col-lg-3">
              <select name="vendor" class="form-control m-b" id="vendor" />
              <option disabled="disabled" selected="selected">-- Select Vendor --</option>
              <?= $this->vendor_model->selectVendor($vendor, $brand) ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button>
              <!-- <button class="btn btn-success" onclick="var e2 = document.getElementById('vpoForm'); e2.action='<?= base_url() ?>accounting/exportRunningVPOs'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> -->
              <a href="<?= base_url() ?>accounting/vendorPayments" class="btn btn-warning">(x) Clear Filter</a>
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
        Vendor Payments List
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
      <div class="panel-body" style="overflow:scroll;">
        <div class="adv-table editable-table ">
          <div class="clearfix">
            <div class="btn-group">
              <?php if ($permission->add == 1) { ?>
                <a href="<?= base_url() ?>accounting/addVendorPayment" class="btn btn-primary ">Add New Payment</a>
                </br></br></br>
              <?php } ?>

            </div>

          </div>
          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>#</th>
                <th>Task Code</th>
                <th>Vendor</th>
                <th>Vendor Email</th>
                <th>Contacts</th>
                <th>Rate</th>
                <th>Volume</th>
                <th>Unit</th>
                <th>Total</th>
                <th>Currency</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($payment->result() as $row) {
                $vendor = $this->db->get_where('vendor', array('id' => $row->vendor))->row();
                ?>
                <tr>
                  <td><?= $row->id ?></td>
                  <td><?= $row->code ?></td>
                  <td>
                    <?php echo $this->vendor_model->getVendorName($row->vendor); ?>
                  </td>
                  <td><?= $vendor->email ?></td>
                  <td><?= $vendor->contact ?></td>
                  <td><?= $row->rate ?></td>
                  <td><?= $row->count ?></td>
                  <td><?= $this->admin_model->getUnit($row->unit) ?></td>
                  <td><?= $row->rate * $row->count ?></td>
                  <td><?= $this->admin_model->getCurrency($row->currency) ?></td>
                  <td><?= $this->accounting_model->getPaymentMethod($row->payment_method) ?></td>
                  <td>
                    <?php echo $row->payment_date; ?>
                  </td>
                  <td>
                    <?php if ($row->status == 1) {
                      echo "Paid";
                    } elseif ($row->status == 2) {
                      echo "Re-opened";
                    } ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td>
                    <?php echo $row->created_at; ?>
                  </td>
                  <td>
                    <?php if ($permission->edit == 1) { ?>
                      <a href="<?= base_url() ?>accounting/editVendorPayment?t=<?= base64_encode($row->id) ?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($permission->delete == 1) { ?>
                      <!-- <a href="#" title="delete" 
                  class="" onclick="return confirm('Are you sure you want to delete this Payment ?');">
                    <i class="fa fa-times text-danger text"></i> Delete
                  </a> -->
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
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