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
<table class="table table-striped table-hover table-bordered" id=" ">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Website</th>
								<th>Status</th>
                              	<th>Brand</th>
                                 <th>Client Type</th>
                              	<th>Customer Alias</th>
                              	<th>Payment terms</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($customer->result() as $row)
								{
						?>
									<tr class="">
										<td><?=$row->id?></td>
										<td><?php echo $row->name ;?></td>
										<td><?php echo $row->website ;?></td>
										<td><?php if($row->status == 1){ echo "Lead"; }elseif ($row->status == 2){ echo "Existing"; } ?></td>
                                        <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td>
                                        <td><?= $this->sales_model->getClientType($row->client_type) ;?></td>
										<td><?php echo $row->alias ;?></td>
										<td><?php echo $row->payment ;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										
									</tr>
						<?php
								}
						?>		
						</tbody>
					</table>
					</body>
                    </html>