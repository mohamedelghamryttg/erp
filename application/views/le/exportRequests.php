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
                              	<th>Task Code</th>
                              	<th>Task Name</th>
                              	<th>Task Type</th>
                              	<th>Subject Matter</th>
                              	<th>Product Line</th>
                              	<th>Linguist Format</th>
								<th>Deliverable Format</th>
								<th>Unit</th>
								<th>Volume</th>
								<th>Complexicty</th>
								<th>Rate</th>
								<th>Source Language</th>
								<th>Target Language</th>
                             	 <th>Start Date</th>
                             	 <th>Delivery Date</th>
                             	 <th>Task File</th>
                             	 <th>Status</th>
                             	 <th>Request Date</th>
                             	 <th>Requested By</th>
                                <th>Created By</th>
                                <th>Created At</th>

							</tr>
						</thead>
						<tbody>
							<?php foreach ($le_request->result() as $row) { 
								$jobData = $this->projects_model->getJobData($row->job_id);
            					$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
							?>
							<tr>
								<td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($row->id) ;?>" class="">LE-<?=$row->id?></a></td>
                              	<td><?php echo $row->subject ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
								<td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
								<td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
								<td><?=$row->linguist?></td>
								<td><?=$row->deliverable?></td>
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

								<td><?php echo $this->admin_model->getLanguage($priceListData->source);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceListData->target);?></td>
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationTaskStatus($row->status) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->status_by) ;?></td>
								<td><?php echo $row->status_at ;?></td>


							</tr>
						<?php } ?>
						</tbody>
					</table>
				</body>
               </html>