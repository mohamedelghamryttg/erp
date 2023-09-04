<!DOCTYPE>
<html dir=ltr>

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
            font-size: 18px;
        }

        table td {
            border: 1px solid black;
        }

        table th {
            border: 1px solid black;
        }

        .clr {
            background-color: #EEEEEE;
            text-align: center;
        }

        .clr1 {
            background-color: #FFFFCC;
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Payment Method</th>
                <th>Type</th>
                <th>Bank</th>
                <th>Account Code</th>
                <th>Currency</th>
                <th>Account Link</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 0;
            if (($payment_method->num_rows()) > 0) {
                foreach ($payment_method->result() as $row) {
                    $counter++;
                    ?>
                    <tr class="">
                        <td>
                            <?= $counter; ?>
                        </td>
                        <td>
                            <?= $row->id; ?>
                        </td>
                        <td>
                            <?= $row->name; ?>
                        </td>
                        <td>
                            <?= ($row->type == '1' ? 'Cash' : ($row->type == '2' ? 'Bank' : '')); ?>
                        </td>
                        <td>
                            <?= (isset($row->bank) ? $this->AccountModel->getByID('bank', $row->bank) : '') ?>
                        </td>
                        <td>
                            <?= $row->acc_code; ?>
                        </td>
                        <td>
                            <?= $this->admin_model->getCurrency($row->currency_id) ?>
                        </td>
                        <td>
                            <?= $this->AccountModel->getByID('account_chart', $row->account_id) ?>
                        </td>
                        <td>
                            <?php if (isset($row->created_by)) {
                                $this->admin_model->getAdmin($row->created_by);
                            } ?>
                        </td>
                        <td>
                            <?= $row->created_at ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7">There is no payment to list</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>