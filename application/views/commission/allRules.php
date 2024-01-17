<!--begin::Entry-->
<div class="d-flex flex-column-fluid py-5">
    <!--begin::Container-->
    <div class="container-fluid">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('true') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fas fa-times-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <!-- start search form card -->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">Search </h3>
            </div>

            <form class="form" id="Filter" action="<?php echo base_url() ?>commission" method="get">
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-1 col-form-label text-lg-right">Year:</label>
                        <div class="col-lg-3">
                            <select name="year" class="form-control m-b" id="Year">
                                <option value="">-- Select Year --</option>
                                <?= $this->accounting_model->selectYear($year ? $year : ''); ?>
                            </select>
                        </div>
                        <label class="col-lg-1 col-form-label text-lg-right">Month:</label>
                        <div class="col-lg-3">
                            <select name="month" class="form-control m-b" id="month">
                                <option value="">-- Select Month --</option>
                                <?= $this->accounting_model->selectMonth($month ? $month : ''); ?>
                            </select>
                        </div>
                        <label class="col-lg-1 col-form-label text-lg-right">Brand:</label>
                        <div class="col-lg-3">
                            <select name="brand" class="form-control m-b" id="brand">
                                <option value="">-- Select Brand --</option>
                                <?= $this->admin_model->selectBrand($brand ?? '') ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-success btn-sm" name="search" type="submit">Search</button>
                            <a href="<?= base_url() ?>commission/tickets" class="btn btn-danger btn-sm"><i class="la la-trash"></i>Clear Filter</a>
                            <button class="btn btn-warning btn-sm" onclick="var e2 = document.getElementById('Filter'); e2.action='<?= base_url() ?>commission/exportTickets'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export
                                To Excel</button>

                        </div>
                    </div>

            </form>
        </div>
    </div>

    <!-- end search form -->

    <!--begin::Card-->
    <div class="card">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Rules| <span class="text-dark-50 font-weight-bold" style="font-size: 14px !important;">
                        <?= $total_rows ?> Total
                    </span></h3>
            </div>
            <div class="card-toolbar">
                <?php if ($permission->add == 1) { ?>
                    <a href="<?= base_url() ?>commission/addRule" class="btn btn-dark btn-sm font-weight-bolder">
                        <i class="fa fa-pen"></i>Add New Rule</a>
                    <button type="button" class="btn btn-dark btn-sm font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-copy"></i>Copy Rule</button>
                    <!-- Modal-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Copy All Data </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="form" id="Filter" action="<?php echo base_url() ?>commission/copyRule" method="post">
                                        <h5 class="font-size-lg text-dark font-weight-bold mb-6 ml-5">Copy From :</h5>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right">Year <span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="year_old" class="form-control" id="year_old" required>
                                                    <option disabled="disabled" selected="selected" value="">-- Select Year --
                                                    </option>
                                                    <?= $this->accounting_model->selectYear() ?>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label text-right">Month <span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="month_old" class="form-control" id="month_old" required>
                                                    <option disabled="disabled" selected="selected" value="">-- Select Month --
                                                    </option>
                                                    <?= $this->accounting_model->selectMonth() ?>
                                                </select>
                                            </div>
                                        </div>
                                        <h5 class="font-size-lg text-dark font-weight-bold mb-6 ml-5">Copy To :</h5>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right">Year <span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="year_new" class="form-control" id="year_new" required>
                                                    <option disabled="disabled" selected="selected" value="">-- Select Year --
                                                    </option>
                                                    <?= $this->accounting_model->selectYear() ?>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label text-right">Month <span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="month_new" class="form-control" id="month_new" required>
                                                    <option disabled="disabled" selected="selected" value="">-- Select Month --
                                                    </option>
                                                    <?= $this->accounting_model->selectMonth() ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right">Date From <span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <input name="date_from" type="text" class="form-control date_sheet" readonly="readonly" placeholder="Select date" required="" />
                                            </div>

                                            <label class="col-lg-2 col-form-label text-right">Date To <span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                                <input name="date_to" type="text" class="form-control date_sheet" readonly="readonly" placeholder="Select date" required="" />

                                            </div>
                                        </div>
                                        <hr />
                                        <div class="text-right">
                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom">

                <thead>
                    <tr>
                        <th no-sort>ID</th>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Date from</th>
                        <th>date to</th>
                        <th>Brand</th>
                        <th>Region</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rules->result() as $row) { ?>
                        <tr>
                            <td>
                                <?= $row->id ?>
                            </td>
                            <td>
                                <?= $row->year ?>
                            </td>
                            <td>
                                <?= $this->accounting_model->getMonth($row->month) ?>
                            </td>
                            <td>
                                <?= $row->date_from ?>
                            </td>
                            <td>
                                <?= $row->date_to ?>
                            </td>

                            <td><span class="label label-square label-default"><?= $this->admin_model->getBrand($row->brand_id) ?></span></td>

                            <td><span class="label label-square label-default"><?= $this->admin_model->getRegion($row->region_id) ?></span></td>
                            <td>
                                <?php if ($permission->edit == 1) { ?>
                                    <a href="<?= base_url() . 'commission/editRule?t=' . base64_encode($row->id); ?>" class="btn btn-sm btn-clean btn-icon mr-2">
                                        <span class="svg-icon svg-icon-primary svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Design\Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1" />
                                                </g>
                                            </svg><!--end::Svg Icon--></span>
                                    </a>
                                <?php }
                                if ($permission->delete == 1) { ?>
                                    <a href="<?= base_url() . 'commission/deleteRule?t=' . base64_encode($row->id); ?>" class="btn btn-sm btn-clean btn-icon mr-2" onclick="return confirm('Are you sure you want to delete this rule?');">
                                        <span class="svg-icon svg-icon-primary svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\General\Trash.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg><!--end::Svg Icon--></span>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <!--end: Datatable-->

        </div>
    </div>
</div>
</div>
<!--end::Card-->
<style>
    .label {
        width: auto;
        padding: 10px;
    }

    .datepicker {
        z-index: 1100;
    }
</style>