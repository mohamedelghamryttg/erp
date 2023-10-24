<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add New Customer</h3>

            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url() ?>customer/doAddCustomerData" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Name</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="name" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Website</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" placeholder="EX: domain.com" name="website" required>			
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Client Type</label>
                        <div class="col-lg-6">
                            <select name="client_type" class="form-control m-b " id="client_type"  required >
                                <option value="" disabled="disabled" selected="selected">-- Select Type --</option>
                                <?= $this->sales_model->selectClientType() ?>
                            </select>		
                        </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer Profile</label>
                            <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="customer_profile" accept=".zip,.rar,.7zip">

                            </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Notes</label>
                            <div class="col-lg-6">
                                     <textarea name="notes" class="form-control" rows="7"></textarea>

                            </div>
                    </div>
        <hr/>
        <div class="form-group">
            <label class="col-lg-3 control-label font-weight-bold " >Customer Leads   
                <a onClick='AddLead()' id='Add_lead' class='btn btn-sm btn-clean' data-toggle="tooltip" data-placement="top" title="Add New Lead"><i class="fa fa-plus-circle" ></i></a>
            </label>            
        </div>
                   

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>customer" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
    
    <div id="leads" style='display:none' >                        
        <div class="card border border-default p-5 leadCard mb-2">
            <div class="form-group row">
                <label class="col-lg-3 control-label font-weight-bold " >Lead #<span class="lead_count">1</span>
               </label>   
                <div class="col-lg-9 text-right">
                    <a class='btn btn-sm btn-clean btn-icon p-0 delete_lead' data-toggle="tooltip" data-placement="top" title="Delete Lead"><i class="fa fa-trash" ></i></a>
                    <a class="btn btn-clean btn-sm p-0 collapseBtn" data-toggle="collapse" href="#multiCollapseExample_11" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-arrow-circle-down" ></i></a>
                </div>
            </div>
            <div class="collapse multi-collapse show" id="multiCollapseExample_11">
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label text-right">Region</label>
                    <div class="col-lg-4">
                        <select name="region[]" class="form-control m-b region" id="region_" onchange="getCountriesRow.call(this, event);" required />
                        <option disabled="disabled" selected="selected">-- Select Region --</option>
                        <?= $this->admin_model->selectRegion() ?>
                        </select>

                    </div>                   
                    <label class="col-lg-2 col-form-label text-right">Country</label>
                    <div class="col-lg-4">
                        <select name="country[]" class="form-control m-b country" id="country_" required />
                        <option disabled="disabled" selected="selected">-- Select Country --</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label text-right">Type</label>
                    <div class="col-lg-4">
                        <select name="type[]" class="form-control m-b" id="type" required />
                        <option disabled="disabled" selected="selected">-- Select Type --</option>
                        <?= $this->customer_model->selectType() ?>
                        </select>

                    </div>

                    <?php if ($permission2->follow == 3 || $permission2->follow == 2) { ?>

                        <label class="col-lg-2 col-form-label text-right">Status</label>
                        <div class="col-lg-4">
                            <select name="status[]" class="form-control m-b" id="status" required />
                            <option disabled="disabled" selected="selected">-- Select Status --</option>
                            <?= $this->customer_model->SelectStatus() ?>
                            </select>

                        </div>

                    <?php } ?>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label text-right">Source</label>
                    <div class="col-lg-4">
                        <select name="source[]" class="form-control m-b" id="source" required />
                        <option disabled="disabled" selected="selected">-- Select Source --</option>
                        <?= $this->customer_model->selectSource() ?>
                        </select>

                    </div>

                    <label class="col-lg-2 col-form-label text-right">Comment</label>
                    <div class="col-lg-4">
                        <textarea name="comment[]" class="form-control" value="" rows="2"></textarea>

                    </div>
                </div>                 
                  <div class="form-group contacts_title" >
                      <hr style="border-style: dashed"/>
                    <label class="col-lg-3 control-label font-weight-bold " >Lead Contacts  
                         <a onClick='AddContact.call(this, event);' class='btn btn-sm btn-clean p-0' data-toggle="tooltip" data-placement="top" title="Add New Contact"><i class="fa fa-plus-circle" ></i></a>
                   
                    </label>            
                </div>
            </div>
        </div>
    </div>
    <div id="contacts" style='display:none' >                        
        <div class="card border border-default p-3 contactCard mb-2" style="border-style: dashed!important">
            <div class="form-group row">
                <label class="col-lg-6 control-label font-weight-bold text-success" >Lead #<span class="lead_count">1</span> <i class="fa fa-arrow-alt-circle-right"></i> Contact #<span class="contact_count">1</span>
                     <a class='btn btn-sm btn-clean btn-icon p-0 delete_contact' data-toggle="tooltip" data-placement="top" title="Delete Contact" ><i class="fa fa-trash-alt" ></i></a>
               </label> 
            </div>
            <div class="form-group row mb-3">
                <label class="col-lg-1 col-form-label text-right">Name</label>
                <div class="col-lg-3">
                    <input type="text" class=" form-control" name="contactName_[]" data-maxlength="300" id="name" required>
                </div>
            
                <label class="col-lg-1 col-form-label text-right">Email</label>
                <div class="col-lg-3">
                    <input type="text" class=" form-control" name="contactEmail_[]" data-maxlength="300" id="email" required>
                </div>
          
                <label class="col-lg-1 col-form-label text-right">Phone</label>
                <div class="col-lg-3">
                    <input type="text" class=" form-control" name="contactPhone_[]" data-maxlength="300" id="phone" required>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-lg-1 col-form-label text-right pb-0">Skype Account</label>
                <div class="col-lg-3">
                    <input type="text" class=" form-control" name="contactSkype_[]" data-maxlength="300" id="skype" required>
                </div>
           
                <label class="col-lg-1 col-form-label text-right pb-0">Job Title</label>
                <div class="col-lg-3">
                    <input type="text" class=" form-control" name="contactJob_[]" data-maxlength="300" id="title" required>
                </div>
           
                <label class="col-lg-1 col-form-label text-right pb-0">Location</label>
                <div class="col-lg-3">
                    <input type="text" class=" form-control" name="contactLocation_[]" data-maxlength="300" id="title" required>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label class="col-lg-4 col-form-label text-right">Comment</label>
                <div class="col-lg-6">
                    <textarea name="contactComment_[]" class="form-control" rows="2"></textarea>

                </div>
            </div>

        </div>

    </div>
