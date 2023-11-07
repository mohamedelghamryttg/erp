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
            font-size: calc(.75rem + 1.5vw) !important;
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

          .mb-xl-8 {
            /* margin-right: 1rem; */
          }
        </style>

        <div class="container content-row">
          <div class="row">
            <!--begin::Col-->
            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background-color: #1b84ff !important; ">
                <div class="card-body d-flex flex-column p-0">
                  <span class="fs-3hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="samCount">...</span>
                  <span class="card-text fs-1hx ml-10 text-right">Projects From SAM </span>

                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background-color: #17c653 !important; ">
                <div class="card-body d-flex flex-column p-0">

                  <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="allCount">...</span>
                  <span class="card-text fs-1hx ml-10 text-right">All Projects </span>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background-color: #f8285a !important; ">
                <div class="card-body d-flex flex-column p-0">
                  <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="runningCount">...</span>
                  <span class="card-text fs-1hx ml-10 text-right">Running Projects </span>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background-color: #3F4254 !important; ">
                <div class="card-body d-flex flex-column p-0">
                  <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="closedCount">...</span>
                  <span class="card-text fs-1hx ml-10 text-right">Closed Projects </span>
                </div>
              </div>
            </div>

          </div>
          <!-- <button id="button_filter21" class="btn btn-outline-success btn-sm text-center text-uppercase"> Projects From SAM <i id="i_button_filter21" class="fa fa-chevron-down"></i></button>
              <button id="button_filter11" class="btn btn-outline-success btn-sm text-center text-uppercase"> Projects Filter <i id="i_button_filter11" class="fa fa-chevron-down"></i></button>

              <?php if ($permission->add == 1) { ?>
                <a href="<?= base_url() ?>projectManagment/addProject" class="btn btn-primary font-weight-bolder">
                  <span class="svg-icon svg-icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" cx="9" cy="15" r="6" />
                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                      </g>
                    </svg>

                  </span>Add New Project</a>
              <?php } ?> -->


        </div>
        <!-- </div>
    </div> -->


        <div class="modal fade" id="filter21Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header text-center" style="margin-left: auto;margin-right: auto;">
                <h5 class="modal-title text-uppercase" id="exampleModalLabel">Projects From SAM </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body  px-0">
                <!-- <div class="container-fluid">
                  <div class="row"> -->
                <div class="col-12">
                  <table id="samTable" class="table table-striped table-bordered  table-hover compact  " cellpadding="0" width="100%">
                  </table>
                  <!-- </div>
                  </div> -->
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
                <h5 class="modal-title text-uppercase" id="filter11ModalLabel">Search Projects</h5>
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

                    <!-- <div class="card-footer">
                      <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10">
                          </div>
                      </div>
                    </div>
                  </form> -->


                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="search" id="search" type="button" value="search">Search</button>
                <a href="<?= base_url() ?>ProjectManagment/" class="btn btn-warning">(x) Clear Filter</a>

              </div>
            </div>
          </div>
        </div>
        <div class="card-body py-0 px-0" style="border-radius: inherit; width: 90%; margin: auto;background-color: #f7f7f7;">
          <!-- <div id="filter21">
           <div class="card-header  py-0">
              <h3 class="card-title">Projects From SAM </h3>
            </div>
             <table id="samTable" class="table table-striped table-bordered  table-hover compact  " cellpadding="0" width="100%">
            </table>
          </div> -->
          <!-- <div id="filter11">

            <div class="card-header  py-0">
              <h3 class="card-title">Search Projects</h3>
            </div> -->

          <!-- </div> -->
        </div>
        <!-- </div> -->

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
              <!-- <h3 class="card-label">Projects List -->
              <!-- <span class="btn btn-dark btn-sm"><span>

                </span></span> -->
              </h3>
            </div>
            <div class="card-toolbar">

              <!--begin::Button-->

              <!--end::Button-->
            </div>
          </div>

          <div class="card-body row py-0">
            <div class="col-sm-12 px-5">

              <table id="user_data" class="table table-striped row-bordered display nowrap table-hover">

              </table>
              <!-- webgrid-table-hidden -->
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
      min-width: 50ch;
    }

    .text-nowrap-datatable {
      white-space: nowrap !important;
      /* min-width: 50ch; */
    }

    .dataTables_paginate ul li {
      padding: 0px !important;
      /* margin: 0px !important; */
      border: 0px !important;
      background: transparent;
    }

    .text-flix-datatable {
      display: flex,
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {

      background: transparent !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
      box-shadow: unset;
    }

    .demo .select2 {
      width: auto !important;
    }

    .btn-group>.btn:not(:last-child):not(.dropdown-toggle),
    .btn-group>.btn-group:not(:last-child)>.btn {
      border-radius: 0;
      margin-right: 1em;
    }

    /* .angularjs-datetime-picker {
      z-index: 5000;
    } */

    .datepicker {
      z-index: 10052;
    }

    table.dataTable td.details-control:before {
      content: '\f044';
      font-family: FontAwesome;
      cursor: pointer;
      font-size: 22px;
      color: #55a4be;
    }

    table.dataTable tr.shown td.details-control:before {
      content: '\f00d';
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

    }
  </style>

  <script src="<?php echo base_url(); ?>assets_new/js/projectsManagment/view_projects.js"></script>