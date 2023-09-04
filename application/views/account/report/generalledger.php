<div class="container-fluid">
    <!-- <div class="content d-flex flex-column flex-column" id="kt_content" style="padding:0;"> -->
    <div class="d-flex flex-column">
        <!--begin::Entry-->
        <div class="d-flex flex-column">
            <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
            <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
            <!--begin::Container-->


            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact"
                style="text-align: center;padding-top: 20px;">
                <div class="card-title" style="margin-bottom: auto;">

                    <h3 class="card-title">Account General Ledger</h3>
                </div>

                <div class="card-body" style="padding-bottom :0;">
                    <div id="search_condation">
                        <form class="form" id="form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role form_date"
                                    style="text-align: initial;">From
                                    Date</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <input type="text" class="input-group date_sheet form-control" name="from_date"
                                        id="from_date" required value="<?= $vs_date1 ?>">
                                </div>

                                <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role to_date"
                                    style="text-align: initial;">To
                                    Date</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <input type="text" class="date_sheet form-control" name="to_date" id="to_date"
                                        required value="<?= $vs_date2 ?>">
                                </div>
                                <div class="col-lg1 col-md-1 col-sm-1 " style="margin: auto;">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-primary btn-icon btn-sm"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="border-color: #ffff;background-color: white;">
                                            <i class="ki ki-bold-menu"
                                                style="font-size: 2.3rem;color: #F64060;background-color: #FFFF;border-color: white;">
                                            </i>
                                        </button>

                                        <div class="dropdown-menu ">
                                            <button class="dropdown-item" id="today" onclick="changeValue('today')"
                                                type="button">Today</button>
                                            <button class="dropdown-item" id="month" onclick="changeValue('month')"
                                                type="button">This
                                                Month</button>
                                            <button class="dropdown-item" id="year" onclick="changeValue('year')"
                                                type="button">This
                                                Year</button>
                                            <button class="dropdown-divider"></button>
                                            <button class="dropdown-item" id="fyear" onclick="changeValue('fyear')"
                                                type="button">Financial
                                                Year</button>
                                            <button class="dropdown-item" id="fyear1" onclick="changeValue('fyear1')"
                                                type="button">First
                                                Quarter</button>
                                            <button class="dropdown-item" id="fyear2" onclick="changeValue('fyear2')"
                                                type="button">Secand
                                                Quarter</button>
                                            <button class="dropdown-item" id="fyear3" onclick="changeValue('fyear3')"
                                                type="button">Theard
                                                Quarter</button>
                                            <button class="dropdown-item" id="fyear4" onclick="changeValue('fyear4')"
                                                type="button">Forth
                                                Quarter</button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role currency_id"
                                    style="text-align: initial;">Currency</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <select class="form-control" name="currency_id" id="currency_id" required>
                                        <option disabled="disabled" selected="selected" value="">--
                                            Select
                                            Currency --
                                        </option>
                                        <?= $this->admin_model->selectCurrency($currency_id) ?>
                                    </select>
                                </div>
                                <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role currency_type"
                                    style="text-align: initial;">Currency Type</label>
                                <div class="col-lg-3 col-md-3 col-sm-4">
                                    <select class="form-control" name="currency_type" id="currency_type" required>
                                        <option value="1">Currency Transaction
                                        </option>
                                        <option selected="selected" value="2">Currency Evaluation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role currency_id"
                                    style="text-align: initial;">Currency</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <select name="account_id" class="form-control m-b" id="account_id">
                                        <option disabled="disabled" selected="selected" value="">--
                                            Select
                                            Account --
                                        </option>
                                        <?= $this->AccountModel->select_chart_main($brand) ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer" style="padding: 12px 0;">
                        <div class=" row">
                            <div class="col-lg-2 col-md-2 col-sm-4">

                                <button class="btn btn-primary btn-block" name="run" id="run" type="text">Run</button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <button class="btn btn-warning btn-block" name="clear" id="clear" type="text">
                                    Clear
                                    Filter</button>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <button class="btn btn-secondary btn-block"
                                    onclick="var e2 = document.getElementById('accountfilter'); e2.action='<?= base_url() ?>account/exportaccount'; e2.submit();"
                                    name="export" type="text">
                                    Export To
                                    Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card-body" style="padding-top :0;">
                <div class="card-title">
                    <div id="account_name" style="text-align: left;"></div>
                </div>

                <table id="kt_datatable_both_scrolls" class="table table-striped table-bordered gy-5 gs-7 ">
                    <thead class="text-center">
                        <th scope="col" class="text-nowrap">#</th>
                        <th scope="col" class="text-nowrap">ID</th>
                        <th scope="col" class="text-nowrap">Code</th>
                        <th scope="col" class="text-nowrap">Account</th>
                        <th scope="col" class="text-nowrap">B. Debit Balance
                        </th>
                        <th scope="col" class="text-nowrap">B. Credit Balance
                        </th>
                        <th scope="col" class="text-nowrap">Debit</th>
                        <th scope="col" class="text-nowrap">Credit</th>
                        <th scope="col" class="text-nowrap">Debit Balance</th>
                        <th scope="col" class="text-nowrap">Credit Balance</th>
                        </tr>
                    </thead>
                    <tbody id="rep_body">

                    </tbody>
                </table>
                <nav class="text-center">
                    <?= $this->pagination->create_links() ?>
                </nav>


            </div>
        </div>
    </div>
    </section>
    <!--end::Card-->
