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
							  <tr>
                                <th>Ticket Number</th>
								<th>Request Type</th>
								<th>Service</th>
                                <th>Task Type</th>
                                <th>Rate</th>
                                <th>Count</th>
                                <th>Unit</th>
                                <th>Currency</th>
                                <th>Source Language</th>
                                <th>Target Language</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                
                                <th>Subject Matter</th>
                                <th>Software</th>
                                <th>Taken Time</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Ticekt</th>
							</tr>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($ticket->result() as $row)
								{
						?>
									<tr class="">
                                      	<td><?php echo $row->id ;?></td>
										<td><?php echo $this->vendor_model->getTicketType($row->request_type) ;?></td>
										<td><?php echo $this->admin_model->getServices($row->service);?></td>
                                      	<td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
										<td><?php echo $row->rate ;?></td>
										<td><?php echo $row->count ;?></td>
										<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
										<td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->source_lang) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->target_lang) ;?></td>
										<td><?php echo $row->start_date ;?></td>
										<td><?php echo $row->delivery_date ;?></td>
										
										<td><?php echo $this->admin_model->getFields($row->subject);?></td>
										<td><?php echo $this->sales_model->getToolName($row->software);?></td>
										<td><?php echo $this->vendor_model->ticketTime($row->id).' H:M';?></td>
										<td><?php echo $this->vendor_model->getTicketStatus($row->status);?></td>
                                        <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
									</tr> 


						<?php
								}
						?>		
						</tbody>
					</table>
</html>