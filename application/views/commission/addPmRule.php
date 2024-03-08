<div class="card card-custom example example-compact">
    <div class="card-header">
        <h3 class="card-title">Add New PM Rule</h3>
    </div>
    <!--begin::Form-->
    <form class="form" action="<?php echo base_url() ?>commission/doAddPmRule" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
        <div class="card-body pb-0">

            <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">Year <span class="text-danger">*</span></label>
                <div class="col-lg-4">
                    <select name="year" class="form-control" id="year" required>
                        <option disabled="disabled" selected="selected" value="">-- Select Year --
                        </option>
                        <?= $this->accounting_model->selectYear() ?>
                    </select>
                </div>

                <label class="col-lg-2 col-form-label text-right">Month <span class="text-danger">*</span></label>
                <div class="col-lg-4">
                    <select name="month" class="form-control" id="month" required>
                        <option disabled="disabled" selected="selected" value="">-- Select Month --
                        </option>
                        <?= $this->accounting_model->selectMonth() ?>
                    </select>
                </div>

            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">Brand <span class="text-danger">*</span></label>
                <div class="col-lg-4">
                    <select name="brand_id" class="form-control" id="brand_id" required>
                        <option disabled="disabled" selected="selected" value="">-- Select Brand -- </option>
                        <?= $this->admin_model->selectBrand() ?>
                    </select>

                </div>
            </div>
        </div>
        <div class="card py-0">
            <div class="card-header">
                <div class="card-toolbar">
                    <a href="<?= base_url() ?>commission/addPmRule" class="btn btn-dark btn-sm font-weight-bolder">
                        <i class="fa fa-plus"></i>Retrieve All PM</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>PM Name</th>
                            <th>Standalone</br> PM</th>
                            <th>PM Commissions </br> ( Matrix ) </th>
                            <th>Supervision</br> Commissions</th>
                            <th>Manager</br> Commissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pm_all->result() as $row) : ?>
                            <tr class="text-center">
                                <td>
                                    <?= $row->id; ?>
                                </td>
                                <td class="text-left">
                                    <?= $row->name; ?>
                                </td>
                                <td>
                                    <div class="checkbox-inline" style="display: inline-block!important" title="stnd_rule">
                                        <label class="checkbox checkbox-lg ">
                                            <input type="checkbox" name="stnd_rule" value="1" />
                                            <span style="border: 1px solid;"></span>
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <div class="checkbox-inline" style="display: inline-block!important" title="stnd_rule">
                                        <label class="checkbox checkbox-lg ">
                                            <input type="checkbox" name="pm_rule" value="1" />
                                            <span style="border: 1px solid;"></span>
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <div class="checkbox-inline" style="display: inline-block!important" title="stnd_rule">
                                        <label class="checkbox checkbox-lg ">
                                            <input type="checkbox" name="super_rule" value="1" />
                                            <span style="border: 1px solid;"></span>
                                        </label>
                                    </div>
                                </td>


                                <td>
                                    <div class="checkbox-inline" style="display: inline-block!important" title="stnd_rule">
                                        <label class="checkbox checkbox-lg ">
                                            <input type="checkbox" name="mang_rule" value="1" />
                                            <span style="border: 1px solid;"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>


                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/role" class="btn btn-default" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>