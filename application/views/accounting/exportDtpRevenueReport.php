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
</style>
</head>
<body>
 <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
              <tr>

              
              
              <th>Job Name</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Currency</th>
               <th>Total Revenue</th>
              <th>Total Revenue $ USD</th>
              <th>Task Type</th>
                        <th>Unit</th>
                        <th>Source Language Direction</th>
                        <th>Target Language Direction</th>
                       <th>Start Date</th>
                       <th>Delivery Date</th>
                       <th>Closed Date</th>
                        <th>Created By</th>

                     
                
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($project)){
              foreach ($project->result() as $row) { 
                  $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                  $jobTotal = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
            ?>
              <tr>
               <!-- jobs -->
                <td><?=$row->name?></td>
                <?php if($row->type == 1){ ?>
                <td><?php echo $row->volume ;?></td>
                <?php }elseif ($row->type == 2) { ?>
                <td><?php echo $jobTotal / $priceList->rate ;?></td>
                <?php } ?>
                <td><?php echo $priceList->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                <td><?php echo $jobTotal; ?></td>
              	<td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$row->closed_date,$jobTotal),2);?></td>
 

            <!--DTP Task -->


                  <td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
                  <td><?=$this->admin_model->getUnit($row->unit)?></td>
                  <td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
                  <td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>

                  <td><?=$row->start_date?></td>
                  <td><?=$row->delivery_date?></td>
                  <td><?=$row->closed_date?></td>
                  <td><?=$this->admin_model->getAdmin($row->created_by)?></td>

                </tr>
              <!-- End DTP Tasks -->

              </tr>
            <?php }} ?>
    </tbody>
</table>
</body>
</html>