<div class="content d-flex flex-column flex-column" id="kt_content" style="padding-top: 0;">
    <div class="d-flex flex-column">
        <!--begin::Entry-->
        <div class="d-flex flex-column">
            <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
            <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
            <!--begin::Container-->
            <div class="container-fluid" style="padding-left: 0;padding-right: 0;">

                <!-- start search form card -->
                <div class="card card-custom gutter-b example example-compact"
                    style="text-align: center;padding-top: 30px;">
                    <div class="card-title" style="margin-bottom: auto;">
                        <h3 class="card-title">Trial Balance</h3>
                    </div>

                    <div class="card-body" style="padding: 0;">

                        <div class="row">

                            <div class="col-lg-4 col-form-label col-sm-12" id="search_col"
                                style="padding-left: 0;padding-right: 0;">
                                <div class="card card-custom example example-compact"
                                    style="align-items: center;margin-bottom: 2.25rem;">
                                    <div class="card-header">
                                        <input type="hidden" name="brand" value="<?= $brand ?>">
                                        <h2 class="card-title">
                                            Brand :
                                            <span style="color: darkred;">
                                                <?= $this->admin_model->getbrand($this->brand); ?>
                                            </span>
                                        </h2>
                                    </div>

                                </div>
                                <div class="form-group row border"
                                    style="margin-left: 20px;margin-right: 20px;padding-right: 10px;">

                                    <form class="form" id="form" method="post" enctype="multipart/form-data" action="">

                                        <div class="form-group row">

                                            <label class="col-lg-10 col-form-label col-sm-10">
                                                <legend> Date ranges:</legend>
                                            </label>
                                            <div class="col-lg-2 col-md-2 col-sm-2 text-right" style="margin: auto;">
                                                <div class="dropdown dropdown-inline">
                                                    <button type="button" class="btn btn-primary btn-icon btn-sm"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"
                                                        style="border-color: #ffff;background-color: white;">
                                                        <i class="ki ki-bold-menu"
                                                            style="font-size: 2.3rem;color: #F64060;background-color: #FFFF;border-color: white;">
                                                        </i>
                                                    </button>
                                                    <!-- <div class="dropdown-menu">
                                                        ...
                                                    </div> -->
                                                    <div class="dropdown-menu ">
                                                        <button class="dropdown-item" id="today"
                                                            onclick="changeValue('today')" type="button">Today</button>
                                                        <button class="dropdown-item" id="month"
                                                            onclick="changeValue('month')" type="button">This
                                                            Month</button>
                                                        <button class="dropdown-item" id="year"
                                                            onclick="changeValue('year')" type="button">This
                                                            Year</button>
                                                        <button class="dropdown-divider"></button>
                                                        <button class="dropdown-item" id="fyear"
                                                            onclick="changeValue('fyear')" type="button">Financial
                                                            Year</button>
                                                        <button class="dropdown-item" id="fyear1"
                                                            onclick="changeValue('fyear1')" type="button">First
                                                            Quarter</button>
                                                        <button class="dropdown-item" id="fyear2"
                                                            onclick="changeValue('fyear2')" type="button">Secand
                                                            Quarter</button>
                                                        <button class="dropdown-item" id="fyear3"
                                                            onclick="changeValue('fyear3')" type="button">Theard
                                                            Quarter</button>
                                                        <button class="dropdown-item" id="fyear4"
                                                            onclick="changeValue('fyear4')" type="button">Forth
                                                            Quarter</button>

                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label col-sm-11 text-right"
                                                        for="role form_date" id="type">From Date</label>
                                                    <div class="col-lg-7 col-md-9 col-sm-11">
                                                        <input type="text" class="date_sheet form-control"
                                                            name="from_date" id="from_date" required
                                                            value="<?= $vs_date1 ?>">
                                                    </div>
                                                    <!-- <div class="col-lg-1 col-md-1 col-sm-1"> -->

                                                    <!-- </div> -->

                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label col-sm-12 text-right"
                                                        for="role to_date" id="type">To Date</label>
                                                    <div class="col-lg-7 col-md-9 col-sm-12">
                                                        <input type="text" class="date_sheet form-control"
                                                            name="to_date" id="to_date" required
                                                            value="<?= $vs_date2 ?>">
                                                    </div>
                                                </div>
                                                <!-- </fieldset> -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-right">Currency</label>
                                            <div class="col-lg-8 col-sm-12">
                                                <select class="form-control" name="currency_id" id="currency_id"
                                                    required>
                                                    <option disabled="disabled" selected="selected" value="">--
                                                        Select
                                                        Currency --
                                                    </option>
                                                    <?= $this->admin_model->selectCurrency($currency_id) ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label text-right">Currency Type</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="currency_type" id="currency_type"
                                                    required>
                                                    <option selected="selected" value="1">Currency Transaction
                                                    </option>
                                                    <option value="2">Currency Evaluation</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <button class="btn btn-primary" name="run" id="run" type="text"
                                                        style="width: 100%;margin: 5px;">Run</button>

                                                    <button class="btn btn-warning" name="clear" id="clear" type="text"
                                                        style="width: 100%;margin: 5px;">
                                                        Clear
                                                        Filter</button>
                                                    <button class="btn btn-secondary"
                                                        onclick="var e2 = document.getElementById('accountfilter'); e2.action='<?= base_url() ?>account/exportaccount'; e2.submit();"
                                                        name="export" type="text" style="width: 100%;margin: 5px;"><i
                                                            class="fa fa-download" aria-hidden="true"></i>
                                                        Export To
                                                        Excel</button>
                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-8 col-form-label col-sm-12 border border-light"
                                style="padding-left: 0;padding-right: 0;">
                                <div class="container row" style="padding-left: 0;padding-right: 0;">
                                    <div class="col-sm-12">
                                        <div class="card-title" style="margin-bottom: auto;">
                                            <div id="account_name" style="text-align: left;"></div>
                                        </div>

                                        <section class="panel">
                                            <div class="panel-body" style="overflow:scroll;">
                                                <div class="adv-table editable-table ">
                                                    <div class="adv-table editable-table ">

                                                        <div class="clearfix">
                                                            <div class="btn-group">
                                                            </div>

                                                        </div>
                                                        <!-- <div class="space15"></div> -->
                                                        <table class="table table-hover table-bordered border-dark"
                                                            style="overflow:scroll;">
                                                            <thead>
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
                                                                <th scope="col" class="text-nowrap">Debit Deviation</th>
                                                                <th scope="col" class="text-nowrap">Credit Deviation
                                                                </th>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#run').on('click', function (e) {
            e.preventDefault();
            var date1 = $("#from_date").val();
            var date2 = $("#to_date").val();

            $.ajax({
                url: "<?= base_url() . "accountReport/trialbalance_calc" ?>",
                type: "POST",
                async: true,
                dataType: 'json',
                data: $('#form').serialize(),
                beforeSend: function () {
                    $('body').css('cursor', 'wait');;
                },
                success: function (data) {
                    if (data != '') {
                        biuld_rep(data)
                    } else {

                    }
                    $('body').css('cursor', 'auto');
                },
                error: function (jqXHR, exception) {
                    $('body').css('cursor', 'auto');
                    //console.log(jqXHR.responseText);
                }
            })
        });

    });

    function biuld_rep(data) {

        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();
        $('#account_name').html('<h2 style="color: darkred;">From Date :' +
            document.getElementById('from_date').innerHTML + " To Date : " +
            document.getElementById('to_date').innerHTML + " Currency " +
            document.getElementById('currency_id').options[document.getElementById('currency_id').selectedIndex].innerHTML + '</h2>');


        var html = '';
        var ix = 1;
        var deb_total = 0;
        var crd_total = 0;
        var beg_deb_balance = 0;
        var beg_deb_total = 0;
        var beg_crd_total = 0;
        var g_deb_total = 0;
        var g_crd_total = 0;
        var balance = 0;
        var g_balance = 0;
        var beg_balance = 0;
        var d_balance = 0;
        var d_beg_balance = 0;
        var d_trn = 0;
        $.each(data.trns_ledger, function (index, value) {
            ix++;


            beg_balance = +value.beg_debit - value.beg_credit;
            balance = +beg_balance + value.debit - value.credit
            if (value.acc == '0') {
                deb_total += +value.debit;
                crd_total += +value.credit;

                beg_deb_total += +value.beg_debit;
                beg_crd_total += +value.beg_credit;
                beg_deb_balance += +value.beg_debit - value.beg_credit;
                if (balance > 0) {
                    g_deb_total += +balance;
                } else {
                    g_crd_total += Math.abs(balance);
                }
                g_balance += +g_deb_total - g_crd_total;
                d_trn += +value.debit - value.credit;
                d_beg_balance += +value.beg_debit - +value.beg_credit;
                d_balance += +balance;
            }



            styl_color = "";
            if (value.level == 0 || value.level == 1) {
                styl_color = 'color:blue;';
            } else {
                styl_color = 'color: green';
            }
            if (value.acc == 0) {
                styl_color = 'color: #F64E60;';
            }
            html += '<tr>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + ix + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + value.id + '</td>';
            html += '<td class="text-nowrap" style="text-align: left;' + styl_color + '">' + value.acode + '</td>';
            html += '<td class="text-nowrap" style="text-align: left;' + styl_color + '">' + value.name + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + (Number(beg_balance) > 0 ? parseFloat(Math.abs(beg_balance)).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + (Number(beg_balance) < 0 ? parseFloat(Math.abs(beg_balance)).toFixed(2) : '') + '</td>';

            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + (Number(value.debit) > 0 ? parseFloat(value.debit).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + (Number(value.credit) > 0 ? parseFloat(value.credit).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + (Number(balance) > 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
            html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + (Number(balance) < 0 ? parseFloat(Math.abs(balance)).toFixed(2) : '') + '</td>';
            html += '</tr>';



        })
        html += '       <tr>';
        html += '        <td class="text-nowrap">' + ix + '</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">Total</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(beg_deb_total) > 0 ? parseFloat(beg_deb_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(beg_crd_total) > 0 ? parseFloat(beg_crd_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(deb_total) > 0 ? parseFloat(deb_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(crd_total) > 0 ? parseFloat(crd_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(g_deb_total) > 0 ? parseFloat(g_deb_total).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(g_crd_total) > 0 ? parseFloat(g_crd_total).toFixed(2) : '') + '</td>';
        html += '    </tr>';

        html += '       <tr>';
        html += '        <td class="text-nowrap">' + ix + '</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap">Deviation</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(d_beg_balance) > 0 ? parseFloat(Math.abs(d_beg_balance)).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(d_beg_balance) < 0 ? parseFloat(Math.abs(d_beg_balance)).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(d_trn) > 0 ? parseFloat(d_trn).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap" style="text-align: right;">' + (Number(d_trn) > 0 ? parseFloat(d_trn).toFixed(2) : '') + '</td>';
        html += '<td class="text-nowrap" style="text-align: right;">' + (Number(d_balance) > 0 ? parseFloat(Math.abs(d_balance)).toFixed(2) : '') + '</td>';
        html += '<td class="text-nowrap" style="text-align: right;">' + (Number(d_balance) < 0 ? parseFloat(Math.abs(d_balance)).toFixed(2) : '') + '</td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"> </td > ';
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