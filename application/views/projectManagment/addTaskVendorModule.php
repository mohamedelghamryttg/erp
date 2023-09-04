<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script>
$(document).ready(function(){
setTimeout(function(){
$(".mce-notification-warning").hide();
}, 1000);
});
</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Task 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>ProjectManagment/doAddTaskVendorModule" method="post" onsubmit="return addTaskForm();disableAddButton();" enctype="multipart/form-data">
                            <input type="text" name="job_id" value="<?=base64_encode($job)?>" hidden="">
                            <input type="text" name="flag" id="flag" value="1" hidden="">
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
                                <label class="col-lg-3 control-label">Service Type</label>

                                <div class="col-lg-6">
                                    <select name="serviceType"  class="form-control m-b"  required >                                       
                                            <option value="0" selected >Real Task</option>
                                            <option  value="1">Test Task </option>                                            
                                    </select>
                                </div>
                            </div>
                      		<div class="form-group">
                                <label class="col-lg-3 control-label">Mail Subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$job_data->name?>" name="subject" id="subject" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" onchange="getVendorByTask('<?=$priceList->service?>','<?=$priceList->source?>','<?=$priceList->target?>');getAllVendorData('<?=$priceList->source?>','<?=$priceList->target?>')" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTaskType(0,$priceList->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Select Vendor">Select Vendor</label>

                                <div class="col-lg-6">
                                    <select name="vendor" onchange="getAllVendorData('<?=$priceList->service?>','<?=$priceList->source?>','<?=$priceList->target?>')" class="form-control m-b" id="vendor" required />
                                            <option disabled="disabled" selected=""></option>
                                            <option value="all"> Send To All Vendors</option>
                                            <?=$this->vendor_model->selectVendorByJob(0,$priceList->source,$priceList->target,$priceList->service,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="vendorData" style="max-height: 300px;overflow-y: scroll">
                                    
                                </div>
                            </div>

                                               <div id="sendToAllVendors" style="display: none;">
                                <div class="form-group">                              
                                <label class="col-lg-3 control-label" for="role name">Unit</label>
                                <div class="col-lg-6">
                                     <select name="unit" class="form-control m-b"  />
                                          <?=$this->admin_model->selectUnit()?>
                                    </select>
                                      
                                </div>
                                </div>
                                 <div class="form-group">
                                    
                                   <label class="col-lg-3 control-label" for="role name">Rate</label>
                                   <div class="col-lg-6" >
                                       <input type="text" name="rate" value=""  class="form-control m-b"onblur="calculateVendorCostChecked()">
                                   </div>
                                </div>
                                 <div class="form-group">
                                    
                                   <label class="col-lg-3 control-label" for="role name">Currency</label>
                                   <div class="col-lg-6" >
                                        <select name="currency" class="form-control m-b"  />
                                          <?=$this->admin_model->selectCurrency()?>
                                    </select>                                       
                                   </div>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Count</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" onblur="calculateVendorCostChecked()" name="count" id="count" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Total Cost</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" readonly="readonly" name="total_cost" id="total_cost" required>
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
                                <label class="col-lg-3 control-label" for="role Time Zone">Time Zone</label>

                                <div class="col-lg-6">
                                    <select name="time_zone" class="form-control m-b" id="time_zone" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTimeZone()?>
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
                                <label class="col-lg-3 control-label" for="insrtuctions">Instructions</label>

                                <div class="col-lg-6">
                                      <textarea name="insrtuctions" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                             <hr/>
                            <div class="form-group">
                                <label class="col-lg-3 control-label font-weight-bold " >schedule Task   
                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="This task will start after the selected task closed"></i>
                                </label>            
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Start After </label>

                                <div class="col-lg-6">
                                    <select name="start_after" class="form-control m-b" />
                                             <option disabled="disabled" selected="selected" value="">-- Select Task --</option>
                                             <?=$this->projects_model->selectRelatedTasks($job)?>
                                    </select>
                                </div>
                            </div>
                
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>ProjectManagment/projectJobs?t=<?=base64_encode($job_data->project_id)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>