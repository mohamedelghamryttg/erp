<!-- <script src="<?php echo base_url(); ?>assets_new/js/table2excel.js"></script> -->
<div class="content d-flex flex-column flex-column" id="kt_content" style="padding:0;">
    <div class="d-flex flex-column">
        <!--begin::Entry-->
        <div class="d-flex flex-column">
            <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
            <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
            <!--begin::Container-->
            <div class="container-fluid">

                <!-- start search form card -->
                <div class="card card-custom gutter-b example example-compact" style="text-align: center;padding-top: 20px;">
                    <div class="card-title" style="margin-bottom: auto;">
                        <!-- <label class="col-lg-10 col-form-label col-sm-10"> -->
                        <!-- <legend>Trial Balance</legend> -->
                        <!-- </label> -->
                        <h1><u><span>Trial Balance</span></u></h1>
                    </div>


                    <div class="card-body">
                        <div id="search_condation">
                            <form class="form" id="form" method="post" enctype="multipart/form-data">
                                <div class="form-group row">

                                    <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role form_date" style="text-align: initial;">From
                                        Date</label>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <input type="text" class="input-group date_sheet form-control" name="from_date" id="from_date" required value="<?= $vs_date1 ?>">
                                    </div>

                                    <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role to_date" style="text-align: initial;">To
                                        Date</label>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <input type="text" class="date_sheet form-control" name="to_date" id="to_date" required value="<?= $vs_date2 ?>">
                                    </div>
                                    <div class="col-lg1 col-md-1 col-sm-1 " style="margin: auto;">
                                        <div class="dropdown dropdown-inline">
                                            <button type="button" class="btn btn-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-color: #ffff;background-color: white;">
                                                <i class="ki ki-bold-menu" style="font-size: 2.3rem;color: #F64060;background-color: #FFFF;border-color: white;">
                                                </i>
                                            </button>
                                            <!-- <div class="dropdown-menu">
                                                        ...
                                                    </div> -->
                                            <div class="dropdown-menu ">
                                                <button class="dropdown-item" id="today" onclick="changeValue('today')" type="button">Today</button>
                                                <button class="dropdown-item" id="month" onclick="changeValue('month')" type="button">This
                                                    Month</button>
                                                <button class="dropdown-item" id="year" onclick="changeValue('year')" type="button">This
                                                    Year</button>
                                                <button class="dropdown-divider"></button>
                                                <button class="dropdown-item" id="fyear" onclick="changeValue('fyear')" type="button">Financial
                                                    Year</button>
                                                <button class="dropdown-item" id="fyear1" onclick="changeValue('fyear1')" type="button">First
                                                    Quarter</button>
                                                <button class="dropdown-item" id="fyear2" onclick="changeValue('fyear2')" type="button">Secand
                                                    Quarter</button>
                                                <button class="dropdown-item" id="fyear3" onclick="changeValue('fyear3')" type="button">Theard
                                                    Quarter</button>
                                                <button class="dropdown-item" id="fyear4" onclick="changeValue('fyear4')" type="button">Forth
                                                    Quarter</button>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role currency_id" style="text-align: initial;">Currency</label>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <select class="form-control" name="currency_id" id="currency_id" required>
                                            <option disabled="disabled" selected="selected" value="">--
                                                Select
                                                Currency --
                                            </option>
                                            <?= $this->admin_model->selectCurrency($currency_id) ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role currency_type" style="text-align: initial;">Currency Type</label>
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <select class="form-control" name="currency_type" id="currency_type" required>
                                            <option value="1">Currency Transaction
                                            </option>
                                            <option selected="selected" value="2">Currency Evaluation</option>
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
                                    <button class="btn btn-secondary btn-block" name="export" id="export" type="text">
                                        Export To
                                        Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .tableFixHead {
                    overflow-y: auto;
                    height: 600px;
                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0px;
                }

                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                th,
                td {
                    padding: 8px 16px;
                    border: 1px solid #ffff;
                }

                th {
                    background: #eee;
                }


                .table-bordered td,
                .table-bordered th {
                    border: 1px solid #bbb;

                }

                .h7 {
                    color: #111111;
                    font-size: 14px;

                }
            </style>
            <div class="container-fluid">
                <div class="card-body">
                    <div class="adv-table tableFixHead ">
                        <table id="print_content" data-excel-name="Trial Balance">
                            <tr>
                                <td>

                                    <div class="card-title">
                                        <div id="account_name" style="text-align: center;"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="table table-hover table-bordered" style="overflow:scroll;" data-excel-name="Trial Balance Details" id="table_Details">

                                        <thead>
                                            <th scope="col" class="text-nowrap">#</th>
                                            <th scope="col" class="text-nowrap">ID</th>
                                            <th scope="col" class="text-nowrap">Code</th>
                                            <th scope="col" class="text-nowrap">Account</th>
                                            <th scope="col" class="text-nowrap" style="width: 120px;">B. Debit Balance
                                            </th>
                                            <th scope="col" class="text-nowrap" style="width: 120px;">B. Credit Balance
                                            </th>
                                            <th scope="col" class="text-nowrap" style="width: 120px;">Debit</th>
                                            <th scope="col" class="text-nowrap" style="width: 120px;">Credit</th>
                                            <th scope="col" class="text-nowrap" style="width: 120px;">Debit Balance</th>
                                            <th scope="col" class="text-nowrap" style="width: 120px;">Credit Balance
                                            </th>

                                        </thead>
                                        <tbody id="rep_body">



                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <nav class="text-center">
                    <?= $this->pagination->create_links() ?>
                </nav>
                <!--end::Card-->
            </div>
        </div>
    </div>
