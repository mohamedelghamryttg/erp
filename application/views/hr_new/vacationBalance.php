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

  <!-- <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

      <div class="d-flex align-items-center mr-1">

      </div>


    </div>
  </div> -->
  <!--end::Subheader-->

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Employee Balance</h3>
        </div>
        <?php
        if (isset($_REQUEST['year'])) {
          $year = $_REQUEST['year'];
        } else {
          $year = "";
        }
        if (isset($_REQUEST['employee_name'])) {
          $employee_name = $_REQUEST['employee_name'];
        } else {
          $employee_name = "";
        }
        ?>
        <form class="form" id="vacationBalanceFilter" action="<?php echo base_url() ?>hr/vacationBalance" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Year:</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="year" value="<?= $year ?>" />
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Employee Name :</label>

              <div class="col-lg-4">
                <select name="employee_name" class="form-control m-b" id="employee_name" />
                <option value="">-- Select Employee --</option>
                <?= $this->hr_model->selectEmployee($employee_name) ?>
                </select>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit"
                    onclick="var e2 = document.getElementById('vacationBalanceFilter'); e2.action='<?= base_url() ?>hr/vacationBalance'; e2.submit();">Search</button>
                  <a href="<?= base_url() ?>hr/vacationBalance" class="btn btn-warning"><i class="la la-trash"></i>Clear
                    Filter</a>

                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('vacationBalanceFilter'); e2.action='<?= base_url() ?>hr/exportVacationBalance'; e2.submit();"
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
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Vacation Balance </h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>hr/addVacationBalance" class="btn btn-primary font-weight-bolder">

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
              </span>Add New Vacation Balance</a>
          <?php } ?>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">

          <thead>
            <tr>
              <th>#ID</th>
              <th>Employee</th>
              <th>Remaining Balance</th>
              <th>Remaining Previous Year Balance</th>
              <!-- <th>Double Days Balance</th>-->
              <th>Annual Leave</th>
              <th>Casual Leave</th>
              <th>Avalible Sick Leave</th>
              <th>Marriage</th>
              <th>Maternity Leave</th>
              <th>Death Leave</th>
              <th>Rest Leave</th>
              <th>Year</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vacation_balance->result() as $row) {
              $restLeave = $this->db->query("SELECT sum(`requested_days`) as days FROM `vacation_transaction` WHERE emp_id = '$row->emp_id' AND type_of_vacation=8")->row()->days;
              ?>
              <tr>
                <td>
                  <?= $row->id ?>
                </td>
                <td>
                  <?= $this->db->query("SELECT name FROM employees WHERE id = '$row->emp_id'")->row()->name; ?>
                </td>
                <td>
                  <?= $row->current_year ?>
                </td>
                <td>
                  <?= $row->previous_year ?>
                </td>
                <!--<td><?= $row->double_days ?></td>-->
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=1&search="
                    target="_blank"><?= $row->annual_leave ?></a></td>
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=2&search="
                    target="_blank"><?= $row->casual_leave ?></a></td>
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=3&search="
                    target="_blank"><?= $row->sick_leave ?></a></td>
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=4&search="
                    target="_blank"><?= $row->marriage ?></a></td>
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=5&search="
                    target="_blank"><?= $row->maternity_leave ?></a></td>
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=6&search="
                    target="_blank"><?= $row->death_leave ?></a></td>
                <td><a
                    href="<?php echo base_url() ?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=8&search="
                    target="_blank"><?= $restLeave ?? 0 ?></a></td>
                <td>
                  <?= $row->year ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>hr/editVacationBalance?i=<?php echo base64_encode($row->id); ?>"
                      class="btn btn-sm btn-clean btn-icon">
                      <i class="la la-edit"></i>
                    </a>
                  <?php } ?>
                </td>

                <td>
                  <?php if ($permission->delete == 1) { ?>
                    <a href="<?php echo base_url() ?>hr/deleteVacationBalance?i=<?php echo base64_encode($row->id); ?>"
                      title="delete" class="btn btn-sm btn-clean btn-icon"
                      onclick="return confirm('Are you sure you want to delete this Employee ?');">
                      <i class="la la-trash"></i>
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