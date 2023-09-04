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
    <div class="container">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search</h3>
        </div>
        <?php

        if (!empty($_REQUEST['customer'])) {
          $customer = $_REQUEST['customer'];

        } else {
          $customer = "";
        }
        if (!empty($_REQUEST['region'])) {
          $region = $_REQUEST['region'];

        } else {
          $region = "";
        }

        ?>
        <form class="form" id="pmCustomer" action="<?php echo base_url() ?>customer/pmCustomer" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Customer</label>
              <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" />
                <option value="">-- Select Customer --</option>
                <?= $this->customer_model->selectCustomerExisting($customer, $this->brand) ?>
                </select>
              </div>

              <label class="col-lg-2 control-label" for="role name">Region</label>
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
                  <button class="btn btn-success mr-2" name="search"
                    onclick="var e2 = document.getElementById('pmCustomer'); e2.action='<?= base_url() ?>customer/pmCustomer'; e2.submit();"
                    type="submit">Search</button>
                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('pmCustomer'); e2.action='<?= base_url() ?>customer/exportPmCustomer'; e2.submit();"
                    name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
                    Excel</button>
                  <a href="<?= base_url() ?>customer/pmCustomer" class="btn btn-warning"><i
                      class="la la-trash"></i>Clear
                    Filter</a>

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
          <h3 class="card-label">Customers PM Management</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>customer/addBranch" class="btn btn-primary font-weight-bolder">
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
            </span>Add New</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Customer Portal</th>
              <th>Source</th>
              <th>Region</th>
              <th>Country</th>
              <th>Type</th>
              <th>Assigned PM</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($branch->result() as $row) {
              $PmCustomer = $this->customer_model->customersPmRow($row->id);
              ?>
              <tr class="">
                <td>
                  <?= $row->id ?>
                </td>
                <td><a href="<?= base_url() ?>customer/leadContacts?t=<?= base64_encode($row->id) ?>"><?php echo $this->customer_model->getCustomer($row->customer); ?></a></td>

                <td><a href="<?= base_url() ?>customer/customerPortal?t=<?= base64_encode($row->id) ?>">Go To Customer
                    Portal</a></td>

                <td>
                  <?php echo $row->source; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getRegion($row->region); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCountry($row->country); ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getType($row->type); ?>
                </td>
                <td>
                  <?php if ($PmCustomer->num_rows() == 0) { ?>
                    <?php if ($permission->follow == 2) { ?>
                      <a href="#myModal<?php echo $row->id; ?>" data-toggle="modal" class="btn btn-success">Assign PM</a>
                    <?php } ?>
                  <?php } else { ?>
                    <table style="border-collapse:collapse;">
                      <tr>
                        <td style="border: 1px solid #ddd;">PM Name</td>
                        <?php if ($permission->follow == 2) { ?>
                          <td style="border: 1px solid #ddd;"></td>
                          <td style="border: 1px solid #ddd;"></td>
                        <?php } ?>
                      </tr>
                      <?php
                      $i = 0;
                      $count = $PmCustomer->num_rows();
                      foreach ($PmCustomer->result() as $pm) {
                        //echo $i;
                        ?>
                        <tr>
                          <td style="border: 1px solid #ddd;">
                            <?php echo $this->admin_model->getAdmin($pm->pm); ?>
                          </td>
                          <?php if ($permission->follow == 2) { ?>
                            <td style="border: 1px solid #ddd;"><a
                                href="<?php echo base_url() ?>customer/deletePmCustomer?t=<?php echo base64_encode($pm->id); ?>">
                                <i class="fa fa-times text-danger text"></i> </a>
                            </td>
                          <?php } ?>
                          <?php if ($i < 1) {
                            ?>
                            <?php if ($permission->follow == 2) { ?>
                              <td rowspan="<?php echo $count; ?>" style="border: 1px solid #ddd;"><a
                                  href="#myModal<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success">Assign PM</a>
                              </td>
                            <?php } ?>
                          <?php }
                          ?>
                        </tr>
                        <?php
                        $i = $i + 1;
                      } ?>
                    </table>
                  <?php } ?>
                </td>
              </tr>

              <!-- form of adding PM and brand to customer-->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                id="myModal<?php echo $row->id; ?>" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Assign Pm To this Customer</h4>
                      <button aria-hidden="true" data-dismiss="modal" class="close text-danger" type="button"
                        style="color:red !important;">×</button>
                    </div>
                    <div class="modal-body">

                      <form role="form" id="commentForm" action="<?php echo base_url() ?>customer/assignPmCustomer"
                        method="post" enctype="multipart/form-data">
                        <input name="lead" type="hidden" value="<?php echo $row->id; ?>">
                        <input name="customer" type="hidden" value="<?php echo $row->customer; ?>">
                        <div class="form-group">
                          <!--<label for="pm">Select Pm </label>-->
                          <select name="pm" class="form-control m-b" id="pm" required>
                            <option disabled="disabled" selected="selected">Select Pm</option>
                            <?= $this->customer_model->selectPmCustomer($row->id, $brand) ?>
                          </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
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