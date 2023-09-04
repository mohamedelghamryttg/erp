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
                              	<th>Number of Requests</th>
                             	 <th>unit</th>
                             	 <th>Total WWC</th>
                             	 <th>TM</th>

							</tr>
						</thead>
						<tbody>
		                   <?php foreach ($unit as $row) { 
								$req = $this->db->query(" SELECT COUNT(*) AS total_requests,u.brand FROM `translation_request` LEFT OUTER JOIN users AS u ON u.id = translation_request.created_by WHERE translation_request.created_at BETWEEN '$date_from' AND '$date_to' AND translation_request.unit = '$row->id' AND translation_request.status != 4  AND u.brand = '$this->brand' GROUP BY brand; ")->row()->total_requests;
                          	if($req > 0){
                            	$data = $this->db->query(" SELECT SUM(count) AS wwc, SUM(tm) AS tm,u.brand FROM `translation_request` LEFT OUTER JOIN users AS u ON u.id = translation_request.created_by WHERE translation_request.created_at BETWEEN '$date_from' AND '$date_to' AND translation_request.unit = '$row->id' AND translation_request.status != 4 AND u.brand = '$this->brand' GROUP BY brand; ")->row();
                        	?>
							<tr>
								<td><?=$req?></td>
								<td><?php echo $row->name ;?></td>
								<td><?=$data->wwc?></td>
								<td><?=$data->tm?></td>
							</tr>
						<?php }}  ?>
						</tbody>
					</table>
					</body>
                    </html>