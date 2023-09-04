<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('true') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('message') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <style>
            .display-node-name {
                position: relative;
                right: -13px;
                bottom: 13px;
                padding-top: 28px;
                padding-bottom: 10px;
                border-left: 1px solid #adadad;
                border-bottom: 1px solid #adadad;
                /* top: -25px; */
            }

            .pl-5 {
                padding: 12px 8px;
            }

            /* .table td {
                padding: 0.75rem 5px;
            } */
        </style>

        <div class="card card-custom gutter-b example example-compact">

            <?php
            if (isset($_REQUEST['account_name'])) {
                $accountName = $_REQUEST['account_name'];
            } else {
                $accountName = "";
            }
            ?>
            <form class="form" id="accountfilter" action="<?php echo base_url() ?>account/accountList" method="get"
                enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-lg-right">Search Account Name</label>
                        <div class="col-lg-3">
                            <input class="form-control" type="text" name="account_name" value="<?= $account_name ?>"
                                autocomplete="off">
                        </div>
                        <div class="col-lg-7 text-lg-right">
                            <button class="btn btn-primary" name="search" type="submit">Search</button>

                            <a href="<?= base_url() ?>account/accountList" class="btn btn-warning"><i
                                    class="la la-trash"></i>Clear
                                Filter</a>

                            <button class="btn btn-secondary"
                                onclick="var e2 = document.getElementById('accountfilter'); e2.action='<?= base_url() ?>account/exportaccount'; e2.submit();"
                                name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i>
                                Export To
                                Excel</button>
                            <a href="#myModal" data-toggle="modal" class="btn btn-success">Import
                                From
                                Excel</a>

                        </div>

                    </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Account of Chart</h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <?php if ($permission->add == 1): ?>
                    <a href="<?= base_url() ?>account/addAccount" class="btn btn-primary font-weight-bolder">

                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path
                                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Add New Account</a>
                    <!--end::Button-->
                <?php endif; ?>
            </div>
            <input type="hidden" name="brand" value=<?= $brand ?>>
        </div>
        <form class="form" action="<?php echo base_url() ?>account/editaccount" method="post"
            enctype="multipart/form-data">
            <div class="card-body" style="padding: 0;">
                <!--begin: Datatable-->
                <table class="table " id="kt_datatable2">
                    <!-- table-separate table-head-custom table-checkable table-hover ordering -->
                    <!-- <table class="table table-separate table-head-custom table-checkable table-hover nowrap" -->
                    <!-- id="kt_datatable_horizontal_scroll"> -->
                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>A Code</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Closing</th>
                            <th>Type</th>
                            <th>Currency</th>
                            <th>Third Party</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $i == $offset ?>

                        <?php foreach ($chart as $row): ?>

                            <tr>

                                <td>
                                    <?= $row->id ?>

                                </td>
                                <td><a href="<?= base_url() ?>account/editaccount?t=<?php echo
                                      base64_encode($row->id); ?>"><?=
                                       $row->ccode; ?></a>
                                </td>
                                <td><a href="<?= base_url() ?>account/editaccount?t=<?php echo
                                      base64_encode($row->id); ?>"><?=
                                       $row->acode; ?></a>
                                </td>
                                <td class="pl-5 text-nowrap">
                                    <?php if ($row->level == 0 || $row->level == 1): ?>
                                        <span>
                                            <span style="position: relative;">

                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                    viewBox="0 0 512 512" xml:space="preserve"
                                                    class="icon text-muted icon-xs shift-left"
                                                    style="height: 12px;width: 12px;">
                                                    <path
                                                        d="M201.6 136c-6.1 0-11.8-2.8-15.6-7.5l-20-25c-3.8-4.7-9.5-7.5-15.6-7.5H0v352.1C0 477 25.7 511 60 511h392c33 0 60-27 60-60V136H201.6zM480 449c0 16.5-13.5 30-30 30H62.9c-8.4 0-16.4-3.5-22.1-9.7l-.9-1c-5.1-5.5-7.9-12.8-7.9-20.3V261h448v188zM32 229V128h112.6l16.4 20.5c9.9 12.4 24.7 19.5 40.6 19.5H480v61H32z">
                                                    </path>
                                                </svg>
                                            </span>

                                        </span>
                                        <span class="align-middle btn-link cursor-pointer ">
                                            <a href="<?= base_url() ?>account/editaccount?t=<?php echo
                                                  base64_encode($row->id); ?>" style="color:blue"> &nbsp;
                                                <?= $row->name; ?></a>
                                        </span>
                                    <?php else: ?>
                                        <?php if ($row->acc == 1): ?>
                                            <span>
                                                <span>
                                                    <?php if ($i == $offset): ?>
                                                        <span class="display-node-name" style="padding-top: 0;">
                                                        <?php else: ?>
                                                            <span class="display-node-name">
                                                            <?php endif; ?>
                                                            <?php for ($ii = 0; $ii <= $row->level; $ii++): ?>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php endfor; ?>
                                                            &nbsp;
                                                        </span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </span>
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0"
                                                        viewBox="0 0 512 512" xml:space="preserve"
                                                        class="icon text-muted icon-xs shift-left"
                                                        style="height: 12px;width: 12px;">
                                                        <path
                                                            d="M201.6 136c-6.1 0-11.8-2.8-15.6-7.5l-20-25c-3.8-4.7-9.5-7.5-15.6-7.5H0v352.1C0 477 25.7 511 60 511h392c33 0 60-27 60-60V136H201.6zM480 449c0 16.5-13.5 30-30 30H62.9c-8.4 0-16.4-3.5-22.1-9.7l-.9-1c-5.1-5.5-7.9-12.8-7.9-20.3V261h448v188zM32 229V128h112.6l16.4 20.5c9.9 12.4 24.7 19.5 40.6 19.5H480v61H32z">
                                                        </path>
                                                    </svg> <span class="align-middle btn-link cursor-pointer ">
                                                        <a href="<?= base_url() ?>account/editaccount?t=<?php echo
                                                              base64_encode($row->id); ?>" style="color:green">
                                                            &nbsp;<?= $row->name; ?></a>
                                                    </span>
                                                </span>

                                            <?php else: ?>
                                                <span>
                                                    <?php if ($i == $offset): ?>
                                                        <span class="display-node-name" style="padding-top: 0;">
                                                        <?php else: ?>
                                                            <span class="display-node-name">
                                                            <?php endif; ?>
                                                            <?php for ($ii = 0; $ii <= $row->level; $ii++): ?>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php endfor; ?>
                                                            &nbsp;
                                                        </span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="align-left btn-link cursor-pointer ">
                                                            <a href="<?= base_url() ?>account/editaccount?t=<?php echo
                                                                  base64_encode($row->id); ?>">
                                                                &nbsp;
                                                                <?= $row->name; ?></a>
                                                        </span>
                                                    </span>

                                                <?php endif; ?>
                                            <?php endif; ?>

                                </td>

                                <td class="text-nowrap">

                                    <?= $row->parent; ?>


                                </td>
                                <td class="text-nowrap">
                                    <?= $row->acc_close; ?>
                                </td>
                                <td class="text-nowrap">
                                    <?= $row->acc_type; ?>
                                </td>
                                <td class="text-nowrap">
                                    <?= $row->currency; ?>
                                </td>
                                <td>
                                    <?php if ($row->acc_thrd_party == 1): ?>
                                        <input type="checkbox" checked disabled>
                                    <?php else: ?>
                                        <input type="checkbox" disabled>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>account/editaccount?t=<?php echo
                                           base64_encode($row->id); ?>" class="">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>account/accountDelete?t=<?php echo
                                           base64_encode($row->id); ?>" title="delete" class=""
                                        onclick="return confirm('Are you sure you want to delete this Account ?');">
                                        <i class="fa fa-times text-danger text"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <?= $this->pagination->create_links() ?>
                </div>
            </div>
        </form>
    </div>

</div>
</div>

<!-- form of adding sam and brand to account-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Select Excel File To Import</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="import_form" name="formdata" enctype="multipart/form-data">
                    <div class="form-group">
                        <p><label>Select Excel File</label>
                            <input type="file" name="file" id="file" required accept=".xls,.xlsx" />
                        </p>
                    </div>
                    <input type="submit" name="import" value="Import" class="btn btn-success" />
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#import_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>account/importaccount",
                method: "POST",
                data: new FormData(formdata),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    alert(data);
                    $("#import_form").modal('hide');
                }
            })
        });

        $("#kt_datatable_horizontal_scroll").DataTable({
            "scrollX": true
        });
        $("#kt_datatable_both_scrolls").DataTable({
            "scrollY": 800,
            "scrollX": true
        });
        // var datatable = $('#kt_datatable2').Datatable({
        //     ordaring: false,

        // });
    });
</script>