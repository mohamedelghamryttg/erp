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
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              

              <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">Search</h3>
          </div>

            <form class="form" id="report" method="post" enctype="multipart/form-data">
             <div class="card-body">

                <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role name">Date From</label>
                <div class="col-lg-3">
                     <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="">
                </div>
                 <label class="col-lg-2 control-label text-lg-right" for="role name">Date To</label>
                <div class="col-lg-3">
                   <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="">
               </div>
              </div>
             <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role date">Task Code</label>
                <div class="col-lg-3">
                      <input type="text" class="form-control" name="id">
                </div>
                <label class="col-lg-2 control-label text-lg-right" for="role date">Task Name</label>
                <div class="col-lg-3">
                        <input type="text" class="form-control" name="task_name">
                </div>
                 </div>
                 <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role date">Report Name</label>
                <div class="col-lg-3">
               <select name="report" class="form-control m-b"  id="report" required />
                       <option disabled="disabled" selected="selected" value="">-- Select Report --</option>
                       <option value="1">By DTP</option>
                       <option value="2">By LE</option>
                       <option value="3">By Translators</option>
              </select>
                </div>
                 </div>
             
              
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                     <button class="btn btn-primary" onclick="var e2 = document.getElementById('report'); e2.action='<?=base_url()?>projects/pmInHouse'; e2.submit();" name="search" type="submit"> Search</button>
                <button class="btn btn-success" onclick="var e2 = document.getElementById('report'); e2.action='<?=base_url()?>projects/exportPmInHouse'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
               </div>
              </div>
             </div>
            </form>
                       </div>
                        </div>
                        
              <!-- end search form -->
            
              <!--begin::Card-->
<!-- By DTP -->
<?php if($report == 1){ ?>
                <div class="card" >
                  <div class="card-header">
                    <div class="card-title">
                      <h3 class="card-label">In House Report By DTP</h3>
                    </div>
                    
                  </div>
                  <div class="card-body" style="overflow-y: scroll;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2" style="overflow:scroll;">
          <thead>
                 <th colspan="20" style="text-align: center;">In House Team Report By DTP</th>
            </thead>
            <thead>
             <tr>
                <th>Task Code</th>
                <th>Task Subject</th>
                <th>Task Type</th>
                <th>Unit</th>
                <th>Volume</th>
                <th>Source Language Direction</th>
                <th>Target Language Direction</th>
                <th>Source Application</th>
                <th>Target Application</th>
                <th>Translatio In</th>
                <th>Rate</th>
                <th>File Attachment</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>View Task</th>


              </tr>
            </thead>
           <tbody>
              <?php foreach ($job->result() as $row) { ?>
              <tr class="">
                <td>DTP-<?=$row->id?></td>
                <td><?=$row->task_name?></td>
                <td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
                <td><?=$this->admin_model->getUnit($row->unit)?></td>
                <td><?=$row->volume?></td>
                <td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
                <td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->source_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->target_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->translation_in)?></td>
                <td><?=$row->rate?></td>
                <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?=$row->start_date?></td>
                <td><?=$row->delivery_date?></td>
                <td><?=$this->projects_model->getDTPTaskStatus($row->status)?></td>
                <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                <td><?=$row->created_at?></td>
                                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?php echo base_url()?>projects/dTPTask?t=<?php echo 
                  base64_encode($row->id) ;?>&j=<?=base64_encode($job)?>" class="">
                    <i class="fa fa-eye"></i> View Task
                  </a>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              
                    </table>
                  </div>
                </div>
                <!--end::Card-->
<?php } ?>
<!-- End DTP Table -->
<!-- By LE -->
<?php if($report == 2){ ?>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                      <h3 class="card-label">In House Team Report By LE</h3>
                    </div>
                    
                  </div>
                  <div class="card-body" style="overflow-y: scroll;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2" style="overflow:scroll;">
          <thead>
                 <th colspan="20" style="text-align: center;">In House Team Report By LE</th>
            </thead>
            <thead>
             <tr>
                <th>Task Code</th>
                <th>Task Subject</th>
                <th>Task Type</th>
                <th>Subject Matter</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <th>Task File</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>View Task</th>


              </tr>
            </thead>
           <tbody>
              <?php foreach ($job->result() as $row) { ?>
              <tr class="">
                <td>LE-<?=$row->id?></a></td>
                <td><?php echo $row->subject ;?></td>
                <td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
                <td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?php echo $this->projects_model->getLETaskStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?php echo base_url()?>projects/leTask?t=<?php echo 
                  base64_encode($row->id) ;?>" class="">
                    <i class="fa fa-eye"></i> View Task
                  </a>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              
                    </table>
                  </div>
                </div>
                <!--end::Card-->
<?php } ?>
<!-- End LE Table -->

<!-- By Translation -->
<?php if($report == 3){ ?>
                <div class="card" >
                  <div class="card-header">
                    <div class="card-title">
                      <h3 class="card-label">In House Team Report By Translation</h3>
                    </div>
                    
                  </div>
                  <div class="card-body" style="overflow-y: scroll;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2" style="overflow:scroll;">
          <thead>
                 <th colspan="20" style="text-align: center;">In House Team Report By Translation</th>
            </thead>
            <thead>
             <tr>
                  <th>Task Code</th>
                  <th>Task Subject</th>
                  <th>Task Type</th>
                  <th>Count</th>
                  <th>Weighted Word Count</th>
                  <th>Unit</th>
                  <th>Start Date</th>
                  <th>Delivery Date</th>
                  <th>Task File</th>
                  <th>Status</th>
                  <th>Created By</th>
                  <th>Created At</th>
                  <th>View Task</th>



              </tr>
            </thead>
          <tbody>
              <?php foreach ($job->result() as $row) { ?>
              <tr class="">
                <td>Translation-<?=$row->id?></a></td>
                                <td><?php echo $row->subject ;?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $row->weighted_word ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?php echo $this->projects_model->getTranslationTaskStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?php echo base_url()?>projects/translationTask?t=<?php echo 
                  base64_encode($row->id) ;?>" class="">
                    <i class="fa fa-eye"></i> View Task
                  </a>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              
                    </table>
                  </div>
                </div>
                <!--end::Card-->
<?php } ?>





              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->