var base_url = $('#base').val();

var bTable;
let commissionData;
let permissions;

function openTab(evt, tabName) {
    console.log(tabName)
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";

    var table = $('#' + tabName).find('table').DataTable();
    table.columns.adjust().draw();
};

$(document).ready(function () {
    $.fn.dataTableExt.sErrMode = "console";
    $.fn.DataTable.ext.pager.numbers_length = 15;
    openTab(event, 'Tab 1');
    let year = $('#Year').val();
    let month = $('#month').val();
    loadAjaxData();

    // table2.buttons().container().insertAfter('#example2');
    function loadAjaxData() {
        var calcid = $('#calcid').val()
        var calcBrandid = $('#calcBrandid').val()
        $.ajax({
            url: base_url + 'commission/commissionCalc',
            type: "POST",
            async: true,
            dataType: 'json',
            data: {
                'calcid': calcid,
                'calcBrandid': calcBrandid
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
                var data = data;
                commissionData = data['jobData'];
                permissions = data['permission'];

                swal.close();
                createTables(commissionData, permissions);
                return
            },
            error: function (jqXHR, exception) {
                commissionData = array();
                permissions = array();
                swal.close();
            }
        });
    }

    function createTables(commissionData, permissions) {

        bTable = $("#kt_datatable2").DataTable({
            data: commissionData,

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

            },
            responsive: {
                details: {
                    type: 'column',
                    target: 0
                }
            },
            order: [1, 'desc'],
            autoWidth: true,
            orderCellsTop: true,
            deferRender: false,

            columns: [{
                data: null,
                className: 'noExport'
            },
            {
                data: 'pm_name'
            },
            {
                data: 'region_name'
            },
            {
                data: 'months',
            },
            {
                data: 'years',
            },
            {
                data: 'revenue_local',
            },
            {
                data: 'cost',
            }, {
                data: 'profit',
            }, {
                data: 'commission',
            },
            ],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).html('<span>' + (iDisplayIndexFull + 1) + '</span>');
            },
            order: [],
            buttons: [
                {
                    text: 'Search Conditions',
                    className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        $('#filter11Modal').modal('show')
                    }
                },
                {
                    text: 'Retrieve',
                    className: 'btn btn-secondary btn-sm text-center font-monospace  fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        if (permissions && permissions.add == '1') {
                            window.location.href = "<?= base_url() ?>admin/addPermission";
                        }
                    }
                },
                {
                    text: 'Calculate',
                    className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase Calculate',
                    action: function (e, dt, node, config) {
                        if (permissions && permissions.add == '1') {
                            return calc_comm();
                        }
                    }
                },
                {
                    text: 'Confirm',
                    className: 'btn btn-dark btn-sm text-center font-monospace  fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        if (permissions && permissions.add == '1') {
                            window.location.href = "<?= base_url() ?>admin/addPermission";
                        }
                    }
                },
                {
                    text: 'Delete',
                    className: 'btn btn-warning btn-sm text-center font-monospace  fw-bold text-uppercase',
                    action: function (e, dt, node, config) {
                        if (permissions && permissions.add == '1') {
                            window.location.href = "<?= base_url() ?>admin/addPermission";
                        }
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
                        title: 'PM Commission List',
                        filename: 'PM Commission List',
                        sheetName: 'PM Commission List',
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
    ////////////////////////

    function calc_comm() {
        var calcid = $('#calcid').val()
        var calcBrandid = $('#calcBrandid').val()

        bTable.destroy();
        loadAjaxData()
        // $.ajax({
        //     url: base_url + 'commission/commissionCalc',
        //     type: "POST",
        //     async: true,
        //     dataType: 'json',
        //     data: {
        //         'calcid': calcid,
        //         'calcBrandid': calcBrandid
        //     },
        //     beforeSend: function () {

        //         Swal.fire({
        //             title: 'Please Wait !',
        //             text: 'Data Calculation ....',
        //             allowEscapeKey: false,
        //             allowOutsideClick: false,
        //             onOpen: function () {
        //                 Swal.showLoading()
        //             }
        //         });

        //     },
        //     success: function (data) {
        //         var data = data;

        //         if (data) {
        //             swal.close();
        //             bTable.ajax.reload();
        //             return true
        //         } else {
        //             alert('Commission Setting Not Found');
        //             return false;
        //         }
        //         swal.close();
        //     },
        //     error: function (jqXHR, exception) {
        //         swal.close();
        //         alert('Commission Setting Not Found');
        //         return false;
        //     }
        // });

    }
    //////////////////////////////
    $('#search').on('click', function (e) {
        e.preventDefault();
        let searchYear = $('#searchYear').val()
        let searchMonth = $('#searchMonth').val()
        let searchBrabd = $('#searchBrabd').val()

        if (searchYear == '' || searchMonth == '' || searchBrabd == '') {
            alert('You must fill out all required fields to Search');
            return false;
        }

        $.ajax({
            url: base_url + 'commission/get_rule',
            type: "POST",
            async: true,
            // dataType: 'json',
            data: {
                'searchYear': searchYear,
                'searchMonth': searchMonth,
                'searchBrabd': searchBrabd
            },
            success: function (data) {
                var data = JSON.parse(data);
                commission_setting = data['commission_setting'];
                if (commission_setting) {
                    $('#calcid').val((commission_setting.id ?? ''));
                    $('#calcYear').val((commission_setting.year ?? ''));

                    $('#calcMonthvalue').val((commission_setting.month_value ?? ''));
                    $('#calcMonth').val((commission_setting.month_name ?? ''));

                    $('#calcBrandid').val((commission_setting.brand_id ?? ''));
                    $('#calcBrandname').val((commission_setting.brand_name ?? ''));

                    $('#calcId').val((commission_setting.id ?? ''));

                    $('#calcdate_from').val((commission_setting.date_from ?? ''));
                    $('#calcdate_to').val((commission_setting.date_to ?? ''));
                    return true
                } else {
                    alert('Commission Setting Not Found');
                    return false;
                }
            },
            error: function (jqXHR, exception) {
                alert('Commission Setting Not Found');
                return false;
            }
        });

        bTable.clear().draw();

        $('#filter11Modal').modal('toggle');
    });

})
