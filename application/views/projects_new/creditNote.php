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
          <h3 class="card-title">Search Credit Note</h3>
        </div>

        <form class="form" id="poList" action="<?php echo base_url() ?>accounting/cpoStatus" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">PO Number</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="po">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Po Status</label>
              <div class="col-lg-3">
                <select name="verified" class="form-control m-b" id="verified" />
                <option disabled="disabled" selected="selected">-- Select Status --</option>
                <option value="1">Verified</option>
                <option value="2">Not Verified</option>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Invoice Status</label>
              <div class="col-lg-3">
                <select name="invoiced" class="form-control m-b" id="invoiced" />
                <option disabled="disabled" selected="selected">-- Select --</option>
                <option value="1">Invoiced</option>
                <option value="2">Not Invoiced</option>
                </select>
              </div>

            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-primary" name="search" type="submit">Search</button>

                </div>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- end search form -->

    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <h3 class="card-label">Credit Notes List</h3>
        </div>

      </div>

      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Credit Note Type</th>
              <th>Customer</th>
              <th>Issue_date</th>
              <th>PM Name</th>
              <th>PO Number</th>
              <th>Amount</th>
              <th>Currency</th>
              <th>Attachment File</th>
              <th>Status</th>
              <th>Status By</th>
              <th>Status At</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>View Request</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($creditNote->result() as $row) {
              ?>
              <tr>
                <td>
                  <?= $row->id ?>
                </td>
                <td>
                  <?= $this->accounting_model->getCreditNoteType($row->type) ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getCustomer($row->customer); ?>
                </td>
                <td>
                  <?= $row->issue_date ?>
                </td>
                <td>
                  <?= $this->admin_model->getAdmin($row->pm) ?>
                </td>
                <td>
                  <?= $row->number ?>
                </td>
                <td>
                  <?= $row->amount ?>
                </td>
                <td>
                  <?= $this->admin_model->getCurrency($row->currency) ?>
                </td>
                <td><a href="<?= base_url() ?>assets/uploads/creditNote/<?= $row->file ?>" target="_blank">Click Here</a>
                </td>
                <td>
                  <?= $this->accounting_model->getCreditNoteStatus($row->status) ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->status_by); ?>
                </td>
                <td>
                  <?= $row->status_at ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?= $row->created_at ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1 && $row->status == 0) { ?>
                    <a href="<?php echo base_url() ?>projects/viewCreditNote?t=<?php echo base64_encode($row->id); ?>"
                      class="">
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
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->