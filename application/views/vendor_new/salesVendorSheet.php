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

        <form class="form" action="<?php echo base_url() ?>vendor/salesVendorSheet" method="post"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Dialect :</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="dialect">
              </div>

            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right">Source :</label>
              <div class="col-lg-3">
                <select name="source_lang" class="form-control m-b" id="source" />
                <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                <?= $this->admin_model->selectLanguage() ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Target :</label>
              <div class="col-lg-3">
                <select name="target_lang" class="form-control m-b" id="target" />
                <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                <?= $this->admin_model->selectLanguage() ?>
                </select>
              </div>

            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right">Service :</label>
              <div class="col-lg-3">
                <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                <option disabled="disabled" selected=""></option>
                <?= $this->admin_model->selectServices() ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right">Task Type :</label>
              <div class="col-lg-3">
                <select name="task_type" class="form-control m-b" id="task_typ" />
                <option disabled="disabled" selected=""></option>
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

    <!--begin::Card-->
    <div class="card">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Vendors Sheet</h3>
        </div>
        <div class="card-toolbar">
          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>vendor/addVendorSheet" class="btn btn-primary font-weight-bolder">
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
          <?php } ?>

          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>Source Language</th>
              <th>Target Language</th>
              <th>Dialect</th>
              <th>Service</th>
              <th>Task Type</th>
              <th>Unit</th>
              <th>Rate</th>
              <th>Currency</th>
              <th>Subject Matter</th>
              <th>Tools</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($vendor->result() as $row) {
              ?>
              <tr class="">
                <td>
                  <?= $this->admin_model->getLanguage($row->source_lang) ?>
                </td>
                <td>
                  <?= $this->admin_model->getLanguage($row->target_lang) ?>
                </td>
                <td>
                  <?= $row->dialect ?>
                </td>
                <td>
                  <?= $this->admin_model->getServices($row->service) ?>
                </td>
                <td>
                  <?= $this->admin_model->getTaskType($row->task_type) ?>
                </td>
                <td>
                  <?= $this->admin_model->getUnit($row->unit) ?>
                </td>
                <td>
                  <?= $row->rate ?>
                </td>
                <td>
                  <?= $this->admin_model->getCurrency($row->currency) ?>
                </td>
                <td>
                  <?php
                  $subjects = explode(",", $row->subject);
                  for ($i = 0; $i < count($subjects); $i++) {
                    if ($i > 0) {
                      echo " - ";
                    }
                    echo $this->admin_model->getFields($subjects[$i]);
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $tools = explode(",", $row->tools);
                  for ($i = 0; $i < count($tools); $i++) {
                    if ($i > 0) {
                      echo " - ";
                    }
                    echo $this->sales_model->getToolName($tools[$i]);
                  }
                  ?>
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
</div>
<!--end::Content-->