<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Request 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doEditTranslationTask" method="post" enctype="multipart/form-data">
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
                              <label class="col-lg-3 control-label" for="insrtuctions">Update Reason</label>

                              <div class="col-lg-6" style="color: red;"><?=$task->reason?></div>
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
                                            <?=$this->admin_model->selectTaskType($task->task_type,$priceList->service)?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Count</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" value="<?=$task->count?>" name="count" id="count" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($task->unit)?>
                                    </select>
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
                                  <input size="16" type="text" onchange="checkDate('delivery_date')" autocomplete="off" value="<?=$task->delivery_date?>" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="">
                              </div>
                          </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                                </div>

                                <div class="col-lg-3">
                                    <?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/taskFile/<?=$task->file?>" target="_blank">Download File</a><?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="insrtuctions">Instructions</label>

                                <div class="col-lg-6">
                                      <textarea name="insrtuctions" class="form-control" rows="6"><?=$task->insrtuctions?></textarea>
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