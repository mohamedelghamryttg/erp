<!--vendor portal modal-->
<div class="modal fade" id="VendorPortalModal_<?=$row->id?>"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Assign Task To Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="TaskVendorModule_<?=$row->id?>" class="cmxform form-horizontal " action="<?= base_url() ?>projectManagment/doAddTaskVendorModule" method="post" onsubmit="return addTaskForm();disableAddButton();" enctype="multipart/form-data">

                    <input type="text" name="job_id" value="<?= base64_encode($row->id) ?>" hidden="">

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Mail Subject</label>

                        <div class="col-lg-9">
                            <input type="text" class=" form-control" value="<?= $row->name ?>" name="subject" id="subject" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                        <div class="col-lg-9">
                            <select name="task_type" class="form-control m-b" onchange="getVendorByTask('<?= $priceList->service ?>', '<?= $priceList->source ?>', '<?= $priceList->target ?>');getVendorData('<?= $priceList->source ?>', '<?= $priceList->target ?>')" id="task_type" required />
                            <option disabled="disabled" selected=""></option>
                            <?= $this->admin_model->selectTaskType(0, $priceList->service) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role Select Vendor">Select Vendor</label>

                        <div class="col-lg-9">
                            <select name="vendor" onchange="getVendorData('<?= $priceList->source ?>', '<?= $priceList->target ?>')" class="form-control m-b" id="vendor" required />
                            <option disabled="disabled" selected=""></option>
                            <?= $this->vendor_model->selectVendorByJob(0, $priceList->source, $priceList->target, $priceList->service, $brand) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role name"></label>
                        <div class="col-lg-9" id="vendorData">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Count</label>

                        <div class="col-lg-9">
                            <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" onblur="calculateVendorCostChecked()" name="count" id="count" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Total Cost</label>

                        <div class="col-lg-9">
                            <input type="text" class=" form-control" readonly="readonly" name="total_cost" id="total_cost" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Start Date</label>
                        <div class="col-md-9">
                            <input size="16" type="text" onchange="checkDate('start_date')" value="<?= date("Y-m-d H:i:s") ?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Delivery Date</label>
                        <div class="col-md-9">
                            <input size="16" type="text" onchange="checkDate('delivery_date')" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role Time Zone">Time Zone</label>

                        <div class="col-lg-9">
                            <select name="time_zone" class="form-control m-b" id="time_zone" required />
                            <option disabled="disabled" selected=""></option>
                            <?= $this->admin_model->selectTimeZone() ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                        <div class="col-lg-9">
                            <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="insrtuctions">Instructions</label>

                        <div class="col-lg-9">
                            <textarea name="insrtuctions" class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                     <div class="form-group row">
                         <div class="col-lg-9"></div>
                            <input class="btn btn-primary disableAdd " type="submit" value="Save" onclick="$('#TaskVendorModule_<?=$row->id?>').submit();">
                    
                </form>

            </div>        
              <div class="modal-footer">
               
                <button type="button" class="btn btn-primary disableAdd saveTask" data-form="TaskVendorModule_<?=$row->id?>" >
                   Save
                </button>
            </div>
        </div>
    </div>
</div>

<!--vendor modal-->

<div class="modal fade" id="VendorModal_<?=$row->id?>"  role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Assign Task To Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="TaskVendor" class="cmxform form-horizontal " action="<?= base_url() ?>projects/doAddTask" method="post" onsubmit="return addTaskForm();disableAddButton();" enctype="multipart/form-data">

                    <input type="text" name="job_id" value="<?= base64_encode($row->id) ?>" hidden="">

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Mail Subject</label>

                        <div class="col-lg-9">
                            <input type="text" class=" form-control" value="<?= $row->name ?>" name="subject" id="subject" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                        <div class="col-lg-9">
                            <select name="task_type" class="form-control m-b" onchange="getVendorByTask('<?= $priceList->service ?>','<?= $priceList->source ?>','<?= $priceList->target ?>');getVendorData('<?= $priceList->source ?>','<?= $priceList->target ?>')" id="task_type" required />
                            <option disabled="disabled" selected=""></option>
                            <?= $this->admin_model->selectTaskType(0, $priceList->service) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role Select Vendor">Select Vendor</label>

                        <div class="col-lg-9">
                            <select name="vendor" onchange="getVendorData('<?= $priceList->source ?>','<?= $priceList->target ?>')" class="form-control m-b" id="vendor" required />
                            <option disabled="disabled" selected=""></option>
                            <?= $this->vendor_model->selectVendorByJob(0, $priceList->source, $priceList->target, $priceList->service, $brand) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role name"></label>
                        <div class="col-lg-9" id="vendorData">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Count</label>

                        <div class="col-lg-9">
                            <input type="text" class=" form-control" onkeypress="return numbersOnly(event)" onblur="calculateVendorCostChecked()" name="count" id="count" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Total Cost</label>

                        <div class="col-lg-9">
                            <input type="text" class=" form-control" readonly="readonly" name="total_cost" id="total_cost" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Start Date</label>
                        <div class="col-md-6">
                            <input size="16" type="text" onchange="checkDate('start_date')" value="<?= date("Y-m-d H:i:s") ?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Delivery Date</label>
                        <div class="col-md-6">
                            <input size="16" type="text" onchange="checkDate('delivery_date')" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role Time Zone">Time Zone</label>

                        <div class="col-lg-9">
                            <select name="time_zone" class="form-control m-b" id="time_zone" required />
                            <option disabled="disabled" selected=""></option>
                            <?= $this->admin_model->selectTimeZone() ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>

                        <div class="col-lg-9">
                            <input type="file" class=" form-control" name="file" id="file" accept="'application/zip'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="insrtuctions">Instructions</label>

                        <div class="col-lg-9">
                            <textarea name="insrtuctions" class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save" form="TaskVendor">
                    <input class="btn btn-danger" type="reset"  value="Reset">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<script>
    $( ".saveTask" ).on( "click", function( event ) {
        event.preventDefault();       
        var form = $( this ).attr("data-form");
         addTaskForm();
     //   disableAddButton();
        console.log(form);
        console.log( $("#"+form).serialize() );
        var dataString =  $("#"+form).serialize() ;
        $.post(base_url+"ProjectManagment/doAddTaskVendorModule", dataString , function(data){
   
            //$("#product_line").html(data);
            });
      });
</script>