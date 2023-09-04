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
            <th>Customer</th>
            <th>Website</th>
            <th>Total Revenue $</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($row as $row) {
            	$closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '2019-01-01' AND '2020-01-01' AND j.status ='1' AND p.lead = '$row->id' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
        ?>
        <tr class="gradeX">
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->website;?></td>
            <td>$ <?=number_format($totalClosed,2)?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>