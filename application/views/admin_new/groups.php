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


      <!--begin::Card-->
      <div class="card">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">Groups</h3>
          </div>
          <div class="card-toolbar">

            <!--begin::Button-->
            <?php if ($permission->add == 1) { ?>
              <a href="<?= base_url() ?>admin/addGroup" class="btn btn-primary font-weight-bolder">
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
              </span>Add New Group</a>
            <!--end::Button-->
          </div>
        </div>
        <div class="card-body">
          <!--begin: Datatable-->
          <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Icon</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($groups->num_rows() > 0) {
                foreach ($groups->result() as $row) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $row->id; ?>
                    </td>
                    <td>
                      <?php echo $row->name; ?>
                    </td>
                    <td>
                      <?php echo $row->icon; ?>
                    </td>
                    <td>
                      <?php if ($permission->edit == 1) { ?>
                        <a href="<?php echo base_url() ?>admin/editGroup?t=<?php echo base64_encode($row->id); ?>" class="">
                          <i class="fa fa-pencil"></i> Edit
                        </a>
                      <?php } ?>
                    </td>

                    <td>
                      <?php if ($permission->delete == 1) { ?>
                        <a href="<?php echo base_url() ?>admin/deleteGroup/<?php echo $row->id ?>" title="delete" class=""
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
                <td colspan="7">There is no groups to list</td>
              </tr>
              <?php
              }
              ?>
            </tbody>

          </table>

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