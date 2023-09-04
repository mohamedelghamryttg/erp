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
<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">View Job</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
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
                                     <td><?=$job->count?>
                                         <?php if($request->status == 2 && $permission->follow == 2 && $this->role == 28){ ?>
                                         <button class="edit btn ml-3" onclick="changeCount();" id="countNum"><i class="fa fa-edit"></i></button>
                                         <form class="form" id="countForm"action="<?php echo base_url()?>translation/updateCount" method="post" style="display: none" >
                                                <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                                                <input name="count" class="form-control-sm" value="<?=$job->count?>">
                                                <button type="submit" class="btn btn-success btn-sm mr-1">Save</button>
                                                <a class="btn btn-danger btn-sm " onclick="ClearUpdateCount()">Cancel</a>

                                          </form>
                                         <?php }?>
                                     </td>
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
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
         <?php if($job->status == 0 && $job->translator == $this->user){ ?>
                <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Task Action</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                   <!--begin::Form-->
            <form class="form" action="<?php echo base_url()?>translation/jobAction" method="post" enctype="multipart/form-data">
                  <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                 <div class="card-body">
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Action:</label>

                            <div class="col-lg-6">
                                <select name="action" class="form-control" id="action" required="">
                                    <option disabled="disabled" selected=""></option>
                                    <option value="1">Accept</option>
                                    <option value="3">Reject</option>
                                </select>
                            </div>
                        </div> 

                    </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
                  </div>
                </div>
                <!--end::Card--> 
                <?php } ?>  
<!--when request status is running & job(task) is partly closed-->
<?php if($request->status == 2 && $job->status == 4 && $permission->follow == 2){ ?>
       <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Update Final Count</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                       <!--begin::Form-->
            <form class="form" action="<?php echo base_url()?>translation/updateFinalCount" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                 <div class="card-body">
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Count:</label>
                            <div class="col-lg-6">
                               <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" name="updated_count" id="updated_count" required>
                            </div>
                        </div> 

                    </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
                  </div>
                </div>
                <!--end::Card-->
     <?php } ?> 



       <?php if(($job->status == 2 || $job->status == 4) && $request->status == 2 && $permission->follow == 2){ ?>
       <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Re-Open Task</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                       <!--begin::Form-->
            <form class="form" action="<?php echo base_url()?>translation/reopenJob" method="post" enctype="multipart/form-data">
                         <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                 <div class="card-body">
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="Division">File Attachment:</label>

                            <div class="col-lg-6">
                              <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">

                            </div>
                        </div> 

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="comment">Comment:</label>

                            <div class="col-lg-6">
                            <textarea name="comment" class="form-control" value="" rows="6" ></textarea>

                            </div>
                        </div> 


                    </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
                  </div>
                </div>
                <!--end::Card-->
     <?php } ?> 

     <?php if($job->status == 1 && $job->translator == $this->user){ ?>
        <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Close Job</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                    <!--begin::Form-->
                  <form class="form"  action="<?php echo base_url()?>translation/closeTranslatioJob" method="post" enctype="multipart/form-data">
                     <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                     <div class="card-body">
                                  <div class="form-group row">
                                        <label class="col-lg-3 col-form-label text-right" for="Division">Action:</label>

                                        <div class="col-lg-6">
                                            <select name="status" class="form-control" id="status" required="">
                                                <option disabled="disabled" selected=""></option>
                                                <option value="2">Closed</option>
                                                <option value="4">Partly Closed</option>
                                            </select>
                                        </div>
                                    </div>  
                                     <div class="form-group row">
                                        <label class="col-lg-3 col-form-label text-right" for="Division">File Attachment:</label>

                                        <div class="col-lg-6">
                                          <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">

                                        </div>
                                    </div> 

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label text-right" for="comment">Comment:</label>

                                        <div class="col-lg-6">
                                        <textarea name="comment" class="form-control" value="" rows="6" ></textarea>

                                        </div>
                                    </div> 

                      </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                          <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!--end::Form-->
                  </div>
                </div>
                <!--end::Card--> 
    <?php } ?>  
     <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Task Response</h3>
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
                 <?php  if($job->status != 2 && $job->status != 4){ ?>

                     <!--begin::Form-->
                  <form class="form" id="commentForm" action="<?php echo base_url()?>translation/jobRespone" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=base64_encode($job->id)?>" readonly="">
                     <div class="card-body">
                                 <div class="form-group row">
                                        <label class="col-lg-3 col-form-label text-right" for="comment">Comment:</label>

                                        <div class="col-lg-6">
                                        <textarea name="comment" class="form-control" value="" rows="6" ></textarea>

                                        </div>
                                    </div> 

                      </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                          <button type="submit" class="btn btn-success mr-2">Submit</button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!--end::Form-->
                   <?php  } ?>

                  </div>
                </div>
                <!--end::Card-->  

                <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Task History</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
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
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card--> 
<script>
    function changeCount(){
        $("#countNum").hide();
        $("#countForm").show();
    }
     function ClearUpdateCount(){
        $("#countNum").show();
        $("#countForm").hide();
    }
    
</script>