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
               <th>PO Number</th>
               <th>Service</th>
               <th>Source</th>
               <th>Target</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Total Revenue</th>
               <th>Currency</th>
               <th>Total Revenue (USD)</th>
              </tr>
            </thead>
            <tbody>
            <?php if(isset($project)){foreach ($project->result() as $job) {
              $priceList = $this->projects_model->getJobPriceListData($job->price_list);
              $total_revenue = $this->sales_model->calculateRevenueJob($job->id,$job->type,$job->volume,$priceList->id);
                    ?>
                    <tr>
                      <td><?php echo $job->number; ?></td>
                      <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                      <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                      <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                      <?php if($job->type == 1){ ?>
                      <td><?php echo $job->volume ;?></td>
                      <?php }elseif ($job->type == 2) { ?>
                      <td><?php echo $total_revenue / $priceList->rate ;?></td>
                      <?php } ?>
                      <td><?php echo $priceList->rate ;?></td>
                      <td><?=number_format($total_revenue,2)?></td>
                      <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                      <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$job->issue_date,$total_revenue),2)?></td>
                    </tr>
              <?php  
            } }?>
            </tbody>
          </table>
</body>
</html>