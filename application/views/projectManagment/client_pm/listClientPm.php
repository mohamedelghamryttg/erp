<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">  
            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Client PM</h3>
                </div>
                <form class="cmxform form-horizontal " action="<?php echo base_url() ?>projectManagment/listClientPm" method="get"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group row">                           
                            <label class="col-lg-2 control-label text-lg-right" for="role name">Name</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="name" value="<?= $name??'' ?>">
                            </div>
                            <label class="col-lg-2 control-label text-lg-right" for="role name">Email</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="email" value="<?= $email??'' ?>">
                            </div>
                        </div>
                        <div class="form-group row">  
                       
                            <label class="col-lg-2 control-label text-lg-right" for="role date">Client</label>
                            <div class="col-lg-4">
                                <select name="customer" class="form-control m-b" id="customer">
                                    <option value="" disabled="disabled" selected="selected">-- Select Client --</option>
                                    <?= $this->customer_model->selectCustomerByPm($customer??'', $this->user, $permission, $this->brand) ?>
                                </select>
                            </div>
                           
                        </div>

                       

                    </div>

                    <div class="card-footer">
                        <div class="row">                            
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-success" name="search" type="submit">Search</button>
                                <a href="<?= base_url() ?>projectManagment/listClientPm/" class="btn btn-danger">(x) Clear Filter</a>



                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php if ($this->session->flashdata('true')) { ?>
                <div class="alert alert-success" role="alert">
                    <span class="far fa-check-circle text-white"></span>
                    <span><strong>
                            <?= $this->session->flashdata('true') ?>
                        </strong></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <span class="fas fa-exclamation-triangle text-white"></span>
                    <span><strong>
                            <?= $this->session->flashdata('error') ?>
                        </strong></span>
                </div>
            <?php } ?>
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Client PM List <span class="btn btn-dark btn-sm"><span>
                                    <?= $total_rows ?>
                                </span></span></h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <?php if ($permission->add == 1) { ?>
                            <a href="<?= base_url() ?>projectManagment/addClientPm" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                         height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path
                                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                        fill="#000000" opacity="0.3" />
                                    </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Add New </a>
                        <?php } ?>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <!--<th>Code</th>-->
                                <th>Name</th>
                                <th>Email</th>
                                <th>Client</th>                
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Edit </th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientPms->result() as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row->id; ?>
                                    </td>
                                    <!--<td><?= $row->code ?>   </td>-->
                                    <td> <?= $row->name; ?>  </td>
                                    <td> <?= $row->email; ?>  </td>
                                    <td >
                                        <?php echo $this->customer_model->getCustomer($row->customer_id); ?>
                                    </td>

                                    <td>
                                        <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                                    </td>
                                    <td>
                                        <?php echo $row->created_at; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($permission->edit == 1) { ?>
                                            <a href="<?php echo base_url() ?>projectManagment/editClientPm?p=<?=base64_encode($row->id)?>">
                                                <i class="fas fa-pencil-alt"></i> 
                                            </a>  
                                         <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($permission->delete == 1) { ?>
                                            <a href="<?php echo base_url() ?>projectManagment/deleteClientPm?p=<?= base64_encode($row->id); ?>" title="delete" 
                                               onclick="return confirm('Are you sure you want to delete this Record ?');">
                                                <i class="fas fa-times-circle text-danger"></i>
                                            </a>
                                         <?php } ?>
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
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
