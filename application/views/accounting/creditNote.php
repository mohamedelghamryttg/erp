<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        Credit Notes Filter
      </header>

      <div class="panel-body">
        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>accounting/creditNote" id="poList" method="get" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="role name">Client</label>

            <div class="col-lg-3">
              <select name="customer" class="form-control m-b" id="customer" />
              <option disabled="disabled" selected="selected">-- Select Client --</option>
              <?= $this->customer_model->selectCustomerBranches(0, $brand) ?>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role name">PO Number</label>

            <div class="col-lg-3">
              <input type="text" class="form-control" name="po">
            </div>
          </div>

          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

              <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
              <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
            </div>

          </div>
      </div>
      <div class="form-group">
        <div class="col-lg-offset-3 col-lg-6">
          <button class="btn btn-primary" name="search" type="submit">Search</button>
          <button class="btn btn-success" onclick="var e2 = document.getElementById('poList'); e2.action='<?= base_url() ?>accounting/exportcreditNote'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
          <a href="<?= base_url() ?>accounting/creditNote" class="btn btn-warning">(x) Clear Filter</a>

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
        Credit Notes List
      </header>
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
      <div class="panel-body" style="overflow:scroll;">
        <div class="adv-table editable-table ">
          <div class="clearfix">
            <div class="btn-group">
              <?php if ($permission->add == 1) { ?>
                <a href="<?= base_url() ?>accounting/addcreditNote" class="btn btn-primary ">Add New Credit Note</a>
                </br></br></br>
              <?php } ?>

            </div>

          </div>
          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>ID</th>
                <th>Credit Note Type</th>
                <th>Customer</th>
                <th>Issue_date</th>
                <th>PM Name</th>
                <th>PO Number</th>
                <th>Invoice Number</th>
                <th>POs</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Attachment File</th>
                <th>Status</th>
                <th>Approved/Reject By</th>
                <th>Approved/Reject At</th>
                <th>Status By</th>
                <th>Status At</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Approve Request</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($creditNote->result() as $row) {
              ?>
                <tr>
                  <td><?= $row->id ?></td>
                  <td><?= $this->accounting_model->getCreditNoteType($row->type) ?></td>
                  <td><?php echo $this->customer_model->getCustomer($row->customer); ?></td>
                  <td><?= $row->issue_date ?></td>
                  <td><?= $this->admin_model->getAdmin($row->pm) ?></td>
                  <td><?= $row->number ?></td>
                  <td><?= $this->accounting_model->getCreditNoteInvoice($row->number) ?></td>
                  <td><?php if ($row->type == 2 || $row->type == 3) {
                        echo $this->accounting_model->getSelectedPOs($row->pos);
                      } ?></td>
                  <td><?= $row->amount ?></td>
                  <td><?= $this->admin_model->getCurrency($row->currency) ?></td>
                  <td><a href="<?= base_url() ?>assets/uploads/creditNote/<?= $row->file ?>" target="_blank">Click Here</a></td>
                  <td><?= $this->accounting_model->getCreditNoteStatus($row->status) ?></td>
                  <td><?php echo $this->admin_model->getAdmin($row->approved_by); ?></td>
                  <td><?= $row->approved_at ?></td>
                  <td><?php echo $this->admin_model->getAdmin($row->status_by); ?></td>
                  <td><?= $row->status_at ?></td>
                  <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                  <td><?= $row->created_at ?></td>
                  <td>
                    <?php if ($permission->view == 2 && ($row->type == 2 || $row->type == 3) && $row->status == 0) { ?>
                      <a href="<?php echo base_url() ?>accounting/approveCreditNoteRequest?t=<?php echo
                                                                                              base64_encode($row->id); ?>" class="">
                        <i class="fa fa-check"></i> Approve Request
                      </a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($permission->edit == 1 && $row->status == 0) { ?>
                      <a href="<?php echo base_url() ?>accounting/editCreditNote?t=<?php echo base64_encode($row->id); ?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                    <?php } ?>
                    <?php if ($permission->edit == 1 && $row->status == 1) { ?>
                      <a href="<?php echo base_url() ?>accounting/closeCreditNote?t=<?php echo base64_encode($row->id); ?>" class="">
                        <i class="fa fa-check"></i> Close Request
                      </a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($permission->delete == 1 && $row->status == 0) { ?>
                      <a href="<?php echo base_url() ?>accounting/deleteCreditNote?t=<?php echo base64_encode($row->id); ?>" title="delete" class="" onclick="return confirm('Are you sure you want to delete this Credit Note ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
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