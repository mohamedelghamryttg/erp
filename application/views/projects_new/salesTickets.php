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

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search Tickets</h3>
        </div>

        <form class="form" id="customerfilter" action="<?php echo base_url() ?>projects/salesTickets" method="post"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Ticket Number</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" name="id">
              </div>



              <div class="col-lg-5 text-right">
                <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
              </div>
            </div>
          </div>
        </form>
      </div>


      <!-- end search form -->

      <!--begin::Card-->
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <h3 class="card-label">Tickets</h3>
          </div>

        </div>
        <div class="card-body">
          <!--begin: Datatable-->
          <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
            <thead>
              <tr>
                <th>PM</th>
                <th>Customer Name</th>
                <th>Opportunity Name</th>
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
                <!--                    <th>Due Date</th>-->
                <th>Subject Matter</th>
                <th>Software</th>
                <th>Taken Time</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>View Ticekt</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($ticket->result() as $row) {
                ?>
                <tr class="">
                  <td>
                    <?php echo $this->admin_model->getAdmin($row->pm); ?>
                  </td>
                  <td>
                    <?php echo $this->customer_model->getCustomer($row->customer); ?>
                  </td>
                  <td>
                    <?php echo $row->project_name; ?>
                  </td>
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
                  <!--                    <td><?php echo $row->due_date; ?></td>-->
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
                    <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                  </td>
                  <td>
                    <?php echo $row->created_at; ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url() ?>vendor/requesterTicketView?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-eye"></i> View Ticekt
                    </a>
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