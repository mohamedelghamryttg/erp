<!DOCTYPE ><html>
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
 <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Job Code</th>
               <th>Client Name</th>
               <th>PO Number</th>
               <th>Service</th>
               <th>Source</th>
               <th>Target</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Total Revenue</th>
               <th>Currency</th>
               <th>Total Revenue (USD)</th>
               <th>Total Cost (USD)</th>
               <th>Closed Date</th>
                <th>Created By</th>
                <th>Assigned SAM</th>
                <th>Issue Date</th>
              </tr>
            </thead>
            <tbody>
            <?php if(isset($jobs)){foreach ($jobs->result() as $job) {
                    $total_revenue = $this->sales_model->calculateRevenueJobForSalesOfCost($job->id,$job->type,$job->volume,$job->price_list_rate);
                    ?>
                    <tr>
                      <td><?=$job->code?></td>
                      <td><?php echo $job->customer_name;?></td>
                      <td><?php echo $job->number; ?></td>
                      <td><?php echo $job->service_name;?></td>
                      <td><?php echo $job->source_lang;?></td>
                      <td><?php echo $job->target_lang;?></td>
                      <?php if($job->type == 1){ ?>
                      <td><?php echo $job->volume ;?></td>
                      <?php }elseif ($job->type == 2) { ?>
                      <td><?php echo $total_revenue / $job->price_list_rate ;?></td>
                      <?php } ?>
                      <td><?php echo $job->price_list_rate ;?></td>
                      <td><?=number_format($total_revenue,2)?></td>
                      <td><?php echo $job->currency_name ;?></td>
                      <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($job->price_list_currency,2,$job->issue_date,$total_revenue),2)?></td>
                      <td><?=number_format($this->accounting_model->totalCostByJobCurrency(2,$job->id),2)?></td>
                      <td><?php echo $job->closed_date ;?></td>
                      <td><?php echo $job->user_name ;?></td>
                      <td><?php echo $this->admin_model->getAdminMulti($job->assigned_sam) ;?></td>
                      <td><?php echo $job->issue_date ;?></td>
                    </tr>
              <?php  
            } }?>
            <?php foreach($creditNote as $row){ ?>
            <tr style="background-color: yellow;">
                	<td>Credit Note Number # <?=$row->id?></td>
                	<td><?php echo $row->customer_name;?> - <?=$this->accounting_model->getCreditNoteType($row->type)?></td>
                	<td><?=$row->po_number?></td>
            		<td></td>
            		<td></td>
            		<td></td>
            		<td></td>
            		<td></td>
                    <td>-<?=$row->amount?></td>
                    <td><?= $row->currency_name?></td>
                    <td>-<?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,2,$row->issue_date,$row->amount),2);?></td>
                    <td></td>
					<td></td>
					<td></td>
                    <td></td>
                    <td><?=$row->issue_date?></td>
            		</tr>
            <?php } ?>
            </tbody>
          </table>
</body>
</html>