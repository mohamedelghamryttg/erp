<?php if ($this->session->flashdata('true')) { ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong><?= $this->session->flashdata('true') ?></strong></span>
    </div>
<?php  } ?>
<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong><?= $this->session->flashdata('error') ?></strong></span>
    </div>
<?php  } ?>
<div class="modal fade" id="filter11Modal" tabindex="-1" role="dialog" aria-labelledby="filter11ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="margin-left: auto;margin-right: auto;">
                <h5 class="modal-title text-uppercase" id="filter11ModalLabel">Search Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>
                <?php
                if (!empty($filter['searchEmpty'])) {
                    $searchEmpty = $filter['searchEmpty'];
                } else {
                    $searchEmpty = "";
                }
                if (!empty($filter['t.code LIKE'])) {
                    $code = $filter['t.code LIKE'];
                } else {
                    $code = "";
                }
                if (!empty($filter['t.created_by ='])) {
                    $created_by = $filter['t.created_by ='];
                } else {
                    $created_by = "";
                }
                if (!empty($filter['t.vendor ='])) {
                    $vendor = $filter['t.vendor ='];
                } else {
                    $vendor = "";
                }
                if (isset($filter['t.status ='])) {
                    $status = $filter['t.status ='];
                } else {
                    $status = "";
                }
                if (!empty($filter['t.verified ='])) {
                    $invoice_status = 1;
                } elseif (!empty($filter['t.verified <>'])) {
                    $invoice_status = 2;
                } else {
                    $invoice_status = "";
                }
                if (empty($payment_method)) {
                    $payment_method = "";
                }
                if (!empty($filter['t.created_at >='])) {
                    $date_from = date("m/d/Y", strtotime($filter['t.created_at >=']));
                } else {
                    $date_from = "";
                }
                if (!empty($filter['t.created_at <='])) {
                    $date_to = date("m/d/Y", strtotime($filter['t.created_at <=']));
                } else {
                    $date_to = "";
                }
                // $vpo_status = ["Running", "Delivered", "Canceled"];
                $vpo_status = ["Running", "Delivered", "Cancelled", "Rejected", "Waiting Vendor Acceptance", "Waiting PM Confirmation", "Not Started Yet", "Heads Up", "Heads Up ( Marked as Available )", "Heads Up ( Marked as Not Available )"];

                ?>
            </div>

            <div class="modal-body  px-0">
                <div class="col-12">

                    <form class="cmxform form-horizontal" id="searchform" method="post" enctype="multipart/form-data">
                        <div class="card-body  py-3 my-0">
                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label text-lg-right">PO Number</label>
                                <div class="col-lg-3">
                                    <input class="form-control" type="text" name="code" autocomplete="off" value="<?php echo $code ?>">
                                </div>

                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">PM Name</label>
                                <div class="col-lg-3">
                                    <select name="created_by" class="form-control m-b" id="created_by" style="width: 100%;">
                                        <option value="">-- Select PM --</option>
                                        <?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label text-lg-right">Vendor Name</label>
                                <div class="col-lg-3">
                                    <select name="vendor" class="form-control m-b" id="vendor" style="width: 100%;">
                                        <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                        <?= $this->vendor_model->selectVendor($vendor, $this->brand) ?>
                                    </select>
                                </div>

                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Vpo Status</label>
                                <div class="col-lg-3">
                                    <select name="status" class="form-control m-b" id="status" style="width: 100%;">
                                        <option disabled selected="selected">-- Select Status --</option>
                                        <?php
                                        for ($i = 0; $i < count($vpo_status); $i++) {
                                            if ($status != "" && $status == $i) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $i . "' " . $selected . ">" . $vpo_status[$i] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label text-lg-right">Invoice Status</label>
                                <div class="col-lg-3">
                                    <select name="invoice_status" class="form-control m-b" id="invoice_status" style="width: 100%;">
                                        <option disabled="disabled" selected="selected">-- Select Status --</option>
                                        <?php if ($invoice_status == 1) { ?>
                                            <option value="1" selected>Verified</option>
                                            <option value="2">Not Verified</option>
                                        <?php } elseif ($invoice_status == 2) { ?>
                                            <option value="1">Verified</option>
                                            <option value="2" selected>Not Verified</option>
                                        <?php } else { ?>
                                            <option value="1">Verified</option>
                                            <option value="2">Not Verified</option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Payment Status</label>
                                <div class="col-lg-3">
                                    <select name="payment_status" class="form-control m-b" id="payment_status" style="width: 100%;">
                                        <option disabled="disabled" selected="selected">-- Select Status --</option>
                                        <?php if ($payment_method == 1) { ?>
                                            <option value="1" selected>Paid</option>
                                            <option value="2">Not Paid</option>
                                        <?php } elseif ($payment_method == 2) { ?>
                                            <option value="1">Paid</option>
                                            <option value="2" selected>Not Paid</option>
                                        <?php } else { ?>
                                            <option value="1">Paid</option>
                                            <option value="2">Not Paid</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-lg-right">

                                    <div class="dropdown dropdown-inline" data-bs-theme="light">
                                        <button class="btn btn-secondary  btn-icon btn-sm " type="button" id="dropdownMenuButtonLight" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border: none;height: 100%;">
                                            <i class="fa fa-ellipsis-v text-primary" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonLight">
                                            <li><a class="dropdown-item " onclick="changeValue('today')" href="javascript:void(0);">Today</a></li>
                                            <li><a class="dropdown-item " onclick="changeValue('7today')" href="javascript:void(0);">Last 7 Days</a></li>
                                            <li><a class="dropdown-item " onclick="changeValue('30today')" href="javascript:void(0);">Last 30 Days</a></li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" onclick="changeValue('month')" href="javascript:void(0);">This Month</a></li>
                                            <li><a class="dropdown-item" onclick="changeValue('lmonth')" href="javascript:void(0);">Last Month</a></li>
                                            <li><a class="dropdown-item" onclick="changeValue('year')" href="javascript:void(0);">This Year</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" onclick="changeValue('fyear1')" href="javascript:void(0);">First Quarter</a></li>
                                            <li><a class="dropdown-item" onclick="changeValue('fyear2')" href="javascript:void(0);">Secand Quarter</a></li>
                                            <li><a class="dropdown-item" onclick="changeValue('fyear3')" href="javascript:void(0);">Theard Quarter</a></li>
                                            <li><a class="dropdown-item" onclick="changeValue('fyear4')" href="javascript:void(0);">Forth Quarter</a></li>
                                        </ul>
                                        <!-- </div> -->

                                    </div> From Date
                                </label>
                                <!-- <label class="col-lg-2 col-form-label text-lg-right">Date From</label> -->
                                <div class="col-lg-3">
                                    <input class="form-control date_sheet" type="text" name="date_from" id="date_from" autocomplete="off" value=<?= $date_from ?>>
                                </div>

                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
                                <div class="col-lg-3">
                                    <input class="form-control date_sheet" type="text" name="date_to" id="date_to" autocomplete="off" value=<?= $date_to ?>>
                                </div>
                            </div>
                            <input hidden type="text" name="searchEmpty" id="searchEmpty" value=<?= $searchEmpty ?>>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
                <a href="<?= base_url() ?>accounting/vpoStatus" class="btn btn-warning">(x) Clear Filter</a>
            </div>
        </div>
    </div>
</div>
<style>
    .whiteSpace {
        white-space: normal;
    }

    .dataTables_wrapper th,
    td {
        white-space: nowrap;

    }
</style>
<div class="content d-flex flex-column flex-column-fluid py-2" id="kt_content">
    <!-- pt-3 -->
    <div class="container-fluid">
        <!--begin::Card-->
        <div class="card">
            <div class="card  pt-2 mb-2 pb-0">
                <div class="card-header flex-wrap border-0 py-0">
                    <h3 class="card-label">Vendor Purchase Order List (VPO)</h3>
                </div>
            </div>
            <div class="card-body px-0">
                <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                    <!-- <table class="table table-striped table-head-custom table-bordered display  " id="kt_datatable2" cellspacing="0" width="100%"> -->

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PM Name</th>
                            <th>P.O Number</th>
                            <th>VPO Status</th>
                            <th>CPO Verified</th>
                            <th>CPO Verified Date</th>
                            <th>VPO Date</th>
                            <th>VPO File</th>
                            <th>Vendor Name</th>
                            <th>Source Language</th>
                            <th>Target Language</th>
                            <th>Task Type</th>
                            <th>Count</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Currency</th>
                            <th>P.O Amount</th>
                            <th>Invoice Status</th>
                            <th>Invoice Date</th>
                            <th>Due Date (45 Days)</th>
                            <th>Max Due Date (60 Days)</th>
                            <th>Payment Status</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>System</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>
<input type='hidden' id="brand_id" value="<?= $this->brand ?>">
<input type='hidden' id="brand_name" value="<?= $this->admin_model->getBrand($brand) ?>">

<script type="text/javascript" src="<?php echo base_url(); ?>assets_new/js/images.js"></script>
<script>
    var bTable;
    let taskData;
    let permissions;
    var myVar = ""
    var brand_id = $('#brand_id').val()
    logo_def(brand_id)

    const n_format = new Intl.NumberFormat('en', {
        style: 'decimal',
        useGrouping: true,
        minimumFractionDigits: 2

    });
    $(document).ready(function() {
        $.fn.dataTableExt.sErrMode = "console";

        loadAjaxData();

        function loadAjaxData() {
            $.ajax({
                url: base_url + 'accounting/get_task',
                type: "POST",
                async: true,
                // dataType: 'json',
                data: {
                    filter_data: function() {
                        return $('#searchform').serialize();
                    }
                },
                beforeSend: function() {

                    Swal.fire({
                        title: 'Please Wait !',
                        text: 'Data Loading ....',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: function() {
                            Swal.showLoading()
                        }
                    });

                },

                success: function(data) {
                    var data = JSON.parse(atob(data));
                    // console.log(data)
                    taskData = data['task'];
                    permissions = data['permission'];
                    swal.close();
                    createTables(taskData, permissions);
                    return
                },
                error: function(jqXHR, exception) {
                    swal.close();
                }
            });
        }

        function createTables(taskData, permissions) {

            bTable = $("#kt_datatable2").DataTable({
                data: taskData,

                processing: true,
                serverSide: true,

                bDestroy: true,
                paging: true,
                select: false,
                searching: false,
                dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
                    "<'row'<'col-sm-12'frt>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                pagingType: "full_numbers",
                scrollX: true,
                scrollY: "60vh",
                scrollCollapse: true,
                pageResize: true,
                responsive: false,

                rowReorder: true,
                orderMulti: true,
                fixedHeader: true,
                language: {
                    lengthMenu: "_MENU_ Rows per page",
                    info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                    paginate: {
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    },
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                },

                order: [1, 'desc'],
                autoWidth: false,
                orderCellsTop: true,
                deferRender: true,
                // tooltip: true,
                columns: [{
                        data: null,
                        className: "text-right noExport noVis",
                        render: function(data, type, row, meta) {
                            var outPut = "<div>"
                            // outPut += '<span>' + (meta.row + meta.settings._iDisplayStart + 1) + '   </span>'
                            if (row.payment_status && row.payment_status == 1) {
                                outPut += "<img src='<?= base_url() ?>assets/images/check.png' />"
                            }
                            outPut += "</div>"
                            return outPut;
                        },

                    },
                    {
                        data: 'user_name',
                        className: 'whiteSpace'

                    },
                    {
                        data: 'code',
                        className: 'whiteSpace'
                    },
                    {
                        data: null,
                        render: function(row) {
                            var vpo_status = ["Running", "Delivered", "Cancelled", "Rejected", "Waiting Vendor Acceptance", "Waiting PM Confirmation", "Not Started Yet", "Heads Up", "Heads Up ( Marked as Available )", "Heads Up ( Marked as Not Available )"];
                            if (row.status) {
                                return vpo_status[row.status]
                            } else {
                                return ''
                            }

                        }
                    },
                    {
                        data: null,
                        render: function(row) {
                            return ((row.po_verified == 1) ? "Verified" : '')
                        }
                    },
                    {
                        data: null,
                        render: function(row) {
                            return ((row.po_verified == 1) ? row.po_verified_at : '')
                        }
                    },
                    {
                        data: 'closed_date'
                    },
                    {
                        data: null,
                        className: 'noExport',
                        orderable: false,
                        render: function(row) {
                            if (row.vpo_file) {
                                if (row.vpo_file.length > 1) {
                                    if (row.job_portal == 1) {
                                        return '<a href = "<?= $this->projects_model->getNexusLinkByBrand() ?>/assets/uploads/invoiceVendorFiles/' + row.vpo_file + '" target = "_blank" > Click Here </a>'
                                    } else {
                                        return '<a href = "<?= base_url() ?>assets/uploads/vpo/' + row.vpo_file + '" target = "_blank" > Click Here </a>'
                                    }
                                } else {
                                    return "";
                                }
                            } else {
                                return "";
                            }
                        }
                    },
                    {
                        data: 'vendor_name'
                    },
                    {
                        data: 'source_lang'
                    },
                    {
                        data: 'target_lang'
                    },
                    {
                        data: 'task_type_name'
                    },
                    {
                        data: 'count'
                    },
                    {
                        data: 'unit_name'
                    },
                    {
                        data: 'rate'
                    },
                    {
                        data: 'currency_name'
                    },
                    {
                        data: 'totalamount',
                    },
                    {
                        data: 'verifiedStat',
                    },
                    {
                        data: 'invoice_dated'

                    },
                    {
                        data: 'date45',
                    },
                    {
                        data: 'date60',
                    },
                    {
                        data: 'PaidStat',
                    },
                    {
                        data: 'payment_date',
                    },
                    {
                        data: 'payment_method_name',
                    },
                    {
                        data: 'portalStat',
                    },

                ],
                columnDefs: [{
                        targets: 0,
                        orderable: false
                    },
                    {
                        targets: [12, 14, 16],
                        render: function(data, type, row, meta) {
                            if (type === 'export') {
                                if (data == 0) {
                                    return ' '
                                } else {
                                    return $.fn.dataTable.render.number('', '.', 3, '', '').display(data)
                                }
                            } else {
                                if (data == 0) {
                                    return ''
                                } else {
                                    return $.fn.dataTable.render.number(',', '.', 3, '', '').display(data)
                                }
                            }
                        }
                    },
                    {
                        targets: [12, 14, 16],
                        className: 'text-right'
                    },
                    // {
                    //     targets: [0, 1, 2, 3, 4, 5, 6, 14, 16],

                    //     tooltip: '<span data-toggle="tooltip" title="' + data + '">' + data + '</span>'
                    // }
                ],

                buttons: [{
                        text: 'Retrieve All',
                        className: 'btn btn-info btn-sm text-center font-monospace fw-bold text-uppercase',
                        action: function(e, dt, node, config) {
                            $('#searchEmpty').val('search');
                            e.preventDefault();
                            loadAjaxData();
                        }
                    },
                    {
                        text: 'Search Conditions',
                        className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',
                        action: function(e, dt, node, config) {
                            $('#filter11Modal').modal('show')
                        }
                    },
                    {
                        extend: 'collection',

                        text: 'Export',
                        buttons: [{
                                extend: 'excelHtml5',
                                text: '<i class="far fa-file-excel"></i>',
                                titleAttr: 'Excel',
                                autoFilter: true,

                                createEmptyCells: true,
                                title: function() {
                                    return 'Vendor Purchase Order (VPO)'
                                },
                                filename: 'Vendor Purchase Order (VPO)',
                                // sheetName: 'Account Subledger',
                                footer: true,
                                exportOptions: {
                                    columns: "thead th:not(.noExport)",
                                    extension: 'xlsx',
                                    modifier: {
                                        // page: 'current'
                                    }

                                },
                                // messageTop: function() {
                                //   var my_newvar = myVar.replace(/<br>/g, "\n");
                                //   var my_newvar = my_newvar.replace(/&nbsp;/g, " ");
                                //   return '\n' + my_newvar
                                // },
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

                                    // $('c[r=A2]', sheet).attr('s', '55');

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
                                extend: 'pdfHtml5',
                                text: '<i class="far fa-file-pdf"></i>',
                                titleAttr: 'PDF',
                                title: 'Vendor Purchase Order (VPO)',
                                filename: 'Vendor Purchase Order (VPO)',
                                charset: 'utf-8',
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                download: 'download',
                                exportOptions: {
                                    columns: ':visible',
                                    footer: false,
                                    header: false,
                                    columns: "thead th:not(.noExport)",
                                    modifier: {
                                        page: 'current'

                                    },
                                },
                                customize: function(doc) {
                                    var colCount = new Array();
                                    var length = $('#kt_datatable2 tbody tr:first-child td').length;
                                    $('#kt_datatable2').find('tbody tr:first-child td').each(function() {
                                        if ($(this).attr('colspan')) {
                                            for (var i = 1; i <= $(this).attr('colspan'); i++) {
                                                colCount.push('*');
                                            }
                                        } else {
                                            colCount.push(parseFloat(100 / length) + '%');
                                        }
                                    });
                                    doc.content[1].layout = "Borders";

                                    const brand_name = $('#brand_name').val();
                                    doc['header'] = (function() {
                                        return {
                                            columns: [{
                                                    image: logoName,
                                                    width: 48
                                                },
                                                {
                                                    alignment: 'left',
                                                    italics: true,
                                                    text: 'dataTables',
                                                    fontSize: 18,
                                                    margin: [10, 0]
                                                },
                                                {
                                                    alignment: 'right',
                                                    fontSize: 14,
                                                    text: brand_name
                                                }
                                            ],
                                            margin: 20
                                        }
                                    });
                                    var now = new Date();
                                    var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                                    doc['footer'] = (function(page, pages) {
                                        return {
                                            columns: [{
                                                    alignment: 'left',
                                                    text: ['Created on: ', {
                                                        text: jsDate.toString()
                                                    }]
                                                },
                                                {
                                                    alignment: 'right',
                                                    text: ['page ', {
                                                        text: page.toString()
                                                    }, ' of ', {
                                                        text: pages.toString()
                                                    }]
                                                }
                                            ],
                                            margin: 20
                                        }
                                    });
                                }

                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i>',
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
                initComplete: function() {
                    this.api().columns().header().to$().each(function() {
                        $(this).attr('title', 'Note that, the ability for the user to shift click to order multiple columns')
                    })
                }
            }).on('buttons-processing', function(e, indicator) {
                if (indicator) {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Descargar excel', // add html attribute if you want or remove
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading()
                        }
                    });
                } else {
                    swal.close();
                }
            });
        }

        // $("#kt_datatable2").on('order.dt search.dt', function() {
        //   t.column(0, {
        //     search: 'applied',
        //     order: 'applied'
        //   }).nodes().each(function(cell, i) {
        //     cell.innerHTML = i + 1;
        //   });
        // }).draw();

        //////////////////////////////
        $('#search').on('click', function(e) {
            $('#searchEmpty').val('search');
            e.preventDefault();
            loadAjaxData();
            $('#filter11Modal').modal('toggle');
        });
        //////////////////////////////   
        function num_formats(xlsx, formatID, formatCode) {
            var sSh = xlsx.xl['styles.xml'];
            var styleSheet = sSh.childNodes[0];
            var numFmts = styleSheet.childNodes[0];
            var cellXfs = styleSheet.childNodes[5];
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

    function changeValue(o) {

        switch (o) {
            case 'today':
                var starDay = moment().format('YYYY-MM-DD');
                $('#date_from').val(starDay);
                $('#date_to').val(starDay);

                break;
            case '7today':

                var startOfMonth = moment().subtract(6, 'days').format('YYYY-MM-DD');
                var endOfMonth = moment().format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case '30today':
                var startOfMonth = moment().subtract(1, 'months').subtract(-1, 'days').format('YYYY-MM-DD');
                var endOfMonth = moment().format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case 'month':
                var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
                var endOfMonth = moment().endOf('month').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case 'lmonth':

                var startOfMonth = moment().subtract(1, 'months').startOf('month').format('YYYY-MM-DD');
                var endOfMonth = moment().subtract(1, 'months').endOf('month').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;

            case 'year':
                var startOfMonth = moment().startOf('year').format('YYYY-MM-DD');
                var endOfMonth = moment().endOf('year').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case 'fyear':
                var startOfMonth = $('#vs_date1').val();
                var endOfMonth = $('#vs_date2').val();

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case 'fyear1':
                var startOfMonth = moment().quarter(1).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(1).endOf('quarter').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
                break;
            case 'fyear2':
                var startOfMonth = moment().quarter(2).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(2).endOf('quarter').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case 'fyear3':
                var startOfMonth = moment().quarter(3).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(3).endOf('quarter').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            case 'fyear4':
                var startOfMonth = moment().quarter(4).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(4).endOf('quarter').format('YYYY-MM-DD');

                $('#date_from').val(startOfMonth);
                $('#date_to').val(endOfMonth);
                break;
            default:
                $('#date_from').val('');
                $('#date_to').val('');
                break;
        }
        return
    }
</script>