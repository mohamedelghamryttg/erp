<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Lost Opportunity 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doEditPmConversionRequest" method="post" enctype="multipart/form-data">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>pmConversionRequest" hidden>
                            <?php } ?>
                            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" >File Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="file_name" id="file_name" value="<?= $row->file_name ?>" required>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected="">Select Task Type</option>
                                            <?php echo $this->projects_model->selectConversionTaskType($row->task_type) ;?>
                                    </select>
                                </div>
                              </div> 
                           <div class="form-group">
                                <label class="col-lg-3 control-label" >Attachment Type</label>

                                <div class="col-lg-6">
                                    <select name="attachment_type" class="form-control m-b" id="attachment_type" required onchange="pmConversionRequest();" />

                                       <?php if($row->attachment_type == 1){ ?>
                                            <option disabled="disabled" >Select Attachment Type</option>
                                            <option selected="" value="1">Attachment</option>
                                            <option  value="2">Link</option>
                                       <?php }elseif ($row->attachment_type == 2) { ?>
                                             <option disabled="disabled" >Select Attachment Type</option>
                                             <option  value="1">Attachment</option>
                                             <option selected="" value="2">Link</option>
                                       <?php }else{ ?>
                                             <option disabled="disabled" selected="" >Select Attachment Type</option>
                                            <option  value="1">Attachment</option>
                                            <option  value="2">Link</option>
                                       <?php } ?>

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
                                    <input type="url" class=" form-control" name="link" value="<?= $row->link?>" id="link_" required>
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
  <script type="text/javascript">
      window.onload =function(){
            var attachment_type = $("#attachment_type").val();
             if(attachment_type == 1){
                  $("#file_attachment").show();
                  $("#link").hide();
             }else if(attachment_type == 2){
                  $("#link").show();
                  $("#file_attachment").hide();
             }
      };

  </script>