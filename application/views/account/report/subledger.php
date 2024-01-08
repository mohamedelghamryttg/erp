<div class="container-fluid">
    <!-- <div class="content d-flex flex-column flex-column" id="kt_content" style="padding:0;"> -->
    <div class="d-flex flex-column">
        <!--begin::Entry-->
        <div class="d-flex flex-column">
            <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
            <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
            <!--begin::Container-->
            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact" style="text-align: center;padding-top: 20px;">
                <div class="card-title" style="margin-bottom: auto;">

                    <h1><u><span>Account Subledger</span></u></h1>
                </div>
                <!-- filter  -->
                <div class="modal fade" id="filter11Modal" tabindex="-1" role="dialog" aria-labelledby="filter11ModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center" style="margin-left: auto;margin-right: auto;">
                                <h5 class="modal-title text-uppercase" id="filter11ModalLabel">Account Subledger Search Conditions</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <style>
                                .datepicker {
                                    z-index: 10000;
                                }
                            </style>
                            <div class="modal-body  px-0">
                                <div class="col-12">
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
                                                <select class="form-control" name="currency_id" id="currency_id" required style="width: 100%;">
                                                    <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                                                    <?= $this->admin_model->selectCurrency($currency_id) ?>
                                                </select>
                                            </div>
                                            <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role currency_type" style="text-align: initial;">Currency Type</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <select class="form-control" name="currency_type" id="currency_type" required style="width: 100%;">
                                                    <option value="1">Currency Transaction</option>
                                                    <option selected="selected" value="2">Currency Evaluation</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role currency_id" style="text-align: initial;">Currency</label>
                                            <div class="col-lg-5 col-md-3 col-sm-3">
                                                <select name="account_id" class="form-control m-b" id="account_id" style="width: 100%;">
                                                    <option disabled="disabled" selected="selected" value="">-- Select Account --</option>
                                                    <?= $this->AccountModel->select_chart_sub($brand) ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" name="run" data-toggle="filter11Modal" id="run" type="button" value="search">Run Report</button>
                                <a href="<?= base_url() ?>AccountReport/subledger" class="btn btn-warning">(x) Clear Filter</a>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- filter  -->
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card-body py-0 px-0">
            <div class="card-title">
                <div id="account_name" style="text-align: left;"></div>
            </div>

            <table id="acc_data" class="table table-striped row-bordered display nowrap table-hover ">
                <thead>
                    <!-- <tr>
                        <th rowspan="3" scope="col" id="first_head"></th>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                    </tr> -->

                    <tr>
                        <th class="text-nowrap">#</th>
                        <!-- <th class="text-nowrap">Type</th> -->
                        <th class="text-nowrap">Transaction</th>
                        <th class="text-nowrap">Serial</th>
                        <th class="text-nowrap">Doc. No</th>
                        <th class="text-nowrap">Date</th>

                        <th class="text-nowrap">Debit</th>
                        <th class="text-nowrap">Credit</th>
                        <th class="text-nowrap">Debit Balance</th>
                        <th class="text-nowrap">Credit Balance</th>
                        <th class="text-nowrap">Trans. Amount</th>
                        <th class="text-nowrap">Trans. Currency</th>
                        <th class="text-nowrap">Rate</th>

                        <th class="text-nowrap">Describtion</th>

                    </tr>
                </thead>
                <tbody id="rep_body">



                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>

                </tfoot>
            </table>

        </div>
    </div>
    </section>

    <!--end::Card-->
</div>
<!-- </div> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets_new/js/buttons.html5.js"></script> -->

