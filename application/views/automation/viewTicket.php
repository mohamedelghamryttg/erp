<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
  .custom{
  font-weight: 700;
  color: #B5B5C3 !important;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.1rem;
}
.card-header .fa.custom {
  transition: .3s transform ease-in-out;
}
.card-header .collapsed .fa.custom {
  transform: rotate(90deg);
}
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
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
            <!-- start search form card --> 
            <div class="card card-custom gutter-b example example-compact" id='ticket_info'>
                <div class="card-header">
                    <h3 class="card-title text-danger"> View Ticket #<?= $ticket->id ?></h3>
                </div>
                <div class="card-body">
                    <table class="table table-head-custom table-hover" width="100%" id="kt_datatable2">
                        <thead>
                            <tr><th colspan="2">Ticket Info</th></tr>
                        </thead>
                        <tbody>                            
                            <tr>
                                <td width="40%"><p class="text-success font-weight-bolder">Ticket From</p></td>
                                <td width="60%"><?= $this->automation_model->getEmpName($ticket->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Function</p></td>
                                <td><?= $this->automation_model->getEmpDep($ticket->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Date</p></td>
                                <td><?= $ticket->created_at ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Ticket Type</p></td>
                                <td><?= $ticket->ticket_type ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Service Type</p></td>
                                <td><?= $this->automation_model->getServiceType($ticket->service_type) ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Subject</p></td>
                                <td><?= $ticket->subject ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Description</p></td>
                                <td><?= $ticket->description ?></td>
                            </tr>
                            <tr>
                                <td><p class="text-success font-weight-bolder">Attachment</p></td>
                                <td><?php if (strlen($ticket->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $ticket->file ?>" target="_blank">Click Here ..</a><?php } ?></td>
                            </tr> 
                            <tr>
                                <td><p class="text-success font-weight-bolder">Status</p></td>
                                <td><span class="text-<?=$this->automation_model->getTicketStatus($ticket->status)['color']?>"><?= $this->automation_model->getTicketStatus($ticket->status)['status'] ?></span></td>                               
                            </tr>
                            <?php if($ticket->status == 3){?>
                            <tr> 
                                <td><p class="text-success font-weight-bolder">Closed BY</p></td>
                                <td><?= $this->automation_model->getUserName($ticket->closed_by); ?></td>
                            </tr>
                            <tr> 
                               <td><p class="text-success font-weight-bolder">Closed AT</p></td>
                                <td><?= $ticket->closed_at ?></td>
                            </tr>
                            <tr> 
                                <td><p class="text-success font-weight-bolder">Action Type </p></td>
                                <td> <?= ($ticket->action_type==1)?'YES':'NO' ?></td>                               
                            </tr>                           
                            <?php }?>
                           
                        </tbody>
                    </table>
                </div>
                 <?php if($role == 1 || $role== 21){?>
                <div class="card-footer">
                    <h6 class="custom">Change Type</h6>
                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>automation/changeTicketType/<?=$ticket->id?>" method="post" >
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-lg-right text-danger font-weight-bolder">Ticket Type</label>
                            <div class="col-lg-6">
                                <select name="ticket_type" id="ticket_type" class="form-control m-b" required>
                                <option  selected="" value="" disabled>--Select Type--</option>
                              <?= $this->automation_model->selectTicketType($ticket->ticket_type) ?>
                            </select>                                                   
                            </div> 
                            <div class="col-lg-3">
                                <button class="btn btn-light-primary" type="submit"><i class="fa fa-paper-plane"></i>Save</button>
                            </div>
                        </div>
                    </form>
                    <hr style="border:1px dashed #ddd" />
                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>automation/changeServiceType/<?=$ticket->id?>" method="post" >
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-lg-right text-danger font-weight-bolder">Service Type</label>
                            <div class="col-lg-6">
                                <select name="service_type" id="service_type" class="form-control" required>
                                        <option  selected="" value="" disabled>--Select Type--</option>
                                      <?= $this->automation_model->selectServiceTypes($ticket->service_type) ?>
                                    </select>                                               
                            </div>  
                            <div class="col-lg-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                 <?php }?>
                <div class="card-footer">
                    <?php if($ticket->status !=3 && ($role == 1 || $role== 21)){?>
                    <h6 class="custom">Change Status</h6>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right font-weight-bolder">Status</label>
                        <div class="col-lg-2">
                            <select name="status" id='status' class="form-control" required onchange="checkStatus()">
                                <option  value="2">In Progress</option>
                                <option  value="3">Closed</option>                                    
                            </select>
                        </div>        

                        <label class="col-lg-2 col-form-label text-lg-right action_type_div font-weight-bold" style="display:none">Action Type:</label>
                        <div class="col-lg-2 action_type_div" style="display:none"> 
                            <select name="action_type" id='action_type' class="form-control">
                                <option  value="1">Yes</option>
                                <option  value="0">No</option>                                    
                            </select>                     
                        </div>
                        <button class="btn btn-sm btn-dark col-lg-1"  onclick="changeStatus()"><i class="fa fa-save"></i>Save</button>
                    </div>
                    <?php }?>
                </div>
            </div>
            
<!--comments section like photo / user name / comment / attach-->

            <div class="card card-custom gutter-b comments" id="comments">            
                <div class="card-header">
                   <h3 class="card-title text-danger">
                       <a class="collapsed d-block" data-toggle="collapse" href="#collapse-collapsed" aria-expanded="true" aria-controls="collapse-collapsed" id="heading-collapsed">
                            <i class="fa fa-chevron-right  custom mr-3"></i>
                            Comments 
                       </a>
                   </h3>
                    
                </div>
<!--                <div id="collapse-collapsed" class="collapse show" aria-labelledby="heading-collapsed">
                    <div class="card-body">
                        <?php if(!empty($comments)) { foreach ($comments as $comment){?>                      
                        <div class="row mt-5" style="border-bottom:1px dashed #ddd">
                            <div class="col-md-2">
                                <img src="<?= base_url();?>assets/user.png" class="img-responsive" width="15px"/>
                               <span class="text-success font-weight-bolder"><?=word_limiter($this->automation_model->getEmpName($comment->emp_id),2,''); ?></span>                                
                            </div>                            
                            <div class="col-md-7">
                                <p><?=$comment->comment?></p>
                                <p><?php if (strlen($comment->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $comment->file ?>" target="_blank">Click Here ..</a><?php } ?></p>
                            </div>
                            <div class="col-md-3 custom">
                              <i class="fa fa-clock fa-xs"></i> <span ><?=$comment->created_at?></span>                               
                            </div>
                        </div>
                        <?php }}else{?>
                        <p>No data available.</p>
                        <?php }?>
                    </div>
                </div>-->
                <div id="collapse-collapsed" class="collapse show" aria-labelledby="heading-collapsed">
                    <div class="card-body">
                                        
                        <?php if(!empty($comments)) { foreach ($comments as $comment){
                            if($this->automation_model->checkIfSoftwareMember($comment->emp_id)){?> 
                              <div class="d-flex flex-column mb-5 align-items-end">
                                <div class="d-flex align-items-center">
                                        <div>
                                                <span class="text-muted font-size-sm mr-2"><?=$comment->created_at?></span>
                                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6"><?=word_limiter($this->automation_model->getEmpName($comment->emp_id),2,''); ?></a>
                                        </div>
                                        <div class="symbol symbol-circle symbol-20 ml-2">
                                                <img src="<?= base_url();?>assets/user.png" class="img-responsive" width="15px"/>
                                        </div>
                                </div>
                                <div class="mt-2 rounded p-3 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-800px  min-w-400px"><?=$comment->comment?> 
                                <?php if (strlen($comment->file) > 1) { ?><p><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $comment->file ?>" target="_blank">Click Here ..</a></p><?php } ?>
                                </div>
                        </div>
                            <?php }else{?> 
                          <div class="d-flex flex-column mb-5 align-items-start">
                                <div class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-20 mr-2">
                                               <img src="<?= base_url();?>assets/user.png" class="img-responsive" width="15px"/>
                                        </div>
                                        <div>
                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6 mr-2"><?=word_limiter($this->automation_model->getEmpName($comment->emp_id),2,''); ?></a>
                                            <span class="text-muted font-size-sm"><?=$comment->created_at?></span>
                                        </div>
                                </div>
                                <div class="mt-2 rounded p-3 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-800px  min-w-400px"><?=$comment->comment?> 
                                    <?php if (strlen($comment->file) > 1) { ?><p><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $comment->file ?>" target="_blank">Click Here ..</a></p><?php } ?>
                                </div>
                        </div>
                            <?php }?>                       
                        <?php }}else{?>
                        <p>No data available.</p>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="card card-custom gutter-b example example-compact">            
                <div class="card-header">
                    <h3 class="card-title text-danger"> Reply <i class='fa fa-reply-all pl-2'></i></h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form class="cmxform form-horizontal " id="saveComment" method="post" action="<?php echo base_url() ?>automation/sendReply" enctype="multipart/form-data">
                            <input type="hidden" name="ticket_id" value="<?=$ticket->id?>"/>
                            <div class="form-group row">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>
                                <div class="col-lg-6">
                                    <textarea name="comment" class="form-control" rows="2" required="" placeholder="Type a message"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>
                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file" >
                                </div>
                            </div>                                           
                            <div class="form-group row">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">         
    function checkStatus() {  
        var status = $("select#status option").filter(":selected").val();
      
        if(status == 3)         
            $(".action_type_div").show();
        else
            $(".action_type_div").hide();
         
    }
    function changeStatus() { 
        Swal.fire({
            title: "Changing Status ...",
            text: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                var url = base_url + "automation/changeStatusTicket/<?=$ticket->id?>";
                var action_type = $("#action_type").val();   
                var status = $("select#status option").filter(":selected").val();
                $.post(url, {action_type: action_type, status: status} ).done(function( data ) {
                    Swal.fire( " Success ....!",  "" , "success").then(function () {
                        window.location.reload();
                    }); 
                });
            } else if (result.dismiss === "cancel") {
                Swal.fire("Cancelled", "" , "error" );
            }
        });
    } 
    
    $(document).on("submit", "#saveComment", function(e)
       {
                
            e.preventDefault();           
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false
            });        
            $( "#comments" ).load(window.location.href + " #comments" );
            $('.collapse').collapse("show");
            $('#saveComment').trigger("reset");
            Swal.fire({
                position: "top-right",
                icon: "success",
                title: "Your Message has been saved",
                showConfirmButton: false,
                timer: 1500
            });
       });
        
</script>