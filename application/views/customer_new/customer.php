<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
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

      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Customer</h3>
        </div>

        <form class="form" id="customerfilter" action="<?php echo base_url() ?>customer/" method="post" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right">Customer Name</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" value="<?= $this->input->post('customer_name') ?>" name="customer_name" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Website</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" value="<?= $this->input->post('website') ?>" name="website" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right">Status</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b">
                  <option value="">-- Select status --</option>
                  <?php
                  if ($this->input->post('status') != '') { ?>
                    <?= $this->customer_model->SelectStatus($this->input->post('status')) ?>
                  <?php } else { ?>
                    <?= $this->customer_model->SelectStatus(0) ?>
                  <?php } ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Created by</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b">
                  <option value="">-- Select Sam --</option>
                  <?= $this->customer_model->selectAllSam($this->input->post('created_by'), $this->brand) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class=" col-lg-2 col-form-label text-lg-right">Client Type</label>
              <div class="col-lg-3">
                <select name="client_type" class="form-control m-b">
                  <option value="">-- Select Type --</option>
                  <?= $this->sales_model->selectClientType($_SESSION['client_type']) ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right">Customer Alias</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" value="<?= $this->input->post('alias') ?>" name="alias" autocomplete="off">
              </div>
            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit" value='<?= $this->input->post('search') ?>'>Search</button>
                  <!-- onclick="var e2 = document.getElementById('customerfilter'); e2.action='<?= base_url() ?>customer/'; e2.submit();" -->
                  <a href="<?= base_url() ?>customer/" class="btn btn-warning"><i class="la la-trash"></i>Clear
                    Filter</a>

                  <button class="btn btn-secondary" onclick="var e2 = document.getElementById('customerfilter'); e2.action='<?= base_url() ?>customer/exportcustomer'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
                    Excel</button>

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
          <h3 class="card-label">Customers</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>customer/addCustomerData" class="btn btn-primary font-weight-bolder">

              <span class="svg-icon svg-icon-md">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <circle fill="#000000" cx="9" cy="15" r="6" />
                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                  </g>
                </svg>
                <!--end::Svg Icon-->
              </span>Add New Customer</a>
            <!--end::Button-->
          <?php } ?>
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Website</th>
              <th>Status</th>
              <th>Brand</th>
              <th>Client Type</th>
              <th>Customer Alias</th>
              <th>Payment terms</th>
              <th>Created By</th>
              <th>Last Updated By</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($customer->result() as $row) {
            ?>
              <tr class="">
                <td>
                  <?= $row->id ?>
                </td>
                <td><a href="<?= base_url() ?>customer/customerPortal?t=<?= base64_encode($row->id) ?>"><?php echo $row->name; ?></a></td>
                <td>
                  <?php echo $row->website; ?>
                </td>
                <td>
                  <?php if ($row->status == 1) {
                    echo "Lead";
                  } elseif ($row->status == 2) {
                    echo "Existing";
                  } ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getBrand($row->brand); ?>
                </td>
                <td>
                  <?= $this->sales_model->getClientType($row->client_type); ?>
                </td>
                <td>
                  <?php echo $row->alias; ?>
                </td>
                <td>
                  <?php echo $row->payment; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  <br />
                  <?php echo $row->created_at; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->updated_by); ?>
                  <br />
                  <?php echo $row->updated_at; ?>
                </td>
                <td>
                  <!--  if(($permission->edit == 1 && $permission->follow == 2) || ($permission->edit == 1 && $row->created_by == $user)) -->
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>customer/editCustomer?t=<?php echo
                                                                              base64_encode($row->id); ?>" class="">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if (($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)) { ?>
                    <a href="<?php echo base_url() ?>customer/deleteCustomer/?t=<?php echo
                                                                                base64_encode($row->id); ?>" title="delete" class="" onclick="return confirm('Are you sure you want to delete this Customer ?');">
                      <i class="fa fa-times text-danger text"></i> Delete
                    </a>
                  <?php } ?>
                </td>
              </tr>
            <?php
            }
            ?>
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