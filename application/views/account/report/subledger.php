<div class="container-fluid">
    <!-- <div class="content d-flex flex-column flex-column" id="kt_content" style="padding:0;"> -->
    <div class="d-flex flex-column">
        <!--begin::Entry-->
        <div class="d-flex flex-column">
            <input type="hidden" value="<?= $vs_date1 ?>" id="vs_date1">
            <input type="hidden" value="<?= $vs_date2 ?>" id="vs_date2">
            <!--begin::Container-->


            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact" style="text-align: center;padding-top: 20px;">
                <div class="card-title" style="margin-bottom: auto;">

                    <h1><u><span>Account Subledger</span></u></h1>
                </div>


                <div class="card-body" style="padding-bottom :0;">
                    <div id="search_condation">
                        <form class="form" id="form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role form_date" style="text-align: initial;">From
                                    Date</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <input type="text" class="input-group date_sheet form-control" name="from_date" id="from_date" required value="<?= $vs_date1 ?>">
                                </div>

                                <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role to_date" style="text-align: initial;">To
                                    Date</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <input type="text" class="date_sheet form-control" name="to_date" id="to_date" required value="<?= $vs_date2 ?>">
                                </div>
                                <div class="col-lg1 col-md-1 col-sm-1 " style="margin: auto;">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-color: #ffff;background-color: white;">
                                            <i class="ki ki-bold-menu" style="font-size: 2.3rem;color: #F64060;background-color: #FFFF;border-color: white;">
                                            </i>
                                        </button>

                                        <div class="dropdown-menu ">
                                            <button class="dropdown-item" id="today" onclick="changeValue('today')" type="button">Today</button>
                                            <button class="dropdown-item" id="month" onclick="changeValue('month')" type="button">This
                                                Month</button>
                                            <button class="dropdown-item" id="year" onclick="changeValue('year')" type="button">This
                                                Year</button>
                                            <button class="dropdown-divider"></button>
                                            <button class="dropdown-item" id="fyear" onclick="changeValue('fyear')" type="button">Financial
                                                Year</button>
                                            <button class="dropdown-item" id="fyear1" onclick="changeValue('fyear1')" type="button">First
                                                Quarter</button>
                                            <button class="dropdown-item" id="fyear2" onclick="changeValue('fyear2')" type="button">Secand
                                                Quarter</button>
                                            <button class="dropdown-item" id="fyear3" onclick="changeValue('fyear3')" type="button">Theard
                                                Quarter</button>
                                            <button class="dropdown-item" id="fyear4" onclick="changeValue('fyear4')" type="button">Forth
                                                Quarter</button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role currency_id" style="text-align: initial;">Currency</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <select class="form-control" name="currency_id" id="currency_id" required>
                                        <option disabled="disabled" selected="selected" value="">--
                                            Select
                                            Currency --
                                        </option>
                                        <?= $this->admin_model->selectCurrency($currency_id) ?>
                                    </select>
                                </div>
                                <label class="col-lg-3 col-form-label col-md-3 col-sm-3" for="role currency_type" style="text-align: initial;">Currency Type</label>
                                <div class="col-lg-3 col-md-3 col-sm-4">
                                    <select class="form-control" name="currency_type" id="currency_type" required>
                                        <option value="1">Currency Transaction
                                        </option>
                                        <option selected="selected" value="2">Currency Evaluation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label col-md-3 col-sm-2" for="role currency_id" style="text-align: initial;">Currency</label>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <select name="account_id" class="form-control m-b" id="account_id">
                                        <option disabled="disabled" selected="selected" value="">--
                                            Select
                                            Account --
                                        </option>
                                        <?= $this->AccountModel->select_chart_sub($brand) ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer" style="padding: 12px 0;">
                        <div class=" row">
                            <div class="col-lg-2 col-md-2 col-sm-4">

                                <button class="btn btn-primary btn-block" name="run" id="run" type="text">Run</button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <button class="btn btn-warning btn-block" name="clear" id="clear" type="text">
                                    Clear
                                    Filter</button>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <button class="btn btn-secondary btn-block" onclick="var e2 = document.getElementById('accountfilter'); e2.action='<?= base_url() ?>account/exportaccount'; e2.submit();" name="export" type="text">
                                    Export To
                                    Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card-body py-0 px-0">
                <div class="card-title">
                    <div id="account_name" style="text-align: left;"></div>
                </div>

                <table id="acc_data" class="table table-striped row-bordered display nowrap table-hover ">
                    <!-- <thead>
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap">Type</th>
                            <th class="text-nowrap">Transaction</th>
                            <th class="text-nowrap">Serial</th>
                            <th class="text-nowrap">Doc. No</th>
                            <th class="text-nowrap">Date</th>

                            <th class="text-nowrap">Debit</th>
                            <th class="text-nowrap">Credit</th>
                            <th class="text-nowrap">Debit Balance</th>
                            <th class="text-nowrap">Credit Balance</th>
                            <th class="text-nowrap">Trans. Currency</th>
                            <th class="text-nowrap">Rate</th>
                           
                            <th class="text-nowrap">Describtion</th>

                        </tr>
                    </thead>
                    <tbody id="rep_body">



                    </tbody> -->
                </table>

            </div>
        </div>
        </section>
        <nav class="text-center">
            <?= $this->pagination->create_links() ?>
        </nav>
        <!--end::Card-->
    </div>
