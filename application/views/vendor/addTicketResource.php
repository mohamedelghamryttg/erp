<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Resource 
			</header> 
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doAddticketResource" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?=$ticket?>" readonly="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Resource <?=$resources+1?></label>
                                <div id='new_resource_<?=$resources+1?>'>
                                    <div class="col-lg-6">
                                        <select class="form-control m-b" name="ticket_response_type_<?=$resources+1?>" required="" id="ticket_response_type_<?=$resources+1?>" onchange="ticketResponeType(<?=$resources+1?>)" />
                                                <option value="" selected="selected">-- Select Type --</option>
                                                <option value="1">New Resource</option>
                                                <option value="2">Select Existing Resource</option>
                                                <option value="3">Select Existing Resource & Adding New Pair</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="add_resouce">
                            
                            <div id="resource_<?=$resources+1?>"></div>
                            </div>
                            <hr>
                            <div class="form-group">
                              <div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addResource()" class="btn btn-primary">Additional Resource +</a>
                                  <a onclick="deleteResource()" class="btn btn-danger">Delete Last One -</a>
                                  <input type="text" name="new_res" id="new_res" value="<?php echo $resources+2;?>" hidden>
                              </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>vendor/vmTicketView?t=<?=$ticket?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </section>
        </div>
    </div>
<script type="text/javascript">
  function addResource(){
    var input = $("#new_res").val();
     //alert(input);
    $("#add_resouce").append("<div id='new_resource_"+input+"'><div class='form-group'><label class='col-lg-3 control-label' for='role Source'>Resource "+input+"</label><div class='col-lg-6'><select name='ticket_response_type_"+input+"' onchange='ticketResponeType("+input+")' class='form-control m-b' id='ticket_response_type_"+input+"' required=''><option disabled='disabled' selected='selected' value=''>-- Select Type --</option><option value='1'>New Resource</option><option value='2'>Select Existing Resource</option><option value='3'>Select Existing Resource & Adding New Pair</option></select></div></div><div id='resource_"+input+"''></div></div>");
    var newInput = parseInt(input) + 1;
      // alert(newInput);
      $("#new_res").val(newInput); 
  	$("select").removeClass( "form-control");
	$("select").select2();
  }

  function deleteResource() {
      var res = $("#new_res").val();
      var num = <?=$resources+1?>;
      // alert(res);
      var newInput = parseInt(res) - 1;

      if(num != newInput){
        $("#new_resource_"+newInput).remove();
        // alert(newInput);
        $("#new_res").val(newInput);   
      }else{
        alert("There's No Resource To Delete ..");
      }

  }
</script>

