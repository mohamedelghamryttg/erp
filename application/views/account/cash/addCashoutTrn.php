<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <form class="cmxform form-horizontal " id="form" method="post" enctype="multipart/form-data"
            style="border: 1px solid brown;border-radius: 105px;">
            <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php } else { ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php } ?>

            <div class="card card-custom example example-compact"
                style="text-align: center;width: 73%;left: 15%;padding-top: 20px;">
                <!-- <div class="card-header">

                </div> -->
                <div class="card-title">
                    <h3 class="card-title">Treasury Receipt</h3>
                    <h3 class="card-title">Add Cash Out</h3>
                </div>
            </div>
            <!--begin::Form-->
            <div class="card-body" style="padding-bottom: 0;">
                <div class="form-group row">
                    <input type="hidden" name="brand" id="brand" value="<?= $brand ?>">

                    <label class="col-lg-3 col-form-label text-right">Brand</label>
                    <div class="col-lg-6">

                        <input type="text" class="form-control" name="brand_name" id="brand_name"
                            value="<?= $this->admin_model->getbrand($this->brand); ?>" disabled>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Cash</label>
                    <div class="col-lg-6">
                        <select name='cash_id' class='form-control m-b' id="cash_id" required>
                            <option value="" selected=''>-- Select Cash --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', '', $brand, '1'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="cash_acc" id="cash_acc">
                    <input type="hidden" name="cash_acc_id" id="cash_acc_id">
                    <input type="hidden" name="cash_acc_name" id="cash_acc_name">
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Internal Number</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="doc_no" id="doc_no">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Date</label>
                    <div class="col-lg-6">
                        <input type="text" class="date_sheet form-control" name="cdate" id="cdate"
                            value="<?= date("Y-m-d") ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required
                            value="<?= $cashout->trn_typ ?>">
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <input type="hidden" name="rev_name" id="rev_name" value="<?= $rev_name ?>">
                    <label class="col-lg-3 col-form-label text-right">Expenses</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_id" id="trn_id" required>
                            <option disabled="disabled" selected="selected" value="">-- Select Revenue Account --
                            </option>
                            <?= $this->AccountModel->Allexpenses($brand, "", $parent_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="amount" id="amount" required step="any"
                            placeholder="0.00" pattern="^\d*(\.\d{0,2})?$"
                            onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Currency</label>
                    <input type="hidden" id="currency_hid" name="currency_hid">
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency_id" required>
                            <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency() ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Rate</label>
                    <input type="hidden" id="rate_h" name="rate_h">
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="rate" id="rate" required step="any"
                            placeholder="0.00000" pattern="^\d*(\.\d{0,5})?$"
                            onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'
                            disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Description</label>
                    <div class="col-lg-6">
                        <textarea id="rem" name="rem" rows="4" cols="40"></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <button type="button" id="submit" class="btn btn-success mr-2" type="text">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>account/cashouttrnlist"
                            class="btn btn-default" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
        <br />
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="datatable-bordered datatable-head-custom datatable-table" id="kt_datatable"
                style="display: block;border-top: 1px solid #3F4254;border-button: 1px solid #3F4254;">
                <thead class="datatable-head">
                    <tr class="datatable-row" style="left: 0px;">
                        <th data-field="debit" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Debit</span></th>
                        <th data-field="credit" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Credit</span></th>
                        <th data-field="acount" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Account</span></th>
                        <th data-field="revenue" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Account Type</span></th>
                        <th data-field="currency" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Currency</span></th>
                        <th data-field="rate" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Rate</span></th>
                        <th data-field="evamount" data-autohide-disabled="false"
                            class="datatable-cell datatable-cell-sort">
                            <span style="width: 112px;">Ev. Amount</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="datatable-body entry_table">
                    <tr data-row="0" class="datatable-row" id="row1" style="left: 0px;">
                    </tr>
                    <tr data-row="0" class="datatable-row" id="row2" style="left: 0px;">
                    </tr>
                </tbody>
            </table>
        </div>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>

<script>
    $(document).ready(function () {
        $("#amount").blur(function () {
            if (this.value === 'NaN') {
                this.value = 0;
            }
            this.value = parseFloat(this.value).toFixed(2);
        });
        $("#rate").blur(function () {
            if ($('#rate_h').val() === 0) {
                $('#rate_h').val() = this.value;
            }
            this.value = parseFloat(this.value).toFixed(5);
            if ($(this).val() == 0) {
                $("#rate").prop("readonly", false);
            }
            else {
                $("#rate").prop("readonly", true);
            }
        });
        $('#cdate').datepicker({
            format: 'yyyy-mm-dd',
            autoClose: true
        });

        $("#submit").click(function (event) {
            $.ajax({
                url: "<?= base_url() . "account/doAddCashoutTrn" ?>",
                type: "POST",
                data: $("#form").serialize(),
                beforeSend: function () {
                    $empty = $('#form').find("input").filter(function () {
                        return this.value === "";
                    });
                    $empty1 = $('#form').find("select").filter(function () {
                        return this.value === "";
                    });
                    $empty2 = $('#form').find("textarea").filter(function () {
                        return this.value === "";
                    });
                    if ($('#amount').val() === 0 || $('#rate_h').val() === 0) {
                        alert('You must fill out all required fields in order to submit a change');
                        return false;
                    }
                    if ($empty.length + $empty1.length + $empty2.length) {
                        alert('You must fill out all required fields in order to submit a change');
                        return false;
                    } else {
                        return true;
                    }
                },
                success: function (data) {
                    window.location = "<?= base_url() ?>" + data;
                }
            });
        });

        $("#cash_id").on('change', function () {
            var cash_id = $("#cash_id").val();
            var date = $("#cdate").val();
            if (cash_id != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'cash_id': cash_id,
                        'date': date
                    },
                    success: function (data) {
                        if (data != '') {
                            $('select[name="currency_id"]').html(data.options);
                            $("#currency_hid").val(data.currency_id);
                            $('select[name="currency_id"]').prop("disabled", true);
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            $('#cash_acc').val(data.cash_acc_acode)
                            $('#cash_acc_id').val(data.cash_acc_id)
                            $("#cash_acc_name").val(data.cash_acc_name);
                            if (data.rate === 0) {
                                $("#rate").prop("disabled", false);
                            } else {
                                $("#rate").prop("disabled", true);
                            }
                            create_entry();
                        } else {
                            $('select[name="currency_id"]').prop("disabled", false);
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            $("#currency_hid").val('');
                            if (data.rate === 0)
                                $("#rate").prop("disabled", false);
                            $('#cash_acc').val('')
                            $('#cash_acc_id').val('')
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("disabled", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                if (data.rate === 0)
                    $("#rate").prop("disabled", false);
                $('#cash_acc').val('')
                $('#cash_acc_id').val('')
            }
        });

        $("#cdate").on('click', function () {
            var cash_id = $("#cash_id").val();
            var date = $('#cdate').val();
            var currency_hid = $("#currency_hid").val();
            if (cash_id != '' && currency_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency_rate" ?>",
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    data: {
                        'currency_hid': currency_hid,
                        'cash_id': cash_id,
                        'date': date
                    },
                    success: function (data) {
                        if (data != '') {
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            if (is_numeric(data.rate))
                                if (data.rate == 0) {
                                    $("#rate").prop("disabled", false);
                                } else {
                                    $("#rate").prop("disabled", true);
                                }
                            else {
                                $("#rate").val(parseFloat(0).toFixed(5));
                                $("#rate").prop("disabled", false);
                            }
                            create_entry();
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            if (data.rate === 0)
                                $("#rate").prop("disabled", false);
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("disabled", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                if (data.rate === 0)
                    $("#rate").prop("disabled", false);
            }
        });

        $("#trn_id").on('change', function () {
            create_entry();
        })
        $("#amount").on('focusout', function () {
            this.value = parseFloat(this.value).toFixed(2);
            create_entry();
        })

        function create_entry() {
            var cash_id = $("#cash_id").val();
            var trn_id = $("#trn_id").val();
            var amont = parseFloat($("#amount").val()).toFixed(5);
            var amont = $("#amount").val();
            var curr_id = $("#currency_hid").val();
            var html1 = ``;
            var html2 = ``;

            if ((cash_id != '' && cash_id != null) && (amont != 0 || amont != '')) {
                html1 =
                    `<td data-field="debit" class="datatable-cell">
                <span style="width: 112px;">  </span>
                </td>

                <td data-field="credit"  class="datatable-cell">
                    <span style="width: 112px;">` + parseFloat($("#amount").val()).toFixed(2) + `</span>
                </td>

                <td data-field="trn"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#cash_id option:selected").text() + `</span>
                </td>

                <td data-field="account"  class="datatable-cell">
                    <span style="width: 112px;">` + $("#cash_acc_name").val() + ` </span>
                </td>`;

                if ((curr_id != '' && curr_id != null)) {
                    html1 = html1 +
                        `<td data-field="currency"  class="datatable-cell">
                        <span style="width: 112px;">` + $("#currency_id option:selected").text() + `</span>
                    </td>
                    <td data-field="rate"  class="datatable-cell">
                        <span style="width: 112px;">` + parseFloat($("#rate").val()).toFixed(5) + `</span>
                    </td>
                    <td data-field="evamount" class="datatable-cell">
                        <span style="width: 112px;">
                            <span class="label label-success label-dot mr-2"></span>
                            <span class="font-weight-bold text-success">` + parseFloat($("#amount").val() * $("#rate").val()).toFixed(2) + `</span> 
                        </span>
                    </td>`;
                }
            }
            $("#row1").html(html1);

            if ((trn_id != '' && trn_id != null) && (amont != 0 || amont != '')) {
                html2 =
                    `<td data-field="debit" class="datatable-cell"><span
                    style="width: 112px;"></span>` + parseFloat($("#amount").val()).toFixed(2) + `</td>
                <td data-field="credit"  class="datatable-cell"><span
                    style="width: 112px;"> </span></td>
                <td data-field="account" class="datatable-cell"><span
                    style="width: 112px;">` + $("#trn_id option:selected").text() + ` </span></td>
                <td data-field="trn"  class="datatable-cell"><span
                    style="width: 112px;">`+ $("#rev_name").val() + `</span></td>
                    `;

                if ((curr_id != '' && curr_id != null)) {
                    html2 = html2 +
                        `<td data-field="currency"  class="datatable-cell"><span 
                    style="width: 112px;">` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell">
                    <span style="width: 112px;">
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + parseFloat($("#amount").val() * $("#rate").val()).toFixed(2) + `</span> </span>
               </td>`;
                }


                $("#row2").html(html2);

            }
        }
        $(document).keypress(function (e) {
            if (e.keyCode === 13) {
                $(document.activeElement).next().focus();
            }
        });
        $("#rate").on('change', function () {
            $("#rate_h").val($(this).val());
            create_entry();
        })
        $("#currency_id").on('change', function () {
            var cash_id = $("#cash_id").val();
            var date = $('#cdate').val();
            var currency_hid = $("#currency_hid").val();
            if (currency_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency_rate" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'currency_hid': currency_hid,
                        'cash_id': cash_id,
                        'date': date
                    },
                    success: function (data) {
                        if (data != '') {
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            if (data.rate === 0) {
                                $("#rate").prop("disabled", false);
                            } else {
                                $("#rate").prop("disabled", true);
                            }
                            create_entry();
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            if (data.rate === 0)
                                $("#rate").prop("disabled", false);
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("disabled", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                $("#rate").prop("disabled", false);
            }
        })
    });

</script>