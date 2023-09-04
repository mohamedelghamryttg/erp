<style>
  .badge span {
    vertical-align: text-top;
  }
</style>
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
          <h3 class="card-title">Search Price List</h3>
        </div>
        <?php
        if (!empty($_REQUEST['product_line'])) {
          $product_line = $_REQUEST['product_line'];

        } else {
          $product_line = "";
        }
        if (!empty($_REQUEST['customer'])) {
          $customer = $_REQUEST['customer'];

        } else {
          $customer = "";
        }
        if (!empty($_REQUEST['source'])) {
          $source = $_REQUEST['source'];

        } else {
          $source = "";
        }
        if (!empty($_REQUEST['target'])) {
          $target = $_REQUEST['target'];

        } else {
          $target = "";
        }
        if (!empty($_REQUEST['service'])) {
          $service = $_REQUEST['service'];

        } else {
          $service = "";
        }
        if (!empty($_REQUEST['task_type'])) {
          $task_type = $_REQUEST['task_type'];

        } else {
          $task_type = "";
        }
        if (!empty($_REQUEST['created_by'])) {
          $created_by = $_REQUEST['created_by'];

        } else {
          $created_by = "";
        }

        ?>
        <form class="form" id="priceListForm" action="<?php echo base_url() ?>customer/priceList" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Customer</label>
              <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" />
                <option value="">-- Select Customer --</option>
                <?= $this->customer_model->selectCustomerBySam($customer, $this->user, $permission, $this->brand) ?>
                </select>

              </div>

              <label class="col-lg-2 control-label text-lg-right" for="role name">Product Line</label>
              <div class="col-lg-3">
                <select name="product_line" class="form-control m-b" id="product_line" />
                <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                <?= $this->customer_model->selectProductLine($product_line, $this->brand) ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Source Language</label>
              <div class="col-lg-3">
                <select name="source" class="form-control m-b" id="source" />
                <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                <option value="0">Empty</option>
                <?= $this->admin_model->selectLanguage($source) ?>
                </select>
              </div>

              <label class="col-lg-2 control-label text-lg-right" for="role name">Target Language</label>
              <div class="col-lg-3">
                <select name="target" class="form-control m-b" id="target" />
                <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                <option value="0">Empty</option>
                <?= $this->admin_model->selectLanguage($target) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Service</label>
              <div class="col-lg-3">
                <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                <option value="" disabled="disabled" selected="selected">-- Select Service --</option>
                <?= $this->admin_model->selectServices($service) ?>
                </select>
              </div>

              <label class="col-lg-2 control-label text-lg-right" for="role name">Task Type</label>
              <div class="col-lg-3">
                <select name="task_type" class="form-control m-b" id="task_type" />
                <option value="" disabled="disabled" selected="selected">-- Select Task Type --</option>
                <?= $this->admin_model->selectAllTaskType($task_type) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Created By</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by" />
                <option value="">-- Select SAM --</option>
                <?= $this->customer_model->selectAllSam($created_by, $this->brand) ?>
                </select>
              </div>
              <label class="col-lg-2 col-form-label text-lg-right">Status</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status" />
                <option value="" selected=''>-- Select --</option>
                <?= $this->sales_model->selectClientPriceStatus($status ?? '') ?>
                </select>
              </div>

            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search"
                    onclick="var e2 = document.getElementById('priceListForm'); e2.action='<?= base_url() ?>customer/priceList'; e2.submit();"
                    type="submit">Search</button>
                  <a href="<?= base_url() ?>customer/priceList" class="btn btn-warning"><i class="la la-trash"></i>Clear
                    Filter</a>

                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('priceListForm'); e2.action='<?= base_url() ?>customer/exportPriceList'; e2.submit();"
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
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Customers Price List</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>customer/addPriceList" class="btn btn-primary font-weight-bolder">
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
              </span>Add New Price List</a>
          <?php } ?>
          <!--end::Button-->
          <a href="<?= base_url() ?>customer/addBulkPriceList" class="btn btn-success ">Import Bulk Data <i
              class="fa fa-upload" aria-hidden="true"></i></a>
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Region</th>
              <th>Country</th>
              <th>Product Line</th>
              <th>Service</th>
              <th>Task Type</th>
              <th>Rate</th>
              <th>Unit</th>
              <th>Source</th>
              <th>Target</th>
              <th>Dialect</th>
              <th>Status</th>
              <th>Approved By</th>
              <th>Created By</th>
              <th>Edit </th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($priceList->result() as $row) {
              $leadData = $this->db->get_where('customer_leads', array('id' => $row->lead))->row();
              ?>
              <tr class="">
                <td>
                  <?php echo $this->customer_model->getCustomer($row->customer); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getRegion($leadData->region); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCountry($leadData->country); ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getProductLine($row->product_line); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getServices($row->service); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getTaskType($row->task_type); ?>
                </td>
                <td>
                  <?php echo $row->rate; ?>
                  <?php echo $this->admin_model->getCurrency($row->currency); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getUnit($row->unit); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->source); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->target); ?>
                </td>
                <td>
                  <?php echo $row->dialect; ?>
                </td>
                <td>
                  <?php echo $this->sales_model->getClientPriceStatus($row->approved); ?>
                </td>
                <td>
                  <?= $this->admin_model->getAdmin($row->approved_by) . "<br/>" . $row->approved_at; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by) . "<br/>" . $row->created_at; ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>customer/editPriceList?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($permission->delete == 1) { ?>
                    <a href="<?php echo base_url() ?>customer/deletePriceList?t=<?php echo
                         base64_encode($row->id); ?>" title="delete" class=""
                      onclick="return confirm('Are you sure you want to delete this Price List ?');">
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