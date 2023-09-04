<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Account Overview</h3>

            </div>
            <div class="card-title">
                <input type="hidden" name="brand" value=<?= $brand ?>>
                <h3 class="card-title">
                    Brand :
                    <?= $this->admin_model->getbrand($this->brand) ?>
                </h3>

                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin::Tiles Widget 1-->
                                <div class="card card-custom gutter-b card-stretch" style=" border: 1px solid;">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <div class="card-title">
                                            <div class="card-label">
                                                <div class="font-weight-bolder">Monthly Sales Stats </div>
                                                <div class="font-weight-bolder" id="month_sales_amount"></div>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Invoices</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="table">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column px-0" style="position: relative;">
                                        <div id="chartContainer">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-4">
                                <!--begin::Tiles Widget 1-->
                                <div class="card card-custom gutter-b card-stretch" style=" border: 1px solid;">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <div class="card-title">
                                            <div class="card-label">
                                                <div class="font-weight-bolder">Receivables </div>
                                                <div class="font-weight-bolder" id="month_sales_amount"></div>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Current</th>
                                                            <th>Overdue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table1">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column px-0" style="position: relative;">
                                        <div id="chartContainer1">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-xl-4">
                                <!--begin::Tiles Widget 1-->
                                <div class="card card-custom gutter-b card-stretch" style=" border: 1px solid;">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <div class="card-title">
                                            <div class="card-label">
                                                <div class="font-weight-bolder">Payables</div>
                                                <div class="font-weight-bolder" id="month_sales_amount"></div>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Current</th>
                                                            <th>Overdue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table2">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column px-0" style="position: relative;">
                                        <div id="chartContainer2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-9 border-right">
                                <!--begin::Tiles Widget 1-->
                                <div class="card card-custom gutter-b card-stretch" style=" border: 1px solid;">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <div class="card-title">
                                            <div class="card-label">
                                                <div class="font-weight-bolder">Cash Flow</div>
                                                <div class="font-weight-bolder" id="month_sales_amount"></div>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Invoices</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="table3">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column px-0" style="position: relative;">
                                        <div id="chartContainer3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 text-right balance-container">
                                <div class="balance-row">
                                    <div class="cursor-pointer" data-ember-action="" data-ember-action-1488="1488">
                                        <div class="text-muted">Cash as on 01 Jan 2023</div>
                                        <div class="legend over-flow direction-ltr">EGP0.00</div>
                                    </div>
                                </div>
                                <div class="balance-row">
                                    <div>
                                        <div class="text-moneyin">Incoming</div>
                                        <div class="legend over-flow direction-ltr">EGP0.00</div>
                                    </div>
                                    <div class="signs"> + </div>
                                </div>
                                <div class="balance-row">
                                    <div>
                                        <div class="text-moneyout">Outgoing</div>
                                        <div class="legend over-flow direction-ltr">EGP0.00</div>
                                    </div>
                                    <div class="signs"> - </div>
                                </div>
                                <div class="balance-row">
                                    <div class="cursor-pointer" data-ember-action="" data-ember-action-1489="1489">
                                        <div class="text-open">Cash as on 31 Dec 2023</div>
                                        <div class="legend over-flow direction-ltr">EGP0.00</div>
                                    </div>
                                    <div class="signs"> = </div>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-xl-8">
                                <!--begin::Tiles Widget 1-->
                                <div class="card card-custom gutter-b card-stretch" style=" border: 1px solid;">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <div class="card-title">
                                            <div class="card-label">
                                                <div class="font-weight-bolder">Income and Expense</div>
                                                <div class="font-weight-bolder" id="month_sales_amount"></div>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Invoices</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="table4">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column px-0" style="position: relative;">
                                        <div id="chartContainer4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-xl-10">
                                <!--begin::Tiles Widget 1-->
                                <div class="card card-custom gutter-b card-stretch" style=" border: 1px solid;">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <div class="card-title">
                                            <div class="card-label">
                                                <div class="font-weight-bolder">Bank and Credit Cards</div>
                                                <div class="font-weight-bolder" id="month_sales_amount"></div>
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Invoices</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="table5">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column px-0" style="position: relative;">
                                        <div id="chartContainer5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>

                </div>




            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $.ajax({
            url: "<?php base_url() ?>month_sales_amount",
            type: "POST",
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            cache: false,
            success: function (data) {
                // alert(data.table_invoice[0]['year'])
                if (data != '') {
                    var trHTML = '';
                    var total_amount = 0;
                    for (var f = 0; f < data.table_invoice.length; f++) {
                        trHTML += '<tr>'
                        trHTML += '<td>'
                        trHTML += '<strong > ' + data.table_invoice[f]['year'] + '</strong >'
                        trHTML += '</td>'

                        trHTML += '<td>'
                        trHTML += '<span class="label label-success">' + data.table_invoice[f]['month'] + '</span>'
                        trHTML += '</td>'
                        trHTML += '<td> ' + data.table_invoice[f]['total_payment'] + '</td >'
                        trHTML += '</tr > ';
                        total_amount += parseFloat(data.table_invoice[f]['total_payment']);
                    }
                    trHTML += '<tr><td colspan="2">'
                    trHTML += '<span class="font-weight-bold text-success" >Total</span >'

                    trHTML += '<td>'
                    trHTML += '<strong > ' + total_amount + '</strong >'
                    trHTML += '</td ></tr>';
                    $('#table').html(trHTML);
                    chart(data);
                }


            },
            error: function (jqXHR, exception) {
                console.log(jqXHR.dataText);
            }
        });

        function chart(data) {
            // var data = JSON.stringify(data.table_invoice);
            //console.log(data)
            var a = Object.values(data.table_invoice).map(value => parseInt(value.month))
            console.log(a);
            var options = {
                chart: {
                    type: 'bar'
                },
                series: [
                    {
                        name: 'sales',
                        data: Object.values(data.table_invoice).map(value => parseFloat(value.total_payment))
                        //[30, 40, 35, 50, 49, 60, 70, 91, 125]
                    }
                ],
                xaxis: {
                    categories: Object.values(data.table_invoice).map(value => parseInt(value.month))
                    //[1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
                }
            }

            var chart = new ApexCharts(document.querySelector('#chartContainer'), options)
            chart.render()
        }

    });  
</script>