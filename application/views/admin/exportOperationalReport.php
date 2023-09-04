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
<?php if($report == 1){ ?>
<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="5" style="text-align: center;">Operational Report By PM From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>PM Name</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($pm->result() as $pm) { 
              $runningProjects = $this->db->query(" SELECT * FROM `job` WHERE created_at < '$date_to' AND created_by = '$pm->id' AND project_id <> 0 AND status = 0 ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT * FROM `job` WHERE closed_date BETWEEN '$date_from' AND '$date_to' AND status ='1' AND created_by = '$pm->id' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
              if($totalClosed == 0 && $totalRunning == 0){
              	$display = "none";
              }else{
              	$display = "";
              }
            ?>
            <tr style="display:<?=$display?>;">
              <td><?=$pm->user_name?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
<?php } ?>
<?php if($report == 2){ ?>
<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="5" style="text-align: center;">Operational Report By SAM From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>SAM Name</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($sam->result() as $sam) { 
              $runningProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = p.lead AND customer_sam.sam = '$sam->id') AS assigned FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.project_id <> 0 AND j.status = 0 AND j.created_at < '$date_to' HAVING assigned = '1' ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = p.lead AND customer_sam.sam = '$sam->id') AS assigned FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.project_id <> 0 AND j.status = 1 AND j.closed_date BETWEEN '$date_from' AND '$date_to' HAVING assigned = '1' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            ?>
            <tr>
              <td><?=$sam->user_name?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
<?php } ?>
<?php if($report == 3){ ?>
<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="6" style="text-align: center;">Operational Report By Customer From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Customer</th>
                <th>Region</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($customer->result() as $customer) { 
              $runningProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.created_at < '$date_to' AND p.lead = '$customer->leadID' AND project_id <> 0 AND j.status = 0 ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '$date_from' AND '$date_to' AND j.status ='1' AND p.lead = '$customer->leadID' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            ?>
            <tr>
              <td><?=$customer->name?></td>
              <td><?php echo $this->admin_model->getRegion($customer->region) ;?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
<?php } ?>

<?php if($report == 4){ ?>
<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
    <thead>
      <tr>
        <th colspan="3" style="text-align: center;">SAM Activities From <?=$date_from?> TO <?=$date_to?></th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th>SAM Name</th>
        <th>Number Of New Sales Activities</th>
        <th>Number Of Business Review Activities</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    foreach ($sam->result() as $sam) { 
      $activities = $this->db->query(" SELECT COUNT(*) AS total FROM `sales_activity` WHERE created_at BETWEEN '$date_from' AND '$date_to' AND created_by = '$sam->id' ")->row();
      $busimess = $this->db->query(" SELECT COUNT(*) AS total FROM `sales_business_reviews` WHERE created_at BETWEEN '$date_from' AND '$date_to' AND created_by = '$sam->id' ")->row();
    ?>
    <tr>
      <td><?=$sam->user_name?></td>
      <td><?=$activities->total?></td>
      <td><?=$busimess->total?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
<?php } ?>

</body>
</html>