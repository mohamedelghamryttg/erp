<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Users</h3>
                </div>
                <div class="card-body">
                    <form class="form" action="<?php echo base_url() ?>admin/masterUsers" method="get"
                        enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right">Employee Name:</label>
                            <div class="col-lg-4">
                                <select name="employee_name" class="form-control m-b" id="employee_name">
                                    <option value="">-- Select Employee --</option>
                                    <?= $this->hr_model->selectEmployee($employee_name) ?>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label text-lg-right" for="role name">Brand:</label>
                            <div class="col-lg-4">
                                <select name="brand" class="form-control m-b" id="brand">
                                    <option value="">-- Select Brand --</option>
                                    <?= $this->admin_model->selectBrand($brand ?? '') ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right">Email:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="email" value="<?= $email ?? '' ?>">
                            </div>
                            <label class="col-lg-2 col-form-label text-lg-right">User Name:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="user_name"
                                    value="<?= $user_name ?? '' ?>">
                            </div>


                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right">Abbreviations:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="abbreviations"
                                    value="<?= $abbreviations ?? '' ?>">
                            </div>
                            <label class="col-lg-2 col-form-label text-lg-right" for="role name">Status:</label>
                            <div class="col-lg-4">
                                <select name="status" class="form-control m-b" id="action">
                                    <option value="" selected=''>-- Select --</option>
                                    <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Active
                                    </option>
                                    <option value="2" <?= isset($status) && $status == 2 ? "selected" : "" ?>>Deactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-9">
                                    <button class="btn btn-success mr-2" name="search" type="submit" value="search"><i
                                            class="la la-search"></i>Search</button>
                                    <button class="btn btn-warning mr-2" name="submitReset" type="submit"
                                        value="submitReset"><i class="la la-trash"></i>Clear Filter</button>
                                    <!-- <button class="btn btn-success mr-2" name="search" type="submit"><i class="la la-search"></i>Search</button>	
                                    <a href="<?= base_url() ?>admin/masterUsers" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a>  -->

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end search form -->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Users</h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <?php if ($permission->add == 1) { ?>
                            <a href="<?= base_url() ?>admin/addUser" class="btn btn-primary font-weight-bolder">
                            <?php } ?>
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add New User</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover"
                        id="kt_datatable2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Employee Name</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)) {
                                foreach ($users->result() as $row) { ?>
                                    <tr class="">
                                        <td>
                                            <?php echo $row->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->ccode ?>
                                        </td>
                                        <td>
                                            <?php echo $row->user_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->email; ?>
                                        </td>
                                        <td>
                                            <?php echo $this->hr_model->getEmployee($row->employees_id); ?>
                                        </td>
                                        <td>
                                            <?= ($row->status == 1) ? "Active" : "Deactive" ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>admin/edituser?t=<?php echo base64_encode($row->id); ?>"
                                                    class="">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                            <tr>
                                <td colspan="7"> There is no users to list</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                    <!--begin::Pagination-->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <?= $this->pagination->create_links() ?>
                    </div>
                    <!--end:: Pagination-->
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>

</div>