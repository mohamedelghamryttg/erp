<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Vm View Ticket 
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

             <div class="panel-body" style="overflow: scroll;">
              <table class="table table-striped table-hover table-bordered" style="white-space: normal;">
                <thead>
                  <tr>
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
                      <tr>
                        <td>Comment</td>
                        <td colspan="20"><?=$row->comment?></td>
                      </tr>
                </tbody>
              </table>    
            </div>
            </section>
        </div>
    </div>


    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Ticket Response 
            </header>
            
            <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
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
            </br>
            <?php if($row->status != 4){ ?>
            <div class="col-lg-offset-3 col-lg-6">
                <a href="#myModal" data-toggle="modal" class="btn btn-primary" >Reply</a>
            </div>
            <?php } ?>
            </br></br>
                </div>
            </section>
        </div>
    </div>

	<!-- CV Request -->
    <?php if($row->request_type == 5){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Ticket Action 
            </header>
            
            <div class="panel-body">
                        <?php
                          $ticketData = $this->db->get_where('vm_ticket_resource',array('ticket' => $row->id))->row();
                              if(isset($ticketData->file)){
                        ?>
                        <input type="text" name="resource_row" value="<?=$ticketData->id?>" hidden="">
                        <div class="form-group">
                              <label class="col-lg-3 control-label" for="role name">Attachment</label>

                              <div class="col-lg-6">
                                  <a href="<?=base_url()?>assets/uploads/tickets/<?=$ticketData->file?>" target="_blank">Click Here ..</a>
                              </div>
                        </div>  
                        <?php } ?>
                  </form>
            </div>
        </section>
        </div>
    </div>
    <?php } ?>

    <!-- Resource Availabilty -->
    <?php if($row->request_type == 4){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Ticket Resources 
            </header>
            
            <div class="panel-body">

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
                          <div class="form-group" id="resouceNumber">
                                <label class="col-lg-3 control-label" for="role Product Lines">Number Of Resources</label>

                                <div class="col-lg-3">
                                    <?=$number?>
                                </div>
                          </div>
            </div>
        </section>
        </div>
    </div>
    <?php } ?>

    <!-- New Resource Or General -->
    <?php if($ticket_resource->num_rows() > 0 && ($row->request_type == 1 || $row->request_type == 3)){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Ticket Resources 
            </header>
            
            <div class="panel-body" style="overflow:scroll;">

                <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
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
                
            </div>
            </section>
        </div>
    </div>
    <?php } ?>

    <?php if($row->status == 5){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Ticket Action
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/confirmCloseTicket" method="post" enctype="multipart/form-data">

                        <input name="id" type="hidden" value="<?=base64_encode($id)?>" readonly="">

                        <div class="form-group">
                              <label class="col-lg-3 control-label" for="ticket status">
                              
                              </label>
                              <label class="col-lg-6 control-label" for="ticket status" style="text-align: left;color: red;">
                              VM send a request to close this ticket , you can accept close ticket by Choose Yes and confirm or you can re-open this ticket again by choose No and confirm ...
                              </label>
                          </div>

                        <div class="form-group">
                              <label class="col-lg-3 control-label" for="ticket status">Accept</label>
                              <div class="col-lg-6">
                                  <select name="accept" class="form-control m-b" id="accept" required />
                                           <option></option>
                                           <option value="1">Yes</option>
                                           <option value="2">No</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-offset-3 col-lg-6">
                                  <button class="btn btn-primary" type="submit">Confirm</button> 
                              </div>
                          </div>    
                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php } ?>

    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Ticket Log 
            </header>
            
            <div class="panel-body">
            <table class="table table-striped table-hover table-bordered">
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
                </div>
            </section>
        </div>
    </div>

    <!-- form of adding sam and brand to customer-->                                   
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                       <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                               <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                               <h4 class="modal-title">Add Your Response</h4>
                             </div>
                             <div class="modal-body" style="height: 214px;">

                             <form role="form" id="commentForm" action="<?php echo base_url()?>vendor/ticketRespone" method="post" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?=base64_encode($id)?>" readonly="">
                               <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" value="" rows="6"></textarea>
                                </div>
                            </div>

                               <button type="submit" class="btn btn-primary">Submit</button>
                             </form>
                         </div>
                       </div>
                     </div>
                  </div>