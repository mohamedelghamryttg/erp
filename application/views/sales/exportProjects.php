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
<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
                             	<th>SAM Name</th>
				                <th>PM Name</th>
				                <th>Opportunity Number</th>
                             	<th>Project Code</th>
				                <th>Project Name</th>
				                <th>Client</th>
				                <th>Region</th>
				                <th>Rolled In Date</th>
				                <th>Product Line</th>
				                <th>Job Code</th>
				                <th>Job Name</th>
				             	<th>Service</th>
				               <th>Source</th>
				               <th>Target</th>
				               <th>Volume</th>
				                <th>Unit</th>
				               <th>Rate</th>
				               <th>Total Revenue</th>
				               <th>Total Revenue In $</th>
				               <th>Currency</th>
				               <th>Status</th>
				               <th>Start Date</th>
				                <th>Delivery Date</th>
				                <th>Closed Date</th>
				                <th>Job Created At</th>	                         	
							</tr>
						</thead>
						<tbody>
						<?php foreach ($project->result() as $row) { 
							$priceList = $this->projects_model->getJobPriceListData($row->price_list);
  							$total_revenue = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
  							$rolled = $this->db->get_where('sales_activity',array('customer'=>$row->customer,'rolled_in'=>1))->row();
  							$leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
						?>
							<tr>
								<td><?php echo $this->admin_model->getAdmin($row->assigned_sam) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?=$row->opportunity?></td>
								<td><?=$row->project_code?></td>
								<td><?=$row->project_name?></td>
								<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
								<td><?php echo $this->admin_model->getRegion($leadData->region) ;?></td>
								<td><?php if(isset($rolled->created_at)){echo $rolled->created_at;}?></td>
                              	<td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
								<td><?=$row->code?></td>
								<td><?=$row->name?></td>
								<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
				                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
				                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
				                 <?php if($row->type == 1){ ?>
				                <td><?php echo $row->volume ;?></td>
				                <?php }elseif ($row->type == 2) { ?>
				                <td><?php echo $total_revenue / $priceList->rate ;?></td>
				                <?php } ?>
				                <td><?php echo $this->admin_model->getUnit($priceList->unit) ;?></td>
				                <td><?=$priceList->rate?></td>
				                <td><?=$total_revenue?></td>
                            	<td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$row->created_at,$total_revenue),2)?></td>
				                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
				                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
				                <td><?=$row->start_date?></td>
				                <td><?=$row->delivery_date?></td>
				                <td><?=$row->closed_date?></td>
				                <td><?=$row->created_at?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
</body>
</html>