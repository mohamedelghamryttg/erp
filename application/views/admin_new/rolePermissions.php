<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
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
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Role Permissions</h3>
                        <h4 class="card-label"><i class="fa fa-arrow-alt-circle-right"></i>
                            <?= $role->name ?>
                        </h4>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <?php if ($permission->add == 1) { ?>
                            <a href="<?= base_url() ?>admin/addPermission" class="btn btn-primary font-weight-bolder">
                            <?php } ?>
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add New Permission</a>
                            <!--end::Button-->

                            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_7_1">List 1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_7_2">List 2</a>
                                </li>

                            </ul>

                    </div>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_pane_7_1" role="tabpanel" aria-labelledby="kt_tab_pane_7_1">
                            <form class="form" action="<?php echo base_url() ?>admin/saveRolePermissions" method="post">
                                <!--begin: Datatable-->
                                <input type="hidden" name="role_id" value="<?= $role->id ?>" />
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Screen</th>
                                            <th>Follow-Up</th>
                                            <th>Can View</th>
                                            <th>Can Add</th>
                                            <th>Can Edit</th>
                                            <th>Can Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($screens->result() as $k => $row)
                                            if ($k < 100) { {
                                                    $val = $this->db->get_where('permission', array('role' => $role->id, 'screen' => $row->id))->row();
                                        ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <input type="hidden" name="screen_id[]" value="<?= $row->id ?>" />
                                                        <?= $row->id; ?>
                                                    </td>
                                                    <td>
                                                        <?= $row->name; ?>
                                                    </td>
                                                    <td>
                                                        <select name="follow_<?= $row->id ?>" class="form-control" style="width: 100%;">
                                                            <?= $this->admin_model->selectFollowUp($val->follow ?? '') ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="view_<?= $row->id ?>" class="form-control" style="width: 100%;">
                                                            <option value="0">-- Select Can View --</option>
                                                            <option <?= (!empty($val) && $val->view == 2) ? 'selected' : '' ?> value="2">View only assigned</option>
                                                            <option <?= (!empty($val) && $val->view == 1) ? 'selected' : '' ?> value="1">View ALL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-inline" style="display: inline-block!important" title="Add">
                                                            <label class="checkbox checkbox-lg ">
                                                                <input type="checkbox" name="add_<?= $row->id ?>" <?= (!empty($val) && $val->add == 1) ? 'checked' : '' ?> value="1" />
                                                                <span style="border: 1px solid;"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-inline" style="display: inline-block!important" title="Edit">
                                                            <label class="checkbox checkbox-lg">
                                                                <input type="checkbox" name="edit_<?= $row->id ?>" <?= (!empty($val) && $val->edit == 1) ? 'checked' : '' ?> value="1" />
                                                                <span style="border: 1px solid;"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-inline" style="display: inline-block!important" title="Delete">
                                                            <label class="checkbox checkbox-lg">
                                                                <input type="checkbox" name="delete_<?= $row->id ?>" <?= (!empty($val) && $val->delete == 1) ? 'checked' : '' ?> value="1" />
                                                                <span style="border: 1px solid;"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>

                                </table>
                                <!--end: Datatable-->
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                                        <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/role" class="btn btn-default" type="button">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_7_2" role="tabpanel" aria-labelledby="kt_tab_pane_7_2">
                            <!--begin: Datatable-->
                            <form class="form" action="<?php echo base_url() ?>admin/saveRolePermissions" method="post">

                                <input type="hidden" name="role_id" value="<?= $role->id ?>" />
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Screen</th>
                                            <th>Follow-Up</th>
                                            <th>Can View</th>
                                            <th>Can Add</th>
                                            <th>Can Edit</th>
                                            <th>Can Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($screens->result() as $k => $row)
                                            if ($k >= 100) { {
                                                    $val = $this->db->get_where('permission', array('role' => $role->id, 'screen' => $row->id))->row();
                                        ?>
                                                <tr class="text-center">
                                                    <td><input type="hidden" name="screen_id[]" value="<?= $row->id ?>" /><?= $row->id; ?></td>
                                                    <td>
                                                        <?= $row->name; ?>
                                                    </td>
                                                    <td>
                                                        <select name="follow_<?= $row->id ?>" class="form-control" style="width: 100%;">

                                                            <?= $this->admin_model->selectFollowUp($val->follow) ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="view_<?= $row->id ?>" class="form-control" style="width: 100%;">
                                                            <option value="0">-- Select Can View --</option>
                                                            <option <?= (!empty($val) && $val->view == 2) ? 'selected' : '' ?> value="2">View only assigned</option>
                                                            <option <?= (!empty($val) && $val->view == 1) ? 'selected' : '' ?> value="1">View ALL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-inline" style="display: inline-block!important" title="Add">
                                                            <label class="checkbox checkbox-lg ">
                                                                <input type="checkbox" name="add_<?= $row->id ?>" <?= (!empty($val) && $val->add == 1) ? 'checked' : '' ?> value="1" />
                                                                <span style="border: 1px solid;"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-inline" style="display: inline-block!important" title="Edit">
                                                            <label class="checkbox checkbox-lg">
                                                                <input type="checkbox" name="edit_<?= $row->id ?>" <?= (!empty($val) && $val->edit == 1) ? 'checked' : '' ?> value="1" />
                                                                <span style="border: 1px solid;"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-inline" style="display: inline-block!important" title="Delete">
                                                            <label class="checkbox checkbox-lg">
                                                                <input type="checkbox" name="delete_<?= $row->id ?>" <?= (!empty($val) && $val->delete == 1) ? 'checked' : '' ?> value="1" />
                                                                <span style="border: 1px solid;"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>

                                </table>
                                <!--end: Datatable-->
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                                        <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/role" class="btn btn-default" type="button">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->