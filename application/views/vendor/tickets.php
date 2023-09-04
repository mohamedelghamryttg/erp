<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php
      $total = $this->vendor_model->getTicketStatusNum($brand);
      ?>
      <div class="row">
        <div class="col-lg-3 col-xs-3" style="background-color: #5e5e5d;color: white; ">
          <!-- small box -->
          	<div>
	            <div class="inner">
	              <h3><?=$total['new']?></h3>

	              <p>New Tickets</p>
	            </div>
        	</div>
        </div>

        <div class="col-lg-3 col-xs-3" style="background-color: #07b817;color: white; ">
          <!-- small box -->
          	<div>
	            <div class="inner">
	              <h3><?=$total['opened']?></h3>

	              <p>Opened Tickets</p>
	            </div>
        	</div>
        </div>

        <div class="col-lg-3 col-xs-3" style="background-color: #e8e806;color: white; ">
          <!-- small box -->
          	<div>
	            <div class="inner">
	              <h3><?=$total['part_closed']?></h3>

	              <p>Partly Closed Tickets</p>
	            </div>
        	</div>
        </div>

        <div class="col-lg-3 col-xs-3" style="background-color: #fb0404;color: white; ">
          <!-- small box -->
          	<div>
	            <div class="inner">
	              <h3><?=$total['closed']?></h3>

	              <p>Closed</p>
	            </div>
        	</div>
        </div>

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Tickets Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="tickets" action="<?php echo base_url()?>vendor/tickets" method="get" enctype="multipart/form-data">
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
                if(isset($_REQUEST['source_lang'])){
                    $source_lang = $_REQUEST['source_lang'];
                }else{
                    $source_lang = "";
                }
                if(isset($_REQUEST['target_lang'])){
                    $target_lang = $_REQUEST['target_lang'];
                }else{
                    $target_lang = "";
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
                    	<input type="text" class="form-control"value="<?= $id?>" name="id">
                    </div>
                </div>

              <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Source</label>

                    <div class="col-lg-3">
                      <select name="source_lang" class="form-control m-b" id="source" />
                                 <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                 <?=$this->admin_model->selectLanguage($source_lang)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role Task Type">Target</label>

                    <div class="col-lg-3">
                        <select name="target_lang" class="form-control m-b" id="target" />
                                 <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                 <?=$this->admin_model->selectLanguage($target_lang)?>
                        </select>
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

                    <label class="col-lg-2 control-label" for="role Software">Software</label>

                    <div class="col-lg-3">
                        <select name="software" class="form-control m-b" id="software" required />
                                <option disabled="disabled" selected="">-- Select Software --</option>
                                 <?=$this->sales_model->selectTools()?>
                        </select>
                </div>
            </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Date From">Date From</label>

                    <div class="col-lg-3">
                        <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                    </div>

                    <label class="col-lg-2 control-label" for="role Date To">Date To</label>

                    <div class="col-lg-3">
                       <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                       <button class="btn btn-success" onclick="var e2 = document.getElementById('tickets'); e2.action='<?=base_url()?>vendor/exportTickets'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                      <a href="<?=base_url()?>vendor/tickets" class="btn btn-warning">(x) Clear Filter</a> 
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
                               <!-- <th>Issues</th>-->
                                <th>Add Issues</th>
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

                   <!-- <td><?php //echo $row->issue ;?></td>-->
                    <td rowspan="" style="border: 1px solid #ddd;"><a href="#myModal2<?php echo $row->id ?>" data-toggle="modal" class="btn btn-danger" >Write Issue</a></td>


										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
                    <td>
                    <?php if($row->status == 1){ ?>
                    <a href="#myModal<?php echo $row->id ;?>" data-toggle="modal" class="btn btn-success" >View Ticekt </a>
                    <?php }elseif ($row->status == 0) { ?>

                    <?php }else{ ?>
                    <a href="<?=base_url()?>vendor/vmTicketView?t=<?php echo base64_encode($row->id) ;?>" class="">
                        <i class="fa fa-eye"></i> Open Ticekt
                      </a>
                    <?php } ?>
                    </td>
									</tr> 

               <!-- start pop up form -->
        <div aria-hidden="true" aria-labelledby="myModalLabel2" role="dialog" tabindex="-1" id="myModal2<?php echo $row->id;?>" class="modal fade">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                         <h4 class="modal-title">Write Issue</h4>
                     </div>
                     <div class="modal-body">

                      <input name="customer" id="ticket_<?=$row->id?>" type="hidden" value="<?php echo $row->id;?>" >
                      <textarea name="issue"id="issue_<?=$row->id?>" class="form-control" style="margin-bottom:15px;" value="" rows="6" ></textarea>
                    
                     <button class="btn btn-default"  type="submit" aria-hidden="true" data-dismiss="modal" class="close" onclick="addIssueToVendorTicket(<?=$row->id?>)">Submit</button>
               </div>
             </div>
           </div>
         </div>
            <!-- end pop up form -->

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




<?php
              foreach($ticket->result() as $row)
                {
            ?>
              <!-- Modal-->                                   
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal<?php echo $row->id;?>" class="modal fade">
                       <div class="modal-dialog">
                         <div class="modal-content " style="width:600px;">
                             <div class="modal-header">
                           <h4 class="modal-title">New Ticket</h4>
                               <button aria-hidden="true" data-dismiss="modal" class="close text-danger" type="button" style="color:red !important;">×</button>
                             </div>
                             <div class="modal-body">
                               


                       <table class="table table-striped table-hover table-bordered " style="white-space: normal;" id="">
               
                        <tbody>
                            
                                <tr>
                                    <td>Ticket Number</td>
                                    <td><?php echo $row->id ;?></td>
                                    <td>Request Type</td>
                                    <td><?php echo $this->vendor_model->getTicketType($row->request_type) ;?></td>
                                </tr>
                                <tr>
                                    <td>Number Of Rescource</td>
                                    <td><?php echo $row->number_of_resource ;?></td>
                                    <td>Service</td>
                                    <td><?php echo $this->admin_model->getServices($row->service);?></td>
                                </tr>
                                <tr>
                                    <td>Task Type</td>
                                    <td><?php echo $this->admin_model->getTaskType($row->task_type);?>
                                    </td>
                                    <td>Rate</td>
                                    <td><?php echo $row->rate ;?></td>
                                </tr>
                                <tr>
                                    <td>Count</td>
                                    <td><?php echo $row->count ;?></td>
                                    <td>Unit</td>
                                    <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                                </tr>
                                <tr>
                                    <td>Currency</td>
                                    <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                                    <td>Source Language</td>
                                    <td><?php echo $this->admin_model->getLanguage($row->source_lang) ;?></td>
                                </tr>

                               <tr>
                                    <td>Target Language</td>
                                    <td><?php echo $this->admin_model->getLanguage($row->target_lang) ;?></td>
                                    <td>Start Date</td>
                                    <td><?php echo $row->start_date ;?></td>
                                </tr>

                                <tr>
                                    <td>Delivery Date</td>
                                    <td colspan="3"><?php echo $row->delivery_date ;?></td>
<!--                                    <td>Due Date</td>
                                    <td><?php echo $row->due_date ;?></td>-->
                                </tr>


                                <tr>
                                    <td>Subject Matter</td>
                                    <td><?php echo $this->admin_model->getFields($row->subject);?></td>
                                    <td>Software</td>
                                    <td><?php echo $this->sales_model->getToolName($row->software);?></td>
                                </tr>


                                <tr>
                                    <td>File Attachment</td>
                                    <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/tickets/<?=$row->file?>" target="_blank">Click Here ..</a><?php } ?></td>
                                    <td>Status</td>
                                    <td><?php echo $this->vendor_model->getTicketStatus($row->status);?></td>
                                </tr>

                              <tr>
                                    <td>Created By</td>
                                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                              		<td>Created At</td>
                                    <td><?php echo $row->created_at ;?></td>
                                </tr>

                              <tr>
                                   <td>Comment</td>
                                    <td colspan="3"><?php echo $row->comment ;?></td>
                                </tr> 
                             
                        </tbody>
                    </table>
                          <form action="<?=base_url()?>vendor/rejectTicekt?t=<?php echo base64_encode($row->id) ;?>" method="post">
                            
                          
                          <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                    <textarea name="comment" id="content" required="" cols="50"></textarea>
                                </div>
                            </div>
              <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <a class="btn btn-primary" href="<?=base_url()?>vendor/vmTicketView?t=<?php echo base64_encode($row->id) ;?>">View Ticket</a> 
                      <input type="submit" name="reject" class="btn btn-primary" style="background-color: red;color: white;" value="Reject">
                    </div>
                  </div>
                      </form>
                  </div>
              </div>
      </div>


                         </div>
                       
                     

                  <!--Modal-->
                  <?php } ?>
