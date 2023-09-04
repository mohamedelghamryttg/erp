<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Q.C. Log Setting for
                    <?= $services->name ?>
                </h3>
            </div>

            <form class="form" action="<?php echo base_url() ?>admin/doEditchecklist" method="post"
                enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" name="id" value="<?= base64_encode($services->id) ?>">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Q.C Log Type</label>
                        <div class="col-lg-6">
                            <select name='qclog' class='form-control m-b' id="qclog" onchange="showDiv('div',this)">
                                <option value="" <?php if ($services->qclog == "0" || $services->qclog == null) {
                                    echo "selected";
                                } ?>>-- Select Q.C Log --</option>
                                <option value="1" <?php if ($services->qclog == "1") {
                                    echo "selected";
                                } ?>>Upload File
                                </option>
                                <option value="2" <?php if ($services->qclog == "2") {
                                    echo "selected";
                                } ?>>Check List
                                </option>
                                <option value="3" <?php if ($services->qclog == "3") {
                                    echo "selected";
                                } ?>>Both</option>
                            </select>
                        </div>
                    </div>
                    <div id="chklistitem" style="display:none">
                        <div class="card border p-6 ">
                            <h6><u>Check List Item</u></h6>
                            <div class="table-responsive">
                                <table class="table table-hover text-center">
                                    <tbody>
                                        <?php for ($i = 1; $i < 31; $i++): ?>
                                            <div class="form-group row" style="margin-bottom: 2px;">
                                                <div class="col-lg-4 ">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-lg-2 col-md-2 col-sm-2 col-form-label  text-center">
                                                            <?= $i ?> -
                                                        </label>
                                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                                            <select class="form-control class_sel"
                                                                name="<?= 'logcheckg' . $i; ?>"
                                                                id="<?= 'logcheckg' . $i; ?>" style="width: 100%;"><?= $this->admin_model->selectServicesCat($serv_res[0]['logcheckg' . $i] ?? '') ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                    <input class="form-control class_val" type="text"
                                                        name="<?= 'logcheck' . $i; ?>" id="<?= 'logcheck' . $i; ?>"
                                                        value="<?= $serv_res[0]['logcheck' . $i]; ?>" maxlength="100">

                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                        <?php for ($i = 1; $i < 6; $i++): ?>
                                            <div class="form-group row" style="margin-bottom: 2px;">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-lg-2 col-md-2 col-sm-2 col-form-label text-center">
                                                            <?= $i ?> -
                                                        </label>
                                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                                            <select class="form-control class_sel"
                                                                name="<?= 'logcheckng' . $i; ?>"
                                                                id="<?= 'logcheckng' . $i; ?>" style="width: 100%;"><?= $this->admin_model->selectServicesCat($serv_res[0]['logcheckng' . $i]); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                    <input class="form-control class_val" type="text"
                                                        name="<?= 'logcheckn' . $i; ?>" id="<?= 'logcheckn' . $i; ?>"
                                                        value="<?= $serv_res[0]['logcheckn' . $i]; ?>" maxlength="100">
                                                </div>
                                            </div>

                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/services"
                                    class="btn btn-default" type="button">Cancel</a>
                            </div>
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
    $(document).ready(function () {
        showDiv();
    });
    function showDiv() {
        getSelectValue = document.getElementById("qclog").value;
        if (getSelectValue == "2" || getSelectValue == "3") {
            document.getElementById("chklistitem").style.display = "block";
        } else {
            document.getElementsByClassName("class_val").value = "";
            document.getElementsByClassName("class_sel").value = "";
            document.getElementById("chklistitem").style.display = "none";
        }
    }

</script>