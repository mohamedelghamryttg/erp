<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Save Request 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>translation/doSaveRequest" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=base64_encode($task->id)?>" hidden="">
                            
                            <div class="form-group">
                            <label class="col-lg-3 control-label" for="role name"></label>
                            <div class="col-lg-6" id="LeadData">
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
                                    <td><?=$this->admin_model->getAdmin($task->created_by)?></td>
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
                             
                             <!-- Enter your comment -->
                             <div class="form-group">
                                <label class="col-sm-3 control-label">Action</label>
                                <div class="col-sm-6">
                                    <select name="status" onchange="translationAction()" class="form-control m-b" id="status" required />
                                            <option disabled="disabled" value="" selected="">-- Select Action --</option>
                                            <option value="2">Accept</option>
                                            <option value="5">Update</option>
                                            <option value="0">Reject</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="comment">
                                
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