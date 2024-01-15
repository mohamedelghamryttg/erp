<style>
    .label{
        width:auto;
        padding: 10px;
    }
    

</style>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
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

        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Payroll</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Details  # <?=$row->id?><a href="<?= base_url() ?>/payroll/editCard/<?= $row->id ?>" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="fa fa-pen"></i> 
                            </a></span>

                    </div>
                    <!--end::Search Form-->

                </div>
                <!--end::Details-->

            </div>
        </div>
        <!--begin::Card-->
        <div class="card">           
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover p-5" id="kt_datatable2">
                    <thead>
                        <tr>
                            <th >Employee Name :</th>
                            <td colspan="3" class="text-left"><?php echo $this->hr_model->getEmployee($row->emp_id); ?> 
                                <br/>
                                <span class="label label-square label-light-info font-size-xs text-dark"><?= $this->automation_model->getEmpDep($row->emp_id) ?></span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Payroll Month :</th>
                            <td><?= date_format(date_create($row->start_date), 'F Y'); ?></td>
                            <th>Till :</th>
                            <td><?= $row->end_date ? date_format(date_create($row->end_date), 'F Y') : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Action :</th>
                            <td><?= $this->hr_model->getPayrollActions($row->action); ?></td>
                            <th>Total Amount :</th>
                            <td><?= $row->amount . ' ' . $this->hr_model->getPayrollUnits($row->unit) ?></td>
                        </tr>
                        <?php if(!empty($row->monthly_installment)){?>
                        <tr>
                            <th>Num. Of Months :</th>
                            <td><?= $row->num_month ?></td>
                            <th>Monthly Installment :</th>
                            <td><?= $row->monthly_installment . ' ' . $this->hr_model->getPayrollUnits($row->unit) ?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <th >Comment :</th>
                            <td colspan="3"><?= $row->comment ?>
                            </td>
                        </tr>
                        <tr>
                            <th >Created By :</th>
                            <td colspan="3"><?= $this->admin_model->getAdmin($row->created_by) ?>
                                <br/><span class="label label-square label-light-info  text-dark"><?= $row->created_at ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Last Updated By :</th>
                            <td colspan="3"><?= $this->admin_model->getAdmin($row->updated_by) ?>
                                <br/><span class="label label-square label-light-info  text-dark"><?= $row->updated_at ?></span>
                            </td>
                        </tr>


                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->   
    </div>
</div> 

