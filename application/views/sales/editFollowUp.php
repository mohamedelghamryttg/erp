<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Follow Up 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doEditFollowUp?>" method="post" enctype="multipart/form-data">

                        <input name="sales" type="hidden" value="<?=$sales?>" >
                        <input name="id" type="hidden" value="<?=$row->id?>" >
                      
                      <!-- Follow Up date -->
                            <div class="form-group">
                              <label class="control-label col-md-3">Follow UP Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" class="form_datetime form-control" onchange="checkDate('follow_up')" value="<?=$row->follow_up?>" name="follow_up" id="follow_up">
                              </div>
                          </div>
                             
                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Customer Status">Customer Status</label>
                                <div class="col-lg-6">
                                    <select name="call_status" class="form-control m-b" id="call_status" required />
                                             <option value="" selected="selected">-- Customer Status --</option>
                                             <?=$this->sales_model->selectActivityStatus($row->call_status)?>
                                    </select>
                                </div>
                            </div> 
                                    
                                <div class="form-group">
                              <label class="control-label col-md-3">Next Action</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" class="form_datetime form-control" onchange="checkDate('new_hitting')" value="<?=$row->new_hitting?>" name="new_hitting" id="new_hitting">
                              </div>
                          </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Comment</label>
                                <div class="col-sm-6">
                                    <textarea name="comment" class="form-control" rows="6"><?=$row->comment?></textarea>
                                </div>
                            </div>
                           
                            
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>sales/followUp?t=<?=base64_encode($sales)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>    

                    </form>
                    </div>
                </div>
            </section>
        </div>
    </div>