<style>
    p {
        color: red;

    }
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add New Account of Chart</h3>
            </div>
            <input type="hidden" name="brand" value=<?= $brand ?>>
        </div>

        <!--begin::Form-->
        <form class="cmxform form-horizontal " id="form" method="post" enctype="multipart/form-data">
            <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php } else { ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php } ?>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Code</label>
                    <div class="col-lg-6">

                        <input type="text" class="form-control" name="ccode" id="ccode" required>

                        <?= form_error('ccode'); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="name" id="name" required>

                        <?= form_error('name'); ?>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-6 col-form-label text-right">
                        <?php
                        $data_acc = array(
                            'name' => 'acc_thrd_party',
                            'id' => 'acc_thrd_party',
                            'value' => false,
                            'checked' => false,
                            'style' => 'margin:10px'
                        );

                        echo form_checkbox($data_acc)
                            ?>This Account has Third Party
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Type</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="acc_type_id" id="type" required>
                            <option disabled="disabled" selected="selected" value="">-- Select Account Type --</option>
                            <?= $this->AccountModel->selectCombo_Name('account_type', '') ?>
                        </select>

                        <?= form_error('acc_type_id'); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Closing</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="acc_close_id" id="type" required>
                            <option disabled="disabled" selected="selected" value="">-- Select Account Closing --
                            </option>
                            <?= $this->AccountModel->selectCombo_Name('account_close', '') ?>
                        </select>
                        <?= form_error('acc_close_id'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Account Currency</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency">
                            <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                            <option> All </option>
                            <?= $this->admin_model->selectCurrency() ?>
                        </select>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Parent Account</label>
                    <div class="col-lg-6">
                        <select name="parent_id" class="form-control m-b" id="parent_id" required>
                            <option selected="selected" value="">-- Select Parent Account --
                            </option>

                            <?= $this->AccountModel->selectCombo_New('account_chart') ?>
                        </select>

                        <?= form_error('parent_id'); ?>

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
                url: "<?= base_url() . "account/doaddaccount" ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function (data) {
                    // console.log(data)
                    window.location = "<?= base_url() ?>" + data;
                }
            });
        });



    })
</script>