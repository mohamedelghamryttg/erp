<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets_new/js/table2excel.js"></script>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 0;">
    <div class="d-flex flex-column-fluid">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
            <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="card card-custom example example-compact" style="align-items: center;">
                    <div class="card-header center">

                        <h3 class="card-title">Account Entry Data List</h3>

                    </div>

                    <input type="hidden" name="brand" value="<?= $brand ?>">

                </div>
                <!-- start search form card -->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Search Condation Transaction</h3>
                    </div>


                    <form class="form" id="form" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group row" id="ddacc_lchoice">
                                        <div class="col-lg-6">
                                            <label class="col-lg-5 control-label" for="role acc_type">Transaction
                                                Type</label>
                                            <div class="col-lg-7">
                                                <select name="acc_type" id='acc_type' class='form-control m-b'>
                                                    <option value="0" selected='selected'>-- Select --</option>
                                                    <option value="1">Opening Entry</option>
                                                    <option value="2">Cash In/Out</option>
                                                    <option value="3">Revenue</option>
                                                    <option value="4">Expenses</option>
                                                    <option value="5">Bank In/Out</option>
                                                    <option value="6">Recivebal</option>
                                                    <option value="7">Payable</option>
                                                    <option value="8">Manual Entry</option>
                                                    <option value="9">All Entry</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div id="dacc_lchoice">
                                                <label class="col-lg-5 control-label" for="role acc_lchoice"
                                                    id="acc_lchoice">Revenue</label>
                                                <div class="col-lg-7">
                                                    <select name="trn_id" id="trn_id" class="form-control m-b">
                                                        <option value="" selected='selected'>-- Select --</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label col-sm-12" for="role type"
                                            id="type">Serial
                                            Number</label>
                                        <div class="col-lg-7 col-md-9 col-sm-12">
                                            <input type="text" class="form-control" name="ser" id="ser">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label col-sm-12" for="role cdate">Date
                                            Ranges</label>
                                        <div class="col-lg-7 col-md-9 col-sm-12">
                                            <div class='input-group' id='kt_daterangepicker_6'>
                                                <input type='text' class="form-control" readonly
                                                    placeholder="Select date range" id="cdate" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <button class="btn btn-primary" name="search" id="search"
                                                    type="text">Search</button>
                                                <a href="<?= base_url() ?>account/dataEntryRep"
                                                    class="btn btn-warning">(x)
                                                    Clear
                                                    Filter</a>
                                                <button class="btn btn-secondary" name="export" id="export"
                                                    onclick="TableToExcel()" type="button"><i class="fa fa-download"
                                                        aria-hidden="true"></i>
                                                    Export To Excel</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="container-fluid row">
                    <!-- <div class="col-sm-12"> -->
                    <!-- <section class="panel"> -->

                    <!-- <div class="panel-body" style="overflow:scroll;">
                                <div class="adv-table editable-table ">
                                    <div class="adv-table editable-table ">
                                        <form class="cmxform form-horizontal " method="post"
                                            enctype="multipart/form-data"> -->
                    <!-- <table> -->


                    <div id="rep_body"></div>
                    <!-- </table> -->
                    <!-- <nav class="text-center">
                                                <?= $this->pagination->create_links() ?>
                                            </nav>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </section>
                    
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function TableToExcel() {
        var table2excel = new Table2Excel({
            filename: "Table.xls"
        });
        table2excel.export(document.querySelectorAll("table.table", "Entrey Data"));

    };
    $(document).ready(function () {

        var startDate;
        var endDate;
        KTBootstrapDaterangepicker.init();

        $('#search').on('click', function (e) {
            e.preventDefault();
            var acc_lchoice = document.getElementById('acc_lchoice');
            var acc_type = $('#acc_type').val()
            switch (acc_type) {
                case '1':
                    document.getElementById('dacc_lchoice').style.display = 'none'
                    get_data('1');
                    break;
                case '2':
                    document.getElementById('dacc_lchoice').style.display = 'none'
                    get_data('2');
                    break;
                case '3':
                    document.getElementById('dacc_lchoice').style.display = 'flex'
                    document.getElementById('acc_lchoice').innerHTML = 'Revenu'
                    get_data('3');
                    break;
                case '4':
                    document.getElementById('dacc_lchoice').style.display = 'flex'
                    document.getElementById('acc_lchoice').innerHTML = 'Expenses'
                    get_data('4');
                    break;
                case '5':
                    document.getElementById('dacc_lchoice').style.display = 'none'
                    get_data('5');
                    break;
                case '6':
                    document.getElementById('dacc_lchoice').style.display = 'flex'
                    document.getElementById('acc_lchoice').innerHTML = 'Recivebal'
                    get_data('6');
                    break;
                case '7':
                    document.getElementById('dacc_lchoice').style.display = 'flex'
                    document.getElementById('acc_lchoice').innerHTML = 'Payable'
                    get_data('7');
                    break;
                case '8':
                    document.getElementById('dacc_lchoice').style.display = 'none'
                    get_data('8');
                    break;
                case '9':
                    document.getElementById('dacc_lchoice').style.display = 'none'
                    get_data('9');
                    break;
                default:
                    break;
            }

        })
        function get_data(trns_select) {
            var date1 = $("#kt_daterangepicker_6").data('daterangepicker').endDate.format('YYYY-MM-DD');
            var date2 = $("#kt_daterangepicker_6").data('daterangepicker').startDate.format('YYYY-MM-DD');
            var ser = $('#ser').val();
            $.ajax({
                url: "<?= base_url() . "AccountReport/dataEntryRep_list" ?>",
                type: "POST",
                async: true,
                dataType: 'json',
                data: {
                    'acc_type': trns_select,
                    'date1': date1,
                    'date2': date2,
                    'ser': ser
                },
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
                    alert('Error Retive Data ....');
                    $('body').css('cursor', 'auto');
                }
            });
        }
    });
    var KTBootstrapDaterangepicker = function () {
        var demos = function () {
            var start = moment().subtract(29, 'days');
            var end = moment();
            var s_date1 = new Date($('#vs_date1').val());
            var s_date2 = new Date($('#vs_date2').val());
            $('#kt_daterangepicker_6').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',

                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Financial Year': [s_date1, s_date2]
                }
            }, function (start, end, label) {
                $('#kt_daterangepicker_6 .form-control').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                startDate = start;
                endDate = end;
            });
        }
        return {
            init: function () {
                demos();
            }
        };
    }();
    $('#category').change(function () {
        var id = $(this).val();
        $.ajax({
            url: "<?php echo site_url('product/get_sub_category'); ?>",
            method: "POST",
            data: { id: id },
            async: true,
            dataType: 'json',
            success: function (data) {
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].subcategory_id + '>' + data[i].subcategory_name + '</option>';
                }
                $('#sub_category').html(html);

            }
        });
        return false;
    });

    $(window).load(function () {
        document.getElementById('dacc_lchoice').style.display = 'none'
    });


    function biuld_rep(data) {
        $entry_text1 = "";
        // var acc_revenue = get_account2();
        var cash_id = $("#cash_id").val();
        var trn_id = $("#trn_id").val();
        var amont = $("#amount").val();
        var html = '';
        var group = '';
        // var data = JSON.parse(data)
        var data_entry = data.entry_rep;
        var head_entry = data.entry_head;
        html += '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">';
        var entry_id = 0;
        var entr_1 = 0;
        var entr_2 = 0;
        var ev_entr_1 = 0;
        var ev_entr_2 = 0;

        var ix = 0;
        var ixx = 0;
        var xx = 0;
        $.each(data_entry, function (index, value1) {
            ix++;
            if (value1.trns_id != entry_id) {

                if (ixx > 0) {
                    html += '<tr style="background-color: #eee;">';
                    html += '<td></td>';
                    html += '<td> Total </td>';
                    html += '<td> </td>';
                    html += '<td style="text-align: right;">' + (Number(entr_1) > 0 ? (parseFloat(entr_1)).toFixed(2) : '') + '</td>';
                    html += '<td style="text-align: right;">' + (Number(entr_2) > 0 ? (parseFloat(entr_2)).toFixed(2) : '') + '</td>';
                    html += '<td> </td>';
                    html += '<td> </td>';
                    html += '<td> </td>';
                    html += '<td> </td>';
                    html += '<td style="text-align: right;">' + (Number(ev_entr_1) > 0 ? (parseFloat(ev_entr_1)).toFixed(5) : '') + '</td>';
                    html += '<td style="text-align: right;">' + (Number(ev_entr_2) > 0 ? (parseFloat(ev_entr_2)).toFixed(5) : '') + '</td>';
                    html += '</tr>';

                    entr_1 = 0;
                    entr_2 = 0;
                    ev_entr_1 = 0;
                    ev_entr_2 = 0;

                }
                ixx++;
                html += '<tr>';
                // html += '<table class="table table-striped table-hover table-bordered">';
                html += '<thead>';
                html += '<tr class="datatable-row" style="background-color: rgba(0,0,0,.05);">';

                html += '<th>#</th>';
                html += '<th>Serial</th>';
                html += '<th>Doc No.</th>';
                html += '<th>Debit</th>';
                html += '<th>Credit</th>';
                html += '<th>Debit Account</th>';
                html += '<th>Credit Account</th>';
                html += '<th>Rate</th>';
                html += '<th>Currency</th>';
                html += '<th>Ev. Debit</th>';
                html += '<th>Ev. Credit</th>';

                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                entry_id = value1.trns_id;
                ix = 1;
                xx++;
            }
            html += '<tr style="background-color: #FFF;">';

            html += '<td>' + ix + '</td>';
            if (xx != 0) {
                html += '<td>' + value1.trns_ser + '</td>';
                html += '<td>' + value1.trns_code + '</td>';
            } else {
                html += '<td>' + '' + '</td>';
                html += '<td>' + '' + '</td>';
            }
            html += '<td style="text-align: right;">' + (Number(value1.deb_amount) > 0 ? (parseFloat(value1.deb_amount)).toFixed(2) : '') + '</td>';
            html += '<td style="text-align: right;">' + (Number(value1.crd_amount) > 0 ? (parseFloat(value1.crd_amount)).toFixed(2) : '') + '</td>';
            html += '<td>' + value1.deb_acc_name + '</td>';
            html += '<td>' + value1.crd_acc_name + '</td>';
            html += '<td>' + value1.rate + '</td>';
            html += '<td>' + value1.currency + '</td>';
            html += '<td style="text-align: right;">' + (Number(value1.ev_deb) > 0 ? (parseFloat(value1.ev_deb)).toFixed(6) : '') + '</td>';
            html += '<td style="text-align: right;">' + (Number(value1.ev_crd) > 0 ? (parseFloat(value1.ev_crd)).toFixed(6) : '') + '</td>';
            html += '</tr>';
            entr_1 += +value1.deb_amount;
            entr_2 += +value1.crd_amount;
            ev_entr_1 += +value1.ev_deb;
            ev_entr_2 += +value1.ev_crd;
            xx = 0;

            if (value1.trns_id != entry_id) {
                html += '</tbody>';
                //  html += '</table>';
                html += '</tr>';
            }
            entry_id = value1.trns_id;
        })
        html += '<tr style="background-color: #eee;">';
        html += '<td></td>';
        html += '<td> Total </td>';
        html += '<td> </td>';
        html += '<td style="text-align: right;">' + (Number(entr_1) > 0 ? (Number(entr_1)).toFixed(2) : '') + '</td>';
        html += '<td style="text-align: right;">' + (Number(entr_2) > 0 ? (Number(entr_2)).toFixed(2) : '') + '</td>';
        html += '<td> </td>';
        html += '<td> </td>';
        html += '<td> </td>';
        html += '<td> </td>';
        html += '<td style="text-align: right;">' + (Number(ev_entr_1) > 0 ? (parseFloat(ev_entr_1)).toFixed(5) : '') + '</td>';
        html += '<td style="text-align: right;">' + (Number(ev_entr_2) > 0 ? (parseFloat(ev_entr_2)).toFixed(5) : '') + '</td>';
        html += '</tr>';

        html += '</tbody>';
        html += '</table>';
        $("#rep_body").html(html);

    }
</script>