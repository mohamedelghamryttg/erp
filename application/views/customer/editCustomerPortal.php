<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Customer Portal
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " id="commentForm" action="<?php echo base_url()?>customer/doEditCustomerPortal?t=<?=base64_encode($id)?>" method="post" enctype="multipart/form-data">
                            <input type="text" name="customer" value="<?=$contact->customer?>" hidden>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="link">Link</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="link" data-maxlength="300" id="link" value="<?=$contact->link?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="link">Portal Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="portal" data-maxlength="300" id="portal" value="<?=$contact->portal?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="username">User Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="username" data-maxlength="300" id="username" value="<?=$contact->username?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="password"> Password </label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="password" data-maxlength="300" id="password" value="<?=$contact->password?>" required>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-lg-3 control-label" for="insrtuctions">Additional Information</label>

                                <div class="col-lg-6">
                                      <textarea name="additional_info" class="form-control" rows="6"><?=$contact->additional_info?></textarea>
                                </div>
                            </div>

        
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>customer/customerPortal?t=<?=base64_encode($contact->customer)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>