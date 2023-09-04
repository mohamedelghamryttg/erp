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
            <!--begin::Subheader-->
            <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
              <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                
                
              </div>
            </div>
            <!--end::Subheader-->

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              
<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">View Request</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    
                        <tbody>
                            <?php
                                   if($task->source_language == 0){
                                      $source = $priceListData->source;
                                      $target = $priceListData->target;
                                  }else{
                                      $source = $task->source_language;
                                      $target = $task->target_language;
                                  }
                             ?> 
                             <tr>
                                <th colspan="2">PM</th>
                                <td colspan="2"><?=$this->admin_model->getAdmin($task->created_by)?></td>
                            </tr>
                                <tr>
                                    <td>Task Name</td>
                                    <td><?=$task->task_name?></td>
                                    <td>Task Type</td>
                                    <td><?=$this->admin_model->getDTPTaskType($task->task_type)?></td>
                                </tr>
                                <tr>
                                    <td>Product line</td>
                                    <td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
                                    <td>Created Date</td>
                                    <td><?=$task->created_at?></td>
                                </tr>
                                <tr>
                                    <td>Volume</td>
                                    <td><?=$task->volume?></td>
                                    <td>Unit</td>
                                    <td><?=$this->admin_model->getUnit($task->unit)?></td>
                                </tr>
                                <tr>
                                    <td>Source Language</td>
                                    <td><?=$this->admin_model->getLanguage($source)?></td>
                                    <td>Source Language Direction</td>
                                    <td><?=$this->admin_model->getDTPDirection($task->source_direction)?></td>
                                </tr>
                                <tr>
                                    <td>Target Language</td>
                                    <td><?=$this->admin_model->getLanguage($target)?></td>
                                    <td>Target Language Direction</td>
                                    <td><?=$this->admin_model->getDTPDirection($task->target_direction)?></td>
                                </tr>
                                <tr>
                                    <td>Source Application</td>
                                    <td><?=$this->admin_model->getDTPApplication($task->source_application)?></td>
                                    <td>Target Application</td>
                                    <td><?=$this->admin_model->getDTPApplication($task->target_application)?></td>
                                </tr>
                                <tr>
                                    <td>Rate</td>
                                    <td><?=$task->rate?></td>
                                    <td>Translatio In</td>
                                    <td><?=$this->admin_model->getDTPApplication($task->translation_in)?></td>
                                </tr>
                                <tr>
                                    <td>File Attachment</td>
                                    <td colspan="3">
                                        <?php if(strlen($task->file) > 1){ ?>
                                            <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/dtpRequest/",$task->file,$task->start_after_type) ?>" target="_blank">Click Here</a>
                                       <?php } else{
                                            if($task->start_after_id != null && $task->start_after_type == "Vendor"){?>
                                                <?= $this->projects_model->getTaskVendorNotes($task->start_after_id)?>
                                        <?php }} ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Start Delivery</td>
                                    <td><?=$task->start_date?></td>
                                    <td>Delivery Date</td>
                                    <td><?=$task->delivery_date?></td>
                                </tr>
                                <tr>
                                    <td>Instructions</td>
                                    <td colspan="3"><?=$task->insrtuctions?></td>
                                </tr>
                                <?php if(strlen($jobData->job_file) > 1){ ?>
                                <tr>
                                    <td>Job Files</td>
                                    <td colspan="3"><a href="<?=base_url()?>assets/uploads/jobFile/<?=$jobData->job_file?>" target="_blank"><?=$jobData->job_file_name?></a></td>
                                </tr>      
                                <?php }?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
<?php if($this->projects_model->checkCloseDTPRequest($task->id) && $task->status != 3){ ?>
      <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label"> Request to Close Job</h3>
                    </div>
                   
                  </div>
                  <div class="card-body">
                    <!--begin::Form-->
            <form class="form" action="<?php echo base_url()?>dtp/closeDtprequest" method="post" enctype="multipart/form-data">
               <input name="id" type="hidden" value="<?=base64_encode($task->id)?>" readonly="">
               <div class="card-body">
                            <div class="form-group row">
                                  <label class="col-lg-3 col-form-label text-right" >Action:</label>

                                  <div class="col-lg-6">
                                      <select name="status" class="form-control" id="status" required="">
                                         <option disabled="disabled" selected=""></option>
                                        <option value="3">Closed</option>
                                      </select>
                                  </div>
                              </div>  
                               <div class="form-group row">
                                  <label class="col-lg-3 col-form-label text-right" >File Attachment:</label>

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
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
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
                        <td><?=$this->projects_model->getTranslationTaskStatus($history->status)?></td>
                        <td>
                            <?php if(strlen($history->file) > 0){ ?>
                            <a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$history->file?>">Click Here ..</a>
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
                 <?php if($task->status != 3){ ?>

                     <!--begin::Form-->
            <form class="form" id="commentForm" action="<?php echo base_url()?>dtp/requestRespone" method="post" enctype="multipart/form-data">
                          <input name="id" type="hidden" value="<?=base64_encode($task->id)?>" readonly="">
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
             <?php } ?>

                  </div>
                </div>
                <!--end::Card--> 
            
              </div>
            </div> 
          </div>