<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Payment Method</h3>

            </div>
            <!--begin::Form-->
            <form class="form" id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <input type="text" name="id" value="<?= base64_encode($payment_method->id) ?>" hidden>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Payment Method</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" value="<?= $payment_method->name ?>" name="name" id="name" required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right">Payment Type</label>
                        <div class="col-lg-6">
                            <select name="type" class="form-control m-b" id="type" required>
                                <option value="" <?= set_select('type', "", !strcmp($payment_method->type, "") ? TRUE : FALSE) ?>>-- Select Type --</option>
                                <option value="1" <?= set_select('type', "1", !strcmp($payment_method->type, "1") ? TRUE : FALSE) ?>> Cash </option>
                                <option value="2" <?= set_select('type', "2", !strcmp($payment_method->type, "2") ? TRUE : FALSE) ?>> Bank </option>
                                <option value="3" <?= set_select('type', "3", !strcmp($payment_method->type, "3") ? TRUE : FALSE) ?>> Credit Card </option>
                                <option value="4" <?= set_select('type', "4", !strcmp($payment_method->type, "4") ? TRUE : FALSE) ?>> Other </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="select_bank">
                        <label class="col-lg-3 col-form-label text-right">Bank</label>
                        <div class="col-lg-6">
                            <select name="bank" class="form-control m-b" id="bank" required>
                                <option value="0">-- Select Bank --</option>
                                <?= $this->AccountModel->selectCombo_New('bank', $payment_method->bank) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="account_no">
                        <label class="col-lg-3 col-form-label text-right">Account Code</label>
                        <div class="col-lg-6">
                            <input name="acc_code" id="acc_code" class="form-control " required value="<?= $payment_method->acc_code ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Currency</label>
                        <div class="col-lg-6">
                            <select name="currency_id" class="form-control m-b" id="currency_id" required>
                                <?= $this->AccountModel->selectCurrency($payment_method->currency_id) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="account_code">>
                        <label class="col-lg-3 col-form-label text-right">Account Link</label>
                        <div class="col-lg-6">
                            <select name="account_id" class="form-control m-b" id="account_id" value="<? $payment_method->account_id ?>">
                                <?= $this->AccountModel->selectCombo_New('account_chart', $payment_method->account_id) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Description</label>
                        <div class="col-lg-6">
                            <textarea id="editor" class='ckeditor' name="payment_desc"><?php $payment_method->payment_desc ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <div class=" card-footer">
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

        $("#type").change(function(e) {
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
            // CKEDITOR.instances.payment_desc.updateElement();
            $.ajax({
                url: "<?= base_url() . "account/doeditpaymentmethodcode/" . $payment_method->id ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.records != 0)
                        alert("Payment Method Name Already Exists!");
                    else
                        window.location = "<?= base_url() . "account/paymentmethodcode" ?>";
                }
            });
        });
    });
    $(window).load(function() {
        if ($("#type").val() == 1) {
            $("#bank").val(null);
            document.getElementById("select_bank").style.display = 'none';
            $("#acc_code").val(null);
            document.getElementById("account_no").style.display = 'none';
        } else if ($("#type").val() == 4) {
            $("#bank").val(null);
            document.getElementById('select_bank').style.display = 'none';
            $("#acc_code").val(null);
            document.getElementById("account_no").style.display = 'none';
            $("#account_id").val(null);
            document.getElementById("account_code").style.display = 'none';
        } else {
            document.getElementById('select_bank').style.display = 'flex';
            document.getElementById("account_no").style.display = 'flex';
        }
    })
</script>