<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Customer Portal</h3>

            </div>
            <!--begin::Form-->
            <form class="form" id="myForm" method="post" enctype="multipart/form-data">
                <input id='id' name='id' value="<?= base64_encode($contact->id) ?>" hidden>
                <div class="card-body">
                    <input type="text" id="customer" name="customer" value="<?= base64_encode($contact->customer) ?>" hidden>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Link</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="link" data-maxlength="300" id="link" value="<?= $contact->link ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Portal Name</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="portal" data-maxlength="300" id="portal" value="<?= $contact->portal ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">User Name</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="username" data-maxlength="300" id="username" value="<?= $contact->username ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Password</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="password" data-maxlength="300" id="password" value="<?= $contact->password ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Additional Information</label>
                        <div class="col-lg-6">
                            <textarea name="additional_info" class="form-control" rows="6"><?= $contact->additional_info ?></textarea>
                        </div>
                    </div>

                    <input type="text" id="fileToDelete" name="fileToDelete" value="<?= $contact->customer_profile ?>" hidden>
                    <?php if ($role != 19) { ?>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer Profile</label>
                            <div class="col-lg-6">

                                <input type="file" class="form-control" id="customer_profile" name="customer_profile" accept=".zip,.rar,.7zip">

                            </div>
                        </div>
                        <div class="form-group row">

                            <?php if ($contact->customer_profile && $contact->customer_profile != '') { ?>
                                <div class="col-lg-6 text-right">
                                    <a class="btn btn-sm btn-success my-3" href="<?= base_url() . 'assets/uploads/customer_profiles/' . $contact->customer_profile ?>">View Profile</a>
                                    <button type="button" id="linkToDelete" class="btn btn-sm btn-primary">Delete Profile</button>
                                    <!-- <a class="btn btn-sm btn-primary" onclick="return confirm('Are you sure you want to delete this Customer ?');" href="<?= base_url() . 'assets/uploads/customer_profiles/' . $contact->customer_profile ?>">Remove Profile</a> -->
                                </div>
                            <?php } ?>

                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer Profile Notes</label>
                            <div class="col-lg-6">
                                <textarea name="notes" class="form-control" rows="10"><?= $contact->notes ?></textarea>

                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button id="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>customer/customerPortal?t=<?= base64_encode($contact->customer) ?>" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var varid = $("#customer").val();
        var id = $("#id").val();
        var url = "<?php echo base_url() ?>customer/doEditCustomerPortal";
        $("#myForm").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: url,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    if (result === "success") {
                        location.href = "<?php echo base_url() ?>customer/customerPortal?t=" + varid;
                    } else {
                        location.href = "<?php echo base_url() ?>customer/editCustomerPortal?t=" + id;
                    }
                },
                error: function() {

                }
            });
        });
        $("#linkToDelete").on('click', function() {
            var file_toDelete = $('#fileToDelete').val()
            if (file_toDelete && file_toDelete != '') {
                if (confirm('Are you sure you want to delete Profile File Uploaded ?')) {
                    $.ajax({
                        method: 'POST',
                        url: "<?= base_url() . "customer/fileToDelete" ?>",
                        data: {
                            'id': id,
                            'file_toDelete': file_toDelete
                        },
                        success: function(result) {
                            if (result === "success") {
                                alert("Success Deleted File ");
                                location.href = "<?php echo base_url() ?>customer/editCustomerPortal?t=" + id;
                            } else {
                                alert("File Failed to Deleted ");
                            }
                        },
                        error: function() {
                            alert("File Failed to Deleted ");
                        }
                    });
                }
            }
        })
    });
</script>