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
                    <h3 class="card-title">Search Payment Method</h3>
                </div>
                <form class="form" id="payment_method" action="<?php echo base_url() ?>account/paymentmethodcode"
                    method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-lg-right">Payment Type</label>
                            <div class="col-lg-3">
                                <select name="type" class="form-control m-b" id="type">
                                    <option value="">-- Select Type --</option>
                                    <option value="1">-- Cash --</option>
                                    <option value="2">-- Bank --</option>
                                    <option value="3">-- Credit Card --</option>
                                </select>
                            </div>

                            <label class="col-lg-3 col-form-label text-lg-right">Payment Method</label>
                            <div class="col-lg-3">
                                <input name="name" id="name" class="form-control m-b">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-lg-right">Account</label>
                            <div class="col-lg-3">
                                <select name="account_id" class="form-control m-b" id="account_id">
                                    <option value="">-- Select Account --</option>
                                    <?= $this->AccountModel->selectCombo_New('account_chart') ?>
                                </select>
                            </div>

                            <label class="col-lg-3 col-form-label text-lg-right">Currency</label>
                            <div class="col-lg-3">
                                <select name="currency_id" class="form-control m-b" id="currency_id">
                                    <option value="">-- Select Currency --</option>
                                    <?= $this->AccountModel->selectCurrency() ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button class="btn btn-success" name="search" type="submit">Search</button>
                                    <a href="<?= base_url() ?>account/paymentmethodcode" class="btn btn-warning"><i
                                            class="la la-trash"></i>Clear Filter</a>

                                    <button class="btn btn-secondary"
                                        onclick="var e2 = document.getElementById('payment_method'); e2.action='<?= base_url() ?>account/exportpaymentmethodcode'; e2.submit();"
                                        name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i>
                                        Export To Excel</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
            <!-- end search form -->
        </div>

        <!--begin::Card-->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">

                    <h3 class="card-label">Payment Method </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>account/Addpaymentmethodcode" class="btn btn-primary font-weight-bolder">
                        <?php } ?>
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path
                                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Add New payment</a>
                    <!--end::Button-->
                </div>
            </div>
            <form class="form" method="post">
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover"
                        id="kt_datatable2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Payment Method</th>
                                <th>Type</th>
                                <th>Bank</th>
                                <th>Account Code</th>
                                <th>Currency</th>
                                <th>Account Link</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($payment_method->num_rows() > 0) {
                                $counter = $offset + 1;
                                foreach ($payment_method->result() as $row) {
                                    ?>
                                    <tr class="">
                                        <td>
                                            <?= $counter; ?>
                                        </td>
                                        <td>
                                            <?= $row->id; ?>
                                        </td>
                                        <td>
                                            <?= $row->name; ?>
                                        </td>
                                        <td>
                                            <?= ($row->type == '1' ? 'Cash' : ($row->type == '2' ? 'Bank' : '')); ?>
                                        </td>
                                        <td>
                                            <?= (isset($row->bank) ? $this->AccountModel->getByID('bank', $row->bank) : '') ?>
                                        </td>
                                        <td>
                                            <?= $row->acc_code; ?>
                                        </td>
                                        <td>
                                            <?= $this->admin_model->getCurrency($row->currency_id) ?>
                                        </td>
                                        <td>
                                            <?= $this->AccountModel->getByID('account_chart', $row->account_id) ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>account/editpaymentmethodcode?t=<?php echo base64_encode($row->id); ?>"
                                                    class="">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->delete == 1) { ?>
                                                <a href="<?php echo base_url() ?>account/deletepaymentmethodcode/<?php echo $row->id ?>"
                                                    title="delete" class=""
                                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="fa fa-times text-danger text"></i> Delete
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter = $counter + 1;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">There is no payment to list</td>
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
            </form>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->