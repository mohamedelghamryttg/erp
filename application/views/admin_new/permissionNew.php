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
        if (!empty($_REQUEST['searchId'])) {
          $searchId = $_REQUEST['searchId'];
        } else {
          $searchId = "";
        }
        if (!empty($_REQUEST['searchScreen'])) {
          $searchScreen = $_REQUEST['searchScreen'];
        } else {
          $searchScreen = "";
        }
        if (!empty($_REQUEST['searchRole'])) {
          $searchRole = $_REQUEST['searchRole'];
        } else {
          $searchRole = "";
        }
        ?>
      </div>

      <div class="modal-body  px-0">
        <div class="col-12">

          <form class="cmxform form-horizontal" id="searchform" method="post" enctype="multipart/form-data">
            <div class="card-body  py-3 my-0">
              <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role searchId" style="margin-top: auto;margin-bottom: auto;">id</label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" name="searchId" value="<?= $searchId ?>">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role searchScreen" style="margin-top: auto;margin-bottom: auto;">Screen</label>
                <div class="col-lg-4">
                  <select name="searchScreen" class="form-control m-b" id="searchScreen" style="width: 100% Iimportant;">
                    <option value="" selected="selected">-- Select Screen --</option>
                    <?= $this->admin_model->selectScreen($searchScreen) ?>
                  </select>
                </div>
                <label class="col-lg-2 control-label text-lg-right" for="role searchRole" style="margin-top: auto;margin-bottom: auto;">Role</label>
                <div class="col-lg-4">
                  <select name="searchRole" class="form-control m-b" id="searchRole" style="width: 100% Iimportant;">
                    <option value="" selected="">-- Select Role --</option>
                    <?= $this->admin_model->selectRole($searchRole) ?>
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
        <a href="<?= base_url() ?>admin/permission" class="btn btn-warning">(x) Clear Filter</a>
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
          <h3 class="card-label">Permission</h3>
        </div>
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-striped table-separate table-head-custom table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Screen</th>
              <th>Role</th>
              <th>Menu Order</th>
              <th>Follow-Up</th>
              <th>Can View</th>
              <th>Can Add</th>
              <th>Can Edit</th>
              <th>Can Delete</th>
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
  var bTable;
  let permissionsData;
  let permissions;
  $(document).ready(function() {
    $.fn.dataTableExt.sErrMode = "console";
    $.fn.DataTable.ext.pager.numbers_length = 15;

    loadAjaxData();

    function loadAjaxData() {
      $.ajax({
        url: base_url + 'admin/get_permission',
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
          permissionsData = data['permissions'];
          permissions = data['permission'];
          swal.close();
          createTables(permissionsData, permissions);
          return
        },
        error: function(jqXHR, exception) {
          swal.close();
        }
      });
    }

    function createTables(permissionsData, permissions) {

      bTable = $("#kt_datatable2").DataTable({
        data: permissionsData,

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
            data: 'screen'
          },
          {
            data: 'role',
          },
          {
            data: 'menu_order',
          },
          {
            data: null,
            render: function(row) {
              if (row.follow == 1) {
                return 'Team';
              } else if (row.follow == 2) {
                return 'Team Leader';
              } else {
                return "";
              }

            }

          },
          {
            data: null,
            render: function(row) {
              if (row.view == 2) {
                return "View Only Assigned";
              } else if (row.view == 1) {
                return "View ALL";
              } else {
                return "No";
              }
            }
          },
          {
            data: null,
            render: function(row) {
              if (row.add == 1) {
                return "Yes";
              } else {
                return "No";
              }
            }
          },
          {
            data: null,
            render: function(row) {
              if (row.edit == 1) {
                return "Yes";
              } else {
                return "No";
              }
            }
          },
          {
            data: null,
            render: function(row) {
              if (row.delete == 1) {
                return "Yes";
              } else {
                return "No";
              }
            }
          },
          {
            data: 'null',
            className: 'noExport noVis',
            orderable: false,
            render: function(data, type, row) {
              var action_btn = '<div>';
              if (permissions && permissions.edit == '1') {
                // action_btn += '<a class="btn btn-dark mr-2" href="<?php echo base_url() ?>admin/editPermission?t=' + btoa(row.id) + '"><i class="fa fa-pen "></i> Edit</a>';
                action_btn += '<a href="<?php echo base_url() ?>admin/editPermission/' + btoa(row.id) + '" ><i class="fa fa-edit text"></i> Edit</a>'
              }
              action_btn += '</div>';
              return action_btn
            }
          },
          {
            data: '',
            className: 'noExport noVis dt-center',
            orderable: false,
            render: function(data, type, row) {
              var action_btn = '<div>';
              if (permissions && permissions.delete == '1') {
                var conf_text = 'Are you sure you want to delete this Permission ? ';
                // '<a href = "url_to_delete" onclick = "return confirm('Are you sure you want to delete this item?');" > Delete < /a>''
                // action_btn += '<a href="<?php echo base_url() ?>admin/deletePermission/' + btoa(row.id) + ' title="delete" class="delete-btn" onclick="return confirm("' + 'conf_text' + '");"> <i class = "fa fa-times text-danger text"> </i> Delete </a>';
                action_btn += `<a class='btn text-danger delete' id='delete'><i class = "fa fa-trash text"> </i>delete</a>`;
              }

              action_btn += '</div>';
              return action_btn
            }
          }
        ],
        order: [],
        buttons: [

          {
            text: 'Add New Permission',
            className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase',
            action: function(e, dt, node, config) {
              if (permissions && permissions.add == '1') {
                window.location.href = "<?= base_url() ?>admin/addPermission";
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
    //////////////////////////////
    $('#kt_datatable2').on('click', '#delete', function(e) {
      var dataRow = $(this).parents('tr');
      var rowId = dataRow.find('td:eq(0)')[0].innerHTML; // Find the mongodb record ID.  Note, for the purpose of this exercise the ID as been added to the row, but would not be done in reality. 
      e.stopPropagation();
      Swal.fire({
        title: 'Are you sure you want to delete this Permission ? ',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false,
        closeOnCancel: false
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?php echo base_url() ?>admin/deletePermission/",
            type: 'POST',
            dataType: 'json',
            data: {
              "id": btoa(rowId)
            },

            success: function(data) {
              if (data.records == 1) {
                // var i = row_index.parentNode.parentNode.rowIndex;
                // document.getElementById("table1").deleteRow(i);
                bTable.row(dataRow).remove().draw();
                Swal.fire(
                  'Deleted!',
                  'this Permission has been deleted.',
                  'success'
                )

              } else {
                Swal.fire(
                  'Error!',
                  'Data Error to delet.',
                  'error'
                )
              }
            }
          });
        }
      });

    });
  })
</script>