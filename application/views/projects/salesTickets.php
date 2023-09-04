<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Tickets Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/salesTickets" method="post" enctype="multipart/form-data">
				
                <div class="form-group">
                    
          			<label class="col-lg-2 control-label" for="role name">Ticket Number</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="id">
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                  </div>
              </div>   
              </form>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Tickets List
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
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
							  <tr>
                    <th>PM</th>
                    <th>Customer Name</th>
                    <th>Opportunity Name</th>
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
<!--                    <th>Due Date</th>-->
                    <th>Subject Matter</th>
                    <th>Software</th>
                    <th>Taken Time</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>View Ticekt</th>
							   </tr>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($ticket->result() as $row)
								{
						?>
									<tr class="">
                    <td><?php echo $this->admin_model->getAdmin($row->pm) ;?></td>
                    <td><?php echo $this->customer_model->getCustomer($row->customer) ;?></td>
                    <td><?php echo $row->project_name ;?></td>
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
										<td><?php echo $this->sales_model->getToolName($row->software);?></td>
										<td><?php echo $this->vendor_model->ticketTime($row->id).' H:M';?></td>
										<td><?php echo $this->vendor_model->getTicketStatus($row->status);?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<a href="<?php echo base_url()?>vendor/requesterTicketView?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-eye"></i> View Ticekt
											</a>
										</td>
									</tr>
						<?php
								}
						?>		
						</tbody>
					</table>
              		<nav class="text-center">
                         <?=$this->pagination->create_links()?>
                    </nav>
				</div>
			</div>
		</section>
	</div>
</div>