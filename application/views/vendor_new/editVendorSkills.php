<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .select2-container{
        width:100%!important;
    }
</style>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong><?= $this->session->flashdata('true') ?></strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?> 
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong><?= $this->session->flashdata('error') ?></strong></span>
            </div>
        <?php } ?>
        <!--begin::Card-->
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Vendors</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Edit Vendor Data</span>

                    </div>
                    <!--end::Search Form-->

                </div>
                <!--end::Details-->

            </div>
        </div>
        <!--end::Subheader-->

        <div class="card card-custom example example-compact">    
            <div class="card-body pt-15">
                <form class="form" action="<?php echo base_url() ?>vendor/doEditVendorSkills" method="post" enctype="multipart/form-data">

                    <input type="text" name="vendor_id" value="<?= base64_encode($id) ?>" hidden="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="role name">Strong Fields <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="strong_fields[]" multiple class="form-control m-b" id="strong_fields" required/>
                            <?= $this->admin_model->selectMultiFields($row->strong_fields) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="role name">Services <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="services[]" multiple class="form-control m-b" id="services" required/>
                            <?= $this->admin_model->selectMultiServices($row->services) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="role name">capacity</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control"  value="<?= $row->capacity ?>" name="capacity">
                        </div>
                    </div>
                    <div class="separator separator-dashed separator-border-2"></div>


                    <div class="form-group row">
                        <label class="col-lg-5 col-form-label" for="role name">- can support with the voice over ?</label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="voice_over" required <?= $row->voice_over==1?'checked':'' ?>/>
                                    <span></span>
                                    Yes
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="voice_over" required <?= !empty($row->voice_over) && $row->voice_over == 0?'checked':'' ?>/>
                                    <span></span>
                                    NO
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="voice_over_sample_div" style="<?= $row->voice_over==1?'':'display: none' ?>">
                        <label class="col-lg-5 col-form-label pl-7" for="role name">- have a sample ?</label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="voice_over_sample" <?= $row->voice_over==1?'required':'' ?> <?= $row->voice_over_sample==1?'checked':'' ?>/>
                                    <span></span>
                                    Yes
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="voice_over_sample" <?= $row->voice_over==1?'required':'' ?>  <?= !empty($row->voice_over_sample) && $row->voice_over_sample==0?'checked':'' ?>/>
                                    <span></span>
                                    NO
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="voice_over_studio_div" style="<?= $row->voice_over_sample == 1?'':'display: none' ?>">
                        <label class="col-lg-5 col-form-label pl-15" for="role name">- Studio or non-studio ?</label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="voice_over_studio" <?= $row->voice_over_sample == 1?'required':'' ?> <?= $row->voice_over_studio==1?' checked':'' ?>/>
                                    <span></span>
                                    Studio
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="voice_over_studio" <?= $row->voice_over_sample == 1?'required':'' ?> <?= !empty($row->voice_over_studio) && $row->voice_over_studio==0?' checked':'' ?>/>
                                    <span></span>
                                    Non-studio
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed separator-border-2"></div>

                    <div class="form-group row">
                        <label class="col-lg-5 col-form-label" for="role name">- Does the vendor have samples in Trans-creation ?</label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="trans_creation_sample"  <?= $row->trans_creation_sample == 1?'checked':'' ?>/>
                                    <span></span>
                                    YES
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="trans_creation_sample"  <?= !empty($row->trans_creation_sample) && $row->trans_creation_sample == 0?'checked':'' ?>/>
                                    <span></span>
                                    No
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed separator-border-2"></div>

                    <div class="form-group row">
                        <label class="col-lg-5 col-form-label" for="role name">- can handle DTP ? </label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="dtp"  <?= $row->dtp == 1?'checked':'' ?>/>
                                    <span></span>
                                    YES
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="dtp" <?= !empty($row->dtp) && $row->dtp == 0?'checked':'' ?>/>
                                    <span></span>
                                    No
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-n5" id="dtp_div" style="<?= $row->dtp == 1?'':'display: none' ?>">
                        <label class="col-lg-5 col-form-label text-center" for="role name">DTP Tools</label>
                        <div class="col-lg-6">
                            <select name="dtp_tools[]" multiple class="form-control m-b" id="dtp_tools" />
                            <?= $this->admin_model->selectMultiDTPApplication($row->dtp_tools) ?>
                            </select>
                        </div>
                    </div>                            
                    <div class="separator separator-dashed separator-border-2"></div>

                    <div class="form-group row">
                        <label class="col-lg-5 col-form-label " for="role name">- can handle sworn translation ? </label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="sworn_translation" <?= $row->sworn_translation == 1?'checked':'' ?>/>
                                    <span></span>
                                    YES
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="sworn_translation" <?= !empty($row->sworn_translation) && $row->sworn_translation == 0?'checked':'' ?>/>
                                    <span></span>
                                    No
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-n5" id="sworn_translation_div" style="<?= $row->sworn_translation == 1?'':'display: none' ?>">
                        <label class="col-lg-5 col-form-label text-center" for="role name">upload the certificate</label>
                        <div class="col-lg-6">
                            <input type="file" class=" form-control" name="sworn_translation_certificate" id="sworn_translation_certificate">
                             <?php if(strlen($row->sworn_translation_certificate) > 1){ ?>  <a class="text-danger" href="<?=base_url()?>assets/uploads/vendors/<?=$row->sworn_translation_certificate?>">Download Certificate</a><?php } ?>
                        </div>
                    </div>
                    <div class="separator separator-dashed separator-border-2"></div>
                    <div class="form-group row">
                        <label class="col-lg-5 col-form-label " for="role name">- vendor holds other certificates (ATA,..)  ?</label>
                        <div class="col-lg-5 mt-5">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="other_certificates" <?= $row->other_certificates == 1?'checked':'' ?>/>
                                    <span></span>
                                    YES
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="other_certificates" <?= !empty($row->other_certificates) && $row->other_certificates == 0?'checked':'' ?>/>
                                    <span></span>
                                    No
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-n5 " id="other_certificates_div" style="<?= $row->other_certificates == 1?'':'display: none' ?>">
                        <label class="col-lg-5 col-form-label text-center" for="role name">upload the certificate</label>
                        <div class="col-lg-6">
                            <input type="file" class=" form-control" name="other_certificates_files" id="other_certificates_files">
                           <?php if(strlen($row->other_certificates_files) > 1){ ?>  <a class="text-danger" href="<?=base_url()?>assets/uploads/vendors/<?=$row->other_certificates_files?>">Download Certificate</a><?php } ?>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-10 text-right">
                            <input class="btn btn-primary" type="submit" name="submit" value="Save">
                            <a href="<?php echo base_url() ?>vendor/vendorProfile?t=<?=base64_encode($id)?>" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">

