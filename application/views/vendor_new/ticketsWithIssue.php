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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center mr-1">
        <!--begin::Page Heading-->
        <div class="d-flex align-items-baseline flex-wrap mr-5">
          <!--begin::Page Title-->
          <h2 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">HTML Table</h2>
          <!--end::Page Title-->
          <!--begin::Breadcrumb-->
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
            <li class="breadcrumb-item text-muted">
              <a href="" class="text-muted">KTDatatable</a>
            </li>
            <li class="breadcrumb-item text-muted">
              <a href="" class="text-muted">Base</a>
            </li>
            <li class="breadcrumb-item text-muted">
              <a href="" class="text-muted">HTML Table</a>
            </li>
          </ul>
          <!--end::Breadcrumb-->
        </div>
        <!--end::Page Heading-->
      </div>
      <!--end::Info-->

    </div>
  </div>
  <!--end::Subheader-->

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Tickets Filter</h3>
        </div>
        <?php
        if (isset($_REQUEST['request_type'])) {
          $request_type = $_REQUEST['request_type'];
        } else {
          $request_type = "";
        }
        if (isset($_REQUEST['service'])) {
          $service = $_REQUEST['service'];
        } else {
          $service = "";
        }
        if (isset($_REQUEST['status'])) {
          $status = $_REQUEST['status'];
        } else {
          $status = "";
        }
        if (isset($_REQUEST['id'])) {
          $id = $_REQUEST['id'];
        } else {
          $id = "";
        }
        if (isset($_REQUEST['created_by'])) {
          $created_by = $_REQUEST['created_by'];
        } else {
          $created_by = "";
        }
        ?>
        <form class="form" action="<?php echo base_url() ?>vendor/ticketsWithIssue" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Ticket Type:</label>
              <div class="col-lg-3">
                <select name="request_type" class="form-control m-b" id="request_type" />
                <option value="">-- Select Type --</option>
                <?= $this->vendor_model->selectTicketType($request_type) ?>
                </select>
              </div>

              <label class="col-lg-2 control-label" for="role name">Service</label>

              <div class="col-lg-3">
                <select name="service" onchange="getService()" class="form-control m-b" id="service" />
                <option disabled="disabled" selected="">-- Select Service --</option>
                <?= $this->admin_model->selectServices($service) ?>
                </select>
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Status:</label>
              <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status" />
                <option disabled="disabled" selected="">-- Select Status --</option>
                <?= $this->vendor_model->selectAllTicketStatus($status) ?>
                </select>
              </div>

              <label class="col-lg-2 control-label" for="role name">Ticket Number</label>

              <div class="col-lg-3">
                <input type="text" class="form-control" value="<?= $id ?>" name="id">
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Requester Name:</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by" />
                <option disabled="disabled" selected="">-- Select Requester Name --</option>
                <?= $this->admin_model->selectAllPmAndSales($created_by, $this->brand) ?>
                </select>
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
                  <a href="<?= base_url() ?>vendor/ticketsWithIssue" class="btn btn-warning"><i
                      class="la la-trash"></i>Clear Filter</a>

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
          <h3 class="card-label">Tickets List </h3>
        </div>
        <div class="card-toolbar">

        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <thead>
              <tr>

                <th>Ticket Number</th>
                <th>Request Type</th>
                <th>Service</th>
                <th>Task Type</th>
                <th>Rate</th>
                <th>Count</th>
                <th>Unit</th>
                <th>Currency</th>
                <th>Source Language</th>
                <th>Target Language</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <!--                                <th>Due Date</th>-->
                <th>Subject Matter</th>
                <th>Software</th>
                <th>Taken Time</th>
                <th>Status</th>
                <th>Issues</th>
                <th>Issue By</th>
                <th>Created By</th>
                <th>Created At</th>
              </tr>

            </thead>

          <tbody>

            <?php
            foreach ($ticket->result() as $row) {
              ?>
              <tr class="">
                <td>
                  <?php echo $row->id; ?>
                </td>
                <td>
                  <?php echo $this->vendor_model->getTicketType($row->request_type); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getServices($row->service); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getTaskType($row->task_type); ?>
                </td>
                <td>
                  <?php echo $row->rate; ?>
                </td>
                <td>
                  <?php echo $row->count; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getUnit($row->unit); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCurrency($row->currency); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->source_lang); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->target_lang); ?>
                </td>
                <td>
                  <?php echo $row->start_date; ?>
                </td>
                <td>
                  <?php echo $row->delivery_date; ?>
                </td>
                <!--                              <td><?php echo $row->due_date; ?></td>-->
                <td>
                  <?php echo $this->admin_model->getFields($row->subject); ?>
                </td>
                <td>
                  <?php echo $this->sales_model->getToolName($row->software); ?>
                </td>
                <td>
                  <?php echo $this->vendor_model->ticketTime($row->id) . ' H:M'; ?>
                </td>
                <td>
                  <?php echo $this->vendor_model->getTicketStatus($row->status); ?>
                </td>
                <td>
                  <?php echo $row->issue; ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->issue_by); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?php echo $row->created_at; ?>
                </td>
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
</div>
<!--end::Content-->