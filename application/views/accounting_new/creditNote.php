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
          <h3 class="card-title">Search Credit Notes</h3>
        </div>

        <form class="form" id="poList" action="<?php echo base_url() ?>accounting/creditNote" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Client</label>
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


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-primary" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>accounting/creditNote" class="btn btn-warning">(x) Clear Filter</a>

                </div>
              </div>
            </div>
        </form>
      </div>
    </div>
    <!--end::Card-->
    <!-- end search form -->

    <!--begin::Card-->
    <div class="card">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Credit Notes List</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>accounting/addcreditNote" class="btn btn-primary font-weight-bolder">
            <?php } ?>
            <span class="svg-icon svg-icon-md">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24" />
                  <circle fill="#000000" cx="9" cy="15" r="6" />
                  <path
                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                    fill="#000000" opacity="0.3" />
                </g>
              </svg>
              <!--end::Svg Icon-->
            </span>Add New Credit Note</a>
          <!--end::Button-->
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
                  <?php if ($row->type == 2 || $row->type == 3) {
                    echo $this->accounting_model->getSelectedPOs($row->pos);
                  } ?>
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
                  <?php echo $this->admin_model->getAdmin($row->approved_by); ?>
                </td>
                <td>
                  <?= $row->approved_at ?>
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
                  <?php if ($permission->view == 2 && ($row->type == 2 || $row->type == 3) && $row->status == 0) { ?>
                    <a href="<?php echo base_url() ?>accounting/approveCreditNoteRequest?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-check"></i> Approve Request
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1 && $row->status == 0) { ?>
                    <a href="<?php echo base_url() ?>accounting/editCreditNote?t=<?php echo base64_encode($row->id); ?>"
                      class="">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  <?php } ?>
                  <?php if ($permission->edit == 1 && $row->status == 1) { ?>
                    <a href="<?php echo base_url() ?>accounting/closeCreditNote?t=<?php echo base64_encode($row->id); ?>"
                      class="">
                      <i class="fa fa-check"></i> Close Request
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($permission->delete == 1 && $row->status == 0) { ?>
                    <a href="<?php echo base_url() ?>accounting/deleteCreditNote?t=<?php echo base64_encode($row->id); ?>"
                      title="delete" class=""
                      onclick="return confirm('Are you sure you want to delete this Credit Note ?');">
                      <i class="fa fa-times text-danger text"></i> Delete
                    </a>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>

        </table>
        <!--begin::Pagination-->
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <?= $this->pagination->create_links() ?>
        </div>
        <!--end:: Pagination-->

        <!--end: Datatable-->
      </div>
    </div>
    <!--end::Card-->
  </div>
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->