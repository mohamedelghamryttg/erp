<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Vendor
            </header>

            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>vendor/doAddVendor"
                        onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role name">Resource</label>

                            <div class="col-lg-6">
                                <select name="resource" class="form-control m-b" onchange="resourceType()" id="resource"
                                    required />
                                <option disabled="disabled" selected="selected">-- Select --</option>
                                <option value="1">New Resource</option>
                                <option value="2">Select Existing Resource & Adding New Pair</option>
                                </select>
                            </div>
                        </div>
                        <div id="new" style="display: none;">

                        </div>
                        <div id="existing" style="display: none;">

                        </div>
                        <hr>
                        <div id="pairs">

                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-6">
                                <a onclick="addNewPair()" class="btn btn-primary">Add Language Pair +</a>
                                <a onclick="deletePair()" class="btn btn-danger">Delete Last One -</a>
                                <input type="text" name="new_pair" id="new_pair" value="1" hidden>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                <a href="<?php echo base_url() ?>vendor" class="btn btn-default"
                                    type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    function resourceType() {
        var resource = $("#resource").val();
        if (resource == 1) {
            $("#new").show();
            $("#new").html(`
                    <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Email</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onblur='vendoremail()' id="vendorEmail" name="email" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Contact</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="contact" required>
                                </div>
                            </div>
                                                
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Phone Number</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" pattern="^[0-9-+\s()]*$" name="phone_number" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Country of Residence</label>

                                <div class="col-lg-6">
                                    <select name="country" class="form-control m-b" id="country" required onchange="checkCountryEGY();"><option disabled="disabled" value=" selected="selected">-- Select Country --</option><?= $this->admin_model->selectAllCountries() ?></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Mother Tongue</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="mother_tongue" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Profile</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="profile" required="">
                                </div>
                            </div>
                  
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Type</label>

                                <div class="col-lg-6">
                                    <select name="type" class="form-control m-b" id="type" required="><option disabled="disabled" value=" selected="selected">-- Select Type --</option><?= $this->vendor_model->selectVendorType(70) ?></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject[]" class="form-control m-b" multiple id="subject" required="><option disabled="disabled" value=" selected="selected">-- Select Subject --</option><?= $this->admin_model->selectFields() ?></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Tools">Tools</label>

                                <div class="col-lg-6">
                                    <select name="tools[]" class="form-control m-b" multiple id="tools" required="><option disabled="disabled" value=" selected="selected">-- Select Tools --</option><?= $this->sales_model->selectTools() ?></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Color</label>

                                <div class="col-lg-6">
                                    <select name="color" class="form-control m-b" id="type"><option disabled="disabled" value="" selected="selected">-- Blank --</option><?= $this->vendor_model->selectVendorColor() ?></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">CV Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="cv" id="cv">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Certificate Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="certificate" id="certificate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">NDA Upload</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="NDA" id="NDA">
                                </div>
                            </div>
                    `);
            $("#existing").hide();
        } else if (resource == 2) {
            $("#new").hide();
            $("#existing").show();
            $("#existing").html(`
                    <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Search Vendor name">Search Vendor Name ...</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="vendor_name" onkeypress="searchOptions()" id="vendor_name">
                                </div>
                            </div>
                            <div style="display: none;">
                                <select class="form-control m-b" id="vendorList" onchange="checkCountryEGY();">
                                         <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                         <?= $this->vendor_model->selectVendor(0, $this->brand) ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Vendor">Vendor</label>

                                <div class="col-lg-6">
                                    <select name="vendor" class="form-control m-b" id="vendor" required onchange="checkCountryEGY();">
                                             <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                             <?= $this->vendor_model->selectVendor(0, $this->brand) ?>
                                    </select>
                                </div>
                            </div>
                    `);
            addNewPair();
        } else {
            $("#new").hide();
            $("#existing").hide();
        }
        $("select").removeClass("form-control");
        $("select").select2();
    }
