
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
        <!--begin::Container-->
        <div class="container">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h4 class="card-label">Incidents Log <i class="fa fa-arrow-alt-circle-right"></i> <?= $this->hr_model->getEmployee($employee_id).'('. $this->accounting_model->getMonth($month).')' ?>
                    <h5 class="text-default"> <?= $sub_core!=''?' <i class="fa fa-arrow-alt-circle-right"></i> '.$this->hr_model->getSubCoreName($sub_core):'' ?></h5></h4>
                </div>
              
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">

                    <thead>
                         <tr>
                            <th>#</th>
                            <th>Employee NAme</th>
                            <th>title</th>
                            <th>Date</th>                                                 
                            <th>Created At</th>     
                            <th></th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $k => $row) { ?>
                            <tr>     
                                <td><?= $k+1 ?></td>
                                  <td><?= $this->hr_model->getEmployee($row->emp_id); ?></td>                                
                                <td><?= character_limiter($row->title, 30,'...') ?></td>  
                                <td><?= $row->date ?></td>                               
                                <td><?= $row->created_at ?></td>                             
                                <td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#Modal_<?= $row->id ?>">View</button></td>                              
                            </tr>
                             <div class="modal fade" id="Modal_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title"><?= $row->title ?></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p class='text-danger'><?= $this->hr_model->getEmployee($row->emp_id); ?></p>
                                      <p class='text-danger'><?= $row->date ?></p>
                                      <p><?= $row->title ?></p>                                     
                                      <p><?= $row->comment ?></p>                                      
                                      <p>Attached File : <?=$row->file?"<a href=".base_url()."assets/uploads/performanceManagment/".$row->file." target='_blank'>Click Here</a>":'No File'?></p>
                                      <hr/>
                                      <p><span class="font-weight-bold text-danger">Kpi Core : </span><?= $this->hr_model->getCoreName($row->kpi_core_id) ?>
                                        <i class="fa fa-sm fa-arrow-circle-right text-danger"></i> <?= $this->hr_model->getSubCoreName($row->kpi_sub_id) ?></p>
                                      <hr/>
                                      <p><span class="font-weight-bold text-danger">Created By : </span><?= $this->admin_model->getUser($row->created_by) ?>
                                      <span class="font-weight-bold text-danger"> At : </span><?= $row->created_at ?></p>
                                    </div>
                                    <div class="modal-footer">                                      
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        <?php } ?>

                    </tbody>
                </table>
                <!--end: Datatable-->              
            </div>
        </div>      
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->