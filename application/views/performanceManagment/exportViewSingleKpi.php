<!DOCTYPE ><html dir=ltr>
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
                    page-break-inside:auto;
                    width:90%;
                }
                tr {
                    page-break-inside:avoid;
                    page-break-after:auto;
                }
            }
            table ,table tr{
                border: 1px solid #000;
                font-size:18px;
            }
            table td {
                border:1px solid #000;
            }
            table th {
                border: 1px solid #000;
                color:#fff;
                background-color: #000;
            }
            .clr{
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
        <table  border='1' style='border-collapse: collapse;'>
        <thead>
            <th colspan="3"><?= $this->hr_model->getTitle($employee_title) ?> </th>
        </thead>
        <tbody> 
            <tr>
                <td class="clr">KPIs to Measure achievement   </td>
                <td class="clr">Weight</td>
                <td class="clr">Target</td>
            </tr>
            <?php
            foreach ($core_headers as $key => $value) {
                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                ?>
                <tr>
                    <td colspan="3"><p style="color:red"><?= $value->core_name ?></p><td>               
                </tr>
                <?php foreach ($sub as $key => $val) { ?> 
                <tr>
                        <td><?= $val->sub_name ?></td>
                        <td><?= $val->weight ?> %</td>
                        <td><?= $val->target .' '.$val->target_type ?></td>
                    </tr>

                    <?php
                }
            }
            ?>

        </tbody>
    </table>
</body>
</html>