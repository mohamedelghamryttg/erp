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
							    <th>PM</th>
                                <th>Job Code</th>
                                <th>Assigned LE</th>
                              	<th>Task Type</th>
                              	<th>Linguist Format</th>
								<th>Deliverable Format</th>
								<th>Unit</th>
								<th>Volume</th>
								<th>Complexicty</th>
								<th>Rate</th>
                             	 <th>Task File</th>
                             	 <th>Status</th>
                             	 <th>View Job</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job->result() as $row) { ?>
							<tr class="">
							<td><?= $this->admin_model->getAdmin($this->db->query("SELECT created_by FROM le_request WHERE id = '$row->request_id'")->row()->created_by);?></td>
                             	<td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($row->request_id) ;?>" class="">LE-<?=$row->request_id?>-<?=$row->id?></a></td>
								<td><?php echo $this->admin_model->getAdmin($row->le) ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
								
								<?php if(is_numeric($row->linguist) && is_numeric($row->deliverable)){ ?>
								<td><?php echo $this->admin_model->getLeFormat($row->linguist);?></td>
								<td><abbr title="<?=$row->deliverable?>"><?php echo character_limiter($this->admin_model->getLeFormat($row->deliverable),10);?></abbr></td>
							<?php }else{ ?>
								<td><?=$row->linguist?></td>
								<td><abbr title="<?=$row->deliverable?>"><?=character_limiter($row->deliverable,10)?></abbr></td>
							<?php } ?>	
								<td><?php echo $this->admin_model->getUnit($row->unit);?></td>
								<td><?=$row->volume?></td>
								
                          <td><?=$this->projects_model->getLeComplexicty($row->complexicty);?></td>		<td><?= $this->projects_model->calculateLeRequestRate($row->task_type,$row->linguist,$row->deliverable,$row->complexicty,$row->volume);?></td>

								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
								<td>
									<?php if($permission->add == 1){ ?>
									<a href="<?php echo base_url()?>le/viewLETask?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Job
									</a>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</body>
                    </html>