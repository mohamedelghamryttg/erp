<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Bank</h3>

            </div>
            <!--begin::Form-->
            <form class="form" id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <input type="text" name="id" value="<?= base64_encode($banks->id) ?>" hidden="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Bank</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" value="<?= $banks->name ?>" name="name" id="name"
                                required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Account</label>
                        <div class="col-lg-6">
                            <select name="account_id" class="form-control m-b" id="account_id">
                                <?= $this->AccountModel->selectCombo_New('account_chart', $banks->account_id) ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="button" id="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>account/bankCode"
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
                url: "<?= base_url() . "account/doEditBank/" . $banks->id ?>",
                type: "POST",
                data: $("#form").serialize(),
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.records != 0)
                        alert("Bank Already Exists!");
                    else
                        window.location = "<?= base_url() . "account/bankCode" ?>";
                }
            });
        });
    });
</script>