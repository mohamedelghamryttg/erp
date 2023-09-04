<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Customer 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/doEditCustomer/<?=$customer->id?>" method="post" enctype="multipart/form-data">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>customer" hidden>
                    <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$customer->name?>" name="name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Website">Website</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$customer->website?>" name="website" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Customer Alias">Customer Alias</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$customer->alias?>" name="alias" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Payment Terms">Payment Terms</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$customer->payment?>" name="payment" required>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>customer" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>