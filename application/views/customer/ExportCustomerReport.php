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
    		<th><table>
    			<tr>
        			<td>Contact name</td>
            		<td>Phone Number</td>
            		<td>Skype</td>
    			</tr>
            </table></th>
            <th>Total Revenue $ 2019</th>
            <th>Total Revenue $ 2020</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($row as $row) {
            	$contact = $this->db->get_where('customer_contacts',array('lead'=>$row->id))->result();
            	$closedProjects2019 = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '2019-01-01' AND '2020-01-01' AND j.status ='1' AND p.lead = '$row->id' ");
              $totalClosed2019 = 0;
              foreach ($closedProjects2019->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed2019 = $totalClosed2019 + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            
            	$closedProjects2020 = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '2020-01-01' AND '2021-01-01' AND j.status ='1' AND p.lead = '$row->id' ");
              $totalClosed2020 = 0;
              foreach ($closedProjects2020->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed2020 = $totalClosed2020 + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
        ?>
        <tr class="gradeX">
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->website;?></td>
            <td>
            	<table>
                	<?php foreach ($contact as $contact) { ?>
                		<tr>
            				<td><?php echo $contact->name;?></td>
            				<td><?php echo $contact->phone;?></td>
            				<td><?php echo $contact->skype_account;?></td>
                		</tr>
                	<?php } ?>
            	</table>	
        	</td>
            <td>$ <?=number_format($totalClosed2019,2)?></td>
            <td>$ <?=number_format($totalClosed2020,2)?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>