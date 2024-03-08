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
        if (!empty($_REQUEST['searchGroup'])) {
          $searchGroup = $_REQUEST['searchGroup'];
        } else {
          $searchGroup = "";
        }
        if (!empty($_REQUEST['searchName'])) {
          $searchName = $_REQUEST['searchName'];
        } else {
          $searchName = "";
        }
        if (!empty($_REQUEST['searchUrl'])) {
          $searchUrl = $_REQUEST['searchUrl'];
        } else {
          $searchUrl = "";
        }
        if (!empty($_REQUEST['searchMenu'])) {
          $searchMenu = $_REQUEST['searchMenu'];
        } else {
          $searchMenu = "";
        }
        ?>
      </div>

      <div class="modal-body  px-0">
        <div class="col-12">

          <form class="cmxform form-horizontal" id="searchform" enctype="multipart/form-data">
            <div class="card-body  py-3 my-0">
              <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">Name</label>
                <div class="col-lg-4">
                  <input type="text" name="searchName" id="searchName" class="form-control" value="<?= $searchName ?>" />
                </div>

                <label class="col-lg-2 col-form-label text-right">Group</label>
                <div class="col-lg-4">
                  <select class="form-control" name="searchGroup" id="searchGroup" style="width:100%;">
                    <option selected="selected" value="" disabled="disabled">-- Select Group --</option>
                    <?= $this->admin_model->selectGroup($searchGroup) ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">URL</label>
                <div class="col-lg-4">
                  <input name="searchUrl" id="searchUrl" class="form-control" value="<?= $searchUrl ?>" />

                </div>

                <label class="col-lg-2 col-form-label text-right">Menu</label>
                <div class="col-lg-4">
                  <select name="searchMenu" class="form-control" id="searchMenu" style="width:100%;">
                    <option selected="selected" value="" disabled="disabled" <?php if ($searchMenu != 1 && $searchMenu != 0) {
                                                                                echo 'selected';
                                                                              } ?>>--Select Menu--</option>

                    <option value="1" <?php if ($searchMenu == 1) {
                                        echo 'selected';
                                      } ?>>1</option>

                    <option value="0" <?php if ($searchMenu == 0) {
                                        echo 'selected';
                                      } ?>>0</option>
                  </select>

                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
        <a href="<?= base_url() ?>admin/screens" class="btn btn-warning">(x) Clear Filter</a>
      </div>
    </div>
  </div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <div class="container-fluid">
    <!--begin::Card-->
    <div class="card">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Screens</h3>
        </div>
      </div>
    </div>
    <div class="card-body">
      <!--begin: Datatable-->
      <table class="table table-striped table-separate table-head-custom table-hover" id="kt_datatable2">
        <thead>
          <tr>
            <th>ID</th>
            <th>Groups</th>
            <th>Name</th>
            <th>URL</th>
            <th>Menue</th>
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

<script>
  var bTable;
  let screensData;
  let permissions;
  $(document).ready(function() {
    $.fn.dataTableExt.sErrMode = "console";
    $.fn.DataTable.ext.pager.numbers_length = 15;

    loadAjaxData();

    function loadAjaxData() {
      $.ajax({
        url: base_url + 'admin/get_screens',
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
          screensData = data['screens'];
          permissions = data['permission'];
          swal.close();
          createTables(screensData, permissions);
          return
        },
        error: function(jqXHR, exception) {
          swal.close();
        }
      });
    }

    function createTables(screensData, permissions) {

      bTable = $("#kt_datatable2").DataTable({
        data: screensData,

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
            data: 'id'
          },
          {
            data: 'group'
          },
          {
            data: 'name'
          },
          {
            data: 'url'
          },
          {
            data: 'menu'
          },

          {
            data: 'null',
            className: 'noExport noVis',
            orderable: false,
            render: function(data, type, row) {
              var action_btn = '<div>';
              if (permissions && permissions.edit == '1') {
                // action_btn += '<a class="btn btn-dark mr-2" href="<?php echo base_url() ?>admin/editPermission?t=' + btoa(row.id) + '"><i class="fa fa-pen "></i> Edit</a>';
                action_btn += '<a href="<?php echo base_url() ?>admin/editScreen/' + btoa(row.id) + '" class=""><i class="fa fa-pencil"></i> Edit</a>'
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
              if (permissions && permissions.delete == '1') {
                var conf_text = 'Are you sure you want to delete this Screen ? ';
                action_btn += '<a href="<?php echo base_url() ?>admin/deleteScreen/' + btoa(row.id) + ' title="delete" class="" onclick="return confirm("' + conf_text + '");"> <i class = "fa fa-times text-danger text"> </i> Delete </a>';
              }

              action_btn += '</div>';
              return action_btn
            }
          }
        ],
        order: [],
        buttons: [

          {
            text: 'Add New Screen',
            className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase',
            action: function(e, dt, node, config) {
              if (permissions && permissions.add == '1') {
                window.location.href = "<?= base_url() ?>admin/addScreen";
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
                title: 'Screens List',
                filename: 'Screens List',
                sheetName: 'Screens List',
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
            onOpen: () => {
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
    //////////////////////////////
  });
</script>