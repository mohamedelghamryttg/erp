<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Tickets Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/ticketsWithIssue" method="get" enctype="multipart/form-data">
				<?php 
				   if(isset($_REQUEST['request_type'])){
                    $request_type = $_REQUEST['request_type'];
                }else{
                    $request_type = "";
                }
                if(isset($_REQUEST['service'])){
                    $service = $_REQUEST['service'];
                }else{
                    $service = "";
                }
                if(isset($_REQUEST['status'])){
                    $status = $_REQUEST['status'];
                }else{
                    $status = "";
                }
                if(isset($_REQUEST['id'])){
                    $id = $_REQUEST['id'];
                }else{
                    $id = "";
                }
              	if(isset($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = "";
                }
				?>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Ticket Type</label>

                     <div class="col-lg-3">
                        <select name="request_type" class="form-control m-b" id="request_type" />
                                 <option disabled="disabled" selected="selected">-- Select Type --</option>
                                 <?=$this->vendor_model->selectTicketType($request_type)?>
                        </select>
                    </div>

                     <label class="col-lg-2 control-label" for="role Task Type">Service</label>

                    <div class="col-lg-3">
                        <select name="service" onchange="getService()" class="form-control m-b" id="service" />
                                <option disabled="disabled" selected="">-- Select Service --</option>
                                 <?=$this->admin_model->selectServices($service)?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Status">Status</label>

                    <div class="col-lg-3">
                        <select name="status" class="form-control m-b" id="status" />
                                <option disabled="disabled" selected="">-- Select Status --</option>
                                 <?=$this->vendor_model->selectAllTicketStatus($status)?>
                        </select>
                    </div>
          			
          			<label class="col-lg-2 control-label" for="role name">Ticket Number</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value="<?= $id?>" name="id">
                    </div>
                </div>
      			<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Requester Name">Requester Name</label>

                    <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by" />
                                <option disabled="disabled" selected="">-- Select Requester Name --</option>
                                 <?=$this->admin_model->selectAllPmAndSales($created_by,$this->brand)?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
					  <a href="<?=base_url()?>vendor/ticketsWithIssue" class="btn btn-warning">(x) Clear Filter</a> 
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
                                <th>Software</th>
                                <th>Taken Time</th>
                                <th>Status</th>
                                <th>Issues</th>
                                <th>Issue By</th>
                                <th>Created By</th>
                                <th>Created At</th>
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
<!--                    <td><?php echo $row->due_date ;?></td>-->
                    <td><?php echo $this->admin_model->getFields($row->subject);?></td>
                    <td><?php echo $this->sales_model->getToolName($row->software);?></td>
                    <td><?php echo $this->vendor_model->ticketTime($row->id).' H:M';?></td>
                    <td><?php echo $this->vendor_model->getTicketStatus($row->status);?></td>
                    <td><?php echo $row->issue ;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->issue_by) ;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
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