</div>

<script>
    const n_format = new Intl.NumberFormat('en', {
        style: 'decimal',
        useGrouping: true,
        minimumFractionDigits: 2

    });
    $(document).ready(function () {
        $('#run').on('click', function (e) {
            e.preventDefault();
            var date1 = $("#from_date").val();
            var date2 = $("#to_date").val();
            var vv_account = $('#account_id').val();
            if (vv_account) {
                $.ajax({
                    url: "<?= base_url() . "accountReport/generalledger_calc" ?>",
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    data: $('#form').serialize(),
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        if (data != '') {
                            biuld_rep(data)
                        } else {

                        }
                        $('#loading').hide();
                    },
                    error: function (jqXHR, exception) {
                        $('#loading').hide();
                        //console.log(jqXHR.responseText);
                    }
                })
            }
        });

    });

    function biuld_rep(data) {
        $('#account_name').html('<h2 style="color: darkred;">' +
            document.getElementById('account_id').options[document.getElementById('account_id').selectedIndex].innerHTML + " - " +
            document.getElementById('currency_id').options[document.getElementById('currency_id').selectedIndex].innerHTML + '</h2>');

        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();
        var html = '';
        var ix = 0;
        var deb_total = 0;
        var crd_total = 0;
        var beg_deb_total = 0;
        var beg_crd_total = 0;
        var bal_deb_total = 0;
        var bal_crd_total = 0;
        var deb_balance = 0;
        var crd_balance = 0;
        var balance = 0;
        var beg_bal = 0;
        var rem_trans = 0;
        var tot_d_balance = 0;
        var tot_c_balance = 0;
        $.each(data.trns_ledger, function (index, value) {
            ix++;
            beg_balance = parseFloat(value.beg_debit) - parseFloat(value.beg_credit);
            balance = beg_balance + parseFloat(value.debit) - parseFloat(value.credit);
            // if (value.acc == '0') {
            deb_total += parseFloat(value.debit);
            crd_total += parseFloat(value.credit);

            beg_deb_total += parseFloat(value.beg_debit);
            beg_crd_total += parseFloat(value.beg_credit);
            rem_trans += parseFloat(value.debit) - parseFloat(value.credit);
            balance = parseFloat(value.balance);

            if (parseFloat(value.balance) > 0) {
                tot_d_balance += parseFloat(value.balance);
            } else {
                tot_c_balance += Math.abs(parseFloat(value.balance));
            }
            beg_bal += (parseFloat(value.beg_debit) - parseFloat(value.beg_credit))
            // }

            html += '<tr>';
            html += '<td class="text-nowrap" style="text-align: right;">' + ix + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;">' + value.id + '</td>';
            html += '<td class="text-nowrap" style="text-align: left;">' + value.acode + '</td>';
            html += '<td class="text-nowrap" style="text-align: left;">' + value.name + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;">' + n_format.format(parseFloat(value.beg_debit).toFixed(2)) + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;">' + n_format.format(parseFloat(value.beg_credit).toFixed(2)) + '</td>';

            html += '<td class="text-nowrap" style="text-align: right;">' + n_format.format(parseFloat(value.debit).toFixed(2)) + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;">' + n_format.format(parseFloat(value.credit).toFixed(2)) + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;">' + n_format.format(parseFloat(Math.abs(tot_d_balance)).toFixed(2)) + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;">' + n_format.format(parseFloat(Math.abs(tot_c_balance)).toFixed(2)) + '</td>';
            html += '</tr>';



        })
        html += '       <tr>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">Total</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(beg_deb_total) > 0 ? n_format.format(parseFloat(beg_deb_total).toFixed(2)) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(beg_crd_total) > 0 ? n_format.format(parseFloat(beg_crd_total).toFixed(2)) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(deb_total) > 0 ? n_format.format(parseFloat(deb_total).toFixed(2)) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(crd_total) > 0 ? n_format.format(parseFloat(crd_total).toFixed(2)) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(tot_d_balance) > 0 ? parseFloat(tot_d_balance).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(tot_c_balance) > 0 ? parseFloat(tot_c_balance).toFixed(2) : '') + '</td>';
        html += '    </tr>';

        html += '       <tr>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">Balance</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(beg_bal) > 0 ? n_format.format(parseFloat(Math.abs(beg_bal)).toFixed(2)) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(beg_bal) < 0 ? n_format.format(parseFloat(Math.abs(beg_bal)).toFixed(2)) : '') + '</td>';
        html += '<td class="text-nowrap" style="text-align: right;">' + (Number(rem_trans) > 0 ? n_format.format(parseFloat(Math.abs(rem_trans)).toFixed(2)) : '') + '</td>';
        html += '<td class="text-nowrap" style="text-align: right;">' + (Number(rem_trans) < 0 ? n_format.format(parseFloat(Math.abs(rem_trans)).toFixed(2)) : '') + '</td>';
        html += '<td class="text-nowrap" style="text-align: right;">' + (Number(balance) > 0 ? n_format.format(parseFloat(Math.abs(balance)).toFixed(2)) : '') + '</td>';
        html += '<td class="text-nowrap" style="text-align: right;">' + (Number(balance) < 0 ? n_format.format(parseFloat(Math.abs(balance)).toFixed(2)) : '') + '</td>';

        html += '    </tr>';

        $("#rep_body").html(html);
    }
    function number_conv(r) {
        if (Number.isNaN(Number.parseFloat(r))) {
            return parseFloat('0').toFixed(2);
        }
        return parseFloat(r).toFixed(2);
    }


    function changeValue(o) {

        switch (o) {
            case 'today':
                var starDay = moment().format('YYYY-MM-DD');
                $('#from_date').val(starDay);
                $('#to_date').val(starDay);

                break;
            case 'month':
                var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
                var endOfMonth = moment().endOf('month').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'year':
                var startOfMonth = moment().startOf('year').format('YYYY-MM-DD');
                var endOfMonth = moment().endOf('year').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear':
                var startOfMonth = $('#vs_date1').val();
                var endOfMonth = $('#vs_date2').val();

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear1':
                var startOfMonth = moment().quarter(1).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(1).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
                break;
            case 'fyear2':
                var startOfMonth = moment().quarter(2).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(2).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear3':
                var startOfMonth = moment().quarter(3).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(3).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear4':
                var startOfMonth = moment().quarter(4).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(4).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            default:
                break;
        }
        return
    }

</script>