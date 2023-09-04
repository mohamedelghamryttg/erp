
        <form class="form " action="<?php echo base_url()?>projects/closeJob" onsubmit="return checkJobVerifyForm();" method="post" enctype="multipart/form-data">
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">DTP Request </h3>
                    </div>
                    <div class="card-toolbar">
                    
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
              <tr>
                                <th>Task Code</th>
                                <th>PM</th>
                                <th>Task Name</th>
                                <th>Task Type</th>
                                <th>Product line</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Source Language</th>
                                <th>Source Language Direction</th>
                                <th>Target Language</th>
                                <th>Target Language Direction</th>
                                <th>Source Application</th>
                                <th>Target Application</th>
                                <th>Translatio In</th>
                                <th>Rate</th>
                                <th>File Attachment</th>
                                <th>Start Delivery</th>
                                <th>Delivery Date</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Task Started At</th>
                                <th>View Jobs</th>
                <th>View Request</th>
              </tr>
            </thead>
            <tbody>
                          <?php
                if($task->source_language == 0){
                                  $source = $priceListData->source;
                                  $target = $priceListData->target;
                                }else{
                                  $source = $task->source_language;
                                  $target = $task->target_language;
                                }
                          ?>
              <tr>
                <td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($task->id) ;?>" class="">DTP-<?=$task->id?></a></td>
                <td><?=$this->admin_model->getAdmin($task->created_by)?></td>
                <td><?=$task->task_name?></td>
                <td><?=$this->admin_model->getDTPTaskType($task->task_type)?></td>
                <td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
                <td><?=$task->volume?></td>
                <td><?=$this->admin_model->getUnit($task->unit)?></td>
                <td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
                <td><?=$this->admin_model->getUnit($task->unit)?></td>
                <td><?=$this->admin_model->getDTPDirection($task->source_direction)?></td>
                <td><?=$this->admin_model->getDTPDirection($task->target_direction)?></td>
                <td><?=$this->admin_model->getDTPApplication($task->source_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($task->target_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($task->translation_in)?></td>
                <td><?=$task->rate?></td>
                <td>
                    <?php if(strlen($task->file) > 1){ ?>
                                            <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/dtpRequest/",$task->file,$task->start_after_type) ?>" target="_blank">Click Here</a>
                                       <?php } else{
                                            if($task->start_after_id != null && $task->start_after_type == "Vendor"){?>
                                                <?= $this->projects_model->getTaskVendorNotes($task->start_after_id)?>
                                        <?php }} ?>
                </td>
                <td><?=$task->start_date?></td>
                <td><?=$task->delivery_date?></td>
                <td><?=$task->created_at?></td>
                <td><?=$this->projects_model->getDTPTaskStatus($task->status)?></td>
                <td><?=$this->admin_model->getAdmin($task->status_by)?></td>
                <td><?=$task->status_at?></td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo 
                    base64_encode($task->id) ;?>" class="">
                      <i class="fa fa-eye"></i> View Jobs
                  </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?php echo base_url()?>dtp/viewRequest?t=<?php echo 
                    base64_encode($task->id) ;?>" class="">
                      <i class="fa fa-eye"></i> View Request
                  </a>
                  <?php } ?>
                </td>
              </tr>
            </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <?php if($this->session->flashdata('true')){ ?>
            <div class="alert alert-success" role="alert">
                    <span class="fa fa-check-circle"></span>
                    <span><strong><?=$this->session->flashdata('true')?></strong></span>
                  </div>
            <?php  } ?>
            <?php if($this->session->flashdata('error')){ ?>
                  <div class="alert alert-danger" role="alert">
                    <span class="fa fa-warning"></span>
                    <span><strong><?=$this->session->flashdata('error')?></strong></span>
                  </div>
            <?php  } ?> 
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">DTP Jobs </h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php //if($permission->add == 1 && $task->status == 2){ ?>
                        <a href="<?=base_url()?>dtp/addJob?t=<?=base64_encode($task->id)?>" class="btn btn-primary font-weight-bolder"> 
                      <span class="svg-icon svg-icon-md">
                      <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="0" y="0" width="24" height="24" />
                          <circle fill="#000000" cx="9" cy="15" r="6" />
                          <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                        </g>
                      </svg>
                      <!--end::Svg Icon-->
                      </span>Add New Job</a>
                       <?php //} ?>

                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                     <thead>
              <tr>
                                <th>Task Code</th>
                                <th>Assigned DTP</th>
                                <th>Task Type</th>
                                <th>Volume</th>
                                <th>Updated Volume</th>
                                <th>Unit</th>
                                <th>Source Language</th>
                                <th>Source Language Direction</th>
                                <th>Target Language</th>
                                <th>Target Language Direction</th>
                                <th>Source Application</th>
                                <th>Target Application</th>
                                <th>Translatio In</th>
                                <th>File Attachment</th>
                                <th>Start Delivery</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                               <th>View Job</th>
                <th>Edit </th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { ?>
              <tr class="">
                              <td><a href="<?php echo base_url()?>dtp/dtpJobs?t=<?php echo base64_encode($task->id) ;?>" class="">DTP-<?=$task->id?>-<?=$row->id?></a></td>
                <td><?php echo $this->admin_model->getAdmin($row->dtp) ;?></td>
                <td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
                <td><?=$row->volume?></td>
                <td><?=$row->updated_count?></td>
                <td><?=$this->admin_model->getUnit($row->unit)?></td>
                <td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
                <td><?=$this->admin_model->getLanguage($priceListData->target)?></td>
                <td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
                <td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->source_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->target_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->translation_in)?></td>
                <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpJob/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?=$row->start_date?></td>
                <td><?=$row->delivery_date?></td>
                <td><?=$this->projects_model->getTranslationJobStatus($row->status)?></td>
                <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                <td><?=$row->created_at?></td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?php echo base_url()?>dtp/viewDtpTask?t=<?php echo 
                    base64_encode($row->id) ;?>" class="">
                      <i class="fa fa-eye"></i> View Job
                  </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if($permission->edit == 1 && ($row->status == 0 || $row->status == 3)){ ?>
                  <a href="<?php echo base_url()?>dtp/editJob?t=<?php echo 
                  base64_encode($task->id) ;?>&j=<?=base64_encode($row->id)?>" class="">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if($permission->delete == 1 && $row->status == 0){ ?>
                  <a href="<?php echo base_url()?>dtp/deleteJob?t=<?php echo 
                  base64_encode($row->id) ;?>&p=<?=base64_encode($row->project_id)?>" title="delete" 
                  class="" onclick="return confirm('Are you sure you want to delete this Project ?');">
                    <i class="fa fa-times text-danger text"></i> Delete
                  </a>
                  <?php } ?>
                </td>
              </tr> 
              <?php } ?>
            </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
             