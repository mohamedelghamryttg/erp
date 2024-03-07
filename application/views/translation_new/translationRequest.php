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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<style>
    .tab-content {
        border: 1px solid #dee2e6 !important;
        border-top: transparent !important;
        padding: 15px;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid py-0" id="kt_content">
    <div class="container-fluid">
        <div class="card mb-2">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title mb-3" style="display: flex;">
                    <h3 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">Translation</h3>
                    <h7 href="#" class="text-muted pt-8">Requests</h7>
                </div>
            </div>
        </div>
        <input type='hidden' id="brand_id" value="<?= $brand ?>">
        <input type='hidden' id="brand_name" value="<?= $this->admin_model->getBrand($brand) ?>">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="tab-1" data-bs-toggle="tab" data-bs-target="#card-1" type="button" role="tab" aria-controls="card-1" aria-selected="true">
                    All Requests | &nbsp;<span class="font-weight-bold" id="total_rows"></span>
                </button>
                <button class="nav-link " id="tab-2" data-bs-toggle="tab" data-bs-target="#card-2" type="button" role="tab" aria-controls="card-2" aria-selected="false">
                    Translation Requests Waiting Confimation | &nbsp;<span class="font-weight-bold" id="total_rows1"></span>
                </button>
                <button class="nav-link " id="tab-3" data-bs-toggle="tab" data-bs-target="#card-3" type="button" role="tab" aria-controls="card-3" aria-selected="false">
                    Heads Up Requests Waiting Confimation | &nbsp;<span class="font-weight-bold" id="total_rows2"></span>
                </button>
            </div>
        </nav>
        <!-- tab 1 -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="card-1" role="tabpanel" aria-labelledby="tab-1">
                <!-- <div class="tab-pane fade show active" id="card-1" role="tabpanel"> -->
                <table class="table table-striped table-separate table-head-custom table-hover nowrap" id="allRequests" width="100%">
                    <thead>
                        <tr>
                            <th>Task Code</th>
                            <th>Task Name</th>
                            <th>Count</th>
                            <th>TM</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Request By</th>
                            <th>Request At</th>
                            <th>View Jobs</th>
                            <th>View Request</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- tab 1 -->
            <div class="tab-pane fade show " id="card-2" role="tabpanel" aria-labelledby="tab-2">
                <table class="table table-striped table-separate table-head-custom table-hover nowrap" id="translationRequests" width="100%">
                    <thead>
                        <tr>
                            <th>PM</th>
                            <th>Task Code</th>
                            <th>Task Type</th>
                            <th>Volume</th>
                            <th>Unit</th>
                            <th>Task Name</th>
                            <th>Start Date</th>
                            <th>Delivery Date</th>
                            <th>Created Date</th>
                            <th>View Task</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- tab 1 -->
            <div class="tab-pane fade show" id="card-3" role="tabpanel" aria-labelledby="tab-3">
                <table class="table table-striped table-separate table-head-custom table-hover nowrap" id="handsRequests" width="100%">
                    <thead>
                        <tr>
                            <th>PM</th>
                            <th>Task Code</th>
                            <th>Task Type</th>
                            <th>Volume</th>
                            <th>Unit</th>
                            <th>Task Name</th>
                            <th>Start Date</th>
                            <th>Delivery Date</th>
                            <th>Created Date</th>
                            <th>View Task</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filter11Modal" role="dialog" aria-labelledby="filter11ModalLabel" aria-hidden="true">
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
                if (!empty($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                } else {
                    $code = "";
                }

                if (!empty($_REQUEST['pm'])) {
                    $pm = $_REQUEST['pm'];
                } else {
                    $pm = "";
                }

                if (!empty($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (!empty($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                } else {
                    $subject = "";
                }
                if (!empty($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                } else {
                    $status = "";
                }
                ?>
            </div>

            <div class="modal-body  px-0">
                <div class="col-12">

                    <form class="cmxform form-horizontal" id="searchform" enctype="multipart/form-data">
                        <div class="card-body  py-3 my-0">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Request Code:</label>
                                <div class="col-lg-3">
                                    <input class="form-control " type="text" name="code" value="<?= $code ?>">
                                </div>
                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Requestor Name:</label>
                                <div class="col-lg-3">
                                    <select name="pm" class="form-control m-b" id="pm" style="width : 100%;">
                                        <option value="" disabled="disabled" selected="selected">-- Select Requestor --</option>
                                        <?= $this->admin_model->selectAllPm($pm, $this->brand) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date From :</label>
                                <div class="col-lg-3">
                                    <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                                </div>
                                <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date To :</label>
                                <div class="col-lg-3">
                                    <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-lg-right">Task Name :</label>
                                <div class="col-lg-3">
                                    <input class="form-control " type="text" name="subject" value="<?= $subject ?>">
                                </div>

                                <label class="col-lg-2 col-form-label text-lg-right" for="role name">Status:</label>
                                <div class="col-lg-3">
                                    <select name="status" class="form-control m-b" style="width : 100%;">
                                        <option value="">-- Select --</option>

                                        <option value="2" <?= $status == '2' ? "selected" : '' ?>>Running</option>;
                                        <option value="3" <?= $status == '3' ? "selected" : '' ?>>Closed</option>;
                                        <option value="4" <?= $status == '4' ? "selected" : '' ?>>Cancelled</option>;
                                        <option value="0" <?= $status == '0' ? "selected" : '' ?>>Rejected</option>;
                                        <option value="1" <?= $status == '1' ? "selected" : '' ?>>Waiting Confirmation</option>;
                                        <option value="5" <?= $status == '5' ? "selected" : '' ?>>Update</option>;
                                        <option value="6" <?= $status == '6' ? "selected" : '' ?>>Not Started Yet</option>;
                                        <option value="7" <?= $status == '7' ? "selected" : '' ?>>Heads Up ( Waiting Response )</option>;
                                        <option value="8" <?= $status == '8' ? "selected" : '' ?>>Heads Up ( Marked as Available )</option>;
                                        <option value="9" <?= $status == '9' ? "selected" : '' ?>>Heads Up ( Marked as Not Available )</option>;

                                    </select>
                                </div>
                            </div>

                            <!-- <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <button class="btn btn-primary" name="search" type="submit">Search</button>
                                        <button class="btn btn-success" onclick="var e2 = document.getElementById('translationRequestForm'); e2.action = '<?= base_url() ?>translation/exportRequests'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                                        <a href="<?= base_url() ?>translation" class="btn btn-warning">(x) Clear Filter</a>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
                <a href="<?= base_url() ?>translation" class="btn btn-warning">(x) Clear Filter</a>
            </div>
        </div>
    </div>


</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets_new/js/images.js"></script>

<script>
    var aTable;
    var tTable;
    var hTable;
    var logoName
    let allRequestsData;
    let translationRequestsData;
    let handsRequestsData;
    let permissions;
    var brand_id = $('#brand_id').val()
    logo_def(brand_id)
    $(document).ready(function() {

        $('#closeModal').on('click', function() {
            $('#filter11Modal').modal('toggle');
        });

        $.fn.dataTableExt.sErrMode = "console";
        $.fn.DataTable.ext.pager.numbers_length = 15;
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();

        loadAjaxData();

        function loadAjaxData() {
            $.ajax({
                url: base_url + 'translation/get_transtations',
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
                    allRequestsData = data['allRequestsData'];
                    translationRequestsData = data['translationRequestsData'];
                    handsRequestsData = data['handsRequestsData'];
                    permissions = data['permission'];
                    swal.close();
                    // $('#exampleone').DataTable().ajax.reload();
                    createTables1(allRequestsData, permissions);
                    createTables2(translationRequestsData, permissions);
                    createTables3(handsRequestsData, permissions);
                    return
                },
                error: function(jqXHR, exception) {
                    swal.close();
                }
            });
        }

        function createTables1(allRequestsData, permissions) {

            bTable = $("#allRequests").DataTable({
                data: allRequestsData,
                serverSide: false,
                processing: true,

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
                responsive: false,
                bDeferRender: true,
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

                autoWidth: true,
                orderCellsTop: true,
                deferRender: false,
                columns: [{
                        data: null,
                        render: function(row) {
                            return '<a href="<?php echo base_url() ?>translation/TranslationJobs?t=' + btoa(row.id) + '" >Translation-' + row.id + '</a>'
                        }
                    },
                    {
                        data: 'subject',
                        className: 'text-wrap'
                    },
                    {
                        data: 'count'
                    },
                    {
                        data: 'tm'
                    },
                    {
                        data: 'delivery_date'
                    },
                    {
                        data: null,
                        render: function(row) {

                            if (row.status) {
                                switch (row.status) {
                                    case '0':
                                        return '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
                                        break;
                                    case '1':
                                        return '<span class="badge badge-danger p-2" style="background-color: #e8e806">Waiting Confirmation</span>';
                                        break;
                                    case '2':
                                        return '<span class="badge badge-danger p-2" style="background-color: #07b817">Running</span>';
                                        break;
                                    case '3':
                                        return '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">Closed</span>';
                                        break;
                                    case '4':
                                        return '<span class="badge badge-danger p-2" style="background-color: #FF5733">Cancelled</span>';
                                        break;
                                    case '5':
                                        return '<span class="badge badge-danger p-2" style="background-color: #6303A5">Update</span>';
                                        break;
                                    case '6':
                                        return '<span class="badge badge-danger p-2" style="background-color: #999">Not Started Yet</span>';
                                        break;
                                    case '7':
                                        return '<span class="badge badge-danger p-2" style="background-color: #999">Heads Up ( Waiting Response )</span>';
                                        break;
                                    case '8':
                                        return '<span class="badge badge-danger p-2" style="background-color: #e8e806">Heads Up ( Marked as Available )</span>';
                                        break;
                                    case '9':
                                        return '<span class="badge badge-danger p-2" style="background-color: #FF5733">Heads Up ( Marked as Not Available )</span>';
                                        break;
                                    default:
                                        return '';
                                        break;
                                }
                            } else {
                                return '';
                            }
                        }
                    },

                    {
                        data: 'user_name',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'null',
                        className: 'noExport noVis',
                        orderable: false,
                        render: function(data, type, row) {
                            var action_btn = '<div>';
                            if (permissions && permissions.edit == '1') {
                                action_btn += '<a href="<?php echo base_url() ?>translation/TranslationJobs?t=' + btoa(row.id) + '" class=""><i class="fa fa-eye"></i> View Jobs </a>';
                            }
                            action_btn += '</div>';
                            return action_btn
                        }
                    },
                    {
                        data: 'null',
                        className: 'noExport noVis',
                        orderable: false,
                        render: function(data, type, row) {
                            var action_btn = '<div>';
                            if (permissions && permissions.edit == '1') {
                                action_btn += '<a href="<?php echo base_url() ?>translation/viewRequest?t=' + btoa(row.id) + '" class=""><i class="fa fa-eye"></i> View Request </a>';
                            }
                            action_btn += '</div>';
                            return action_btn
                        }
                    }
                ],
                order: [
                    // [7, "asc"],
                    // [5, "asc"]
                ],
                initComplete: function() {
                    var allCount = (allRequestsData) ? allRequestsData.length : 0;
                    document.getElementById("total_rows").innerHTML = (allCount ?? 0);


                },
                buttons: [

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
                                title: 'Translation Requests List',
                                filename: 'Translation Requests List',
                                sheetName: 'Translation Requests List',
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
                                title: 'Translation Requests List',
                                filename: 'Translation Requests List',
                                charset: 'utf-8',
                                // orientation: 'landscape',
                                pageSize: 'LEGAL',
                                download: 'download',
                                exportOptions: {
                                    columns: ':visible',
                                    footer: false,
                                    header: false,
                                    columns: "thead th:not(.noExport)",
                                    modifier: {
                                        // page: 'current'

                                    },
                                },
                                customize: function(doc) {
                                    var colCount = new Array();
                                    var length = $('#user_data tbody tr:first-child td').length;

                                    $('#user_data').find('tbody tr:first-child td').each(function() {
                                        if ($(this).attr('colspan')) {
                                            for (var i = 1; i <= $(this).attr('colspan'); $i++) {
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
                                title: 'Translation Requests List',
                                filename: 'Translation Requests List',
                                exportOptions: {
                                    columns: ':visible',
                                    orientation: 'landscape',
                                    columns: "thead th:not(.noExport)",
                                    modifier: {
                                        page: 'current'

                                    },
                                },

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
                        onOpen: () => {
                            Swal.showLoading()
                        }
                    });
                } else {
                    swal.close();
                }
            });
        }

        /////// datatable 2 
        function createTables2(translationRequestsData, permissions) {

            tTable = $("#translationRequests").DataTable({
                data: translationRequestsData,
                serverSide: false,
                processing: true,

                bDestroy: true,
                paging: true,
                select: false,
                searching: false,
                dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'C>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                pagingType: "full_numbers",
                scrollX: true,
                scrollY: "50vh",
                scrollCollapse: true,
                pageResize: true,
                autoWidth: false,
                responsive: false,
                bDeferRender: true,
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
                columnDefs: [{
                    targets: [7, 8, 9],
                    className: 'text-wrap'
                }],
                columns: [{
                        data: 'user_name',
                    },
                    {
                        data: null,
                        render: function(row) {
                            var action_btn = '<div>';
                            if (permissions && permissions.add == '1') {
                                action_btn += '<a  href="<?php echo base_url() ?>translation/saveRequest?t=' + btoa(row.id) + '">Translation-' + row.id + '</a>';
                            } else {
                                action_btn += 'Translation-' + row.id;
                            }
                            action_btn += '</div>';
                            return action_btn;

                            // return '<a href="<?php echo base_url() ?>translation/TranslationJobs?t=' + btoa(row.id) + '" >Translation-' + row.id + '</a>'
                        }
                    },
                    {
                        data: 'ttask_type'
                    },
                    {
                        data: 'count'
                    },
                    {
                        data: 'ttunit'
                    },
                    {
                        data: 'subject'
                    },
                    {
                        data: 'start_date'
                    },
                    {
                        data: 'delivery_date'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: null,
                        className: 'noExport',
                        orderable: false,
                        render: function(data, type, row) {
                            var action_btn = '<div>';
                            if (permissions && permissions.add == '1') {
                                action_btn += '<a  href="<?php echo base_url() ?>translation/saveRequest?t=' + btoa(row.id) + '"><i class="fa fa-eye "></i> View Task</a>';
                            }
                            action_btn += '</div>';
                            return action_btn;
                        }
                    }
                ],

                initComplete: function() {
                    var allCount1 = (translationRequestsData) ? translationRequestsData.length : 0;
                    document.getElementById("total_rows1").innerHTML = (allCount1 ?? 0);
                },
            })
        }

        /////// datatable 3
        function createTables3(handsRequestsData, permissions) {

            tTable = $("#handsRequests").DataTable({
                data: handsRequestsData,
                serverSide: false,
                processing: true,

                bDestroy: true,
                paging: true,
                select: false,
                searching: false,
                dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'C>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                pagingType: "full_numbers",
                scrollX: true,
                scrollY: "50vh",
                scrollCollapse: true,
                pageResize: true,
                autoWidth: false,
                responsive: false,
                bDeferRender: true,
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
                columnDefs: [{
                    targets: [6, 7, 8],
                    className: 'text-wrap'
                }],
                columns: [{
                        data: 'user_name',
                    },
                    {
                        data: null,
                        render: function(row) {
                            var action_btn = '<div>';
                            if (permissions && permissions.add == '1') {
                                action_btn += '<a  href="<?php echo base_url() ?>translation/saveRequestPlan?t=' + btoa(row.id) + '">Translation-' + row.id + '</a>';
                            } else {
                                action_btn += 'Translation-' + row.id;
                            }
                            action_btn += '</div>';
                            return action_btn;
                        }
                    },
                    {
                        data: 'task_type'
                    },
                    {
                        data: 'count'
                    },
                    {
                        data: 'unit'
                    },
                    {
                        data: 'subject'
                    },
                    {
                        data: 'start_date'
                    },
                    {
                        data: 'delivery_date'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: null,
                        className: 'noExport',
                        orderable: false,
                        render: function(data, type, row) {
                            var action_btn = '<div>';
                            if (permissions && permissions.add == '1') {
                                action_btn += '<a  href="<?php echo base_url() ?>translation/saveRequestPlan?t=' + btoa(row.id) + '"><i class="fa fa-eye "></i> View Task</a>';
                            }
                            action_btn += '</div>';
                            return action_btn;
                        }
                    }
                ],

                initComplete: function() {
                    var allCount2 = (handsRequestsData) ? handsRequestsData.length : 0;
                    document.getElementById("total_rows2").innerHTML = (allCount2 ?? 0);
                },
            })
        }
        //////////////////////////////
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust().scroller.measure();;
        });

        //////////////////////////////
        $('#search').on('click', function(e) {
            e.preventDefault();
            loadAjaxData();
            $('#filter11Modal').modal('toggle');
        });
        //////////////////////////////
    });
</script>