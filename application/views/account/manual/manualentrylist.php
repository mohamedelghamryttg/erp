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
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <?php if (isset($_SERVER['HTTP_REFERER'])): ?>
        <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
    <?php else: ?>
        <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
    <?php endif; ?>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Manual Entry Transaction</h3>
                </div>

                <form class="form" id="poList" action="<?php echo base_url() ?>account/ManualEntryList" method="post"
                    enctype="multipart/form-data">
                    <input type='hidden' name='current_page' value='<?= $current_page ?>' />
                    <div class="card-body">
                        <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
                        <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role form_date"
                                style="text-align: initial;">From
                                Date</label>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <input type="text" class="input-group date_sheet form-control" name="from_date"
                                    id="from_date" value="<?= $_SESSION['from_date'] ?? '' ?>">
                            </div>

                            <label class="col-lg-2 col-form-label col-md-3 col-sm-3" for="role to_date"
                                style="text-align: initial;">To
                                Date</label>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <input type="text" class="date_sheet form-control" name="to_date" id="to_date"
                                    value="<?= $_SESSION['to_date'] ?? '' ?>">
                            </div>
                            <div class="col-lg1 col-md-1 col-sm-1 " style="margin: auto;">
                                <div class="dropdown dropdown-inline">
                                    <button type="button" class="btn btn-primary btn-icon btn-sm" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        style="border-color: #ffff;background-color: white;">
                                        <i class="ki ki-bold-menu"
                                            style="font-size: 2.3rem;color: #F64060;background-color: #FFFF;border-color: white;">
                                        </i>
                                    </button>

                                    <div class="dropdown-menu ">
                                        <button class="dropdown-item" id="today" onclick="changeValue('today')"
                                            type="button">Today</button>
                                        <button class="dropdown-item" id="month" onclick="changeValue('month')"
                                            type="button">This
                                            Month</button>
                                        <button class="dropdown-item" id="year" onclick="changeValue('year')"
                                            type="button">This
                                            Year</button>
                                        <button class="dropdown-divider"></button>
                                        <button class="dropdown-item" id="fyear" onclick="changeValue('fyear')"
                                            type="button">Financial
                                            Year</button>
                                        <button class="dropdown-item" id="fyear1" onclick="changeValue('fyear1')"
                                            type="button">First
                                            Quarter</button>
                                        <button class="dropdown-item" id="fyear2" onclick="changeValue('fyear2')"
                                            type="button">Secand
                                            Quarter</button>
                                        <button class="dropdown-item" id="fyear3" onclick="changeValue('fyear3')"
                                            type="button">Theard
                                            Quarter</button>
                                        <button class="dropdown-item" id="fyear4" onclick="changeValue('fyear4')"
                                            type="button">Forth
                                            Quarter</button>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 control-label" for="role ser">Serial Number</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="ser" id="ser"
                                    value="<?= $_SESSION['ser'] ?? '' ?>">
                            </div>
                            <label class="col-lg-2 control-label" for="role ser">Sort By</label>
                            <div class="col-lg-3" style="text-align: center;">
                                <select class="form-control" name="sort_by" id="sort_by" required>
                                    <option value="id" <?php if ($_SESSION['sort_by'] == "id") {
                                        echo "selected";
                                    } ?>>Sort By ID
                                    </option>
                                    <option value="ccode" <?php if ($_SESSION['sort_by'] == "ccode") {
                                        echo "selected";
                                    } ?>>Sort By
                                        Serial</option>
                                    <option value="doc_no" <?php if ($_SESSION['sort_by'] == "doc_no") {
                                        echo "selected";
                                    } ?>>Sort By
                                        Doc Num</option>
                                    <option value="date" <?php if ($_SESSION['sort_by'] == "date") {
                                        echo "selected";
                                    } ?>>Sort By
                                        Date</option>
                                    <option value="tot_deb" <?php if ($_SESSION['sort_by'] == "tot_deb") {
                                        echo 'selected="selected"';
                                    } ?>>Sort
                                        By Amount</option>
                                    <option value="currency_id" <?php if ($_SESSION['sort_by'] == "currency_id") {
                                        echo "selected";
                                    } ?>>Sort By Currency</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12" style="text-align: center;">
                                <button class="btn btn-primary" name="search" type="submit">Search</button>
                                <!-- <a href="<?= base_url() ?>account/ManualEntryList" class="btn btn-warning">(x)
                                    Clear
                                    Filter</a> -->
                                <button class="btn btn-warning" name="clear_filter" id="clear_filter" type="text">Clear
                                    Filter</button>

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
                    <h3 class="card-label">
                        Manual Entry List
                    </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <?php if ($permission->add == 1): ?>
                        <a href="<?= base_url() ?>account/addManualEntry" class="btn btn-primary font-weight-bolder">
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
                        </span>Add New Manual Entry Note</a>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serial</th>
                            <th>Doc Number</th>
                            <!-- <th>Account Name</th> -->
                            <th>Date</th>
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
                        <?php $i = $current_page; ?>
                        <?php foreach ($manual_entries->result() as $row): ?>
                            <?php $i++; ?>
                            <tr>
                                <td>
                                    <?= $i ?>
                                </td>
                                <td>
                                    <?php if ($permission->edit == 1): ?>
                                        <a href="<?php echo base_url() ?>account/editManualEntry?c=<?= $current_page; ?>&t=<?php echo base64_encode($row->id); ?>"
                                            class="">
                                            <?= $row->ccode ?>
                                        </a>
                                    <?php else: ?>
                                        <?= $row->ccode ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($permission->edit == 1): ?>
                                        <a href="<?php echo base_url() ?>account/editManualEntry?c=<?= $current_page; ?>&t=<?php echo base64_encode($row->id); ?>"
                                            class="">
                                            <?= $row->doc_no ?>
                                        </a>
                                    <?php else: ?>
                                        <?= $row->doc_no ?>
                                    <?php endif; ?>
                                </td>
                                <!-- <td>
                                    <?php //$this->AccountModel->getByID('account_chart', $row->account_id) 
                                        ?>
                                </td> -->
                                <td>
                                    <span id="cdate">
                                        <?= date("d/m/Y", strtotime($row->date)) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $row->tot_deb ?>
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
                                        <a href="<?php echo base_url() ?>account/editManualEntry?c=<?= $current_page; ?>&t=<?php echo base64_encode($row->id); ?>"
                                            class="">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                <td>
                                    <?php if ($permission->delete == 1): ?>
                                        <a href="<?php echo base_url() ?>account/deleteManualEntry/<?php echo $row->id; ?>"
                                            title="delete" class=""
                                            onclick="return confirm('Are you sure you want to delete this Manual Entry ?');">
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
    $('#clear_filter').click(function () {
        document.getElementById("from_date").value = "";
        document.getElementById("to_date").value = "";
        document.getElementById("ser").value = "";
        document.getElementById("sort_by").value = "id";
    })
    function changeValue(o) {

        switch (o) {
            case 'today':
                var starDay = moment().format('YYYY-MM-DD');
                $('#from_date').val(starDay);
                $('#to_date').val(starDay);

                break;
            case 'month':
                var startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
                var endOfMonth = moment().endOf('month').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'year':
                var startOfMonth = moment().startOf('year').format('YYYY-MM-DD');
                var endOfMonth = moment().endOf('year').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear':
                var startOfMonth = $('#vs_date1').val();
                var endOfMonth = $('#vs_date2').val();

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear1':
                var startOfMonth = moment().quarter(1).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(1).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
                break;
            case 'fyear2':
                var startOfMonth = moment().quarter(2).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(2).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear3':
                var startOfMonth = moment().quarter(3).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(3).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            case 'fyear4':
                var startOfMonth = moment().quarter(4).startOf('quarter').format('YYYY-MM-DD');
                var endOfMonth = moment().quarter(4).endOf('quarter').format('YYYY-MM-DD');

                $('#from_date').val(startOfMonth);
                $('#to_date').val(endOfMonth);
                break;
            default:
                break;
        }
        return
    }

</script>