<?php if ($this->session->flashdata('true')) { ?>
    <div class="alert alert-success" role="alert">
        <span class="fa fa-check-circle"></span>
        <span><strong><?= $this->session->flashdata('true') ?></strong></span>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?> 
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-warning"></span>
        <span><strong><?= $this->session->flashdata('error') ?></strong></span>
    </div>
<?php } ?>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!-- start search form card --> 
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Search Payment Methods</h3>
                </div>
                <form class="form"  action="<?php echo base_url() ?>accounting/allPaymentMethods" method="get" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label text-lg-right">Name</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="name" value="<?= $name ?>">

                            </div> 
                            <label class="col-lg-2 col-form-label text-lg-right">Bank Name</label>
                            <div class="col-lg-3">
                                <select name="bank" class="form-control m-b"  >
                                    <option value="" disabled="disabled" selected="selected">-- Select Bank --</option>
                                    <option value="100" <?=$bank == 100 ?"selected":""?>>None</option>
                                    <?= $this->accounting_model->selectBank($bank) ?>
                                </select>
                            </div> 
                        </div>  
                    </div>  
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                                <button class="btn btn-success mr-2" name="search" type="submit">Search</button>  
                                <a href="<?= base_url() ?>accounting/allPaymentMethods" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end search form -->
            <!--begin::Card-->
            <div class="card">
               <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">All Payment Methods</h3>
                    </div>
                
                <div class="card-toolbar">
                <?php if ($permission->add == 1) { ?>
                  <a href="<?= base_url() ?>accounting/addPaymentMethod" class="btn btn-primary font-weight-bolder"> 

                      <i class="fa fa-pen"></i>Add New </a>
                  <?php } ?>

              </div>   
                   </div>
                 <div class="card-body ">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Bank Name</th> 
                                <th>Created By</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payment_method->result() as $row) { ?>
                                <tr>
                                    <td><?= $row->id ?></td>
                                    <td><?= $row->name ?></td>               
                                    <td><?php echo $this->accounting_model->getBank($row->bank); ?></td> 
                                    <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                    <td><?php echo $row->created_at; ?></td>
                                    <td>
                                     <?php if($permission->delete == 1){?>
                                        <a title ="Delete" href="<?php echo base_url() ?>accounting/deletePaymentMethod/<?=$row->id?>" onclick="return confirm('Deleting Method ... are you sure?')" class="ml-5">
                                            <i class="fa fa-trash"></i> 
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
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->