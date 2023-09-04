<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
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
        <section class="panel">
            <header class="panel-heading">
                Edit Vm Ticket 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doEditVmTicket" method="post" enctype="multipart/form-data">

                        <input name="id" type="hidden" value="<?=base64_encode($id)?>">
                        <input name="from_id" type="hidden" value="<?=$from_id?>">
                       <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Ticket Subject</label>
                                     
                                <div class="col-lg-6">
                                  <?php if(empty($row->ticket_subject)) {?>
                                    <input type="text" class=" form-control" value="<?php  echo  $this->db->query("SELECT project_name FROM `sales_opportunity` WHERE `id` = '$id' ")->row()->project_name;  ?>" name="ticket_subject" readonly="">
                                  <?php }else{ ?>
                                    <input type="text" class=" form-control" value="<?= $row->ticket_subject ?>" name="ticket_subject" readonly="">
                                 <?php } ?>
                                </div>
                            </div>
                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="Request Type">Request Type</label>
                                <div class="col-lg-6">
                                    <select name="request_type" onchange="ticketReqType()" class="form-control m-b" id="request_type" required />
                                             <option value="" selected="selected">-- Request Type --</option>
                                             <?=$this->vendor_model->selectTicketType($row->request_type)?>
                                    </select>
                                </div>
                            </div> 
                            <?php 
                            if($row->request_type == 1 || $row->request_type == 4 || $row->request_type == 5){
                              $style = "";
                              $required = "";
                            }else{
                              $style = "display:none;";
                              $required = "required";
                            }
                            ?>
                            <div class="form-group" id="resouceNumber" style="<?=$style?>">
                                <label class="col-lg-3 control-label" for="role Product Lines">Number Of Resources</label>

                                <div class="col-lg-3">
                                    <input maxlength="1" type="text" class=" form-control" name="number_of_resource" value="<?=$row->number_of_resource?>" id="number_of_resource" onkeypress="return numbersOnly(event)" <?=$required?> >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices($row->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTaskType($row->task_type,$row->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate"> Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" value="<?=$row->rate?>" class=" form-control" name="rate" data-maxlength="300" id="rate" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                               <label class="col-lg-3 control-label" for="Count"> Count</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" value="<?=$row->count?>" class=" form-control" name="count" data-maxlength="300" id="count" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($row->unit)?>
                                    </select>
                                </div>
                            </div>
      
      						<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($row->currency)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_lang" class="form-control m-b" id="source_lang" required />
                                             <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->source_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_lang" class="form-control m-b" id="target_lang" required />
                                             <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->target_lang)?>
                                    </select>
                                </div>
                            </div>
                      
                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" class="form_datetime form-control" value="<?=$row->start_date?>" name="start_date" id="start_date">
                              </div>
                          </div>
                                    
                                <div class="form-group">
                              <label class="control-label col-md-3">Delivery Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" class="form_datetime form-control" value="<?=$row->delivery_date?>" name="delivery_date" id="delivery_date">
                              </div>
                          </div>

<!--                           <div class="form-group">
                              <label class="control-label col-md-3">Due Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" class="form_datetime form-control" value="<?=$row->due_date?>" name="due_date" id="delivery_date">
                              </div>
                          </div>-->

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject" class="form-control m-b" id="subject" required />
                                             <option disabled="disabled" selected="selected">-- Select Subject --</option>
                                             <?=$this->admin_model->selectFields($row->subject)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Software">Software</label>

                                <div class="col-lg-6">
                                    <select name="software" class="form-control m-b" id="software" required />
                                            <option disabled="disabled" selected=""></option>
                                             <?=$this->sales_model->selectTools($row->software)?>
                                    </select>
                                </div>
                            </div>

                          <div class="form-group">
                              <label class="col-sm-3 control-label">Comment</label>
                              <div class="col-sm-6">
                                  <textarea name="comment" class="form-control" rows="6"><?=$row->comment?></textarea>
                              </div>
                          </div>
                           
                            
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>vendor/vmTicket?t=<?=$from_id?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>    

                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>