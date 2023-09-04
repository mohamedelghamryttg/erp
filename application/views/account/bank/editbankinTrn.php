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

                    <h3>Edit bank IN</h3>
                    <input type="hidden" name="serial" id="serial" value="<?= $bankin->ccode ?>">
                    <h3 style="color: darkred;">Serial :
                        <?= $bankin->ccode ?>
                </div>



                <div class="form-group row">
                    <input type="hidden" name="brand" id="brand" value=<?= $brand_id ?>>
                    <label class="col-lg-3 col-form-label text-right">Brand</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="brand_name" id="brand_name" value="<?= $brand ?>"
                            disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-6">
                        <select name='bank_id' class='form-control m-b' id="bank_id" required>

                            <option value="" selected=''>-- Select bank --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', $bankin->bank_id, $brand_id, '2'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="bank_acc" id="bank_acc" value="<?= $acc_setup->bank_acc_id ?>">
                    <input type="hidden" name="bank_acc_id" id="bank_acc_id" value="<?= $acc_setup->bank_acc_id ?>">
                    <input type="hidden" name="bank_acc_name" id="bank_acc_name"
                        value="<?= $this->db->get_where('account_chart', array('id' => $acc_setup->bank_acc_id))->row()->name ?>">
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Internal Number</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="doc_no" id="doc_no"
                            value="<?= $bankin->doc_no ?>">

                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Date</label>
                    <div class="col-lg-6">
                        <input type="text" class="date_sheet form-control" name="cdate" id="cdate"
                            value="<?= date("Y-m-d", strtotime($bankin->date)) ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required
                            value="<?= $bankin->trn_typ ?>">
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Revenue</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_id" id="trn_id" required>
                            <option disabled="disabled" selected="selected" value="">-- Select Revenue Account --
                            </option>
                            <?= $this->AccountModel->Allrevenue($brand_id, $bankin->trn_id, $acc_setup->bank_acc_id) ?>
                        </select>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="amount" id="amount"
                            value="<?= $bankin->amount ?>" required step="any" placeholder="0.00"
                            pattern="^\d*(\.\d{0,2})?$"
                            onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Collection date</label>
                    <div class="col-lg-6">
                        <input type="text" class="date_sheet form-control" name="cdate1" id="cdate1"
                            value="<?= date("Y-m-d", strtotime($bankin->date)) ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Cheque Number</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="check_no" id="check_no"
                            value="<?= $bankin->check_no ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Currency</label>
                    <input type="hidden" id="currency_hid" name="currency_hid" value="<?= $bankin->currency_id ?>">
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency_id" disabled required>
                            <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency($bankin->currency_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Rate</label>
                    <input type="hidden" id="rate_h" name="rate_h" value="<?= $bankin->rate ?>">
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="rate" id="rate" value="<?= $bankin->rate ?>"
                            required step="any" placeholder="0.00000" pattern="^\d*(\.\d{0,5})?$"
                            onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'
                            disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Description</label>
                    <div class="col-lg-6">
                        <textarea id="rem" name="rem" rows="4" cols="40"><?= $bankin->rem ?></textarea>
                    </div>
                </div>
            </div>


            <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>account/cashintrnlist"
                            class="btn btn-default" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
        <br />
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="datatable-bordered datatable-head-custom datatable-table" id="kt_datatable"
                style="display: block;border-top: 1px solid #3F4254;">
                <thead class="datatable-head">
                    <tr class="datatable-row" style="left: 0px;">
                        <th data-field="debit" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Debit</span></th>
                        <th data-field="credit" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Credit</span></th>
                        <th data-field="acount" class="datatable-cell datatable-cell-sort"><span
                                style="width: 164px;">Account</span></th>
                        <th data-field="revenue" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Account Type</span></th>
                        <th data-field="currency" class="datatable-cell datatable-cell-sort"><span
                                style="width: 112px;">Currency</span></th>
                        <th data-field="rate" class="datatable-cell datatable-cell-sort"><span
                                style="width: 60px;">Rate</span></th>
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
        create_entry();

        $("#submit").click(function (event) {
            $.ajax({
                url: "<?= base_url() . "account/doEditbankhinTrn" ?>",
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

        $('#cdate1').datepicker({
            dateFormat: 'yyyy-mm-dd',
            autoClose: true
        });

        $('#cdate').datepicker({
            dateFormat: 'yyyy-mm-dd',
            autoClose: true
        });

        $("#bank_id").on('change', function () {
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


                    success: function (data) {
                        if (data != '') {
                            $('select[name="currency_id"]').html(data.options);
                            $("#currency_hid").val(data.currency_id);
                            $('select[name="currency_id"]').prop("disabled", true);
                            $("#rate").val(data.rate);
                            $("#rate_h").val(data.rate);
                            $('#bank_acc').val(data.bank_acc_acode)
                            $('#bank_acc_id').val(data.bank_acc_id)
                            $("#bank_acc_name").val(data.bank_acc_name);
                            if (data.rate != 0)
                                $("#rate").prop("disabled", true);
                            create_entry();
                        } else {
                            $('select[name="currency_id"]').prop("disabled", false);
                            $("#rate").val('');
                            $("#rate_h").val('');
                            $("#currency_hid").val('');
                            $("#rate").prop("disabled", false);
                            $('#bank_acc').val('')
                            $('#bank_acc_id').val('')
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("disabled", false);
                $("#rate").val('');
                $("#rate_h").val('');
                $("#currency_hid").val('');
                $("#rate").prop("disabled", false);
                $('#bank_acc').val('')
                $('#bank_acc_id').val('')
            }
        });

        $("#cdate").on('click', function () {
            var bank_id = $("# bank_id").val();
            var date = $('#cdate').val();
            var currency_hid = $("#currency_hid").val();
            if (bank_id != '' && currency_hid != '') {
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
                if (data.rate === 0)
                    $("#rate").prop("disabled", false);
            }
        });

        $("#trn_id").on('change', function () {
            create_entry();
        })
        $("#amount").on('focusout', function () {
            create_entry();
        })

        function create_entry() {
            var bank_id = $("#bank_id").val();
            var trn_id = $("#trn_id").val();
            var rate = parseFloat($("#rate").val()).toFixed(5);
            var amont = parseFloat($("#amount").val()).toFixed(2);
            var curr_id = $("#currency_hid").val();
            var html1 = ``;
            var html2 = ``;
            if ((bank_id != '' && bank_id != null) && (amont != 0 || amont != '')) {
                html1 =
                    `<td data-field="debit" class="datatable-cell">
                <span style="width: 112px;"> </span>
                </td>

                <td data-field="credit"  class="datatable-cell">
                    <span style="width: 112px;">` + parseFloat($("#amount").val()).toFixed(2) + ` </span>
                </td>

                <td data-field="trn"  class="datatable-cell"><span
                    style="width: 164px;">` + $("#bank_id option:selected").text() + `</span>
                </td>

                <td data-field="account"  class="datatable-cell">
                    <span style="width: 112px;">` + $("#bank_acc_name").val() + ` </span>
                </td>`;

                if ((curr_id != '' && curr_id != null)) {
                    html1 = html1 +
                        `<td data-field="currency"  class="datatable-cell">
                        <span style="width: 112px;">` + $("#currency_id option:selected").text() + `</span>
                    </td>
                    <td data-field="rate"  class="datatable-cell">
                        <span style="width: 60px;">` + parseFloat($("#rate").val()).toFixed(5) + `</span>
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
                    style="width: 112px;">` + parseFloat($("#amount").val()).toFixed(2) + `</span></td>
                <td data-field="credit"  class="datatable-cell"><span
                    style="width: 112px;"> </span></td>
                <td data-field="account" class="datatable-cell"><span
                    style="width: 164px;">` + $("#trn_id option:selected").text() + ` </span></td>
                <td data-field="trn"  class="datatable-cell"><span
                    style="width: 112px;">`+ $("#rev_name").val() + `</span></td>
                    `;

                if ((curr_id != '' && curr_id != null)) {
                    html2 = html2 +
                        `<td data-field="currency"  class="datatable-cell"><span 
                    style="width: 112px;">` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell"><span
                    style="width: 60px;">` + $("#rate").val() + `</span></td>
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
                if (data.rate === 0)
                    $("#rate").prop("disabled", false);
            }

        });
    })
</script>