<script>
    var account_data;
    var bTable;
    var data;
    var myVar = ""
    var redraw = false;
    const n_format = new Intl.NumberFormat('en', {
        style: 'decimal',
        useGrouping: true,
        minimumFractionDigits: 2

    });
    $(document).ready(function() {

        bTable = $("#acc_data").DataTable({
            processing: true,
            retrieve: true,
            paging: true,
            searching: false,
            responsive: false,
            info: true,
            fixedHeader: true,
            deferRender: true,
            estroy: true,
            ordering: false,
            pagingType: "full_numbers",
            scrollX: true,
            scrollY: "60vh",
            scrollCollapse: true,
            pageResize: true,
            dom: "<'toolbar'><'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthMenu: [10, 25, 50],
            pageLength: 10,
            ajax: {
                url: "<?= base_url() . "accountReport/subledger_calc" ?>",
                type: "POST",
                dataType: 'json',
                // async: true,
                data: {
                    filter_data: function() {
                        return $('#form').serialize();
                    }
                },

                dataSrc: 'trns_ledger'
            },
            language: {
                infoEmpty: "No entries to show",
                paginate: {
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>'
                },
            },
            columns: [{

                    data: 'id'
                },
                {
                    data: 'type'
                },
                {
                    data: 'ser'
                },
                {
                    data: 'doc_no'
                },
                {
                    data: 'date'
                },
                {
                    data: 'deb'
                },
                {
                    data: 'crd'

                },
                {
                    data: 'deb_bal'
                },
                {
                    data: 'crd_bal'
                },
                {
                    data: 'f_amount'
                },
                {
                    data: 'curr'
                },
                {
                    data: 'rate'
                },
                {
                    data: 'desc'
                }
            ],
            order: [

            ],
            columnDefs: [{
                targets: 4,
                render: function(data, type, row, meta) {
                    if (type === 'export') {
                        if (data == '') {
                            return ''
                        } else {
                            let spli = data.split('-');
                            let engl = spli[2] + '-' + spli[1] + '-' + spli[0];
                            return Math.round(25569 + (Date.parse(engl) / (86400 * 1000)))
                        }
                    } else {
                        if (data == '') {
                            return ''
                        } else {
                            return data
                        }
                    }
                }
            }, {
                targets: 2,
                render: function(data, type, row, meta) {
                    if (type === 'export') {
                        if (data == '') {
                            return '\u200C';
                        } else {
                            return '\u200C' + data
                        }
                    } else {
                        if (data == '') {
                            return ''
                        } else {
                            return data
                        }
                    }
                }
            }, {
                targets: [5, 6, 7, 8, 9],
                render: function(data, type, row, meta) {
                    if (type === 'export') {
                        if (data == 0) {
                            return ' '
                        } else {
                            return data
                            // $.fn.dataTable.render.number('', '.', 3, '', '').display(data)
                        }
                    } else {
                        if (data == 0) {
                            return ''
                        } else {
                            return $.fn.dataTable.render.number(',', '.', 3, '', '').display(data)
                        }
                    }
                }
            }, {
                targets: 11,
                render: function(data, type, row, meta) {
                    if (type === 'export') {
                        if (data == 0) {
                            return ' '
                        } else {
                            return data
                            //     return $.fn.dataTable.render.number('', ',', 5, '', '').display(data)
                        }
                    } else {
                        if (data == 0) {
                            return ''
                        } else {
                            return $.fn.dataTable.render.number(',', '.', 5, '', '').display(data)
                        }
                    }
                }
            }, {
                targets: [5, 6, 7, 8, 9, 11],
                className: 'text-right'
            }, {
                targets: [1, 2, 3, 4, 10, 12],
                className: 'text-left'
            }],
            buttons: [

                {
                    text: 'Search Conditions',
                    className: 'btn btn-secondary btn-sm text-center font-monospace fw-bold text-uppercase',
                    action: function(e, dt, node, config) {
                        $('#filter11Modal').modal('show')
                    }
                },
                {
                    extend: 'collection',
                    text: 'Export',
                    className: 'btn btn-success btn-sm text-center font-monospace  fw-bold text-uppercase  text-center',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="far fa-file-excel"></i>',
                            className: 'btn btn-success btn-sm text-center font-monospace  fw-bold text-uppercase',

                            titleAttr: 'Excel',
                            autoFilter: true,
                            createEmptyCells: true,
                            title: function() {
                                return 'Account Subledger'
                            },
                            filename: 'Account Subledger',
                            // sheetName: 'Account Subledger',
                            footer: true,
                            exportOptions: {
                                columns: "thead th:not(.noExport)",
                                extension: 'xlsx',
                                modifier: {}

                            },
                            messageTop: function() {
                                var my_newvar = myVar.replace(/<br>/g, "\n");
                                var my_newvar = my_newvar.replace(/&nbsp;/g, " ");
                                return '\n' + my_newvar
                            },
                            exportOptions: {
                                orthogonal: 'export'

                            },
                            // excelStyles: {
                            //     template: "blue_medium"
                            // },
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                var nstyle1 = num_formats(xlsx, 300, "#,##0.000;(#,##0.000)");
                                var nstyle2 = num_formats(xlsx, 301, "#,##0.00000;(#,##0.00000)");


                                // $('c[r=A1]', sheet).attr('s', '2');
                                $('c[r=A2]', sheet).attr('s', '55');
                                // $('row:first c', sheet).attr('s', '42');

                                // $('row:nth-child(3n) t', sheet).text('Custom text');

                                $('row c[r^="F"]', sheet).attr('s', nstyle1);
                                $('row c[r^="G"]', sheet).attr('s', nstyle1);
                                $('row c[r^="H"]', sheet).attr('s', nstyle1);
                                $('row c[r^="I"]', sheet).attr('s', nstyle1);
                                $('row c[r^="J"]', sheet).attr('s', nstyle1);
                                $('row c[r^="L"]', sheet).attr('s', nstyle2);


                                // $('row c[r^="C"]:gt(0)', sheet).attr('t', 'inlineStr');
                                $('row c[r^="C"]', sheet).attr('s', 50);
                                $('row c[r^="E"]', sheet).attr('s', 67);

                                $('row:last c', sheet).attr('s', '22');


                                // $('row:first c', sheet).attr('s', '51');

                                $('row:nth-child(n)', sheet).attr('ht', '21').attr('customHeight', "1");
                                $('row:nth-child(2)', sheet).attr('ht', '100').attr('customHeight', "1");

                                var col = $('col', sheet);
                                $(col[4]).attr('width', 11);
                                // $('row:nth-child(2n) c', sheet).attr('s', '22');
                            }

                        },
                        {
                            extend: 'pdf',
                            text: '<i class="far fa-file-pdf"></i>',
                            className: 'btn btn-success btn-sm text-center font-monospace  fw-bold text-uppercase',

                            titleAttr: 'PDF',
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                                orientation: 'landscape',
                                columns: "thead th:not(.noExport)",
                            },

                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i>',
                            className: 'btn btn-success btn-sm text-center font-monospace  fw-bold text-uppercase',

                            titleAttr: 'Print',

                            exportOptions: {
                                columns: ':visible',
                                orientation: 'landscape',
                                columns: "thead th:not(.noExport)",
                            },
                            customize: function(win) {
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        }
                    ]
                },
                {
                    extend: 'colvis',
                    postfixButtons: ['colvisRestore'],
                    text: '<i class="fa fa-bars"></i>',
                    collectionLayout: 'fixed two-column',
                    collectionTitle: 'Column visibility control',
                    columns: ':not(.noVis)',
                    columnText: function(dt, idx, title) {
                        return (idx + 1) + ': ' + title;
                    },
                }
            ],
            footerCallback: function(tfoot, data, start, end, display) {

                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                var total1 = api
                    .column(5, {
                        page: 'all'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return parseFloat(intVal(a) + intVal(b)).toFixed(3);
                    }, 0);

                $(api.column(5).footer()).html(n_format.format(parseFloat(total1).toFixed(3)));
                ////////
                var total2 = api
                    .column(6, {
                        page: 'all'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return parseFloat(intVal(a) + intVal(b)).toFixed(3);
                    }, 0);
                $(api.column(6).footer()).html(n_format.format(parseFloat(total2).toFixed(3)));
                /////////////
                var balance = total1 - total2

                if (balance > 0) {
                    $(api.column(7).footer()).html(n_format.format(parseFloat(balance).toFixed(3)));
                    $(api.column(8).footer()).html('');
                } else {
                    $(api.column(8).footer()).html(0 - balance);
                    $(api.column(7).footer()).html('');
                }
                $(api.column(1).footer()).html('Totals');
            },
            drawCallback: function() {
                if (redraw === false) {
                    redraw = true;
                    this.api().draw('page');
                } else {
                    redraw = false;
                }

            },
            rowCallback: function(row, data) {
                // $('td:eq(1)', row).html(data[0] + '/' + $('tfoot th:eq(3)').text())
            },

        }).on('buttons-processing', function(e, indicator) {
            if (indicator) {
                Swal.fire({
                    title: 'Please Wait !',
                    html: 'Descargar excel', // add html attribute if you want or remove
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            } else {
                swal.close();
            }
        });;
        //  document.querySelector('div.toolbar').innerHTML = '<b>' + myVar + '</b>';
        $('#run').on('click', function(e) {
            e.preventDefault();

            var account_index = document.getElementById("account_id").selectedIndex;
            if (account_index > 0) {

                myVar = "Account : " + document.getElementById("account_id").options[account_index].text + '\n';
                myVar += "<br>"
                myVar += "Currency : " + document.getElementById("currency_id").options[document.getElementById("currency_id").selectedIndex].text;
                myVar += "<br>"
                myVar += "Currency Type : " + document.getElementById("currency_type").options[document.getElementById("currency_type").selectedIndex].text;
                myVar += "<br>"
                var from_date = document.getElementById("from_date").value;
                from_date = from_date.replace(/-/g, "/");
                from_date = moment(from_date).format('DD-MM-YYYY');
                var to_date = document.getElementById("to_date").value;
                to_date = to_date.replace(/-/g, "/");
                to_date = moment(to_date).format('DD-MM-YYYY');


                myVar += "Date From : " + from_date + '&nbsp;' + '&nbsp;' + '&nbsp;' + '&nbsp;' + " To Date :" + to_date;
                myVar += "<br>"
                // myVar += "<br>"
                // $('#acc_data').append('<caption style="caption-side: top"><div>' + myVar + '</div></caption>');
                $("div.toolbar").html('<left><b >' + myVar + '</right>');
                // mergeCells(rowPos, data.header.length - 1);
            }
            $('#filter11Modal').modal('toggle');
            bTable.ajax.reload();

        });


        function num_formats(xlsx, formatID, formatCode) {
            var sSh = xlsx.xl['styles.xml'];
            var styleSheet = sSh.childNodes[0];
            numFmts = styleSheet.childNodes[0];
            cellXfs = styleSheet.childNodes[5];
            var formatID = formatID;

            /// In what follows, use "createElementNS" everytime the attribute has an uppercase letter; otherwise, Chrome and Firefox will break the XML by lowercasing it

            // Using this instead of "" (required for Excel 2007+, not for 2003)
            var ns = "http://schemas.openxmlformats.org/spreadsheetml/2006/main";
            // Create a custom number format
            var newNumberFormat = document.createElementNS(ns, "numFmt");
            newNumberFormat.setAttribute("numFmtId", formatID);
            newNumberFormat.setAttribute("formatCode", formatCode);
            // Append the new format next to the other ones
            numFmts.appendChild(newNumberFormat);

            // Create a custom style
            var lastStyleNum = $('cellXfs xf', sSh).length - 1;
            var styleNum = lastStyleNum + 1;
            var newStyle = document.createElementNS(ns, "xf");
            // Customize style
            newStyle.setAttribute("numFmtId", formatID);
            newStyle.setAttribute("fontId", 2);
            newStyle.setAttribute("fillId", 0);
            newStyle.setAttribute("borderId", 0);
            newStyle.setAttribute("applyFont", 1);
            newStyle.setAttribute("applyFill", 1);
            newStyle.setAttribute("applyBorder", 1);
            newStyle.setAttribute("xfId", 0);
            newStyle.setAttribute("applyNumberFormat", 1);
            // Alignment (optional)
            var align = document.createElementNS(ns, "alignment");
            align.setAttribute("horizontal", "center");
            newStyle.appendChild(align);
            // Append the style next to the other ones
            cellXfs.appendChild(newStyle);

            // Use the new style on "Age" column
            // $('row:not(:eq(1)) c[r^=F]', sheet).attr('s', styleNum);
            return styleNum;
        }


    })
</script>