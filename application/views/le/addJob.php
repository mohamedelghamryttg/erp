<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Job 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>le/doAddJob" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                            <input type="text" name="request_id" value="<?=base64_encode($task->id)?>" hidden="">
                  			<div class="form-group" style="overflow: scroll;">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                          <tr>
                                            <th>Task Code</th>
                                            <th>Task Name</th>
                                            <th>Task Type</th>
                                            <th>Subject Matter</th>
                                            <th>Product Line</th>
                                            <th>Linguist Format</th>
                                            <th>Deliverable Format</th>
                                            <th>Unit</th>
                                            <th>Volume</th>
                                            
                                            <th>Source Language</th>
                                            <th>Target Language</th>
                                           <th>Start Date</th>
                                           <th>Delivery Date</th>
                                           <th>Task File</th>
                                           <th>Status</th>
                                           <th>Request Date</th>
                                           <th>Requested By</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>View Request</th>
                                          </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <tr class="">
                                            <td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($task->id) ;?>" class="">LE-<?=$task->id?></a></td>
                                              <td><?php echo $task->subject ;?></td>
                                            <td><?php echo $this->admin_model->getLETaskType($task->task_type);?></td>
                                            <td><?php echo $this->admin_model->getLESubject($task->subject_matter);?></td>
                                            <td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
                                          <?php if(is_numeric($task->linguist) && is_numeric($task->deliverable)){ ?>
                                            <td><?php echo $this->admin_model->getLeFormat($task->linguist);?></td>
                                            <td><?php echo $this->admin_model->getLeFormat($task->deliverable);?></td>
                                          <?php }else{ ?>
                                            <td><?=$task->linguist ?></td>
                                            <td><?=$task->deliverable ?></td>
                                          <?php } ?>  
                                            <td><?php echo $this->admin_model->getUnit($task->unit);?></td>
                                            <td><?=$task->volume?></td>
                                           
                                       
                                            <td><?php echo $this->admin_model->getLanguage($priceListData->source);?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceListData->target);?></td>
                                            <td><?php echo $task->start_date ;?></td>
                                            <td><?php echo $task->delivery_date ;?></td>
                                            <td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                            <td><?php echo $this->projects_model->getTranslationTaskStatus($task->status) ;?></td>
                                            <td><?php echo $task->created_at ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->status_by) ;?></td>
                                            <td><?php echo $task->status_at ;?></td>
                                            <td>
                                              <a href="<?php echo base_url()?>le/viewRequest?t=<?php echo 
                                                base64_encode($task->id) ;?>" class="">
                                                  <i class="fa fa-eye"></i> View Request
                                              </a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Assigned LE">Assigned LE</label>

                                <div class="col-lg-6">
                                    <select name="le" class="form-control m-b" id="le" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectAllLE($this->brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLETaskType($task->task_type)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject_matter" class="form-control m-b" id="subject_matter" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLESubject($task->subject_matter)?>
                                    </select>
                                </div>
                            </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Linguist Format</label>
                             
                                <div class="col-lg-6">
                                    <select name="linguist_format" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLeFormat($task->linguist)?>
                                    </select>
                                </div>
                          </div>

                          <div class="form-group">
                              <label class="control-label col-md-3">Deliverable Format</label>
                              
                                <div class="col-lg-6">
                                    <select name="deliverable_format" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLeFormat($task->deliverable)?>
                                    </select>
                                </div>
                          </div>
                            <div class="form-group">
                              <label class="control-label col-md-3">Unit</label>
                             
                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLeUnit($task->unit)?>
                                    </select>
                                </div>
                          </div> 
                           <div class="form-group">
                                <label class="col-lg-3 control-label" for="insrtuctions">Volume</label>

                                <div class="col-lg-6">
                                      <input type="text" name="volume" value="<?= $task->volume?>" class="form-control" rows="6"></input>
                                </div>
                            </div>
                              
                    
                            
                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" onchange="checkDate('start_date')" value="<?=date("Y-m-d H:i:s")?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="control-label col-md-3">Delivery Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" onchange="checkDate('delivery_date')" value="<?=$task->delivery_date?>" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="">
                              </div>
                          </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role TTG TM usage">TTG TM usage</label>

                                <div class="col-lg-6">
                                    <select name="tm_usage" class="form-control m-b" id="tm_usage" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?php if($task->tm_usage == 1){ ?>
                                            <option value="1" selected="">Yes</option>
                                            <option value="0">No</option>
                                            <?php }else{ ?>
                                            <option value="1">Yes</option>
                                            <option value="0" selected="">No</option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="insrtuctions">Instructions</label>

                                <div class="col-lg-6">
                                      <textarea name="insrtuctions" class="form-control" rows="6"></textarea>
                                </div>
                            </div> 
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>