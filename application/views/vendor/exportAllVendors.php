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
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Contact</th>
               <th>Phone Number</th>
								<th>Country of Residence</th>
								<th>Mother Tongue</th>
								<th>Profile</th>
                <th>Created By</th>
                <th>Created At</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($vendor->result() as $row)
								{
                            		if($row->color == "1"){
										$style = 'background-color: red;color: white;';
									}elseif($row->color == "2"){
										$style = 'background-color: yellow;';
									}
									else{
										$style = '';
									}
						?>
									<tr style="<?=$style?>" class="">
										<td><?=$row->id?></td>
										<td><?=$row->name?></td>
										<td><?=$row->email?></td>
										<td><?=$row->contact?></td>
                    <td><?=$row->phone_number?></td>
										<td><?=$row->mother_tongue?></td>
										<td><?=$row->profile?></td>
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