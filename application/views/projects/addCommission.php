<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Commission
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doAddCommission" method="post" onsubmit="return disableAddButton();" enctype="multipart/form-data">
                            <input type="text" name="job_id" value="<?=base64_encode($job)?>" hidden="">
                            <input type="text" name="volume" value="<?=$job_data->volume?>" hidden="">
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
                                <label class="col-lg-3 control-label" for="role Name">Name</label>

                                <div class="col-lg-6">
                                    <select name="commission" id="commission" class="form-control m-b" onchange="getCommissionEmail();getCommissionRate();" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->projects_model->selectCommission(0,$brand)?>
                                    </select>
                                </div>
                            </div>
                
                			<div class="form-group">
                               <label class="col-lg-3 control-label" for="Email">Email</label>

                               <div class="col-lg-6" id="email">
                               
                               </div>
                             </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate">Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" id="rate" step="any" required>
                               </div>
                             </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>projects" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>