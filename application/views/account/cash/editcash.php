<style>
    @media print {
        #print_text {
            background-color: black;
        }
    }
</style>
<div class="d-flex flex-column-fluid" id="print_text">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Cash</h3>

            </div>
            <!--begin::Form-->
            <form class="form" id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <input type="text" name="id" value="<?= base64_encode($cash_code->id) ?>" hidden="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">cash</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" value="<?= $cash_code->name ?>" name="name"
                                id="name" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Account</label>
                        <div class="col-lg-6">
                            <select name="account_id" class="form-control m-b" id="account_id">
                                <?= $this->AccountModel->selectCombo_New('account_chart', $cash_code->account_id) ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Currency</label>
                        <div class="col-lg-6">
                            <select name="currency_id" class="form-control m-b" id="currency_id" required>
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
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>account/cashcode"
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
                url: "<?= base_url() . "account/doEditcash/" . $cash_code->id ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function (data) {
                    console.log(data);
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