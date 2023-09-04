<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                View Job 
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
                <div class="form">
                            
                            <div class="form-group">
                            <label class="col-lg-2 control-label" for="role name"></label>
                            <div class="col-lg-6" id="LeadData">
                    <table class="table table-striped table-hover table-bordered" id="">
                        <tbody>
                                <tr>
                                    <td>Task Code</td>
                                    <td>Translation-<?=$job->request_id?>-<?=$job->id?></td>
                                    <td>Assigned Translator</td>
                                    <td><?php echo $this->admin_model->getAdmin($job->translator) ;?></td>
                                </tr>
                                <tr>
                                    <td>Task Type</td>
                                    <td><?=$this->admin_model->getTaskType($job->task_type)?></td>
                                     <th>Count</th>
                                    <td><?=$job->count?></td>
                                </tr>
                                <tr>
                                    <td>Unit</td>
                                    <td><?=$this->admin_model->getUnit($job->unit)?></td>
                                    <th>Task File</th>
                                    <td><?php if(strlen($job->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationJob/<?=$job->file?>" target="_blank">Click Here</a><?php } ?></td>
                                </tr>
                                <tr>
                                    <td>Start Delivery</td>
                                    <td><?=$job->start_date?></td>
                                    <td>Delivery Date</td>
                                    <td><?=$job->delivery_date?></td>
                                </tr>
                                <tr>
                                    <td>Created Date</td>
                                    <td><?=$job->created_at?></td>
                                    <td>Status</td>
                                    <td><?=$this->projects_model->getTranslationJobStatus($job->status)?></td>
                                </tr>
                                <tr>
                                    <td>Closed Date</td>
                                    <td><?=$job->closed_date?></td>
                                </tr>  
                                <tr>
                                    <td>Instructions</td>
                                    <td colspan="3"><?=$job->insrtuctions?></td>
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

    <?php if($job->status == 0 && $job->translator == $this->user){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Task Action 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/jobAction" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="comment">Action</label>

                          <div class="col-lg-3">
                            <select name="action" class="form-control m-b" id="action" required />
                                    <option disabled="disabled" selected=""></option>
                                    <option value="1">Accept</option>
                                    <option value="3">Reject</option>
                            </select>
                          </div>
                          <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                    </form>
                </div>
                </div>
            </section>
        </div>
    </div>
    <?php } ?>

    <?php if($request->status == 2 && $job->status == 4 && $permission->follow == 2){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Update Final Count
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/updateFinalCount" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Count</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" name="updated_count" id="updated_count" required>
                                </div>
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

    <?php if(($job->status == 2 || $job->status == 4) && $request->status == 2 && $permission->follow == 2){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Re-Open Task
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/reopenJob" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                        
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

    <?php if($job->status == 1 && $job->translator == $this->user){ ?>
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Close Job 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/closeTranslatioJob" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role File Attachment">Action</label>
                             <div class="col-lg-3">
                                <select name="status" class="form-control m-b" id="status" required />
                                        <option disabled="disabled" selected=""></option>
                                        <option value="2">Closed</option>
                                        <option value="4">Partly Closed</option>
                                </select>
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
            <?php if($job->status != 2 && $job->status != 4){ ?>
                <div class="panel-body">
                    <div class="form">
                        <form role="form" id="commentForm" action="<?php echo base_url()?>translation/jobRespone" method="post" enctype="multipart/form-data">
                          <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
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
            <?php } ?>
            </section>
        </div>
    </div>

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
                        <td><?=$this->projects_model->getTranslationJobStatus($history->status)?></td>
                        <td>
                            <?php if(strlen($history->file) > 0){ ?>
                            <a href="<?=base_url()?>assets/uploads/translationJob/<?=$history->file?>">Click Here ..</a>
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