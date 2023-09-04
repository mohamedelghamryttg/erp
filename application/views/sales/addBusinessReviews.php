<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New 
            </header>
            
            <div class="panel-body"> 
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>sales/doAddBusinessReviews" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group"> 
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData();clearChoose()" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?php if($permission->view == 1){ ?>
                                             <?=$this->customer_model->selectExistingCustomerBySam(0,$this->user,$permission,$this->brand)?>
                                             <?php }else{
                                                if($this->role == 2){
                                                    echo $this->customer_model->selectCustomerByPm(0,$this->user,$permission,$this->brand);
                                                }elseif($this->role == 3){
                                                    echo $this->customer_model->selectExistingCustomerBySam(0,$this->user,$permission,$this->brand);
                                                }
                                                ?>
                                             <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                    
                                </div>
                            </div>  

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Contact Method">Contact Method</label>
                                <div class="col-lg-6">
                                    <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod()?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" style="overflow-x: auto;" id="customerContact">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="choose">Choose</label>
                                <label class="col-lg-1 control-label" for="SLA"><input type="radio" onchange="ChooseBusinessReviews()" value="1" name="type" id="type" required="">SLA</label>
                                <label class="col-lg-1 control-label" for="SLA"><input type="radio" onchange="ChooseBusinessReviews()" value="2" name="type" id="type">SIP</label>
                                <label class="col-lg-7 control-label" for="SLA"></label>
                            </div>

                            <div id="SLA">
                                
                            </div>
                            <div id="SIP">
                                
                            </div>
                                         
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>sales/BusinessReviews" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript">
        function ChooseBusinessReviews(){
            var type = $('input[type=radio][name=type]:checked').val();
            if(type == 1){
                var lead = $("#lead").val();
                if(lead === undefined){
                    $("#SLA").html(`<p style="color:red;text-align:center;">Please Check Customer First ..</p>`);
                }else{
                    $.ajaxSetup({
                        beforeSend: function(){
                          $('#loading').show();
                        },
                    });
                     $.post(base_url+"sales/checkSlaAttachment", {lead:lead} , function(data){
                        $('#loading').hide();
                        // alert(data);
                        $("#SLA").html(`
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="role name">Reason</label>

                            <div class="col-lg-6">
                                <select name="sla_reason" class="form-control m-b" id="sla_reason" required="">
                                    <option disabled="disabled" value="" selected="selected">-- Select Reason --</option>
                                    <?=$this->sales_model->SelectSlaReason()?></select>
                            </div>
                        </div>`+data+` `);
                    });
                }
                $("#SIP").html(``);
            }else if(type == 2){
                $("#SIP").html(`
                    <div  style="overflow: scroll;">
                        <table class="table table-striped table-hover table-bordered" id="datatables">
                            <thead>
                                <tr>
                                    <td>Issue</td>
                                    <td>Reason</td>
                                    <td>Improvement Owner</td>
                                    <td>Proposed Solution</td>
                                    <td>Due Date for Final feedback</td>
                                    <td>Status of resolution</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="sip_issue" class="form-control m-b" id="sip_issue" required="">
                                                 <option value="" selected="selected">-- Select Issue --</option>
                                                 <?=$this->sales_model->SelectSipIssue()?>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="sip_reason" required=""></textarea>
                                    </td>
                                    <td>
                                        <select name="sip_improvement_owner" class="form-control m-b" id="sip_improvement_owner" required="">
                                                 <option value="" selected="selected">-- Select User --</option>
                                                 <?=$this->admin_model->selectAllUsersByMail($this->brand)?>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="sip_proposed_solution" required=""></textarea>
                                    </td>
                                    <td>
                                        <input class="form_datetime form-control" type="text" name="sip_due_date" autocomplete="off" onchange="checkDate('sip_due_date')" id="sip_due_date" required="">
                                    </td>
                                    <td>
                                        <select name="sip_status_resolution" class="form-control m-b" id="sip_status_resolution" required="">
                                                 <option value="" selected="selected">-- Select Status --</option>
                                                 <option value="1">Opened</option>
                                                 <option value="2">Closed</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    `);
                $("#SLA").html(``);
            }else{
                $("#SIP").html(``);
                $("#SLA").html(``);
            }
            $('.form_datetime').datetimepicker();
            // $('#datatables').DataTable();
        }
        function clearChoose(){
            $("#type").prop("checked", false);
            $("#SIP").html(``);
            $("#SLA").html(``);
        }
    </script>