</div>
<script>
   
    function AddLead(){      
        $(".card-body .leadCard .multi-collapse").removeClass('show');
        $(".card-body .leadCard .collapseBtn").find('i').addClass('fa-arrow-circle-up').removeClass('fa-arrow-circle-down');
        $(".card-body").append($("#leads").html());       
        leadCount(); 
        $('html, body').animate({ scrollTop: $(".card-body .leadCard .multi-collapse.show").offset().top});
    }
    
    function AddContact(event){        
        $(this).closest(".leadCard").find('.collapse').append($("#contacts").html());  
        $('html, body').animate({ scrollTop: $(this).closest(".leadCard").find('.contactCard:last').offset().top});
         contactCount();
    }
    
    $(document).on("click",".delete_lead", function () {
        $(this).tooltip('hide');
        if (!confirm('Delete Lead , Are you sure?')) 
               return false;                 
        $(this).closest('.leadCard').remove();
        leadCount();
        contactCount();
    });
    
    $(document).on("click",".delete_contact", function () { 
        $(this).tooltip('hide');
        if (!confirm('Delete Contact , Are you sure?')) 
               return false;                 
        $(this).closest('.contactCard').remove();       
        contactCount();
       
    });
   
    function leadCount(){ 
        $('.card-body .leadCard').each(function(index, item) {
            var k = ++index;
            $(item).find('.lead_count').html(k);
            $(item).find('.collapseBtn').attr('href','#multiCollapseExample_'+k);
            $(item).find('.multi-collapse').attr('id','multiCollapseExample_'+k); 
            $(item).find('.multi-collapse select').each(function(i, it) {
                var old_name  =  $(it).attr('id').split('_', 1)[0];
                $(it).attr('id',old_name+'_'+k);   
            });
            $('.select2-container').remove();
            $('select').select2({dropdownCssClass: "selectheight"});
            $('.select2-container').css('width','100%');
        });
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    }
    
    function contactCount(){ 
        $('.card-body .leadCard').each(function(index, item) {             
            $(item).find('.lead_count').html(index+1);
            $(item).find('.contactCard').each(function(ind, ite) {
                 $(ite).find('.contact_count').html(++ind);
            });           
            $(item).find('.contactCard input').each(function(i, it) {
                var old_name  =  $(it).attr('name').split('_')[0];
                $(it).attr('name',old_name+'_'+index+'[]');   
            });           
            $(item).find('.contactCard textarea').each(function(i, it) {
                var old_name  =  $(it).attr('name').split('_')[0];
                $(it).attr('name',old_name+'_'+index+'[]');   
            });           
        });
        
    }  

    function getCountriesRow(event){       
        var region = $(this).val();
        var id = $(this).attr('id');
        var id_num = id.split('_')[1];        
        $.ajaxSetup({
            beforeSend: function(){
              $('#loading').show();
            },
        });
        $.post(base_url+"customer/getCountries", {region:region} , function(data){
            $('#loading').hide();              
            $("#country_"+id_num).html(data);            
        //    $("#country_"+id_num).select2.trigger('change');
        });
    }
    
    $(document).on("click",".collapseBtn", function () {      
       $(this).find('i').toggleClass('fa-arrow-circle-down fa-arrow-circle-up');
    });
</script>