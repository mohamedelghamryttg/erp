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
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Activities</h3>
        </div>
        <?php

        if (isset($_REQUEST['id'])) {
          $id = $_REQUEST['id'];
        } else {
          $id = "";
        }
        if (isset($_REQUEST['customer'])) {
          $customer = $_REQUEST['customer'];
        } else {
          $customer = "";
        }
        if (isset($_REQUEST['created_by'])) {
          $created_by = $_REQUEST['created_by'];
        } else {
          $created_by = "";
        }
        if (isset($_REQUEST['region'])) {
          $region = $_REQUEST['region'];
        } else {
          $region = "";
        }

        ?>

        <form class="form" id="activityForm" action="<?php echo base_url() ?>sales/salesActivity" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Customer</label>
              <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" onchange="CustomerData()" />
                <option value="">-- Select Customer --</option>
                <?= $this->customer_model->selectCustomerBySam($customer, $user, $permission, $this->brand) ?>
                </select>
              </div>

              <?php if ($permission->view == 1) { ?>
                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Created By</label>
                <div class="col-lg-3">
                  <select name="created_by" class="form-control m-b" id="created_by" />
                  <option value="">-- Select SAM --</option>
                  <?= $this->customer_model->selectAllSam($created_by, $this->brand) ?>
                  </select>
                </div>
              <?php } ?>
            </div>


            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>

            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Activity Number</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" value="<?= $id ?>" name="id" autocomplete="off">
              </div>
              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Region</label>
              <div class="col-lg-3">
                <select name="region" class="form-control m-b" id="region" />
                <option value="">-- Select Region --</option>
                <?= $this->admin_model->selectRegion($region) ?>
                </select>
              </div>

            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success" name="search" type="submit">Search</button>
                  <button class="btn btn-warning"
                    onclick="var e2 = document.getElementById('activityForm'); e2.action='<?= base_url() ?>sales/exportActivities'; e2.submit();"
                    name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
                    Excel</button>
                  <a href="<?= base_url() ?>sales/salesActivity" class="btn btn-secondary">(x) Clear Filter</a>

                </div>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- end search form -->

    <!--begin::Card-->
    <div class="card">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Sales Activities</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>sales/addSalesActivity" class="btn btn-primary font-weight-bolder">
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
            </span>Add New Activity</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>Activity Number</th>
              <th>Customer</th>
              <th>Region</th>
              <th>Country</th>
              <th>Customer Type</th>
              <th>Rolled In</th>
              <th>Contact Method</th>
              <th>Call Status</th>
              <th>Assigned PM</th>
              <!-- <th>Contact Name</th> -->
              <th>Created BY</th>
              <th>Created At</th>
              <th>Edit </th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($sales->num_rows() > 0) {
              foreach ($sales->result() as $row) {
                $leadData = $this->db->get_where('customer_leads', array('id' => $row->lead))->row();
                $customerData = $this->db->get_where('customer', array('id' => $row->customer))->row();
                ?>
                <tr class="">
                  <td>
                    <?= $row->id ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url() ?>sales/followUp?t=<?php echo base64_encode($row->id); ?>
                      "><?php echo $this->customer_model->getCustomer($row->customer); ?></a>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getRegion($leadData->region); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getCountry($leadData->country); ?>
                  </td>
                  <td>
                    <?php echo $this->customer_model->getType($leadData->type); ?>
                  </td>
                  <td>
                    <?php if ($row->rolled_in == 1) {
                      echo "Yes";
                    } else if ($row->rolled_in == 2) {
                      echo "No";
                    } else {
                    } ?>
                  </td>
                  <td>
                    <?php echo $this->sales_model->getContactMethod($row->contact_method); ?>
                  </td>
                  <td>
                    <?php echo $this->sales_model->getActivityStatus($row->status); ?>
                  </td>
                  <!-- <td><?php echo $row->contact_id; ?></td> -->
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->pm) ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by) ?>
                  </td>
                  <td>
                    <?php echo $row->created_at ?>
                  </td>
                  <td>
                    <?php if (($permission->edit == 1 && $permission->follow == 2) || ($permission->edit == 1 && $row->created_by == $user)) { ?>
                      <a href="<?php echo base_url() ?>sales/editSalesActivity?t=<?php echo
                           base64_encode($row->id); ?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if (($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)) { ?>
                      <a href="<?php echo base_url() ?>sales/deleteSalesActivity?t=<?php echo
                           base64_encode($row->id); ?>" title="delete" class=""
                        onclick="return confirm('Are you sure you want to delete this activity ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                    <?php } ?>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
            <tr>
              <td colspan="7">There is no Activties in your list</td>
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
</div>
<!--end::Content-->