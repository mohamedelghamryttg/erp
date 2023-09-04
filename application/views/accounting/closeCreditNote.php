<?php if($row->type == 1 || $row->type== 4){ 
$job = $this->db->get_where('job',array('po'=>$row->po))->result();
?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Credit Note Request
			</header>
			<div class="panel-body">
          		<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
							<span class=" btn-primary" style="">
								Request Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                 <th>ID</th>
                                 <th>Credit Note Type</th>
                                 <th>Customer</th>
                                 <th>Issue_date</th>
                                 <th>PO Number</th>
                                 <th>Amount</th>
                                 <th>Currency</th>
                                 <th>Attachment File</th>
                                 <th>Status</th>
                                 <th>Status By</th>
                                 <th>Status At</th>
                                 <th>Created By</th>
                                 <th>Created At</th>
							</tr>
						</thead>
						<tbody>
							<tr class="">
                                <td><?=$row->id?></td>
            					<td><?=$this->accounting_model->getCreditNoteType($row->type)?></td>
                				<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                				<td><?=$row->issue_date?></td>
                				<td><?=$this->accounting_model->getPONumber($row->po)?></td>
                				<td><?=$row->amount?></td>
                				<td><?=$this->admin_model->getCurrency($row->currency)?></td>
                				<td><a href="<?=base_url()?>assets/uploads/creditNote/<?=$row->file?>" target="_blank">Click Here</a></td>
                				<td><?=$this->accounting_model->getCreditNoteStatus($row->status)?></td>
                				<td><?php echo $this->admin_model->getAdmin($row->status_by) ;?></td>
                            	<td><?=$row->status_at?></td>
                				<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                				<td><?=$row->created_at?></td>
							</tr>
						</tbody>
					</table>
				</div>
            	<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
							<span class=" btn-primary" style="">
								PO / Job Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                 <th>Job Code</th>
                				<th>Job Name</th>
               					<th>Product Line</th>
               					<th>Service</th>
               					<th>Source</th>
               					<th>Target</th>
               					<th>Volume</th>
               					<th>Rate</th>
               					<th>Total Revenue</th>
               					<th>Currency</th>
               					<th>Status</th>
               					<th>PO Number</th>
                 				<th>CPO File</th>
                  				<th>PO Status</th>
               					<th>Has Error</th>
                				<th>Start Date</th>
                				<th>Delivery Date</th>
               					<th>Closed Date</th>
                				<th>Created By</th>
                				<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job as $job) { 
            					$priceList = $this->projects_model->getJobPriceListData($job->price_list);
            					$total_revenue = $this->sales_model->calculateRevenueJob($job->id,$job->type,$job->volume,$priceList->id);
            					$poData = $this->projects_model->getJobPoData($job->po);
            				?>
              				<tr>
                				<td><a href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($job->project_id)?>"><?=$job->code?></a></td>
                				<td><?=$job->name?></td>
                				<td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
                				<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                				<td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                				<td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                				<?php if($job->type == 1){ ?>
                				<td><?php echo $job->volume ;?></td>
                				<?php }elseif ($job->type == 2) { ?>
                				<td><?php echo $total_revenue / $priceList->rate ;?></td>
                				<?php } ?>
                				<td><?php echo $priceList->rate ;?></td>
                				<td><?=$total_revenue?></td>
                				<td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                				<td><?php echo $this->projects_model->getJobStatus($job->status) ;?></td>
                				<td><?php if(isset($poData)){ echo $poData->number; }?></td>
                				<td><?php 
                				if(isset($poData)){ ?><a href="<?=base_url()?>assets/uploads/cpo/<?=$poData->cpo_file?>" target="_blank">Click Here</a><?php } ?></td>
                				<td><?php if(isset($poData)){$this->accounting_model->getPOStatus($poData->verified); } ?></td>
                				<td>
               				 	<?php if(isset($poData)){
                    				if($poData->verified == 2){
                      				$errors = explode(",", $poData->has_error);
                      				for ($i=0; $i < count($errors); $i++) { 
                        				if($i > 0){echo " - ";}
                        				echo $this->accounting_model->getError($errors[$i]);
                       				}
                     				}} ?>
                				</td>
                				<td><?php echo $job->start_date ;?></td>
                				<td><?php echo $job->delivery_date ;?></td>
                				<td><?php echo $job->closed_date ;?></td>
                				<td><?php echo $this->admin_model->getAdmin($job->created_by) ;?></td>
                				<td><?php echo $job->created_at ;?></td>
              				</tr>
            				<?php } ?>
						</tbody>
					</table>
				</div>
          </div>
</div>
</div>
<?php } ?>

<?php if($row->status == 1){ ?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Close Request 
            </header>
            
            <div class="panel-body">
                 <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/doCloseCreditNote" method="post" enctype="multipart/form-data">

                        <input name="id" type="hidden" value="<?=base64_encode($row->id)?>" readonly="">
                        <!-- Enter your comment -->
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-success" type="submit" name="submit" value="Close Request">
                                    <a href="<?php echo base_url()?>accounting/creditNote" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>   
                  </form>
            </div>
        </section>
        </div>
    </div>
<?php } ?>
