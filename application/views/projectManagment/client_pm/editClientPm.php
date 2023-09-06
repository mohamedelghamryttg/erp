<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container pt-3">
        <?php if ($this->session->flashdata('true')) { ?>
                <div class="alert alert-success" role="alert">
                    <span class="far fa-check-circle text-white"></span>
                    <span><strong>
                            <?= $this->session->flashdata('true') ?>
                        </strong></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                    <span><strong>
                            <?= $this->session->flashdata('error') ?>
                        </strong></span>
                </div>
            <?php } ?>
        <!--begin::Card-->
        <div class="card card-custom example example-compact mt-7">
            <div class="card-header">
                <h3 class="card-title">Edit PM Data</h3>

            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url() ?>projectManagment/doEditClientPm" onsubmit="return disableEditButton();" method="post" enctype="multipart/form-data">

                <div class="card-body">     
                     <input type="hidden" name="id" value="<?= $client_pm->id ?>">  
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Customer</label>
                        <div class="col-lg-6">
                            <select name="customer" class="form-control m-b" id="customer"  required />
                            <option value="" selected="" disabled="">-- Select Customer --</option>
                            <?= $this->customer_model->selectCustomerByPm($client_pm->customer_id, $pm, $permission, $brand) ?>
                            </select>  
                        </div>
                    </div>  
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Name</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="name" id="name" autocomplete="off" value="<?=$client_pm->name?>" required>            
                        </div>
                    </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Email</label>
                        <div class="col-lg-6">
                            <input type="email" class=" form-control" name="email" id="email" autocomplete="off" value="<?=$client_pm->email?>" required>            
                        </div>
                    </div>

                   
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>projectManagment/listClientPm" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>

