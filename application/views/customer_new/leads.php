<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
          <h3 class="card-title">Search Leads</h3>
        </div>
        <?php
        if (!empty($_REQUEST['customer'])) {
          $customer = $_REQUEST['customer'];

        } else {
          $customer = "";
        }
        if (!empty($_REQUEST['region'])) {
          $region = $_REQUEST['region'];

        } else {
          $region = "";
        }
        if (!empty($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
          $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
          $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));

        } else {
          $date_to = "";
          $date_from = "";
        }
        if (!empty($_REQUEST['created_by'])) {
          $created_by = $_REQUEST['created_by'];

        } else {
          $created_by = "";
        }

        ?>

        <form class="form" id="leads" action="<?php echo base_url() ?>customer/leads" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Customer</label>
              <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" />
                <option value="">-- Select Customer --</option>
                <?= $this->customer_model->selectCustomerLead($customer, $this->brand) ?>
                </select>

              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Region</label>
              <div class="col-lg-3">
                <select name="region" class="form-control m-b" id="region" />
                <option value="">-- Select Region --</option>
                <?= $this->admin_model->selectRegion($region) ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" id="date_from" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" id="date_to" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">

              <label class="col-lg-2 col-form-label text-lg-right">Created By</label>
              <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by" />
                <option value="">-- Select User --</option>
                <?= $this->customer_model->selectAllSamMarketing($created_by, $this->brand) ?>
                </select>
              </div>
              <label class="col-lg-2 col-form-label text-lg-right">Assigned To</label>
              <div class="col-lg-3">
                <select name="assigned_to" class="form-control m-b" id="assigned_to" />
                <option value="">-- Select User --</option>
                <?= $this->customer_model->selectSamCustomer($assigned_to, $brand) ?>
                </select>
              </div>
            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <a class="btn btn-success mr-2" name="search" onclick="searchLeads();">Search</a>
                  <a href="<?= base_url() ?>customer/leads" class="btn btn-warning"><i class="la la-trash"></i>Clear
                    Filter</a>
                  <button class="btn btn-secondary"
                    onclick="var e2 = document.getElementById('leads'); e2.action='<?= base_url() ?>customer/exportleads'; e2.submit();"
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
          <h3 class="card-label">Customers Leads</h3>
        </div>
        <div class="card-toolbar">

          <!--begin::Button-->
          <?php if ($permission->add == 1) { ?>
            <a href="<?= base_url() ?>customer/addLead" class="btn btn-primary font-weight-bolder">
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
            </span>Add New Lead</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body" id="leadData">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Source</th>
              <th>Region</th>
              <th>Country</th>
              <th>Type</th>
              <th>Assigned SAM</th>
              <th>Status</th>
              <th>Approved</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($leads->result() as $row) {
              $SamCustomer = $this->customer_model->customersSam($row->id);
              ?>
              <tr class="">
                <td>
                  <?= $row->id ?>
                </td>
                <td><a href="<?= base_url() ?>customer/leadContacts?t=<?= base64_encode($row->id) ?>"><?php echo $this->customer_model->getCustomer($row->customer); ?></a></td>
                <?php if (is_numeric($row->source)) { ?>
                  <td>
                    <?php echo $this->customer_model->getSource($row->source); ?>
                  </td>
                <?php } else { ?>
                  <td>
                    <?= $row->source ?>
                  </td>
                <?php } ?>
                <td>
                  <?php echo $this->admin_model->getRegion($row->region); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getCountry($row->country); ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getType($row->type); ?>
                </td>
                <td class="leadInfo" id="SamTable_<?= $row->id ?>" data-id="<?= $row->id ?>"
                  data-customer="<?= $row->customer ?>">
                  <?php if ($row->approved == 1) { ?>
                    <?php if ($SamCustomer->num_rows() == 0) { ?>
                      <?php if ($permission->follow == 2) { ?>
                        <a href="#myModal" data-toggle="modal" class="btn btn-success">Assign SAM</a>
                      <?php } ?>
                    <?php } else { ?>
                      <table style="border-collapse:collapse;">
                        <tr>
                          <td style="border: 1px solid #ddd;">SAM Name</td>
                          <?php if ($permission->follow == 2) { ?>
                            <td style="border: 1px solid #ddd;"></td>
                            <td style="border: 1px solid #ddd;"></td>
                          <?php } ?>
                        </tr>
                        <?php
                        $i = 0;
                        $count = $SamCustomer->num_rows();
                        foreach ($SamCustomer->result() as $sam) {
                          //echo $i;
                          ?>
                          <tr>
                            <td style="border: 1px solid #ddd;">
                              <?php echo $this->admin_model->getAdmin($sam->sam); ?>
                            </td>
                            <?php if ($permission->follow == 2) { ?>
                              <!-- <td style="border: 1px solid #ddd;"><a href="<?php echo base_url() ?>customer/deleteSamCustomer?t=<?php echo base64_encode($sam->id); ?>">  -->
                              <td style="border: 1px solid #ddd;"><a onclick="deleteSamCustomer(<?= $sam->id ?>,<?= $row->id ?>)">
                                  <i class="fa fa-times text-danger text"></i> </a>
                              </td>
                            <?php } ?>
                            <?php if ($i < 1) {
                              ?>
                              <?php if ($permission->follow == 2) { ?>
                                <td rowspan="<?php echo $count; ?>" style="border: 1px solid #ddd;"><a href="#myModal"
                                    data-toggle="modal" class="btn btn-success">Assign SAM</a>
                                </td>
                              <?php } ?>
                            <?php }
                            ?>
                          </tr>
                          <?php
                          $i = $i + 1;
                        } ?>
                      </table>
                    <?php } ?>
                  <?php } ?>

                </td>
                <td>
                  <?php echo $this->customer_model->getStatus($row->status); ?>
                </td>
                <td>
                  <?php if ($row->approved == 1) {
                    echo "Yes";
                  } elseif ($row->approved == 2) {
                    echo "No";
                  } ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                </td>
                <td>
                  <?= $row->created_at ?>
                </td>
                <td>
                  <?php if ($permission->edit == 1) { ?>
                    <a href="<?php echo base_url() ?>customer/editLead?t=<?php echo
                         base64_encode($row->id); ?>" class="">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if (($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)) { ?>
                    <a href="<?php echo base_url() ?>customer/deleteLead?t=<?php echo
                         base64_encode($row->id); ?>" title="delete" class=""
                      onclick="return confirm('Are you sure you want to delete this Customer ?');">
                      <i class="fa fa-times text-danger text"></i> Delete
                    </a>
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
        <div class="pagination d-flex justify-content-between align-items-center flex-wrap">
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

<!-- form of adding sam and brand to customer-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Assign SAM To this Customer</h4>
      </div>
      <div class="modal-body">

        <input name="lead" id="lead_id" type="hidden" value="0">
        <input name="customer" id="customer_id" type="hidden" value="0">
        <div class="form-group">
          <label for="sam">Select SAM</label>
          <select name="sam" id="sam_id" class="form-control m-b" id="sam" required>
            <option disabled="disabled" selected="selected">Select SAM</option>
            <?= $this->customer_model->selectSamCustomer('', $brand) ?>
          </select>
        </div>

        <button class="btn btn-default" type="submit" aria-hidden="true" data-dismiss="modal" class="close"
          onclick="assignSamCustomerGlobal()">Submit</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    $(document).on('shown.bs.modal', '#myModal', function (e) {
      var $invoker = $(e.relatedTarget);
      var td = $invoker.closest('td.leadInfo');
      $('#lead_id').val(td.attr('data-id'));
      $('#customer_id').val(td.attr('data-customer'));
    });
    $(document).on('hidden.bs.modal', '#myModal', function (e) {
      $('#lead_id').val(0);
      $('#customer_id').val(0);
    });

  });
  function searchLeads() {

    var assigned_to = $("#assigned_to").val();
    var customer = $("#customer").val();
    var region = $("#region").val();
    var date_from = $("#date_from").val();
    var date_to = $("#date_to").val();
    var created_by = $("#created_by").val();

    $.ajaxSetup({
      beforeSend: function () {
        $('#loading').show();
      },
    });
    $.post(base_url + "customer/searchLeadsAjax", { customer: customer, region: region, date_from: date_from, date_to: date_to, created_by: created_by, assigned_to: assigned_to }, function (data) {
      $('#loading').hide();
      $("#leadData").html(data);
      $(".pagination").remove();
      $('#kt_datatable2').dataTable({
        "order": [],
        'paging': true,
        "searching": false,
        scrollX: true,
        scrollY: 400,
        scrollCollapse: true
      });
    });
  }
</script>