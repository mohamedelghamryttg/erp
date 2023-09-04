<!--begin::Content-->



<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-3 py-lg-3 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <?php if ($this->session->flashdata('true')) { ?>
                <div class="alert alert-success w-100" role="alert">
                    <span class="fa fa-check-circle"></span>
                    <span><strong>
                            <?= $this->session->flashdata('true') ?>
                        </strong></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger w-100" role="alert">
                    <span class="fa fa-warning"></span>
                    <span><strong>
                            <?= $this->session->flashdata('error') ?>
                        </strong></span>
                </div>
            <?php } ?>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom min-h-500px card-border">
                <div class="card-header flex-wrap py-6">
                    <div class="card-title">
                        <h3 class="card-label">QC Log Category</h3>

                    </div>

                    <div class="card-toolbar">
                        <?php if ($permission->add == 1) { ?>
                            <a class="btn btn-dark btn-sm font-weight-bolder" data-toggle="modal" data-target="#addModal">
                                <i class="fa fa-plus-circle"></i>add New
                            </a>
                            <!-- Modal-->
                            <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog"
                                aria-labelledby="staticBackdrop" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">add New Category</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <form class="cmxform form-horizontal "
                                            action="<?php echo base_url() ?>admin/savemanagerQCcategory" method="post"
                                            enctype="multipart/form-data">

                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label" for="comment">Category</label>
                                                    <div class="col-lg-9">
                                                        <input type='text' name="name" class="form-control" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                                                <button type="button" class="btn btn-default font-weight-bold"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>
                <div>
                    <p class="text-danger">Using it in Service Setting</p>
                </div>
                <div class="card-body">
                    <!-- Modal-->
                    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
                        aria-labelledby="staticBackdrop" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <form class="cmxform form-horizontal "
                                    action="<?php echo base_url() ?>admin/updatemanagerQCcategory" method="post"
                                    enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type='hidden' name="id" value="" class="form-control" />
                                        <div class="form-group row">
                                            <label class="col-lg-3 control-label" for="comment">Category</label>
                                            <div class="col-lg-9">
                                                <input type='text' name="name" class="form-control text-left" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                                        <button type="button" class="btn btn-default font-weight-bold"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover">

                        <thead>
                            <tr>
                                <th no-sort>ID</th>
                                <th class="w-50">Category</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($qcchklist_cat->result() as $row) { ?>
                                <tr>
                                    <td class="id">
                                        <?= $row->id ?>
                                    </td>
                                    <td class="name">
                                        <?= $row->name ?>
                                    </td>
                                    <td>
                                        <?= $row->created_at ?>
                                    </td>
                                    <td>
                                        <?= $this->admin_model->getUser($row->created_by) ?>
                                    </td>
                                    <td>
                                        <button type="button" recordID="<?= $row->id ?>"
                                            class="btn btn-light-info btn-sm edit" data-toggle="modal"
                                            data-target="#editModal">
                                            <i class="fa fa-pen"></i>Edit
                                        </button>

                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <?= $this->pagination->create_links() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Content-->

<script>
    $(document).on("click", ".edit", function () {
        var id = $(this).attr('recordID');
        var name = $(this).closest('tr').find('.name').text().trim();

        $('#editModal').find('input[name=id]').val(id);
        $('#editModal').find('input[name=name]').val(name);

    });
</script>