$('input[type=radio][name=other_certificates]').change(function() {   
    if (this.value == '1') {
       $("#other_certificates_div").show();
      
    }
    else  {
        $("#other_certificates_div").hide();
       
        $("#other_certificates_files").val('');
    }
});

$('input[type=radio][name=sworn_translation]').change(function() {   
    if (this.value == '1') {
       $("#sworn_translation_div").show();
    
    }
    else  {
        $("#sworn_translation_div").hide();
       
        $("#sworn_translation_certificate").val('');
    }
});

$('input[type=radio][name=dtp]').change(function() {   
    if (this.value == '1') {
       $("#dtp_div").show();
       $("#dtp_tools").attr('required','true');
    }
    else  {
        $("#dtp_div").hide();
        $("#dtp_tools").removeAttr('required');        
        $("#dtp_tools").val('');
        $('#dtp_tools').trigger('change');
    }
});

$('input[type=radio][name=voice_over_sample]').change(function() { 
    if (this.value == '1') {
       $("#voice_over_studio_div").show();
       $('input[type=radio][name=voice_over_studio]').attr('required','true');
    }
    else  {
        $("#voice_over_studio_div").hide();
        $('input[type=radio][name=voice_over_studio]').removeAttr('required');
        $('input[type=radio][name=voice_over_studio]').prop('checked', false); 
    }
});

$('input[type=radio][name=voice_over]').change(function() {   
    if (this.value == '1') {
       $("#voice_over_sample_div").show();
       $('input[type=radio][name=voice_over_sample]').attr('required','true');
    }
    else  {
        $("#voice_over_sample_div").hide();
        $('input[type=radio][name=voice_over_sample]').removeAttr('required');
        $('input[type=radio][name=voice_over_sample]').prop('checked', false);
        $("#voice_over_studio_div").hide();
        $('input[type=radio][name=voice_over_studio]').removeAttr('required');
        $('input[type=radio][name=voice_over_studio]').prop('checked', false); 
    }
   
});


</script>