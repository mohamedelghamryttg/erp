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
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>dtp/doAddJob" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                            <input type="text" name="request_id" value="<?=base64_encode($task->id)?>" hidden="">
                  			<div class="form-group" style="overflow: scroll;">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                      <thead>
                                        <tr>
                                          <th>Task Code</th>
                                          <th>PM</th>
                                          <th>Task Name</th>
                                          <th>Task Type</th>
                                          <th>Product line</th>
                                          <th>Volume</th>
                                          <th>Unit</th>
                                          <th>Source Language</th>
                                          <th>Source Language Direction</th>
                                          <th>Target Language</th>
                                          <th>Target Language Direction</th>
                                          <th>Source Application</th>
                                          <th>Target Application</th>
                                          <th>Translatio In</th>
                                          <th>Rate</th>
                                          <th>File Attachment</th>
                                          <th>Start Delivery</th>
                                          <th>Delivery Date</th>
                                          <th>Request Date</th>
                                          <th>Status</th>
                                          <th>Created By</th>
                                          <th>Task Started At</th>
                                        </tr>
                                      </thead>
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
                                          <td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($task->id) ;?>" class="">DTP-<?=$task->id?></a></td>
                                          <td><?=$this->admin_model->getAdmin($task->created_by)?></td>
                                          <td><?=$task->task_name?></td>
                                          <td><?=$this->admin_model->getDTPTaskType($task->task_type)?></td>
                                          <td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
                                          <td><?=$task->volume?></td>
                                          <td><?=$this->admin_model->getUnit($task->unit)?></td>
                                          <td><?=$this->admin_model->getLanguage($source)?></td>
                                          <td><?=$this->admin_model->getDTPDirection($task->source_direction)?></td>
                                          <td><?=$this->admin_model->getLanguage($target)?></td>
                                          <td><?=$this->admin_model->getDTPDirection($task->target_direction)?></td>
                                          <td><?=$this->admin_model->getDTPApplication($task->source_application)?></td>
                                          <td><?=$this->admin_model->getDTPApplication($task->target_application)?></td>
                                          <td><?=$this->admin_model->getDTPApplication($task->translation_in)?></td>
                                          <td><?=$task->rate?></td>
                                          <td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                          <td><?=$task->start_date?></td>
                                          <td><?=$task->delivery_date?></td>
                                          <td><?=$task->created_at?></td>
                                          <td><?=$this->projects_model->getDTPTaskStatus($task->status)?></td>
                                          <td><?=$this->admin_model->getAdmin($task->status_by)?></td>
                                          <td><?=$task->status_at?></td>
                                        </tr>
                                      </tbody>
                                      </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role DTP">DTP</label>

                                <div class="col-lg-6">
                                    <select name="dtp" class="form-control m-b" id="dtp" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectAllDTP($this->brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectDTPTaskType($task->task_type)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Volume</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="volume" value="<?=$task->volume?>" onkeypress="return numbersOnly(event)" id="volume">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectUnit($task->unit)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Source Language Direction</label>

                                <div class="col-lg-6">
                                    <select name="source_direction" class="form-control m-b" id="source_direction" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectDTPDirection($task->source_direction)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Target Language Direction</label>

                                <div class="col-lg-6">
                                    <select name="target_direction" class="form-control m-b" id="target_direction" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectDTPDirection($task->target_direction)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Source Application</label>

                                <div class="col-lg-6">
                                    <select name="source_application" class="form-control m-b" id="source_application" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectDTPApplication($task->source_application)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Target Application</label>

                                <div class="col-lg-6">
                                    <select name="target_application" class="form-control m-b" id="target_application" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectDTPApplication($task->target_application)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Translatio In</label>

                                <div class="col-lg-6">
                                    <select name="translation_in" class="form-control m-b" id="translation_in" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectDTPApplication($task->translation_in)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class="form-control" name="file" id="file" accept="'application/zip'">
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
                                <label class="col-lg-3 control-label" for="insrtuctions">Cleint Instructions</label>

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