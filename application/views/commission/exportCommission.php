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
  
    <table class="table table-separate table-head-custom">

            <thead>
                <tr>
                    <th no-sort>ID</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Date from</th>
                    <th>date to</th>
                    <th>Brand</th>
                    <th>Region</th>                                    
                    <th>Standalone %</th>                                    
                    <th>Team Leader %</th>                                    
                    <th>Cogs %</th>                                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rules->result() as $row) { ?>
                    <tr>
                        <td>
                            <?= $row->id ?>
                        </td>                       
                        <td>
                            <?= $row->year ?>
                        </td>
                        <td>
                            <?= $this->accounting_model->getMonth($row->month) ?>
                        </td>
                        <td>
                            <?= $row->date_from ?>
                        </td>
                        <td>
                            <?= $row->date_to ?>
                        </td>                      
                       
                        <td><?= $this->admin_model->getBrand($row->brand_id) ?></td>
                        <td><?= $this->admin_model->getRegion($row->region_id)?></td>
                        <td><?=$row->standalone_per?></td>
                        <td><?=$row->teamleader_per?></td>
                        <td><?=$row->cogs_per?></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
</body>
</html>
