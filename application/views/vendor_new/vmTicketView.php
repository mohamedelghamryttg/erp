<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:"#content" });</script>
<script>tinymce.init({ selector:"#comment" });</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

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
<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Vm View Ticket </h3>
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
<!--                              <th>Due Date</th>-->
                              <th>Subject Matter</th>
                              <th>Software</th>
                              <th>File Attachment</th>
                              <th>Status</th>
                              <th>Created By</th>
                              <th>Created At</th> 
                        </tr>
                    </thead>
                           <tbody>
                              <tr>
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
<!--                                  <td><?php echo $row->due_date ;?></td>-->
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
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
              </div>