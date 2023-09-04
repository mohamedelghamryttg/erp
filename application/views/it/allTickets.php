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
    <!--begin::Subheader-->
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center mr-1">

            </div>
            <!--end::Info-->

        </div>  
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <div class="container">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Tickets</h3>
                    
                </div>
                      <div class="card-toolbar">
                      <?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>it/addTicket" class="btn btn-primary font-weight-bolder"> 

                            <i class="fa fa-pen"></i>Send Ticket </a>
                    <?php } ?>

                </div>
            <div class="card-body p-0">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" >

                    <thead>
                        <tr> 
                            <th no-sort>Ticket ID</th>
                            <th>Ticket From</th>                           
                            <th>Ticket Subject</th>
                            <th>Date</th>                           
                            <th>view</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets->result() as  $row) { ?>
                        <tr> 
                                <td ><?= $row->id ?></td>
                                <td><?= $row->from_email ?><br/><span class="label label-square label-light-info font-size-xs"><?= $this->automation_model->getEmpName($row->emp_id); ?></span></td>                                
                                <td><?= word_limiter($row->subject,10) ?></td>
                                <td><?= $row->created_at  ?></td>
                               <td>
                                    <a href="<?= base_url() . 'it/viewTicket/' . $row->id ?>" class="">
                                        <i class="fa fa-eye"></i> View 
                                    </a>
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
<style>
    .label{
        width:auto;padding: 10px;
    }    
   
</style>
