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
                             	 <th>Count</th>
                             	 <th>TM</th>
                             	 <th>Delivery Date</th>
                             	 <th>Status</th>
                             	 <th>Created By</th>
								 
							</tr>
						</thead>
						<tbody>
							<?php foreach ($translation_request->result() as $row) { 
								$jobData = $this->projects_model->getJobData($row->job_id);
            					$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
							?>
							<tr>
								<td><a href="<?php echo base_url()?>translation/TranslationJobs?t=<?php echo base64_encode($row->id) ;?>" class="">Translation-<?=$row->id?></a></td>
								<td><?php echo $row->count ;?></td>
								<td><?php echo $row->tm ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								<td><?php echo $this->projects_model->getTranslationTaskStatus($row->status) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								
							</tr>
						<?php } ?>
						</tbody>
					</table>
					</body>
                    </html>