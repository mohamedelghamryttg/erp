<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                View Request 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <div class="form-group">
                    <div class="col-lg-12" id="LeadData" style="overflow:scroll;">
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th colspan="2">PM</th>
                                <td colspan="2"><?=$this->admin_model->getAdmin($task->created_by)?></td>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>Task Code</td>
                                    <td>Translation-<?=$task->id?></td>
                                    <td>Task Name</td>
                                    <td><?=$task->subject?></td>
                                </tr>
                                <tr>
                                    <td>Task Type</td>
                                    <td><?=$this->admin_model->getTaskType($task->task_type)?></td>
                                    <td>Product line</td>
                                    <td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
                                </tr>
                                <tr>
                                    <td>Volume</td>
                                    <td><?=$task->count?></td>
                                    <td>Unit</td>
                                    <td><?=$this->admin_model->getUnit($task->unit)?></td>
                                </tr>
                                <tr>
                                    <td>Source Language</td>
                                    <td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
                                    <td>Target Language</td>
                                    <td><?=$this->admin_model->getLanguage($priceListData->target)?></td>
                                </tr>
                                <tr>
                                    <td>File Attachment</td>
                                    <td colspan="3"><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                </tr>
                                <tr>
                                    <td>Start Delivery</td>
                                    <td><?=$task->start_date?></td>
                                    <td>Delivery Date</td>
                                    <td><?=$task->delivery_date?></td>
                                </tr>
                                <tr>
                                    <td>Request Date</td>
                                    <td><?=$task->created_at?></td>
                                    <td>Status</td>
                                    <td><?=$this->projects_model->getTranslationTaskStatus($task->status)?></td>
                                </tr>
                                <tr>
                                    <td>Created By</td>
                                    <td><?=$this->admin_model->getAdmin($task->status_by)?></td>
                                    <td>Task Started At</td>
                                    <td><?=$task->created_at?></td>
                                </tr>  
                                <tr>
                                    <td>Instructions</td>
                                    <td colspan="3"><?=$task->insrtuctions?></td>
                                </tr> 
                        </tbody>
                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
          <?php 
            $id = base64_decode($_GET['t']) ;
           $numOfJobs = $this->db->query("SELECT * FROM translation_request_job WHERE request_id = '$id'")->num_rows();
           if($numOfJobs == 0){ ?>
                <div class="row">
              <div class="col-lg-12">
               <section class="panel">
		            <header class="panel-heading">
		                Update Request to Waitting Confirmation 
		            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/updateTranslationRequestToWattingConfirmation" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($task->id)?>" readonly="">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role File Attachment">Action</label>
                             <div class="col-lg-3">
                                <select name="status" class="form-control m-b" id="status" required />
                                         <option disabled="disabled" selected=""></option>
                                         <option value="1">Waiting Confirmation</option>
                                </select>
                              </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-lg-3 control-label"></label>

                          <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
                        </div>
                    </form>
                </div>
                </div>
            </section>
        </div>
    </div>
          <?php } ?>
    <?php if($this->projects_model->checkCloseTranslationRequest($task->id) && $task->status != 3){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Request to Close Job 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/closeTranslationRequest" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($task->id)?>" readonly="">
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role File Attachment">Action</label>
                             <div class="col-lg-3">
                                <select name="status" class="form-control m-b" id="status" required />
                                         <option disabled="disabled" selected=""></option>
                                         <option value="3">Closed</option>
                                </select>
                              </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role Weighted Word Count">TM</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value="<?=$task->tm?>" name="tm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                            <div class="col-lg-6">
                                <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                            </div>
                        </div>
                       <div class="form-group">
                          <label class="col-lg-3 control-label" for="comment">Comment</label>

                          <div class="col-lg-8">
                            <textarea name="comment" class="form-control" value="" rows="6" ></textarea>
                          </div>
                        </div> 
                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="comment"></label>

                          <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
                    Task History 
                </header>
                
                <div class="panel-body">
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                    <tr>
                      <tr>
                      <th>Status</th>
                      <th>File Link</th>
                      <th>Comment</th>
                      <th>Created At</th>
                      <th>Created By</th>
                    </tr>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($history as $history) { ?>
                    <tr class="">
                        <td><?=$this->projects_model->getTranslationTaskStatus($history->status)?></td>
                        <td>
                            <?php if(strlen($history->file) > 0){ ?>
                            <a href="<?=base_url()?>assets/uploads/translationRequest/<?=$history->file?>">Click Here ..</a>
                            <?php } ?>
                        </td>
                        <td><?=$history->comment?></td>
                        <td><?=$history->created_at?></td>
                        <td><?=$this->admin_model->getAdmin($history->created_by)?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                </br>
            </section>
        </div>
    </div>


    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Task Response 
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
            
            </br></br>
                </div>
            <?php if($task->status != 3){ ?>
                <div class="panel-body">
                    <div class="form">
                        <form role="form" id="commentForm" action="<?php echo base_url()?>translation/requestRespone" method="post" enctype="multipart/form-data">
                          <input name="id" type="hidden" value="<?=base64_encode($task->id)?>" readonly="">
                         <div class="form-group">
                              <label class="col-lg-3 control-label" for="comment">Comment</label>

                              <div class="col-lg-6">
                                    <textarea name="comment" class="form-control" value="" rows="6"></textarea> 
                                    <input type="text" class=" form-control" name="flag" value="1" hidden="" >
                              </div>
                          </div>

                         <button type="submit" class="btn btn-primary">Submit</button>
                       </form>        
                    </div>
                </div>
            <?php } ?>
            </section>
        </div>
    </div>