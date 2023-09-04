<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Project 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>ProjectManagment/doAddProject" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Project Name/Email subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" id="name" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="getCustomerData();clearJobs()" required />
                                             <option value="" selected="" disabled="">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerByPm(0,$pm,$permission,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">

                                </div>
                            </div>  
                  
                  			<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Product Lines</label>

                                <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" onchange="getPriceList();clearJobs()" required />
                                             <option disabled="disabled">-- Select Product Line --</option>
                                    </select>
                                </div>
                            </div>
              
              				<div id="new_job_div">
                                
                            </div>
                            <hr>
                            <div class="form-group">
                              <div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addResource()" class="btn btn-primary">Add Job +</a>
                                  <a onclick="deleteResource()" class="btn btn-danger">Delete Last One -</a>
                                  <input type="text" name="new_job" id="new_job" value="1" hidden>
                              </div>
                            </div>
                            <hr>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>projects" class="btn btn-default" type="button">Cancel</a>
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
    var input = $("#new_job").val();
    // alert(input);
    $("#new_job_div").append(`<div id='job_`+input+`'><hr><div class='form-group'><label class='col-lg-3 control-label' for='project name'>Job Name</label><div class='col-lg-6'><input type='text' class=' form-control' value='' name='jobName_`+input+`' id='jobName_`+input+`'></div></div><div class='form-group'><label class='col-lg-3 control-label'>Job Type</label><div class='col-lg-6'><select class=' form-control' name='job_type_`+input+`' id='job_type_`+input+`' required><option value='0'>Real Job</option><option value='1'>Free Job</option></select></div></div><div class='form-group'><label class='col-lg-3 control-label' for='role Services'>Services</label><div class='col-lg-6'><select name='service_`+input+`' class='form-control m-b' id='service_`+input+`' onchange='getPriceListByServiceAndIteration(`+input+`)' required=''><option disabled='disabled' value='' selected='selected'>-- Select Service --</option><?=$this->admin_model->selectServices()?></select></div></div><div class='form-group'><div class='col-lg-12'id='PriceList_`+input+`' style='overflow: scroll;max-height: 300px;'></div></div><div class='form-group'><label class='col-lg-3 control-label' for='role name'></label><div class='col-lg-6'id='fuzzy_`+input+`'></div></div><div class='form-group'><label class='col-lg-3 control-label'>Total Revenue</label><div class='col-lg-6'><input type='text' class=' form-control' readonly='readonly' name='total_revenue_`+input+`' id='total_revenue_`+input+`' required></div></div><div class='form-group'><label class='control-label col-lg-3'> Start Date</label><div class='col-lg-6'><input class='form_datetime form-control' type='text' value='<?=date('Y-m-d H:i:s')?>' name='start_date_`+input+`' autocomplete='off' onchange='checkDate("start_date_`+input+`")' id='start_date_`+input+`' required=''></div></div><div class='form-group'><label class='control-label col-lg-3'> Delivery Date</label><div class='col-lg-6'><input class='form_datetime form-control' type='text' name='delivery_date_`+input+`' autocomplete='off' onchange='checkDate("delivery_date_`+input+`")' id='delivery_date_`+input+`' required=''></div></div></div>`);
    var newInput = parseInt(input) + 1;
    // alert(newInput);
    $("#new_job").val(newInput); 
    // alert($("#new_job").val()); 
    $('.form_datetime').datetimepicker();
  }
  function deleteResource() {
    var input = $("#new_job").val();
    // alert(input);
    var newInput = parseInt(input) - 1;

    if(input > 1){
      $("#job_"+newInput).remove();
      // alert(newInput);
      $("#new_job").val(newInput);   
      // alert($("#new_job").val()); 
    }else{
      alert("There's No Jobs To Delete ..");
    }
  }

</script>