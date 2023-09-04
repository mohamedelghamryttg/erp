<?php if ($this->session->flashdata('true')): ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong>
                <?= $this->session->flashdata('true') ?>
            </strong></span>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong>
                <?= $this->session->flashdata('error') ?>
            </strong></span>
    </div>
<?php endif; ?>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Cash In Transaction</h3>
                </div>

                <form class="form" id="poList" action="<?php echo base_url() ?>account/cashintrnlist" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
                    <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
                    <div class="card-body">
                        <div class="form-group row">

                            <label class="col-lg-2 control-label" for="role cash_id">Cash</label>
                            <div class="col-lg-3">
                                <select name='cash_id' class='form-control m-b' id="cash_id">
                                    <option value="" selected="">-- Select Cash --</option>
                                    <?= $this->AccountModel->selectPaymentCombo('payment_method', $cash_id, $brand, '1'); ?>
                                </select>
                            </div>

                            <label id="acc_type" class="col-lg-2 col-form-label">Revenue</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="trn_id" id="trn_id">
                                    <option value="" selected=''>-- Select Revenue --</option>
                                    <?= $this->AccountModel->Allrevenue($brand, $trn_id, $parent_id); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label" for="role ser">Serial Number</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="ser" id="ser" value="<?= $ser ?>">
                            </div>

                            <label id="acc_type" class="col-lg-2 col-form-label text-right" for="role ccode">Document
                                Number</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="ccode" id="ccode" value="<?= $ccode ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label col-sm-12" for="role cdate">Date
                                Ranges</label>
                            <div class="col-lg-3 col-md-9 col-sm-12">

                                <div class='input-group' id='kt_daterangepicker_6'>
                                    <input type='text' class="form-control" placeholder="Select date range"
                                        name="cdaterange" id="cdaterange" />

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button type="submit" name="search" class="btn btn-success mr-2">Search</button>
                                    <a href="<?= base_url() ?>account/cashintrnlist" class="btn btn-warning">(x)
                                        Clear
                                        Filter</a>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <!--end::Card-->
        <!-- end search form -->

        <!--begin::Card-->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Cash In List </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <?php if ($permission->add == 1): ?>
                        <a href="<?= base_url() ?>account/addCashinTrn" class="btn btn-primary font-weight-bolder">
                        <?php endif; ?>
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path
                                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Add New Cash In Note</a>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Serial</th>
                            <th>Doc Number</th>
                            <th>Date</th>
                            <th>Cash</th>
                            <th>Revenue</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Rate</th>
                            <th>Notes</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($cash_trn->result() as $row): ?>
                            <?php $i++; ?>
                            <tr>
                                <td>
                                    <?= $i ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>account/editCashinTrn?t=<?php echo base64_encode($row->id); ?>"
                                        class="">
                                        <?= $row->ccode ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <a href="<?php echo base_url() ?>account/editCashinTrn?t=<?php echo base64_encode($row->id); ?>"
                                            class=""><?= $row->doc_no; ?> </a>
                                    </a>
                                </td>
                                <td>
                                    <span id="cdate">
                                        <?= date("d/m/Y", strtotime($row->date)) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $this->AccountModel->getByID('payment_method', $row->cash_id); ?>
                                </td>
                                <td>
                                    <?= $this->AccountModel->getByID('account_chart', $row->trn_id) ?>
                                </td>
                                <td>
                                    <?= $row->amount ?>
                                </td>
                                <td>
                                    <?= $this->admin_model->getCurrency($row->currency_id) ?>
                                </td>
                                <td>
                                    <?= $row->rate ?>
                                </td>
                                <td>
                                    <?= $row->rem ?>
                                </td>
                                <td>
                                    <?= $this->admin_model->getAdmin($row->created_by); ?>
                                </td>
                                <td>
                                    <?= $row->created_at ?>
                                </td>

                                <td>
                                    <?php if ($permission->edit == 1): ?>
                                        <a href="<?php echo base_url() ?>account/editCashinTrn?t=<?php echo base64_encode($row->id); ?>"
                                            class="">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                <td>
                                    <?php if ($permission->delete == 1): ?>
                                        <a href="<?php echo base_url() ?>account/deleteCashinTrn/<?php echo $row->id; ?>"
                                            title="delete" class=""
                                            onclick="return confirm('Are you sure you want to delete this Cash In Transaction ?');">
                                            <i class="fa fa-times text-danger text"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <?= $this->pagination->create_links() ?>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<script>
    $(document).ready(function () {
        var startDate;
        var endDate;

        KTBootstrapDaterangepicker.init();

    })
    var KTBootstrapDaterangepicker = function () {
        var demos = function () {
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
            }, function (start, end, label) {
                $('#kt_daterangepicker_6 .form-control').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                startDate = start;
                endDate = end;
            });
        }
        return {
            init: function () {
                demos();
            }
        };
    }();
</script>