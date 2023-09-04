<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Job </h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>projects/doEditJob" method="post" onsubmit="return checkPriceListForm()" enctype="multipart/form-data">
                <div class="card-body">
                            <input type="text" name="project_id" value="<?=base64_encode($project)?>" hidden="">
                            <input type="text" name="id" value="<?=base64_encode($job)?>" hidden="">
                            <input type="text" name="job_price_list" value="<?=$row->price_list?>" hidden="">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Project Data</label>
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

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Job Name</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" name="name" value="<?=$row->name?>" id="name">
                                
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Services</label>
                            <div class="col-lg-6" id="email">
                                <select name="service" onchange="getPriceListByService()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices($priceList->service)?>
                                    </select>
                        </div>

                    </div>

                     <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Price List</label>
                            <div class="col-lg-6" id="PriceList" style="overflow: scroll;max-height: 300px;width: 700px;">
                              <?=$this->sales_model->getPriceListByLead($project_data->lead,$priceList->price_list_id,$project_data->product_line)?>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="fuzzy">
                                <?=$this->sales_model->getPriceListFuzzyJob($row->id,$row->volume,$row->type,$priceList->rate)?>
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Total Revenue</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" readonly="readonly" value="<?=$this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id)?>" name="total_revenue" id="total_revenue" required>
                            </div>
                    </div>


                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Start Date</label>
                            <div class="col-lg-6">
                                <input class="form_datetime form-control" type="text" value="<?=$row->start_date?>" name="start_date" onchange="checkDate('start_date')" autocomplete="off" id="start_date" required="">
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Delivery Date</label>
                            <div class="col-lg-6">
                                <input class="form_datetime form-control" type="text" value="<?=$row->delivery_date?>" name="delivery_date" onchange="checkDate('delivery_date')" autocomplete="off" id="delivery_date" required="">
                            </div>
                    </div>

                 </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>projects/projectJobs?t=<?=base64_encode($project)?>" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>