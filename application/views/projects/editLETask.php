<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Request 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doEditLETask" method="post" enctype="multipart/form-data">
                            <input type="text" name="job_id" value="<?=base64_encode($job)?>" hidden="">
                            <input type="text" name="task" value="<?=base64_encode($task->id)?>" hidden="">
                  			<div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                                        <thead>
                                            <tr>
                                                 <th>Job Code</th>
                                                 <th>Product Line</th>
                                                 <th>Service</th>
                                                 <th>Source</th>
                                                 <th>Target</th>
                                                 <th>Volume</th>
                                                 <th>Rate</th>
                                                 <th>Total Revenue</th>
                                                 <th>Currency</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr class="">
                                                <td><?=$job_data->code?></td>
                                                <td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
                                                <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                                                <td><?php echo $job_data->volume ;?></td>
                                                <td><?php echo $priceList->rate ;?></td>
                                                <td><?=$this->sales_model->calculateRevenueJob($job_data->id,$job_data->type,$job_data->volume,$priceList->id)?></td>
                                                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                                                <td><?php echo $this->admin_model->getAdmin($job_data->created_by) ;?></td>
                                                <td><?php echo $job_data->created_at ;?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                      
                      		<div class="form-group">
                                <label class="col-lg-3 control-label">Mail Subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$task->subject?>" name="subject" id="subject" required>
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
                                            <?=$this->admin_model->selectLeFormat()?>
                                    </select>
                                </div>
                          </div>

                          <div class="form-group">
                              <label class="control-label col-md-3">Deliverable Format</label>
                              
                                <div class="col-lg-6">
                                    <select name="deliverable_format" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLeFormat()?>
                                    </select>
                                </div>
                          </div>
                            <div class="form-group">
                              <label class="control-label col-md-3">Unit</label>
                             
                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="target_language" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectLEUnit($task->unit)?>
                                    </select>
                                </div>
                          </div> 
                           <div class="form-group">
                                <label class="col-lg-3 control-label" for="insrtuctions">Volume</label>

                                <div class="col-lg-6">
                                      <input type="text" name="volume" value="<?=$task->volume?>" required class="form-control" rows="6"></input>
                                </div>
                            </div>
                              
                            <!-- hagar 23/1/2020 --> 
                            <?php
                                $checked1 = "";
                                $checked2 = "";
                                $checked3 = "";
                                if($task->complexicty == 1){
                                     $checked1 = "checked";
                                }elseif ($task->complexicty == 2) {
                                      $checked2 = "checked";
                                }elseif ($task->complexicty == 3) {
                                     $checked3 = "checked";
                                }
                             ?>
                         <div class="form-group">
                           <label class="col-lg-3 control-label">Complexicty</label>

                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?= $checked1?>  required name="complexicty" value="1">
                            <label>Low</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?= $checked2?> name="complexicty" value="2">
                            <label>Mid</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?= $checked3?> name="complexicty" value="3" >
                            <label>High</label>
                           </div>
                         </div>
                            
                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" onchange="checkDate('start_date')" value="<?=$task->start_date?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="">
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
                                      <textarea name="insrtuctions" class="form-control" rows="6"><?=$task->insrtuctions?></textarea>
                                </div>
                            </div>
                              <hr/>
                             <div class="form-group">
                                <label class="col-lg-3 control-label font-weight-bold " >Total Hours   
                                    <span class="text-danger font-weight-bolder"> * </span>
                                </label>            
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Work Hours  </label>
                                <div class="col-lg-6">                               
                                    <input type="number" name="work_hours" value="<?=$task->work_hours?>" class="form-control" required min="0" step="0.5"/>
                               </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Overtime Hours  </label>
                                <div class="col-lg-6">                               
                                    <input type="number" name="overtime_hours" value="<?=$task->overtime_hours?>" class="form-control" required min="0" step="0.5"/>
                               </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Double Paid Hours  </label>
                                <div class="col-lg-6">                               
                                    <input type="number" name="doublepaid_hours" value="<?=$task->doublepaid_hours?>" class="form-control" required min="0" step="0.5"/>
                               </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>projects/jobTasks?t=<?=base64_encode($job)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>