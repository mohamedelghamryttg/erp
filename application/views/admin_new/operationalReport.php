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
          <h3 class="card-title">Date Filter</h3>
        </div>

        <form class="form" id="report" action="<?php echo base_url() ?>admin/languages" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

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

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Report Name</label>
              <div class="col-lg-3">
                <select name="report" class="form-control m-b" id="report" required />
                <option disabled="disabled" selected="selected" value="">-- Select Report --</option>
                <?php
                if ($_REQUEST['report'] == 1) { ?>
                  <option selected="" value="<?= $_REQUEST['report'] ?>">By PM</option>
                  <option value="2">By SAM</option>
                  <option value="3">By Customer</option>
                  <option value="4">SAM Activities</option>
                <?php } elseif ($_REQUEST['report'] == 2) { ?>
                  <option selected="" value="<?= $_REQUEST['report'] ?>">By SAM</option>
                  <option value="1">By PM</option>
                  <option value="3">By Customer</option>
                  <option value="4">SAM Activities</option>
                <?php } elseif ($_REQUEST['report'] == 3) { ?>
                  <option selected="" value="<?= $_REQUEST['report'] ?>">By Customer</option>
                  <option value="1">By PM</option>
                  <option value="2">By SAM</option>
                  <option value="4">SAM Activities</option>
                <?php } elseif ($_REQUEST['report'] == 4) { ?>
                  <option selected="" value="<?= $_REQUEST['report'] ?>">SAM Activities</option>
                  <option value="1">By PM</option>
                  <option value="2">By SAM</option>
                  <option value="3">By Customer</option>
                <?php } else { ?>
                  <option value="1">By PM</option>
                  <option value="2">By SAM</option>
                  <option value="3">By Customer</option>
                  <option value="4">SAM Activities</option>

                <?php } ?>
                </select>

              </div>

            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search"
                    onclick="var e2 = document.getElementById('report'); e2.action='<?= base_url() ?>admin/operationalReport'; e2.submit();"
                    type="submit">Search</button>
                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('report'); e2.action='<?= base_url() ?>admin/exportOperationalReport'; e2.submit();"
                    name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To
                    Excel</button>
                  <a href="<?= base_url() ?>admin/operationalReport" class="btn btn-warning"><i
                      class="la la-trash"></i>Clear Filter</a>

                </div>
              </div>
            </div>
        </form>
      </div>

      <!-- end search form -->

      <!-- By PM -->
      <?php if ($report == 1) { ?>

        <div class="card-body">

          <!--begin: Datatable-->
          <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
            <thead>
              <tr>
                <th>ID</th>
                <th>Language</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>

              </tr>
            </thead>
            <tbody>
              <?php
              if (count($languages->num_rows()) > 0) {
                foreach ($languages->result() as $row) {
                  ?>
                  <tr class="">
                    <td>
                      <?php echo $row->id; ?>
                    </td>
                    <td>
                      <?php echo $row->name; ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                    </td>
                    <td>
                      <?= $row->created_at ?>
                    </td>
                    <td>
                      <?php if ($permission->edit == 1) { ?>
                        <a href="<?php echo base_url() ?>admin/editLanguage?t=<?php echo base64_encode($row->id); ?>" class="">
                          <i class="fa fa-pencil"></i> Edit
                        </a>
                      <?php } ?>
                    </td>

                    <td>
                      <?php if ($permission->delete == 1) { ?>
                        <a href="<?php echo base_url() ?>admin/deleteLanguage/<?php echo $row->id ?>" title="delete" class=""
                          onclick="return confirm('Are you sure you want to delete this user?');">
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
                <td colspan="7">There is no Languages to list</td>
              </tr>
              <?php
              }
              ?>
            </tbody>

          </table>
          <!--end: Datatable-->
        </div>
      <?php } ?>
    </div>
    <!--end::Card-->
  </div>
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->