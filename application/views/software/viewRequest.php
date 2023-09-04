<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Change Request Status
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>software/changeConversionRequestStatus" method="post" enctype="multipart/form-data">
                           <input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">
                           <div class="form-group">
                                <label class="col-lg-3 control-label" >Status</label>

                                <div class="col-lg-6">
                                <select name="status" class="form-control m-b" id="status" required />
                                        <option disabled="disabled" selected="">Select Status</option>
                                        <option value="2">Closed</option>
                                        <option value="3">Failed</option>

                                    </select>
                                </div>
                              </div> 
                			 <div class="form-group">
                                <label class="col-lg-3 control-label" >Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file">
                                </div>
                             </div>
                              <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" value="" rows="6"></textarea>
                                </div>
                            </div>
                              
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>software/ttgSoftware" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>