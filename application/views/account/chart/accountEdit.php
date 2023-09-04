<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Account</h3>
            </div>
            <input type="hidden" name="brand" value=<?= $brand ?>>
        </div>
        <!--begin::Form-->
        <form class="cmxform form-horizontal " method="post" enctype="multipart/form-data" id="form">
            <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php } else { ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php } ?>
            <input type="text" name="id" value="<?= base64_encode($account_chart->id) ?>" hidden="">
            <div class="card-body">
                <input type="hidden" class="form-control" name="acode" id="acode" value="<?= $account_chart->acode ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Code</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="acode1" id="acode1"
                            value="<?= $account_chart->acode ?>" disabled>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Code</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="ccode" id="ccode"
                            value="<?= $account_chart->ccode ?>">
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="name" id="name"
                            value="<?= $account_chart->name ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-6 col-form-label text-right">
                        <input type="checkbox" name="acc_thrd_party" <?php if ($account_chart->acc_thrd_party == 1): ?>
                                type="checkbox" checked value="<?= (($account_chart->acc_thrd_party == 1) ? 1 : 0) ?>">
                        <?php else: ?>
                            value="<?= (($account_chart->acc_thrd_party == 1) ? 1 : 0) ?>">
                        <?php endif ?>
                        This
                        Account has Third Party
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Type</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="acc_type_id" id="acc_type_id" required
                            value="<?= $account_chart->acc_type ?>">
                            <option selected="selected" value="">-- Select Account Type --</option>
                            <?= $this->AccountModel->selectCombo_Name('account_type', $account_chart->acc_type_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Closing</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="acc_close_id" id="acc_close_id" required
                            value="<?= $account_chart->acc_close_id ?>">
                            <option selected="selected" value="">-- Select Account Closing --</option>
                            <?= $this->AccountModel->selectCombo_Name('account_close', $account_chart->acc_close_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Currency</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency" required
                            value="<?= $account_chart->currency_id ?>">
                            <option selected="selected" value="">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency($account_chart->currency_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Parent Account</label>
                    <div class="col-lg-6">
                        <select name="parent_id" class="form-control m-b" id="parent_id"
                            value="<?= $account_chart->parent_id ?>">
                            <option selected="selected" value="">-- Select Parent Account --</option>
                            <?= $this->AccountModel->selectCombo_New('account_chart', $account_chart->parent_id) ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>account/accountList"
                            class="btn btn-default" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
<script>
    $(document).ready(function () {
        $("#submit").click(function (event) {
            $.ajax({
                url: "<?= base_url() . "account/doeditaccount" ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function (data) {
                   // console.log(data);
                    window.location = "<?= base_url() ?>" + data;
                }
            });
        });
    })
</script>