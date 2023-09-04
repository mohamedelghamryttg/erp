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
        <div class="container">


            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Bank Transaction</h3>
                </div>

                <form class="form" id="poList" action="<?php echo base_url() ?>account/bankouttrnlist" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group row">

                            <label class="col-lg-2 control-label" for="role ser">Bank</label>
                            <div class="col-lg-3">
                                <select name='bank_id' class='form-control m-b'>
                                    <option value="" selected=''>-- Select --</option>
                                    <?= $this->AccountModel->selectcombo('bank', "", $brand_id); ?>
                                </select>
                            </div>

                            <label id="acc_type" class="col-lg-2 col-form-label text-right">Revenue</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="trn_id" id="trn_id">
                                    <option value="" selected=''>-- Select --</option>
                                    <?= $this->AccountModel->Allrevenue($brand_id, "", $parent_id); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label" for="role ser">Serial Number</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="ser">
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
                            <label class="col-lg-2 col-form-label text-lg-right">Collection date From</label>
                            <div class="col-lg-3">
                                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">

                            </div>

                            <label class="col-lg-2 control-label" for="role name">Collection date To</label>
                            <div class="col-lg-3">
                                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Check Number</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="check_no" id="check_no" required>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-lg-1 col-form-label text-lg-right">Month</label>
                            <div class="col-lg-2">
                                <select name='months' class='form-control m-b'>
                                    <option value="" selected=''>-- Select --</option>
                                    <?= $this->accounting_model->selectMonth($month); ?>
                                </select>
                            </div>

                            <label class="col-lg-1 control-label" for="role name">Year</label>
                            <div class="col-lg-2">
                                <select name='years' class='form-control m-b'>
                                    <option value="" selected=''>-- Select --</option>
                                    <?= $this->accounting_model->selectYear($year); ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label" for="role sel_date">Date Type</label>
                            <div class="col-lg-2">
                                <select name='sel_date' class='form-control m-b'>
                                    <option value="1">Today</option>
                                    <option value="2">Month/Year</option>
                                    <option value="3">Same Date</option>
                                    <option value="4">Financial Date</option>

                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-primary" name="search" type="submit">Search</button>
                                    <a href="<?= base_url() ?>account/bankouttrnlist" class="btn btn-warning">(x)
                                        Clear
                                        Filter</a>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <!--end::Card-->
        <!-- end search form -->

        <!--begin::Card-->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Bank
                        List
                    </h3>
                </div>
                <div class="card-toolbar">

                    <!--begin::Button-->
                    <?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>account/addbankoutTrn" class="btn btn-primary font-weight-bolder">
                        <?php } ?>
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Add New Bank Note</a>
                        <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Serial</th>
                            <th>Doc Number</th>
                            <th>Date</th>
                            <th>Bank</th>
                            <th>Revenue</th>
                            <th>Amount</th>
                            <th>Check Number</th>
                            <th>Collection date</th>
                            <th>Currency</th>
                            <th>Rate</th>
                            <th>Notes</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($bank_trn->result() as $row) : ?>
                            <?php $i++; ?>
                            <tr>
                                <td>
                                    <?= $i ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>account/editbankoutTrn?t=<?php echo base64_encode($row->id); ?>" class="">
                                        <?= $row->ccode ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <a href="<?php echo base_url() ?>account/editbankoutTrn?t=<?php echo base64_encode($row->id); ?>" class=""><?= $row->doc_no; ?> </a>
                                    </a>
                                </td>
                                <td>
                                    <?= $row->date ?>
                                </td>
                                <td>
                                    <?= $this->AccountModel->getByID('bank', $row->bank_id); ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>account/editbankoutTrn?t=<?php echo base64_encode($row->id); ?>" class="">
                                        <?= $this->AccountModel->getByID('account_chart', $row->trn_id) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= $row->amount ?>
                                </td>
                                <td>
                                    <?= $this->admin_model->getCurrency($row->currency_id) ?>
                                </td>
                                <td>
                                    <?= $row->rate ?>
                                </td>
                                <td>
                                    <?= $row->rem ?>
                                </td>
                                <td>
                                    <?= $this->admin_model->getAdmin($row->created_by); ?>
                                </td>
                                <td>
                                    <?= $row->created_at ?>
                                </td>

                                <td>
                                    <?php if ($permission->edit == 1) : ?>
                                        <a href="<?php echo base_url() ?>account/editbankoutTrn?t=<?php echo base64_encode($row->id); ?>" class="">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                <td>
                                    <?php if ($permission->delete == 1) : ?>
                                        <a href="<?php echo base_url() ?>account/deletebankoutTrn/<?php echo $row->id; ?>" title="delete" class="" onclick="return confirm('Are you sure you want to delete this Bank Out Transaction ?');">
                                            <i class="fa fa-times text-danger text"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <?= $this->pagination->create_links() ?>
                </div>
                <!--end:: Pagination-->

                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->

<script>
    $(document).ready(function() {
        $('#type').on('change', function() {
            console.log("ahmed hmed ")
            var type = $('#type').val()
            var acc_type = $('#acc_type')
            if (type == 1) {
                acc_type.html("Revenue")
            } else {

                acc_type.html("Expenses")
            }
        })
    });
</script>