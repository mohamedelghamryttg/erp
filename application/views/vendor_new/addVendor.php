<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New Vendor </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>vendor/doAddVendor" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				 <div class="card-body">

						
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" text-right">Resource:</label>

                            <div class="col-lg-6">
                                <select class="form-control" name="resource"onchange="resourceType()" id="resource" required>
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
					<div class="form-group row">
                          <div class="col-lg-offset-1 col-lg-6">
                              <a onclick="addNewPair()" class="btn btn-success">Add Language Pair +</a>
                              <a onclick="deletePair()" class="btn btn-danger">Delete Last One -</a>
                              <input type="text" name="new_pair" id="new_pair" value="1" hidden>
                          </div>
                        </div>
                        <hr>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>vendor" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div> 

<script type="text/javascript">
        function resourceType() {
            var resource = $("#resource").val();
            if(resource == 1){
                $("#new").show();
                $("#new").html(`
                    <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Name :</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Email:</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" onblur='vendoremail()' id="vendorEmail" name="email" required>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Contact:</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="contact" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Country of Residence :</label>

                                <div class="col-lg-6">
                                    <select name="country" class="form-control " id="country" required="><option disabled="disabled" value=" selected="selected">-- Select Country --</option><?=$this->admin_model->selectAllCountries()?></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Mother Tongue :</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="mother_tongue" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Profile :</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="profile" required="">
                                </div>
                            </div>
                  
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Type :</label>

                                <div class="col-lg-6">
                                    <select name="type" class="form-control " id="type" required="><option disabled="disabled" value=" selected="selected">-- Select Type --</option><?=$this->vendor_model->selectVendorType(70)?></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Subject Matter :</label>

                                <div class="col-lg-6">
                                    <select name="subject[]" class="form-control " multiple id="subject" required="><option disabled="disabled" value=" selected="selected">-- Select Subject --</option><?=$this->admin_model->selectFields()?></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Tools:</label>

                                <div class="col-lg-6">
                                    <select name="tools[]" class="form-control " multiple id="tools" required="><option disabled="disabled" value=" selected="selected">-- Select Tools --</option><?=$this->sales_model->selectTools()?></select>
                                </div>
                            </div>

							<div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Color:</label>

                                <div class="col-lg-6">
                                    <select name="color" class="form-control " id="type"><option disabled="disabled" value="" selected="selected">-- Blank --</option><?=$this->vendor_model->selectVendorColor()?></select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >CV Upload:</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="cv" id="cv">
                                </div>
                            </div>
                    `);
                $("#existing").hide();
            }else if(resource == 2){
                $("#new").hide();
                $("#existing").show();
                $("#existing").html(`
                    <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Search Vendor Name ...</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="vendor_name" onkeypress="searchOptions()" id="vendor_name">
                                </div>
                            </div>
                            <div class="form-group row" style="display: none;">
                                <select class="form-control " id="vendorList">
                                         <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                         <?=$this->vendor_model->selectVendor(0,$this->brand)?>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Vendor:</label>

                                <div class="col-lg-6">
                                    <select name="vendor" class="form-control " id="vendor" required >
                                             <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                                             <?=$this->vendor_model->selectVendor(0,$this->brand)?>
                                    </select>
                                </div>
                            </div>
                    `);
                addNewPair();
            }else{
                $("#new").hide();
                $("#existing").hide();
            }
        	$("select").removeClass("form-control");
			$("select").select2();
        }
    </script>
    <script type="text/javascript">
        function addNewPair(){
            var x = $("#new_pair").val();
            $("#pairs").append("<div id='pair_"+x+"'><div class='form-group row'><label class='col-lg-3 col-form-label text-right'>Dialect:</label><div class='col-lg-3'><input type='text' class=' form-control' name='dialect_"+x+"' id='dialect_"+x+"' required=''></div></div><div class='form-group row'><label class='col-lg-3 col-form-label text-right' >Source Language:</label><div class='col-lg-3'><select name='source_lang_"+x+"' class='form-control ' id='source_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Source Language --</option><?=$this->admin_model->selectLanguage()?></select></div><label class='col-lg-3 col-form-label text-right'>Target Language:</label><div class='col-lg-3'><select name='target_lang_"+x+"' class='form-control ' id='target_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Target Language --</option><?=$this->admin_model->selectLanguage()?></select></div></div><div class='form-group row'><label class='col-lg-3 col-form-label text-right'>Service:</label><div class='col-lg-3'><select name='service_"+x+"' class='form-control ' id='service_"+x+"' onchange='getTaskTypeByNumber("+x+")' required=''><option disabled='disabled' value='' selected='selected'>-- Select Service --</option><?=$this->admin_model->selectServices()?></select></div><label class='col-lg-3 col-form-label text-right'>Unit:</label><div class='col-lg-3'><select name='unit_"+x+"' class='form-control ' id='unit_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Unit --</option><?=$this->admin_model->selectUnit()?></select></div></div><div class='form-group row'><label class='col-lg-3 col-form-label text-right'>Task Type:</label><div class='col-lg-3'><select name='task_type_"+x+"' class='form-control ' id='task_type_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Task Type --</option></select></div><label class='col-lg-3 col-form-label text-right'>Special Rate:</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='special_rate_"+x+"' data-maxlength='300' id='special_rate_"+x+"' step='any'></div></div><div class='form-group row'><label class='col-lg-3 col-form-label text-right'> Rate:</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='rate_"+x+"' data-maxlength='300' id='rate_"+x+"' step='any' required=''></div><label class='col-lg-3 col-form-label text-right'>Currency:</label><div class='col-lg-3'><select name='currency_"+x+"' class='form-control ' id='currency_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Currency --</option><?=$this->admin_model->selectCurrency()?></select></div></div><hr></div>");
            var newInput = parseInt(x) + 1;
            // alert(newInput);
            $("#new_pair").val(newInput);
        }

        function deletePair() {
              var res = $("#new_pair").val();
              // alert(res);
              var newInput = parseInt(res) - 1;

              if(newInput >= 1){
                $("#pair_"+newInput).remove();
                // alert(newInput);
                $("#new_pair").val(newInput);   
              }else{
                alert("There's No Pairs To Delete ..");
              }
          }
    </script>