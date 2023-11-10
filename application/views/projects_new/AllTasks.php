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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Tasks</h3>
        </div>
        <?php

        if (!empty($_REQUEST['code'])) {
          $code = $_REQUEST['code'];
        } else {
          $code = "";
        }
        if (!empty($_REQUEST['vendor'])) {
          $vendor = $_REQUEST['vendor'];
        } else {
          $vendor = "";
        }
        if (!empty($_REQUEST['task_type'])) {
          $task_type = $_REQUEST['task_type'];
        } else {
          $task_type = "";
        }
        if (!empty($_REQUEST['status'])) {
          $status = $_REQUEST['status'];
        } else {
          $status = "";
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
        if (isset($_REQUEST['created_by'])) {
          $created_by = $_REQUEST['created_by'];
        } else {
          $created_by = "";
        }
        ?>
        <form class="form" id="customerfilter" action="<?php echo base_url() ?>projectManagment/allTasks" method="get" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Task Code</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="code" value="<?= $code ?>">

              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Vendor</label>
              <div class="col-lg-3">
                <select name="vendor" class="form-control m-b" id="vendor" />
                <option value="" disabled="disabled" selected="selected">-- Select Vendor --</option>
                <?= $this->vendor_model->selectVendor($vendor, $this->brand) ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Task Type</label>
              <div class="col-lg-3">
                <select name="task_type" class="form-control m-b" id="task_type" />
                <option value="" disabled="disabled" selected="selected">-- Select Task Type --</option>
                <?= $this->admin_model->selectAllTaskType($task_type) ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Status</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status" />
                <option value="">-- Select Status --</option>

                <option value="3" <?= (isset($_REQUEST['status']) && $_REQUEST['status'] == 3) ? 'selected' : '' ?>>Running</option>
                <option value="1" <?= (isset($_REQUEST['status']) && $_REQUEST['status'] == 1) ? 'selected' : '' ?>>Delivered</option>
                <option value="2" <?= (isset($_REQUEST['status']) && $_REQUEST['status'] == 2) ? 'selected' : '' ?>>Cancelled</option>
                <option value="5" <?= (isset($_REQUEST['status']) && $_REQUEST['status'] == 5) ? 'selected' : '' ?>>Waiting PM Confirmation</option>


                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Source Language</label>
              <div class="col-lg-3">
                <select name="source" class="form-control m-b" id="source" />
                <option value="" disabled="disabled" selected="selected">-- Select Source Language --</option>
                <?= $this->admin_model->selectLanguage($source) ?>
                </select>
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Target Language</label>
              <div class="col-lg-3">
                <select name="target" class="form-control m-b" id="target" />
                <option value="" disabled="disabled" selected="selected">-- Select Target Language --</option>
                <?= $this->admin_model->selectLanguage($target) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Created by</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" />
                <option value="">-- Select --</option>
                <?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
                </select>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>projectManagment/allTasks" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a>

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
          <h3 class="card-label">All Tasks</h3>
        </div>

      </div>
      <div class="card-body">
        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>Projects/confirmTasks" onsubmit="return checkTaskConfirmForm();" method="post" enctype="multipart/form-data">
          <?php if ((isset($_REQUEST['status']) && $_REQUEST['status'] == 5)) { ?>
            <div class="col-lg-12">
              <input type="submit" style="margin-right: 5rem;" name="save" value="Confirm Selected Tasks" class="btn btn-primary">

            </div>
          <?php } ?>
          <!--begin: Datatable-->
          <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
            <thead>
              <tr>
                <?php if ((isset($_REQUEST['status']) && $_REQUEST['status'] == 5)) { ?>
                  <th><input type="checkbox" id="checkAll" onChange="checkAllBox()"></th>
                <?php } ?>
                <th>Task Code</th>
                <th>Task Subject</th>
                <th>Task Type</th>
                <th>Vendor</th>
                <th>Source</th>
                <th>Target</th>
                <th>Count</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Total Cost</th>
                <th>Currency</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <th>Task File</th>
                <th>Status</th>
                <th>Closed Date</th>
                <th>Created By</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($task->result() as $row) {
              ?>
                <tr>
                  <?php if ((isset($_REQUEST['status']) && $_REQUEST['status'] == 5)) { ?>
                    <td>
                      <?php if ($row->status == 5) { ?>
                        <input type="checkbox" class="checkConfirmation" data_code="<?= $row->code ?>" name="select[]" value="<?= $row->id ?>">
                      <?php } ?>
                    </td>
                  <?php } ?>
                  <td><a href="<?= base_url() ?>projectManagment/taskPage?t=<?= base64_encode($row->id) ?>"><?= $row->code ?></a></td>
                  <td><?php echo $row->subject; ?></td>
                  <td><?php echo $this->admin_model->getTaskType($row->task_type); ?></td>
                  <td><?php echo $this->vendor_model->getVendorName($row->vendor); ?></td>
                  <td><?php echo $this->admin_model->getLanguage($row->source); ?></td>
                  <td><?php echo $this->admin_model->getLanguage($row->target); ?></td>
                  <td><?php echo $row->count; ?></td>
                  <td><?php echo $this->admin_model->getUnit($row->unit); ?></td>
                  <td><?php echo $row->rate; ?></td>
                  <td><?php echo $row->rate * $row->count; ?></td>
                  <td><?php echo $this->admin_model->getCurrency($row->currency); ?></td>
                  <td><?php echo $row->start_date; ?></td>
                  <td><?php echo $row->delivery_date; ?></td>
                  <td><?php if (strlen($row->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/taskFile/<?= $row->file ?>" target="_blank">Click Here</a><?php } ?></td>
                  <td><?php echo $this->projects_model->getJobStatus($row->status); ?></td>
                  <td><?php echo $row->closed_date; ?></td>
                  <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                  <td><?php echo $row->created_at; ?></td>
                </tr>
              <?php } ?>
            </tbody>

          </table>
        </form>
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