<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Request</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>projects/doEditPmConversionRequest" method="post" enctype="multipart/form-data">
                <div class="card-body">
            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">File Name</label>
                            <div class="col-lg-6">
                              <input type="text" class=" form-control" name="file_name" id="file_name" value="<?= $row->file_name ?>" required>
                                </div>
                            </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Task Type</label>
                            <div class="col-lg-6">
                                <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected="">Select Task Type</option>
                                            <?php echo $this->projects_model->selectConversionTaskType($row->task_type) ;?>
                                    </select>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Attachment Type</label>
                            <div class="col-lg-6" id="email">
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

                     <div class="form-group row" id="file_attachment" style="display: none;">
                            <label class="col-lg-3 col-form-label text-right">Attachment</label>
                            <div class="col-lg-6">
                             <input type="file" class=" form-control" name="file" id="file_attachment_" >
                            </div>
                    </div>

                    <div class="form-group row" id="link" style="display: none;">
                            <label class="col-lg-3 col-form-label text-right">Link</label>
                            <div class="col-lg-6">
                                 <input type="url" class=" form-control" name="link" value="<?= $row->link?>" id="link_" required>
                            </div>
                    </div>

                   </div>

                   
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>projects/pmConversionRequest" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>