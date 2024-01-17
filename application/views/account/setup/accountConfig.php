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

<!--begin::Container-->
<div class="container">
    <input type="hidden" name="brand" value="<?= $brand ?>">
    <div class="card card-custom example example-compact" style="align-items: center;">
        <div class="card-header center">
            <h3 class="card-title">Account Configuration</h3>
        </div>
    </div>

    <form class="cmxform form-horizontal " method="post" enctype="multipart/form-data" id="config_form">
        <div class="card-body">
            <input type="hidden" class="form-control" name="id" id="id" value="<?= $accConfig->id;
                                                                                ?>">
            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6" for="role sdate1">Information</label>
                <div class="col-md-9 col-sm-6">
                    <input class="form-control date_sheet" type="text" name="sdate1" autocomplete="off" value="<?= "Mysql Version :" . $this->db->platform() . " - " . $this->db->version() . " - PHP Version :" . phpversion() . " - Codeigniter Version :" . CI_VERSION; ?>" disabled>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6" for="role sdate1">Financial Year From
                    Date</label>
                <div class="col-md-2 col-sm-6">
                    <input class="form-control date_sheet" type="text" name="sdate1" autocomplete="off" value="<?php if (isset($accConfig->sdate1)) {
                                                                                                                    echo $accConfig->sdate1;
                                                                                                                };
                                                                                                                ?>" required>

                </div>

                <label class="col-md-3 col-form-label  col-sm-6" for="role sdate2">Date To</label>
                <div class="col-md-2 col-sm-6">
                    <input class="form-control date_sheet" type="text" name="sdate2" autocomplete="off" value="<?php if (isset($accConfig->sdate2)) {
                                                                                                                    echo $accConfig->sdate2;
                                                                                                                };
                                                                                                                ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6">Cash In Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="cashin_num" id="cashin_num" value="<?= $accConfig->cashin_num;
                                                                                                        ?>" maxlength="10">
                </div>

                <label class="col-md-3 col-form-label  col-sm-6">Cash Out Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="cashout_num" id="cashout_num" value="<?= $accConfig->cashout_num;
                                                                                                        ?>" maxlength="10">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6">Bank In Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="bankin_num" id="bankin_num" value="<?= $accConfig->bankin_num;
                                                                                                        ?>" maxlength="10">
                </div>

                <label class="col-md-3 col-form-label  col-sm-6">Bank Out Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="bankout_num" id="bankout_num" value="<?= $accConfig->bankout_num;
                                                                                                        ?>" maxlength="10">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6">Receivable Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="rec_num" id="rec_num" value="<?= $accConfig->rec_num;
                                                                                                ?>" maxlength="10">
                </div>

                <label class="col-md-3 col-form-label  col-sm-6">Payable Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="pay_num" id="pay_num" value="<?= $accConfig->pay_num;
                                                                                                ?>" maxlength="10">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6">Revenue Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="rev_num" id="rev_num" value="<?= $accConfig->rev_num;
                                                                                                ?>" maxlength="10">
                </div>

                <label class="col-md-3 col-form-label  col-sm-6">Expenses Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="exp_num" id="exp_num" value="<?= $accConfig->exp_num;
                                                                                                ?>" maxlength="10">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label  col-sm-6">Manual Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="manual_num" id="manual_num" value="<?= $accConfig->manual_num;
                                                                                                        ?>" maxlength="10">
                </div>
                <label class="col-md-3 col-form-label  col-sm-6">Beginning Transaction Auto Serial</label>
                <div class="col-md-2 col-sm-6">
                    <input type="text" class="form-control" name="begin_num" id="begin_num" value="<?= $accConfig->begin_num;
                                                                                                    ?>" maxlength="10">
                </div>
            </div>



            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Cash Main Account</label>
                <div class="col-lg-6">
                    <select name="cash_acc_id" class="form-control m-b" id="cash_iacc_id" value="<?= $accConfig->cash_acc_id ?>">
                        <option selected="selected" value="">-- Select Cash Main Account --
                        </option>

                        <?= $this->AccountModel->selectCombo_New('account_chart', $accConfig->cash_acc_id) ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Bank Main Account</label>
                <div class="col-lg-6">
                    <select name="bank_acc_id" class="form-control m-b" id="bank_acc_id" value="<?= $accConfig->bank_acc_id ?>">
                        <option selected="selected" value="">-- Select Bank Main Account --</option>

                        <?= $this->AccountModel->selectCombo_New('account_chart', $accConfig->bank_acc_id) ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Revenue Main Account</label>
                <div class="col-lg-6">
                    <select name="rev_acc_id" class="form-control m-b" id="rev_acc_id" value="<?= $accConfig->rev_acc_id; ?>">
                        <option selected="selected" value="">-- Select Expenses Main Account --</option>

                        <?= $this->AccountModel->selectCombo_New('account_chart', $accConfig->rev_acc_id) ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Expenses Main Account</label>
                <div class="col-lg-6">
                    <select name="exp_acc_id" class="form-control m-b" id="exp_acc_id" value="<?= $accConfig->exp_acc_id; ?>">
                        <option value="" selected="selected">-- Select Expenses Main Account --</option>

                        <?= $this->AccountModel->selectCombo_New('account_chart', $accConfig->exp_acc_id) ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Customer Main Account</label>
                <div class="col-lg-6">
                    <select name="cust_acc_id" class="form-control m-b" id="cust_acc_id" value="<?= $accConfig->cust_acc_id ?>">
                        <option value="" selected="selected">-- Select Parent Account --</option>

                        <?= $this->AccountModel->selectCombo_New('account_chart', $accConfig->cust_acc_id) ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Vendor Main Account</label>
                <div class="col-lg-6">
                    <select name="ven_acc_id" class="form-control m-b" id="ven_acc_id" value="<?= $accConfig->ven_acc_id ?>">
                        <option value="" selected="selected">-- Select Parent Account --</option>

                        <?= $this->AccountModel->selectCombo_New('account_chart', $accConfig->ven_acc_id) ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label text-right">Local Currency</label>
                <div class="col-lg-6">
                    <select name="local_currency_id" class="form-control m-b" id="local_currency_id" value="<?= $accConfig->local_currency_id ?>">
                        <option value=""" selected=" selected">-- Select Currency --</option>

                        <?= $this->admin_model->selectCurrency($accConfig->local_currency_id) ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 text-center">
                    </b>
                    <h2><u>Data Adjustments</u></h2></b>
                    <div class="form-group row align-items-center border-dark">
                        <div class="col-md-12 col-sm-6 text-center">
                            <nav class="nav flex-column" style="text-align: left;text-indent: 20%;">
                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="#Date_Modal" data-toggle="modal">
                                    <!-- <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary"
                                        href="javascript:d_cust_inv_calc()" id="d_cust_inv_calc"> -->
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Delete Customer Invoices Entry
                                        </span>
                                    </span>
                                </a>

                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:c_cust_inv_calc()" id="c_cust_inv_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Recreate Customer Invoices Entry
                                        </span>
                                    </span>
                                </a>
                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:d_cust_pay_calc()" id="d_cust_pay_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Delete Customer Payments Entry
                                        </span>
                                    </span>
                                </a>
                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:c_cust_pay_calc()" id="c_cust_pay_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Recreate Customer Payments Entry
                                        </span>
                                    </span>
                                </a>


                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:d_ven_inv_calc()" id="d_ven_inv_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Delete Vendor Invoices Entry
                                        </span>
                                    </span>
                                </a>
                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:c_ven_inv_calc()" id="c_ven_inv_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Recreate Vendor Invoices Entry
                                        </span>
                                    </span>
                                </a>

                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:d_ven_pay_calc()" id="d_ven_pay_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Delete Vendor Payments Entry
                                        </span>
                                    </span>
                                </a>
                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="javascript:d_ven_pay_calc()" id="d_ven_pay_calc">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Recreate Vendor Payments Entry
                                        </span>
                                    </span>
                                </a>
                                <hr width="100%" color="darkgray" size="50px" />

                                <a class="nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary" href="#myModal" data-toggle="modal">
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Import Payment Method From Excel
                                        </span>
                                    </span>
                                </a>

                                <hr width="100%" color="darkgray" size="50px" />

                                <a class='btn nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary  text-left' id='job_rev_calc'>
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Calculate Jobs Revenue and Revenue Local
                                        </span>
                                    </span>
                                </a>

                                <a class='btn nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary text-left' id='job_cost_tr_calc'>
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Calculate Jobs Translation Cost
                                        </span>
                                    </span>
                                </a>

                                <a class='btn nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary text-left' id='job_cost_le_calc'>
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Calculate Jobs LE Cost
                                        </span>
                                    </span>
                                </a>

                                <a class='btn nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary text-left' id='job_cost_dtp_calc'>
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Calculate Jobs DTP Cost
                                        </span>
                                    </span>
                                </a>


                                <a class='btn nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary text-left' id='job_cost_ext_calc'>
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Calculate Jobs Venfor Cost
                                        </span>
                                    </span>
                                </a>

                                <a class='btn nav-link font-weight-bold font-size-h5 text-dark-75 text-hover-primary text-left' id='job_cost_all_calc'>
                                    <span class="text-nowrap">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 3%;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Calculate Jobs Total Cost
                                        </span>
                                    </span>
                                </a>

                            </nav>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <button type="text" class="btn btn-success mr-2" id="submit">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>admin" type="button">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 120%;">
            <div class="modal-header">
                <h2>Import Payment Method</h2>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Select Excel File To Import</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="import_form" name="formdata" enctype="multipart/form-data">
                    <div class="form-group">
                        <p><label>Select Excel File</label>
                            <input type="file" name="file" id="file" required accept=".xls,.xlsx" />
                        </p>
                    </div>
                    <input type="submit" name="import" value="Import" class="btn btn-success" />
                </form>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="Date_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 120%;">
            <div class="modal-header">
                <h2>Select Date Range</h2>
                <p id="selection_name" calss="selection_name"></p>
            </div>
            <div class="modal-body">
                <form method="post" id="date_selection" name="formdata1" enctype="multipart/form-data">
                    <div class="form-group">
                        <p><label>Date From</label>
                            <input type="date" name="file" id="file" required accept=".xls,.xlsx" />
                        </p>
                        <p><label>Date To</label>
                            <input type="date" name="file" id="file" required accept=".xls,.xlsx" />
                        </p>

                    </div>
                    <input type="submit" name="submit" value="Submit" class="btn btn-success" />
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#submit").on('click', function(e) {
            e.preventDefault();
            var vsdate1 = $('#sdate1').val()
            var vsdate2 = $('#sdate2').val()

            $.ajax({
                url: "<?= base_url('account/saveAccountConfig') ?>",
                type: "post",
                data: $('#config_form').serialize(),
                success: function(data) {
                    window.location = "<?= base_url() . "account/accountConfig" ?>";
                },
                error: function(jqXHR, exception) {
                    // alert(data);
                    console.log(jqXHR.dataText);
                }
            });
        });

        $('#Date_Modal').on('show.bs.modal', function(event) {
            var myVal = $(event.relatedTarget).data('val');
            $(this).find(".selection_name").text(myVal);
        });
        event.preventDefault();
    });
    $('#date_selection').on('submit', function(event) {
        event.preventDefault();
        var conf = confirm('Are you sure you want to Import Payment Method Data  ?');
        if (conf) {

            $.ajax({
                url: "<?php echo base_url(); ?>account/c_cust_invoice_entry",
                method: "POST",
                data: new FormData(formdata),
                data: $('#date_selection').serialize(),
                beforeSend: function() {
                    $('#loading').show();
                    $("#Date_Modal").modal('hide');
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })
        }
    })


    $('#import_form').on('submit', function(event) {
        event.preventDefault();
        var conf = confirm('Are you sure you want to Import Payment Method Data  ?');
        if (conf) {
            $.ajax({
                // url: "<?php echo base_url(); ?>account/importPaymentMethod",
                url: "<?php echo base_url(); ?>account/importhr",
                method: "POST",
                data: new FormData(formdata),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    alert(data);
                    $("#import_form").modal('hide');
                }
            })
        }
    })

    $("#job_rev_calc").on('click', function() {
        var conf = confirm('Are you sure you want to Calculate Jobs Revenue and Revenue Local ?');
        if (conf) {
            $.ajax({
                url: "<?php echo base_url(); ?>account/job_rev_calc",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })

        }
    })

    $("#job_cost_tr_calc").on('click', function() {
        var conf = confirm('Are you sure you want to Calculate Jobs Translation Cost ?');
        if (conf) {
            $.ajax({
                url: "<?php echo base_url(); ?>account/job_cost_tr_calc",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })

        }
    })
    $("#job_cost_le_calc").on('click', function() {
        var conf = confirm('Are you sure you want to Calculate Jobs LE Cost ?');
        if (conf) {
            $.ajax({
                url: "<?php echo base_url(); ?>account/job_cost_le_calc",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })

        }
    })
    $("#job_cost_dtp_calc").on('click', function() {
        var conf = confirm('Are you sure you want to Calculate Jobs DTP Cost ?');
        if (conf) {
            $.ajax({
                url: "<?php echo base_url(); ?>account/job_cost_dtp_calc",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })

        }
    });
    $("#job_cost_ext_calc").on('click', function() {
        var conf = confirm('Are you sure you want to Calculate Jobs Vendor Cost ?');
        if (conf) {
            $.ajax({
                url: "<?php echo base_url(); ?>account/job_cost_ext_calc",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })

        }
    });
    $("#job_cost_all_calc").on('click', function() {
        var conf = confirm('Are you sure you want to Total Cost ?');
        if (conf) {
            $.ajax({
                url: "<?php echo base_url(); ?>account/job_cost_all_calc",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })

        }
    })
    $("#c_cust_pay_calc").on('click', function() {
        event.preventDefault();
        var conf = confirm('Are you sure you want to Recreate Customer Payment Entry Data  ?');
        if (conf) {

            $.ajax({
                url: "<?php echo base_url(); ?>account/c_cust_payment_entry",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })
        }
    })
    $("#c_cust_inv_calc").on('click', function() {
        event.preventDefault();
        var conf = confirm('Are you sure you want to Recreate Invoices Data Entry ?');
        if (conf) {

            $.ajax({
                url: "<?php echo base_url(); ?>account/c_cust_invoice_entry",
                method: "POST",
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    alert(data);
                }
            })
        }
    })


    function d_cust_inv_calc() {
        var conf = confirm('Are you sure you want to Delete All Customer Invoices Entry ?');

    }
</script>