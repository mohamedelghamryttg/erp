<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <form class="cmxform form-horizontal " id="form" method="post" enctype="multipart/form-data">
            <?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php else : ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php endif; ?>

            <div class="card text-center">
                <div class="card-header">
                    <h3>Edit Bank In</h3>
                    <input type="hidden" name="serial" id="serial" value="<?= $bankin->ccode ?>">
                    <h3 style="color: darkred;"><u>Serial :<?= $bankin->ccode ?></u></h3>
                </div>
            </div>
            <!--begin::Form-->
            <input type="hidden" name="id" value="<?= base64_encode($bankin->id) ?>">

            <div class="card-body py-0 shadow-lg p-3 mb-5 bg-white rounded">
                <input type="hidden" name="brand" id="brand" value="<?= $brand ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-6">
                        <select name='bank_id' class='form-control m-b' id="bank_id" required value="<?= $bankin->bank_id ?>">
                            <option value="" selected='' disabled>-- Select bank --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', $bankin->bank_id, $brand, '2'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="bank_acc" id="bank_acc" value="<?= $cash_acc ?>">
                    <input type="hidden" name="bank_acc_id" id="bank_acc_id" value="<?= $cash_acc_id ?>">
                    <input type="hidden" name="bank_acc_name" id="bank_acc_name" value="<?= $cash_acc_name ?>">
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Date</label>
                    <div class="col-lg-6">
                        <input type="text" class="date_sheet form-control" name="cdate" id="cdate" value="<?= date("Y-m-d", strtotime($bankin->date)) ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Internal Number</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="doc_no" id="doc_no" value="<?= $bankin->doc_no ?>">
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="auto_num" class="btn btn-success mr-2"> Auto Number</button>
                    </div>
                </div>
                <div class="form-group row" hidden>
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required value="<?= $bankin->trn_typ ?>">
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="Other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <input type="hidden" name="rev_name" id="rev_name" value="<?= $rev_name ?>">
                    <label class="col-lg-3 col-form-label text-right">Revenue</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_id" id="trn_id" required value="<?= $bankin->trn_id ?>">
                            <option disabled="disabled" selected="selected" value="">-- Select Revenue Account --
                            </option>
                            <?= $this->AccountModel->Allrevenue($brand, $bankin->trn_id, $acc_setup->bank_acc_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="amount" id="amount" value="<?= $bankin->amount ?>" required step="any" placeholder="0.00" pattern="^\d*(\.\d{0,2})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Cheque Number</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="check_no" id="check_no" value="<?= $bankin->cheque_no ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Collection date</label>
                    <div class="col-lg-6">
                        <input type="text" class="date_sheet form-control" name="cdate1" id="cdate1" value="<?= date("Y-m-d", strtotime($bankin->cheque_date ?? '')) ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Currency</label>
                    <input type="hidden" id="currency_hid" name="currency_hid" value="<?= $bankin->currency_id ?>">
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency_id" disabled required value="<?= $bankin->currency_id ?>">
                            <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency($bankin->currency_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Rate</label>
                    <input type="hidden" id="rate_h" name="rate_h" value="<?= $bankin->rate ?>">
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="rate" id="rate" value="<?= $bankin->rate ?>" required step="any" placeholder="0.00000" pattern="^\d*(\.\d{0,5})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)' disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Description</label>
                    <div class="col-lg-6">
                        <textarea id="rem" name="rem" rows="4" cols="40"><?= $bankin->rem ?></textarea>
                    </div>
                </div>


                <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>account/bankintrnlist" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br />
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="datatable-bordered datatable-head-custom datatable-table" id="kt_datatable" style="display: block;border-top: 1px solid #3F4254;">
                <thead class="datatable-head">
                    <tr class="datatable-row" style="left: 0px;">
                        <th data-field="debit" class="datatable-cell px-0"><span style="width: 112px;">Debit</span></th>
                        <th data-field="credit" class="datatable-cell px-0"><span style="width: 112px;">Credit</span></th>
                        <th data-field="acount" class="datatable-cell  px-0"><span style="width: 150px;">Account</span></th>
                        <th data-field="revenue" class="datatable-cell  px-0"><span style="width: 150px;">Transaction</span></th>
                        <th data-field="currency" class="datatable-cell  px-0"><span style="width: 112px;">Currency</span></th>
                        <th data-field="rate" class="datatable-cell  px-0"><span style="width: 112px;">Rate</span></th>
                        <th data-field="evamount" data-autohide-disabled="false" class="datatable-cell  px-0">
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
    $(document).ready(function() {
        create_entry();
        $("#amount").blur(function() {
            if (this.value === 'NaN') {
                this.value = 0;
            }
            this.value = parseFloat(this.value).toFixed(2);
        });
        $("#rate").blur(function() {
            if ($('#rate_h').val() === 0) {
                $('#rate_h').val() = this.value;
            }
            this.value = parseFloat(this.value).toFixed(5);
            if ($(this).val() == 0) {
                $("#rate").prop("readonly", false);
            } else {
                $("#rate").prop("readonly", true);
            }
        });

        $("#submit").click(function(event) {
            $.ajax({
                url: "<?= base_url() . "account/doEditbankinTrn" ?>",
                type: "POST",
                data: $("#form").serialize(),
                beforeSend: function() {
                    $empty = $('#form').find("input").filter(function() {
                        return this.value === "";
                    });
                    $empty1 = $('#form').find("select").filter(function() {
                        return this.value === "";
                    });
                    $empty2 = $('#form').find("textarea").filter(function() {
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
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.records != 0)
                        alert("Bank In Already Exists!");
                    else
                        window.location = "<?= base_url("account/bankintrnlist") ?>";
                }
            });
        });

        $("#bank_id").on('change', function() {
            var bank_id = $("#bank_id").val();
            var date = $("#cdate").val();
            if (bank_id != '') {
                $.ajax({
                    url: "<?= base_url() . "account/bank_trn_cuttrncy" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'bank_id': bank_id,
                        'date': date
                    },
                    success: function(data) {
                        if (data != '') {
                            $('select[name="currency_id"]').html(data.options);
                            $("#currency_hid").val(data.currency_id);
                            $('select[name="currency_id"]').prop("readonly", true);
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            $('#bank_acc').val(data.bank_acc_acode)
                            $('#bank_acc_id').val(data.bank_acc_id)
                            $("#bank_acc_name").val(data.bank_acc_name);
                            if (data.rate === 0) {
                                $("#rate").prop("readonly", false);
                            } else {
                                $("#rate").prop("readonly", true);
                            }
                            create_entry();
                        } else {
                            $('select[name="currency_id"]').prop("readonly", false);
                            $("#rate").val('0');
                            $("#rate_h").val('0');
                            $("#currency_hid").val('');
                            $("#rate").prop("readonly", false);
                            $('#bank_acc').val('')
                            $('#bank_acc_id').val('')
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("readonly", false);
                $("#rate").val('0');
                $("#rate_h").val('0');
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
                $('#bank_acc').val('')
                $('#bank_acc_id').val('')
            }
        });
        $("#cdate1").datetimepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            defaultDate: new Date()
        });

        $("#cdate").datetimepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            defaultDate: new Date()
        });

        $("#cdate").on('change.datetimepicker', function() {
            var bank_id = $("#bank_id").val();
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
                        'bank_id': bank_id,
                        'date': date
                    },
                    success: function(data) {
                        if (data != '') {
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            if (data.rate === 0) {
                                $("#rate").prop("readonly", false);
                            } else {
                                $("#rate").prop("readonly", true);
                            }
                            create_entry();
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            $("#rate").prop("readonly", false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("disabled", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
            }
        });

        $("#trn_id").on('change', function() {
            create_entry();
        });
        $("#amount").on('focusout', function() {
            this.value = parseFloat(this.value).toFixed(2);
            create_entry();
        })

        function create_entry() {
            $entry_text1 = "";
            var bank_id = $("#bank_id").val();
            var trn_id = $("#trn_id").val();
            var amont = $("#amount").val();
            if ((bank_id != '' && bank_id != null) && (amont != 0 || amont != '')) {
                $("#row1").html(`
                "<td data-field="debit" class="datatable-cell px-0"  style="width: 112px;"><span
                   >` + $("#amount").val() + `</span></td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                    > </span></td>
                <td data-field="account" " class="datatable-cell px-0"  style="width: 150px;"><span
                   >` + $("#bank_acc_name").val() + ` </span></td>
                <td data-field="trn"  class="datatable-cell px-0"  style="width: 150px;"><span
                    >` + $("#bank_id option:selected").text() + `</span></td>
                <td data-field="currency"  class="datatable-cell px-0"  style="width: 112px;"><span
                   >` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell px-0"  style="width: 112px;"><span
                    >` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell px-0"  style="width: 112px;">
                    <span >
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + $("#amount").val() * $("#rate").val() + `</span> </span>
               </td>`);
            }

            if ((trn_id != '' && trn_id != null) && (amont != 0 && amont != '')) {
                $("#row2").html(`
                "<td data-field="debit" class="datatable-cell px-0" style="width: 112px;"><span
                    ></span></td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                   > ` + $("#amount").val() + `</span></td>
                <td data-field="account" " class="datatable-cell px-0"  style="width: 150px;"><span
                    >` + $("#trn_id option:selected").text() + ` </span></td>
                <td data-field="trn"  class="datatable-cell px-0" style="width: 150px;"><span
                    ></span></td>
                <td data-field="currency"  class="datatable-cell px-0" style="width: 112px;"><span
                    >` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell px-0" style="width: 112px;"><span
                    >` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell px-0" style="width: 112px;">
                    <span >
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + $("#amount").val() * $("#rate").val() + `</span> </span>
               </td>`);
            }
        }
        $(document).keypress(function(e) {
            if (e.keyCode === 13) {
                $(document.activeElement).next().focus();
            }
        });
        $("#rate").on('change', function() {
            $("#rate_h").val($(this).val());
            create_entry();
        })

        $("#currency_id").on('change', function() {
            $("#currency_hid").val($("#currency_id").val());
            var bank_id = $("#bank_id").val();
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
                        'bank_id': bank_id,
                        'date': date
                    },
                    success: function(data) {
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
                            $("#rate").prop("readonly", false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("readonly", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
            }
        });
    })
    $('#auto_num').click(function() {
        var date_trns = $('#cdate').val();
        var dt = new Date(date_trns);
        var dtm = dt.getMonth() + 1;
        if (dtm == 0) {
            dtm = 12
        }
        var ntm = parseInt(document.getElementById("doc_no").value.substr(0, 2));
        if (dtm != ntm) {
            $.ajax({
                url: "<?= base_url("account/auto_num_Transaction") ?>",
                type: "POST",
                data: {
                    'cdate': date_trns,
                    'transaction': 'Bank In',
                },
                success: function(data) {
                    //var data = JSON.parse(data);
                    // console.log(data);
                    document.getElementById("doc_no").value = data;
                }
            });
        }
    })
</script>