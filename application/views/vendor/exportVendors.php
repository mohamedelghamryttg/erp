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
								<th>Status</th>
								<th>Source Language</th>
								<th>Target Language</th>
								<th>Dialect</th>
								<th>Service</th>
								<th>Task Type</th>
								<th>Unit</th>
								<th>Rate</th>
                            	<th>Special Rate</th>
								<th>Currency</th>
								<th>Contact</th>
                                                                 <th>Phone Number</th>
								<th>Country of Residence</th>
								<th>Mother Tongue</th>
								<th>Profile</th>
								<th>CV</th>
								<th>Subject Matter</th>
								<th>Tools</th>
								<th>Type</th>
								<th>Num. Of Tasks</th>
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
                                    	<td><?php echo $this->vendor_model->getVendorStatus($row->status) ;?></td>
										<td><?=$this->admin_model->getLanguage($row->source_lang)?></td>
										<td><?=$this->admin_model->getLanguage($row->target_lang)?></td>
										<td><?=$row->dialect?></td>
										<td><?=$this->admin_model->getServices($row->service)?></td>
										<td><?=$this->admin_model->getTaskType($row->task_type)?></td>
										<td><?=$this->admin_model->getUnit($row->unit)?></td>
										<td><?=$row->rate?></td>
										<td><?=$row->special_rate?></td>
										<td><?=$this->admin_model->getCurrency($row->currency)?></td>
										<td><?=$row->contact?></td>
                                                                                <td><?=$row->phone_number?></td>
										<td><?=$this->admin_model->getCountry($row->country)?></td>
										<td><?=$row->mother_tongue?></td>
										<td><?=$row->profile?></td>
										<td><?php if(strlen($row->cv) > 1){ ?><a href="<?=base_url()?>assets/uploads/vendors/<?=$row->cv?>">Download</a><?php } ?></td>
										<td>
										<?php
										$subjects = explode(",", $row->subject);
										for ($i=0; $i < count($subjects); $i++) { 
											if($i > 0){echo " - ";}
										 	echo $this->admin_model->getFields($subjects[$i]);
										 } 
										?>
										</td>
										<td>
										<?php
										$tools = explode(",", $row->tools);
										for ($i=0; $i < count($tools); $i++) { 
											if($i > 0){echo " - ";}
										 	echo $this->sales_model->getToolName($tools[$i]);
										 } 
										?>
										</td>
										<td><?php echo $this->vendor_model->getVendorType($row->type) ;?></td>
                                             <td>
										<?= $this->vendor_model->getVendorTaskCount($row->id); ?>
									</td>
										<td><?php echo $this->admin_model->getAdmin($row->sheetCreatedBy) ;?></td>
										<td><?php echo $row->sheetCreatedAt ;?></td>
									</tr>
						<?php
								}
						?>		
						</tbody>
					</table>
				</body>
</html>