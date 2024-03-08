<!DOCTYPE>
<html>

<head>
    <style>
        @media print {
            table {
                font-size: smaller;
            }

            thead {
                display: table-header-group;
            }

            table {
                page-break-inside: auto;
                width: 75%;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

        table {
            border: 1px solid black;
            /*font-size:18px;*/
        }

        table td {
            /*border: 1px dashed black;*/
        }

        table th {
            /* border: 1px solid black;*/
        }

        .clr {
            background-color: #EEEEEE;
            text-align: center;
        }

        .clr1 {
            background-color: #FFFFCC;
            text-align: center;
        }

        p {
            line-height: .3;
        }

        .small {
            font-size: 11px;
        }

        .td {
            border: 1px dashed black;
            ;
            font-size: 10px;
        }

        .bold {
            border: 1px dashed black;
            ;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: center">
        <thead>
            <tr style="height:50px">
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>

                <th style="text-align: left;width: 30%;border:1px solid #fff;border-radius: 50%"><img src="<?= '@' . base64_encode(file_get_contents($image_src)) ?>" width=50 height=35></th>
                <th style="text-align: left;width: 33%"></th>
                <th style="text-align:left;width: 36%">
                    <h4 style="color: #750101;">The Translation Gate </h4>
                    <p style="font-size: 10px; ">Tax ID: 465-068-499 </p>
                    <p style="font-size: 10px;">Tax File No. : 5-01778-570 </p>
                    <p style="font-size: 10px;">Tax Office's: Joint-Stock companies Cairo</p>
                </th>
            </tr>
            <tr style="height:50px">
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr style="height:70px">
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="margin-top:20px">
                <td>
                    <table style="width: 100%;text-align: left;">
                        <tr>
                            <td class="td bold" style="width:40%;background-color:#e5b8b7;">Bill To:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="td bold">Company</td>
                            <td class="td"><?= $this->customer_model->getCustomer($invoice->customer) ?></td>
                        </tr>
                        <tr>
                            <td class="td bold">Address</td>
                            <td class="td"></td>
                        </tr>
                        <tr>
                            <td class="td bold">City</td>
                            <td class="td"></td>
                        </tr>
                        <tr>
                            <td class="td bold">Country</td>
                            <td class="td"><?= $this->admin_model->getCountry($lead->country) ?></td>
                        </tr>

                    </table>
                </td>
                <td></td>
                <td>
                    <table style="width: 100%;text-align: left;">
                        <tr>
                            <td class="td bold" style="width:40%">Inv. No:</td>
                            <td class="td"><?= $invoice->id ?></td>
                        </tr>
                        <tr>
                            <td class="td bold">Issue Date</td>
                            <td class="td"><?= $invoice->issue_date ?></td>
                        </tr>
                        <tr>
                            <td class="td bold">Due Date</td>
                            <td class="td"><?= date("Y-m-d", strtotime($invoice->created_at . " +" . $invoice->payment . " days")) ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="height:70px">
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table style="width: 100%;text-align: left;padding: 3px">
                        <thead>
                            <tr style="background-color:#e5b8b7;">
                                <th class="td bold">PO No.</th>
                                <th class="td bold">Job Name</th>
                                <th class="td bold">Service Type</th>
                                <th class="td bold">Source Language</th>
                                <th class="td bold">Target Language</th>
                                <th class="td bold">Count</th>
                                <th class="td bold">Unit</th>
                                <th class="td bold">Rate</th>
                                <th class="td bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $invoiceTotal = 0;
                            for ($i = 0; $i < count($pos); $i++) {
                                $poData = $this->db->get_where('po', array('id' => $pos[$i]))->row();
                                $jobs = $this->db->get_where('job', array('po' => $poData->id))->result();
                                foreach ($jobs as $job) {
                                    $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                                    $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id); ?>
                                    <tr>
                                        <td class="td"><?= $poData->number ?></td>
                                        <td class="td"><?= $job->name ?></td>
                                        <td class="td"><?= $this->admin_model->getServices($priceList->service) ?></td>
                                        <td class="td"><?= $this->admin_model->getLanguage($priceList->source) ?></td>
                                        <td class="td"><?= $this->admin_model->getLanguage($priceList->target) ?></td>
                                        <?php if ($job->type == 1) { ?>
                                            <td class="td"><?= $job->volume ?></td>
                                        <?php  } elseif ($job->type == 2) { ?>
                                            <td class="td"><?= $jobTotal / $priceList->rate ?></td>
                                        <?php } ?>
                                        <td class="td"><?= $this->admin_model->getUnit($priceList->unit) ?></td>
                                        <td class="td"><?= $priceList->rate ?></td>
                                        <td class="td"><?= $jobTotal ?></td>
                                    </tr>
                            <?php $invoiceTotal = $invoiceTotal + $jobTotal;
                                }
                            } ?>
                            <tr>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td"></td>
                                <td class="td" style="background-color:#e5b8b7;"><?= $invoiceTotal ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="height:70px">
                <td colspan="3"></td>
            </tr>
            <?php if ($bank->bank == 1) { ?>
                <tr style="text-align:left">
                    <td colspan="3">
                        <p style="font-weight:bold;font-size:10px;"> Key Email: <a href="mailTo:Karim@thetranslationgate.com">Karim@thetranslationgate.com</a></p>
                        <p style="font-weight:bold;font-size:10px;"> NB: Exempted from national VAT</p>
                    </td>
                </tr>
                <tr style="height:70px">
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table style="width: 80%;text-align: left;vertical-align: middle;padding: 5px">
                            <thead>
                                <tr style="background-color:#e5b8b7;font-size:10px;font-weight:bold;border: 1px dashed black;text-align:center">
                                    <th colspan="2" class="td bold">Payment Methods</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td bold" style="width: 30%; vertical-align: middle;">Money Bookers</td>
                                    <td class="td" style="width: 70%;"><a href="mailTo:payments@thetranslationgate.com">payments@thetranslationgate.com</a></td>
                                </tr>
                                <tr>
                                    <td class="td bold" style="width: 30%; vertical-align: bottom;">Bank Transfer</td>
                                    <td class="td" style="width: 70%;"><b>Bank Name:</b> Arab African International Bank<br />
                                        <b>Bank Address:</b> 359 Soudan St. Mohandessin, Giza, Egypt<br />
                                        <b>Branch Name:</b> Soudan<br />
                                        <b>SWIFT Code:</b> ARAIEGCX<br />
                                        <b>Account Name:</b> The Translation Gate<br />
                                        <b>Account No:</b> 525676<br />

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php } elseif ($bank->bank == 2) { ?>
                <tr style="text-align:left">
                    <td colspan="3">
                        <p style="font-weight:bold;font-size:10px;"> Key Email: <a href="mailTo:accountsreceivable@thetranslationgate.com">accountsreceivable@thetranslationgate.com</a></p>
                        <p style="font-weight:bold;font-size:10px;"> NB: Exempted from national VAT</p>
                    </td>
                </tr>
                <tr style="height:70px">
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table style="width: 80%;text-align: left;vertical-align: middle;padding: 5px">
                            <thead>
                                <tr style="background-color:#e5b8b7;font-size:10px;font-weight:bold;border: 1px dashed black;text-align:center">
                                    <th colspan="2" class="td bold">Payment Methods</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td bold" style="width: 30%; vertical-align: middle;">Money Bookers</td>
                                    <td class="td" style="width: 70%;"><a href="mailTo:payments@thetranslationgate.com">payments@thetranslationgate.com</a></td>
                                </tr>
                                <tr>
                                    <td class="td bold" style="width: 30%; vertical-align: bottom;">Bank Transfer</td>
                                    <td class="td" style="width: 70%;"><b>Account Name: </b>Afaq Al Mutmeyza Translation Services LLC <br />
                                        <b>Bank Name:</b> Emirates Islamic Bank <br />
                                        <b>Bank Address:</b> P.O. Box 6564 – Dubai, UAE<br />
                                        <b>Swift Code: </b>MEBLAEAD<br /><br />
                                        <b>Account & IBAN Numbers:</b><br />
                                        <b>Account Number:</b> 3707394443201 (USD)<br />
                                        <b>IBAN:</b> AE800340003707394443201 (USD)<br />
                                        <b>Account Number:</b> 3707394443202 (EUR)<br />
                                        <b>IBAN:</b> AE530340003707394443202 (EUR)<br />
                                        <b>Account Number:</b> 3707394443203 (AED)<br />
                                        <b>IBAN:</b> AE260340003707394443203 (AED)<br />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>