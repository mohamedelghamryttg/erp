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
          <h3 class="card-title">Search Vendor Account</h3>
        </div>

        <form class="form" id="vendorAccount" action="<?php echo base_url() ?>admin/vendorsAccounts" method="get" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Email</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" value="<?= $email ?? ''; ?>" name="email">

              </div>

            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" onclick="var e2 = document.getElementById('vendorAccount'); e2.action='<?= base_url() ?>admin/vendorsAccounts'; e2.submit();" type="submit">Search</button>
                  <a href="<?= base_url() ?>admin/vendorsAccounts" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a>

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
          <h3 class="card-label">Vendors Accounts</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->

        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Password</th>
              <th>First Login</th>
              <th>Account Status</th>
              <th>View</th>

            </tr>
          </thead>
          <tbody>
            <?php
            if ($vendorsAccounts->num_rows() > 0) {
              foreach ($vendorsAccounts->result() as $row) {
            ?>
                <tr class="">
                  <td><?php echo $row->id; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->email; ?></td>
                  <td><?php echo base64_decode($row->password); ?></td>
                  <td><?php echo $row->first_login; ?></td>
                  <td><?php if ($row->status == 0) {
                        echo "Active";
                      } elseif ($row->status == 1) {
                        echo "Deactive";
                      } ?></td>
                  <td>
                    <?php if ($permission->view == 1) { ?>
                      <a href="<?php echo base_url() ?>admin/viewVendorAccount?t=<?php echo base64_encode($row->id); ?>" class="">
                        <i class="fa fa-pencil"></i> View
                      </a>
                    <?php } ?>
                  </td>
                <?php
              }
            } else {
                ?>
                <tr>
                  <td colspan="7">There is no users to list</td>
                </tr><?php
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