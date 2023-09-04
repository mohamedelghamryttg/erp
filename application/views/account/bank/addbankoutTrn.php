

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.meceiptin.js"></script>
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

                    <h3 class="card-title">Add Bank Out</h3>
                </div>
            </div>
            <!--begin::Form-->
            <div class="card-body" style="padding-bottom: 0;">
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
                            <option value="" selected=''>-- Select --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', '', $brand_id, '2'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="bank_acc" id="bank_acc">
                    <input type="hidden" name="bank_acc_id" id="bank_acc_id">
                    <input type="hidden" name="bank_acc_name" id="bank_acc_name">
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
                        <input type="text" class="form-control datepicker " name="cdate" id="cdate" value=<?= $date; ?>
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required>
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
                            <?= $this->AccountModel->Allrevenue($brand_id, "", $parent_id) ?>
                        </select>
                    </div>
                    <!-- <input type="hidden" name="rev_acc" id="rev_acc"> -->
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="amount" id="amount" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Check Number</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="check_no" id="check_no"required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Collection date</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control datepicker " name="cdate1" id="cdate1" value=<?= $date1; ?>
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required>
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Currency</label>
                    <input type="hidden" id="curreny_hid" name="curreny_hid">
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency_id" required>
                            <option disabled="disabled" selected="selected">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency() ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Rate</label>
                    <input type="hidden" id="rate_h" name="rate_h">
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="rate" id="rate" required>
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
        $("#submit").click(function (event) {
            $.ajax({
                url: "<?= base_url() . "account/doAddbankoutTrn" ?>",
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
            console.log(bank_id)
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
                            $("#curreny_hid").val(data.currency_id);
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
                            $("#curreny_hid").val('');
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
                $("#curreny_hid").val('');
                $("#rate").prop("disabled", false);
                $('#bank_acc').val('')
                $('#bank_acc_id').val('')
            }
        });

        $("#cdate").on('click', function () {
            var bank_id = $("#bank_id").val();
            var date = $('#cdate').val();
            var curreny_hid = $("#curreny_hid").val();
            if (bank_id != '' && curreny_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/bank_trn_cuttrncy_rate" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'curreny_hid': curreny_hid,
                        'bank_id': bank_id,
                        'date': date
                    },
                    success: function (data) {
                        if (data != '') {
                            // $('select[name="currency_id"]').html(data.options);
                            // $("#curreny_hid").val(data.currency_id);
                            // $('select[name="currency_id"]').prop("disabled", true);
                            $("#rate").val(data.rate);
                            $("#rate_h").val(data.rate);
                            if (data.rate != 0)
                                $("#rate").prop("disabled", true);
                            create_entry();
                        } else {
                            // $('select[name="currency_id"]').prop("disabled", false);
                            $("#rate").val('');
                            $("#rate_h").val('');
                            // $("#curreny_hid").val('');
                            $("#rate").prop("disabled", false);
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
                $("#curreny_hid").val('');
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
            $entry_text1 = "";
            // var acc_revenue = get_account2();
            var bank_id = $("#bank_id").val();
            var trn_id = $("#trn_id").val();
            var amont = $("#amount").val();
            if (bank_id != '' && (amont != 0 || amont != '')) {
                $("#row1").html(`
                "<td data-field="debit" class="datatable-cell"><span
                    style="width: 112px;">` + $("#amount").val() + `</span></td>
                <td data-field="credit"  class="datatable-cell"><span
                    style="width: 112px;"> </span></td>
                <td data-field="account" " class="datatable-cell"><span
                    style="width: 112px;">` + $("#bank_acc_name").val() + ` </span></td>
                <td data-field="trn"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#bank_id option:selected").text() + `</span></td>
                <td data-field="currency"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell">
                    <span style="width: 112px;">
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + $("#amount").val() * $("#rate").val() + `</span> </span>
               </td>`);
            }
            if (trn_id != '' && (amont != 0 || amont != '')) {
                $("#row2").html(`
                "<td data-field="debit" class="datatable-cell"><span
                    style="width: 112px;"></span></td>
                <td data-field="credit"  class="datatable-cell"><span
                    style="width: 112px;"> ` + $("#amount").val() + `</span></td>
                <td data-field="account" " class="datatable-cell"><span
                    style="width: 112px;">` + $("#trn_id option:selected").text() + ` </span></td>
                <td data-field="trn"  class="datatable-cell"><span
                    style="width: 112px;"></span></td>
                <td data-field="currency"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell"><span
                    style="width: 112px;">` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell">
                    <span style="width: 112px;">
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + $("#amount").val() * $("#rate").val() + `</span> </span>
               </td>`);
            }
        }

        $(document).keypress(function (e) {
            if (e.keyCode == 13) {
                $(document.activeElement).next().focus();
            }
        });
    });
</script>