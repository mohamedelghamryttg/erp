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
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search</h3>
        </div>

        <form class="form" id="customerfilter" action="<?php echo base_url() ?>projects/lateDeliveryReport" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Delivery Date</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="delivery_date" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Created By</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by" />
                <option value="">-- Select PM --</option>
                <?= $this->admin_model->selectAllPm('', $this->brand) ?>
                </select>
              </div>
            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-primary" name="search" type="submit">Search</button>
                  <button class="btn btn-success"
                    onclick="var e2 = document.getElementById('lateDeliveryForm'); e2.action='<?= base_url() ?>projects/exportLateDeliveryJobs'; e2.submit();"
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
      <div class="card-header">
        <div class="card-title">
          <h3 class="card-label">Late Delivery Jobs - <span class="numberCircle"><span>
                <?= $job->num_rows() ?>
              </span></span></h3>
        </div>

      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
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