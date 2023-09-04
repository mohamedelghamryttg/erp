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
<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center mr-1">
									<!--begin::Page Heading-->
									<div class="d-flex align-items-baseline flex-wrap mr-5">
										<!--begin::Page Title-->
										<h2 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">HTML Table</h2>
										<!--end::Page Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
											<li class="breadcrumb-item text-muted">
												<a href="" class="text-muted">KTDatatable</a>
											</li>
											<li class="breadcrumb-item text-muted">
												<a href="" class="text-muted">Base</a>
											</li>
											<li class="breadcrumb-item text-muted">
												<a href="" class="text-muted">HTML Table</a>
											</li>
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page Heading-->
								</div>
								<!--end::Info-->
								
							</div>
						</div>
						<!--end::Subheader-->

						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
							
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
						  <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
					<div class="card-header">
						<h3 class="card-title">Tickets Filter</h3>
					</div>
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
						<form class="form"  id="tickets" action="<?php echo base_url()?>vendor/tickets" method="get" enctype="multipart/form-data">
						 <div class="card-body">

    						  <div class="form-group row">
        						   <label class="col-lg-2 control-label text-lg-right">Ticket Type:</label>
                        <div class="col-lg-3">
                            <select name="request_type" class="form-control m-b" id="request_type"/>
                                     <option  disabled="disabled" selected="selected">-- Select Type --</option>
                                    <?=$this->vendor_model->selectTicketType($request_type)?>
                            </select>
                        </div>
                        <label class="col-lg-2 col-form-label text-lg-right">Service:</label>
                         <div class="col-lg-3">
                          <select name="service" onchange="getService()" class="form-control m-b" id="service"/>
                                     <option  disabled="disabled" selected="selected">-- Select Service --</option>
                                     <?=$this->admin_model->selectServices($service)?>
                            </select>
                         </div> 
    						  </div> 
                  <div class="form-group row">
                       <label class="col-lg-2 col-form-label text-lg-right">Status:</label>
                           <div class="col-lg-3">
                               <select name="status" class="form-control m-b" id="status"/>
                                      <option disabled="disabled" selected="">-- Select Status --</option>
                                      <?=$this->vendor_model->selectAllTicketStatus($status)?>
                            </select> 
                           </div>  

                       <label class="col-lg-2 control-label text-lg-right" for="role name">Ticket Number:</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control"value="<?= $id?>" name="id" />
                        </div>
                  </div>
                  <div class="form-group row">
                       <label class="col-lg-2 col-form-label text-lg-right">Source:</label>
                           <div class="col-lg-3">
                             <select  name="source_lang" class="form-control m-b" id="source"/>
                                        <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                     <?=$this->admin_model->selectLanguage($source_lang)?>
                              </select>
                           </div>  

                       <label class="col-lg-2 control-label text-lg-right" for="role name">Target:</label>
                        <div class="col-lg-3">
                            <select name="target_lang" class="form-control m-b" id="target" />
                                     <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                     <?=$this->admin_model->selectLanguage($target_lang)?>
                            </select>
                        </div>
                  </div>
                  <div class="form-group row">
                       <label class="col-lg-2 col-form-label text-lg-right">Requester Name:</label>
                           <div class="col-lg-3">
                             <select name="created_by" class="form-control m-b" id="created_by" />
                                    <option disabled="disabled" selected="">-- Select Requester Name --</option>
                                     <?=$this->admin_model->selectAllPmAndSales($created_by,$this->brand)?>
                            </select>
                           </div>  

              </div>

						 
						 <div class="card-footer">
						  <div class="row">
						   <div class="col-lg-2"></div>
						   <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search" type="submit">Search</button>	
                           <button class="btn btn-secondary"  onclick="var e2 = document.getElementById('tickets'); e2.action='<?=base_url()?>vendor/exportTickets'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>	
                    	   <a href="<?=base_url()?>vendor/tickets" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

						   </div>
						  </div>
						 </div>
						</form>
                       </div>
                     </div>
                        
						  <!-- end search form -->
						
							<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Tickets List </h3>
                    </div>
                    <div class="card-toolbar">
                     
       
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
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
                                <th>Add Issues</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Ticekt</th>
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
                    <!--end: Datatable-->
                     <!--begin::Pagination-->
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                         <?=$this->pagination->create_links()?>  
                  </div>
                  <!--end:: Pagination-->
                  </div>
                </div>
                <!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->