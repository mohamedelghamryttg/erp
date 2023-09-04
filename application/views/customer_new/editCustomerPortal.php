<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Customer Portal</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>customer/doEditCustomerPortal?t=<?=base64_encode($id)?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                        <input type="text" name="customer" value="<?=$contact->customer?>" hidden>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Link</label>
                            <div class="col-lg-6">
                                  <input type="text" class=" form-control" name="link" data-maxlength="300" id="link" value="<?=$contact->link?>" required>  
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Portal Name</label>
                            <div class="col-lg-6">
                                  <input type="text" class=" form-control" name="portal" data-maxlength="300" id="portal" value="<?=$contact->portal?>"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">User Name</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control" name="username" data-maxlength="300" id="username" value="<?=$contact->username?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Password</label>
                            <div class="col-lg-6">
                                 <input type="text" class=" form-control" name="password" data-maxlength="300" id="password" value="<?=$contact->password?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Additional Information</label>
                            <div class="col-lg-6">
                                 <textarea name="additional_info" class="form-control" rows="6"><?=$contact->additional_info?></textarea>
                            </div>
                        </div>

                    </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>customer/customerPortal?t=<?=base64_encode($contact->customer)?>" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>