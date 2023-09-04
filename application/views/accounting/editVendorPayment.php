<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Vendor Payment 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/doEditVendorPayment" method="post" enctype="multipart/form-data">
                         <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>customer" hidden>
                         <?php } ?>
                            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Vendor">Vendor</label>

                                <div class="col-lg-6">
                                    <select name="vendor" class="form-control m-b" id="vendor" onchange="getVendorInfo();getVendorVerifiedTasks();" required />
                                             <option><?=$this->vendor_model->getVendorName($task->vendor)?></option>
                                    </select>
                                </div>
                            </div>
 
                           <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="vendorData">
                                <?=$this->vendor_model->getVendorInfo($task->vendor)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="tasks">
                                    <?=$this->accounting_model->getVendorVerifiedTasksById($task)?>
                                </div>
                            </div>  
                  
                  			<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Payment Method</label>

                                <div class="col-lg-6">
                                    <select name="payment_method" class="form-control m-b" id="payment_method"  required />
                                             <option value="" selected="selected" disabled="">-- Select Payment Method --</option>
                                             <?=$this->accounting_model->selectPaymentMethod($payment->payment_method,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Payment Status</label>

                                <div class="col-lg-6">
                                    <select name="status" class="form-control m-b" id="status"  required />
                                            <?php if($permission->follow == 1){ ?>
                                             <option value="" disabled="">-- Select Payment Status --</option>
                                             <option value="1" selected="">Paid</option>
                                             <?php }elseif ($permission->follow == 2) { ?>
                                             <?=$this->accounting_model->selectVendorPaymentStatus($payment->status)?>
                                             <?php } ?>
                                    </select>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>accounting/vendorPayments" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>