<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add New Payment Method</h3>

            </div>
            <!--begin::Form-->
            <form class="form" id="form"action="<?php echo base_url() ?>accounting/doAddPaymentMethod" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Name</label>
                        <div class="col-lg-6">

                            <input type="text" class=" form-control m-b" name="name" data-maxlength="300" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Bank</label>

                        <div class="col-lg-6">
                            <select name="bank"value="" required="" class="form-control m-b">
                                <option value="" disabled="" selected="">-- Select --</option>
                                <option value="0" > None </option>
                                <?=$this->accounting_model->selectBank()?>
                            </select>
                        </div>
                    </div> 	
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button class="btn btn-primary"name="save" type="submit">Save</button> 
                            <a href="<?php echo base_url() ?>accounting/allPaymentMethods" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
