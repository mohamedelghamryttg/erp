<script>tinymce.init({ selector:'textarea' });</script>  
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

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              
<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Vm View Ticket</h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                    <tr>
                    <th>Ticket Number</th>
                    <th>Request Type</th>
                    <th>Number Of Rescource</th>
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
                    <th>File Attachment</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created At</th>
                  </tr>
             </thead>
         <tbody>
                <tr class="">
                        <input type="text" id="request_type" value="<?=$row->request_type?>" hidden="">
                        <input type="text" id="number_of_resource" value="<?=$row->number_of_resource?>" hidden="">
                        <td><?php echo $row->id ;?></td>
                        <td><?php echo $this->vendor_model->getTicketType($row->request_type) ;?></td>
                        <td><?php echo $row->number_of_resource ;?></td>
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
<!--                        <td><?php echo $row->due_date ;?></td>-->
                        <td><?php echo $this->admin_model->getFields($row->subject);?></td>
                        <td><?php echo $this->sales_model->getToolName($row->software);?></td>
                        <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/tickets/<?=$row->file?>" target="_blank">Click Here ..</a><?php } ?></td>
                        
                        <td><?php echo $this->vendor_model->getTicketStatus($row->status);?></td>
                        <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                        <td><?php echo $row->created_at ;?></td>
                      </tr>
                               
            </tbody>
              
                    </table>                  
                    <!--end: Datatable-->

                    <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-left">Comment</label>
               <div class="col-lg-10">
                 <?=$row->comment?>
               </div>  
                  </div>
                </div>
                <!--end::Card--> 
          </div>

       <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Ticket Response </h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                   <thead>
                        <tr>
                          <tr>
                          <th>Username</th>
                          <th>Response</th>
                          <th>Created At</th>
                        </tr>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($response as $response) { ?>
                        <tr class="">
                            <td><?=$this->admin_model->getAdmin($response->created_by)?></td>
                            <td><?=$response->response?></td>
                            <td><?=$response->created_at?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>                  
                    <!--end: Datatable-->

                    <?php if($row->status != 4){ ?>
                      <div class="col-lg-offset-3 col-lg-6">
                          <a href="#myModal" data-toggle="modal" class="btn btn-primary" >Reply</a>
                      </div>
                      <?php } ?>
                </div>
              </div>
                <!--end::Card--> 
            <?php if($row->request_type == 5){ ?>
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Ticket Action</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                     <?php
                          $ticketData = $this->db->get_where('vm_ticket_resource',array('ticket' => $row->id))->row();
                              if(isset($ticketData->file)){
                        ?>
                    <input name="resource_row" value="<?=$ticketData->id?>" hidden="">
                   <div class="card-body">
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Attachment:</label>
                            <div class="col-lg-6">
                               <a class="btn btn-success mr-2" href="<?=base_url()?>assets/uploads/tickets/<?=$ticketData->file?>" target="_blank">Click Here ..</a>
                            </div>
                        </div> 

                    </div>
                    <?php } ?>
                  
                  </div>
             </div>
            <?php } ?> 

                <!--end::Card--> 
                 
       <!--begin::Card-->
       <?php if($row->request_type == 4){ ?>
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Ticket Resources </h3>
                    </div>
                  </div>
                  <div class="card-body">
                     <?php
                          $ticketData = $this->db->get_where('vm_ticket_resource',array('ticket' => $row->id))->row();
                              if(isset($ticketData->number_of_resource)){
                                  $number = $ticketData->number_of_resource;
                        ?>
                     <input type="text" name="resource_row" value="<?=$ticketData->id?>" hidden="">
                        <?php
                              }else{
                                $number = "";
                              }
                        ?>
                         <div class="form-group row">

                           <label class="col-lg-2 col-form-label text-lg-left">Number Of Resources</label>
                           <div class="col-lg-10">
                              <?=$number?>
                           </div>  
                              </div>
                    
                </div>
              </div>
                  <?php } ?>

                <!--end::Card--> 

       <!-- New Resource Or General -->
        <?php if($ticket_resource->num_rows() > 0 && ($row->request_type == 1 || $row->request_type == 3)){ ?>
            <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Ticket Resources </h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                     <thead>
                                <tr>
                                  <th>Resource Type</th>
                                  <th>Source Language</th>
                                  <th>Target Language</th>
                                  <th>Dialect</th>
                                  <th>Service</th>
                                  <th>Task Type</th>
                                  <th>Unit</th>
                                  <th>Rate</th>
                                  <th>Currency</th>
                                  <th>Subject Matter</th>
                                  <th>Tools</th>
                                  <th>Created By</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($ticket_resource->result() as $ticket_resource) { 
                                $x=1;
                                $resource = $this->db->get_where('vendor',array('id'=>$ticket_resource->vendor))->row();
                                $sheet = $this->db->get_where('vendor_sheet',array('vendor'=>$resource->id,'ticket_id'=>$id,'i'=>$ticket_resource->id))->row(); 
                              ?>

                              <tr>
                                <td>
                                <?php if($ticket_resource->type == 1){echo "New Resource";}
                                      if($ticket_resource->type == 2){echo "Select Existing Resource";}
                                      if($ticket_resource->type == 3){echo "Select Existing Resource & Adding New Pair";}
                                ?>
                                </td>
                                <?php if($ticket_resource->type != 2){ ?>
                                <td><?=$this->admin_model->getLanguage($sheet->source_lang)?></td>
                                <td><?=$this->admin_model->getLanguage($sheet->target_lang)?></td>
                                <td><?=$sheet->dialect?></td>
                                <td><?=$this->admin_model->getServices($sheet->service)?></td>
                                <td><?=$this->admin_model->getTaskType($sheet->task_type)?></td>
                                <td><?=$this->admin_model->getUnit($sheet->unit)?></td>
                                <td><?=$sheet->rate?></td>
                                <td><?=$this->admin_model->getCurrency($sheet->currency)?></td>
                                <td>
                                <?php
                                $subjects = explode(",", $sheet->subject);
                                for ($i=0; $i < count($subjects); $i++) { 
                                  if($i > 0){echo " - ";}
                                  echo $this->admin_model->getFields($subjects[$i]);
                                 } 
                                ?>
                                </td>
                                <td>
                                <?php
                                $tools = explode(",", $sheet->tools);
                                for ($i=0; $i < count($tools); $i++) { 
                                  if($i > 0){echo " - ";}
                                  echo $this->sales_model->getToolName($tools[$i]);
                                 } 
                                ?>
                                </td>
                                <?php }else{ ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php } ?>
                                <td><?php echo $this->admin_model->getAdmin($ticket_resource->created_by) ;?></td>
                              </tr>
                              <?php } ?>
                              </tbody>
                    </table>                  
                    <!--end: Datatable-->
                </div>
              </div>
               <?php } ?>
                <!--end::Card--> 

                <?php if($row->status == 5){ ?>
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Ticket Action</h3>
                    </div>
                  </div>
                  <div class="card-body">
                     <!--begin::Form-->
                    <form class="form" id="commentForm"action="<?php echo base_url()?>vendor/confirmCloseTicket" method="post" enctype="multipart/form-data">
                       <input name="id" type="hidden" value="<?=base64_encode($id)?>" readonly="">
                       <div class="card-body">
                           <div class="form-group row">
                                <div class=""> <p class="col-lg-6 col-form-label text-right text-danger mx-auto"> VM send a request to close this ticket , you can accept close ticket by Choose Yes and confirm or you can re-open this ticket again by choose No and confirm ...:</p></div> 

                                  <div class="col-lg-6 mx-auto">
                                      <select name="accept" class="form-control" id="accept" required="">
                                           <option></option>
                                           <option value="1">Yes</option>
                                           <option value="2">No</option>>
                                      </select>
                                  </div>
                              </div> 
                        </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-lg-3"></div>
                          <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Confirm</button>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!--end::Form-->
                  
                  </div>
              
             </div>
              <?php } ?> 
                <!--end::Card--> 
                 
         <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Ticket Log </h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                       <thead>
                        <tr>
                          <tr>
                          <th>Username</th>
                          <th>Ticket Status</th>
                          <th>Created At</th>
                        </tr>
                        </tr>
                      </thead>
                      <tbody>
                      <tr class="">
                        <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                        <td><span class="badge badge-danger p-2" style="background-color: #fb0404">New</span></td>
                        <td><?=$row->created_at?></td>
                      </tr>
                      <?php foreach ($log as $log) { ?>
                        <tr class="">
                            <td><?=$this->admin_model->getAdmin($log->created_by)?></td>
                            <td><?=$this->vendor_model->getTicketStatus($log->status)?></td>
                            <td><?=$log->created_at?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>                  
                    <!--end: Datatable-->
                </div>
              </div>
           <!--end::Card--> 
            <!--begin::Card-->
            <!-- form of adding sam and brand to customer--> 
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                       <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                               <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                               <h4 class="modal-title">Add Your Response</h4>
                             </div>
                             <div class="modal-body">

                             <form class="form"role="form" id="commentForm" action="<?php echo base_url()?>vendor/ticketRespone" method="post" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?=base64_encode($id)?>" readonly="">
                               <div class="form-group">
                                <label class="col-lg-2 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" value=""></textarea>
                                </div>
                            </div>

                               <button type="submit" class="btn btn-primary">Submit</button>
                             </form>
                         </div>
                       </div>
                     </div>
                  </div>
           <!--end::Card--> 










              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->