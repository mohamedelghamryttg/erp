<!DOCTYPE ><html dir=ltr>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
  background-color: #EEEEEE;
  text-align: center;
}
.clr1 {
background-color: #FFFFCC;
  text-align: center;
}
.bg-success{
   color: #008a00; 
} 
</style>
</head>
<body>
  
    <table class="table table-bordered table-responsive pb-10 "style ="max-height:500px">
        <thead>
          
            <tr class="sticky-head">
                <!--<th >#ID</th>-->
                <th class="sticky-col">Employee</th>
                <?php                               
                foreach ($days as $key => $day) {
                    echo "<th class='font-size-xs text-center'style='font-size:11px'>" . $day->format('d M') .
                       "<br/><span style='font-size:10px;color:#e83e8c'>".$day->format('D').
                    "</span></th>";
                }
                ?>   
                <th >Total Worked</th>
                <th >Total WO</th>
                <th >Total WH</th>
                <th >Total Off </th>
                <th >Total Deductions </th>
                 <th >Approval Status </th>
                 <th ></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($employees as $emp) { $count_worked =0;$count_off =0;$count_deduction=0;$count_office_worked=0;$count_home_worked=0;?>
                <tr>
                    <!--<td ><?= $emp->id ?></td>-->
                    <td class="sticky-col"><?= word_limiter($emp->name, 3, ' ') ?></td>
                    <?php foreach ($days as $key => $day) {
                        $status = $this->hr_model->getDayStatusFast($emp->id, $day->format('Y-m-d'));
                        ?>
                    <td class="font-size-xs status " <?php if($status=='W' || $status=='WO'){
                        echo 'style="background:green;color:white"';
                        }
                        else if($status == 'A' ){
                            echo 'style="background:red;color:white"';
                        }
                        else if($status == 'V' ){
                            echo 'style="background:gray;color:white"';
                        }
                        else if($status == 'WH' ){
                           echo 'style="background:orange;color:white"';
                        }?>><?= $status ?></td>
                        <?php if($status=='W'|| $status== 'WO'|| $status == 'WH'){
                               $count_worked ++;
                        }else {
                            $count_off ++;
                        }
                        if($status=='A'){
                               $count_deduction ++;                                                        
                        }if($status=='WO'){
                               $count_office_worked ++;                                                       
                        }if($status=='WH'){
                               $count_home_worked ++;
                        }                                
                    } ?>
                    <td class="worked font-weight-bolder"><?=$count_worked?></td>
                    <td class="worked_office text-success font-weight-bolder"><?= $count_office_worked ?></td>
                    <td class="worked_home text-warning font-weight-bolder"><?= $count_home_worked ?></td>
                    <td class="off font-weight-bolder"><?=$count_off?></td>
                    <td class="deduction text-danger font-weight-bolder"><?=$count_deduction?></td>
                     <?php $approval_status = $this->hr_model->checkTimeSheetRowStatus($emp->id,$payroll_month??0,$count_deduction);?>
                    <td class="font-weight-bolder">                                                             
                       <?=$approval_status['status']?>                       
                    </td>
                    <td class="font-weight-bolder">                                                             
                     <?=$approval_status['msg']?>                      
                    </td>
                    
                </tr>
        <?php } ?>

        </tbody>
    </table>
</body>
</html>
