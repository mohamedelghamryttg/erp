<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Task</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>projects/doEditTask" method="post" enctype="multipart/form-data">
                <div class="card-body">
                            <input type="text" name="job_id" value="<?=base64_encode($job)?>" hidden="">
                            <input type="text" name="task_id" value="<?=base64_encode($row->id)?>" hidden="">

                        <div class="form-group row">
                            < <div class="col-lg-12">
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

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Mail Subject</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" name="subject" value="<?=$row->subject?>" id="subject" required>           
                            </div>
                            
                        </div>

                     <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Task Type</label>
                            <div class="col-lg-6">
                                <select name="task_type" class="form-control m-b" onchange="getVendorByTask('<?=$priceList->service?>','<?=$priceList->source?>','<?=$priceList->target?>');getVendorData('<?=$priceList->source?>','<?=$priceList->target?>')" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTaskType($row->task_type,$priceList->service)?>
                                    </select>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Select Vendor</label>
                            <div class="col-lg-6">
                                 <select name="vendor" onchange="getVendorData('<?=$priceList->source?>','<?=$priceList->target?>')" class="form-control m-b" id="vendor" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->vendor_model->selectVendorByJob($row->vendor,$priceList->source,$priceList->target,$priceList->service,$brand)?>
                                    </select>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="vendorData">
                                <input type="radio" name="select" value="1" checked="" hidden="">
                                    <?=$this->vendor_model->getVendorTableData($row->vendor,$row->task_type,$row->rate)?>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Count</label>
                            <div class="col-lg-6">
                               <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" value="<?=$row->count?>" onblur="calculateVendorCostChecked()" name="count" id="count" required>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Total Cost</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" readonly="readonly" value="<?=$row->count*$row->rate?>" name="total_cost" id="total_cost" required>
                            </div>
                    </div>

                     <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Start Date</label>
                            <div class="col-lg-6">
                                <input size="16" type="text" onchange="checkDate('start_date')" value="<?=$row->start_date?>" class="form_datetime form-control" name="start_date" autocomplete="off" id="start_date" required="">
                            </div>
                    </div>

                     <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Delivery Date</label>
                            <div class="col-lg-6">
                                <input size="16" type="text" onchange="checkDate('delivery_date')" value="<?=$row->delivery_date?>" class="form_datetime form-control" name="delivery_date" autocomplete="off" id="delivery_date" required="">
                            </div>
                    </div>

                     <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Time Zone</label>
                            <div class="col-lg-6">
                                <select name="time_zone" class="form-control m-b" id="time_zone" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectTimeZone($row->time_zone)?>
                                    </select>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">File Attachment</label>
                            <div class="col-lg-6">
                                 <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Instructions</label>
                            <div class="col-lg-6">
                               <textarea name="insrtuctions" class="form-control" rows="6"><?=$row->insrtuctions?></textarea>
                            </div>
                    </div>

                </div>


                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>projects" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>