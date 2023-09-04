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
  
    <table class="table table-bordered table-responsive pb-10 "style ="max-height:500px">
       <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Payroll Month</th>                            
                            <th>Payroll Year</th>                            
                            <th>Till Month</th>                            
                            <th>Till Year</th>                            
                            <th>action</th>
                            <th>amount</th>                            
                           
                        </tr>
                    </thead>
        <tbody>
        <?php foreach ($logs->result() as $k=>$row) {    ?>    
                        <tr> 
                        
                                <td><?= ++$k?></td>
                                <td><?=$row->emp_id ?></td>
                                <td><?php echo $this->hr_model->getEmployee($row->emp_id); ?></td>
                                <td><?= date('F',strtotime($row->start_date)); ?></td>
                                <td><?= date('Y',strtotime($row->start_date)); ?></td>
                                <td><?= date('F',strtotime($row->end_date)) ?></td>
                                <td><?= date('Y',strtotime($row->end_date)) ?></td>
                                
                                <td><?= $this->hr_model->getPayrollActions($row->action); ?></td>
                                <td><?= $row->amount.' '.$this->hr_model->getPayrollUnits($row->unit) ?></td>
                              
                            </tr>
<?php } ?>

        </tbody>
    </table>
</body>
</html>
