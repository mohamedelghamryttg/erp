<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Vm Ticket 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doAddVmTicket" onsubmit="return checkResouceNumber();disableAddButton();" method="post" enctype="multipart/form-data">

                        <input name="from_id" type="hidden" value="<?=$from_id?>">
                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Ticket Subject</label>
                                     
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php  echo  $this->db->query("SELECT project_name FROM `sales_opportunity` WHERE `id` = '$id' ")->row()->project_name;  ?>" name="ticket_subject" readonly="">
                                </div>
                            </div>
                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="Request Type">Request Type</label>
                                <div class="col-lg-6">
                                    <select name="request_type" onchange="ticketReqType()" class="form-control m-b" id="request_type" required />
                                             <option value="" selected="selected">-- Request Type --</option>
                                             <?=$this->vendor_model->selectTicketType()?>
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group" id="resouceNumber">
                                <label class="col-lg-3 control-label" for="role Product Lines">Number Of Resources</label>

                                <div class="col-lg-3">
                                    <input maxlength="1" type="text" class=" form-control" onblur="return checkResouceNumber()" name="number_of_resource" id="number_of_resource" onkeypress="return numbersOnly(event)" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" value="" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" value="" selected=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate"> Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" class=" form-control" name="rate" data-maxlength="300" id="rate" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                               <label class="col-lg-3 control-label" for="Count"> Count</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" class=" form-control" name="count" data-maxlength="300" id="count" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" value="" selected="selected">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit()?>
                                    </select>
                                </div>
                            </div>
      			
      						<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" value="" selected="selected">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_lang" class="form-control m-b" id="source_lang" required />
                                             <option disabled="disabled" value="" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_lang" class="form-control m-b" id="target_lang" required />
                                             <option disabled="disabled" value="" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>
                      
                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" required="" value="<?=date("Y-m-d H:i:s")?>" autocomplete="off" class="form_datetime form-control" onchange="checkDate('start_date');" name="start_date" id="start_date">
                              </div>
                          </div>
                                    
                          <div class="form-group">
                              <label class="control-label col-md-3">Delivery Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" required="" autocomplete="off" class="form_datetime form-control" onchange="checkDate('delivery_date');" name="delivery_date" id="delivery_date">
                              </div>
                          </div>

<!--                          <div class="form-group">
                              <label class="control-label col-md-3">Due Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text"  autocomplete="off" class="form_datetime form-control" onchange="checkDate('due_date');" name="due_date" id="due_date">
                              </div>
                          </div>-->

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject" class="form-control m-b" id="subject" required />
                                             <option disabled="disabled" value="" selected="selected">-- Select Subject --</option>
                                             <?=$this->admin_model->selectFields()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Software">Software</label>

                                <div class="col-lg-6">
                                    <select name="software" class="form-control m-b" id="software" required />
                                            <option disabled="disabled" value="" selected=""></option>
                                             <?=$this->sales_model->selectTools()?>
                                    </select>
                                </div>
                            </div>

							<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file">
                                </div>
                            </div>

                          <div class="form-group">
                              <label class="col-sm-3 control-label">Comment</label>
                              <div class="col-sm-6">
                                  <textarea name="comment" class="form-control" rows="6"></textarea>
                              </div>
                          </div>
                           
                            
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>vendor/vmTicket?t=<?=$from_id?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>    

                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    