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
                              	<th>PM</th>
                                <th>Task Name</th>
                                <th>Task Type</th>
                                <th>Product line</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Source Language</th>
                                <th>Source Language Direction</th>
                                <th>Target Language</th>
                                <th>Target Language Direction</th>
                                <th>Source Application</th>
                                <th>Target Application</th>
                                <th>Translatio In</th>
                                <th>Rate</th>
                                <th>File Attachment</th>
                                <th>Start Delivery</th>
                                <th>Delivery Date</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Task Started At</th>

							</tr>
						</thead>
						<tbody>
							<?php foreach ($dtp_request->result() as $row) { 
								$jobData = $this->projects_model->getJobData($row->job_id);
            					$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
							?>
							<tr>
								<td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($row->id) ;?>" class="">DTP-<?=$row->id?></a></td>
								<td><?=$this->admin_model->getAdmin($row->created_by)?></td>
								<td><?=$row->task_name?></td>
								<td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
								<td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
								<td><?=$row->volume?></td>
								<td><?=$this->admin_model->getUnit($row->unit)?></td>
								<td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
								<td><?=$this->admin_model->getLanguage($priceListData->target)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->source_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->target_application)?></td>
								<td><?=$this->admin_model->getDTPApplication($row->translation_in)?></td>
								<td><?=$row->rate?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?=$row->start_date?></td>
								<td><?=$row->delivery_date?></td>
								<td><?=$row->created_at?></td>
								<td><?=$this->projects_model->getDTPTaskStatus($row->status)?></td>
								<td><?=$this->admin_model->getAdmin($row->status_by)?></td>
								<td><?=$row->status_at?></td>
							
							</tr>
						<?php } ?>
						</tbody>
					</table>
					</body>
                    </html>