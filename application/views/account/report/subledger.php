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

                    <h1><u><span>Account Subledger</span></u></h1>
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
                                        <?= $this->AccountModel->select_chart_sub($brand) ?>
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
                    <thead>
                        <tr style="background-color: #C1C3CC;">
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap">ID</th>
                            <th class="text-nowrap">Transaction</th>
                            <th class="text-nowrap">Serial</th>
                            <th class="text-nowrap">Doc. No</th>
                            <th class="text-nowrap">Date</th>

                            <th class="text-nowrap">Debit</th>
                            <th class="text-nowrap">Credit</th>
                            <th class="text-nowrap">Debit Balance</th>
                            <th class="text-nowrap">Credit Balance</th>
                            <th class="text-nowrap">Currency</th>
                            <th class="text-nowrap">Rate</th>
                            <!-- <th scope="col" >Account Details
                                    </th> -->
                            <th class="text-nowrap">Describtion</th>

                        </tr>
                    </thead>
                    <tbody id="rep_body">



                    </tbody>
                </table>

            </div>
        </div>
        </section>
        <nav class="text-center">
            <?= $this->pagination->create_links() ?>
        </nav>
        <!--end::Card-->
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#kt_datatable_both_scrolls").DataTable({
            "paging": true,
            pagingTag: 'button',
            "lengthChange": false,
            "pageLength": 25,
            "autoWidth": false,
            "ordering": false,
            fixedHeader: true,
            responsive: true,
            "searching": false
        });
        $('#run').on('click', function (e) {
            e.preventDefault();
            var date1 = $("#from_date").val();
            var date2 = $("#to_date").val();

            $.ajax({
                url: "<?= base_url() . "accountReport/subledger_calc" ?>",
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
                        biuld_rep_null(data)
                    }
                    $('#loading').hide();
                },
                error: function (jqXHR, exception) {
                    $('#loading').hide();
                    //console.log(jqXHR.responseText);
                }
            })
        });

    });

    function biuld_rep_null(data) {
        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();
        $('#account_name').html('<h2 style="color: darkred;">From Date : ' +
            date1 + "  -  To Date : " +
            date2 + "<br> "
            + " Currency :" +
            document.getElementById('currency_id').options[document.getElementById('currency_id').selectedIndex].innerHTML + '</h2>');

    }
    function biuld_rep(data) {
        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();

        $('#account_name').html('<h4><span style="color: darkred;" >From Date : ' +
            '</span><span style="3F4254;" > ' + date1 + ' </span> <span style="color: darkred; " >-  To Date : ' +
            '</span><span style="3F4254;" > ' + date2 + " </span></b4> "
            + '<h4><span style="color: darkred;" > Currency :</span><span style="3F4254;" >' +
            document.getElementById('currency_id').options[document.getElementById('currency_id').selectedIndex].innerHTML + " </span></b4><h4> " +
            document.getElementById('account_id').options[document.getElementById('account_id').selectedIndex].innerHTML + "</h4>");


        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();
        var html = '';
        var ix = 1;
        var deb_total = 0;
        var crd_total = 0;
        var g_deb_total = 0;
        var g_crd_total = 0;
        var balance = 0;

        //html += '<thead>';
        html += '       <tr>';
        html += '        <td class="text-nowrap">' + ix + '</td>';
        html += '        <td class="text-nowrap">0</td>';
        html += '        <td class="text-nowrap">Begining Balance</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">' + date1 + '</td>';
        // html += '        <td ></td>';
        // html += '        <td ></td>';

        $.each(data.beg_ledger, function (index, value) {
            deb_total += +number_conv(value.debit);
            crd_total += +number_conv(value.credit);
            g_deb_total = +number_conv(deb_total);
            g_crd_total = +number_conv(crd_total);
            balance = +deb_total - crd_total

            html += '        <td class="text-nowrap">' + (Number(value.debit) > 0 ? parseFloat(value.debit).toFixed(2) : '') + '</td>';
            html += '        <td class="text-nowrap">' + (Number(value.credit) > 0 ? parseFloat(value.credit).toFixed(2) : '') + '</td>';
            html += '        <td class="text-nowrap">' + (Number(balance) > 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
            html += '        <td class="text-nowrap">' + (Number(balance) < 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
        })


        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';

        // html += '        <td > </td > ';
        html += '        <td class="text-nowrap"> </td > ';
        html += '    </tr>';
        //html += '</thead>';


        $.each(data.trns_ledger, function (index, value) {
            ix++;
            deb_total += +number_conv(value.debit);
            crd_total += +number_conv(value.credit);
            g_deb_total = +number_conv(deb_total);
            g_crd_total = +number_conv(crd_total);
            balance = +deb_total - crd_total

            html += '<tr>';
            html += '<td class="text-nowrap">' + ix + '</td>';
            html += '<td class="text-nowrap">' + value.id + '</td>';
            html += '<td class="text-nowrap">' + value.trns_type + '</td>';
            html += '<td class="text-nowrap">' + value.trns_ser + '</td>';
            html += '<td class="text-nowrap">' + value.trns_code + '</td>';
            html += '<td class="text-nowrap">' + value.trns_date + '</td>';

            // html += '<td >' + (value.deb_acc_acode ? value.deb_acc_acode : value.crd_acc_acode) + '</td>';
            // html += '<td >' + (value.deb_acc_acode ? value.deb_name : value.crd_name) + '</td>';
            html += '<td class="text-nowrap">' + (Number(value.debit) > 0 ? parseFloat(value.debit).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap">' + (Number(value.credit) > 0 ? parseFloat(value.credit).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap">' + (Number(balance) > 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap">' + (Number(balance) < 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap">' + value.currency + '</td>';
            html += '<td class="text-nowrap">' + parseFloat(value.rate).toFixed(5) + '</td>';

            switch (value.trns_type) {
                case 'Cash In':
                    // document.cookie = "ss = " + value.deb_account;
                    // var cookies = document.cookie = "abc=" + value.deb_account;
                    // var text = <?php
                    // $ss = "<script>document.writeln(value.deb_account);</script>";
                    // $text = $this->AccountModel->getpayment_method($ss);
                    // echo $text;
                    // ?>;

                    // html += '<td >' + text + '</td>'
                    break;
                case 'Cash Out':
                    break;
                case 'Manual Entry':
                // html += '<td ></td>';
                default:
                    //  html += '<td ></td>';
                    break;
            }
            // html += '<td ></td>';
            //if (value.data1 != null) {
            html += '<td class="text-nowrap">' + (value.data1 ? value.data1 : '') + '</td>';
            // } else { html += '<td ></td>'; }


            html += '</tr>';

        })
        html += '       <tr style="background-color: #eee;">';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">Total</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        // html += '        <td ></td>';
        // html += '        <td ></td>';
        html += '        <td class="text-nowrap">' + (Number(deb_total) > 0 ? parseFloat(deb_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap">' + (Number(crd_total) > 0 ? parseFloat(crd_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"> </td > ';
        html += '    </tr>';

        html += '       <tr style="background-color: #D7D9E6;">';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">Balance</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        // html += '        <td ></td>';
        // html += '        <td ></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '<td class="text-nowrap">' + (Number(balance) > 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
        html += '<td class="text-nowrap">' + (Number(balance) < 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"> </td > ';
        html += '    </tr>';

        $("#rep_body").html(html);
        // g_deb_total += value.deb_amount;
        // g_crd_total += value.crd_amount;

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