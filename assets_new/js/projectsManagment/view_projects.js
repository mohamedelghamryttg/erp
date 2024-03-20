var base_url = $('#base').val();
let projectsTable;
let permissions;
var projectData;
var samData;
var json;
var logoName;

var brand_id = $('#brand_id').val()
// import logoName from "postimg.js"

$(document).ready(function (e) {

    $.fn.dataTableExt.sErrMode = "console";
    var permissions
    projectsTable = $('#user_data').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        destroy: true,
        paging: true,
        select: false,
        searching: false,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        pageLength: 10,
        pagingType: "full_numbers",
        scrollX: true,
        scrollY: "60vh",
        scrollCollapse: true,
        pageResize: true,
        responsive: false,

        rowReorder: false,
        orderMulti: true,
        fixedHeader: true,

        autoWidth: false,
        orderCellsTop: true,
        deferRender: true,
        stateSave: false,
        dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
            "<'row'<'col-sm-12'frt>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            lengthMenu: "_MENU_ Rows per page",
            info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
            paginate: {
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>',
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>'
            },
        },
        'ajax': {

            url: base_url + 'projectManagment/findall',
            type: 'POST',
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

            dataSrc: function (json) {
                permissions = json.permissions
                swal.close();
                return (json.data);
                // }
            }

        }, columnDefs: [{
            targets: [0, 1, 5, 12],
            orderable: false,
            className: 'noExport noVis'
        },
        {
            targets: [0],
            width: 1
        },

        ],
        createdRow: function (row, data, dataIndex) {
            $('td:eq(4)', row).css('min-width', '300px');
            $('td:eq(1)', row).css('min-width', '30px');
        },
        buttons: [

            {
                text: 'Add New Project',
                className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase',
                action: function (e, dt, node, config) {
                    if (permissions != null && permissions.add == '1') {
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
                className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase sam_data_sel',
                action: function (e, dt, node, config) {
                    $('#filter21Modal').modal('show')
                }
            },
            {
                extend: 'collection',
                text: 'Export',
                buttons: [{
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: 'Excelbtn',
                    action: function (e, dt, node, config) {
                        // $.ajax({
                        //     url: base_url + 'accounting/exportvpoStatus',
                        //     type: 'post',
                        //     // data: dt.ajax.params(),
                        //     data: {
                        //         filter_data: function() {
                        //             return $('#searchform').serialize();
                        //         }
                        //     },
                        //     dataType: 'json',
                        //     success: function(returnedData) {
                        //         console.log(returnedData);
                        //     },



                        $.ajax({
                            url: base_url + 'projectManagment/exportProjects',
                            type: "POST",
                            destroy: true,
                            data: dt.ajax.params(),
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
                                // location.href = base_url + 'projectManagment/exportProjects',
                                swal.close();
                                return
                            },
                            error: function (jqXHR, exception) {
                                console.log(jqXHR.responseText)
                                swal.close();
                            }
                        });
                    },
                    //     extend: 'excelHtml5',
                    //     text: '<i class="far fa-file-excel"></i>',
                    //     titleAttr: 'Excel',
                    //     autoFilter: true,
                    //     title: 'Projects List',
                    //     filename: 'Projects List',
                    //     sheetName: 'Projects List',
                    //     exportOptions: {
                    //         columns: "thead th:not(.noExport)",
                    //         extension: 'xlsx',
                    //         modifier: {
                    //             // page: 'current'
                    //         }

                    //     },
                    //     excelStyles: {
                    //         template: "blue_medium"
                    //     },
                    //     init: function (api, node, config) {
                    //         $(node).removeClass('btn-secondary')
                    //     }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'PDF',
                    title: 'Projects List',
                    filename: 'Projects List',
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
                            // page: 'current'

                        },
                    },
                    customize: function (doc) {
                        var colCount = new Array();
                        var length = $('#user_data tbody tr:first-child td').length;

                        $('#user_data').find('tbody tr:first-child td').each(function () {
                            if ($(this).attr('colspan')) {
                                for (var i = 1; i <= $(this).attr('colspan'); $i++) {
                                    colCount.push('*');
                                }
                            } else { colCount.push(parseFloat(100 / length) + '%'); }
                        });
                        doc.content[1].layout = "Borders";

                        const brand_name = $('#brand_name').val();
                        doc['header'] = (function () {
                            return {
                                columns: [
                                    {
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
                        doc['footer'] = (function (page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: ['Created on: ', { text: jsDate.toString() }]
                                    },
                                    {
                                        alignment: 'right',
                                        text: ['page ', { text: page.toString() }, ' of ', { text: pages.toString() }]
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
                    orientation: 'landscape',
                    title: 'Projects List',
                    autoPrint: false,
                    // footer: false,
                    // header: false,
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
    function sam_table() {

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
                //     // title: '#',
                //     data: null,

                // },
                // {
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
            // fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //     $('td:eq(0)', nRow).html('<span>' + (iDisplayIndexFull + 1) + '</span>');
            // },
            // initComplete: function () {
            //     var samCount = samData.length
            //     document.getElementById("samCount").innerHTML = samCount;

            // },
        });
    }
    $('#search').on('click', function (e) {
        e.preventDefault();
        // loadAjaxData();
        $('#filter11Modal').modal('toggle');
        $('#user_data').DataTable().ajax.reload();
    });
    $('.sam_data_sel').on('click', function (e) {
        $.ajax({
            url: base_url + 'projectManagment/get_sam_data',
            type: "POST",
            async: true,
            dataType: 'json',
            // data: {
            //     filter_data: function () {
            //         return $('#searchform').serialize();
            //     }
            // },
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
                // var data = JSON.parse(atob(data));

                samData = data['opportunity'];
                permissions = data['permission'];
                console.log(samData)
                swal.close();
                sam_table(samData, permissions);
                // createTables(projectData, samData);
                return
            },
            error: function (jqXHR, exception) {
                swal.close();
            }
        });



    });

    //////////////////////////////
})



