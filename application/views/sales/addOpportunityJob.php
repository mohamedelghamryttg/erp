<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Job 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doOpportunityJob" method="post" onsubmit="return checkPriceListForm();disableAddButton();" enctype="multipart/form-data">
                            <input type="text" name="opportunity" value="<?=base64_encode($opportunity)?>" hidden="">

                            <input type="text" name="product_line" id="product_line" value="<?=$row->product_line?>" hidden=""></td>
                            <input type="text" name="lead" id="lead" value="<?=$row->lead?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Job Name</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->project_name?>" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getPriceListByService()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled"></option>
                                            <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Price List</label>
                                <div class="col-lg-6" id="PriceList" style="overflow: scroll;max-height: 300px;width: 700px;">
                                <?=$this->sales_model->getPriceListByLead($row->lead,0,$row->product_line)?>
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
                                    <a href="<?php echo base_url()?>sales/viewOpportunityJob?t=<?=base64_encode($opportunity)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>