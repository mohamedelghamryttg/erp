<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Save Request 
            </header>
            <?php
        		$priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                                if($task->source_language == 0){
                                    $source = $priceListData->source;
                                    $target = $priceListData->target;
                                }else{
                                    echo $source = $task->source_language;
                                    $target = $task->target_language;
                                }
        	?>
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>dtp/doSaveRequestPlan" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=base64_encode($task->id)?>" hidden="">
                            
                            <div class="form-group">
                       <div class="col-lg-12" style="overflow:scroll;" id="LeadData">
                      <table class="table table-striped table-hover table-bordered" id="">

                       <thead>
                            <tr>
                                <th colspan="2">PM</th>
                                <td colspan="2"><?=$this->admin_model->getAdmin($task->created_by)?></td>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <td colspan="3"><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                </tr>
                                <tr>
                                    <td>Start Delivery</td>
                                    <td><?=$task->start_date?></td>
                                    <td>Delivery Date</td>
                                    <td><?=$task->delivery_date?></td>
                                </tr>
                               
                                        
                        </tbody>
                    </table>
                    <div>
                        <h5  style="color: black;">Instructions :</h5> <p style="color: black; font-size: 14px;"> <?=$task->insrtuctions?></p>
                    </div>
                                </div>
                            </div>
                             
                             <!-- Enter your comment -->
                                   <div class="form-group">
                                <label class="col-sm-3 control-label">Action</label>
                                <div class="col-sm-6">
                                    <select name="status"  class="form-control m-b"  required />
                                            <option disabled="disabled" value="" selected="">-- Select Action --</option>
                                            <option value="8">Available</option>
                                            <option value="9">Not Available</option>
                                          
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="comment">
                                 <label class="col-sm-3 control-label">Comment</label>
                                <div class="col-sm-6">
                                    <textarea name="plan_comment" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save Changes">
                                    <a href="<?php echo base_url()?>translation" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>