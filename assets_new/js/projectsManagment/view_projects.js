var base_url = $('#base').val();
var datatable;
let permissions;

$(document).ready(function (e) {
    // $('#user_data thead th')
    //   .clone(true)
    //   .addClass('filters')
    //   .appendTo('#user_data thead');

    // $('#user_data thead tr:eq(1) th').each(function() {
    //   var title = $(this).text();
    //   $(this).html('<input type="text" placeholder="Search ' + title + '" class="column_search" />');
    // });
    //*************************/


    $.fn.DataTable.ext.pager.numbers_length = 15;
    $.fn.dataTable.ext.errMode = 'throw';
    /////////////
    $.extend($.fn.dataTable.defaults, {
        processing: true,
        // rownames: true,
        bDestroy: true,
        paging: true,
        scrollX: false,
        retrieve: true,
        stateSave: false,
        autoWidth: true,
        select: false,
        selecttype: 'single',
        sort: true,
        Info: true,
        pageLength: 10,
        fixedHeader: true,
        fixedHeader: {
            headerOffset: 50
        },
        searching: false,
        pagingType: 'full_numbers',
        scrollCollapse: true,
        scrollY: 500,
        colReorder: true,
        ///////////////
        displayStart: 0,
        orderClasses: true,
        orderCellsTop: true,
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
        ],
        language: {
            oPaginate: {
                sNext: '<i class="ki ki-bold-arrow-next icon-xs"></i>',
                sPrevious: '<i class="ki ki-bold-arrow-back icon-xs"></i>',
                sFirst: '<i class="ki ki-bold-double-arrow-back icon-xs"></i>',
                sLast: '<i class="ki ki-bold-double-arrow-next icon-xs"></i>'
            },
            aria: {
                sortAscending: ": activate to sort column ascending",
                sortDescending: ": activate to sort column descending"
            },
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary"></i><span class="sr-only ">Loading...</span> '
        },


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
                text: 'Search Projects',
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
                    action: function (e, dt, node, config) {
                        setTimeout(function () {
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                        }, 50);
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
                }
            }
        ],
        // },

    });

    //////////////////////////////
    $('#filter21Modal').on('shown.bs.modal', function (e) {
        $.fn.dataTable.tables({
            visible: true,
            api: true
        }).columns.adjust();
    });
    ////////////////////////////////////// samTable
    var samTable = $('#samTable').DataTable({
        ajax: {
            url: base_url + 'projectManagment/findallO',
            dataSrc: 'opportunity',
        },
        // responsive: true,
        columns: [{
            title: '#',
            data: null,

        },
        {
            title: 'ID',
            data: 'id'
        },
        {
            title: 'PROJECT NAME',
            data: 'project_name',
            // className: 'text-wrap-datatable',
        },
        {
            title: 'Client',
            data: 'customer_name'
        },
        {
            title: 'Assigned Date',
            data: 'assigned_at',
            className: 'text-nowrap-datatable',

        },
        {
            title: 'SAM',
            data: 'sam_name',

        },
        {
            title: 'SAVE',
            data: 'null',

            // className: 'noExport noVis',
            orderable: false,
            render: function (data, type, row) {
                return '<a class="btn btn-outline-primary" href="' + base_url + 'projects/saveProject?t=' + btoa(row.id) + '" style="display:flex;"><i class="fa fa-search"></i> View </a>';
            }
        }
        ],
        responsive: true,
        scrollY: 250,
        scrollX: false,
        order: [1, 'desc'],
        autoWidth: true,
        pageLength: 5,
        dom: "<'row'<'col-sm-12 col-md-5'i>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'><'col-sm-12 col-md-7'p>>",

        renderer: 'bootstrap',
        columnDefs: [{
            defaultContent: "-",
            targets: "_all",
        }],
        // row number
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(0)', nRow).html('<span>' + (iDisplayIndexFull + 1) + '</span>');
        }
    });
    samTable.on('xhr', function () {
        var json = samTable.ajax.json();
        var samCount = json.opportunity.length

        document.getElementById("samCount").innerHTML = samCount;
    });
    ////////////////////////////////////// user_data
    var datatable = $('#user_data').DataTable({
        ajax: {
            url: base_url + 'projectManagment/findall',
            type: "POST",
            dataType: 'json',
            async: true,
            data: {
                filter_data: function () {
                    return $('#searchform').serialize();
                },
            },
            dataSrc: 'projects',
        },
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        order: [1, 'desc'],
        columns: [{
            title: '#',
            // data: null,
            // className: 'pl-10'
            // className: 'noExport noVis',
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
                if (row.allclosed != row.closedstat) {
                    if (row.total_hours > 0) {
                        progress = row.interval_hours * 100 / row.total_hours;
                        progress = progress >= 100 ? 100 : parseInt(progress);
                    } else {
                        progress = 0;
                    }
                    progress = parseInt(progress);
                    if (progress) {
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
            title: 'STATUS',
            data: 'null',
            render: function (data, type, row) {
                if (row.allclosed == row.closedstat) {
                    return 'Closed';
                } else {
                    return 'Running';
                }
            }
        },
        {
            title: 'OPPORTUNITY NO',
            data: 'opportunity'
        },
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
                if (row.allclosed == row.closedstat) {
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
                    if (row.allclosed == row.closedstat) {
                        action_btn += '<a class="btn btn-dark font-weight-bold mr-2 disabled" href="' + base_url + 'projectManagment/editProject?t=' + btoa(row.id) + '"><i class="fa fa-pen "></i> Edit</a>';
                    } else {
                        action_btn += '<a class="btn btn-dark font-weight-bold mr-2" href="' + base_url + 'projectManagment/editProject?t=' + btoa(row.id) + '"><i class="fa fa-pen "></i> Edit</a>';
                    }
                }
                if (permissions && permissions.delete == '1') {
                    if (row.allclosed == row.closedstat) {
                        action_btn += '<a class="btn btn-danger font-weight-bold mr-2 disabled" id="del_fun" title="delete" href="javascript:void(0)" data-id=' + row.id + '><i class="la la-trash"></i> Delete</a>';
                    } else {
                        action_btn += '<a class="btn btn-danger font-weight-bold mr-2 " id="del_fun" title="delete" href="javascript:void(0)" data-id=' + row.id + '><i class="la la-trash"></i> Delete</a>';
                    }
                }
                action_btn += '</div>';
                return action_btn
            }
        }

            // ,
            // {
            //   title: 'DELETE',
            //   data: 'null',
            //   className: 'noExport noVis ',
            //   orderable: false,
            //   render: function(data, type, row) {
            //     // let link = "<?php echo base_url() ?>projectManagment/deleteProject?t=" + btoa(row.id)
            //     // let messg = "Are you sure you want to delete this Project ?"
            //     if (permissions && permissions.delete == '1' && row.status == 0) {
            //       return '<a class="btn btn-danger" id="del_fun" title="delete" href="javascript:void(0)" data-id=' + row.id + '><i class="la la-trash"></i> Delete</a>'
            //     } else {
            //       return '<div></div>'
            //     }
            //   }
            // }
        ],
        initComplete: function () {
            $('div.dataTables_length').addClass('demo');

        },
        dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        // dom: 'TC<"clear">lfrtipB',
        // renderer: 'bootstrap'
        columnDefs: [{
            defaultContent: "-",
            targets: "_all",


            className: 'dtr-control',
            orderable: false,
            targets: 0

        }]
    });
    datatable.on('xhr', function () {
        var json = datatable.ajax.json();
        permissions = json.permission;
        // alert(permissions.add)
        if (permissions.add != '1') {
            datatable.buttons('.addButtonClass').disable();
        }

        var allCount = json.projects.length
        var rowToCount = json.projects


        document.getElementById("allCount").innerHTML = allCount;
        document.getElementById("runningCount").innerHTML = rowToCount.reduce(function (a, b) {
            return (b.allclosed != b.closedstat) ? a + 1 : a;
        }, 0);
        document.getElementById("closedCount").innerHTML = rowToCount.reduce(function (a, b) {
            return (b.allclosed == b.closedstat) ? a + 1 : a;
        }, 0);
    });


    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    $('#search').on('click', function (e) {
        e.preventDefault();
        $('#filter11Modal').modal('toggle');
        datatable.ajax.reload();

    });


    $('#user_data tbody').on('click', '#del_fun', function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        const url = base_url + "projectManagment/deleteProject?t=" + btoa(id);

        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to delete this Project ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                location.assign(url);
                e.preventDefault();
                Swal.fire({
                    title: "Deleted!",
                    text: "this Project has been deleted.",
                    icon: "success"
                });
            }
        });

    });
    // $('#user_data tbody').on('click', 'tr td.dtr-control', function() {
    //   var tr = $(this).closest('tr');
    //   var row = datatable.row(tr);

    //   if (row.child.isShown()) {
    //     row.child.hide();
    //     tr.removeClass('shown');
    //   } else {
    //     //Below line does the trick :)
    //     if (datatable.row('.shown').length) {
    //       $('.details-control', table.row('.shown').node()).click();
    //     }
    //     row.child(format(row.data())).show();
    //     tr.addClass('shown');
    //   }
    // });
})
