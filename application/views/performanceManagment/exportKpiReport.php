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
                    width:75%;
                }
                tr {
                    page-break-inside:avoid;
                    page-break-after:auto;
                }
            }
            table {
                border: 1px solid black;
                font-size:18px;
            }
            table td {
                border: 1px solid black;
                text-align: left;
            }
            table th {
                border: 1px solid black;
                background-color: #AE2938;
                color:#fff;
            }

            .bg-success{
                color: #008a00;
            }
        </style> 
    </head>
    <body>
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">


            <thead>
                <tr>
                    <th colspan="<?= count($months_list) + 5 ?>">Kpi Score Report From <b><?= date('F, Y', strtotime("01-$start_month-$start_year_str")) ?>  To  <?= date('F, Y', strtotime("01-$end_month-$end_year_str")) ?></b></th>

                </tr>
                <tr>
                    <th>#Employee ID</th>
                    <th>Employee</th>     
                    <th>Direct Manager</th>     
                    <th >Function</th>
                    <?php
                    foreach ($months_list as $k => $val) {
                        $year = $this->hr_model->getYear($years_list[$k]);?>
                      <th><?=date('F, Y', strtotime("01-$val-$year")) ?></th>
                  <?php } ?>                         
                    <th >AVG.</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $emp) { ?>
                    <tr>
                        <td ><?= $emp ?></td>
                        <td ><?= $this->hr_model->getEmployee($emp); ?></td>
                        <td ><?= $this->hr_model->getEmployee($this->hr_model->getManagerId($emp)); ?></td>
                        <td ><?= $this->automation_model->getEmpDep($emp); ?></td>
                        <?php foreach ($months_list as $k => $val) { ?>                                       
                            <td ><?= $scores[$emp][$val][$years_list[$k]] ?></td>
                        <?php } ?>
                        <td  style="font-weight: bold;"><?= $score_avg[$emp] ?> % </td>

                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </body>
</html>
