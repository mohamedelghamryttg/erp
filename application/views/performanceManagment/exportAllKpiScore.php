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
        <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">

                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Score%</th>
                            <th>Performance Matrix</th>
                            <th>Status</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kpis->result() as $row) { 
                             $score_data = $this->db->query("SELECT sum(score) as sum From kpi_score_data WHERE kpi_score_id = '$row->id'")->row();
                             $score = $score_data->sum;                           
                           ?>     <tr> 
                                <td><?php echo $this->hr_model->getEmployee($row->emp_id); ?></td>
                                <td><?php echo $this->hr_model->getYear($row->year); ?></td>
                                <td><?php echo $this->accounting_model->getMonth($row->month); ?></td>
                                <td><span class="label label-square label-<?=$this->hr_model->performanceMatrix($score,$row->year)['color']?>"><?=  number_format((float)$score, 2, '.', '') ?>%</span></td>
                                <td><span class="label label-square label-<?=$this->hr_model->performanceMatrix($score,$row->year)['color']?>"><?php echo $this->hr_model->performanceMatrix($score,$row->year)['grade']; ?></span></td>
                                <td><?php echo $this->hr_model->getScoreStatus($row->id); ?></td>
                              
                            </tr>
<?php } ?>
                    </tbody>
                </table>
                <!--end: Datatable-->
    </body>
</html>
