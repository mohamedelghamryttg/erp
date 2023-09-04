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
            <!--             start search form card  
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Search </h3>
                            </div>
                            <form class="form" id="Filter" action="<?php echo base_url() ?>automation/allServiceTypes" method="get" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-2 mb-5 col-form-label text-lg-right" for="role name">Ticket Type:</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="type" class="form-control m-b" value="<?= $type ?? '' ?>"/>
            
                                        </div> 
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-10">
                                                <button class="btn btn-success mr-2" name="search" type="submit">Search</button>	
                                                <a href="<?= base_url() ?>automation/allServiceTypes" class="btn btn-danger"><i class="la la-trash"></i>Clear Filter</a> 
            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>            
                        </div>
                     end search form -->

            <!--begin::Card-->
            <div class="card card-custom min-h-500px card-border">
                <div class="card-header flex-wrap py-6">
                    <div class="card-title">
                        <h3 class="card-label">Ticket Service Types | <span class="text-dark-50 font-weight-bold"
                                style="font-size: 14px !important;">
                                <?= $total_rows ?> Total
                            </span></h3>
                        <div class="d-flex align-items-center" id="kt_subheader_search">
                            <form class="ml-5" action="<?php echo base_url() ?>automation/allServiceTypes" method="get">
                                <div class="input-group input-group-sm input-group-solid" style="">
                                    <input type="text" class="form-control" name="type" value="<?= $type ?? '' ?>"
                                        id="kt_subheader_search_form" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" name="search" type="submit"><i
                                                class="flaticon2-search-1 icon-sm"></i>Search</button>
                                        <a href="<?= base_url() ?>automation/allServiceTypes" class="btn btn-danger"><i
                                                class="la la-trash"></i>Clear</a>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                                            <h5 class="modal-title" id="exampleModalLabel">add New Type</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <form class="cmxform form-horizontal "
                                            action="<?php echo base_url() ?>automation/saveServiceType" method="post"
                                            enctype="multipart/form-data">

                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 control-label" for="comment">Title</label>
                                                    <div class="col-lg-9">
                                                        <input type='text' name="title" class="form-control" />
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
                <div class="card-body">
                    <!-- Modal-->
                    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
                        aria-labelledby="staticBackdrop" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Service Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <form class="cmxform form-horizontal "
                                    action="<?php echo base_url() ?>automation/updateServiceType" method="post"
                                    enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type='hidden' name="id" value="" class="form-control" />
                                        <div class="form-group row">
                                            <label class="col-lg-3 control-label" for="comment">Title</label>
                                            <div class="col-lg-9">
                                                <input type='text' name="title" class="form-control" />
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
                                <th class="w-50">Title</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets->result() as $row) { ?>
                                <tr>
                                    <td class="id">
                                        <?= $row->id ?>
                                    </td>
                                    <td class="title">
                                        <?= $row->title ?>
                                    </td>
                                    <td>
                                        <?= $row->created_at ?>
                                    </td>
                                    <td>
                                        <?= $this->automation_model->getUserName($row->created_by) ?>
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
                    <!--end: Datatable-->
                    <!--begin::Pagination-->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <?= $this->pagination->create_links() ?>
                    </div>
                    <!--end:: Pagination-->


                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
</div>
<!--end::Content-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    $(document).on("click", ".edit", function () {
        var id = $(this).attr('recordID');
        var title = $(this).closest('tr').find('.title').text();
        $('#editModal').find('input[name=id]').val(id);
        $('#editModal').find('input[name=title]').val(title);

    });
</script>