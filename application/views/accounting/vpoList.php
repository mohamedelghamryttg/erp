<div class="row">
  <div class="col-sm-12">
    <section class="panel">

      <header class="panel-heading">
        VPO Filter
      </header>

      <div class="panel-body">
        <form class="cmxform form-horizontal " id="vpoForm" action="<?php echo base_url() ?>accounting/vpoList" method="get" enctype="multipart/form-data">
          <?php
          if (isset($_REQUEST['code'])) {
            $code = $_REQUEST['code'];
          } else {
            $code = "";
          }
          if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
          } else {
            $created_by = "";
          }
          if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
          } else {
            $vendor = "";
          }

          ?>
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">PO Number</label>

            <div class="col-lg-3">

              <input class="form-control" type="text" value="<?= $code ?>" name="code" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="role Task Type">PM Name</label>
            <div class="col-lg-3">
              <select name="created_by" class="form-control m-b" id="created_by" />
              <option value="">-- Select PM --</option>
              <?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
              </select>
            </div>

            <label class="col-lg-2 control-label" for="role name">Vendor Name</label>
            <div class="col-lg-3">
              <select name="vendor" class="form-control m-b" id="vendor" />
              <option disabled="disabled" selected="selected">-- Select Vendor --</option>
              <?= $this->vendor_model->selectVendor($vendor, $brand) ?>
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
              <button class="btn btn-success" onclick="var e2 = document.getElementById('vpoForm'); e2.action='<?= base_url() ?>accounting/exportVpo'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
              <a href="<?= base_url() ?>accounting/vpoList" class="btn btn-warning">(x) Clear Filter</a>

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
          <span><strong><?= $this->session->flashdata('true') ?></strong></span>
        </div>
      <?php  } ?>
      <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
          <span class="fa fa-warning"></span>
          <span><strong><?= $this->session->flashdata('error') ?></strong></span>
        </div>
      <?php  } ?>

      <div class="panel-body">
        <form method="post" action="<?php echo base_url() ?>accounting/verifyVPO" onsubmit="return checkPoVerifyForm()" enctype="multipart/form-data">
          <div class="adv-table editable-table " style="overflow-y: scroll;">
            <div class="clearfix">
              <div class="btn-group">
                <?php if ($permission->add == 1) { ?>
                  <div class="form-group">
                    <label class="col-lg-2 control-label" for="role date">Invoices File</label>
                    <div class="col-lg-3">
                      <input type="file" class=" form-control" name="file" required="">
                    </div>
                    <label class="col-lg-2 control-label" for="role date">Invoice Date</label>
                    <div class="col-lg-3">
                      <input class="date_sheet form-control" type="text" name="invoice_date" autocomplete="off" id="invoice_date" required="">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group mt-5">
                    <label class="col-lg-2 control-label" for="role date">Total</label>
                    <div class="col-lg-6">
                      <input class="form-control" type="text" id="sum_total" readonly="" value="0">
                    </div>
                  </div>
                  </br></br></br>
                  <input type="submit" name="submit" class="btn btn-primary " style="margin-right: 5rem;" value="Verify Selected POs">
                  <a class="btn btn-success " onclick="checkAll();totalValue();" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                  <a class="btn btn-danger " onclick="unCheckAll();totalValue();" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                  </br></br></br>
                <?php } ?>

              </div>
            </div>
            <div class="space15"></div>

            <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
              <thead>
                <tr>
                  <th>#</th>
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
                  <th>Has Error</th>
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
                    <td><input type="checkbox" class="checkPo" name="select[]" value="<?= $row->id ?>" onclick="totalValue();" total="<?= $row->rate * $row->count; ?>"></td>
                    <td><?= $row->code ?></td>
                    <td><?php echo $this->admin_model->getTaskType($row->task_type); ?></td>
                    <td><?php echo $this->vendor_model->getVendorName($row->vendor); ?></td>
                    <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                    <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                    <td><?php echo $row->count; ?></td>
                    <td><?php echo $this->admin_model->getUnit($row->unit); ?></td>
                    <td><?php echo $row->rate; ?></td>
                    <td><?php echo $row->rate * $row->count; ?></td>
                    <td><?php echo $this->admin_model->getCurrency($row->currency); ?></td>
                    <td><?php echo $row->start_date; ?></td>
                    <td><?php echo $row->delivery_date; ?></td>
                    <td><?php if (strlen($row->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/taskFile/<?= $row->file ?>" target="_blank">Click Here</a><?php } ?></td>
                    <?php if ($row->job_portal == 1) { ?>
                      <td><a class="btn btn-success " data-toggle="modal" style="margin-right: 5rem;">Nexus System</a></td>
                    <?php } else { ?>
                      <td><a class="btn btn-danger " data-toggle="modal" href="#ErrorModal<?php echo $row->id ?>" style="margin-right: 5rem;">Has Error</a></td>
                    <?php } ?>
                    <td><?php echo $this->projects_model->getJobStatus($row->status); ?></td>
                    <td><?php echo $row->closed_date; ?></td>
                    <td><?= $projectData->closed_date ?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                    <td><?php echo $row->created_at; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
        </form>
        <?php foreach ($task->result() as $modal) { ?>
          <!-- form of Has Error VPO -->
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ErrorModal<?php echo $modal->id; ?>" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                  <h4 class="modal-title">Has Error PO</h4>
                </div>
                <div class="modal-body">

                  <form method="post" action="<?php echo base_url() ?>accounting/HasErrorVPO">
                    <input type="text" name="task" value="<?= base64_encode($modal->id) ?>" hidden="">
                    <select class="form-control m-b" name="has_error[]" id="has_error" required="" multiple>
                      <?= $this->accounting_model->selectHasError() ?>
                    </select></br>

                    <button type="submit" class="btn btn-default">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <nav class="text-center">
          <?= $this->pagination->create_links() ?>
        </nav>
      </div>
  </div>
  </section>
</div>
</div>
<script>
  function totalValue() {
    var sum = 0;
    $('.checkPo').each(function() {
      if ($(this).is(':checked')) {
        var val = $(this).attr('total') ? parseFloat($(this).attr('total')) : 0;
        sum += val;
      }
    });
    $('#sum_total').val(sum);
  }
</script>