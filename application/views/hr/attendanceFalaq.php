<!-- requests view for parent -->
<?php
$title = $this->db->query(" SELECT title FROM employees WHERE id = '$this->emp_id' ")->row()->title;
if ($title == 11 or $title == 15 or $title == 16 or $title == 17 or $title == 28 or $title == 37 or $title == 40 or $title == 44 or $title == 48 or $title == 51 or $title == 54 or $title == 56 or $title == 59 or $title == 77 or $title == 93 or $title == 96 or $title == 97 or $title == 98 or $title == 100 or $title == 101 or $title == 104 or $title == 108 or $title == 107 or $title == 41 or $title == 122 or $title == 25 or $title == 123 or $title == 126 or $title == 125 or $title == 131 or $title == 146 or $title == 148 or $title == 163 or $title == 173 or $title == 135 or ($title == 42 and $this->admin_model->checkIfUserIsManager($this->user))) {
  $start_date = date("Y-m-d", strtotime("-45 days"));
  $end_date = date("Y-m-d", strtotime("+1 day"));
  $data = $this->hr_model->getMissingAttendanceRequests($this->emp_id, $title, $start_date, $end_date)->result();

  ?>
  <div class="row">
    <div class="col-sm-12">
      <section class="panel">
        <header class="panel-heading">
          <button id="missing_requests" onclick="showAndHide('missing_requests_filter','missing_requests');"
            style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;"
            class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
          Pending Approval Requests <span class="numberCircle" style="line-height: 20px">
            <?php echo count($data) ?>
          </span>
        </header>

        <div id="missing_requests_filter" style="display: none;" class="panel-body">
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" id="approval" style="overflow:scroll;">
            <thead>

              <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Date </th>
                <th>Sign In/Out</th>
                <th>Manager Approval</th>
                <!--<th>Hr Approval</th>-->
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $row) { ?>
                <tr>
                  <td>
                    <?= $row->id ?>
                  </td>
                  <td>
                    <?= $row->USRID ?>
                  </td>
                  <td>
                    <?= $this->hr_model->getEmployee($row->USRID) ?>
                  </td>
                  <td>
                    <?= $row->SRVDT ?>
                  </td>
                  <?php if ($row->TNAKEY == 1) {
                    ?>
                    <td>
                      <?php echo "Sign In"; ?>
                    </td>
                  <?php } elseif ($row->TNAKEY == 2) {
                    ?>
                    <td>
                      <?php echo "Sign Out"; ?>
                    </td>
                    <?php
                  } ?>

                  <?php if ($title == 37 or $title == 123) { ?>

                    <td>
                      <?= $this->hr_model->getVacationStatus($row->manager_approval); ?>
                    </td>
                  <?php } else { ?>
                    <?php if ($row->manager_approval == 0) { ?>
                      <td rowspan="" style="border: 1px solid #ddd;"><a href="#managerModal<?php echo $row->id ?>"
                          data-toggle="modal" class="btn btn-success">Manager Approval</a></td>
                    <?php } else { ?>
                      <td>
                        <?= $this->hr_model->getVacationStatus($row->manager_approval); ?>
                      </td>
                    <?php } ?>

                    <!--<td><?= $this->hr_model->getVacationStatus($row->hr_approval); ?></td>-->
                  <?php } ?>
                </tr>
                <!-- start manager pop up form -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                  id="managerModal<?php echo $row->id; ?>" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Manager Approval</h4>
                      </div>
                      <div class="modal-body">

                        <div class="form-group">
                          <label class="col-lg-4 control-label" style="padding: 9px ; margin: 5px;" for="role name">Manager
                            Action</label>
                          <input name="id" id="id_<?= $row->id ?>" type="hidden" value="<?php echo $row->id; ?>">

                          <div class="col-lg-7" style="padding: 5px ; margin: 5px;">
                            <select name="manager_approval" id="manager_approval_<?= $row->id ?>"
                              class="form-control m-b" />
                            <option value="">-- Select status --</option>
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                            </select>
                          </div>
                        </div>
                        <button class="btn btn-danger  btn-block" type="submit" aria-hidden="true" data-dismiss="modal"
                          class="close" onclick="missingAttendanceApprovalForManager(<?= $row->id ?>)">Submit</button>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- end pop up form -->


              <?php } ?>

            </tbody>
          </table>

        </div>
      </section>
    </div>
  </div>
  <!-- -->
<?php } ?>


