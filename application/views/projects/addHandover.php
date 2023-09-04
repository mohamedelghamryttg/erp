<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script>
$(document).ready(function(){
setTimeout(function(){
$(".mce-notification-warning").hide();
}, 1000);
});
</script>


<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Handover
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doAddHandover"  method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Customer Name</label>

                                <div class="col-lg-6">
                                    <select name="customer_name" class="form-control m-b" id="customer_name" required="">
                                        <option></option>
                                        <?=$this->customer_model->selectCustomer()?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Customer PM</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="customer_pm" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >TTG PM Name</label>

                                <div class="col-lg-6">
                                    <select name="ttg_pm_name" class="form-control m-b" id="ttg_pm_name" required="">
                                        <option></option>
                                        <?=$this->sales_model->selectPm(0,$brand)?>
                                    </select>
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-lg-3 control-label" >Productline</label>

                                <div class="col-lg-6">
                                    <select name="productline" class="form-control m-b" id="productline" required="">
                                        <option></option>
                                    <?=$this->customer_model->selectProductLine(0,1)?>
                                    </select>

                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" >Email subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="email_subject" required=""/>

                                </div>
                            </div>
                             
                              <div class="form-group">
                                <label class="col-lg-3 control-label" >Service</label>

                                <div class="col-lg-6">
                                    <select name="service" class="form-control m-b" id="service" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Subject Matter</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="subject_matter" required=""/>

                                </div>
                            </div>
                              <div class="form-group">
                                <label class="col-lg-3 control-label" >Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_language" class="form-control m-b" id="source_language" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group">
                                <label class="col-lg-3 control-label" >Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_language" class="form-control m-b" id="target_language" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Dialect</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="dialect" required=""/>

                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Tool</label>

                                <div class="col-lg-6">
                                    <select name="tool" class="form-control m-b" id="tool" required="">
                                        <option></option>
                                        <?=$this->sales_model->selectTools()?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Source Format</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="source_format" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Source files location</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="source_files_location" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Deliverables Format</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="deliverables_format" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Delivery location</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="delivery_location" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Number of files</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="number_of_files" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Files Names</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="files_names" required=""/>

                                </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required=""/>
                              </div>
                          </div>

                         <div class="form-group">
                              <label class="control-label col-md-3">Delivery Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required=""/>
                              </div>
                          </div>
                           <div class="form-group">
                                <label class="col-lg-3 control-label">Volume</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="volume" id="volume" required=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required="" />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectUnit()?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Total PO Amount</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="total_po_amount" required=""/>

                                </div>
                            </div> 
                            <hr>
                        <div id="pairs">
                            
                        </div>
                        <div class="form-group">
                          <div class="col-lg-offset-1 col-lg-6">
                              <a onclick="addNewPair()" class="btn btn-primary">Add Resource</a>
                              <a onclick="deletePair()" class="btn btn-danger">Delete Last One </a>
                              <input type="text" name="new_pair" id="new_pair" value="1" hidden>
                          </div>
                        </div>
                        <hr>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Customer Instructions</label>

                                <div class="col-lg-6">
                                    <textarea name="customer_instructions" class=" form-control" ></textarea>

                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Vendors to Avoid</label>

                                <div class="col-lg-6">
                                    <textarea name="vendors_to_avoid" class=" form-control" ></textarea>

                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Important comment</label>

                                <div class="col-lg-6">
                                    <textarea name="important_comment" class=" form-control" ></textarea>

                                </div>
                            </div>  
                            

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>projects/handOver" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div> 

    <script type="text/javascript">
        function addNewPair(){
            var x = $("#new_pair").val();
            $("#pairs").append(`
                <div id='pair_`+x+`'>
               <div class='form-group'>
                        <label class='col-lg-3 control-label'>Type</label>
                        <div class='col-lg-6'>
                            <select name='type_`+x+`' id='type_`+x+`'class='form-control m-b' value="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <option  value='1'>Translator</option>
                                <option  value='2'>Reviewer</option>
                                <option  value='3'>Proofreader</option>
                            </select>
                        </div>
                    </div> 
                     <div class='form-group'>
                        <label class='col-lg-3 control-label'>Name</label>
                        <div class='col-lg-6'>
                            <input type='text' class='form-control'name='name_`+x+`' id='name_`+x+`'>
                         </div>
                     </div> 
                      <div class="form-group">
                      <label class="control-label col-md-3">Resource Delivery Date</label>
                      <div class="col-md-6">
                          <input size="16" type="text" autocomplete="off" class="form_datetime form-control" name='resource_delivery_date_`+x+`' id='resource_delivery_date_`+x+`'>
                      </div>
                  </div>
                        
                 <hr></div>`);
            var newInput = parseInt(x) + 1;
            $("#new_pair").val(newInput);
        
        	$('.form_datetime').datetimepicker();
        }

        function deletePair() {
              var res = $("#new_pair").val();
              // alert(res);
              var newInput = parseInt(res) - 1;

              if(newInput >= 2){
                $("#pair_"+newInput).remove();
                // alert(newInput);
                $("#new_pair").val(newInput);   
              }else{
                alert("There's No Pairs To Delete ..");
              }
          }
    </script>