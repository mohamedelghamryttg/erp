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
                <th>ID</th>
                <th>cash</th>
                <th>Account</th>
                <th>Currency</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (($cash_code->num_rows()) > 0) {
                foreach ($cash_code->result() as $row) {
                    ?>
                    <tr class="">
                        <td>
                            <?php echo $row->id; ?>
                        </td>
                        <td>
                            <?php echo $row->name; ?>
                        </td>
                        <td>
                            <?php echo $this->AccountModel->getchartData($row->account_id)->name; ?>
                        </td>
                        <td>
                            <?= $this->admin_model->getCurrency($row->currency_id) ?>
                        </td>
                        <td>
                            <?php echo $this->admin_model->getAdmin($row->created_by); ?>
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
                    <td colspan="7">There is no cash to list</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>