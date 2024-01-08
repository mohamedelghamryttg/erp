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
                if (!empty($_REQUEST['searchBank'])) {
                    $searchBank = $_REQUEST['searchBank'];
                } else {
                    $searchBank = "";
                }
                if (!empty($_REQUEST['searchRevenue'])) {
                    $searchRevenue = $_REQUEST['searchRevenue'];
                } else {
                    $searchRevenue = "";
                }
                if (!empty($_REQUEST['searchSer'])) {
                    $searchSer = $_REQUEST['searchSer'];
                } else {
                    $searchSer = "";
                }
                if (!empty($_REQUEST['searchCcode'])) {
                    $searchCcode = $_REQUEST['searchCcode'];
                } else {
                    $searchCcode = "";
                }
                if (!empty($_REQUEST['searchCdate'])) {
                    $searchCdate = $_REQUEST['searchCdate'];
                } else {
                    $searchCdate = "";
                }
                ?>
            </div>

            <div class="modal-body  px-0">
                <div class="col-12">

                    <form class="cmxform form-horizontal" id="searchform" enctype="multipart/form-data">
                        <div class="card-body  py-3 my-0">

                            <div class="form-group row">

                                <label class="col-lg-2 control-label text-right" for="role searchBank">Bank</label>
                                <div class="col-lg-4">
                                    <select name='searchBank' class='form-control m-b' id="searchBank" style="width:100%;">
                                        <option value="" selected="" disabled>-- Select Bank --</option>
                                        <?= $this->AccountModel->selectPaymentCombo('payment_method', $searchBank, $brand, '1'); ?>
                                    </select>
                                </div>

                                <label id="acc_type" class="col-lg-2 col-form-label text-right">Revenue</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="searchRevenue" id="searchRevenue" style="width:100%;">
                                        <option value="" selected='' disabled>-- Select Revenue --</option>
                                        <?= $this->AccountModel->Allrevenue($brand, $searchRevenue, $parent_id); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 control-label text-right" for="role searchSer">Serial Number</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="searchSer" id="searchSer" value="<?= $searchSer ?>">
                                </div>

                                <label id="acc_type" class="col-lg-2 col-form-label text-right" for="role searchCcode">Document
                                    Number</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="searchCcode" id="searchCcode" value="<?= $searchCcode ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right" for="role searchChequeNo">Cheque Number</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="searchChequeNo" id="searchChequeNo">
                                </div>
                                <label class="col-lg-2 control-label text-right" for="role searchChequeDate">Collection Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="date-sheet form-control" name="searchChequeDate" id="searchChequeDate">
                                </div>


                            </div>
                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label col-sm-12 text-right" for="role searchCdate">Date
                                    Ranges</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">

                                    <div class='input-group' id='kt_daterangepicker_6'>
                                        <input type='text' class="form-control" placeholder="Select date range" name="searchCdate" id="searchCdate" />

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
                <a href="<?= base_url() ?>account/bankouttrnlist" class="btn btn-warning">(x) Clear Filter</a>
            </div>
        </div>
    </div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="container-fluid">
        <!-- start search form card -->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h2 class="card-label text-center"><u><b>Receipt Bank Out List </b></u></h2>
                </div>
            </div>
            <div class="card-body px-0">

                <table class="table table-separate table-head-custom table-hover" id="kt_datatable2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>ID</th>
                            <th>Serial</th>
                            <th>Doc Number</th>
                            <th>Date</th>
                            <th>Bank</th>
                            <th>Revenue</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Rate</th>
                            <th>Cheque Number</th>
                            <th>Collection Date</th>
                            <th>Notes</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var startDate;
        var endDate;
        var bTable;
        let BankOutData;
        let permission;
        let audit_permission;
        KTBootstrapDaterangepicker.init();
        $.fn.dataTableExt.sErrMode = "console";
        $.fn.DataTable.ext.pager.numbers_length = 15;
        loadAjaxData();

        function loadAjaxData() {
            $.ajax({
                url: base_url + 'account/get_bankOutList',
                type: "POST",
                async: true,

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
                    BankOutData = data['bank_trn'];
                    permission = data['permission'];
                    audit_permission = data['audit_permission'];
                    swal.close();
                    createTables(BankOutData, permission, audit_permission);
                    return
                },
                error: function(jqXHR, exception) {
                    swal.close();
                }
            });
        }

        function createTables(BankOutData, permission, audit_permission) {

            bTable = $("#kt_datatable2").DataTable({
                data: BankOutData,

                processing: true,
                serverSide: false,
                bDestroy: true,
                paging: true,
                select: false,
                searching: false,
                dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                pagingType: "full_numbers",
                scrollX: true,
                scrollY: "50vh",
                scrollCollapse: true,
                pageResize: true,
                responsive: true,

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
                autoWidth: true,
                orderCellsTop: true,
                deferRender: false,
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "text-right"
                    },
                    {
                        data: null,
                        render: function(row) {
                            outPut = "<div>"
                            if (row.doc_file && row.doc_file != '') {
                                outPut += ' &nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color: cadetblue;"> </i>';
                            }
                            if (row.audit_chk && row.audit_chk == 1) {
                                outPut += ' &nbsp;<i class="fas fa-stamp" aria-hidden="true" style="color: cadetblue;"></i>';
                            }
                            outPut += "</div>"
                            return outPut;
                        }
                    },
                    {
                        data: 'id',
                    },
                    {
                        data: null,
                        render: function(row) {
                            outPut = "<div>"
                            if (permission.view == 1 || permission.edit == 1 || (audit_permission.edit ?? '') == 1) {
                                outPut += '<a href="<?php echo base_url() ?>account/editBankoutTrn/' + btoa(row.id) + '">' + row.ccode + '</a>'
                            } else {
                                outPut += row.ccode
                            }
                            outPut += "</div>"
                            return outPut;
                        }
                    },
                    {
                        data: null,
                        render: function(row) {
                            outPut = "<div>"
                            if (permission.view == 1 || permission.edit == 1 || (audit_permission.edit ?? '') == 1) {
                                outPut += '<a href="<?php echo base_url() ?>account/editBankoutTrn/' + btoa(row.id) + '" class="">' + row.doc_no + '</a>'
                            } else {
                                outPut += row.doc_no
                            }
                            outPut += "</div>"
                            return outPut;
                        }
                    },
                    {
                        data: 'date',
                        render: function(data, type, row) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            }
                            return moment(data).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'bank_name'
                    },
                    {
                        data: 'trn_name'
                    },
                    {
                        data: 'amount',
                        className: "text-right"
                    },

                    {
                        data: 'currency_name'
                    },
                    {
                        data: 'rate',
                        className: "text-right"
                    },
                    {
                        data: 'cheque_no'
                    },
                    {
                        data: 'cheque_date',
                        render: function(data, type, row) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            }
                            return moment(data).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'rem'
                    },
                    {
                        data: 'users_name'
                    },
                    {
                        data: 'created_at'
                    },

                    {
                        data: null,
                        className: 'noExport noVis',
                        orderable: false,
                        render: function(data, type, row) {
                            var action_btn = '<div>';
                            if (permission && permission.edit == '1') {
                                action_btn += '<a href="<?php echo base_url() ?>account/editBankoutTrn/' + btoa(row.id) + '" class=""><i class="fa fa-pencil"></i> Edit</a>'
                            }
                            action_btn += '</div>';
                            return action_btn
                        }
                    },
                    {
                        data: null,
                        className: 'noExport noVis',
                        orderable: false,
                        render: function(data, type, row) {
                            var action_btn = '<div>';
                            if (permission && permission.delete == '1') {
                                var conf_text = 'Are you sure you want to delete this Permission ? ';
                                action_btn += '<a href="<?php echo base_url() ?>account/deleteBankoutTrn/' + btoa(row.id) + ' title="delete" class="" onclick="return confirm("' + conf_text + '");"> <i class = "fa fa-times text-danger text"> </i> Delete </a>';
                            }
                            action_btn += '</div>';
                            return action_btn
                        }
                    }
                ],
                columnDefs: [{
                    // targets: 3,
                    // render: $.fn.dataTable.render.moment('M-DD-YYYY,THH:mm', 'M/DD/YYYY')
                }],
                order: [],
                buttons: [{
                        text: 'Add New Bank Out',
                        className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase',
                        action: function(e, dt, node, config) {
                            if (permission && permission.add == '1') {
                                window.location.href = "<?= base_url() ?>account/addBankoutTrn";
                            }
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
                        // className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',

                        text: 'Export',
                        buttons: [{
                                extend: 'excelHtml5',
                                text: '<i class="far fa-file-excel"></i>',
                                titleAttr: 'Excel',
                                autoFilter: true,
                                title: 'Permission List',
                                filename: 'Permission List',
                                sheetName: 'Permission List',
                                exportOptions: {
                                    columns: "thead th:not(.noExport)",
                                    extension: 'xlsx',
                                    modifier: {
                                        // page: 'current'
                                    }

                                },
                                excelStyles: {
                                    template: "blue_medium"
                                },
                                init: function(api, node, config) {
                                    $(node).removeClass('btn-secondary')
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="far fa-file-pdf"></i>',
                                titleAttr: 'PDF',
                                exportOptions: {
                                    columns: ':visible',
                                    orientation: 'landscape',
                                    columns: "thead th:not(.noExport)",
                                },

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

            }).on('buttons-processing', function(e, indicator) {
                if (indicator) {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Descargar excel', // add html attribute if you want or remove
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        }
                    });
                } else {
                    swal.close();
                }
            });
        }
        //////////////////////////////
        $('#search').on('click', function(e) {
            e.preventDefault();
            loadAjaxData();
            $('#filter11Modal').modal('toggle');
        });

    })
    var KTBootstrapDaterangepicker = function() {
        var demos = function() {
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
            }, function(start, end, label) {
                $('#kt_daterangepicker_6 .form-control').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                startDate = start;
                endDate = end;
            });
        }
        return {
            init: function() {
                demos();
            }
        };
    }();
</script>