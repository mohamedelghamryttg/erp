<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Job 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doAddJob" method="post" onsubmit="return checkPriceListForm();disableAddButton();" enctype="multipart/form-data">
                            <input type="text" name="project_id" value="<?=base64_encode($project)?>" hidden="">
                  			<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Project Data">Project Data</label>

                                <div class="col-lg-6">
                                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                        <thead>
                                            <tr>
                                                <th>Client Name</th>
                                                <th>Project Name</th>
                                                <th>Project Code</th>
                                                <th>Product Line</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?=$this->customer_model->getCustomer($project_data->customer)?></td>
                                                <td><?=$project_data->name?></td>
                                                <td><?=$project_data->code?></td>
                                                <td><?=$this->customer_model->getProductLine($project_data->product_line)?><input type="text" name="product_line" id="product_line" value="<?=$project_data->product_line?>" hidden=""></td>
                                                <input type="text" name="lead" id="lead" value="<?=$project_data->lead?>" hidden="">
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
                      		<div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Job Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$project_data->name?>" name="name" id="name">
                                </div>
                            </div>
                      		<div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Job Type</label>

                                <div class="col-lg-6">
                                    <select name="job_type"  class="form-control m-b" id="job_type" required onchange="getJobTypeInputs()">
                                        <option value="" disabled="" selected=''>-- Select Type --</option>
                                            <option value="0" >Real Job</option>
                                            <option  value="1">Free Job</option>
                                            
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="attachedEmail" style='display: none'>
                                <label class="col-lg-3 control-label" for="role File Attachment">Email Attachment
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="This file is required as it's free job"></i>
                                </label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="attached_email" id="attached_email" accept="'application/zip'" required>
                                </div>
                            </div>
                      
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getPriceListByService()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" value="" selected=""></option>
                                            <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12" id="PriceList" style="overflow: scroll;max-height: 300px;">
                                <?=$this->sales_model->getPriceListByLead($project_data->lead,0,$project_data->product_line)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="fuzzy">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Total Revenue</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" readonly="readonly" name="total_revenue" id="total_revenue" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-3"> Start Date</label>
                                <div class="col-lg-6">
                                    <input class="form_datetime form-control" type="text" value="<?=date("Y-m-d H:i:s")?>" name="start_date" autocomplete="off" onchange="checkDate('start_date')" id="start_date" required="">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-3"> Delivery Date</label>
                                <div class="col-lg-6">
                                    <input class="form_datetime form-control" type="text" name="delivery_date" autocomplete="off" onchange="checkDate('delivery_date')" id="delivery_date" required="">
                                    
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>projects/projectJobs?t=<?=base64_encode($project)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>