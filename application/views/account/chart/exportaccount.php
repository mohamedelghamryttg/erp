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
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>

                <th>Code</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Closing</th>
                <th>Type</th>
                <th>Currency</th>
                <th>Therd Party</th>

            </tr>
        </thead>

        <tbody>
            <?php foreach ($chart->result() as $row): ?>
                <tr class="">

                    <td><a href="<?= base_url() ?>account/editAccount/<?= base64_encode($row->id) ?>"><?=
                            $row->ccode; ?></a>
                    </td>
                    <td>
                        <?= $row->name; ?>
                    </td>
                    <td>
                        <?= $row->parent; ?>
                    </td>
                    <td>
                        <?= $row->acc_close; ?>
                    </td>
                    <td>
                        <?= $row->acc_type; ?>
                    </td>
                    <td>
                        <?= $row->currency; ?>
                    </td>
                    <td>
                        <?php if ($row->acc_thrd_party == 1): ?>
                            <input type="checkbox" checked>
                        <?php else: ?>
                            <input type="checkbox">
                        <?php endif ?>
                    </td>


                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>