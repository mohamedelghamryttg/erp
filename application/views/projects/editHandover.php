<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Handover
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doEditHandover"  method="post" enctype="multipart/form-data">
                        <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>
                             <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                             <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                             <?php }else{ ?>
                             <input type="text" name="referer" value="<?=base_url()?>projects/handover" hidden>
                             <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Customer Name</label>

                                <div class="col-lg-6">
                                    <select name="customer_name" class="form-control m-b" id="customer_name" required="">
                                        <option></option>
                                        <?=$this->customer_model->selectCustomer($row->customer_name)?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Customer PM</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="customer_pm" value="<?= $row->customer_pm?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >TTG PM Name</label>

                                <div class="col-lg-6">
                                    <select name="ttg_pm_name" class="form-control m-b" id="ttg_pm_name" required="">
                                        <option></option>
                                        <?=$this->sales_model->selectPm($row->ttg_pm_name,$brand)?>
                                    </select>
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-lg-3 control-label" >Productline</label>

                                <div class="col-lg-6">
                                    <select name="productline" class="form-control m-b" id="productline" required="">
                                        <option></option>
                                    <?=$this->customer_model->selectProductLine($row->productline,1)?>
                                    </select>

                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" >Email subject</label>

                                <div class="col-lg-6">
                                <input type="text"class=" form-control" name="email_subject"value="<?= $row->email_subject?>"required=""/>

                                </div>
                            </div>
                             
                              <div class="form-group">
                                <label class="col-lg-3 control-label" >Service</label>

                                <div class="col-lg-6">
                                    <select name="service" class="form-control m-b" id="service" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectServices($row->service)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Subject Matter</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="subject_matter" value="<?= $row->subject_matter?>" required=""/>

                                </div>
                            </div>
                              <div class="form-group">
                                <label class="col-lg-3 control-label" >Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_language" class="form-control m-b" id="source_language" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectLanguage($row->source_language)?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group">
                                <label class="col-lg-3 control-label" >Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_language" class="form-control m-b" id="target_language" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectLanguage($row->target_language)?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Dialect</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="dialect" value="<?= $row->dialect?>" required=""/>

                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Tool</label>

                                <div class="col-lg-6">
                                    <select name="tool" class="form-control m-b" id="tool" required="">
                                        <option></option>
                                        <?=$this->sales_model->selectTools($row->tool)?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Source Format</label>

                                <div class="col-lg-6">
                                 <input type="text" class=" form-control" name="source_format"value="<?= $row->source_format?>"required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Source files location</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="source_files_location"value="<?= $row->source_files_location ?>" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Deliverables Format</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="deliverables_format"value="<?= $row->deliverables_format?>" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Delivery location</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="delivery_location"value="<?= $row->delivery_location ?>" required>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Number of files</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="number_of_files"value="<?= $row->number_of_files?>" required=""/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Files Names</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="files_names"value="<?= $row->files_names?>" required=""/>

                                </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" value="<?= $row->start_date?>" autocomplete="off"  class="form_datetime form-control" name="start_date" id="start_date" required=""/>
                              </div>
                          </div>

                         <div class="form-group">
                              <label class="control-label col-md-3">Delivery Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" value="<?= $row->delivery_date?>" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required=""/>
                              </div>
                          </div>
                           <div class="form-group">
                                <label class="col-lg-3 control-label">Volume</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control"value="<?= $row->volume?>" name="volume" id="volume" required=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required="" />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectUnit($row->unit)?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Total PO Amount</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="total_po_amount" value="<?= $row->total_po_amount?>" required=""/>

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
                                    <textarea name="customer_instructions" class=" form-control" ><?= $row->customer_instructions?></textarea>

                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Vendors to Avoid</label>

                                <div class="col-lg-6">
                                    <textarea name="vendors_to_avoid" class=" form-control" ><?= $row->vendors_to_avoid?></textarea>

                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Important comment</label>

                                <div class="col-lg-6">
                                    <textarea name="important_comment" class=" form-control" ><?= $row->important_comment?></textarea>

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
                            <select name='type_`+x+`' id='type_`+x+`'class='form-control m-b' value="" >
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
                            <input type='text' class='form-control'name='name_`+x+`' id='name_`+x+`'/>
                         </div>
                     </div> 
                      <div class="form-group">
                      <label class="control-label col-md-3">Resource Delivery Date</label>
                      <div class="col-md-6">
                          <input size="16" type="text" autocomplete="off" class="form_datetime form-control" name='resource_delivery_date_`+x+`' id='resource_delivery_date_`+x+`'/>
                      </div>
                  </div>
                        
                 <hr></div>`);
            var newInput = parseInt(x) + 1;
            $("#new_pair").val(newInput);
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