<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <br/>
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
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">  Add Sales VM Ticket </h3>

            </div>
            <!--begin::Form-->
            <form class="form"  action="<?php echo base_url() ?>vendor/doAddSalesVmTicketMultiLang" onsubmit="return checkResouceNumberMultiLang()" method="post" enctype="multipart/form-data">
                <div class="card-body">
                     <h3 class="font-size-lg text-dark font-weight-bold mb-6 ml-5">1. Ticket Info :</h3>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Ticket Subject:</label>
                        <div class="col-lg-6">
                             <input type="text" class=" form-control" name="ticket_subject" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Request Type:</label>

                        <div class="col-lg-6">
                            <select name="request_type" onchange="ticketReqType()" class="form-control" id="request_type" required="">
                                <option value="" disabled='' selected=''>--Request Type --</option>
                                <?= $this->vendor_model->selectSalesTicketType() ?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row" id="resouceNumber">
                        <label class="col-lg-3 col-form-label text-right">Number Of Resources:</label>
                        <div class="col-lg-6">
                            <input maxlength="1" type="text" class=" form-control" onblur="return checkResouceNumberMultiLang()" name="number_of_resource" id="number_of_resource" onkeypress="return numbersOnly(event)" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Services:</label>

                        <div class="col-lg-6">
                            <select name="service" value="" onchange="getTaskType()" class="form-control" id="service" required>
                               <?= $this->admin_model->selectServices() ?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Task Type:</label>
                        <div class="col-lg-6">
                            <select name="task_type" class="form-control" id="task_type" required>
                                <option disabled="disabled" value="" selected="">-- Task Type --</option>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Count:</label>
                        <div class="col-lg-6">
                               <input type="number" onkeypress="return rateCode(event)" class=" form-control" name="count" data-maxlength="300" id="count" step="any" min=".01" required>
                     
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Unit:</label>

                        <div class="col-lg-6">
                            <select name="unit" class="form-control" id="unit" required>
                               <option disabled="disabled" value="" selected="selected">-- Select Unit --</option>
                                <?=$this->admin_model->selectUnit()?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" >Currency:</label>

                        <div class="col-lg-6">
                            <select name="currency" class="form-control" id="currency" required>
                                <option value="" disabled='' selected=''>--Select Currency --</option>
                                <?= $this->admin_model->selectCurrency() ?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Source Language:</label>
                        <div class="col-lg-6">
                            <select name="source_lang" class="form-control" id="source_lang" required>
                                <option value="" disabled='' selected=''>-- Select Source Language --</option>
                                <?= $this->admin_model->selectLanguage() ?>
                            </select>

                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Start Date:</label>
                        <div class="col-lg-6">
                            <input type="text" required="" value="<?= date("Y-m-d H:i:s", strtotime('1 min')) ?>" autocomplete="off" class="date_sheet_day form-control datetimepicker-input" data-toggle="datetimepicker" onchange="checkDate('start_date');" name="start_date" id="start_date" placeholder="Start Date">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Delivery Date:</label>
                        <div class="col-lg-6">
                            <input type="text"  required="" value="<?= date("Y-m-d H:i:s", strtotime('1 hour')) ?>" autocomplete="off" class="date_sheet_day form-control datetimepicker-input" data-toggle="datetimepicker"  onchange="checkDate('delivery_date');" name="delivery_date" id="delivery_date" placeholder="Delivery Date"/>
                  
                        </div>                     
                    </div>           
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Subject Matter:</label>
                        <div class="col-lg-6">
                            <select name="subject" class="form-control" id="subject" required  >
                                <option value="" disabled='' selected=''>-- Select Subject --</option>
                                <?= $this->admin_model->selectFields() ?>
                            </select>

                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Software:</label>
                        <div class="col-lg-6">
                            <select name="software" class="form-control" id="software" required >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->sales_model->selectTools() ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Attachment:</label>
                        <div class="col-lg-6">
                            <input type="file" class=" form-control" name="file" id="file">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Comment:</label>
                        <div class="col-lg-6">
                            <textarea name="comment" class="form-control" rows="6"></textarea>

                        </div>
                    </div>
                    <hr/>
                     <div class="form-group">
                        <label class="col-lg-3 control-label font-weight-bold " >2. Languages :   
                            <a onClick='AddLang()' id='Add_lang' class='btn btn-sm btn-clean' data-toggle="tooltip" data-placement="top" title="Add New Language"><i class="fa fa-plus-circle" ></i></a>
                        </label>            
                    </div>                   
                    <div class="card border border-default p-5  mb-2" style="border-style: dashed!important">
                       <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" width="50%">Target Language <span class="text-danger">*</span></th>
                                        <th scope="col"width="30%">Rate <span class="text-danger">*</span></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="langDiv">
                                    <tr class="langCard">
                                        <th scope="row" class="lang_count">1</th>
                                        <td>  
                                            <select name="target_lang[]" class="form-control" id="target_lang_1" required >
                                                <option value="" disabled='' selected=''>-- Select Target Language --</option>
                                                <?= $this->admin_model->selectLanguage() ?>
                                            </select>
                                        </td>
                                        <td>  
                                              <input type="number" onkeypress="return rateCode(event)" class=" form-control rate" name="rate[]" data-maxlength="300" id="rate" step="any" min="0" required>
                                        </td>
                                        <td></td>
                                    </tr>

                                </tbody>
                                </table>
                            </div>           
                            <a onClick='AddLang()' id='Add_lang' class='btn btn-sm btn-dark' data-toggle="tooltip" data-placement="top" title="Add Language"><i class="fa fa-plus-circle" ></i></a>
                      
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Save</button>
                            <a class="btn btn-secondary"  href="<?php echo base_url() ?>vendor/salesVmTickets" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
    <table  style='display:none' >
        <tbody id="languages">
            <tr class="langCard">
                <th scope="row" class="lang_count">2</th>
                <td>
                    <select name="target_lang[]" class="form-control" id="target_lang" required >
                        <option value="" disabled='' selected=''>-- Select Target Language --</option>
                        <?= $this->admin_model->selectLanguage() ?>
                    </select>
                </td>
                <td>  
                    <input type="number" onkeypress="return rateCode(event)" class=" form-control rate" name="rate[]" data-maxlength="300" id="rate" step="any" min="0" required>
                </td>
                <td>
                    <a class='btn btn-sm btn-clean btn-icon p-0 delete_lang' data-toggle="tooltip" data-placement="top" title="Delete Language"><i class="fa fa-trash" ></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>   
    function AddLang(){  
        $('#loading').show();           
        setTimeout( function(){ 
            $(".langDiv").append($("#languages").html());
            langCount();
            $('html, body').animate({ scrollTop: $(".card-body .langCard:last").offset().top},function() {
                $('#loading').hide();
           });  
          }  , 100 );
              
    }
      
    $(document).on("click",".delete_lang", function () {
        $(this).tooltip('hide');
        if (!confirm('Delete Language , Are you sure?')) 
               return false;                 
        $(this).closest('.langCard').remove();
        langCount();       
    });  
   
    function langCount(){ 
        $('.langDiv .langCard').each(function(index, item) {
            var k = ++index;
            $(item).find('.lang_count').html(k);           
            $(item).find('select').each(function(i, it) {
                var old_name  =  $(it).attr('id').split('_', 1)[0];
                $(it).attr('id',old_name+'_'+k);   
            });
            $('.select2-container').remove();
            $('select').select2({dropdownCssClass: "selectheight"});
            $('.select2-container').css('width','100%');
        });
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    }
    
    $(function() {
       $('.date_sheet_day').datetimepicker( {format: 'YYYY-MM-DD HH:mm:ss'}); 

    });
     
    function checkResouceNumberMultiLang(){
        var reqType = $("#request_type").val();
        var number = $("#number_of_resource").val();       
        var count = $("#count").val();
        if(reqType == 1 || reqType == 5 || reqType == 4){
            if(number < 1){
                alert("You must add 1 resource at least ..");
                return false;
            }
        }  
        var inputs = $(".rate").not(":last");
        for(var i = 0; i < inputs.length; i++){
             if($(inputs[i]).val() <= 0){
                if(reqType != 2){
                    alert("Rate should be more than 0 ");
                    return false;
                }else if(reqType == 2 && rate < 0){
                     alert("Rate should be equal or more than 0");
                    return false;
                }
            }
           
        }

        if(count <= 0){
            alert("Count should be more than 0 ");
            return false;
        }
    }
</script>