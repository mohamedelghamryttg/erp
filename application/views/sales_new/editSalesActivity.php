<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Sales Activity</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>sales/doEditActivity" method="post" enctype="multipart/form-data">
                <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                                <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                                <?php }else{ ?>
                                <input type="text" name="referer" value="<?=base_url()?>sales/salesActivity" hidden>
                            <?php } ?>
                            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>

                <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer</label>
                            <div class="col-lg-6">
                                  <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam($row->customer,$sam,$permission,$brand)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="LeadData">
                               <?=$this->customer_model->getLeadData($row->lead,$row->customer,$sam)?>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Contact Method</label>
                            <div class="col-lg-6">
                                 <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod($row->contact_method)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="customerContact">
                               <?=$this->customer_model->getCustomerContact($row->lead,$row->contact_id)?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Contact Status</label>
                            <div class="col-lg-6">
                                 <select name="status" class="form-control m-b" id="status" onchange="getLeadStatus()" required />
                                             <option value="" selected="selected">-- Contact Status --</option>
                                             <?=$this->sales_model->selectActivityStatus($row->status)?>
                                    </select>
                            </div>
                        </div>


                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Feedback</label>
                            <div class="col-lg-6">
                                 <select name="feedback" class="form-control m-b" id="feedback" required />
                                             <option value="" selected="selected">-- Feedback --</option>
                                             <?=$this->sales_model->SelectFeedback($row->feedback)?>
                                    </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Comment</label>
                            <div class="col-lg-6">
                                 <textarea name="comment" class="form-control" value="" rows="6"><?=$row->comment?></textarea>
                            </div>
                        </div>

                    </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>sales/salesActivity" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
            