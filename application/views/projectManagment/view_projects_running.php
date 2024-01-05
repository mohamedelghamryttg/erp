<div class="content d-flex flex-column flex-column-fluid  py-2" id="kt_content">
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid ">
      <!--begin::Card-->
      <div class="card card-custom gutter-b example example-compact  py-0 my-3">
        <style>
          .row.display-flex {
            display: flex;
            flex-wrap: wrap;
          }

          .row.display-flex>[class*='col-'] {
            display: flex;
            flex-direction: column;
          }

          .text-white {
            color: var(--bs-text-white) !important;
          }

          /* .fs-2hx {
            font-size: 2.5rem !important;
          } */

          .ls-n2 {
            letter-spacing: -.115rem !important;
          }

          .text-white {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-white-rgb), var(--bs-text-opacity)) !important;
          }

          .lh-1 {
            line-height: 1 !important;
          }

          .fw-bold {
            font-weight: 600 !important;
          }

          .fs-0hx {
            font-size: calc(0.2rem + 1.0vw) !important;
          }

          .fs-1hx {
            font-size: calc(0.375rem + 1.0vw) !important;
          }

          .fs-2hx {
            font-size: calc(1.375rem + 1.5vw) !important;
          }

          .fs-3hx {
            font-size: calc(1rem + 1.5vw) !important;
          }

          .fs-4hx {
            font-size: calc(.4rem + 1.5vw) !important;
          }

          .me-2 {
            margin-right: 1.5rem !important;
          }

          .fs-6 {
            font-size: 1.075rem !important;
          }

          .fw-semibold {
            font-weight: 500 !important;
          }

          .pt-1 {
            padding-top: 0.25rem !important;
          }
        </style>

        <div class="container content-row">
          <div class="row">
            <!--begin::Col-->
            <div class="col-12" style="display: flex;">
              <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: linear-gradient(180deg, rgba(9,9,121,1) 90%, rgba(0,212,255,1) 100%);">
                  <div class="card-body  p-0" style="float:left;">
                    <span class="fs-3hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="samCount">...</span>
                    <span class="card-text fs-0hx text-right">Projects From SAM </span>

                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-lg-3 d-flex align-items-stretch" style="display: none !important;">
                <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: linear-gradient(180deg,  rgba(28,173,17,.8) 90%, rgba(0,212,255,.5) 100%);">
                  <div class="card-body p-0" style="float:left;">

                    <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="allCount">...</span>
                    <span class="card-text fs-0hx text-right">All Projects </span>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
                <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background:linear-gradient(180deg,  rgba(248,40,90,.8) 90%, rgba(0,212,255,.5) 100%); ">
                  <div class="card-body p-0" style="float:left;">
                    <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="runningCount">...</span>
                    <span class="card-text fs-0hx text-right">Running Projects </span>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-lg-3 d-flex align-items-stretch" style="display: none !important;">
                <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: linear-gradient(180deg,  rgba(63,66,84,.8) 90%, rgba(0,212,255,.5) 100%);">
                  <div class="card-body p-0" style="float:left;">
                    <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="closedCount">...</span>
                    <span class="card-text fs-0hx text-right">Closed Projects </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="filter21Modal" tabindex="-1" role="dialog" aria-labelledby="filter21Modal" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header text-center" style="margin-left: auto;margin-right: auto;">
                <h5 class="modal-title text-uppercase" id="filter21ModalLabel">Projects From SAM </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body  px-0">

                <div class="col-12">
                  <div class="table-responsive">
                    <table id="samTable" class="table table-striped row-bordered display compac nowrap table-hover " cellspacing="0" width="100%">
                      <!-- table table-striped table-bordered  table-hover display compac nowrap table-responsive" cellpadding="0" width="100%"> -->
                      <thead>
                        <tr>
                          <th class="all">#</th>
                          <th class="all">ID</th>
                          <th class="all">PROJECT NAME</th>
                          <th class="all">CLIENT</th>
                          <th class="all">ASSIGNED DATE</th>
                          <th class="all">SAM</th>
                          <th class="all">SAVE</th>

                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- //////////////////////// -->
        <div class="modal fade" id="filter11Modal" tabindex="-1" role="dialog" aria-labelledby="filter11ModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header text-center" style="margin-left: auto;margin-right: auto;">
                <h5 class="modal-title text-uppercase" id="filter11ModalLabel">Search Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div>
                <?php
                if (!empty($_REQUEST['code'])) {
                  $code = $_REQUEST['code'];
                } else {
                  $code = "";
                }
                if (!empty($_REQUEST['name'])) {
                  $name = $_REQUEST['name'];
                } else {
                  $name = "";
                }
                if (!empty($_REQUEST['customer'])) {
                  $customer = $_REQUEST['customer'];
                } else {
                  $customer = "";
                }
                if (!empty($_REQUEST['product_line'])) {
                  $product_line = $_REQUEST['product_line'];
                } else {
                  $product_line = "";
                }
                if (!empty($_REQUEST['status'])) {
                  $status = $_REQUEST['status'];
                } else {
                  $status = "";
                }
                if (isset($_REQUEST['created_by'])) {
                  $created_by = $_REQUEST['created_by'];
                } else {
                  $created_by = "";
                }
                if (isset($_REQUEST['pono'])) {
                  $pono = $_REQUEST['pono'];
                } else {
                  $pono = "";
                }
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                  $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                  $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                } else {
                  $date_to = "";
                  $date_from = "";
                }
                ?>
              </div>

              <div class="modal-body  px-0">
                <div class="col-12">

                  <form class="cmxform form-horizontal" id="searchform" method="post" enctype="multipart/form-data">
                    <input type="text" name="screen_type" value="<?= $screen_type ?>" hidden>
                    <div class="card-body  py-3 my-0">
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role code">Project Code</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" name="code" value="<?= $code ?>">
                        </div>
                        <label class="col-lg-2 control-label text-lg-right" for="role name">Project Name</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" name="name" value="<?= $name ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role customer">Client</label>
                        <div class="col-lg-3">
                          <select name="customer" class="form-control m-b" id="customer" style="width: 100% Iimportant;">
                            <option value="" selected="selected">-- Select Client --</option>
                            <?= $this->customer_model->selectCustomerByPm($customer, $this->user, $permission, $this->brand) ?>
                          </select>
                        </div>
                        <label class="col-lg-2 control-label text-lg-right" for="role product_line">Product Line</label>
                        <div class="col-lg-3">
                          <select name="product_line" class="form-control m-b" id="product_line" style="width: 100% Iimportant;">
                            <option value="" selected="">-- Select Product Line --</option>
                            <?= $this->customer_model->selectProductLine($product_line, $this->brand) ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role status">Status</label>
                        <div class="col-lg-3 " style="width: 100%;">
                          <?php if ($screen_type == 'All') { ?>
                            <select name="status" class="form-control m-b" id="status" style="width: 100% Iimportant;">
                              <option value="">-- Select Status --</option>
                              <?php
                              if ($status == 2) { ?>
                                <option selected="" value="<?= $_REQUEST['status'] ?>">Running</option>
                                <option value="1">Closed</option>
                              <?php } elseif ($status == 1) { ?>
                                <option selected="" value="<?= $_REQUEST['status'] ?>">Closed</option>
                                <option value="2">Running</option>
                              <?php } else { ?>
                                <option value="2">Running</option>
                                <option value="1">Closed</option>
                              <?php } ?>
                            </select>
                          <?php } else { ?>
                            <select name="status" class="form-control m-b" id="status" style="width: 100% Iimportant;" disabled>
                              <option value="">-- Select Status --</option>
                              <option selected value="2">Running</option>
                              <option value="1">Closed</option>

                            </select>
                          <?php } ?>

                        </div>

                        <label class="col-lg-2 col-form-label text-lg-right">Created by</label>
                        <div class="col-lg-3">
                          <select name="created_by" class="form-control m-b" id="created_by" style="width: 100% Iimportant;">
                            <option value="">-- Select PM --</option>
                            <?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row" style="display: none">
                        <label class="col-lg-2 control-label text-lg-right" for="role pono">Po</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" name="pono" value="<?= $pono ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role date">Date From</label>
                        <div class="col-lg-3">
                          <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value="<?= $date_from ?>">
                        </div>
                        <label class="col-lg-2 control-label text-lg-right" for="role date">Date To</label>
                        <div class="col-lg-3">
                          <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" value="<?= $date_to ?>">
                        </div>

                      </div>

                    </div>
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
                <a href="<?= base_url() ?>ProjectManagment/runningProject" class="btn btn-warning">(x) Clear Filter</a>

              </div>
            </div>
          </div>
        </div>

        <!--end::Card-->
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
        <div class="card">
          <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
              <h3 class="text-uppercase border-bottom mb-4">Projects List</h3>
            </div>
          </div>

          <div class="card-body row py-0 px-0">
            <div class="col-sm-12 px-5">

              <table id="user_data" class="table table-striped row-bordered display nowrap table-hover " cellspacing="0" width="100%">

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  div.dataTables_wrapper div.dataTables_processing {
    background-color: transparent;
    border: none;
  }

  .text-wrap-datatable {
    white-space: pre-line !important;
    min-width: 30ch;
  }

  .text-nowrap-datatable {
    white-space: nowrap !important;
  }

  .dataTables_paginate ul li {
    padding: 0px !important;
    border: 0px !important;
    background: transparent;
  }

  .text-flix-datatable {
    display: flex,
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {

    background: transparent !important;
  }



  .demo .select2 {
    width: auto !important;
  }

  .btn-group>.btn:not(:last-child):not(.dropdown-toggle),
  .btn-group>.btn-group:not(:last-child)>.btn {
    border-radius: 1;
    margin-right: 0.5em;
  }

  .datepicker {
    z-index: 10052;
  }

  table.dataTable td.details-control:before {
    content: '\f044';
    font-family: FontAwesome;
    cursor: pointer;
    font-size: 22px;
    color: #55a4be;
    font-size: 16px;
  }

  table.dataTable tr.shown td.details-control:before {
    content: '\f00d';
    font-family: FontAwesome;
    color: black;
  }

  table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before,
  table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
    background-color: #e91e63 !important;
  }

  table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td.dtr-control:before,
  table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th.dtr-control:before {
    background-color: #e91e63 !important;
  }


  .dataTables_wrapper table.dataTable.collapsed>tbody>tr>td:first-child::before {
    padding: 0 !important;
    font-size: 1.5em;
  }

  .swal2-content .select2 {
    display: none;
  }
</style>


<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets_new/js/projectsManagment/view_projects.js"></script>