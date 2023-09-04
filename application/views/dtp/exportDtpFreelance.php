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
                          <th>Job Id</th>
                          <th>Subject</th>
                          <th>Task Type</th>
                          <th>Vendor</th>
                          <th>Rate</th>
                          <th>Unit</th>
                          <th>Count</th>
                          <th>Total Cost</th>
                          <th>Currency</th>
                          <th>Start Date</th>
                          <th>Delivery Date</th> 
                          <th>Status</th>
                          <th>Created By</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach ($row->result() as $row) { 
                          if( $row->status == 0 or $row->status == 1){

                            ?>
                  <tr> 
                     <td><?=$row->id?></td>
                    <td><?=$row->job_id?></td>
                    <td><?=$row->subject?></td>
                    <td><?=$this->admin_model->getTaskType($row->task_type)?></td>
                    <td><?=$this->db->query("SELECT name FROM vendor WHERE id = '$row->vendor'")->row()->name; ?></td>
                    <td><?= $row->rate?></td>
                    <td><?=$this->admin_model->getUnit($row->unit)?></td>
                    <td><?= $row->count?></td>
                    <td><?php echo $row->rate * $row->count;?></td>
                    <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                    <td><?=$row->start_date?></td>
                    <td><?= $row->delivery_date?></td> 
                    <td><?= $this->projects_model->getJobStatus($row->status)?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                  </tr>
            <?php }}?>
						</tbody>
					</table>
					</body>
                    </html>