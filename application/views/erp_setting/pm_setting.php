<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
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

<!--begin::Container-->
<div class="container-falut">
    <input type="hidden" name="brand" value="<?= $brand ?>">
    <div class="card card-custom example example-compact" style="align-items: center;">
        <div class="card-header center">
            <h3 class="card-title">Projects Management Settings</h3>
        </div>
    </div>
    <form class="cmxform form-horizontal" method="post" enctype="multipart/form-data" id="config_form">
        <div class="card-body">
            <input type="hidden" class="form-control" name="id" id="id" value="<?= $pmConfig->id;
            ?>">
            <div class="row">

                <!-- Tab navs -->
                <div class="col-md-2 mb-2">
                    <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="qmsitting-tab" data-toggle="tab" href="#qmsitting" role="tab"
                                aria-controls="qmsitting" aria-selected="true">Q.M Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pmvsetting-tab" data-toggle="tab" href="#pmvsetting" role="tab"
                                aria-controls="pmvsetting" aria-selected="false">PM-Vendor Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="vpmsetting-tab" data-toggle="tab" href="#vpmsetting" role="tab"
                                aria-controls="vpmsetting" aria-selected="false">Vendor-PM Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cusetting-tab" data-toggle="tab" href="#cusetting" role="tab"
                                aria-controls="cusetting" aria-selected="false">Customer Ev. Setting</a>
                        </li>
                    </ul>
                </div>
                <!-- Tab navs -->

                <div class="col-md-10 mb-10">
                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active " id="qmsitting" role="tabpanel"
                            aria-labelledby="qmsitting-tab">
                            <div class="card">
                                <div class="card-header" style="padding-bottom: 0px !important;">
                                    <h3 class="card-title text-center">Q.M Setting </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-12">Q.M Email</label>
                                        <div class="col-md-9 col-sm-12">
                                            <input type="text" class="form-control" name="qmemail" id="qmemail" value="<?= $pmConfig->qmemail;
                                            ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-12">Q.M Email Subject</label>
                                        <div class="col-md-9 col-sm-12">
                                            <input type="text" class="form-control" name="qmemailsub" id="qmemailsub"
                                                value="<?= $pmConfig->qmemailsub;
                                                ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-12">Q.M Email Desc</label>
                                        <div class="col-md-9 col-sm-12">
                                            <textarea id="qmemaildesc" class="form_control ckeditor"
                                                name="qmemaildesc"><?= $pmConfig->qmemaildesc; ?></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pmvsetting" role="tabpanel" aria-labelledby="pmvsetting-tab">
                            <div class="card">
                                <div class="card-header" style="padding-bottom: 0px !important;">
                                    <h3 class="card-title text-center">PM-Vendor Evaluation Setting</h3>
                                </div>
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-6">Block Vendor After Bad
                                            Evaluation
                                            Count</label>
                                        <div class="col-md-1 col-sm-1">
                                            <input type="text" class="form-control" name="block_v_no" id="block_v_no"
                                                value="<?= $pmConfig->block_v_no;
                                                ?>" maxlength="1">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-6">PM Vendor Evaluation
                                            Setting</label>
                                        <div class="col-md-9 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="w-75">Evatuation Point</th>
                                                            <th scope="col" class="text-center">Percentage %</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 1
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="pm_ev_name1" id="pm_ev_name1" value="<?= $pmConfig->pm_ev_name1;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="pm_ev_per1"
                                                                    id="pm_ev_per1" value="<?= $pmConfig->pm_ev_per1;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 2
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="pm_ev_name2" id="pm_ev_name2" value="<?= $pmConfig->pm_ev_name2;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="pm_ev_per2"
                                                                    id="pm_ev_per2" value="<?= $pmConfig->pm_ev_per2;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 3
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="pm_ev_name3" id="pm_ev_name3" value="<?= $pmConfig->pm_ev_name3;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="pm_ev_per3"
                                                                    id="pm_ev_per3" value="<?= $pmConfig->pm_ev_per3;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 4
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="pm_ev_name4" id="pm_ev_name4" value="<?= $pmConfig->pm_ev_name4;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="pm_ev_per4"
                                                                    id="pm_ev_per4" value="<?= $pmConfig->pm_ev_per4;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 5
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="pm_ev_name5" id="pm_ev_name5" value="<?= $pmConfig->pm_ev_name5;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="pm_ev_per5"
                                                                    id="pm_ev_per5" value="<?= $pmConfig->pm_ev_per5;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 6
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="pm_ev_name6" id="pm_ev_name6" value="<?= $pmConfig->pm_ev_name6;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="pm_ev_per6"
                                                                    id="pm_ev_per6" value="<?= $pmConfig->pm_ev_per6;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vpmsetting" role="tabpanel" aria-labelledby="vpmsetting-tab">
                            <div class="card">
                                <div class="card-header" style="padding-bottom: 0px !important;">
                                    <h3 class="card-title text-center">Vendor-PM Evaluation Setting</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-6">Vendor PM Evaluation
                                            Setting</label>
                                        <div class="col-md-9 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="w-75">Evatuation Point</th>
                                                            <th scope="col" class="text-center">Percentage %</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 1
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="v_ev_name1" id="v_ev_name1" value="<?= $pmConfig->v_ev_name1;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="v_ev_per1"
                                                                    id="v_ev_per1" value="<?= $pmConfig->v_ev_per1;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 2
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="v_ev_name2" id="v_ev_name2" value="<?= $pmConfig->v_ev_name2;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="v_ev_per2"
                                                                    id="v_ev_per2" value="<?= $pmConfig->v_ev_per2;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 3
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="v_ev_name3" id="v_ev_name3" value="<?= $pmConfig->v_ev_name3;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="v_ev_per3"
                                                                    id="v_ev_per3" value="<?= $pmConfig->v_ev_per3;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 4
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="v_ev_name4" id="v_ev_name4" value="<?= $pmConfig->v_ev_name4;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="v_ev_per4"
                                                                    id="v_ev_per4" value="<?= $pmConfig->v_ev_per4;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 5
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="v_ev_name5" id="v_ev_name5" value="<?= $pmConfig->v_ev_name5;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="v_ev_per5"
                                                                    id="v_ev_per5" value="<?= $pmConfig->v_ev_per5;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 6
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="v_ev_name6" id="v_ev_name6" value="<?= $pmConfig->v_ev_name6;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="v_ev_per6"
                                                                    id="v_ev_per6" value="<?= $pmConfig->v_ev_per6;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cusetting" role="tabpanel" aria-labelledby="cusetting-tab">
                            <div class="card">
                                <div class="card-header" style="padding-bottom: 0px !important;">
                                    <h3 class="card-title text-center">Customer Evaluation Setting</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-12">Customer Evaluation Email
                                            Subject</label>
                                        <div class="col-md-9 col-sm-12">
                                            <input type="text" class="form-control" name="cuemailsub" id="cuemailsub"
                                                value="<?= $pmConfig->cuemailsub;
                                                ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-12">Customer Evaluation Email
                                            Desc</label>
                                        <div class="col-md-9 col-sm-12">
                                            <textarea id="cuemaildesc" class="form_control ckeditor"
                                                name="cuemaildesc"><?= $pmConfig->cuemaildesc; ?></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label  col-sm-6">Customer PM Evaluation
                                            Setting</label>
                                        <div class="col-md-9 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="w-75">Evatuation Point</th>
                                                            <th scope="col" class="text-center">Percentage %</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 1
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="c_ev_name1" id="c_ev_name1" value="<?= $pmConfig->c_ev_name1;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="c_ev_per1"
                                                                    id="c_ev_per1" value="<?= $pmConfig->c_ev_per1;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 2
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="c_ev_name2" id="c_ev_name2" value="<?= $pmConfig->c_ev_name2;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="c_ev_per2"
                                                                    id="c_ev_per2" value="<?= $pmConfig->c_ev_per2;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 3
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="c_ev_name3" id="c_ev_name3" value="<?= $pmConfig->c_ev_name3;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="c_ev_per3"
                                                                    id="c_ev_per3" value="<?= $pmConfig->c_ev_per3;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 4
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="c_ev_name4" id="c_ev_name4" value="<?= $pmConfig->c_ev_name4;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="c_ev_per4"
                                                                    id="c_ev_per4" value="<?= $pmConfig->c_ev_per4;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 5
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="c_ev_name5" id="c_ev_name5" value="<?= $pmConfig->c_ev_name5;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="c_ev_per5"
                                                                    id="c_ev_per5" value="<?= $pmConfig->c_ev_per5;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;font-weight: bold;"> 6
                                                            </td>
                                                            <td><input type="text" class="form-control font-weight-bold"
                                                                    name="c_ev_name6" id="c_ev_name6" value="<?= $pmConfig->c_ev_name6;
                                                                    ?>">
                                                            </td>
                                                            <td class="text-center"><input type="text"
                                                                    class="form-control text-center" name="c_ev_per6"
                                                                    id="c_ev_per6" value="<?= $pmConfig->c_ev_per6;
                                                                    ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="text-center">
                        <button type="text" class="btn btn-success mr-2" id="submit">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>admin" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
<script>
    $(document).ready(function () {

        $("#submit").on('click', function (e) {
            // e.preventDefault();
            CKEDITOR.instances.qmemaildesc.updateElement();
            CKEDITOR.instances.cuemaildesc.updateElement();
            $.ajax({
                url: "<?= base_url('settings/savePmConfig') ?>",
                type: "POST",
                data: $('#config_form').serialize(),
                success: function (data) {
                    alert(data);
                },
                error: function (jqXHR, exception) {
                    console.log(jqXHR.dataText);
                }
            });
        });
    });

</script>