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
           <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">

            <thead>
              <tr>
                <th>Customer</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              	<th>Total VPOs Cost</th>
                <th>Profit</th>
              </tr>
            </thead>
            <tbody>
            <?php 
      
            foreach ($customer->result() as $customer) { 
              $runningProjects = $this->db->query(" SELECT j.*,p.customer FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.created_at < '$date_to' AND project_id <> 0 AND j.status = 0 AND p.customer = '$customer->id' ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT j.*,p.customer FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '$date_from' AND '$date_to' AND j.status ='1' AND p.customer = '$customer->id' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            ?>
            <tr>
              <td><?=$customer->name?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
              <td>$ <?=number_format($totalCost,2)?></td>
              <td>$ <?=number_format($totalClosed - $totalCost,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>

          </body>
</html>