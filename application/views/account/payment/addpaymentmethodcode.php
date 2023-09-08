<script src="<?php echo base_url(); ?>assets_new/js/ckeditor/ckeditor.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add Payment Method</h3>
            </div>
            <!--begin::Form-->
            <form class="form" id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Payment Method</label>
                        <div class="col-lg-6">
                            <input name="name" id="name" class="form-control required" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right">Payment Type</label>
                        <div class="col-lg-6">
                            <select name="type" class="form-control m-b" id="type" required>
                                <option value="">-- Select Type --</option>
                                <option value="1"> Cash </option>
                                <option value="2"> Bank </option>
                                <option value="3"> Credit Card </option>
                                <option value="4"> Other </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="select_bank">
                        <label class="col-lg-3 col-form-label text-right">Bank</label>
                        <div class="col-lg-6">
                            <select name="bank" class="form-control m-b" id="bank" required>
                                <option value="" selected>-- Select Bank --</option>
                                <?= $this->AccountModel->selectCombo_New('bank') ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="account_no">
                        <label class="col-lg-3 col-form-label text-right">Account Code</label>
                        <div class="col-lg-6">
                            <input name="acc_code" id="acc_code" class="form-control " required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Currency</label>
                        <div class="col-lg-6">
                            <select name="currency_id" class="form-control required m-b" id="currency_id" required>
                                <option value="">-- Select Currency --</option>
                                <?= $this->AccountModel->selectCurrency() ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="account_code">
                        <label class="col-lg-3 col-form-label text-right">Account Link</label>
                        <div class="col-lg-6">
                            <select name="account_id" class="form-control required m-b" id="account_id">
                                <option value="" selected>-- Select Account --</option>
                                <?= $this->AccountModel->selectCombo_New('account_chart') ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Description</label>
                        <div class="col-lg-6">
                            <textarea id="editor" class='ckeditor' name="payment_desc"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>account/paymentmethodcode" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#type").change(function() {
            if ($("#type").val() == 1) {
                $("#bank").val(null);
                document.getElementById("select_bank").style.display = 'none';
                $("#acc_code").val(null);
                document.getElementById("account_no").style.display = 'none';
            } else if ($("#type").val() == 4) {
                $("#bank").val(null);
                document.getElementById("select_bank").style.display = 'none';
                $("#acc_code").val(null);
                document.getElementById("account_no").style.display = 'none';
                $("#account_id").val(null);
                document.getElementById("account_code").style.display = 'none';
            } else {
                document.getElementById('select_bank').style.display = 'flex';
                document.getElementById("account_no").style.display = 'flex';
            }
        })
        $("#submit").click(function(e) {
            e.preventDefault();
            //CKEDITOR.instances.payment_desc.updateElement();
            $.ajax({
                url: "<?= base_url() . "account/doAddpaymentmethodcode" ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.records != 0)
                        alert("paymentmethod Already Exists!");
                    else
                        window.location = "<?= base_url() . "account/paymentmethodcode" ?>";
                }
            });
        });
    });
</script>