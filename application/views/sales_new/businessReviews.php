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
          <h3 class="card-title">Search Business Review</h3>
        </div>

        <form class="form" id="businessReviewsForm" action="<?php echo base_url() ?>sales/businessReviews" method="post"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Number #</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" value="<?= $id ?>" name="id">

              </div>

              <label class="col-lg-2 control-label" for="role name">Customer</label>
              <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" onchange="CustomerData()">
                  <option value="">-- Select Customer --</option>
                  <?php if ($permission->view == 1) { ?>
                    <?= $this->customer_model->selectExistingCustomerBySam($customer, $this->user, $permission, $this->brand) ?>
                  <?php } else {
                    if ($this->role == 2) {
                      echo $this->customer_model->selectCustomerByPm($customer, $this->user, $permission, $this->brand);
                    } elseif ($this->role == 3) {
                      echo $this->customer_model->selectExistingCustomerBySam($customer, $this->user, $permission, $this->brand);
                    }
                    ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Type</label>
              <div class="col-lg-3">
                <select name="type" class="form-control m-b" id="type">
                  <option value="">-- Select Type --</option>
                  <?php
                  if ($_REQUEST['type'] == 1) { ?>
                    <option selected="" value="<?= $_REQUEST['type'] ?>">SLA</option>
                    <option value="2">SIP</option>
                  <?php } elseif ($_REQUEST['type'] == 2) { ?>
                    <option selected="" value="<?= $_REQUEST['type'] ?>">SIP</option>
                    <option value="1">SLA</option>

                  <?php } else { ?>
                    <option value="1">SLA</option>
                    <option value="2">SIP</option>

                  <?php } ?>
                </select>
              </div>

              <label class="col-lg-2 control-label" for="role name">Created by</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by">
                  <option value="">-- Select SAM --</option>
                  <?= $this->customer_model->selectAllSam($created_by, $this->brand) ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">

              </div>

              <label class="col-lg-2 control-label" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>
            </div>

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Region</label>
              <div class="col-lg-3">
                <select name="region" class="form-control m-b" id="region">
                  <option value="">-- Select Region --</option>
                  <?= $this->admin_model->selectRegion($region) ?>
                </select>
              </div>
            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">

                  <button class="btn btn-success mr-2" name="search" type="submit" value="search"><i
                      class="la la-search"></i>Search</button>
                  <button class="btn btn-warning mr-2" name="submitReset" type="submit" value="submitReset"><i
                      class="la la-trash"></i>Clear
                    Filter</button>

                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('businessReviewsForm'); e2.action='<?= base_url() ?>sales/exportBusinessReviews'; e2.submit();"
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
          <h3 class="card-label">Business Reviews</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>sales/addBusinessReviews" class="btn btn-primary font-weight-bolder">
            <?php } ?>
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
            </span>Add New Business Review</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
            <tr>
              <th>Number #</th>
              <th>Customer</th>
              <th>Region</th>
              <th>Country</th>
              <th>Contact Name</th>
              <th>Contact Method</th>
              <th>Type</th>
              <th>SLA Reason</th>
              <th>SLA Attachment</th>
              <th>SIP Issue</th>
              <th>SIP Reason</th>
              <th>SIP Improvement Owner</th>
              <th>SIP Proposed Solution</th>
              <th>SIP Due Date For Final Feedback</th>
              <th>SIP Status Of Resolution</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($business->result() as $row) {
              $contactData = $this->db->get_where('customer_contacts', array('id' => $row->contact_id))->row();
              ?>
              <tr class="">
                <td>
                  <?php echo $row->id; ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getCustomer($row->customer ?? ''); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getRegion($row->region ?? ''); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCountry($row->country ?? ''); ?>
                </td>
                <td>
                  <?= $contactData->name ?>
                </td>
                <td>
                  <?= $this->sales_model->getContactMethod($row->contact_method ?? '') ?>
                </td>
                <td>
                  <?php if ($row->type == 1) {
                    echo "SLA";
                  } elseif ($row->type == 2) {
                    echo "SIP";
                  } ?>
                </td>
                <td>
                  <?= $this->sales_model->getSlaReason($row->sla_reason ?? '') ?>
                </td>
                <td>
                  <?php if (strlen($row->sla_attachment ?? '') > 0) {
                    echo "<a href=" . base_url() . "assets/uploads/slaAttachment/" . $row->sla_attachment . ">Click Me</a>";
                  } ?>
                </td>
                <td>
                  <?= $this->sales_model->getSipIssue($row->sip_issue ?? '') ?>
                </td>
                <td>
                  <?php echo $row->sip_reason; ?>
                </td>
                <td>
                  <?= $this->admin_model->getUsersByMail($row->sip_improvement_owner ?? '') ?>
                </td>
                <td>
                  <?php echo $row->sip_proposed_solution; ?>
                </td>
                <td>
                  <?php echo $row->sip_due_date; ?>
                </td>
                <td>
                  <?php if ($row->sip_status_resolution == 1) {
                    echo "Opened";
                  } elseif ($row->sip_status_resolution == 2) {
                    echo "Closed";
                  } ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by ?? ''); ?>
                </td>
                <td>
                  <?php echo $row->created_at; ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>sales/editBusinessReviews?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($permission->delete == 1) { ?>
                    <!-- <a href="<?php echo base_url() ?>sales/deleteOpportunity?t=<?php echo
                         base64_encode($row->id); ?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Opportunity ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a> -->
                  <?php } ?>
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