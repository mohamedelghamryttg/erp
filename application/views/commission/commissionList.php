<div class="content d-flex flex-column flex-column-fluid py-0" id="kt_content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header flex-wrap border-0 pb-0">
                <div class="card-title">
                    <h3 class="card-label">PM Commission List</h3>
                </div>
            </div>
            <div id="calcData">
                <div class="form-group row  mb-2">
                    <input name="calcid" id="calcid" type="hidden" class="form-control">
                    <label class="col-lg-1 col-form-label text-right">Brand :</label>
                    <div class="col-lg-3">
                        <input name="calcBrandid" id="calcBrandid" type="hidden" class="form-control">
                        <input name="calcBrandname" id="calcBrandname" type="text" class="form-control" readonly="readonly">
                    </div>

                    <label class="col-lg-1 col-form-label text-right">Year :</label>
                    <div class="col-lg-2">
                        <input name="calcYear" id="calcYear" type="text" class="form-control " readonly="readonly">
                    </div>

                    <label class="col-lg-1 col-form-label text-right">Month :</label>
                    <div class="col-lg-2">
                        <input name="calcMonthvalue" id="calcMonthvalue" type="hidden" class="form-control">
                        <input name="calcMonth" id="calcMonth" type="text" class="form-control" readonly="readonly">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-lg-4"></div>
                    <label class="col-lg-1 col-form-label text-right">Date From :</label>
                    <div class="col-lg-2">
                        <input name="calcdate_from" id="calcdate_from" type="text" class="form-control" readonly="readonly">
                    </div>

                    <label class="col-lg-1 col-form-label text-right">Date To :</label>
                    <div class="col-lg-2">
                        <input name="calcdate_to" id="calcdate_to" type="text" class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body-fluid">
            <style>
                /* Style the tab */
                .tab {
                    overflow: hidden;
                    border: 1px solid #ccc;
                    background-color: #f1f1f1;
                }

                /* Style the buttons inside the tab */
                .tab button {
                    background-color: inherit;
                    float: left;
                    border: none;
                    outline: none;
                    cursor: pointer;
                    padding: 14px 16px;
                    transition: 0.3s;
                    font-size: 17px;
                }

                /* Change background color of buttons on hover */
                .tab button:hover {
                    background-color: #ddd;
                }

                /* Create an active/current tablink class */
                .tab button.active {
                    background-color: #ccc;
                }

                /* Style the tab content */
                .tabcontent {
                    display: none;
                    padding: 6px 12px;
                    border: 1px solid #ccc;
                    border-top: none;
                }
            </style>
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Tab 1')">PM Commission List</button>
                <button class="tablinks" onclick="openTab(event, 'Tab 2')">PM Monthly Revenue / Cost</button>

            </div>

            <div id="Tab 1" class="tabcontent">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom " id="kt_datatable2">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PM ID</th>
                            <th>PM Name</th>
                            <th>Region</th>
                            <th>month</th>
                            <th>year</th>
                            <th>Revenue</th>
                            <th>Cost</th>
                            <th>Profit</th>
                            <th>Member Commission</th>
                            <th>Stand Commission</th>
                            <th>TeamL Commission</th>
                        </tr>
                    </thead>

                </table>
                <!--end: Datatable-->

            </div>

        </div>
    </div>
</div>
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
                if (!empty($_REQUEST['searchYear'])) {
                    $searchYear = $_REQUEST['searchYear'];
                } else {
                    $searchYear = "";
                }
                if (!empty($_REQUEST['searchMonth'])) {
                    $searchMonth = $_REQUEST['searchMonth'];
                } else {
                    $searchMonth = "";
                }
                if (!empty($_REQUEST['searchBrabd'])) {
                    $searchBrabd = $_REQUEST['searchBrabd'];
                } else {
                    $searchBrabd = "";
                }
                ?>
            </div>

            <div class="modal-body  px-0">
                <div class="col-12">

                    <form class="cmxform form-horizontal" id="searchform" method="post" enctype="multipart/form-data">
                        <div class="card-body  py-3 my-0">
                            <div class="form-group row">
                                <label class="col-lg-1 col-form-label text-lg-right">Brand:</label>
                                <div class="col-lg-3">
                                    <select name="searchBrabd" id="searchBrabd" class="form-control m-b" id="brand" style="width: 100%;" required>
                                        <option value="">-- Select Brand --</option>
                                        <?= $this->admin_model->selectBrand($searchBrabd ?? '') ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-1 col-form-label text-lg-right">Year:</label>
                                <div class="col-lg-3">
                                    <select name="searchYear" class="form-control m-b" id="searchYear" style="width: 100%;" required>
                                        <option value="">-- Select Year --</option>
                                        <?= $this->accounting_model->selectYear($searchYear ?? ''); ?>
                                    </select>
                                </div>
                                <label class="col-lg-1 col-form-label text-lg-right">Month:</label>
                                <div class="col-lg-3">
                                    <select name="searchMonth" class="form-control m-b" id="searchMonth" style="width: 100%;" required>
                                        <option value="">-- Select Month --</option>
                                        <?= $this->accounting_model->selectMonth($searchMonth ?? ''); ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
                <a href="<?= base_url() ?>admin/permission" class="btn btn-warning">(x) Clear Filter</a>
            </div>
        </div>
    </div>
</div>
<style>
    .label {
        width: auto;
        padding: 10px;
    }

    .datepicker {
        z-index: 1100;
    }
</style>
<script src="<?php echo base_url(); ?>assets_new/js/commission/commission.js"></script>