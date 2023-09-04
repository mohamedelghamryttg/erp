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
  <!--begin::Subheader-->
  <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">


    </div>
  </div>
  <!--end::Subheader-->

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title"> Handover Filter</h3>
        </div>
        <?php
        if (isset($_REQUEST['customer_name'])) {
          $customer_name = $_REQUEST['customer_name'];
        } else {
          $customer_name = "";
        }
        if (isset($_REQUEST['ttg_pm_name'])) {
          $ttg_pm_name = $_REQUEST['ttg_pm_name'];
        } else {
          $ttg_pm_name = "";
        }
        ?>
        <form class="form" id="handoverFilter" action="<?php echo base_url() ?>projects/handover" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Customer Name</label>
              <div class="col-lg-3">
                <select name="customer_name" class="form-control m-b" />
                <option value="">-- Select Customer Name --</option>
                <?= $this->customer_model->selectCustomer($customer_name) ?>
                </select>
              </div>
              <label class="col-lg-2 col-form-label text-lg-right" for="role name">TTG PM Name</label>
              <div class="col-lg-3">
                <select name="ttg_pm_name" class="form-control m-b" />
                <option value="">-- Select PM --</option>
                <?= $this->sales_model->selectPm($ttg_pm_name, $brand) ?>
                </select>
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>projects/handover" class="btn btn-warning"><i class="la la-trash"></i>Clear
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
          <h3 class="card-label">Handover</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>projects/addHandover" class="btn btn-primary font-weight-bolder">
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
            </span>Add New Record</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>#ID</th>
              <th>Costumer Name</th>
              <th>Costumer PM</th>
              <th>TTG PM Name</th>
              <th>Productline</th>
              <th>Email subject</th>
              <th>Service</th>
              <th>Subject Matter</th>
              <th>Source Language</th>
              <th>Target Language</th>
              <th>Dialect</th>
              <th>Tool</th>
              <th>Source Format</th>
              <th>Source files location</th>
              <th>Deliverables Format</th>
              <th>Delivery location</th>
              <th>Number of files</th>
              <th>Files Names</th>
              <th>Start date</th>
              <th>Delivery date</th>
              <th>Volume</th>
              <th>Unite</th>
              <th>Total PO Amount</th>
              <th>Customer Instructions</th>
              <th>Vendors to avoid </th>
              <th>Important comment</th>
              <th>Created At</th>
              <th>Created By</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($handover->result() as $row) {
              //$handoverResources = $this->db->query('SELECT * FROM handover_resources WHERE handover = "$row->id"');
              $handoverResources = $this->db->get_where('handover_resources', array('handover' => $row->id))->result();

              ?>
              <tr>

                <td>
                  <?= $row->id ?>
                </td>
                <td>
                  <?= $this->customer_model->getCustomer($row->customer_name) ?>
                </td>
                <td>
                  <?= $row->customer_pm ?>
                </td>
                <td>
                  <?= $this->admin_model->getUser($row->ttg_pm_name) ?>
                </td>
                <td>
                  <?= $this->customer_model->getProductLine($row->productline) ?>
                </td>
                <td>
                  <?= $row->email_subject ?>
                </td>
                <td>
                  <?= $this->admin_model->getServices($row->service) ?>
                </td>
                <td>
                  <?= $row->subject_matter ?>
                </td>
                <td>
                  <?= $this->admin_model->getLanguage($row->source_language) ?>
                </td>
                <td>
                  <?= $this->admin_model->getLanguage($row->target_language) ?>
                </td>
                <td>
                  <?= $row->dialect ?>
                </td>
                <td>
                  <?= $this->sales_model->getToolName($row->tool) ?>
                </td>
                <td>
                  <?= $row->source_format ?>
                </td>
                <td>
                  <?= $row->source_files_location ?>
                </td>
                <td>
                  <?= $row->deliverables_format ?>
                </td>
                <td>
                  <?= $row->delivery_location ?>
                </td>
                <td>
                  <?= $row->number_of_files ?>
                </td>
                <td>
                  <?= $row->files_names ?>
                </td>
                <td>
                  <?= $row->start_date ?>
                </td>
                <td>
                  <?= $row->delivery_date ?>
                </td>
                <td>
                  <?= $row->volume ?>
                </td>
                <td>
                  <?= $this->admin_model->getUnit($row->unit) ?>
                </td>
                <td>
                  <?= $row->total_po_amount ?>
                </td>
                <td>
                  <?= $row->customer_instructions ?>
                </td>
                <td>
                  <?= $row->vendors_to_avoid ?>
                </td>
                <td>
                  <?= $row->important_comment ?>
                </td>
                <td>
                  <?= $row->created_at ?>
                </td>
                <td>
                  <?= $this->admin_model->getAdmin($row->created_by) ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>projects/editHandover?t=<?php echo base64_encode($row->id); ?>"
                      class="btn btn-sm btn-clean btn-icon">
                      <i class="la la-edit"></i>
                    </a>
                  <?php } ?>
                </td>

                <td>
                  <?php if ($permission->delete == 1) { ?>
                    <a href="<?php echo base_url() ?>projects/deleteHandover?t=<?php echo base64_encode($row->id); ?>"
                      title="delete" class="btn btn-sm btn-clean btn-icon"
                      onclick="return confirm('Are you sure you want to delete this Record ?');">
                      <i class="la la-trash"></i>
                    </a>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td colspan="16">
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                      <th>#ID</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>Delevery Date</th>
                      <th>Created At</th>
                      <th>Created By</th>
                      <th>Edit</th>
                      <th>Delete</th>

                    </thead>
                    <tbody>
                      <?php foreach ($handoverResources as $resource) { ?>
                        <tr>
                          <td>
                            <?= $resource->id ?>
                          </td>
                          <td>
                            <?php if ($resource->type == 1) { ?>
                              Translator
                            <?php } elseif ($resource->type == 2) { ?>
                              Reviewer
                            <?php } elseif ($resource->type == 3) { ?>
                              Proofreader
                            <?php } ?>
                          </td>
                          <td>
                            <?= $resource->name ?>
                          </td>
                          <td>
                            <?= $resource->delevery_date ?>
                          </td>
                          <td>
                            <?= $row->created_at ?>
                          </td>
                          <td>
                            <?= $this->admin_model->getAdmin($row->created_by) ?>
                          </td>
                          <td>
                            <?php if ($permission->edit == 1) { ?>
                              <a href="<?php echo base_url() ?>projects/editHandoverResource?t=<?php echo base64_encode($resource->id); ?>"
                                class="btn btn-sm btn-clean btn-icon">
                                <i class="la la-edit"></i>
                              </a>
                            <?php } ?>
                          </td>

                          <td>
                            <?php if ($permission->delete == 1) { ?>
                              <a href="<?php echo base_url() ?>projects/deleteHandoverResource?t=<?php echo base64_encode($resource->id); ?>"
                                title="delete" class="btn btn-sm btn-clean btn-icon"
                                onclick="return confirm('Are you sure you want to delete this Record ?');">
                                <i class="la la-trash"></i>
                              </a>
                            <?php } ?>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
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