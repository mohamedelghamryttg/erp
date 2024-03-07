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
    <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>PO Number</th>

                <th>Closed Date</th>
                <th>PM Name</th>
                <th>Verified</th>
                <th>Verified At</th>
                <th>Has Error</th>
                <th>Invoiced</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $x = 0;
            foreach ($cpo->result() as $row) {
                $jobs = $this->db->get_where('job', array('po' => $row->id))->result();
            ?>
                <tr>
                    <td><?php echo $this->customer_model->getCustomer($row->customer); ?></td>
                    <td><?php echo $row->number; ?></td>
                    <td><?php echo $row->created_at; ?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                    <td><?php if ($row->verified == '1') {
                            echo "Verified";
                        } elseif ($row->verified == '2') {
                            echo "Has Error";
                        } else {
                            echo "Not Verified";
                        } ?></td>
                    <td><?php if ($row->verified == '1') {
                            echo $row->verified_at;
                        } ?></td>
                    <td>
                        <?php
                        if ($row->verified == '2') {
                            $errors = explode(",", $row->has_error);
                            for ($i = 0; $i < count($errors); $i++) {
                                if ($i > 0) {
                                    echo " - ";
                                }
                                echo $this->accounting_model->getError($errors[$i]);
                            }
                        } ?>
                    </td>
                    <td><?php if ($row->invoiced == '1') {
                            echo "Invoiced";
                        } else {
                            echo "Not Invoiced";
                        } ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>