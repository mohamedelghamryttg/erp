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
          <h3 class="card-title">Search PM Conversion Request</h3>
        </div>
        <?php
        if (isset($_REQUEST['file_name'])) {
          $file_name = $_REQUEST['file_name'];
        } else {
          $file_name = "";
        }
        if (isset($_REQUEST['task_type'])) {
          $task_type = $_REQUEST['task_type'];
        } else {
          $task_type = "";
        }

        ?>
        <form class="form" id="pmConversionRequestForm" action="<?php echo base_url() ?>projects/pmConversionRequest"
          method="get" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">File Name</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" value="<?= $file_name ?>" name="file_name">

              </div>

              <label class="col-lg-2 control-label" for="role name">Task Type</label>
              <div class="col-lg-3">
                <select name="task_type" class="form-control m-b" id="task_type" />
                <option disabled="disabled" selected="">Select Task Type</option>
                <?php echo $this->projects_model->selectConversionTaskType($task_type); ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
              </div>

              <label class="col-lg-2 control-label" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>
            </div>



            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search"
                    onclick="var e2 = document.getElementById('pmConversionRequestForm'); e2.action='<?= base_url() ?>projects/pmConversionRequest'; e2.submit();"
                    type="submit">Search</button>
                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('pmConversionRequestForm'); e2.action='<?= base_url() ?>projects/exportPmConversionRequest'; e2.submit();"
                    name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
                    Excel</button>
                  <a href="<?= base_url() ?>projects/pmConversionRequest" class="btn btn-warning"><i
                      class="la la-trash"></i>Clear Filter</a>

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
          <h3 class="card-label">PM Conversion Requests</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>projects/addPmConversionRequest" class="btn btn-primary font-weight-bolder">
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
            </span>Add Conversion Request</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>File Name</th>
              <th>Task Type</th>
              <th>Attachment Type</th>
              <th>Attachment</th>
              <th>Link</th>
              <th>Status</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>View Request</th>
              <!--<th>Edit</th> -->
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pm_conversion_requests->result() as $row) { ?>
              <tr class="">
                <td>
                  <?= $row->id ?>
                </td>
                <td>
                  <?= $row->file_name ?>
                </td>
                <td>
                  <?= $this->projects_model->getConversionTaskType($row->task_type) ?>
                </td>
                <td>
                  <?= $row->attachment_type == 1 ? "Attachment" : "Link" ?>
                </td>
                <td>
                  <?= $row->attachment ?>
                </td>
                <td><a>
                    <?= $row->link ?>
                  </a></td>
                <td>
                  <?php if ($row->status == 1) {
                    echo "Running";
                  } elseif ($row->status == 2) {
                    echo "Closed";
                  } elseif ($row->status == 3) {
                    echo "Faild";
                  } ?>

                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?= $row->created_at ?>
                </td>
                <td>
                  <a href="<?php echo base_url() ?>projects/viewPmConversionRequest?t=<?php echo
                       base64_encode($row->id); ?>" class="">
                    <i class="fa fa-eye"></i> View Request
                  </a>
                </td>
                <!--                <td>
                   <?php if ($permission->edit == 1) { ?>
                    <?php if ($row->status == 1) { ?>
                      <a href="<?php echo base_url() ?>projects/editPmConversionRequest?t=<?php echo
                           base64_encode($row->id); ?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                    <?php } ?>
                  <?php } ?>
                </td> -->

                <td>
                  <?php if ($permission->delete == 1) { ?>
                    <a href="<?php echo base_url() ?>projects/deletePmConversionRequest?t=<?php echo
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