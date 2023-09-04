<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Save Project 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projectPlanning/doSaveProject" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=$row->id?>" hidden="">
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Project Name/Email subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->project_name?>" name="project_name" id="project_name" required readonly="">
                                </div>
                            </div>
                            <?php if($this->brand == 1){?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">TTG Branch Name</label>

                                <div class="col-lg-6">
                                    <select name="branch_name" class="form-control m-b" readonly="" />
                                            <option disabled="disabled" selected="selected"><?=$this->projects_model->getTTGBranchName($row->branch_name)?></option>
                                             
                                    </select>
                                </div>
                            </div>
                             <?php }?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" required readonly="" />
                                              <option value="<?=$row->lead?>" selected="selected"><?=$this->customer_model->getCustomer($row->customer)?></option>
                                     </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                    <?=$this->customer_model->getLeadRowData($row->lead)?>
                                </div>
                            </div> 
                           
                            <div class="form-group">                            
                            <div class="col-lg-12" id="LeadData">
                                <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                    <thead>
                                        <tr>
                                          <tr>
                                               <th>Job Name</th>
                                            <th>Product Line</th>
                                             <th>Service</th>
                                             <th>Source</th>
                                             <th>Target</th>
                                             <th>Volume</th>
                                             <th>Rate</th>
                                             <th>Total Revenue</th>
                                             <th>Currency</th>
                                             <th>Start Date</th>
                                            <th>Delivery Date</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php foreach ($job as $job_data) { 
                                        $priceList = $this->projects_model->getJobPriceListData($job_data->price_list);
  										$total_revenue = $this->sales_model->calculateRevenueJob($job_data->id,$job_data->type,$job_data->volume,$priceList->id);
                                    ?>
                                        <tr>
                                             <td><?php echo $job_data->name; ?></td>
                                            <td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
                                            <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                                            <?php if($job_data->type == 1){ ?>
                                            <td><?php echo $job_data->volume ;?></td>
                                            <?php }elseif ($job_data->type == 2) { ?>
                                            <td><?php echo $total_revenue / $priceList->rate ;?></td>
                                            <?php } ?>
                                            <td><?php echo $priceList->rate ;?></td>
                                            <td><?=$this->sales_model->calculateRevenueJob($job_data->id,$job_data->type,$job_data->volume,$priceList->id)?></td>
                                            <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                                            <td><?php echo $job_data->start_date ;?></td>
                                            <td><?php echo $job_data->delivery_date ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($job_data->created_by) ;?></td>
                                            <td><?php echo $job_data->created_at ;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>                   
                           
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit"  name="submit" value="Save">
                                  	<input class="btn btn-danger" type="submit" name="reject" value="Lost">
                                    <a href="<?php echo base_url()?>projectPlanning" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>