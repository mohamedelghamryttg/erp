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
    <div class="container">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title"> Medical Insurance Filter </h3>
        </div>
        <?php
        if (!empty($_REQUEST['employee_id'])) {
          $employee_id = $_REQUEST['employee_id'];

        } else {
          $employee_id = "";
        }

        ?>
        <form class="form" action="<?php echo base_url() ?>hr/medicalInsurance" method="get" id="medical_insurance"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">
              <label class="col-lg-2 control-label text-lg-right" for="role name">Employee Name :</label>

              <div class="col-lg-3">
                <select name="employee_id" class="form-control " />
                <option value="">-- Select Employee --</option>
                <?= $this->hr_model->selectEmployee(0) ?>
                </select>


              </div>

            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>hr/medicalInsurance" class="btn btn-warning"><i
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
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label"> Medical Insurance</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>hr/addMedicalInsurance" class="btn btn-primary font-weight-bolder">

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
              </span>Add New Medical Insurance</a>
          <?php } ?>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Employee Name</th>
              <th>Year</th>
              <th>CRT</th>
              <th>Activation Date</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($medical->num_rows() > 0) {
              foreach ($medical->result() as $row) {
                ?>

                <tr>
                  <td rowspan="2">
                    <?php echo $row->id; ?>
                  </td>
                  <td>
                    <?php echo $this->hr_model->getEmployee($row->employee_id); ?>
                  </td>
                  <td>
                    <?php echo $this->hr_model->getYear($row->year); ?>
                  </td>
                  <td>
                    <?php echo $row->crt; ?>
                  </td>
                  <td>
                    <?php echo $row->activation_date; ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td>
                    <?php echo $row->created_at; ?>
                  </td>
                  <td>
                    <?php if ($permission->edit == 1) { ?>
                      <a href="<?php echo base_url() ?>hr/editMedicalInsurance?t=<?php echo base64_encode($row->id); ?>"
                        class="btn btn-sm btn-clean btn-icon">
                        <i class="la la-edit"></i>
                      </a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($permission->delete == 1) { ?>
                      <a href="<?php echo base_url() ?>hr/deleteMedicalInsurance?t=<?= base64_encode($row->id) ?>&e=<?= base64_encode($row->employee_id) ?>"
                        title="delete" class="btn btn-sm btn-clean btn-icon"
                        onclick="return confirm('Are you sure you want to delete this Member?');">
                        <i class="la la-trash"></i>
                      </a>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <table class="table table-striped table-hover table-bordered">
                      <thead>
                        <th>ID</th>
                        <th>Member Name</th>
                        <th>Date of Birth</th>
                        <th>Activation Date</th>
                        <th>Type</th>
                        <th>Annual fees</th>
                      </thead>
                      <tbody>
                        <?php
                        $member = $this->db->get_where('medical_family_members', array('employee_id' => $row->employee_id));
                        foreach ($member->result() as $member) {

                          ?>

                          <tr>
                            <td>
                              <?php echo $member->id; ?>
                            </td>
                            <td>
                              <?php echo $member->name; ?>
                            </td>
                            <td>
                              <?php echo $member->birth_date; ?>
                            </td>
                            <td>
                              <?php echo $member->activation_date; ?>
                            </td>
                            <td>
                              <?php if ($member->type == 1) {
                                echo "Supose";
                              } else if ($member->type == 2) {
                                echo "Child";
                              } ?>
                            </td>
                            <td>
                              <?php echo $member->fees; ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="7">There is no Medical Insurance to list</td>
              </tr>
              <?php
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
<!--end::Content-->