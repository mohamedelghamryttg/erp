<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Business Review</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>customer/doEditPriceList/<?=$id?>" method="post" enctype="multipart/form-data">
                <input type="text" name="id" value="<?=base64_encode($id)?>" hidden="">
                <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                <?php }else{ ?>
                <input type="text" name="referer" value="<?=base_url()?>sales/businessReviews" hidden>
                <?php } ?>

                <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer</label>
                            <div class="col-lg-6">
                                <select name="customer" class="form-control m-b" id="customer"  onchange="CustomerData();" required />
                                             <option value="" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectExistingCustomerBySam($row->customer,$this->user,$permission,$this->brand)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="LeadData">
                                <?=$this->customer_model->getLeadData($row->lead,$row->customer,$this->user)?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Contact Method</label>
                            <div class="col-lg-6">
                                  <select name="contact_method" class="form-control m-b" id="contact_method" onchange="getContacts()" required />
                                             <option value="" selected="selected">-- Contact Method --</option>
                                             <?=$this->sales_model->selectContactMethod($row->contact_method)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" style="overflow-x: auto;" id="customerContact">
                                 <?=$this->customer_model->getCustomerContact($row->lead,$row->contact_id)?>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Choose</label>
                                <input type="text" name="type" value="<?=$row->type?>" hidden="">
                                <?php
                                if($row->type == 1){
                                    echo ' <label class="col-lg-1 control-label" for="SLA">SLA</label>';
                                }else if($row->type == 2){
                                    echo '<label class="col-lg-1 control-label" for="SIP">SIP</label>';
                                }
                                ?>
                        </div>
                        <div id="SLA">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Reason</label>
                            <div class="col-lg-6">
                                 <select name="sla_reason" class="form-control m-b" id="sla_reason" required="">
                                        <option disabled="disabled" value="" selected="selected">-- Select Reason --</option>
                                        <?=$this->sales_model->SelectSlaReason($row->sla_reason)?></select>
                            </div>
                        </div>
                          <?php if($row->type == 1){
                                    $LeadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row()->sla_attachment;
                                    if(strlen($LeadData) > 0){
                                        echo $html = ' <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="role name">Download SLA Attachment</label>

                                                        <div class="col-lg-6">
                                                            <a href='.base_url().'assets/uploads/slaAttachment/'.$LeadData.'>Click Me</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="role name">Update SLA Attachment</label>

                                                        <div class="col-lg-6">
                                                            <input type="file" class=" form-control" name="sla_attachment" id="sla_attachment">
                                                        </div>
                                                    </div>
                                                    ';
                                    }else{
                                        echo $html = ' <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="role name">Attachment</label>

                                                        <div class="col-lg-6">
                                                            <input type="file" class=" form-control" name="sla_attachment" id="sla_attachment" required>
                                                        </div>
                                                    </div> ';
                                    } 
                                ?>
                                <?php } ?>
                            </div>
                            <div id="SIP">
                            <?php if($row->type == 2){ ?>
                        <div style="overflow: scroll;">
                            <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
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
                                                             <?=$this->sales_model->SelectSipIssue($row->sip_issue)?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea name="sip_reason" required=""><?=$row->sip_reason?></textarea>
                                                </td>
                                                <td>
                                                    <select name="sip_improvement_owner" class="form-control m-b" id="sip_improvement_owner" required="">
                                                             <option value="" selected="selected">-- Select User --</option>
                                                             <?=$this->admin_model->selectAllUsersByMail($this->brand,$row->sip_improvement_owner)?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea name="sip_proposed_solution" required=""><?=$row->sip_proposed_solution?></textarea>
                                                </td>
                                                <td>
                                                    <input class="form_datetime form-control" type="text" name="sip_due_date" autocomplete="off" onchange="checkDate('sip_due_date')" id="sip_due_date" value="<?=$row->sip_due_date?>" required="">
                                                </td>
                                                <td>
                                                    <select name="sip_status_resolution" class="form-control m-b" id="sip_status_resolution" required="">
                                                             <option value="" selected="selected">-- Select Status --</option>
                                                             <?php if($row->sip_status_resolution == 1){ ?>
                                                             <option value="1" selected="">Opened</option>
                                                             <option value="2">Closed</option>
                                                             <?php } ?>
                                                             <?php if($row->sip_status_resolution == 2){ ?>
                                                             <option value="1">Opened</option>
                                                             <option value="2" selected="">Closed</option>
                                                             <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>
                            </div>
                           
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>sales/BusinessReviews" class="btn btn-default" type="button">Cancel</a>
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
    </script>