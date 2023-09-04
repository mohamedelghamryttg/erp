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
				                <th>PM Name</th>
                             	<th>Region</th>
				                <th>Target/Monthly</th>
				                <th>Target/ Annually</th>
				                <th>Achieved Monthly $</th>
				                <th>Achieved Annually $</th>
				                <th>Number of Customers Served /Active</th>
				                <th>Number of Customers Assigned/Target</th>
				                <th>Number of jobs</th>
				                <th>Services</th>
				                <th>VPOs/COGS</th>
				                <th>Gross Profit $</th>
							</tr>
						</thead>
						<tbody>
						<?php
				                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
				                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
				                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
				                	$pms = $this->db->query(" SELECT * FROM users WHERE (role = '2' OR role = '13' OR role = '16' OR role = '29' OR role = '42' OR role = '43' OR role = '45' OR role = '47') AND brand = '$this->brand' ")->result();
                                	foreach($pms as $pm){
                                    	$regions = $this->db->query("SELECT DISTINCT c.region FROM job AS j 
										LEFT OUTER JOIN project AS p ON j.project_id = p.id
										LEFT OUTER JOIN customer_leads AS c ON p.lead = c.id
										WHERE j.created_by = '$pm->id' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to'  
										ORDER BY `c`.`region`  DESC")->result();
                                    	$customers = $this->db->query("SELECT DISTINCT p.customer FROM job AS j 
										LEFT OUTER JOIN project AS p ON j.project_id = p.id
										WHERE j.created_by = '$pm->id' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to'")->num_rows();
                                    	$services = $this->db->query(" SELECT DISTINCT l.service FROM job AS j 
											LEFT OUTER JOIN job_price_list AS l ON l.id = j.price_list
											WHERE j.created_by = '$pm->id' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to' ")->result();
                                    
                                    	$monthlyAchieved = $this->projects_model->getJobsRevenue($pm->id,$date_from,$date_to);
                                    	$totalCost = $this->projects_model->getTotalCost($pm->id,$date_from,$date_to);
                                    	$yearlyAchieved = $this->projects_model->getJobsRevenue($pm->id,date("Y", strtotime($_REQUEST['date_from']))."-01-06",$date_to)
						?>
							<tr>

								<td><?php echo $pm->user_name ;?></td>
								<td>
                            	<?php foreach($regions as $region){ 
                        			echo $this->admin_model->getRegion($region->region)." ";
                        		}
                                ?>
                            	</td>
								<td></td>
								<td></td>
								<td><?=number_format($monthlyAchieved['total'],2)?></td>
								<td><?=number_format($yearlyAchieved['total'],2)?></td>
                              	<td><?=$customers?></td>
                              	<td></td>
                              	<td><?=$monthlyAchieved['jobsNum']?></td>
                              	<td>
                            	<?php foreach($services as $service){ 
                        			echo $this->admin_model->getServices($service->service)." ";
                        		}
                                ?>
                            	</td>
                              	<td><?=number_format($totalCost,2)?></td>
                              	<td><?=number_format($monthlyAchieved['total']-$totalCost,2)?></td>

							</tr>
                        	<?php }} ?>
						</tbody>
					</table>
</body>
</html>