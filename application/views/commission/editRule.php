<div class="d-flex flex-column-fluid mt-2">
    <!--begin::Container-->
    <div class="container">
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
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Rule</h3>
            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>commission/doEditRule"
                  onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                <div class="card-body">                   
                    <input type='hidden' name="id" value="<?=$id?>"/>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right">Year <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <select name="year" class="form-control" id="year" required>
                                <option disabled="disabled" selected="selected" value="">-- Select Year --
                                </option>
                                <?= $this->accounting_model->selectYear($row->year) ?>
                            </select>
                        </div>

                        <label class="col-lg-2 col-form-label text-right">Month <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <select name="month" class="form-control" id="month" required>
                                <option disabled="disabled" selected="selected" value="">-- Select Month --
                                </option>
                                <?= $this->accounting_model->selectMonth($row->month) ?>
                            </select>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right">Brand <span  class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <select name="brand" class="form-control" id="brand" required>
                                <option disabled="disabled" selected="selected" value="">-- Select Brand -- </option>
                                <?= $this->admin_model->selectBrand($row->brand_id) ?>
                            </select>                          

                        </div>

                        <label class="col-lg-2 col-form-label text-right">Region </label>
                        <div class="col-lg-4">
                            <select name="region" class="form-control" id="region" >
                                <option selected="selected" value="">-- Select Region -- </option>
                                <?= $this->admin_model->selectRegion($row->region_id) ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right">Date From <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input name="date_from" type="text" class="form-control date_sheet" value="<?=$row->date_from?>" readonly="readonly" placeholder="Select date" />
                        </div>

                        <label class="col-lg-2 col-form-label text-right">Date To <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input name="date_to" type="text" class="form-control date_sheet" value="<?=$row->date_to?>" readonly="readonly" placeholder="Select date" />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right">Standalone % <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="number" name="standalone_per" class="form-control" required min="0" step=".05" value="<?=$row->standalone_per?>" />
                        </div>
                        <label class="col-lg-2 col-form-label text-right">Team Leader %<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="number" name="teamleader_per" class="form-control" required min="0" step=".05" value="<?=$row->teamleader_per?>"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right">Cogs % <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="number" name="cogs_per" class="form-control" required min="0" step=".05" value="<?=$row->cogs_per?>"/>

                        </div>                        
                    </div>


                    <hr />
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" colspan="2">Monthly Target</th>
                                <th scope="col">If Cogs < ..%</th>
                                <th scope="col">If Cogs > ..%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($x = 1; $x < 6; $x++) { 
                                    $rev_target_from_name = "rev_target_from_$x";
                                    $rev_target_to_name = "rev_target_to_$x";
                                    $cogs_per_l = "cogs_per_l$x";
                                    $cogs_per_m = "cogs_per_m$x";
                                    ?>
                                <tr>
                                    <th scope="row"><?= $x ?></th>
                                    <td><input type="number" name="rev_target_from_<?= $x ?>" <?= $row->$rev_target_from_name?'value="'.$row->$rev_target_from_name.'"':" "?> class="form-control form-control-sm" placeholder="from"  min="0" step=".05" <?= $x <= 2 ? "required" : "" ?> /></td>
                                    <td><input type="number" name="rev_target_to_<?= $x ?>" <?= $row->$rev_target_to_name?'value="'.$row->$rev_target_to_name.'"':" "?> class="form-control form-control-sm" placeholder="to"  min="0" step=".05" <?= $x <= 2 ? "required" : "" ?> /></td>
                                    <td><input type="number" name="cogs_per_l<?= $x ?>" <?= $row->$cogs_per_l?'value="'.$row->$cogs_per_l.'"':" "?> class="form-control form-control-sm" placeholder="%"  min="0" step=".05" <?= $x <= 2 ? "required" : "" ?> /></td>
                                    <td><input type="number" name="cogs_per_m<?= $x ?>" <?= $row->$cogs_per_m?'value="'.$row->$cogs_per_m.'"':" "?> class="form-control form-control-sm" placeholder="%"  min="0" step=".05" <?= $x <= 2 ? "required" : "" ?> /></td>

                                </tr>
                            <?php } ?>
                        <th scope="row">6</th>
                        <td colspan="2"><input type="number" name="rev_target_6"  value="<?=$row->rev_target_6?>" class="form-control form-control-sm" placeholder="more than"  min="0" step=".05" required /></td>

                        <td><input type="number" name="cogs_per_l6"  value="<?=$row->cogs_per_l6?>" class="form-control form-control-sm" placeholder="%"  min="0" step=".05" required /></td>
                        <td><input type="number" name="cogs_per_m6"  value="<?=$row->cogs_per_m6?>" class="form-control form-control-sm" placeholder="%"  min="0" step=".05" required /></td>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>commission"
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
