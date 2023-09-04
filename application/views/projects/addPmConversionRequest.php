<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Lost  Opportunity
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doAddPmConversionRequest" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >File Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="file_name" id="file_name" required>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected="">Select Task Type</option>
                                            <?php echo $this->projects_model->selectConversionTaskType(0) ;?>
                                    </select>
                                </div>
                              </div> 
                           <div class="form-group">
                                <label class="col-lg-3 control-label" >Attachment Type</label>

                                <div class="col-lg-6">
                                    <select name="attachment_type" class="form-control m-b" id="attachment_type" required onchange="pmConversionRequest();" />
                                            <option disabled="disabled" selected="">Select Attachment Type</option>
                                            <option  value="1">Attachment</option>
<!--                                             <option  value="2">Link</option> -->

                                    </select>
                                </div>
                              </div> 
                             <div class="form-group"id="file_attachment" style="display: none;">
                                <label class="col-lg-3 control-label" >Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file_attachment_" >
                                </div>
                             </div>
                              <div class="form-group" id="link" style="display: none;">
                                <label class="col-lg-3 control-label">Link</label>

                                <div class="col-lg-6">
                                    <input type="url" class=" form-control" name="link" id="link_" required>
                                </div>
                             </div>
                              
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>projects/pmConversionRequest" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>