</div>

<script>
    // $('#export').on('click', function(e) {
    //     var table2excel = new table2excel({

    //         defaultFileName: "Trial Balance",
    //         preserveColors: true

    //     });
    //     table2excel.export(document.querySelectorAll("table.table", "Trial Balance"));
    // });


    $(document).ready(function() {

        $('#run').on('click', function(e) {
            e.preventDefault();
            var date1 = $("#from_date").val();
            var date2 = $("#to_date").val();

            $.ajax({

                url: "<?= base_url() . "accountReport/trialbalance_calc" ?>",
                type: "POST",
                async: true,
                dataType: 'json',
                data: $('#form').serialize(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data != '') {
                        biuld_rep(data)
                    } else {
                        biuld_rep_null(data)
                    }
                    $('#loading').hide();
                },
                error: function(jqXHR, exception) {
                    $('#loading').hide();

                }
            })
        });

    });
    $("#btnPrint").on("click", function() {
        //alert($(window).height());
        // var ht = $(window).height();
        // var wt = $(window).width();

        // var divContents = $("#print_content").html();
        // var printWindow = window.open('', '', 'height=' + ht + 'px,width=' + wt + 'px');
        // printWindow.document.write('<html><head><title>Rail Bhojan Order details</title>');
        // printWindow.document.write('<link rel = "stylesheet" href = "https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css" >');
        // printWindow.document.write('<script');
        // printWindow.document.write(' src="https://unpkg.com/bootstrap-table@1.21.4/dist/locale/bootstrap-table-zh-CN.min.js"></');
        // printWindow.document.write('script>');
        // printWindow.document.write('<script');
        // printWindow.document.write(' src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></');
        // printWindow.document.write('script>');
        // printWindow.document.write('</head><body>');
        // printWindow.document.write(divContents);
        // printWindow.document.write('</body></html>');
        // printWindow.document.close();
        // printWindow.print();
        window.print();
    });

    function printPageArea(areaID) {
        // var printContent = document.getElementById(areaID).innerHTML;
        // var originalContent = document.body.innerHTML;
        // document.body.innerHTML = printContent;
        // window.print();
        // document.body.innerHTML = originalContent;


        //$('#print_examp').print();

        //redirect('account/report/tr_report.php');
    }

    function biuld_rep_null(data) {
        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();
        $('#account_name').html('<h2 style="color: darkred;">From Date : ' +
            date1 + "  -  To Date : " +
            date2 + "<br> " +
            " Currency :" +
            document.getElementById('currency_id').options[document.getElementById('currency_id').selectedIndex].innerHTML + '</h2>');

    }

    function biuld_rep(data) {

        var date1 = $("#from_date").val();
        var date2 = $("#to_date").val();
        $('#account_name').html('<h2 style="color: darkred;">From Date : ' +
            date1 + "  -  To Date : " +
            date2 + "<br> " +
            " Currency :" +
            document.getElementById('currency_id').options[document.getElementById('currency_id').selectedIndex].innerHTML + '</h2>');


        var html = '';
        var ix = 0;
        let deb_total = 0.0;
        let crd_total = 0.0;
        // let beg_deb_balance = 0.0;
        let beg_deb_total = 0.0;
        let beg_crd_total = 0.0;
        let g_deb_total = 0.0;
        let g_crd_total = 0.0;
        let balance = 0.0;
        let g_balance = 0.0;
        let beg_balance = 0.0;
        let d_balance = 0.0;
        let d_beg_balance = 0.0;
        let d_trn = 0.0;

        let trn_b_balance = 0.0;
        let trn_balance = 0.0;

        $.each(data.trns_ledger, function(index, value) {
                // console.log(value.beg_debit)
                // if (parseFloat(value.beg_debit) != 0 || parseFloat(value.beg_credit) != 0 || parseFloat(value.debit) != 0 || parseFloat(value.credit) != 0) {
                ix++;
                beg_balance = parseFloat(value.beg_debit) - parseFloat(value.beg_credit);

                balance = beg_balance + parseFloat(value.debit) - parseFloat(value.credit);
                if (value.acc == '0') {
                    deb_total += parseFloat(value.debit, 7);
                    crd_total += parseFloat(value.credit, 7);

                    beg_deb_total += parseFloat(value.beg_debit, 7);
                    beg_crd_total += parseFloat(value.beg_credit, 7);

                    d_trn += parseFloat(value.debit, 7) - parseFloat(value.credit, 7);
                    d_beg_balance += beg_balance;


                    d_balance += balance;

                    if (balance > 0) {
                        g_deb_total += balance;
                    } else {
                        g_crd_total += Math.abs(balance);
                    }
                    g_balance += g_deb_total - g_crd_total;
                }
                trn_b_balance = parseFloat(value.beg_debit, 7) - parseFloat(value.beg_credit, 7);
                trn_balance = trn_b_balance + parseFloat(value.debit, 7) - parseFloat(value.credit, 7);

                styl_color = "";
                if (value.level == '0' || value.level == '1') {
                    styl_color = 'color:blue;';
                } else {
                    styl_color = 'color: green';
                }
                if (value.acc == '0') {
                    styl_color = 'color: #F64E60;';
                }
                html += '<tr>';
                html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + ix + '</td>';
                html += '<td class="text-nowrap" style="text-align: right;' + styl_color + '">' + value.id + '</td>';
                html += '<td class="text-nowrap" style="text-align: left;' + styl_color + '">' + value.acode + '</td>';
                html += '<td class="text-nowrap" style="text-align: left;' + styl_color + '">' + value.name + '</td>';
                // html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(beg_balance) > 0 ? parseFloat(Math.abs(beg_balance)).toFixed(2) : '') + '</td>';
                // html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(beg_balance) < 0 ? parseFloat(Math.abs(beg_balance)).toFixed(2) : '') + '</td>';

                html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(value.beg_debit) != 0 ? parseFloat(value.beg_debit).toFixed(2) : '') + '</td>';
                html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(value.beg_credit) != 0 ? parseFloat(value.beg_credit).toFixed(2) : '') + '</td>';

                // html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(value.debit) > 0 ? parseFloat(value.debit).toFixed(2) : '') + '</td>';
                // html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(value.credit) > 0 ? parseFloat(value.credit).toFixed(2) : '') + '</td>';

                html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(value.debit) > 0 ? parseFloat(value.debit).toFixed(2) : '') + '</td>';
                html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(value.credit) > 0 ? parseFloat(value.credit).toFixed(2) : '') + '</td>';
                html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(trn_balance) > 0 ? parseFloat(Math.abs(trn_balance)).toFixed(2) : '') + '</td>';
                html += '<td class="text-nowrap" style="text-align: right;width: 120px;' + styl_color + '">' + (Number(trn_balance) < 0 ? parseFloat(Math.abs(trn_balance)).toFixed(2) : '') + '</td>';
                html += '</tr>';

            }

            // }
        )

        html += '       <tr>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"><div class="h7">Total</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (Number(beg_deb_total) > 0 ? parseFloat(beg_deb_total).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (Number(beg_crd_total) > 0 ? parseFloat(beg_crd_total).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (Number(deb_total) > 0 ? parseFloat(deb_total).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (Number(crd_total) > 0 ? parseFloat(crd_total).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (Number(g_deb_total) > 0 ? parseFloat(g_deb_total).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (Number(g_crd_total) > 0 ? parseFloat(g_crd_total).toFixed(2) : '') + '</div></td>';
        html += '    </tr>';
        d_beg_balance = parseFloat(beg_deb_total).toFixed(2) - parseFloat(beg_crd_total).toFixed(2);
        d_balance = parseFloat(g_deb_total).toFixed(2) - parseFloat(g_crd_total).toFixed(2);
        html += '       <tr>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"></td>';
        html += '        <td class="text-nowrap"><div class="h7">Deviation</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (parseFloat(d_beg_balance) > 0 ? parseFloat(d_beg_balance).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (parseFloat(d_beg_balance) < 0 ? parseFloat(Math.abs(d_beg_balance)).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (parseFloat(d_trn) > 0 ? parseFloat(d_trn).toFixed(2) : '') + '</div></td>';
        html += '        <td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (parseFloat(deb_total).toFixed(2) - parseFloat(crd_total).toFixed(2) > 0 ? parseFloat(Math.abs(d_trn)).toFixed(2) : '') + '</div></td>';
        html += '<td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (parseFloat(d_balance) > 0 ? parseFloat(d_balance).toFixed(2) : '') + '</div></td>';
        html += '<td class="text-nowrap" style="text-align: right;width: 120px;"><div class="h7">' + (parseFloat(d_balance) < 0 ? parseFloat(Math.abs(d_balance)).toFixed(2) : '') + '</div></td>';

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