</script>
<script type="text/javascript">
    function addNewPair() {
        var x = $("#new_pair").val();
        $("#pairs").append("<div id='pair_" + x + "'><div class='form-group'><label class='col-lg-2 control-label' for='role name'>Dialect</label><div class='col-lg-3'><input type='text' class=' form-control' name='dialect_" + x + "' id='dialect_" + x + "' required=''></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Source Language</label><div class='col-lg-3'><select name='source_lang_" + x + "' class='form-control m-b' id='source_" + x + "' required=''><option disabled='disabled' value='' selected='selected'>-- Select Source Language --</option><?= $this->admin_model->selectLanguage() ?></select></div><label class='col-lg-2 control-label' for='role Target'>Target Language</label><div class='col-lg-3'><select name='target_lang_" + x + "' class='form-control m-b' id='target_" + x + "' required=''><option disabled='disabled' value='' selected='selected'>-- Select Target Language --</option><?= $this->admin_model->selectLanguage() ?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Service</label><div class='col-lg-3'><select name='service_" + x + "' class='form-control m-b' id='service_" + x + "' onchange='getTaskTypeByNumber(" + x + ")' required=''><option disabled='disabled' value='' selected='selected'>-- Select Service --</option><?= $this->admin_model->selectServices() ?></select></div><label class='col-lg-2 control-label' for='role Unit'>Unit</label><div class='col-lg-3'><select name='unit_" + x + "' class='form-control m-b' id='unit_" + x + "' required=''><option disabled='disabled' value='' selected='selected'>-- Select Unit --</option><?= $this->admin_model->selectUnit() ?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Task Type</label><div class='col-lg-3'><select name='task_type_" + x + "' class='form-control m-b' id='task_type_" + x + "' required=''><option disabled='disabled' value='' selected='selected'>-- Select Task Type --</option></select></div><label class='col-lg-2 control-label' for='rate'>Special Rate</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='special_rate_" + x + "' data-maxlength='300' id='special_rate_" + x + "' step='any'></div></div><div class='form-group'><label class='col-lg-2 control-label' for='rate'> Rate</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='rate_" + x + "' data-maxlength='300' id='rate_" + x + "' step='any' required=''></div><label class='col-lg-2 control-label' for='role Currency'>Currency</label><div class='col-lg-3'><select name='currency_" + x + "' class='form-control m-b' id='currency_" + x + "' required=''><option disabled='disabled' value='' selected='selected'>-- Select Currency --</option><?= $this->admin_model->selectCurrency() ?></select></div></div><hr></div>");
        var newInput = parseInt(x) + 1;
        // alert(newInput);
        $("#new_pair").val(newInput);
        checkCountryEGY();
    }

    function deletePair() {
        var res = $("#new_pair").val();
        // alert(res);
        var newInput = parseInt(res) - 1;

        if (newInput >= 1) {
            $("#pair_" + newInput).remove();
            // alert(newInput);
            $("#new_pair").val(newInput);
        } else {
            alert("There's No Pairs To Delete ..");
        }
    }

    // check if country = egy -> currency = egp
    function checkCountryEGY() {
        var res = $("#resource").val();
        if (res == "1") {
            var country = $("#country").val();
            if (country == "369") {
                $('[id^="currency_"]').val("1");
                $('[id^="currency_"]:not(.form-control)').select2().trigger('change');
                $('[id^="currency_"]').attr("readonly", true);
                $('[id^="currency_"]:not(.form-control)').select2("readonly", true);
            } else {
                $('[id^="currency_"]').removeAttr("readonly");
                $('[id^="currency_"]:not(.form-control)').select2("readonly", false);
            }
        } else {
            var option = $("#vendor option:selected").attr('country');

            if (option == "369") {
                $('[id^="currency_"]').val("1");
                $('[id^="currency_"]:not(.form-control)').select2().trigger('change');
                $('[id^="currency_"]').attr("readonly", true);
                $('[id^="currency_"]:not(.form-control)').select2("readonly", true);
            } else {
                $('[id^="currency_"]').removeAttr("readonly");
                $('[id^="currency_"]:not(.form-control)').select2("readonly", false);
            }

        }


    }


</script>