<div class="container container-form">
    <?php if($this->session->flashdata('true')){ ?>
                <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong><?=$this->session->flashdata('true')?></strong></span>
                </div>
                <?php  } ?>
                <?php if($this->session->flashdata('error')){ ?>
                <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong><?=$this->session->flashdata('error')?></strong></span>
                </div>
    <?php  } ?>
    <form action="<?php echo base_url()?>externalVendor/doAddVendor" method="post" enctype="multipart/form-data">
        <h2 class="text-center">Became A Vendor</h2>
        <input type="hidden" name="brand" value="<?=$brand?>">
        <div class="form-group row">
            <label for="nameFormLabel" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" name="name" class="form-control" id="nameFormLabel" placeholder="Name">
            </div>
        </div>

        <div class="form-group row">
            <label for="emailFormLabel" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="email" name="email" class="form-control" id="emailFormLabel" placeholder="Email">
            </div>
        </div>

        <div class="form-group row">
            <label for="contactFormLabel" class="col-sm-2 col-form-label">Contact</label>
            <div class="col-sm-10">
            <input type="text" name="contact" class="form-control" id="contactFormLabel" placeholder="Contact">
            </div>
        </div>

        <div class="form-group row">
            <label for="countryFormLabel" class="col-sm-2 col-form-label">Country of Residence</label>
            <div class="col-sm-10">
            <select name="country" class="form-control m-b" id="countryFormLabel" required="">
                <option disabled="disabled" value=" selected="selected">-- Select Country --</option>
                <?=$this->admin_model->selectAllCountries()?>
            </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="motherTongueFormLabel" class="col-sm-2 col-form-label">Mother Tongue</label>
            <div class="col-sm-10">
            <input type="text" name="mother_tongue" class="form-control" id="motherTongueFormLabel" placeholder="Mother Tongue">
            </div>
        </div>

        <div class="form-group row">
            <label for="profileFormLabel" class="col-sm-2 col-form-label">Profile</label>
            <div class="col-sm-10">
            <input type="url" name="profile" class="form-control" id="profileFormLabel" placeholder="Profile">
            </div>
        </div>

        <div class="form-group row">
            <label for="subject" class="col-sm-2 col-form-label">Subject Matter</label>
            <div class="col-sm-10">
                <select name="subject[]" class="form-control m-b" multiple id="subject" required="">
                    <option disabled="disabled" value=" selected="selected">-- Select Subject --</option>
                    <?=$this->admin_model->selectFields()?></select>
            </div>
        </div>

        <div class="form-group row">
            <label for="tools" class="col-sm-2 col-form-label">Tools</label>
            <div class="col-sm-10">
                <select name="tools[]" class="form-control m-b" multiple id="tools" required="">
                    <option disabled="disabled" value=" selected="selected">-- Select Tools --</option>
                    <?=$this->sales_model->selectTools()?></select>
            </div>
        </div>
        <div class="form-group row">
           <label for="cv" class="col-sm-2 col-form-label">CV Upload</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="cv" id="cv">
            </div>
        </div>
        <div class="form-group row">
           <label for="certificate" class="col-sm-2 col-form-label">Certificate Upload</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="certificate" id="certificate">
            </div>
        </div>
        <hr>
        <div class="repeater">
            <div data-repeater-list="language-pair">
                <div class="language-pair" data-repeater-item>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="dialect">Dialect</label>
                        <div class="col-sm-3">
                        <input type="text" class="form-control dialect" name="dialect" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="source_lang">Source Language</label>
                        <div class="col-sm-3">
                            <select name='source_lang' class='form-control source_lang m-b' required=''>
                            <option disabled='disabled' value='' selected='selected'>-- Select Source Language --</option>
                            <?=$this->admin_model->selectLanguage()?>
                        </select>                    
                        </div> 

                        <label class="col-sm-2 offset-2 col-form-label" for="target_lang">Taregt Language</label>
                        <div class="col-sm-3">
                            <select name='target_lang' class='form-control target_lang m-b' required=''>
                                <option disabled='disabled' value='' selected='selected'>-- Select Target Language --</option>
                                <?=$this->admin_model->selectLanguage()?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="service">Service</label>
                        <div class="col-sm-3">
                            <select name='service' class='form-control service m-b' required=''>
                            <option disabled='disabled' value='' selected='selected'>-- Select service --</option>
                            <?=$this->admin_model->selectServices()?>
                        </select>                    
                        </div> 

                        <label class="col-sm-2 offset-2 col-form-label" for="unit">Unit</label>
                        <div class="col-sm-3">
                            <select name='unit' class='form-control unit m-b' required=''>
                                <option disabled='disabled' value='' selected='selected'>-- Select Unit --</option>
                                <?=$this->admin_model->selectUnit()?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="task_type">Task Type</label>
                        <div class="col-sm-3">
                            <select name='task_type' class='form-control task_type m-b'  required=''>
                            <option disabled='disabled' value='' selected='selected'>-- Select Task Type --</option>
                        </select>                    
                        </div> 

                        <label class="col-sm-2 offset-2 col-form-label" for="special_rate">Special Rate</label>
                        <div class="col-sm-3">
                          <input type='number' class='form-control special_rate' name='special_rate' data-maxlength='300' step='any'>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="rate">Rate</label>
                        <div class="col-sm-3">
                          <input type='number' class='form-control rate' name='rate' data-maxlength='300' step='any'>
                        </div>
                        <label class="col-sm-2 offset-2 col-form-label" for="currency">Currency</label>
                        <div class="col-sm-3">
                            <select name='currency' class='form-control currency m-b' required=''>
                                <option disabled='disabled' value='' selected='selected'>-- Select Currency --</option>
                                <?=$this->admin_model->selectCurrency()?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 offset-5">
                          <input data-repeater-delete type='button' class='btn btn-danger' value="Delete Language Pair -">
                        </div>
                    </div>
                    <hr>

                </div>
               
            </div>
        <input data-repeater-create type="button" class="btn btn-primary" value="Add Language Pair +"/>
        <input type="submit" class="btn btn-primary" value="Send Request"/>
        </div>

    </form>
</div>