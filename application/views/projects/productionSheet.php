<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Date Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="productionForm" action="<?php echo base_url()?>projects/productionSheet" method="get" enctype="multipart/form-data">
        <?php 
               if(!empty($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = 1;
                }
        ?>
        <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Created Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Created Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
            </div>

        </div>
       <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Closed Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="closed_date_from" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Closed Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="closed_date_to" autocomplete="off">
            </div>

        </div>
       
       <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Status</label>

                    <div class="col-lg-3">
                      <select name="status" class="form-control m-b" id="status" />
                                 <option disabled="disabled" selected="selected">-- Select Status --</option>
                                 <option value="2">Running</option>
                                 <option value="1">Delivered</option>
                        </select>
                    </div>
                </div>
        <?php if($permission->view == 1){ ?>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Created By</label>
          <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by"/>
                         <option value="">-- Select PM --</option>
                         <?=$this->admin_model->selectAllPm($created_by,$this->brand)?>
                </select>
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" name="search" type="submit">Search</button> 
              	<button class="btn btn-success" onclick="var e2 = document.getElementById('productionForm'); e2.action='<?=base_url()?>projects/exportProductionSheet'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                <a href="<?=base_url()?>projects/productionSheet" class="btn btn-warning">(x) Clear Filter</a> 
            </div>
        </div>   
        </form>
      </div>
    </section>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Production Report
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Project Code</th>
                <th>Project Name</th>
                <th>Client</th>
                <th>Product Line</th>
                <th>PO Number</th>
                <th>PO Status</th>
                <th>Status</th>
                <th>Closed Date</th>
                <th>Created By</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($project)){
              foreach ($project->result() as $project) { 
                $job = $this->db->get_where('job',array('project_id'=>$project->id))->result();
            ?>
              <tr>
                <td rowspan="3"><a href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($project->id)?>"><?=$project->code?></a></td>
                <td><a href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($project->id)?>"><?=$project->name?></a></td>
                <td><?php echo $this->customer_model->getCustomer($project->customer);?></td>
                <td><?php echo $this->customer_model->getProductLine($project->product_line);?></td>
                <td><?php echo $project->po ;?></td>
                <td><?=$this->accounting_model->getPOStatus($project->verified)?></td>                
                <td>
                  <?=$this->projects_model->getNewProjectStatus($project->status,$project->id)?>
                </td>
                <td><?php echo $project->closed_date ;?></td>
                <td><?php echo $this->admin_model->getAdmin($project->created_by) ;?></td>
                <td><?php echo $project->created_at ;?></td>
              </tr>
              <!-- jobs -->
              <tr>
                <td colspan="6">
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                      <th>Job Code</th>
                      <th>Service</th>
                       <th>Source</th>
                       <th>Target</th>
                       <th>Volume</th>
                       <th>Rate</th>
                       <th>Currency</th>
                       <th>Unit</th>
                       <th>Total Revenue</th>
                       <th>Status</th>
                       <th>Delivery Date</th>
                        <th>Created By</th>
                    </thead>
                    <tbody>
                    <?php 
                    $total = 0;
                    foreach ($job as $job) { 
                      $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                      $jobTotal = $this->sales_model->calculateRevenueJob($job->id,$job->type,$job->volume,$priceList->id);
                      $total = $total + $jobTotal;
                    ?>
                      <tr>
                        <td><?=$job->code?></td>
                        <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                        <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                        <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                        <td><?php echo $job->volume ;?></td>
                        <td><?php echo $priceList->rate ;?></td>
                        <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                        <td><?php echo $this->admin_model->getUnit($priceList->unit) ;?></td>
                        <td><?php echo $jobTotal; ?></td>
                        <td><?php echo $this->projects_model->getJobStatus($job->status) ;?></td>
                        <td><?php echo $job->closed_date ;?></td>
                        <td><?php echo $this->admin_model->getAdmin($job->created_by) ;?></td>
                      </tr>
                    <?php } ?>
                      <tr>
                        <td colspan="8">Project Total Revenue</td>
                        <td><?=$total?></td>
                        <td colspan="3"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <!-- Tasks -->
              <tr>
                <td colspan="6">
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                       <th>Task Code</th>
                        <th>Task Type</th>
                       <th>Vendor</th>
                       <th>Count</th>
                       <th>Unit</th>
                       <th>Rate</th>
                       <th>Total Cost</th>
                       <th>Currency</th>
                       <th>Start Date</th>
                       <th>Delivery Date</th>
                         <th>Time Zone</th>
                       <th>Task File</th>
                         <th>Vendor Task File</th>
                       <th>Status</th>
                       <th>Closed Date</th>
                       <th>VPO Status</th>
                       <th>Has Error</th>
                        <th>Created By</th>
                    </thead>
                    <tbody>
                    <?php 
                    $total = 0;
                      $job_ids = $this->db->query(" SELECT GROUP_CONCAT(id SEPARATOR ',') AS job_ids FROM job WHERE project_id = '$project->id' ")->row()->job_ids;
                      if($job_ids == NULL){
                          $job_ids = 0;
                      }
                      $task = $this->db->query(" SELECT * FROM `job_task` WHERE job_id IN (".$job_ids.") ")->result();
                      $total = 0;
                    foreach ($task as $task) {
                      $taskTotal = $task->rate * $task->count; 
                      $total = $total + $taskTotal;
                    ?>
                      <tr>
                        <td><a href="<?=base_url()?>projects/taskPage?t=<?=base64_encode($task->id)?>"><?=$task->code?></a></td>
                        <td><?php echo $this->admin_model->getTaskType($task->task_type);?></td>
                        <td><?php echo $this->vendor_model->getVendorName($task->vendor);?></td>
                        <td><?php echo $task->count ;?></td>
                        <td><?php echo $this->admin_model->getUnit($task->unit) ;?></td>
                        <td><?php echo $task->rate ;?></td>
                        <td><?php echo $task->rate * $task->count;?></td>
                        <td><?php echo $this->admin_model->getCurrency($task->currency) ;?></td>
                        <td><?php echo $task->start_date ;?></td>
                        <td><?php echo $task->delivery_date ;?></td>
                        <td><?=$this->admin_model->getTimeZone($task->time_zone)?></td>
                        <td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/taskFile/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                        <td><?php if(strlen($task->vendor_task_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/vendorTaskFile/<?=$task->vendor_task_file?>" target="_blank">Click Here</a><?php } ?></td>
                        <td><?php echo $this->projects_model->getJobStatus($task->status) ;?></td>
                        <td><?php echo $task->closed_date ;?></td>
                        <td><?=$this->accounting_model->getPOStatus($task->verified)?></td>
                        <td>
                        <?php if($task->verified == 2){
                            $errors = explode(",", $task->has_error);
                            for ($i=0; $i < count($errors); $i++) { 
                              if($i > 0){echo " - ";}
                              echo $this->accounting_model->getError($errors[$i]);
                             } 
                           } ?>
                        </td>
                        <td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
                      </tr>
                    <?php } ?>
                      <tr>
                        <td colspan="6">Project Total Cost</td>
                        <td><?=$total?></td>
                        <td colspan="11"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            <?php }} ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>