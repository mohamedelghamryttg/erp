<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <form class="form" id="form" enctype="multipart/form-data">
            <?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php else : ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php endif; ?>

            <div class="card text-center">
                <div class="card-header">
                    <h3>Treasury Receipt Add Cash Out</h3>
                </div>
            </div>
            <!--begin::Form-->

            <div class="card-body py-0 shadow-lg p-3 mb-5 bg-white rounded">
                <input type="hidden" name="brand" id="brand" value="<?= $brand ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Cash</label>
                    <div class="col-lg-6">
                        <select name='cash_id' class='form-control m-b' id="cash_id" required>
                            <option value="" selected='' disabled>-- Select Cash --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', '', $brand, '1'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="cash_acc" id="cash_acc">
                    <input type="hidden" name="cash_acc_id" id="cash_acc_id">
                    <input type="hidden" name="cash_acc_name" id="cash_acc_name">
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Date</label>
                    <div class="col-lg-2">
                        <div id="target" style="position:relative" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" id="cdate" name="cdate" data-toggle="datetimepicker" data-target="#Datetimepicker" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- </div>
                <div class="form-group row"> -->
                    <label class="col-lg-2 col-form-label text-right">Document Number</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="doc_no" id="doc_no" required>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="auto_num" class="btn btn-success mr-2"> Auto Number</button>
                    </div>
                </div>
                <div class="form-group row" hidden>
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required>
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="Other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <input type="hidden" name="rev_name" id="rev_name" value="<?= $rev_name ?>">
                    <label class="col-lg-3 col-form-label text-right">Expenses</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_id" id="trn_id" required>
                            <option disabled="disabled" selected="selected" value="">-- Select Expenses Account --</option>
                            <?= $this->AccountModel->Allexpenses($brand, "", $parent_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="amount" id="amount" required step="any" placeholder="0.00" pattern="^\d*(\.\d{0,2})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
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
                        <input type="number" class="form-control" name="rate" id="rate" required step="any" placeholder="0.00000" pattern="^\d*(\.\d{0,5})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">File Attach</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="doc_file" id="doc_file" accept=".zip,.rar,.7zip">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">File Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" name="desc_file" id="desc_file" rows="1" cols="40"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" id="rem" name="rem" rows="4" cols="40" required></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <button id="submit" class="btn btn-success mr-2">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>account/cashouttrnlist" class="btn btn-default" type="button">Cancel</a>

                    </div>
                </div>
            </div>

        </form>

        <div class="container-fluid">
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="datatable-bordered datatable-head-custom datatable-table" id="kt_datatable" style="display: block;border-top: 1px solid #3F4254; border-bottom: 1px solid #3F4254;">
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
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
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
        });

        $("#form").submit(function(e) {
            // .click(function(event) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url() . "account/doAddCashoutTrn" ?>",
                type: "POST",
                // dataType: "json",
                // data: $("#form").serialize(),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    if ($('#amount').val() === 0 || $('#rate_h').val() === 0) {
                        alert('You must fill Amount fields in order to submit a change');
                        return false;
                    }

                },
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.records == 1)
                        alert("Cash Out Receipt Already Exists!");
                    else if (data.records == 2) {
                        alert("Can Not Upload File !");
                    } else {
                        window.location = "<?= base_url("account/cashouttrnlist") ?>";
                    }
                }
            });
        });

        $("#cash_id").on('change', function() {
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
                    success: function(data) {
                        if (data != '') {
                            $('select[name="currency_id"]').html(data.options);
                            $("#currency_hid").val(data.currency_id);
                            $('select[name="currency_id"]').prop("readonly", true);
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            $('#cash_acc').val(data.cash_acc_acode)
                            $('#cash_acc_id').val(data.cash_acc_id)
                            $("#cash_acc_name").val(data.cash_acc_name);
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
                            $('#cash_acc').val('')
                            $('#cash_acc_id').val('')
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
                $('#cash_acc').val('')
                $('#cash_acc_id').val('')
            }
        });

        $("#cdate").datetimepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            defaultDate: new Date()
        });

        $("#cdate").on('change.datetimepicker', function() {
            var cash_id = $("#cash_id").val();
            var date = $('#cdate').val();
            var currency_hid = $("#currency_hid").val();
            if (currency_hid != '') {
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
                $('select[name="currency_id"]').prop("readonly", false);
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
            var cash_id = $("#cash_id").val();
            var trn_id = $("#trn_id").val();
            var amont = $("#amount").val();
            if ((cash_id != '' && cash_id != null) && (amont != 0 || amont != '')) {
                $("#row1").html(`
                "<td data-field="debit" class="datatable-cell px-0"  style="width: 112px;"><span
                   ></span></td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                    >` + $("#amount").val() + ` </span></td>
                <td data-field="account" " class="datatable-cell px-0"  style="width: 150px;"><span
                   >` + $("#cash_acc_name").val() + ` </span></td>
                <td data-field="trn"  class="datatable-cell px-0"  style="width: 150px;"><span
                    >` + $("#cash_id option:selected").text() + `</span></td>
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
                    ></span>` + $("#amount").val() + `</td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                   > </span></td>
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
        });
        $("#currency_id").on('change', function() {
            $("#currency_hid").val($("#currency_id").val());
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
                $('select[name="currency_id"]').prop("readonly", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
            }
        })
    });
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
                    'transaction': 'Cash Out'
                },
                success: function(data) {
                    document.getElementById("doc_no").value = data;
                }
            });
        }
    })
</script>