<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        Filter
      </header>

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

      <div class="panel-body">
        <form class="cmxform form-horizontal " id="attendance" action="<?php echo base_url() ?>hr/attendance"
          method="post" enctype="multipart/form-data">
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

              <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required=""
                value="<?= $_REQUEST['date_from'] ?? '' ?>">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
              <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required=""
                value="<?= $_REQUEST['date_to'] ?? '' ?>">
            </div>

          </div>

          <?php if ($permission->view == 1) { ?>


            <?php if ($this->role == 12) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->customer_model->selectSamEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>


            <?php if ($this->role == 15) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->accounting_model->selectAccountantEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>


            <?php if ($this->role == 16) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->projects_model->selectPmEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>


            <?php if ($this->role == 24) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->admin_model->selectDtpEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>


            <?php if ($this->role == 28) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->admin_model->selectTranslatorEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>


            <?php if ($this->role == 26) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->admin_model->selectLeEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>

            <?php if ($this->role == 32) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->vendor_model->selectVmEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>

            <?php if ($this->role == 22) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" required="" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->admin_model->selectMarketingEmployeeId() ?>
                  </select>
                </div>
              </div>

            <?php } ?>



            <?php if ($this->role == 1 or $this->role == 21 or $this->role == 31 or $this->role == 46) { ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
                <div class="col-lg-3">
                  <select name="user" class="form-control m-b" id="user" />
                  <option value="">-- Select Employee --</option>
                  <?= $this->hr_model->selectEmployee($_REQUEST['user'] ?? '') ?>
                  </select>
                </div>

                <label class="col-lg-2 control-label" for="role name">Function</label>
                <div class="col-lg-3">
                  <select name="department" class="form-control m-b" id="department" />
                  <option value="" selected="">-- Select Department --</option>
                  <?= $this->hr_model->selectDepartmentKpi($department) ?>
                  </select>
                </div>


              <?php } ?>


            <?php } ?>



            <div class="form-group">
              <div class="col-lg-offset-3 col-lg-6" style="margin-top:20px">
                <button class="btn btn-primary btn-sm font-weight-bold" name="search" type="submit">Search</button>
                <?php if ($permission->add == 1) { ?>
                  <a href="<?= base_url() ?>hr/remoteAccess" class="btn bg-primary btn-sm font-weight-bold">Remote
                    Access</a>
                  <a href="<?= base_url() ?>hr/missingAttendance" class="btn btn-danger btn-sm font-weight-bold">Missing
                    Attendance</a>
                  <button class="btn btn-success btn-sm font-weight-bold"
                    onclick="var e2 = document.getElementById('attendance'); e2.action='<?= base_url() ?>hr/exportAttendanceLog'; e2.submit();"
                    name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                  <a href="<?= base_url() ?>hr/timeSheet" class="btn btn-primary btn-sm font-weight-bold"><i
                      class="fa fa-clock-o" aria-hidden="true"></i> Time Sheet</a>
                <?php } ?>
              </div>
            </div>
        </form>
      </div>
    </section>
  </div>
</div>
<?php if (isset($_POST['search'])) { ?>
  <div class="row">
    <div class="col-sm-12">
      <section class="panel">

        <header class="panel-heading">
          Attendance Log
        </header>

        <div class="panel-body">
          <div class="adv-table editable-table " style="overflow-y: scroll;">
            <div class="clearfix">
            </div>
            <div class="space15"></div>

            <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
              <thead>
                <tr>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Sign In</th>
                  <th>Sign Out</th>
                  <th>Location</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($attendance as $row) {
                  $signin = $this->db->query("SELECT id FROM attendance_log AS log WHERE log.USRID = " . $row->USRID . " AND TNAKEY = '1' AND SRVDT = '" . $row->SignIn . "' ORDER BY log.id ASC LIMIT 1")->row();
                  $signOut = $this->db->query("SELECT SRVDT,id FROM attendance_log AS log WHERE log.USRID = " . $row->USRID . " AND TNAKEY = '2' AND
                                        ((log.SRVDT BETWEEN '" . $row->SignIn . "' AND DATE_ADD('" . $row->SignIn . "', INTERVAL 18 hour)) AND log.SRVDT > '" . $row->SignIn . "') ORDER BY log.id DESC LIMIT 1")->row();
                  ?>
                  <tr>
                    <td>
                      <?= $row->USRID ?>
                    </td>
                    <td>
                      <?= $this->hr_model->getEmployee($row->USRID) ?>
                    </td>
                    <td>
                      <?= $row->SignIn ?>
                    </td>
                    <td>
                      <?= $signOut->SRVDT ?? '' ?>
                    </td>
                    <td>
                      <?= $this->hr_model->checkAttendanceLocation($signin->id ?? '', $signOut->id ?? '') ?? '' ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
<?php } ?>