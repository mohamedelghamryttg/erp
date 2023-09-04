<?php if($permission->view == 1){?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">			
			<header class="panel-heading">
				Tickets Filter
			</header>			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="tickets" action="<?php echo current_url()?>" method="get" enctype="multipart/form-data">
                            <?php 
                                    if(isset($_REQUEST['created_by'])){
                                        $created_by = $_REQUEST['created_by'];
                                    }else{
                                        $created_by = "";
                                    }
                            ?>
			    
      			<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Requester Name">Created By</label>

                    <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by" />
                                <option disabled="disabled" selected="">-- Select Name --</option>
                                 <?=$this->admin_model->selectAllVmTicketsUsers($created_by,$this->brand)?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                      <a href="<?=current_url()?>" class="btn btn-warning">(x) Clear Filter</a> 
                  </div>
              </div>   
              </form>
			</div>
		</section>
	</div>
</div>
<?php }?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				VM Tickets
			</header>
			<?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
			<?php  } ?>
			<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
			<?php  } ?>
			
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<!--<a href="<?=base_url()?>vendor/addSalesVmTicket" class="btn btn-primary ">Add New Ticket</a>-->
							<a href="<?=base_url()?>vendor/addSalesVmTicketMultiLang" class="btn btn-primary ">Add New Ticket</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
							  <tr>
                                <th>Ticket Number</th>
								<th>Request Type</th>
								<th>Service</th>
								<th>Task Type</th>
                                <th>Rate</th>
                                <th>Count</th>
                                <th>Unit</th>
                                <th>Currency</th>
                                <th>Source Language</th>
                                <th>Target Language</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
<!--                                <th>Due Date</th>-->
                                <th>Subject Matter</th>
                                <th>Ticket Subject</th>
                                <th>Software</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Ticket</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($ticket->result() as $row)
								{
						?>
									<tr class="">
                                      	<td><?php echo $row->id ;?></td>
										<td><?php echo $this->vendor_model->getTicketType($row->request_type) ;?></td>
										<td><?php echo $this->admin_model->getServices($row->service);?></td>
										<td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
										<td><?php echo $row->rate ;?></td>
										<td><?php echo $row->count ;?></td>
										<td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
										<td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->source_lang) ;?></td>
										<td><?php echo $this->admin_model->getLanguage($row->target_lang) ;?></td>
										<td><?php echo $row->start_date ;?></td>
										<td><?php echo $row->delivery_date ;?></td>
<!--										<td><?php echo $row->due_date ;?></td>-->
										<td><?php echo $this->admin_model->getFields($row->subject);?></td>
										<td><?php echo $row->ticket_subject ;?></td>
										<td><?php echo $this->sales_model->getToolName($row->software);?></td>
										<td><?php echo $this->vendor_model->getTicketStatus($row->status);?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<a href="<?php echo base_url()?>vendor/requesterTicketViewSales?t=<?php echo 
											base64_encode($row->id) ;?>&from=<?=base64_encode(0)?>" class="">
												<i class="fa fa-eye"></i> View Ticket
											</a>
										</td>
										<td>
											<?php if($permission->edit == 1 && $row->status == 1){ ?>
											<a href="<?php echo base_url()?>vendor/editSalesVmTicket?t=<?php echo 
											base64_encode($row->id);?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if($permission->delete == 1 && $row->status == 1){ ?>
											<a href="<?php echo base_url()?>vendor/deleteSalesVmTicket?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Ticket ?');">
												<i class="fa fa-times text-danger text"></i> Delete
											</a>
											<?php } ?>
										</td>
									</tr>
						<?php
								}
						?>		
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>