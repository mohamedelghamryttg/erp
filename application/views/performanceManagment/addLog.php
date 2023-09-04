<?php if ($this->session->flashdata('true')) { ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong>
                <?= $this->session->flashdata('true') ?>
            </strong></span>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong>
                <?= $this->session->flashdata('error') ?>
            </strong></span>
    </div>
<?php } ?>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add Incident</h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>performanceManagment/saveLog" method="post"
                onsubmit="return checkScore();" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select Employee Name:</label>
                        <div class="col-lg-6">
                            <select name="emp_id" id="emp_id" class="form-control" required="" onChange="getKpiCore()">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->getEmployeesNameByManager($emp_id); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Incident Title:</label>
                        <div class="col-lg-6">
                            <input type="text" name="title" class="form-control" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Date:</label>
                        <div class="col-lg-6">
                            <input type="date" name="date" class="form-control" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select KPI Core <i class="fa fa-info-circle"
                                title="Note That : You can select the KPI core affected by this Incident"></i> :
                        </label>
                        <div class="col-lg-6">
                            <select name="kpi_core_id" id="kpi_core_id" class="form-control"
                                onChange="getThisSubCore()">
                                <option value="" disabled='' selected=''>-- Select --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Sub Core:</label>
                        <div class="col-lg-6">
                            <select name="kpi_sub_id" id="kpi_sub_id" class="form-control">
                                <option value="" disabled='' selected=''>-- Select --</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Comment:</label>
                        <div class="col-lg-6">
                            <textarea name="comment" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label col-form-label text-right">Attachment</label>
                        <div class="col-lg-6">

                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                            <a href="<?php echo base_url() ?>performanceManagment/incidentLog" class="btn btn-secondary"
                                type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    // let base_url = "<?= base_url() ?>";
    function getKpiCore() {
        var employee_id = $("#emp_id").val();
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "performanceManagment/getKpiByEmployeesName", { employee_id: employee_id }, function (data) {
            $('#loading').hide();
            $('#kpi_core_id').html(data);

        });
    }

    function getThisSubCore() {
        var kpi_core_id = $("#kpi_core_id").val();
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "performanceManagment/getKpiSubByCore", { kpi_core_id: kpi_core_id }, function (data) {
            $('#loading').hide();
            $('#kpi_sub_id').html(data);

        });
    }

</script>