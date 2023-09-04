


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
                    <th>Customer Name </th>
                    <th>Project Name</th>
                    <th>Revues achieved from 1st Jan ~ up to date </th>
                    <th>Closed Date</th>
                   
              </tr>
    </thead>
    <tbody>  
        <?php 
                foreach ($customer->result() as $customer) { 
                     $closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,p.code AS projectCode FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.status = 1 AND p.lead = '$customer->leadID' AND p.created_by = 34 AND YEAR(CURRENT_TIMESTAMP) = ( SELECT EXTRACT(YEAR FROM p.created_at))");

                        $totalClosed = 0;
                      foreach ($closedProjects->result() as $closed) {
                          $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                          $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                          $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
                  ?>
                  <tr class="">
                    <td><?= $customer->name ;?></td>
                    <td><?= $closed->projectCode ;?></td>
                    <td>$ <?=number_format($totalClosed,2)?></td>
                    <th><?= $closed->closed_date ?></th>
                  </tr>
               <?php }} ?>  
        
    </tbody>
</table>
</body>
</html>