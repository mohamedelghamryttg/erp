<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        VPO Filter
      </header>

      <div class="panel-body">
        <form class="cmxform form-horizontal " id="vpoForm" action="<?php echo base_url() ?>accounting/verifiedVpo"
          method="post" enctype="multipart/form-data">
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">PO Number</label>

            <div class="col-lg-3">

              <input class="form-control" type="text" name="code" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="role Task Type">PM Name</label>
            <div class="col-lg-3">
              <select name="created_by" class="form-control m-b" id="created_by">
                <option value="">-- Select PM --</option>
                <?= $this->admin_model->selectAllPm('', $this->brand) ?>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role name">Vendor Name</label>
            <div class="col-lg-3">
              <select name="vendor" class="form-control m-b" id="vendor">
                <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                <?= $this->vendor_model->selectVendor(0, $brand) ?>
              </select>
            </div>
          </div>
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

              <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
              <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
            </div>

          </div>
          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button>
              <button class="btn btn-success"
                onclick="var e2 = document.getElementById('vpoForm'); e2.action='<?= base_url() ?>accounting/exportVerifiedVpo'; e2.submit();"
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
        All VPOs
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
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>

          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Task Code</th>
                <th>Task Type</th>
                <th>Vendor</th>
                <th>Source Language</th>
                <th>Target Language</th>
                <th>Count</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Total Cost</th>
                <th>Currency</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <th>Task File</th>
                <th>Vpo File</th>
                <th>Verify</th>
                <th>Verified At</th>
                <th>Verified By</th>
                <th>Status</th>
                <th>Closed Date</th>
                <th>CPO Closed Date</th>
                <th>Created By</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($task->result() as $row) {
                $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                $project = explode("-", $row->code);
                $projectData = $this->projects_model->getProjectData($project[1]);
                ?>
                <tr>
                  <td>
                    <?= $row->code ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getTaskType($row->task_type); ?>
                  </td>
                  <td>
                    <?php echo $this->vendor_model->getVendorName($row->vendor); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getLanguage($priceList->source); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getLanguage($priceList->target); ?>
                  </td>
                  <td>
                    <?php echo $row->count; ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getUnit($row->unit); ?>
                  </td>
                  <td>
                    <?php echo $row->rate; ?>
                  </td>
                  <td>
                    <?php echo $row->rate * $row->count; ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getCurrency($row->currency); ?>
                  </td>
                  <td>
                    <?php echo $row->start_date; ?>
                  </td>
                  <td>
                    <?php echo $row->delivery_date; ?>
                  </td>
                  <td>
                    <?php if (strlen($row->file) > 1) { ?><a
                      href="<?= base_url() ?>assets/uploads/taskFile/<?= $row->file ?>" target="_blank">Click Here</a>
                  <?php } ?>
                  </td>
                  <td>
                    <?php if (strlen($row->vpo_file) > 1 && $row->job_portal == 1) { ?>
                      <a href="<?= $this->projects_model->getNexusLinkByBrand() ?>/assets/uploads/invoiceVendorFiles/<?= $row->vpo_file ?>"
                        target="_blank">Click Here</a>
                    <?php } elseif (strlen($row->vpo_file) > 1 && $row->job_portal == 0) { ?>
                      <a href="<?= base_url() ?>assets/uploads/vpo/<?= $row->vpo_file ?>" target="_blank">Click Here</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($row->verified == 1) {
                      echo "Verified";
                    } ?>
                  </td>
                  <td>
                    <?php echo $row->verified_at; ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->verified_by); ?>
                  </td>
                  <td>
                    <?php echo $this->projects_model->getJobStatus($row->status); ?>
                  </td>
                  <td>
                    <?php echo $row->closed_date; ?>
                  </td>
                  <td>
                    <?= $projectData->closed_date ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td>
                    <?php echo $row->created_at; ?>
                  </td>
                </tr>
              <?php } ?>
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