<div class="content d-flex flex-column flex-column-fluid py-2" id="kt_content">
  <div class="container-fluid">
    <div class="card card-custom gutter-b example example-compact  py-0 my-3">
      <style>
        .ls-n2 {
          letter-spacing: -.115rem !important;
        }

        .lh-1 {
          line-height: 1 !important;
        }

        .fw-bold {
          font-weight: 600 !important;
        }

        .fs-3hx {
          font-size: calc(1rem + 1.5vw) !important;
        }

        .fs-0hx {
          font-size: calc(0.2rem + 1.0vw) !important;
        }

        .fs-4hx {
          font-size: calc(.4rem + 1.5vw) !important;
        }

        .me-2 {
          margin-right: 1.5rem !important;
        }

        .control-label {
          margin: auto;
        }
      </style>
      <div class="container content-row">
        <div class="row">
          <!--begin::Col-->
          <div class="col-12" style="display: flex;">
            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #de5e74;">
                <div class="card-body p-0" style="float:left;">
                  <span class="fs-3hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="samCount"><?= $samCount ?>
                    <span class="card-text fs-0hx text-right">Projects From SAM </span></span>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #385898;">
                <div class="card-body p-0" style="float:left;">
                  <span class="fs-3hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="samCount"><?= $rec_all ?>
                    <span class="card-text fs-0hx text-right"> All Projects </span></span>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #2abba7;">
                <div class="card-body p-0" style="float:left;">

                  <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="countRun"><?= $rec_r ?>
                    <span class="card-text fs-0hx text-right"> Running Projects </span></span>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
              <div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #1877F2;">
                <div class="card-body p-0" style="float:left;">
                  <span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="countClose"><?= $rec_c ?>
                    <span class="card-text fs-0hx text-right"> Closed Projects </span></span>
                </div>
              </div>
            </div>


          </div>
        </div>

        <div class="modal top fade" id="filter21Modal" tabindex="-1" role="dialog" aria-labelledby="filter21Modal" aria-hidden="true">
          <div class="modal-dialog modal-x1" role="document">
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
                    <table id="samTable" class="table table-striped align-middle fs-6 gy-5 wrap table-head-custom table-bordered display ">

                      <!-- <table id="samTable" class="table table-striped row-bordered display compac nowrap table-hover " cellspacing="0" width="100%"> -->
                      <!-- table table-striped table-bordered  table-hover display compac nowrap table-responsive" cellpadding="0" width="100%"> -->
                      <thead>
                        <tr>
                          <!-- <th class="all">#</th> -->
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
                        <div class="col-lg-4">
                          <input type="text" class="form-control" name="code" value="<?= $code ?>">
                        </div>
                        <label class="col-lg-2 control-label text-lg-right" for="role name">Project Name</label>
                        <div class="col-lg-4">
                          <input type="text" class="form-control" name="name" value="<?= $name ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role customer">Client</label>
                        <div class="col-lg-4">
                          <select name="customer" class="form-control m-b" id="customer" style="width: 100% Iimportant;">
                            <option value="" selected="selected">-- Select Client --</option>
                            <?= $this->customer_model->selectCustomerByPm($customer, $this->user, $permission, $this->brand) ?>
                          </select>
                        </div>
                        <label class="col-lg-2 control-label text-lg-right" for="role product_line">Product Line</label>
                        <div class="col-lg-4">
                          <select name="product_line" class="form-control m-b" id="product_line" style="width: 100% Iimportant;">
                            <option value="" selected="">-- Select Product Line --</option>
                            <?= $this->customer_model->selectProductLine($product_line, $this->brand) ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role status">Status</label>
                        <div class="col-lg-4 " style="width: 100%;">
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

                        <label class="col-lg-2 col-form-label text-lg-right">Created by</label>
                        <div class="col-lg-4">
                          <select name="created_by" class="form-control m-b" id="created_by" style="width: 100% Iimportant;">
                            <option value="">-- Select PM --</option>
                            <?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role pono">Po</label>
                        <div class="col-lg-4">
                          <input type="text" class="form-control" name="pono" value="<?= $pono ?>">
                        </div>
                        <div class="col-lg-6"></div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-2 control-label text-lg-right" for="role date">Date From</label>
                        <div class="col-lg-4">
                          <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value="<?= $date_from ?>">
                        </div>
                        <label class="col-lg-2 control-label text-lg-right" for="role date">Date To</label>
                        <div class="col-lg-4">
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
                <a href="<?= base_url() ?>ProjectManagment/" class="btn btn-warning">(x) Clear Filter</a>

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
      </div>
    </div>
    <div class="card">
      <div class="card  pt-2 mb-2 pb-2 mx-4">
        <div class="card-header flex-wrap border-0 py-2">
          <h3 class="card-label">Projects List</h3>
        </div>
      </div>
      <!-- <div class="card-header flex-wrap border-0 pt-6 pb-0">
      <div class="card-title">
        <h3 class="text-uppercase border-bottom mb-4">Projects List</h3>
      </div>
    </div> -->
      <input type='hidden' id="brand_id" value="<?= $this->brand ?>">
      <input type='hidden' id="brand_name" value="<?= $this->admin_model->getBrand($brand) ?>">
      <!-- <div class="card-body row py-0 px-0"> -->
      <!-- <div class="col-sm-12 px-5"> -->
      <div class="card-body mx-4 px-0">
        <!-- <table id="user_data" class="table table-striped row-bordered display nowrap table-hover table-bordered" cellspacing="0" width="100%"> -->
        <table id="user_data" class="table table-striped align-middle fs-6 gy-5 wrap table-head-custom table-bordered display ">
          <thead>
            <tr>
              <th></th>
              <th style="padding: 0;">PROGRESS</th>
              <th>ID</th>
              <th>PROJECT CODE</th>
              <th>PROJECT NAME</th>
              <th>CLIENT</th>
              <th>STATUS</th>
              <th>PRODUCT LINE</th>
              <th>CREATED BY</th>
              <th>CREATED AT</th>
              <th>DELIVERY DATE</th>
              <th>TICKETS</th>
              <th>OPPORTUNITY NO</th>
              <th>ACTIONS</th>

            </tr>
          </thead>
        </table>
        <!-- </div> -->
      </div>
    </div>
  </div>

  <script src="<?php echo base_url(); ?>assets_new/js/projectsManagment/view_projects.js"></script>