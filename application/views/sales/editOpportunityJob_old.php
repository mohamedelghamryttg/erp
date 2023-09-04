<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Job 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doEditOpportunityJob" method="post" onsubmit="return checkPriceListForm()" enctype="multipart/form-data">
                            <input type="text" name="opportunity" value="<?=base64_encode($opportunity)?>" hidden="">
                            <input type="text" name="id" value="<?=base64_encode($job)?>" hidden="">
                            <input type="text" name="job_price_list" value="<?=$row->price_list?>" hidden="">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getPriceListByService()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices($priceList->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Price List</label>
                                <div class="col-lg-6" id="PriceList" style="overflow: scroll;max-height: 300px;width: 700px;">
                                <?=$this->sales_model->getPriceListByLead($opp_data->lead,$priceList->price_list_id,$opp_data->product_line)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="fuzzy">
                                    <?=$this->sales_model->getPriceListFuzzyJob($row->id,$row->volume,$row->type,$priceList->rate)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Total Revenue</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" readonly="readonly" value="<?=$this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id)?>" name="total_revenue" id="total_revenue" required>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>sales/viewOpportunityJob?t=<?=base64_encode($opportunity)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>