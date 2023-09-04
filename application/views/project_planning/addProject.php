<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add New Project "Heads Up"</h3>
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url() ?>ProjectPlanning/doAddProject" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="project_name" id="name" autocomplete="off" required>            
                        </div>
                    </div>

                    <?php if($this->brand == 1){?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">TTG Branch Name</label>

                        <div class="col-lg-6">
                            <select name="branch_name" class="form-control m-b"  />
                                    <option disabled="disabled" selected="selected">-- Select Branch Name --</option>
                                     <?=$this->projects_model->selectTTGBranchName()?>
                            </select>
                        </div>
                    </div>
                    <?php }?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Customer</label>
                        <div class="col-lg-6">
                            <select name="customer" class="form-control m-b" id="customer"  onchange="getCustomerData();clearJobs()" required />
                            <option value="" selected="" disabled="">-- Select Customer --</option>
                            <?= $this->customer_model->selectCustomerByPm(0, $pm, $permission, $brand) ?>
                            </select>  
                        </div>
                    </div>  

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right"></label>
                        <div class="col-lg-6" id="LeadData">           
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Product Lines</label>
                        <div class="col-lg-6">
                            <select name="product_line" class="form-control m-b" id="product_line" onchange="getPriceList();clearJobs()" required />
                            <option disabled="disabled">-- Select Product Line --</option>
                            </select>          
                        </div>
                    </div>

                  
                    <hr>



                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>ProjectPlanning" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>

