<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Project "Heads Up"</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>ProjectPlanning/doEditProject" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>                           

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                            <div class="col-lg-6">
                              <input type="text" class=" form-control" name="project_name" id="name" value="<?=$row->project_name?>" required>
                                </div>
                            </div>
                     <?php if($this->brand == 1){?>
                      <div class="form-group row">
                          <label class="col-lg-3 control-label text-right">TTG Branch Name</label>

                          <div class="col-lg-6">
                              <select name="branch_name" class="form-control m-b"  />
                                      <option disabled="disabled" selected="selected">-- Select Branch Name --</option>
                                       <?=$this->projects_model->selectTTGBranchName($row->branch_name)?>
                              </select>
                          </div>
                      </div>
                    <?php }?>
                                         

                 </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>ProjectPlanning" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
