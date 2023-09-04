<!-- employees birth days start -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <header class="panel-heading">
        <button id="button_filter" onclick="showAndHide('filter','button_filter');"
          style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;"
          class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
        Birthsdays This Month <span class="numberCircle"><span>
            <?= $birthdayData->num_rows() ?>
          </span></span><img
          src="https://www.animatedimages.org/data/media/296/animated-festivity-and-celebration-image-0166.gif"
          style="padding:5px;width:60px;height:60px;">
      </header>
      <div id="filter" class="panel-body" style="overflow:scroll; display: none;">
        <table class="table table-striped table-hover table-bordered" id="">
          <thead>
            <tr>
              <th> Name</th>
              <th>Birth Date</th>
            </tr>
          </thead>

          <tbody>
            <?php
            if ($birthdayData->num_rows() > 0) {
              foreach ($birthdayData->result() as $row) { ?>
                <tr class="">
                  <td>
                    <?php echo $row->name; ?>
                  </td>
                  <td>
                    <?php echo $row->birth_date; ?>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="7">There is No Bitrth Days This Month </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>

      <header class="panel-heading">
        <button id="button_contract" onclick="showAndHide('contract','button_contract');"
          style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;"
          class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
        Contracts Notifications <span class="numberCircle"><span>
            <?= $contractData->num_rows() ?>
          </span></span>
      </header>
      <div id="contract" class="panel-body" style="overflow:scroll; display: none;">
        <table class="table table-striped table-hover table-bordered" id="">
          <thead>
            <tr>
              <th> Name</th>
              <th>Contract Date</th>
              <th>Num. Of Days Left</th>
            </tr>
          </thead>

          <tbody>
            <?php
            if ($contractData->num_rows() > 0) {
              foreach ($contractData->result() as $row) {
                ?>
                <tr class="">

                  <td>
                    <?php echo $row->name; ?>
                  </td>
                  <td>
                    <?php echo $row->contract_date; ?>
                  </td>
                  <td>
                    <?php echo $row->days; ?>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="7">There is No Contracts Coming In Next 10 Days </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>

<!-- employees birth days end -->

<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        Employees Filter
      </header>
      <?php
      if (!empty($_REQUEST['name'])) {
        $name = $_REQUEST['name'];

      } else {
        $name = "";
      }

      if (!empty($_REQUEST['title'])) {
        $title = $_REQUEST['title'];

      } else {
        $title = "";
      }

      if (!empty($_REQUEST['division'])) {
        $division = $_REQUEST['division'];

      } else {
        $division = "";
      }

      if (!empty($_REQUEST['department'])) {
        $department = $_REQUEST['department'];

      } else {
        $department = "";
      }

      if (!empty($_REQUEST['status'])) {
        $status = $_REQUEST['status'];

      } else {
        $status = "";
      }
      ?>

      <div class="panel-body">
        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>hr/employees" method="get" id="employees"
          enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="name">Name</label>

            <div class="col-lg-3">
              <input type="text" class="form-control" value="<?= $name ?>" name="name">
            </div>

            <label class="col-lg-2 control-label" for="role name">Position</label>

            <div class="col-lg-3">
              <select name="title" class="form-control m-b" id="title">
                <option value="">-- Select Title --</option>
                <?= $this->hr_model->selectTitle($title) ?>
              </select>
            </div>

          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="role name">Division</label>

            <div class="col-lg-3">
              <select name="division" onchange="getDepartment()" class="form-control m-b" id="division">
                <option value="">-- Select Division --</option>
                <?= $this->hr_model->selectDivision($division) ?>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role name">Function</label>

            <div class="col-lg-3">
              <select name="department" class="form-control m-b" id="department">
                <option disabled="disabled" selected=""></option>
                <?= $this->hr_model->selectDepartment($department) ?>
              </select>
            </div>

          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="Employee Status">Employee Status</label>

            <div class="col-lg-3">
              <select name="status" onchange="showResignedSearch()" class="form-control m-b" id="status">
                <option value="">-- Select Status --</option>
                <?php
                if ($_REQUEST['status'] != NULL && $_REQUEST['status'] == 0) { ?>
                  <option selected="" value="0">Working</option>
                  <option value="1">Resigned</option>
                <?php } elseif ($_REQUEST['status'] != NULL && $_REQUEST['status'] == 1) { ?>
                  <option value="0">Working</option>
                  <option selected="" value="1">Resigned</option>
                <?php } else { ?>
                  <option value="0">Working</option>
                  <option value="1">Resigned</option>

                <?php } ?>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role name">Social Insurance</label>

            <div class="col-lg-3">
              <select name="social_ins" class="form-control m-b" id="social_ins">
                <option disabled="disabled" selected=""></option>
                <option value="1" <?= isset($social_ins) && $social_ins == '1' ? "selected" : '' ?>>Yes</option>
                <option value="0" <?= isset($social_ins) && $social_ins == '0' ? "selected" : '' ?>>No</option>

              </select>
            </div>
          </div>
          <div class="form-group" style="display: none;" id="resignedSearch">
            <label class="col-lg-2 control-label" for="role date">Resigned From</label>
            <div class="col-lg-3">
              <input class="form-control date_sheet" type="text" name="resigned_from" autocomplete="off">
            </div>
            <label class="col-lg-2 control-label" for="role date">Resigned To</label>
            <div class="col-lg-3">
              <input class="form-control date_sheet" type="text" name="resigned_to" autocomplete="off">
            </div>
          </div>


          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button>
              <button class="btn btn-success"
                onclick="var e2 = document.getElementById('employees'); e2.action='<?= base_url() ?>hr/exportEmployees'; e2.submit();"
                name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
              <a href="<?= base_url() ?>hr/employees" class="btn btn-warning">(x) Clear Filter</a>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        Employees
      </header>
      <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success" role="alert">
          <span class="fa fa-check-circle"></span>
          <span><strong>
              <?= $this->session->flashdata('true') ?>
            </strong>
          </span>
        </div>
      <?php } ?>
      <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
          <span class="fa fa-warning"></span>
          <span><strong>
              <?= $this->session->flashdata('error') ?>
            </strong>
          </span>
        </div>
      <?php } ?>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow:scroll;">
          <div class="clearfix">
            <div class="btn-group">
              <?php if ($permission->add == 1) { ?>
                <a href="<?= base_url() ?>hr/addEmployees" class="btn btn-primary ">Add New Employee</a>
                </br></br>
                </br>
              <?php } ?>
            </div>

          </div>

          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th colspan="6" style="text-align: center; background: #2980B9;">Employee Data</th>
                <th colspan="15" style="text-align: center; background: #7FB3D5;">Positioning Data </th>
                <th colspan="3" style="text-align: center; background: #D4E6F1 ;">Communication info</th>
              </tr>

              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>National ID/Passport ID</th>
                <th>Brand</th>
                <th>Division</th>
                <th>Function</th>
                <th>Position</th>
                <th>Direct Manager</th>
                <th>Time Zone</th>
                <th>Office Location</th>
                <th>Hiring Date</th>
                <th>Probationay Period</th>
                <th>Contract Date</th>
                <th>Contract Type</th>
                <th>Workplace Model</th>
                <th>Employee Status</th>
                <th>Resignation Date</th>
                <th>Resignation Reason</th>
                <th>Resignation Comment</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Emergency Contact</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>

              </tr>
            </thead>

            <tbody>
              <?php
              if (($employees->num_rows()) > 0) {
                foreach ($employees->result() as $row) {
                  ?>
                  <tr class="">
                    <td>
                      <?php echo $row->id; ?>
                    </td>
                    <td>
                      <?php echo $row->name; ?>
                    </td>
                    <td>
                      <?php echo $row->birth_date; ?>
                    </td>
                    <td>
                      <?php if ($row->gender == 1) {
                        echo "Male";
                      } else {
                        echo "Female";
                      } ?>
                    </td>
                    <td>
                      <?php echo $row->national_id; ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getBrand($row->brand); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDivision($row->division); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDepartment($row->department); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getTitle($row->title); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getEmployee($row->manager); ?>
                    </td>
                    <td>
                      <?php echo $row->time_zone; ?>
                    </td>
                    <td>
                      <?php echo $row->office_location; ?>
                    </td>
                    <td>
                      <?php echo $row->hiring_date; ?>
                    </td>
                    <td>
                      <?php echo $row->prob_period; ?>
                    </td>
                    <td>
                      <?php echo $row->contract_date; ?>
                    </td>
                    <td>
                      <?php if ($row->contract_type == 1) {
                        echo "Full Time";
                      } else if ($row->contract_type == 2) {
                        echo "Part Time";
                      } ?>
                    </td>
                    <td>
                      <?= $row->workplace_model; ?>
                    </td>
                    <td>
                      <?php if ($row->status == 0) {
                        echo "Working";
                      } else if ($row->status == 1) {
                        echo "Resigned";
                      } ?>
                    </td>
                    <td>
                      <?php echo $row->resignation_date; ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getResignationReason($row->resignation_reason); ?>
                    </td>
                    <td>
                      <?php echo $row->resignation_comment; ?>
                    </td>
                    <td>
                      <?php echo $row->email; ?>
                    </td>
                    <td>
                      <?php echo $row->phone; ?>
                    </td>
                    <td>
                      <?php echo $row->emergency; ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                    </td>
                    <td>
                      <?php echo $row->created_at; ?>
                    </td>
                    <td>
                      <?php if ($permission->edit == 1) { ?>
                        <a href="<?php echo base_url() ?>hr/editEmployees?t=<?php echo base64_encode($row->id); ?>" class="">
                          <i class="fa fa-pencil"></i> Edit
                        </a>
                      <?php } ?>
                    </td>

                    <td>
                      <?php if ($permission->delete == 1) { ?>
                        <a href="<?php echo base_url() ?>hr/deleteEmployees/<?php echo $row->id ?>" title="delete" class=""
                          onclick="return confirm('Are you sure you want to delete this Employee?');">
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
                  <td colspan="7">There is no Employee to list</td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
          <nav class="text-center">
            <?= $this->pagination->create_links() ?>
          </nav>

        </div>
      </div>
    </section>
  </div>
</div>
<script type="text/javascript">

  function showResignedSearch() {

    $('#resignedSearch').show();

  }
</script>