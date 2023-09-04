<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
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

      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Logger</h3>
        </div>

        <form class="form" id="customerfilter" action="<?php echo base_url() ?>admin/listUserActivity" method="post"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Table Name</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="table_name" value="<?= $table_name ?? '' ?>">

              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Screen</label>
              <div class="col-lg-3">
                <select name="screen" class="form-control m-b" id="screen">
                  <option value="" selected="selected">-- Select Screen --</option>
                  <?= $this->admin_model->selectScreen($screen ?? '') ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Select Type</label>
              <div class="col-lg-3">
                <select name="type" class="form-control m-b" id="type">
                  <option value="">-- Select Type --</option>

                  <option value="1" <?= (isset($type) && $type == 1) ? 'selected' : '' ?>>Update</option>
                  <option value="2" <?= (isset($type) && $type == 2) ? 'selected' : '' ?>>Delete</option>
                  <option value="5" <?= (isset($type) && $type == 5) ? 'selected' : '' ?>>Restore</option>

                </select>
              </div>
              <label class="col-lg-2 col-form-label text-lg-right">Created by</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" />
                <option value="">-- Select --</option>
                <?= $this->admin_model->SelectAllUsers($created_by ?? '') ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" value="<?= $date_from ?? '' ?>"
                  autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" value="<?= $date_to ?? '' ?>"
                  autocomplete="off">
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit" value="search"><i
                      class="la la-search"></i>Search</button>
                  <button class="btn btn-warning mr-2" name="submitReset" type="submit" value="submitReset"><i
                      class="la la-trash"></i>Clear
                    Filter</button>

                  <!-- <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>admin/listUserActivity" class="btn btn-warning"><i
                      class="la la-trash"></i>Clear Filter</a> -->

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
          <h3 class="card-label">All Data</h3>
        </div>

      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>

              <th>ID</th>
              <th>Screen</th>
              <th>Table Name</th>
              <th>transaction ID </th>
              <th>Type</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Data</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($logger)) {
              foreach ($logger->result() as $row) {
                ?>
                <tr>

                  <td>
                    <?= $row->id ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getScreenName($row->screen); ?>
                  </td>
                  <td>
                    <?= $row->table_name ?>
                  </td>
                  <td>
                    <?= $row->transaction_id_name . " => " . $row->transaction_id ?>
                  </td>
                  <td>
                    <?php if ($row->type == 1)
                      echo 'Update';
                    elseif ($row->type == 2)
                      echo 'Delete';
                    elseif ($row->type == 5)
                      echo 'Restore';
                    ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td>
                    <?php echo $row->created_at; ?>
                  </td>
                  <td><code style="white-space: normal;"><?= $row->data ?></code></td>
                  <td>
                    <?php if ($row->type == 2 && $row->parent_id == 0 && $permission->delete == 1) { ?>
                      <a href="<?= base_url() . 'admin/userLoggerRestoreData/' . $row->id ?>" class="btn p-2 btn-dark"
                        onclick="return confirm('Warning!!! Are you sure you want to Restore this data ?');"><i
                          class="fa fa-recycle"></i> Restore</a>
                    <?php } ?>
                  </td>

                </tr>
              <?php }
            } ?>
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