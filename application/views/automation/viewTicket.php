<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .custom {
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
                            <tr>
                                <th colspan="2">Ticket Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <p class="text-success font-weight-bolder">Ticket From</p>
                                </td>
                                <td width="60%"><?= $this->automation_model->getEmpName($ticket->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Department</p>
                                </td>
                                <td><?= $this->automation_model->getEmpDep($ticket->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Date</p>
                                </td>
                                <td><?= $ticket->created_at ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Ticket Type</p>
                                </td>
                                <td>
                                    <?= $ticket->ticket_type ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Service Type</p>
                                </td>
                                <td>
                                    <?= $this->automation_model->getServiceType($ticket->service_type) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Subject</p>
                                </td>
                                <td>
                                    <?= $ticket->subject ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Description</p>
                                </td>
                                <td>
                                    <?= htmlspecialchars_decode(stripslashes($ticket->description)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Attachment</p>
                                </td>
                                <td>
                                    <?php if (strlen($ticket->file) > 1) { ?><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $ticket->file ?>" target="_blank">Click Here ..</a><?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Approval</p>
                                </td>
                                <td><span id="approvalStatus_text" class="text-<?= $this->automation_model->getTicketApproval($ticket->approval)['color'] ?>"><?= $this->automation_model->getTicketApproval($ticket->approval)['status'] ?>
                                    </span></td>
                            </tr>
                            <input type="hidden" id="send_flg" name="send_flg" value="<?= $ticket->send_flg ?>">
                            <?php switch ($ticket->approval):
                                case '1': ?>
                                    <tr>
                                        <td></td>
                                        <td><b>Sending To :</b>
                                            <?= $this->automation_model->getEmpName($ticket->emp_approval_id) . "<br>" . $ticket->emp_approval_email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>Sending At :</b>
                                            <?= $ticket->send_approval_at ?>
                                        </td>
                                    </tr>
                                <?php break;
                                case '2': ?>
                                    <tr>
                                        <td></td>
                                        <td><b>Approved By : </b>
                                            <?= $this->automation_model->getEmpName($ticket->emp_approval_id) . "<br>" . $ticket->emp_approval_email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td> <b>Sending At :</b>
                                            <?= $ticket->send_approval_at ?><br />
                                            <b>Approved At :</b>
                                            <?= $ticket->emp_approval_at ?? '' ?>

                                        </td>
                                    </tr>
                                <?php break;
                                case '3': ?>
                                    <tr>
                                        <td></td>
                                        <td><b>Rejected By :</b>
                                            <?= $this->automation_model->getEmpName($ticket->emp_approval_id) . "<br>" . $ticket->emp_approval_email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>Sending At :</b>
                                            <?= $ticket->send_approval_at ?><br />
                                            <b>Rejected At :</b>
                                            <?= $ticket->emp_approval_at ?? '' ?>
                                        </td>
                                    </tr>
                                <?php break;
                                default: ?>

                            <?php endswitch; ?>
                            </tr>

                            <?php if ($ticket->status == 3) { ?>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Closed BY</p>
                                    </td>
                                    <td>
                                        <?= $this->automation_model->getUserName($ticket->closed_by); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Closed AT</p>
                                    </td>
                                    <td>
                                        <?= $ticket->closed_at ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Action Type </p>
                                    </td>
                                    <td>
                                        <?= ($ticket->action_type == 1) ? 'YES' : 'NO' ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Status</p>
                                </td>
                                <td><span class="text-<?= $this->automation_model->getTicketStatus($ticket->status)['color'] ?>"><?= $this->automation_model->getTicketStatus($ticket->status)['status'] ?></span>
                                </td>
                            </tr>

                            <?php if ($ticket->status == 3) { ?>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Closed BY</p>
                                    </td>
                                    <td>
                                        <?= $this->automation_model->getUserName($ticket->closed_by); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Closed AT</p>
                                    </td>
                                    <td>
                                        <?= $ticket->closed_at ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Action Type </p>
                                    </td>
                                    <td> <?= ($ticket->action_type == 1) ? 'YES' : 'NO' ?></td>
                                </tr>
                            <?php } elseif ($ticket->status == 5) { ?>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Cancelled BY</p>
                                    </td>
                                    <td><?= $this->automation_model->getUserName($ticket->closed_by); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Cancelled AT</p>
                                    </td>
                                    <td><?= $ticket->closed_at ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-success font-weight-bolder">Comment </p>
                                    </td>
                                    <td> <?= $ticket->comment ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
                <?php if ($role == 1 || $role == 21) { ?>
                    <div class="card-footer">
                        <h6 class="custom">Change Type</h6>
                        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>automation/changeTicketType/<?= $ticket->id ?>" method="post">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-lg-right text-danger font-weight-bolder">Ticket Type</label>
                                <div class="col-lg-6">
                                    <select name="ticket_type" id="ticket_type" class="form-control m-b" required>
                                        <option selected="" value="" disabled>--Select Type--</option>
                                        <?= $this->automation_model->selectTicketType($ticket->ticket_type) ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button class="btn btn-light-primary" type="submit"><i class="fa fa-paper-plane"></i>Save</button>
                                </div>
                            </div>
                        </form>
                        <hr style="border:1px dashed #ddd" />
                        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>automation/changeServiceType/<?= $ticket->id ?>" method="post">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-lg-right text-danger font-weight-bolder">Service Type</label>
                                <div class="col-lg-6">
                                    <select name="service_type" id="service_type" class="form-control" required>
                                        <option selected="" value="" disabled>--Select Type--</option>
                                        <?= $this->automation_model->selectServiceTypes($ticket->service_type) ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
                <div class="card-footer">
                    <?php if (($ticket->status != 3 && $ticket->status != 5) && ($role == 1 || $role == 21)) { ?>
                        <h6 class="custom">Change Status</h6>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-lg-right font-weight-bolder">Status</label>
                            <div class="col-lg-2">
                                <select name="status" id='status' class="form-control" required onchange="checkStatus()">
                                    <option selected disabled value="">-- Select --</option>
                                    <option value="2" <?php if ($ticket->status == '2') {
                                                            echo "selected";
                                                        } ?>>In Progress</option>
                                    <option value="4" <?php if ($ticket->status == '4') {
                                                            echo "selected";
                                                        } ?>>Pending</option>
                                    <option value="3" <?php if ($ticket->status == '3') {
                                                            echo "selected";
                                                        } ?>>Closed</option>
                                    <option value="5" <?php if ($ticket->status == '5') {
                                                            echo "selected";
                                                        } ?>>Cancelled</option>

                                </select>
                            </div>

                            <label class="col-lg-2 col-form-label text-lg-right action_type_div font-weight-bold" style="display:none">Action Type:</label>
                            <div class="col-lg-2 action_type_div" style="display:none">
                                <select name="action_type" id='action_type' class="form-control">
                                    <option value="" <?php if ($ticket->action_type == '' || $ticket->action_type == null) {
                                                            echo "selected";
                                                        } ?>>-- Select --</option>
                                    <option value="1" <?php if ($ticket->action_type == '1') {
                                                            echo "selected";
                                                        } ?>>Yes</option>
                                    <option value="0" <?php if ($ticket->action_type == '0') {
                                                            echo "selected";
                                                        } ?>>No</option>
                                    <!-- <option value="1">Yes</option>
                                    <option value="0">No</option> -->
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label text-lg-right cancelled_comment_div font-weight-bold" style="display:none">Comment:</label>
                            <div class="col-lg-4 cancelled_comment_div" style="display:none">
                                <textarea name="cancelled_comment" id='cancelled_comment' class="form-control"></textarea>

                            </div>

                            <button class="btn btn-sm btn-dark col-lg-1" onclick="changeStatus()"><i class="fa fa-save"></i>Save</button>
                        </div>
                        <!-- //*********************** */ -->
                        <hr style="border:1px dashed #ddd" />
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-lg-right font-weight-bolder">Approval</label>
                            <div class="col-lg-3">

                                <select name="approvalStatus" id='approvalStatus' class="form-control">
                                    <option value="0" <?php if ($ticket->approval == '0' || $ticket->approval == null) {
                                                            echo "selected";
                                                        } ?>>NA Approval</option>
                                    <option value="1" <?php if ($ticket->approval == '1') {
                                                            echo "selected";
                                                        } ?>>Pending Approval</option>
                                    <option value="2" <?php if ($ticket->approval == '2') {
                                                            echo "selected";
                                                        } ?>>Approved</option>
                                    <option value="3" <?php if ($ticket->approval == '3') {
                                                            echo "selected";
                                                        } ?>>Rejected</option>
                                </select>


                            </div>
                            <button class="btn btn-sm btn-dark col-lg-1" id="app_send_btn" onclick="changeApprovalStatus()"><i class="fa fa-save"></i>Save</button>
                        </div>

                        <div class="form-group row action_App_div" style="display : none;">
                            <label class="col-lg-3 col-form-label text-lg-right font-weight-bolder">Approval From :</label>
                            <div class="col-lg-4 action_App_emp">
                                <select name="action_emp" id="action_emp" class="form-control" style="width: 100%;">
                                    <option selected="selected" value="">-- Select Employee Name --</option>
                                    <?= $this->admin_model->selectEmployees($ticket->emp_approval_id) ?>
                                </select>
                            </div>
                            <div class="col-lg-4 action_App_email">
                                <input type="text" name="emp_email" id="emp_email" class="form-control" readonly>
                            </div>
                        </div>

                    <?php } ?>
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

                <div id="collapse-collapsed" class="collapse show" aria-labelledby="heading-collapsed">
                    <div class="card-body">

                        <?php if (!empty($comments)) {
                            foreach ($comments as $comment) {
                                if ($this->automation_model->checkIfSoftwareMember($comment->emp_id)) { ?>
                                    <div class="d-flex flex-column mb-5 align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="symbol symbol-circle symbol-20 ml-2">
                                                    <img src="<?= base_url(); ?>assets/user.png" class="img-responsive" width="15px" />
                                                </div>

                                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">
                                                    <?= word_limiter($this->automation_model->getEmpName($comment->emp_id), 2, ''); ?>
                                                </a>
                                            </div>
                                            <span class="text-muted font-size-sm mr-2">
                                                <?= $comment->created_at ?>
                                            </span>
                                        </div>
                                        <div class="mt-2 rounded p-3 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-left max-w-800px  min-w-400px">
                                            <?= $comment->comment ?>
                                            <?php if (strlen($comment->file) > 1) { ?>
                                                <p><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $comment->file ?>" target="_blank">Click Here ..</a></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="d-flex flex-column mb-5 align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-20 mr-2">
                                                <img src="<?= base_url(); ?>assets/user.png" class="img-responsive" width="15px" />
                                            </div>
                                            <div>
                                                </a><span class="text-muted font-size-sm">
                                                    <?= $comment->created_at ?>
                                                </span>
                                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6 mr-2"><?= word_limiter($this->automation_model->getEmpName($comment->emp_id), 2, ''); ?>

                                            </div>
                                        </div>
                                        <div class="mt-2 rounded p-3 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-800px  min-w-400px">
                                            <?= $comment->comment ?>
                                            <?php if (strlen($comment->file) > 1) { ?>
                                                <p><a href="<?= base_url() ?>assets/uploads/automationTickets/<?= $comment->file ?>" target="_blank">Click Here ..</a></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php }
                        } else { ?>
                            <p>No data available.</p>
                        <?php } ?>
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
                            <input type="hidden" name="ticket_id" id="ticket_id" value="<?= $ticket->id ?>" />
                            <div class="form-group row">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>
                                <div class="col-lg-6">
                                    <textarea name="comment" class="form-control" rows="2" required="" placeholder="Type a message"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>
                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file" id="file">
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
        var appstatus_text = document.getElementById('approvalStatus_text').innerText
        if (status == 3) {
            if (appstatus_text == 'Pending Approval') {
                Swal.fire({
                    title: "A ticket cannot be closed requiring approval ...",
                    icon: "error",
                });
                $("select[name='status'] option[value='2']").prop('selected', true)
                return;
            } else {
                $(".action_type_div").show();
            }
        } else {
            $(".action_type_div").hide();
        }
        if (status == 5)
            $(".cancelled_comment_div").show();
        else
            $(".cancelled_comment_div").hide();

    }
    $(document).ready(function() {
        $("#approvalStatus").change(function() {
            appstatus = $(this).val();
            send_flg = $('#send_flg').val();

            if (appstatus == 1) {
                if (send_flg != 1) {
                    $(".action_App_div").show();
                    $('#app_send_btn').html("<i class='fa fa-envelope'></i>Send");
                } else {
                    $('#app_send_btn').html("<i class='fa fa-envelope'></i>Resend");
                }
            } else {
                $('#emp_email').val('');
                $(".action_App_div").hide();
                $('#app_send_btn').html("<i class='fa fa-save'></i>Save");
            }
        }).trigger('change');

        $("#action_emp").change(function() {
            employee_id = $(this).val();
            if (employee_id == '') {
                $("#emp_email").val('');
            } else {
                $.ajax({
                    url: "<?= base_url() . "automation/get_email" ?>",
                    type: "POST",
                    data: {
                        employee_id: employee_id
                    },
                    success: function(data) {
                        if (data != '') {
                            $("#emp_email").val(data);
                        } else {
                            $("#emp_email").val('');
                        }
                    }
                });

            }
        }).trigger('change');
    });

    function changeApprovalStatus() {
        var emp_email = $('#emp_email').val();
        var send_flg = $('#send_val').val();
        var emp_name = $('action_emp').value;
        var approvalStatus = $("select#approvalStatus option").filter(":selected").val();

        var approvalStatus_text = document.getElementById('approvalStatus').options[document.getElementById('approvalStatus').selectedIndex].text;;

        var chk_app_stat = document.getElementById('approvalStatus_text').innerText;

        if (approvalStatus_text == chk_app_stat) {
            return;
        }
        var mesg = "";
        if (approvalStatus == 1) {
            mesg = "Changing Approval Status And Send Email ...";
        } else {
            mesg = "Changing Approval Status ...";
        }
        if ((emp_email == '' || emp_name == '') && approvalStatus == 1) {
            Swal.fire({
                title: "Must Select Email to send it  ...",
                icon: "error",
            });
        } else {

            Swal.fire({
                title: mesg,
                text: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, do it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    //sendApprovalEmail//
                    var url = base_url + "automation/changeApprovalStatusTicket ?>";
                    var action_type = $("#action_type").val();
                    var emp_id = $('#action_emp').val();
                    var ticket_id = $('#ticket_id').val();

                    $.ajax({
                        url: "<?= base_url() . "automation/changeApprovalStatusTicket" ?>",
                        type: "POST",
                        data: {
                            emp_id: emp_id,
                            id: ticket_id,
                            approvalStatus: approvalStatus
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(data) {
                            if (data == '') {
                                Swal.fire(" Success ....!", "", "success").then(function() {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(" Send Failed ....!", "", "error")
                                $('#loading').hide();
                            }
                        }
                    });

                }
            });
        };
    }

    function changeStatus() {
        var status = $("select#status option").filter(":selected").val();
        var appstatus_text = document.getElementById('approvalStatus_text').innerText
        if (status == 0) {
            Swal.fire("Please Select Status", "", "error");
        } else {
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
                    var url = base_url + "automation/changeStatusTicket/<?= $ticket->id ?>";
                    var action_type = $("#action_type").val();
                    var status = $("select#status option").filter(":selected").val();
                    var comment = $("#cancelled_comment").val();
                    $.post(url, {
                        action_type: action_type,
                        status: status,
                        comment: comment
                    }).done(function(data) {
                        Swal.fire(" Success ....!", "", "success").then(function() {
                            window.location.reload();
                        });
                    });
                } else if (result.dismiss === "cancel") {
                    Swal.fire("Cancelled", "", "error");
                }
            });
        }
    }

    $(document).on("submit", "#saveComment", function(e) {

        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
        });
        $("#comments").load(window.location.href + " #comments");
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