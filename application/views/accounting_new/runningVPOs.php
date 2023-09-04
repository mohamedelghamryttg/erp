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
          <h3 class="card-title">VPO Search</h3>
        </div>

        <form class="form" id="vpoForm" method="get" action="<?php echo base_url() ?>accounting/runningVPOs"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">PO Number</label>
              <div class="col-lg-3">
                <input class="form-control" type="text" name="code" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">PM Name</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by">
                  <option value="">-- Select PM --</option>
                  <?= $this->admin_model->selectAllPm('', $this->brand) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Vendor Name</label>
              <div class="col-lg-3">
                <select name="vendor" class="form-control m-b" id="vendor">
                  <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                  <?= $this->vendor_model->selectVendor(0, $brand) ?>
                </select>
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-primary" name="search" type="submit">Search</button>
                  <button class="btn btn-success"
                    onclick="var e2 = document.getElementById('vpoForm'); e2.action='<?= base_url() ?>accounting/exportRunningVPOs'; e2.submit();"
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
      <div class="card-header">
        <div class="card-title">
          <h3 class="card-label">All Running VPOs <span class="btn btn-danger"><span>
                <?= $count ?>
              </span></span></h3>
        </div>

      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>Task Code</th>
              <th>Task Type</th>
              <th>Vendor</th>
              <th>Source Language</th>
              <th>Target Language</th>
              <th>Count</th>
              <th>Unit</th>
              <th>Rate</th>
              <th>Total Cost</th>
              <th>Currency</th>
              <th>Start Date</th>
              <th>Delivery Date</th>
              <th>Task File</th>
              <th>Status</th>
              <th>Created By</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($task->result() as $row) {
              $priceList = $this->projects_model->getJobPriceListData($row->price_list);
              $project = explode("-", $row->code);
              $projectData = $this->projects_model->getProjectData($project[1]);
              ?>
              <tr>
                <td>
                  <?= $row->code ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getTaskType($row->task_type); ?>
                </td>
                <td>
                  <?php echo $this->vendor_model->getVendorName($row->vendor); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($priceList->source); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($priceList->target); ?>
                </td>
                <td>
                  <?php echo $row->count; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getUnit($row->unit); ?>
                </td>
                <td>
                  <?php echo $row->rate; ?>
                </td>
                <td>
                  <?php echo $row->rate * $row->count; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCurrency($row->currency); ?>
                </td>
                <td>
                  <?php echo $row->start_date; ?>
                </td>
                <td>
                  <?php echo $row->delivery_date; ?>
                </td>
                <td>
                  <?php if (strlen($row->file ?? '') > 1) { ?><a
                    href="<?= base_url() ?>assets/uploads/taskFile/<?= $row->file ?>" target="_blank">Click Here</a>
                <?php } ?>
                </td>
                <td>
                  <?php echo $this->projects_model->getJobStatus($row->status); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?php echo $row->created_at; ?>
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