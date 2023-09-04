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
								<th>Target Language</th>
								<th>Vendors Count</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($language as $row)
								{
                            $vendor = $this->db->query("SELECT COUNT(*) AS total FROM vendor_sheet WHERE target_lang='$row->id' AND service='1' AND task_type='2' ")->row();
						?>
									<tr class="">
										<td><?=$row->name?></td>
                                    <td><?=$vendor->total?></td>
									</tr>
						<?php
								}
						?>		
						</tbody>
					</table>
				</body>
</html>