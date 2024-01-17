var base_url = $('#base').val();
let projectsTable;
let permissions;
var projectData;
var samData;
var json;

$(document).ready(function (e) {
    $.fn.dataTableExt.sErrMode = "console";
    $.fn.DataTable.ext.pager.numbers_length = 15;
    // $.fn.dataTable.ext.errMode = 'throw';
    loadAjaxData();
    function loadAjaxData() {
        $.ajax({
            url: base_url + 'projectManagment/findall',
            type: "POST",
            async: true,
            // dataType: 'json',
            data: {
                filter_data: function () {
                    return $('#searchform').serialize();
                }
            },
            beforeSend: function () {

                Swal.fire({
                    title: 'Please Wait !',
                    text: 'Data Loading ....',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    onOpen: function () {
                        Swal.showLoading()
                    }
                });

            },

            success: function (data) {
                var data = JSON.parse(atob(data));
                projectData = data['projects'];
                samData = data['opportunity'];
                permissions = data['permission'];
                swal.close();
                createTables(projectData, samData, permissions);
                return
            },
            error: function (jqXHR, exception) {
                swal.close();
            }
        });
    }
    function createTables(projectData, samData, permissions) {
        // console.log(samData);
        projectsTable = $('#user_data').DataTable({
            data: projectData,

            processing: true,
            serverSide: false,
            bDestroy: true,
            paging: true,
            select: false,
            searching: false,
            dom:
                "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
                "<'row'<'col-sm-12'ftr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'ip>>",
            // 'Bfrtip',
            // "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
            // "<'row'<'col-sm-12'tr>>" +
            // "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            pagingType: "full_numbers",
            scrollX: true,
            scrollY: "50vh",
            scrollCollapse: true,
            pageResize: true,
            responsive: true,
            // bProcessing: true,
            language: {
                lengthMenu: "_MENU_ Rows per page",
                info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                // sSearch: "_INPUT_",
                // sSearchPlaceholder: "Search table",
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

                // processing: '<i class="fas fa-asterisk fa-spin fa-6x fa-fw"></i> < br > PROCESSING < br > Please wait...',

            }, responsive: {
                details: {
                    type: 'column',
                    target: 0
                }
            },
            order: [1, 'desc'],
            autoWidth: true,
            orderCellsTop: true,
            deferRender: false,

            buttons: [

                {
                    text: 'Add New Project',
                    className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        if (permissions && permissions.add == '1') {
                            window.location.href = base_url + 'projectManagment/addProject';
                        }
                    }
                },
                {
                    text: 'Search Conditions',
                    className: 'btn btn-secondary btn-sm text-center font-monospace fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        $('#filter11Modal').modal('show')
                    }
                }, {
                    text: 'Projects From SAM',
                    className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        $('#filter21Modal').modal('show')
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
                        title: 'Projects List',
                        filename: 'Projects List',
                        sheetName: 'Projects List',
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
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary')
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        titleAttr: 'PDF',
                        title: 'Projects List',
                        filename: 'Projects List',

                        exportOptions: {
                            columns: ':visible',
                            footer: false,
                            header: false,
                            columns: "thead th:not(.noExport)",
                            modifier: {
                                page: 'current'

                            },
                        },

                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i>',
                        titleAttr: 'Print',
                        orientation: 'landscape',
                        autoPrint: false,
                        footer: false,
                        header: false,
                        download: 'download',
                        exportOptions: {
                            columns: ':visible',

                            columns: "thead th:not(.noExport)",
                        },
                        customize: function (win) {
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
                    columnText: function (dt, idx, title) {
                        return (idx + 1) + ': ' + title;
                    },
                }
            ],

            columnDefs: [{
                // targets: 0,
                // orderable: false,
                // defaultContent: "-",
                // targets: "_all",


                // className: 'dtr-control',
                // orderable: false,
                // targets: 0,
                // data: 0,
                // title: '<i class="fa fa-info-circle fa-lg" ></i>'
            }],
            columns: [
                {
                    data: null,
                    title: '<i class="fa fa-info-circle fa-lg"></i>',
                    className: 'noExport dtr-control',

                    defaultContent: '',
                    orderable: false

                },
                {
                    title: 'ID',
                    data: 'id'
                },
                {
                    title: 'PROJECT CODE',
                    data: 'code',
                    render: function (data, type, row) {
                        if (row.status == 0) {
                            return '<a href="' + base_url + 'ProjectManagment/projectJobs?t=' + btoa(row.id) + '">' + row.code +
                                '</a>';
                        } else {
                            return '<div></div>';
                        }
                    }
                },
                {
                    title: 'PROJECT NAME',
                    data: 'name',
                    className: 'text-wrap-datatable',
                },
                {
                    title: 'CLIENT',
                    data: 'customername',
                },

                {
                    title: 'PROGRESS',
                    data: 'null',
                    render: function (data, type, row, meta) {

                        var progress = 0;
                        progRow = '<div></div>';

                        var allc;
                        if (row.allclosed) {
                            allc = row.allclosed;
                        } else {
                            allc = 0;
                        }
                        var alls;
                        if (row.closedstat) {
                            alls = row.closedstat;
                        } else {
                            alls = 0;
                        }

                        if (allc != alls) {
                            if (row.total_hours > 0) {
                                progress = row.interval_hours * 100 / row.total_hours;
                                progress = progress >= 100 ? 100 : parseInt(progress);
                            } else {
                                progress = 0;
                            }
                            progress = parseInt(progress);
                            if (progress >= 0) {
                                progRow = '<div class = "progress border border-info" >'
                                if (progress > 100) {
                                    progRow += '<span style="position: absolute;margin: 6.5px 2.5%;color:#000"><span style="color:red">***</span></span>'
                                } else {
                                    progRow += '<span style="position: absolute;margin: 6.5px 2.5%;color:#000"><span style="color:#000">' + (100 - progress) + ' %</span></span>'
                                    switch (true) {
                                        case (progress <= 15):
                                            n_width = ((progress <= 85) ? (100 - progress) : 85);
                                            progRow += '<div class="progress-bar bg-success progress-bar-striped  progress-bar-animated" role ="progressbar" style="width:' + n_width + '%" value="' + progress + '" max = "100" ></div>'
                                            break;
                                        case (progress <= 35):
                                            n_width = ((progress <= 65) ? (100 - progress) : 65)
                                            progRow += '<div class="progress-bar bg-warning progress-bar-striped  progress-bar-animated" role="progressbar" style="width: ' + n_width + '%" value="' + progress + '" max="100"></div>'
                                            break;
                                        case (progress <= 100):
                                            n_width = ((progress < 100) ? (100 - progress) : 0)
                                            progRow += '<div class="progress-bar bg-primary progress-bar-striped  progress-bar-animated" role="progressbar" style="width:' + n_width + '%" value="' + progress + '" max="100"></div>'
                                            break;
                                        default:
                                            progRow += '<div class="progress-bar bg-primary progress-bar-striped  progress-bar-animated" role="progressbar" style="width:  0%" value=0  max="100">*</div>'
                                            break;
                                    }
                                }
                                progRow += '</div>'
                            }
                        }
                        return progRow;
                    },
                },
                {
                    title: 'OPPORTUNITY NO',
                    data: 'opportunity'
                },
                {
                    title: 'STATUS',
                    data: 'null',
                    render: function (data, type, row) {
                        if (row.allclosed == row.closedstat && row.closedstat != 0) {
                            return 'Closed';
                        } else {
                            return 'Running';
                        }
                    }
                },

                // {
                //     title: 'PO',
                //     data: 'po_number',
                // },
                {
                    title: 'PRODUCT LINE',
                    data: 'productline',
                },
                {
                    title: 'CREATE BY',
                    data: 'username'
                },
                {
                    title: 'CREATE AT',
                    data: 'created_at'
                },
                {
                    title: 'TICKETS',
                    data: 'null',
                    className: 'noExport',
                    orderable: false,
                    render: function (data, type, row) {
                        if (row.allclosed == row.closedstat && row.closedstat != 0) {
                            return '<a class="btn btn-outline-success disabled" href = "' + base_url + 'vendor/vmPmTicket?t=' + btoa(row.id) + '" ><i class="fa fa-eye "></i> View Tickets </a>';
                        } else {
                            return '<a class="btn btn-outline-success" href = "' + base_url + 'vendor/vmPmTicket?t=' + btoa(row.id) + '" ><i class="fa fa-eye "></i> View Tickets </a>';
                        }
                    }
                },
                {
                    title: 'ACTIONS',
                    data: 'null',
                    className: 'noExport noVis',
                    orderable: false,
                    render: function (data, type, row) {
                        var action_btn = '<div>';
                        if (permissions && permissions.edit == '1') {
                            if (row.allclosed == row.closedstat && row.closedstat != 0) {

                                action_btn += '<a class="btn btn-dark font-weight-bold mr-2" href="' + base_url + 'projectManagment/editProject?t=' + btoa(row.id) + '"><i class="fa fa-pen "></i> Edit</a>';
                            }
                        }
                        if (permissions && permissions.delete == '1') {
                            if (row.allclosed == row.closedstat && row.closedstat != 0) {
                                // action_btn += '<a class="btn btn-danger font-weight-bold mr-2 disabled" id="del_fun" title="delete" href="javascript:void(0)" data-id=' + row.id + '><i class="la la-trash"></i> Delete</a>';
                            } else {
                                action_btn += '<a class="btn btn-danger font-weight-bold mr-2 " id="del_fun" title="delete" href="javascript:void(0)" data-id=' + row.id + '><i class="la la-trash"></i> Delete</a>';
                            }
                        }
                        action_btn += '</div>';
                        return action_btn
                    }
                }
            ],
            initComplete: function () {

                // projectData, samData, permissions
                var allCount = (projectData) ? projectData.length : 0;
                var rowToCount = projectData;

                // console.log(json.projects)
                document.getElementById("allCount").innerHTML = allCount;
                document.getElementById("runningCount").innerHTML = Array.isArray(rowToCount) ? rowToCount.reduce(function (a, b) {
                    return ((b.allclosed != b.closedstat) || (b.allclosed == 0 && b.closedstat == 0)) ? a + 1 : a;
                }, 0) : 0;
                document.getElementById("closedCount").innerHTML = Array.isArray(rowToCount) ? rowToCount.reduce(function (a, b) {
                    return (b.allclosed == b.closedstat && b.closedstat != 0) ? a + 1 : a;
                }, 0) : 0;

            },
        }).on('buttons-processing', function (e, indicator) {
            if (indicator) {
                Swal.fire({
                    title: 'Please Wait !',
                    html: 'Descargar excel',// add html attribute if you want or remove
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
            }
            else {
                swal.close();
            }
        });

        ////////////////////////////////////// samTable
        samTable = new $('#samTable').DataTable({
            data: samData,

            processing: true,
            serverSide: false,
            bDestroy: true,
            paging: true,
            searching: false,
            dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            pagingType: "full_numbers",

            scrollY: 400,
            scrollX: true,
            scrollCollapse: true,
            // pageResize: true,
            pageLength: 5,

            order: [1, 'desc'],
            autoWidth: false,

            dom: "<'row'<'col-sm-12 col-md-5'i>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'><'col-sm-12 col-md-7'p>>",

            // renderer: 'bootstrap',
            language: {
                lengthMenu: "_MENU_ Rows per page",
                info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                paginate: {
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>'
                }
            },
            columnDefs: [{
                defaultContent: "-",
                targets: "_all",
            }],
            columns: [{
                // title: '#',
                data: null,

            },
            {
                // title: 'ID',
                data: 'id'
            },
            {
                // title: 'PROJECT NAME',
                data: 'project_name',
                className: 'text-wrap-datatable',
            },
            {
                // title: 'Client',
                data: 'customer_name',
                className: 'text-wrap-datatable',
            },
            {
                // title: 'Assigned Date',
                data: 'assigned_at',
                className: 'text-nowrap-datatable',

            },
            {
                // title: '',
                data: 'sam_name',

            },
            {
                // title: 'SAVE',
                data: 'null',
                orderable: false,
                render: function (data, type, row) {
                    return '<a class="btn btn-sm  py-1 btn-outline-primary " href="' + base_url + 'projects/saveProject?t=' + btoa(row.id) + '" style="font-size: 0.8em;"><i class="fas fa-search fa-sm" ></i> View </a>';
                }
            }
            ],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).html('<span>' + (iDisplayIndexFull + 1) + '</span>');
            },
            initComplete: function () {
                var samCount = samData.length
                document.getElementById("samCount").innerHTML = samCount;

            },
        });

    }
    //////////////////////////////
    $('#search').on('click', function (e) {
        e.preventDefault();
        loadAjaxData();
        $('#filter11Modal').modal('toggle');
    });
    //////////////////////////////
    $('#filter21Modal').on('shown.bs.modal', function (e) {
        $.fn.dataTable.tables({
            visible: true,
            api: true
        }).columns.adjust();
    });

    // Add filtering


})



