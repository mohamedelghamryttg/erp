<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Upload New CV 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doeditCVDialict" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=base64_encode($row->id)?>" hidden="">
                            <input type="text"  name="idVendorCv" value="<?=$idVendorCv?>" hidden="">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Dialect</label>

                                <div class="col-lg-6">
                                      <input type="text" name="dialect" id="target" value="<?=$row->dialect?>" class="form-control m-b"><br>   
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>vendor/cvDialict" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
