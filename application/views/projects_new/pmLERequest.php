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
          <h3 class="card-title">Search LE Requests</h3>
        </div>
        <?php

        if (!empty($_REQUEST['code'])) {
          $code = $_REQUEST['code'];
        } else {
          $code = "";
        }

        if (!empty($_REQUEST['subject'])) {
          $subject = $_REQUEST['subject'];

        } else {
          $subject = "";
        }
        ?>
        <form class="form" id="customerfilter" action="<?php echo base_url() ?>projects/pmLERequest" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Task Code</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="code" value="<?= $code ?>">

              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Task Name</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="subject" value="<?= $subject ?>">
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>projects/pmLERequest" class="btn btn-warning"><i
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
      <div class="card-header">
        <div class="card-title">
          <h3 class="card-label">LE Requests</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>projects/addLeRequest" class="btn btn-primary font-weight-bolder">
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
            </span>Add New Request</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>#</th>
              <th>Task Code</th>
              <th>Task Name</th>
              <th>Task Type</th>
              <th>Subject Matter</th>
              <th>Product Line</th>
              <th>Linguist Format</th>
              <th>Deliverable Format</th>
              <th>Unit</th>
              <th>Volume</th>
              <th>Complexicty</th>
              <th>Rate</th>
              <th>Source Language</th>
              <th>Target Language</th>
              <th>Start Date</th>
              <th>Delivery Date</th>
              <th>Task File</th>
              <th>Status</th>
              <th>Request Date</th>
              <th>Requested By</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>View Request</th>
              <th>Edit </th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ix = $offset;
            foreach ($le_request->result() as $row) {
              $ix++;
              $jobData = $this->projects_model->getJobData($row->job_id = 0);

              ?>
              <tr>
                <td>
                  <?= $ix ?>
                </td>
                <td>
                  <?php echo $row->id; ?>
                </td>
                <td>
                  <?php echo $row->subject; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLETaskType($row->task_type); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLESubject($row->subject_matter); ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getProductLine($row->product_line); ?>
                </td>
                <?php if (is_numeric($row->linguist) && is_numeric($row->deliverable)) { ?>
                  <td>
                    <?php echo $this->admin_model->getLeFormat($row->linguist); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getLeFormat($row->deliverable); ?>
                  </td>
                <?php } else { ?>
                  <td>
                    <?= $row->linguist ?>
                  </td>
                  <td>
                    <?= $row->deliverable ?>
                  </td>
                <?php } ?>
                <td>
                  <?php echo $this->admin_model->getUnit($row->unit); ?>
                </td>
                <td>
                  <?= $row->volume ?>
                </td>

                <td>
                  <?= $this->projects_model->getLeComplexicty($row->complexicty); ?>
                </td>
                <td>
                  <?= $row->rate ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->source_language); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->target_language); ?>
                </td>
                <td>
                  <?php echo $row->start_date; ?>
                </td>
                <td>
                  <?php echo $row->delivery_date; ?>
                </td>
                <td>
                  <?php if (strlen($row->file) > 1) { ?><a
                      href="<?= base_url() ?>assets/uploads/leRequest/<?= $row->file ?>" target="_blank">Click Here</a>
                  <?php } ?>
                </td>
                <td>
                  <?php echo $this->projects_model->getTranslationTaskStatus($row->status); ?>
                </td>
                <td>
                  <?php echo $row->created_at; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->status_by); ?>
                </td>
                <td>
                  <?php echo $row->status_at; ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>projects/leTask?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-eye"></i> View Task
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5)) { ?>
                    <a href="<?php echo base_url() ?>projects/editLeRequest?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($permission->delete == 1) { ?>
                    <a href="<?php echo base_url() ?>projects/deleteLeRequest?t=<?php echo
                         base64_encode($row->id); ?>" title="delete" class=""
                      onclick="return confirm('Are you sure you want to delete this Request ?');">
                      <i class="fa fa-times text-danger text"></i> Delete
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