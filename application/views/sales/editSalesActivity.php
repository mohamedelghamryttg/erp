<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Activity 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doEditActivity" method="post" enctype="multipart/form-data">
                           <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                                <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                                <?php }else{ ?>
                                <input type="text" name="referer" value="<?=base_url()?>sales/salesActivity" hidden>
                            <?php } ?>
                            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam($row->customer,$sam,$permission,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                   <?=$this->customer_model->getLeadData($row->lead,$row->customer,$sam)?>
                                </div>
                            </div>  

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Contact Method">Contact Method</label>
                                <div class="col-lg-6">
                                    <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod($row->contact_method)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="customerContact">
                                   <?=$this->customer_model->getCustomerContact($row->lead,$row->contact_id)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Contact Status">Contact Status</label>
                                <div class="col-lg-6">
                                    <select name="status" class="form-control m-b" id="status" onchange="getLeadStatus()" required />
                                             <option value="" selected="selected">-- Contact Status --</option>
                                             <?=$this->sales_model->selectActivityStatus($row->status)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Feedback">Feedback</label>
                                <div class="col-lg-6">
                                    <select name="feedback" class="form-control m-b" id="feedback" required />
                                             <option value="" selected="selected">-- Feedback --</option>
                                             <?=$this->sales_model->SelectFeedback($row->feedback)?>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="form-group" id="rolled_status">
                                <label class="col-lg-3 control-label" for="Rolled In">Rolled In</label>
                                <div class="col-lg-6">
                                    <select name="rolled_in" class="form-control m-b" id="rolled_in" onchange="getPayment()" required />
                                             <option value="" selected="selected">-- Rolled In --</option>
                                             <?php if($row->rolled_in == 1){ ?>
                                                <option value="1" selected="">Yes</option>
                                                <option value="2">No</option>
                                             <?php }elseif ($row->rolled_in == 2) { ?>
                                             <option value="1">Yes</option>
                                             <option value="2" selected="">No</option>
                                             <?php }else{ ?>
                                             <option value="1">Yes</option>
                                             <option value="2">No</option>
                                             <?php } ?>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div id="payment_method">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Revenue USD">Payment</label>

                                    <div class="col-lg-5">
                                        <input type="number" class=" form-control" id="payment" name="payment" required="" data-maxlength="300"  id="paymnet" step="any"  >
                                    </div>
                                    <label class="col-lg-1 control-label" for="">Days</label>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Select PM">Select PM</label>
                                    <div class="col-lg-6">
                                        <select name="pm" class="form-control m-b" id="pm" required />
                                                 <option value="" selected="selected">-- Select PM --</option>
                                                 <?=$this->sales_model->selectPm()?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" value="" rows="6"><?=$row->comment?></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>sales/salesActivity" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

	<div class="row divComments">
        <div class="col-sm-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="form">
                        <form class="cmxform form-horizontal ">
                        <input type="text" id="activity" value="<?=$row->id?>" hidden="">
                        <input type="text" id="lead" value="<?=$row->lead?>" hidden="">
                        <?php foreach ($comments as $comment) { 
                          if($comment->team == 3){
                          ?>
                            <div class="form-group">
                                <div class="col-lg-3" style="padding-top: 5px;background-color: #79c4f1;"><p style="text-align: left;"><?php echo $this->admin_model->getAdmin($comment->created_by) ;?> - <?=$comment->created_at?></p></div>
                                <div class="col-lg-6" style="padding-top: 5px;background-color: #79c4f1;"><p style="text-align: left;"><?=$comment->comment?></p></div>
                                <div class="col-lg-3"></div>
                            </div>
                          <?php }else{ ?>
                            <div class="form-group">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6" style="padding-top: 5px;background-color: #f6ede8;"><p style="text-align: right;"><?=$comment->comment?></p></div>
                                <div class="col-lg-3" style="padding-top: 5px;background-color: #f6ede8;"><p style="text-align: right;"><?php echo $this->admin_model->getAdmin($comment->created_by) ;?> - <?=$comment->created_at?></p></div>
                            </div>
                        <?php }} ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea id="chat" class="form-control" value="" rows="6"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment"></label>

                                <div class="col-lg-6">
                                      <a href="" onclick="addCommentSales();return false;" class="btn btn-primary" type="button">Send Comment</a>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>