<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add New Project</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>projects/doAddProject" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                
                <div class="card-body">
                
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                            <div class="col-lg-6">
                                 <input type="text" class=" form-control" name="name" id="name" autocomplete="off" required>            
                            </div>
                        </div>
						
                		<div class="form-group row">
												<label class="col-form-label text-right col-lg-3 col-sm-12">No Icon</label>
												<div class="col-lg-4 col-md-9 col-sm-12">
													<input type="text" class="form-control form-control-solid datetimepicker-input" id="kt_datetimepicker_5" placeholder="Select date &amp; time" data-toggle="datetimepicker" data-target="#kt_datetimepicker_5" />
												</div>
											</div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer</label>
                            <div class="col-lg-6">
                                <select name="customer" class="form-control m-b" id="customer"  onchange="getCustomerData();clearJobs()" required />
                                             <option value="" selected="" disabled="">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerByPm(0,$pm,$permission,$brand)?>
                                    </select>  
                            </div>
                        </div>  

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="LeadData">           
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Product Lines</label>
                            <div class="col-lg-6">
                                 <select name="product_line" class="form-control m-b" id="product_line" onchange="getPriceList();clearJobs()" required />
                                             <option disabled="disabled">-- Select Product Line --</option>
                                    </select>          
                            </div>
                        </div>

                        <div id="new_job_div">
                            </div>
                        <hr>

                        <div class="form-group row">
                            <div class="col-lg-offset-1 col-lg-6">
                                <a onclick="addResource()" class="btn btn-primary">Add Job +</a>
                                <a onclick="deleteResource()" class="btn btn-danger">Delete Last One -</a>
                                <input type="text" name="new_job" id="new_job" value="1" hidden>        
                            </div>
                        </div>
                        <hr>
                        

                        </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>projects" class="btn btn-default" type="button">Cancel</a>
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
  function addResource(){
    var input = $("#new_job").val();
    // alert(input);
    $("#new_job_div").append(`<div id='job_`+input+`'><hr><div class='form-group'><label class='col-lg-3 control-label' for='project name'>Job Name</label><div class='col-lg-6'><input type='text' class=' form-control' value='' name='jobName_`+input+`' id='jobName_`+input+`'></div></div><div class='form-group'><label class='col-lg-3 control-label' for='role Services'>Services</label><div class='col-lg-6'><select name='service_`+input+`' class='form-control m-b' id='service_`+input+`' onchange='getPriceListByServiceAndIteration(`+input+`)' required=''><option disabled='disabled' value='' selected='selected'>-- Select Service --</option><?=$this->admin_model->selectServices()?></select></div></div><div class='form-group'><div class='col-lg-12'id='PriceList_`+input+`' style='overflow: scroll;max-height: 300px;'></div></div><div class='form-group'><label class='col-lg-3 control-label' for='role name'></label><div class='col-lg-6'id='fuzzy_`+input+`'></div></div><div class='form-group'><label class='col-lg-3 control-label'>Total Revenue</label><div class='col-lg-6'><input type='text' class=' form-control' readonly='readonly' name='total_revenue_`+input+`' id='total_revenue_`+input+`' required></div></div><div class='form-group'><label class='control-label col-lg-3'> Start Date</label><div class='col-lg-6'><input class='form_datetime form-control' type='text' value='<?=date('Y-m-d H:i:s')?>' name='start_date_`+input+`' autocomplete='off' onchange='checkDate("start_date_`+input+`")' id='start_date_`+input+`' required=''></div></div><div class='form-group'><label class='control-label col-lg-3'> Delivery Date</label><div class='col-lg-6'><input class='form_datetime form-control' type='text' name='delivery_date_`+input+`' autocomplete='off' onchange='checkDate("delivery_date_`+input+`")' id='delivery_date_`+input+`' required=''></div></div></div>`);
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