<script type="text/javascript">
  function ticketResponeType(x){
      var type = $("#ticket_response_type_"+x).val();
      var pattern = "^[0-9-+&#92;s()]*$";
      $("#resource_"+x).html("");
      if(type == 1){
        // alert("New Resource ..");
        $("#resource_"+x).html(`<div id='new_resource_`+x+`'><div class='form-group'><label class='col-lg-2 control-label' for='role name'>Name</label><div class='col-lg-3'><input type='text' class=' form-control' name='name_`+x+`' id='name_`+x+`' required=''></div><label class='col-lg-2 control-label' for='role name'>Email</label><div class='col-lg-3'><input type='email' onblur='vendorTicketEmail(`+x+`)' class=' form-control' name='email_`+x+`' id='email_`+x+`' required=''></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role name'>Contact</label><div class='col-lg-3'><input type='text' class=' form-control' name='contact_`+x+`' id='contact_`+x+`' required=''></div><label class='col-lg-2 control-label' for='role name'>Country of Residence</label><div class='col-lg-3'><select name='country_`+x+`' class='form-control m-b' id='country_`+x+`' required='' onchange="checkCountryEGYType1(`+x+`);"><option disabled='disabled' value='' selected='selected'>-- Select Country --</option><?=$this->admin_model->selectAllCountries()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role name'>Phone Number</label><div class='col-lg-3'><input type='text' class=' form-control' pattern="`+pattern+`" name='phone_number_`+x+`' id='phone_number_`+x+`' required=''></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role name'>Mother Tongue</label><div class='col-lg-3'><input type='text' class=' form-control' name='mother_tongue_`+x+`' id='mother_tongue_`+x+`' required=''></div><label class='col-lg-2 control-label' for='role name'>Dialect</label><div class='col-lg-3'><input type='text' class=' form-control' name='dialect_`+x+`' id='dialect_`+x+`' required=''></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Profile'>Profile</label><div class='col-lg-3'><input type='text' class=' form-control' name='profile_`+x+`' id='profile_`+x+`'></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Source Language</label><div class='col-lg-3'><select name='source_lang_`+x+`' class='form-control m-b' id='source_`+x+`' required=''><option disabled='disabled' value='' selected='selected'>-- Select Source Language --</option><?=$this->admin_model->selectLanguage()?></select></div><label class='col-lg-2 control-label' for='role Target'>Target Language</label><div class='col-lg-3'><select name='target_lang_`+x+`' class='form-control m-b' id='target_`+x+`' required=''><option disabled='disabled' value='' selected='selected'>-- Select Target Language --</option><?=$this->admin_model->selectLanguage()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Service</label><div class='col-lg-3'><select name='service_`+x+`' class='form-control m-b' id='service_`+x+`' onchange='getTaskTypeByNumber(`+x+`)' required=''><option disabled='disabled' value='' selected='selected'>-- Select Service --</option><?=$this->admin_model->selectServices()?></select></div><label class='col-lg-2 control-label' for='role Unit'>Unit</label><div class='col-lg-3'><select name='unit_`+x+`' class='form-control m-b' id='unit_`+x+`' required=''><option disabled='disabled' value='' selected='selected'>-- Select Unit --</option><?=$this->admin_model->selectUnit()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Task Type</label><div class='col-lg-3'><select name='task_type_`+x+`' class='form-control m-b' id='task_type_`+x+`' required=''><option disabled='disabled' value='' selected='selected'>-- Select Task Type --</option></select></div><label class='col-lg-2 control-label' for='rate'>Special Rate</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='special_rate_`+x+`' data-maxlength='300' id='special_rate_`+x+`' step='any' ></div></div><div class='form-group'><label class='col-lg-2 control-label' for='rate'> Rate</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='rate_`+x+`' data-maxlength='300' id='rate_`+x+`' step='any' required=''></div><label class='col-lg-2 control-label' for='role Currency'>Currency</label><div class='col-lg-3'><select name='currency_`+x+`' class='form-control m-b' id='currency_`+x+`' required=''><option disabled='disabled' value='' selected='selected'>-- Select Currency --</option><?=$this->admin_model->selectCurrency()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Subject Matter'>Subject Matter</label><div class='col-lg-3'><select name='subject_`+x+`[]' multiple class='form-control m-b' id='subject_`+x+`' required=''><?=$this->admin_model->selectFields()?></select></div><label class='col-lg-2 control-label' for='role Tools'>Tools</label><div class='col-lg-3'><select name='tools_`+x+`[]' multiple class='form-control m-b' id='tools_`+x+`' required=''><?=$this->sales_model->selectTools()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Color'>Color</label><div class='col-lg-3'><select name='color_`+x+`' class='form-control m-b' id='color_`+x+`'><option disabled='disabled' value='' selected='selected'>-- Blank --</option><?=$this->vendor_model->selectVendorColor()?></select></div>
          </div><div class='form-group'><label class='col-lg-3 control-label' for='role name'>CV Upload</label><div class='col-lg-6'><input type='file' class=' form-control' name='file_`+x+`' id='file_`+x+`' ></div></div></div><hr>`);
      }else if(type == 2){
        // alert("Select Existing Resource ..");
        $("#resource_"+x).html("<div class='form-group'><label class='col-lg-3 control-label' for='role Vendor'>Vendor</label><div class='col-lg-6'><select name='vendor_"+x+"' class='form-control m-b' id='vendor' required=''><option disabled='disabled' value='' selected='selected'>-- Select Vendor --</option><?=$this->vendor_model->selectVendorByMail(0,$brand)?></select></div></div><hr>");

      }else if(type == 3){
        // alert("Select Existing Resource & Adding New Pair ..");
        $("#resource_"+x).html("<div class='form-group'><label class='col-lg-3 control-label' for='role Vendor'>Vendor</label><div class='col-lg-6'><select name='vendor_"+x+"' class='form-control m-b' id='vendor' required='' onchange='checkCountryEGYType3("+x+")'><option disabled='disabled' value='' selected='selected'>-- Select Vendor --</option><?=$this->vendor_model->selectVendorByMail(0,$brand)?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role name'>Dialect</label><div class='col-lg-3'><input type='text' class=' form-control' name='dialect_"+x+"' id='dialect_"+x+"' required=''></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Source Language</label><div class='col-lg-3'><select name='source_lang_"+x+"' class='form-control m-b' id='source_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Source Language --</option><?=$this->admin_model->selectLanguage()?></select></div><label class='col-lg-2 control-label' for='role Target'>Target Language</label><div class='col-lg-3'><select name='target_lang_"+x+"' class='form-control m-b' id='target_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Target Language --</option><?=$this->admin_model->selectLanguage()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Service</label><div class='col-lg-3'><select name='service_"+x+"' class='form-control m-b' id='service_"+x+"' onchange='getTaskTypeByNumber("+x+")' required=''><option disabled='disabled' value='' selected='selected'>-- Select Service --</option><?=$this->admin_model->selectServices()?></select></div><label class='col-lg-2 control-label' for='role Unit'>Unit</label><div class='col-lg-3'><select name='unit_"+x+"' class='form-control m-b' id='unit_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Unit --</option><?=$this->admin_model->selectUnit()?></select></div></div><div class='form-group'><label class='col-lg-2 control-label' for='role Source'>Task Type</label><div class='col-lg-3'><select name='task_type_"+x+"' class='form-control m-b' id='task_type_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Task Type --</option></select></div><label class='col-lg-2 control-label' for='rate'>Special Rate</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='special_rate_"+x+"' data-maxlength='300' id='special_rate_"+x+"' step='any' ></div></div><div class='form-group'><label class='col-lg-2 control-label' for='rate'> Rate</label><div class='col-lg-3'><input type='number' onkeypress='return rateCode(event)' onblur='calculateMin()' class=' form-control' name='rate_"+x+"' data-maxlength='300' id='rate_"+x+"' step='any' required=''></div><label class='col-lg-2 control-label' for='role Currency'>Currency</label><div class='col-lg-3'><select name='currency_"+x+"' class='form-control m-b' id='currency_"+x+"' required=''><option disabled='disabled' value='' selected='selected'>-- Select Currency --</option><?=$this->admin_model->selectCurrency()?></select></div></div><hr>");
      }else if(type == 0){
        $("#resource_"+x).html("");
      }
  		$("select").select2();
  }
  
    // check if country = egy -> currency = egp
        function checkCountryEGYType1(x){           
            var country = $("#country_"+x).val();             
            if(country == "369"){                 
                $("#currency_"+x).val("1");
                $("#currency_"+x).select2().trigger('change');
                $("#currency_"+x).select2("readonly",true);
            }else{   
                $("#currency_"+x).select2("readonly", false);
            } 
        }
        
        function checkCountryEGYType3(x){
                    
            var option = $("#vendor[name=vendor_"+x+"] option:selected").attr('country');           
           if(option == "369"){   
                $("#currency_"+x).val("1");
                $("#currency_"+x).select2().trigger('change');
                $("#currency_"+x).select2("readonly",true);
            }else{                
                $("#currency_"+x).select2("readonly", false);
            }
               
                      
        }
</script>
