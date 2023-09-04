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
                text-align: center;
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
            .bg-yellow{
                background-color:yellow;      
            }
            .bg-danger{
              background-color:red;      
            }
            .bg-warning{
              background-color:orange;      
            }
            .bg-success{
              background-color:green;      
            }
            .bg-primary{
              background-color:blue;      
            }
        </style>
    </head>
    <body>  
                    <table  border='1' style='border-collapse: collapse;'>
                        <thead>
                            <tr>
                                <th colspan="5"><?= $this->hr_model->getEmployee($score->emp_id) ?> / <?= $this->accounting_model->getMonth($score->month) ?></th>

                            </tr>
                            <tr>
                                <th>KPIs to Measure achievement</th>
                                <th>Weight</th>
                                <th>Target</th>
                                <th>Achieved</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach ($core_headers as $key => $value) { ?>
                                <tr>
                                    <td colspan="5" style="color:red;text-align: left"><?= $value->core_name ?></td>
                                </tr>
                                <?php
                                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                                foreach ($sub as $key => $val) {

                                    $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_sub_id = '$val->id' and kpi_score_id = '$score->id'")->row();
                                    ?> 
                                    <tr>
                                        <td><?= $val->sub_name ?></td>
                                        <td><?= $score_data->weight ?> %</td>
                                        <td><?= $score_data->target .' '?><?=$val->target_type!='#'?$val->target_type:'' ?></td>
                                        <td><?= $score_data->achieved .' '?><?=$val->target_type!='#'?$val->target_type:'' ?></td>
                                        <td><?= $score_data->score ?> %</td>

                                    </tr>

                                <?php }
                            } ?>
                          
                            <tr  class="clr1">
                            </tr>
                            <tr  class="clr1">
                            <?php   $total_score = $this->db->query("SELECT sum(`score`)as total From kpi_score_data WHERE kpi_score_id = '$score->id'")->row();
                                ?>  
                                <tr  class="bg-<?=$this->hr_model->performanceMatrix((float)$total_score->total,$score->year)['color']?>" style="color:#FFF;vertical-align: middle;">                                                           
                                <td colspan="4" ><h4 >Total Score</h4></td>                                
                                <td class="total_score"><h4 class="text-center"><?= number_format((float)$total_score->total, 2, '.', ''); ?>%</h4></td>
                           
                            </tr>  
                        </tbody>

                    </table>
         <?php if($gab > 0){?>
          <table  border='1' style='border-collapse: collapse;'>
                        <thead>
                            <tr>
                                <th colspan="5">Gap Performance Analysis </th>

                            </tr>
                            <tr>
                                 <th>GAP Performance</th>
                                <th>Action</th>
                                <th>Due Date</th>
                                <th>Owners</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php  foreach($actions as $k=>$action){ ?> 
                            <tr>
                                <td width='30%'><?=$this->hr_model->getSubCoreName($action->kpi_sub_id)?></td>
                                <td><?=$action->action?></td>
                                <td><?=$action->deadline?></td>
                                <td><?=$action->owner?></td>
                                <td><?=$action->comment?></td>
                            </tr>
                           <?php  }?>
                                                     
                        </tbody>

                    </table>
        <?php } ?>
     </body>
</html>            