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
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/doAddJob" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                            <input type="text" name="request_id" value="<?=base64_encode($task->id)?>" hidden="">
                  			<div class="form-group" style="overflow: scroll;">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                                        <thead>
                                            <tr>
                                                 <th>Task Code</th>
                                                <th>Task Subject</th>
                                                <th>Task Type</th>
                                                 <th>Count</th>
                                                 <th>Unit</th>
                                                 <th>Start Date</th>
                                                 <th>Delivery Date</th>
                                                 <th>Task File</th>
                                                 <th>Status</th>
                                                 <th>Request Date</th>
                                                 <th>Requested By</th>
                                                 <th>Closed Date</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr class="">
                                               <td><a href="<?php echo base_url()?>translation/TranslationJobs?t=<?php echo base64_encode($task->id) ;?>" class="">Translation-<?=$task->id?></a></td>
                                            <td><?php echo $task->subject ;?></td>
                                            <td><?php echo $this->admin_model->getTaskType($task->task_type);?></td>
                                            <td><?php echo $task->count ;?></td>
                                            <td><?php echo $this->admin_model->getUnit($task->unit) ;?></td>
                                            <td><?php echo $task->start_date ;?></td>
                                            <td><?php echo $task->delivery_date ;?></td>
                                            <td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                            <td><?php echo $this->projects_model->getTranslationTaskStatus($task->status) ;?></td>
                                            <td><?php echo $task->created_at ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
                                            <td><?php echo $task->closed_date ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->status_by) ;?></td>
                                            <td><?php echo $task->status_at ;?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Translator">Translator</label>

                                <div class="col-lg-6">
                                    <select name="translator" class="form-control m-b" id="translator" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectAllTranslator($this->brand,$this->user)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTaskType(0,1)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Count</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" name="count" id="count" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectUnit($task->unit)?>
                                    </select>
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
                                  <input size="16" type="text" onchange="checkDate('delivery_date')" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="">
                              </div>
                          </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
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