</div>

<script>
    var account_data
    $(document).ready(function() {


        // $('#acc_data').DataTable();

        // function biuld_rep(account_data) {
        bTable = $("#acc_data").DataTable({
            processing: true,
            retrieve: true,
            paging: true,
            searching: false,
            responsive: true,
            info: true,
            pageLength: 10,
            fixedHeader: true,
            scrollY: 500,
            scrollX: true,
            deferRender: true,
            scrollCollapse: true,
            dom: 'r<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            // select: {
            //     info: true,
            //     style: 'single',
            //     selector: 'td:nth-child(1),td:nth-child(2)'
            // },
            ajax: {
                url: "<?= base_url() . "accountReport/subledger_calc" ?>",
                type: "POST",
                dataType: 'json',
                async: true,
                data: {
                    filter_data: function() {
                        return $('#form').serialize();
                    }
                },
                // beforeSend: function() {
                //     $('#loading').show();
                // },
                // success: function(data) {
                //     $('#loading').hide();
                // },
                // error: function(jqXHR, exception) {
                //     $('#loading').hide();
                // },
                dataSrc: 'trns_ledger'
            },
            // language: {
            //     "decimal": "",
            //     "emptyTable": "No data available in table",
            //     "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            //     "infoEmpty": "Showing 0 to 0 of 0 entries",
            //     "infoFiltered": "(filtered from _MAX_ total entries)",
            //     "infoPostFix": "",
            //     "thousands": ",",
            //     "lengthMenu": "Show _MENU_ entries",
            //     "loadingRecords": "Loading...",
            //     "processing": "",
            //     "search": "Search:",
            //     "zeroRecords": "No matching records found",

            // },
            language: {
                infoEmpty: "My Custom Message On Empty Table"
            },
            columns: [{
                    'data': 'id',

                }, {
                    'data': 'data2',
                },
                {
                    'data': 'data1'
                }
            ],
            order: [

            ],
            // columnDefs: [{
            //     render: function(data, type, full, meta) {
            //         return "<div class='text-wrap holes'>" + data + "</div>";
            //     },
            //     targets: 1
            // }, {
            //     render: function(data, type, full, meta) {
            //         return "<div class='text-wrap holes'>" + data + "</div>";
            //     },
            //     targets: 2
            // }, {
            //     target: 1,
            //     visible: false
            // }]
        });




    })
</script>