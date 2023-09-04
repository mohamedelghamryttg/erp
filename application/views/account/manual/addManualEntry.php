<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-custom example example-compact" style="align-items: center;">
            <div class="card-header center">
                <h3 class="card-title">Add Manual Entry</h3>
            </div>
            <form class="cmxform form-horizontal " id="form" method="post" enctype="multipart/form-data">
                <?php if (isset($_SERVER['HTTP_REFERER'])): ?>
                    <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
                <?php else: ?>
                    <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
                <?php endif; ?>
                <!--begin::Form-->
                <div class="card-body" style="padding-bottom: 0;">
                    <input type="hidden" name="brand" id="brand" value="<?= $brand ?>">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Document Internal Number</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" name="doc_no" id="doc_no">

                        </div>
                        <div class="col-lg-2">
                            <button type="button" id="auto_num" class="btn btn-success mr-2"> Auto Number</button>
                        </div>
                        <label class="col-lg-2 col-form-label text-right">Document Date</label>
                        <div class="col-lg-3">
                            <input type="text" class="date_sheet form-control" name="cdate" id="cdate"
                                value="<?= date("Y-m-d") ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Currency</label>
                        <input type="hidden" id="currency_hid" name="currency_hid">
                        <div class="col-lg-3">
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
                    <hr />
                    <div class="form-group row">
                        <label class="col-lg-3 control-label font-weight-bold ">Add Entry Accounts :
                            <a onClick='AddAccount()' id='Add_brand_account' class='btn btn-sm btn-clean'
                                data-toggle="tooltip" data-placement="top" title="Add New Account"><i
                                    class="fa fa-plus-circle"></i></a>
                        </label>
                    </div>

                    <div class="form-group row"
                        style="border-top: 1px solid #3F4254; border-bottom: 1px solid #3F4254;margin-bottom: 0;">
                        <div class="col-lg-3">
                            <div calss="row" style="display: flex;">
                                <div class="col-lg-6 col-form-label text-center">
                                    <label>Debit</label>
                                </div>
                                <div class="col-lg-6 col-form-label text-center">
                                    <label>Credit</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-form-label text-center">
                            <label>Account</label>
                        </div>
                        <div class="col-lg-3 col-form-label text-center">
                            <label>Third Party</label>
                        </div>
                        <div class="col-lg-2">
                            <div calss="row" style="display: flex;">
                                <div class="col-lg-10 col-form-label text-center">
                                    <label>Evaluation</label>
                                </div>
                                <div class="col-lg-2 col-form-label text-center">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table"></div>
                    <div class="form-group row " style="border-top: 1px solid #3F4254;">
                        <div class="col-lg-3">
                            <div calss="row" style="display: flex;">
                                <div class="col-lg-6 col-form-label text-center">
                                    <input type="text" class="form-control text-right" id="tot_debit" name="tot_debit"
                                        step="0.01" pattern="^\d*(\.\d{0,2})?$" value="0.00" readonly>
                                </div>
                                <div class="col-lg-6 col-form-label text-center">
                                    <input type="text" class="form-control text-right" id="tot_credit" name="tot_credit"
                                        step="0.01" pattern="^\d*(\.\d{0,2})?$" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-form-label text-center"></div>
                        <div class="col-lg-3 col-form-label text-center"></div>
                        <div class="col-lg-2">
                            <div calss="row" style="display: flex;">
                                <div class="col-lg-10 col-form-label text-center">
                                </div>
                                <div class="col-lg-2 col-form-label text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        input[type=number]::-webkit-inner-spin-button,
                        input[type=number]::-webkit-outer-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                            padding: 4px;

                        }

                        input[type=number] {
                            -moz-appearance: textfield;
                            padding: 4px;

                        }
                    </style>
                    <div class="form-group row addscroll">
                        <label class="col-lg-3 control-label font-weight-bold ">Add Entry Accounts :
                            <a onClick='AddAccount()' id='Add_brand_account' class='btn btn-sm btn-clean'
                                data-toggle="tooltip" data-placement="top" title="Add New Account"><i
                                    class="fa fa-plus-circle"></i></a>
                        </label>
                    </div>
                    <div id="accounts" style="display:none;">
                        <div class="card border border-default accountCard m-2 row table_row"
                            style="border: 1px #cccbcb  solid !important;padding-bottom: 7px;">
                            <div class="p-5 d-flex align-items-center">
                                <div class="col-lg-3">
                                    <div class="row" style="display: flex;">
                                        <div class="col-lg-6" id="deb">
                                            <input type="text" class="form-control text-right" id="debit" name="debit"
                                                value="0.00" step="0.01" pattern="^\d*(\.\d{0,2})?$" min=".00">
                                        </div>

                                        <div class="col-lg-6" id="crd">
                                            <input type="text" class="form-control text-right" id="credit" name="credit"
                                                value="0.00" step="0.01" pattern="^\d*(\.\d{0,2})?$" min=".00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" id="acc">
                                    <select class="form-control" name="account_id" id="account_id" required>
                                        <option selected="selected" value="" disabled="disabled">-- Select Account --
                                        </option>
                                        <?= $this->AccountModel->selectCombo_Where('account_chart', ['acc' => 0, 'brand' => $brand]); ?>
                                    </select>
                                </div>

                                <div class="col-lg-3" id="acc_third">

                                </div>
                                <div class="col-lg-2 eval">
                                    <div class="row" style="display: flex;">
                                        <div class="col-lg-10" id="ev">
                                            <input type="text" class="form-control text-right" id="ev" name="ev"
                                                value="0.00" pattern="" step="0.01" readonly>
                                        </div>

                                        <div class="col-lg-2" style="padding: 0;">
                                            <a class='btn btn-sm btn-clean btn-icon p-0 delete_account'
                                                data-toggle="tooltip" data-placement="top" title="Delete Account"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row_detals">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-9" id="desc">
                                    <textarea class="form-control text-left" id="desc_text" name="desc_text"
                                        rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-center">

                    <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                    <a class="btn btn-secondary" href="<?php echo base_url() ?>account/ManualEntryList"
                        class="btn btn-default" type="button">Cancel</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var row_number = 0;

    function create_entry() {
        row_number++;
        $('#accounts [name="account_id"]').attr('id', `account_id${row_number}`);
        $('#accounts [name="desc_text"]').attr('id', `desc_text${row_number}`);
        $(".card-body .table").append($("#accounts").html());
        accountCount();
        $('html, body').animate({ scrollTop: $(".addscroll ").offset().top });
    }

    function AddAccount() {
        if ($("#rate").val() > 0) {
            const acc_id = $(".table").children().last().children().first().children().first().nextAll('#acc').find('select').val();
            if (acc_id || $(".table").children().length == 0) {
                create_entry();
            } else {
                alert('Choose an Account First!');
            }
        } else {
            alert('Choose Valid Currency First!');
        }
    }

    function check_ev() {
        $('.table div.table_row').each(function () {
            const debit = $(this).find('#debit').val().replace(/,/g, '');
            const credit = $(this).find('#credit').val().replace(/,/g, '');
            if (debit != 0) {
                $(this).find('[name="ev"]').val(parseFloat(parseFloat(debit) * $("#rate").val()).toFixed(2).replace(/[^\d.]/g, "")
                    .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3').replace(/\.(\d{2})\d+/, '.$1')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
            if (credit != 0) {
                $(this).find('[name="ev"]').val(parseFloat(parseFloat(credit) * $("#rate").val()).toFixed(2).replace(/[^\d.]/g, "")
                    .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3').replace(/\.(\d{2})\d+/, '.$1')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
        });
    }

    function accountCount() {
        $('.table div.table_row').each(function () {
            $(this).find('#acc .select2-container').remove();
            $(this).find(`[name="account_id"]`).select2({
                dropdownCssClass: "selectheight"
            });
            $(this).find('.select2-container').css('width', '100%');
        });
    }
    $('#auto_num').click(function () {
        var date_trns = $('#cdate').val();

        $.ajax({
            url: "<?= base_url("account/auto_num") ?>",
            type: "POST",
            data: {
                'cdate': date_trns,
            },
            success: function (data) {
                //var data = JSON.parse(data);
                console.log(data);
                document.getElementById("doc_no").value = data;
            }
        });
    })
    document.addEventListener("keypress", function (event) {
        // alert(event.keyCode);
        if (event.keyCode == 43) {
            AddAccount();
        }
    });
    $(document).ready(function () {

        $("#rate").blur(function () {
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

        $('#cdate').datepicker({
            format: 'yyyy-mm-dd',
            autoClose: true
        });

        $("#submit").click(function (event) {
            $empty = $('#form').find("input").filter(function () {
                return this.value === "";
            });
            $empty1 = $('#currency_id').filter(function () {
                return this.value === "";
            });
            if ($.trim($("#rem").val()).length == 0) {
                $empty2 = '1';
            } else {
                $empty2 = '';
            };
            if ($('#rate_h').val() === 0) {
                alert('You must fill out all required fields in Rate to submit a change');
                return false;
            }
            const acc_id = $(".table").children().last().children().first().children().first().nextAll('#acc').find('select').val();
            if ($empty.length + $empty1.length) {
                alert('You must fill out all required fields in order to submit a change');
                return false;
            } else if ($empty2.length) {
                alert('You must fill out Document Description to submit a change');
                return false;
            } else if (acc_id == null && $(".table").children().length != 0) {
                alert('Choose Account First!');
                return false;
            } else if (parseFloat($('#tot_debit').val().replace(/,/g, '')).toFixed(2) != parseFloat($('#tot_credit').val().replace(/,/g, '')).toFixed(2)) {
                alert('Total Debit and Total Credit should be Equal!');
                return false;
            }

            var table_rows = new Array();
            var index = 1;
            $('.table .table_row').each(function () {
                var table_row = {};
                console.log($(this));
                //  console.log(table_row.debit);
                const debit = parseFloat($(this).find('#debit').val().replace(/,/g, ''));
                const credit = parseFloat($(this).find('#credit').val().replace(/,/g, ''));
                const acc_id = $(this).find('[name="account_id"]').val();
                const third_party_id = $(this).find('[name="account_3party"]').val();
                const ev = $(this).find('#ev').find('input').val().replace(/,/g, '');
                table_row['debit'] = debit;
                table_row['credit'] = credit;
                table_row['account_id'] = acc_id;
                table_row['desc_text'] = document.getElementById(`desc_text${index}`).value;
                if (third_party_id != null)
                    table_row['account_3party'] = third_party_id;
                else
                    table_row['account_3party'] = '';
                if (credit == 0) {
                    table_row['evdebit'] = ev;
                    table_row['evcredit'] = credit;
                } else {
                    table_row['evdebit'] = debit;
                    table_row['evcredit'] = ev;
                }
                table_rows.push(table_row);
                index++;
            });
            table = {};
            table['table'] = table_rows;
            table["debit_tot"] = parseFloat($("#tot_debit").val().replace(/,/g, '')).toFixed(2);
            table["credit_tot"] = parseFloat($("#tot_credit").val().replace(/,/g, '')).toFixed(2);
            table["tot_evdebit"] = parseFloat($("#tot_debit").val().replace(/,/g, '') * $('#rate_h').val()).toFixed(2);
            table["tot_evcredit"] = parseFloat($("#tot_credit").val().replace(/,/g, '') * $('#rate_h').val()).toFixed(2);

            $.ajax({
                url: "<?= base_url("account/doAddManualEntry") ?>",
                type: "POST",
                data: {
                    'form': $("#form").serializeArray(),
                    'table': table,
                    'rows': row_number
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.records != 0)
                        alert("Manual Entry Already Exists!");
                    else
                        window.location = "<?= base_url("account/ManualEntryList") ?>";
                }
            });
        });

        $("#cdate").on('change', function () {
            var date = $('#cdate').val();
            $("#currency_hid").val($('#currency_id').val());
            var currency_hid = $("#currency_hid").val();
            if (currency_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency_rate" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'currency_hid': currency_hid,
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
                            if (row_number == 0) {
                                create_entry();
                            }
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            $("#rate").prop("disabled", false);
                            alert('No Currency Rate assigned to this currency at that date!');
                        }
                        check_ev();

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

        $("#currency_id").on('change', function () {
            var date = $('#cdate').val();
            $("#currency_hid").val($('#currency_id').val());
            var currency_hid = $("#currency_hid").val();
            if (currency_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency_rate" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'currency_hid': currency_hid,
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
                            if (row_number == 0) {
                                create_entry();
                            }
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            $("#rate").prop("disabled", false);
                            alert('No Currency Rate assigned to this currency at that date!');
                        }
                        check_ev();

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

        function calc_total() {
            var total_debit = 0;
            var total_credit = 0;
            $('.table #debit').each(function () {
                total_debit += parseFloat($(this).val().replace(/,/g, ''));
            });
            $('.table #credit').each(function () {
                total_credit += parseFloat($(this).val().replace(/,/g, ''));
            });
            $('#tot_debit').val(parseFloat(total_debit).toFixed(2).replace(/[^\d.]/g, "")
                .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                .replace(/\.(\d{2})\d+/, '.$1')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#tot_credit').val(parseFloat(total_credit).toFixed(2).replace(/[^\d.]/g, "").replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                .replace(/\.(\d{2})\d+/, '.$1').replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

        $(document).keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(document.activeElement).next())
                    $(document.activeElement).next().focus();
                else
                    $(document.activeElement).focusout();
            }
        });

        // $(document).on('keydown', 'input[pattern]', function (e) {
        //     var input = $(this);
        //     var oldVal = input.val();
        //     var regex = new RegExp(input.attr('pattern'), 'g');

        //     setTimeout(function () {
        //         var newVal = input.val();
        //         if (!regex.test(newVal)) {
        //             input.val(oldVal);
        //         }
        //     }, 1);
        // });

        $(document).on('change', '#debit', function (e) {
            var input = $(this);
            var value = parseFloat(input.val().replace(/,/g, '')).toFixed(2);
            if (value == 'NaN') {
                input.val(parseFloat(0).toFixed(2));
            } else {
                input.val(value.replace(/[^\d.]/g, "").replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                    .replace(/\.(\d{2})\d+/, '.$1').replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
            value = parseFloat(input.val().replace(/,/g, '')).toFixed(2);
            if (value == 0) {
                input.parent().next().find('input').prop('readonly', false);
            } else {
                input.parent().next().find('input').prop('readonly', true);
            }
            input.parent().parent().parent().nextAll('.eval').find('input').val(parseFloat($("#rate").val() * value).toFixed(2)
                .replace(/[^\d.]/g, "").replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3').replace(/\.(\d{2})\d+/, '.$1')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            calc_total();
        });

        $(document).on('change', '#credit', function (e) {
            var input = $(this);
            var value = parseFloat(input.val().replace(/,/g, '')).toFixed(2);
            if (value == 'NaN') {
                input.val(parseFloat(0).toFixed(2));
            } else {
                input.val(value.replace(/[^\d.]/g, "").replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                    .replace(/\.(\d{2})\d+/, '.$1').replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
            value = parseFloat(input.val().replace(/,/g, '')).toFixed(2);
            if (value == 0) {
                input.parent().prev().find('input').prop('readonly', false);
            } else {
                input.parent().prev().find('input').prop('readonly', true);
            }
            input.parent().parent().parent().nextAll('.eval').find('input').val(parseFloat($("#rate").val() * value).toFixed(2)
                .replace(/[^\d.]/g, "").replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3').replace(/\.(\d{2})\d+/, '.$1')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            calc_total();
        });

        $(document).on('change', '[name="account_id"]', function (event) {
            const changedCell = $(event.target);
            const account_id = $(changedCell).val();
            const row = $(changedCell).attr('id').substr(10);
            $.ajax({
                url: "<?= base_url("account/get_trn_account") ?>",
                type: "POST",
                cache: false,
                dataType: 'json',
                data: {
                    'account_id': account_id,
                },
                success: function (data) {
                    if (data != '') {
                        if (data.acc_third_party == 1) {
                            let html = `<select name="account_3party" id="account_3party${row}" class="form-control">
                                        <option value="" selected="" disabled>-- Select Third Party Account --</option>` +
                                data.combo +
                                `</select>`;
                            changedCell.parent().next().html(html);
                            $('.table .table_row').each(function () {
                                $(this).find('[name="account_3party"]').select2({
                                    dropdownCssClass: "selectheight"
                                });
                                $(this).find('.select2-container').css('width', '100%');
                            });
                        } else {
                            changedCell.parent().next().html('');
                        }
                    }
                },
                error: function (jqXHR, exception) {
                    console.log(jqXHR.responseText);
                }
            });
        });

        $(document).on("click", ".delete_account", function () {
            $(this).tooltip('hide');
            if (!confirm('Delete Account , Are you sure?'))
                return false;
            $(this).closest('.accountCard').remove();
            row_number--;
            calc_total();
        });
    });

</script>