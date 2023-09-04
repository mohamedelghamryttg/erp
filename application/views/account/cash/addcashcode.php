<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add Cash</h3>
            </div>
            <!--begin::Form-->
            <form class="form" id="form" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Cash</label>
                        <div class="col-lg-6">
                            <input name="name" id="name" class="form-control required" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Account</label>
                        <div class="col-lg-6">
                            <select name="account_id" class="form-control required m-b" id="account_id" required>
                                <option value="">-- Select Account --</option>
                                <?= $this->AccountModel->selectCombo_New('account_chart') ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Currency</label>
                        <div class="col-lg-6">
                            <select name="currency_id" class="form-control required m-b" id="currency_id" required>
                                <option value="">-- Select Currency --</option>
                                <?= $this->AccountModel->selectCombo_New('currency') ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>account/addcashcode"
                                class="btn btn-default" type="button">Cancel</a>

                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("#submit").click(function (event) {
            $.ajax({
                url: "<?= base_url() . "account/doaddcashcode" ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.records != 0)
                        alert("cash Already Exists!");
                    else
                        window.location = "<?= base_url() . "account/cashcode" ?>";
                }
            });
        });
    });
</script>