<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        Department Filter
      </header>

      <?php
      if (!empty($_REQUEST['division'])) {
        $division = $_REQUEST['division'];

      } else {
        $division = "";
      }

      if (!empty($_REQUEST['name'])) {
        $name = $_REQUEST['name'];

      } else {
        $name = "";
      }


      ?>

      <div class="panel-body">
        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>hr/department" method="get"
          id="departments" enctype="multipart/form-data">

          <div class="form-group">
            <label class="col-lg-2 control-label" for="name">Department</label>

            <div class="col-lg-3">
              <input type="text" class="form-control" value="<?= $name ?>" name="name">
            </div>

            <label class="col-lg-2 control-label" for="role name">Division</label>

            <div class="col-lg-3">
              <select name="division" class="form-control m-b" id="division" />
              <option value="">-- Select Division --</option>
              <?= $this->hr_model->selectDivision($division) ?>
              </select>
            </div>

          </div>

          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search"
                onclick="var e2 = document.getElementById('departments'); e2.action='<?= base_url() ?>hr/department'; e2.submit();"
                type="submit">Search</button>
              <!--<button class="btn btn-success" onclick="var e2 = document.getElementById('structure'); e2.action='<?= base_url() ?>hr/exportStructure'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> -->
              <a href="<?= base_url() ?>hr/department" class="btn btn-warning">(x) Clear Filter</a>
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
        Department
      </header>
      <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success" role="alert">
          <span class="fa fa-check-circle"></span>
          <span><strong><?= $this->session->flashdata('true') ?></strong></span>
        </div>
      <?php } ?>
      <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
          <span class="fa fa-warning"></span>
          <span><strong><?= $this->session->flashdata('error') ?></strong></span>
        </div>
      <?php } ?>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow:scroll;">
          <div class="clearfix">
            <div class="btn-group">
              <?php if ($permission->add == 1) { ?>
                <a href="<?= base_url() ?>hr/addDepartment" class="btn btn-primary ">Add New Department</a>
                </br></br></br>
              <?php } ?>
            </div>

          </div>

          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Department</th>
                <th>Division</th>
                <th>Brand</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>

              </tr>
            </thead>

            <tbody>
              <?php
              if ($department->num_rows() > 0) {
                foreach ($department->result() as $row) {
                  ?>
                  <tr class="">
                    <td>
                      <?php echo $row->id; ?>
                    </td>
                    <td>
                      <?php echo $row->name; ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDivision($row->division); ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getBrand($row->brand); ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                    </td>
                    <td>
                      <?php echo $row->created_at; ?>
                    </td>
                    <td>
                      <?php if ($permission->edit == 1) { ?>
                        <a href="<?php echo base_url() ?>hr/editDepartment?t=<?php echo base64_encode($row->id); ?>" class="">
                          <i class="fa fa-pencil"></i> Edit
                        </a>
                      <?php } ?>
                    </td>

                    <td>
                      <?php if ($permission->delete == 1) { ?>
                        <a href="<?php echo base_url() ?>hr/deleteDepartment/<?php echo $row->id ?>" title="delete" class=""
                          onclick="return confirm('Are you sure you want to delete this Department?');">
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
                <td colspan="7">There is no Departments to list</td>
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