<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        Filter
      </header>

      <div class="panel-body">
        <form class="cmxform form-horizontal " id="lateDeliveryForm"
          action="<?php echo base_url() ?>projects/lateDeliveryReport" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="role date">Delivery Date</label>

            <div class="col-lg-3">

              <input class="form-control date_sheet" type="text" name="delivery_date" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role Task Type">Created By</label>

            <div class="col-lg-3">
              <select name="created_by" class="form-control m-b" id="created_by" />
              <option value="">-- Select PM --</option>
              <?= $this->admin_model->selectAllPm('', $this->brand) ?>
              </select>
            </div>

          </div>
          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button>
              <button class="btn btn-success"
                onclick="var e2 = document.getElementById('lateDeliveryForm'); e2.action='<?= base_url() ?>projects/exportLateDeliveryJobs'; e2.submit();"
                name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
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
        Late Delivery Jobs - <span class="numberCircle"><span><?= $job->num_rows() ?></span></span>
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>PM Name</th>
                <th>Job Code</th>
                <th>Job Name</th>
                <th>Client Name</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) {
                $projectData = $this->db->get_where('project', array('id' => $row->project_id))->row();
                ?>
                <tr>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td><a target="_blank"
                      href="<?= base_url() ?>projects/projectJobs?t=<?= base64_encode($row->project_id) ?>"><?= $row->code ?></a>
                  </td>
                  <td><abbr title="<?= $row->name ?>"><?= character_limiter($row->name, 10) ?></abbr></td>
                  <td>
                    <?php echo $this->customer_model->getCustomer($projectData->customer); ?>
                  </td>
                  <td>
                    <?php echo $row->start_date; ?>
                  </td>
                  <td>
                    <?php echo $row->delivery_date; ?>
                  </td>
                  <td>
                    <?php echo $row->created_at; ?>
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