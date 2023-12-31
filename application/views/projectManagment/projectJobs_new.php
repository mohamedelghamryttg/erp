<style>
    .modal-dialog{
        max-width: 900px!important;
        width: 900px!important;
    }
    .nav-link{
        padding: 5px 12px!important;
    }
    #list-example{
        min-height: auto;
        border: 1px #185898 solid;
        border-left: 10px #185898 solid;
        font-weight: bold;
        border-radius: 0;
    }
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
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
                        <?php }?>
    </div>
</div>
<div class="row">
    <div class="col-sm-10" >        
        <nav id="list-example" class="navbar navbar-light bg-light px-3">

            <ul class="nav nav-pills" style="width:100%">
                <li class="nav-item">
                    <a class="nav-link" href="#po">Po</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#close_jobs">Close Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#project_jobs">Project Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#vendor_tasks">Vendor Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#vendor_tasks_offers">Vendor Offers List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#translation_tasks">Translation Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#dtp_tasks">DTP Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#le_tasks">LE Requests</a>
                </li>

            </ul>
        </nav>
       <section class="panel" id="po">
           <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/addPoNumber"  method="post" enctype="multipart/form-data">
                    <header class="panel-heading">
                            Add Po Number
                    </header>
                    <div class="panel-body">
                        <input type="text" name="project_id" value="<?=base64_encode($project_data->id)?>" hidden="">
                        <div class="form-group row">
                            <label class="col-lg-2 control-label" for="role File Attachment">CPO Attachment</label>

                            <div class="col-lg-3">
                                <input type="file" class=" form-control" name="cpo_file" id="cpo_file" required="" accept="'application/zip'">
                            </div>
                            <label class="col-lg-2 control-label">PO Number</label>

                            <div class="col-lg-3">
                                <input type="text" class=" form-control" name="po" id="po" required>
                            </div>
                            </div>
                         <div class="form-group row">
                            <label class="col-lg-2 control-label">Total Amount</label>
                            <div class="col-lg-3">
                                <input type="number" step=".01" min="0" class=" form-control" name="total_amount"  required>
                            </div>
                             <div class="col-lg-2"></div>
                            <div class="col-lg-4">
                                <input type="submit"  name="save" value="Save Changes" class="btn btn-primary">
                                </div>
                               
                        </div>
                        </div>
           </form>
        </section>
        <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="scrollspy-example" tabindex="0">
        <form class="cmxform form-horizontal " action="<?php echo base_url()?>ProjectManagment/closeJobNew" onsubmit="return checkJobVerifyForm();" method="post" enctype="multipart/form-data">
            <section class="panel" id="close_jobs">			
                <header class="panel-heading">
                    Close Jobs
                </header>		
                <div class="panel-body">
                    <input type="text" name="project_id" value="<?= base64_encode($project_data->id) ?>" hidden="">
                    <div class="form-group">          
                        <label class="col-lg-2 control-label">PO Number</label>

                        <div class="col-lg-3">
                            <select name="po" class="form-control" required="">
                                            <?= $this->projects_model->selectPoAvailable($project_data->id);?>
                                        </select>
                        </div>
                    </div>
                    <div class="form-group">                	
                        <div class="col-lg-12 text-center"style="margin-top: 1rem;">
                            <input type="submit" style="margin-right: 5rem;" name="save" value="Save Changes" class="btn btn-primary">
                            <a class="btn btn-success " onclick="checkAll()" style="margin-right: 5rem;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Select All</a>
                            <a class="btn btn-danger " onclick="unCheckAll()" style="margin-right: 5rem;"><i class="fa fa-square" aria-hidden="true"></i> Select None</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="panel" id="project_jobs">
                    <header class="panel-heading">
                        Project Jobs
                    </header>	<div class="panel-body">
                        <div class="adv-table editable-table " style="overflow-y: scroll;">
                            <div class="clearfix">
                                <div class="btn-group">
                                    <?php if ($permission->add == 1 && $project_data->status == 0) { ?>
                                        <a href="<?= base_url() ?>projectManagment/addJob?t=<?= base64_encode($project) ?>" class="btn btn-primary ">Add New Job</a>
                                        </br></br></br>
                                    <?php } ?>

                                </div>

                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Code</th>
                                        <th>Job Name</th>
                                        <th>Product Line</th>
                                        <th>Service</th>
                                        <th>Source</th>
                                        <th>Target</th>
                                        <th>Volume</th>
                                        <th>Rate</th>
                                        <th>Total Revenue</th>
                                        <th>Currency</th>
                                        <th>Start Date</th>
                                        <th>Delivery Date</th>
                                        <th>Status</th>
                                        <th>PO Number</th>
                                        <th>CPO File</th>
                                        <th>PO Status</th>
                                        <th>PO Status Date</th>
                                        <th>Has Error</th>
                                        <th>Closed Date</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Job Files</th>
                                        <th>Email Attachment</th>
                                        <th>Actions</th>
    <!--                                    <th>Re-open</th>
                                        <th>Edit </th>
                                        <th>Delete</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($job->result() as $row) {
                                        $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                                        $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
                                        $check = $this->projects_model->checkCloseJob($row->id);
                                        $poData = $this->projects_model->getJobPoData($row->po);
                                        ?>
                                        <tr>
                                            <td>
                                               <?php //if(($check || $row->job_type == 1) && $row->status != 1){ 
                                                                    if($row->status != 1){ ?>
                                                <input type="checkbox" class="checkPo" name="select[]" value="<?= $row->id ?>">
        <?php } ?>
                                            </td>
                                            <td><a href="<?= base_url() ?>projects/jobTasks?t=<?= base64_encode($row->id) ?>"><?= $row->code ?></a>
                                                <?php
                                                if ($row->job_type == "1") {
                                                    echo "<p class='text-center mt-2'><span class='label label-danger'>Free Job</span></p>";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $this->customer_model->getProductLine($priceList->product_line); ?></td>
                                            <td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                                            <?php if ($row->type == 1) { ?>
                                                <td><?php echo $row->volume; ?></td>
        <?php } elseif ($row->type == 2) { ?>
                                                <td><?php echo $total_revenue / $priceList->rate; ?></td>
        <?php } ?>
                                            <td><?php echo $priceList->rate; ?></td>
                                            <td><?= $total_revenue ?></td>
                                            <td><?php echo $this->admin_model->getCurrency($priceList->currency); ?></td>
                                            <td><?php echo $row->start_date; ?></td>
                                            <td><?php echo $row->delivery_date; ?></td>
                                            <td><?php echo $this->projects_model->getJobStatus($row->status); ?></td>
                                            <td><?php if (isset($poData)) {
                                            echo $poData->number;
                                        } ?></td>
                                            <td><?php if (isset($poData)) { ?><a href="<?= base_url() ?>assets/uploads/cpo/<?= $poData->cpo_file ?>" target="_blank">Click Here</a><?php } ?></td>
                                            <td><?php if (isset($poData)) {
                                            $this->accounting_model->getPOStatus($poData->verified);
                                        } ?></td>
                                            <td><?= $poData->verified_at ?></td>
                                            <td>
                                                <?php
                                                if (isset($poData)) {
                                                    if ($poData->verified == 2) {
                                                        $errors = explode(",", $poData->has_error);
                                                        for ($i = 0; $i < count($errors); $i++) {
                                                            if ($i > 0) {
                                                                echo " - ";
                                                            }
                                                            echo $this->accounting_model->getError($errors[$i]);
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td> 
        <?php if ($row->status == 0) { ?>
                                                <td> </td>
                                                <?php } elseif ($row->status == 1) { ?>
                                                <td><?php echo $row->closed_date; ?></td>
                                                <?php } ?>
                                            <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                            <td><?php echo $row->created_at; ?></td>
                                            <td> <?php if(strlen($row->job_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/jobFile/<?=$row->job_file?>" target="_blank"><?=$row->job_file_name?></a><?php }?></td>
                                            <td> <?php if(strlen($row->attached_email) > 1 && $row->job_type == "1"){ ?><a href="<?=base_url()?>assets/uploads/jobFile/<?=$row->attached_email?>" target="_blank">Click Here..</a><?php }?></td>
                                            <td> 
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-cogs mr-2"></i>
                                               </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="<?= base_url() ?>projects/jobTasks?t=<?= base64_encode($row->id) ?>"  class="dropdown-item">
                                                    <i class="fa fa-tasks"></i> Tasks</a>

                                              <?php if ($permission->edit == 1 && $row->status == 1 && $poData->verified != 1) { ?>
                                                        <a href="<?php echo base_url() ?>ProjectManagment/reopenJob?t=<?php
                                                        echo
                                                        base64_encode($row->id);
                                                        ?>&p=<?= base64_encode($poData->id) ?>" class="dropdown-item" onclick="return confirm('Are you sure you want to Re-open this Job ?');">
                                                            <i class="fa fa-undo"></i> Re-open
                                                        </a>
                                                <?php } ?>
                                             <?php if ($permission->edit == 1 && $row->status == 0) { ?>
                                                        <a href="<?php echo base_url() ?>projectManagment/editJob?t=<?php
                                                        echo
                                                        base64_encode($row->id);
                                                        ?>&p=<?= base64_encode($row->project_id) ?>" class="dropdown-item">
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </a>
                                            <?php } ?>
                                              <?php if ($permission->delete == 1 && $row->status == 0) { ?>
                                                        <a href="<?php echo base_url() ?>projectManagment/deleteJob?t=<?php
                                                        echo
                                                        base64_encode($row->id);
                                                        ?>&p=<?= base64_encode($row->project_id) ?>" title="delete" 
                                                           class="dropdown-item" onclick="return confirm('Are you sure you want to delete this Project ?');">
                                                            <i class="fa fa-times text-danger text"></i> Delete
                                                        </a>
                                            <?php } ?>
                                              <?php if ($permission->add == 1 && $row->status == 0 ) { 
                                                  if($this->brand == 1){?>
                                                        <a href="<?php echo base_url() ?>projectManagment/addTaskVendorModule?t=<?=
                                                        base64_encode($row->id);
                                                        ?>" title="send" 
                                                           class="dropdown-item">
                                                            <i class="fa fa-envelope-o"></i> Assign To Vendor
                                                        </a>
    <!--                                                   <a href='#' data-row="<?=$row?>" title="send" class="dropdown-item VendorPortalBtn" data-toggle="modal" data-target="#VendorPortalModal_<?=$row->id?>">
                                                               <i class="fa fa-envelope-o"></i> Assign To Vendor
                                                              </a>-->
                                                  <?php }else{?>
    <!--                                                      <a href='#' title="send" class="dropdown-item VendorBtn" data-toggle="modal" data-target="#VendorModal_<?=$row->id?>">
                                                               <i class="fa fa-envelope-o"></i> Assign To Vendor
                                                              </a>-->
                                                <a href="<?=base_url()?>projectManagment/addTask?t=<?=base64_encode($row->id)?>" title="send" 
                                                           class="dropdown-item">
                                                            <i class="fa fa-envelope-o"></i> Assign To Vendor
                                                        </a>
                                                <?php }if($priceList->service == 1){?>
                                                        <a href="<?php echo base_url() ?>projectManagment/addTranslationTask?t=<?=
                                                        base64_encode($row->id);
                                                        ?>" title="send" 
                                                           class="dropdown-item">
                                                            <i class="fa fa-sort-alpha-asc"></i> Send Request To Translation
                                                        </a>
                                                 <?php }if($priceList->service == 23){?>
                                                        <a href="<?=base_url()?>projects/dtpRequest?t=<?=base64_encode($row->id)?>" title="send" 
                                                           class="dropdown-item">
                                                            <i class="fa fa-font"></i> Send Request To DTP
                                                        </a>
                                             <?php }?>
                                                        <a href="<?php echo base_url() ?>projectManagment/addLeTask?t=<?=
                                                        base64_encode($row->id);
                                                        ?>" title="send" 
                                                           class="dropdown-item">
                                                            <i class="fa fa-font"></i> Send Request To LE
                                                        </a>

                                            <?php } ?>
                                            </div>
                                            </td>

                                        </tr>
    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </section>        
        </form>
            
        <section class="panel" id="vendor_tasks">
            <header class="panel-heading">
               Vendor Tasks
            </header>
            <div id="vendorTasks" class="panel-body">
                <div class="adv-table editable-table " style="overflow-y: scroll;">
               
                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <th>Task Code</th>
                                <th>Task Subject</th>
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
                                <th>Vendor Attachment</th>
                                <th>Status</th>
                                <th>Closed Date</th>
                                <th>VPO Status</th>
                                <th>Has Error</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Re-open</th>                                
                                <th>View </th>
                                <th>Edit </th>
                                <th>Delete</th>
                                <th>Cancel Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks->result() as $task) {
                                ?>
                                <tr>
                                    <td><a href="<?= base_url() ?>projects/taskPage?t=<?= base64_encode($task->id) ?>"><?= $task->code ?></a></td>
                                    <td><?php echo $task->subject; ?></td>
                                    <td><?php echo $this->admin_model->getTaskType($task->task_type); ?></td>
                                    <td><?php echo $this->vendor_model->getVendorName($task->vendor); ?></td>
                                    <td><?php echo $task->count; ?></td>
                                    <td><?php echo $this->admin_model->getUnit($task->unit); ?></td>
                                    <td><?php echo $task->rate; ?></td>
                                    <td><?php echo $task->rate * $task->count; ?></td>
                                    <td><?php echo $this->admin_model->getCurrency($task->currency); ?></td>
                                    <td><?php echo $task->start_date; ?></td>
                                    <td><?php echo $task->delivery_date; ?></td>
                                    <td><?= $this->admin_model->getTimeZone($task->time_zone) ?></td>
                                    <td><?php if (strlen($task->file) > 1) { ?>
                                            <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/taskFile/",$task->file,$task->start_after_type) ?>" target="_blank">Click Here</a>
                                     <?php } else{
                                            if($task->start_after_id != null && $task->start_after_type == "Vendor"){?>
                                                <?= $this->projects_model->getTaskVendorNotes($task->start_after_id)?>
                                        <?php }} ?>
                                    </td>
                                    <td><?php if (strlen($task->vendor_attachment) > 1) { ?><a href="<?=$this->projects_model->getNexusLinkByBrand()?>/assets/uploads/jobTaskVendorFiles/<?= $task->vendor_attachment ?>" target="_blank">Click Here ..</a><?php } ?></td>
                                    <td>
                                        <?php echo $this->projects_model->getJobStatus($task->status); 
                                         if(!empty($task->start_after_id)){
                                            echo "<br/><span>Start After Task : ".$task->start_after_type."-".$task->start_after_id."<span>" ;
                                        }?>
                                        <?php if ($permission->view == 1 && $task->job_portal == 1 && $task->status == 5) { ?>
                                            <p class="text-center">   <a href="<?php echo base_url() ?>ProjectManagment/pmDirectConfirm?task_id=<?php
                                                echo
                                                base64_encode($task->id);
                                                ?>" class="btn btn-sm btn-default mt-2"onclick="return confirm('Are you sure you want to Confirm this Task ?');">
                                                    <i class="fa fa-check-circle  text-success text"></i> Confirm
                                                </a></p>
    <?php } ?>
                                    </td>
                                    <td><?php echo $task->closed_date; ?></td>
                                    <td><?= $this->accounting_model->getPOStatus($task->verified) ?></td>
                                    <td>
                                        <?php
                                        if ($task->verified == 2) {
                                            $errors = explode(",", $task->has_error);
                                            for ($i = 0; $i < count($errors); $i++) {
                                                if ($i > 0) {
                                                    echo " - ";
                                                }
                                                echo $this->accounting_model->getError($errors[$i]);
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $this->admin_model->getAdmin($task->created_by); ?></td>
                                    <td><?php echo $task->created_at; ?></td>                                                               
                                    <td>
                                        <?php if ($permission->edit == 1 && $task->status == 1 && $task->verified != 1 && $job_data->status == 0) { ?>
                                            <a href="<?php echo base_url() ?>projects/reopenTask?t=<?php
                                               echo
                                               base64_encode($task->id);
                                               ?>&p=<?= base64_encode($job_data->status) ?>" class="" onclick="return confirm('Are you sure you want to Re-open this Task ?');">
                                                <i class="fa fa-undo"></i> Re-open
                                            </a>
                                        <?php } ?>
                                    </td>                                    
                                    <td>
                                           <?php if ($permission->view == 1 && $task->job_portal == 1) { ?>
                                            <a href="<?php echo base_url() ?>ProjectManagment/viewTask?t=<?php
                                       echo
                                       base64_encode($task->id);
                                       ?>&j=<?= base64_encode($task->job_id) ?>" class="">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
    <?php if ($permission->edit == 1 && ( $task->status == 0 || $task->status == 4 || $task->status == 3)) { ?>
                                            <a href="<?php echo base_url() ?>ProjectManagment/editTask?t=<?php
                                            echo
                                            base64_encode($task->id);
                                            ?>&j=<?= base64_encode($task->job_id) ?>" class="">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
    <?php if ($permission->delete == 1 && $task->status != 1) { ?>
                                            <a href="<?php echo base_url() ?>ProjectManagment/deleteTask?t=<?php
                                            echo
                                            base64_encode($task->id);
                                            ?>&j=<?= base64_encode($task->job_id) ?>" title="delete" 
                                               class="" onclick="return confirm('Are you sure you want to delete this Task ?');">
                                                <i class="fa fa-times text-danger text"></i> Delete
                                            </a>
    <?php } ?>
                                    </td>								<td>
                                        <?php if ($permission->edit == 1 && $task->status != 1) { ?>
                                            <a href="<?php echo base_url() ?>ProjectManagment/cancelTask?t=<?php
                                    echo
                                    base64_encode($task->id);
                                            ?>&j=<?= base64_encode($task->job_id) ?>" title="Cancel" 
                                               class="" onclick="return confirm('Are you sure you want to Cancel this Task ?');">
                                                <i class="fa fa-times text-danger text"></i> Cancel
                                            </a>
                <?php } ?>
                                    </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
            
        <section class="panel" id="vendor_tasks_offers">
            
            <header class="panel-heading">
                <button id="button_filter2" onclick="showAndHide('vendorTasksOffers','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
               
               Vendor Offers List
            </header>
            <div id="vendorTasksOffers" class="panel-body">
                <div class="adv-table editable-table " style="overflow-y: scroll;">
               
                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>                                
                                <th>#</th>
                                <th>Task Subject</th>
                                <th>Task Type</th>                               
                                <th>Count</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Total Cost</th>
                                <th>Currency</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Time Zone</th>
                                <th>Task File</th>
                                <th>Status</th>                                
                                <th>Created By</th>
                                <th>Created At</th>                                
                                <th>View </th>                                
                                <th>Cancel Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks_offers->result() as $task) {
                                ?>
                                <tr>
                                    <td><?php echo $task->id; ?></td>
                                    <td><?php echo $task->subject; ?></td>
                                    <td><?php echo $this->admin_model->getTaskType($task->task_type); ?></td>
                                    <td><?php echo $task->count; ?></td>
                                    <td><?php echo $this->admin_model->getUnit($task->unit); ?></td>
                                    <td><?php echo $task->rate; ?></td>
                                    <td><?php echo $task->rate * $task->count; ?></td>
                                    <td><?php echo $this->admin_model->getCurrency($task->currency); ?></td>
                                    <td><?php echo $task->start_date; ?></td>
                                    <td><?php echo $task->delivery_date; ?></td>
                                    <td><?= $this->admin_model->getTimeZone($task->time_zone) ?></td>
                                    <td><?php if (strlen($task->file) > 1) { ?>
                                        <a href="<?= base_url() ?>assets/uploads/taskFile/<?= $task->file ?>" target="_blank">Click Here</a>
                                        <?php } ?>
                                    </td>
                                    <td> <?php echo $this->projects_model->getVendorOfferStatus($task->status); 
                                        if(!empty($task->start_after_id)){
                                            echo "<br/><span>Start After Task : ".$task->start_after_type."-".$task->start_after_id."<span>" ;
                                        }?>
                                    </td>
                                  
                                    <td><?php echo $this->admin_model->getAdmin($task->created_by); ?></td>
                                    <td><?php echo $task->created_at; ?></td>                                   
                                    <td>
                                           <?php if ($permission->view == 1 && $task->job_portal == 1) { ?>
                                            <a href="<?php echo base_url() ?>ProjectManagment/viewOffer?t=<?php
                                       echo
                                       base64_encode($task->id);
                                       ?>&j=<?= base64_encode($task->job_id) ?>" class="">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        <?php } ?>
                                    </td>                                								<td>
                                        <?php if ($permission->edit == 1 && $task->status == 4) { ?>
                                            <a href="<?php echo base_url() ?>ProjectManagment/cancelOffer?t=<?=
                                    base64_encode($task->id);
                                            ?>&j=<?= base64_encode($task->job_id) ?>" title="Cancel" 
                                               class="" onclick="return confirm('Are you sure you want to Cancel this Task ?');">
                                                <i class="fa fa-times text-danger text"></i> Cancel
                                            </a>
                                <?php } ?>
                                    </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="panel" id="translation_tasks">

            <header class="panel-heading">
                <button id="button_filter3" onclick="showAndHide('translationTasks','button_filter3');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
                Translation Tasks
            </header>
            <div id="translationTasks" class="panel-body">
                <div class="adv-table editable-table " style="overflow-y: scroll;">
                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <th>Task Code</th>
                                <th>Task Subject</th>
                                <th>Task Type</th>
                                <th>Count</th>
                                <th>TM</th>
                                <th>Net word count</th>
                                <th>Unit</th>
                                <th>Total Cost in $</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Task File</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Task</th>
                                <th>Edit </th>
                                <th>Cancel </th>                                   
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($translation_request)) {
                                foreach ($translation_request->result() as $row) {
                                    $dateArray = explode("-", $row->created_at);
                                    $year = $dateArray[0];
                                    $rateProduction = $this->db->get_where('production_team_cost', array('task_type' => $row->task_type, 'unit' => $row->unit, 'year' => $year, 'team' => 1))->row()->rate;
                                    $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 2);
                                    ?>
                                    <tr>
                                        <td>Translation-<?= $row->id ?></a></td>
                                        <td><?php echo $row->subject; ?></td>
                                        <td><?php echo $this->admin_model->getTaskType($row->task_type); ?></td>
                                        <td><?php echo $row->count; ?></td>
                                        <td><?php echo $row->tm; ?></td>
                                        <td><?php echo $row->count - $row->tm; ?></td>
                                        <td><?php echo $this->admin_model->getUnit($row->unit); ?></td>
                                        <td><?php echo number_format($rateTrnasfared * $row->count, 2); ?></td>
                                        <td><?php echo $row->start_date; ?></td>
                                        <td><?php echo $row->delivery_date; ?></td>
                                        <td><?php if (strlen($row->file) > 1) { ?>
                                               <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/translationRequest/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                           <?php } else{
                                                if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                                    <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                            <?php }} ?>
                                        </td>
                                        <td><?php echo $this->projects_model->getTranslationTaskStatus($row->status); 
                                        if(!empty($row->start_after_id)){
                                            echo "<br/><span>Start After Task : ".$row->start_after_type."-".$row->start_after_id."<span>" ;
                                        }?>
                                        </td>
                                        <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                        <td><?php echo $row->created_at; ?></td>
                                        <td>
                                            <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>projectManagment/translationTask?t=<?php echo
                                    base64_encode($row->id);
                                    ?>" class="">
                                                    <i class="fa fa-eye"></i> View Task
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                <a href="<?php echo base_url() ?>projectManagment/editTranslationTask?t=<?php echo
                                    base64_encode($row->id);
                                                ?>&j=<?= base64_encode($job) ?>" class="">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
    <?php } ?>
                                        </td>
                                        <td>
                                               <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                <a href="<?php echo base_url() ?>projectManagment/cancelTranslationRequest?t=<?php echo
                                       base64_encode($row->id);
                                       ?>" title="Cancel" 
                                                   class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
                                                    <i class="fa fa-times text-danger text"></i> Cancel
                                                </a>
                                            <?php } ?>
                                        </td>                                           
                                    </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
        <section class="panel"  id="dtp_tasks">
            <header class="panel-heading">
                    <button id="button_filter2" onclick="showAndHide('dtpTasks','button_filter4');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
                    DTP Tasks
            </header>
            <div id="dtpTasks" class="panel-body">
                <div class="adv-table editable-table " style="overflow-y: scroll;">
                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
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
                                <th>Total Cost in $</th>
                                <th>File Attachment</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Task</th>
                                <th>Edit</th>
                                <th>Cancel </th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($dtp_request)) {
                                foreach ($dtp_request->result() as $row) {
                                    $dateArray = explode("-", $row->created_at);
                                    $year = $dateArray[0];
                                    $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $row->unit, 'year' => $year, 'brand' => $this->brand, 'team' => 3))->row()->rate;
                                    $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 2);
                                    ?>
                                    <tr>
                                        <td>DTP-<?= $row->id ?></td>
                                        <td><?= $row->task_name ?></td>
                                        <td><?= $this->admin_model->getDTPTaskType($row->task_type) ?></td>
                                        <td><?= $this->admin_model->getUnit($row->unit) ?></td>
                                        <td><?= $row->volume ?></td>
                                        <td><?= $this->admin_model->getDTPDirection($row->source_direction) ?></td>
                                        <td><?= $this->admin_model->getDTPDirection($row->target_direction) ?></td>
                                        <td><?= $this->admin_model->getDTPApplication($row->source_application) ?></td>
                                        <td><?= $this->admin_model->getDTPApplication($row->target_application) ?></td>
                                        <td><?= $this->admin_model->getDTPApplication($row->translation_in) ?></td>
                                        <td><?= $row->rate ?></td>
                                        <td><?php echo $rateTrnasfared * $row->volume; ?></td>
                                        <td><?php if (strlen($row->file) > 1) { ?>
                                                <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/dtpRequest/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                            <?php } else{
                                                if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                                    <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                            <?php }} ?>
                                        </td>
                                        <td><?= $row->start_date ?></td>
                                        <td><?= $row->delivery_date ?></td>
                                        <td><?php echo $this->projects_model->getDTPTaskStatus($row->status) ;
                                                 if(!empty($row->start_after_id)){
                                            echo "<br/><span>Start After Task : ".$row->start_after_type."-".$row->start_after_id."<span>" ;
                                        }?>
                                        </td>
                                        <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>
                                        <td><?= $row->created_at ?></td>
                                        <td>
                                            <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>projects/dTPTask?t=<?php echo
                                    base64_encode($row->id);
                                                ?>&j=<?= base64_encode($job) ?>" class="">
                                                    <i class="fa fa-eye"></i> View Task
                                                </a>
        <?php } ?>
                                        </td>
                                        <td>
                                               <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                <a href="<?php echo base_url() ?>projects/editDtpTask?t=<?php echo
                                       base64_encode($row->id);
                                       ?>&j=<?= base64_encode($job) ?>" class="">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                               <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                <a href="<?php echo base_url() ?>projects/cancelDTPRequest?t=<?php echo
                                       base64_encode($row->id);
                                       ?>&j=<?= base64_encode($job) ?>" title="Cancel" 
                                                   class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
                                                    <i class="fa fa-times text-danger text"></i> Cancel
                                                </a>
                                            <?php } ?>
                                        </td>
                                     
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>	
            
        <section class="panel" id="le_tasks">

            <header class="panel-heading">
                <button id="button_filter1" onclick="showAndHide('leTasks','button_filter1');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
                LE Tasks
            </header>

            <div id="leTasks" class="panel-body">
                <div class="adv-table editable-table " style="overflow-y: scroll;">

                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <th>Task Code</th>
                                <th>Task Subject</th>
                                <th>Task Type</th>
                                <th>Subject Matter</th>
                                <th>Total Cost in $</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Task File</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Task</th>
                                <th>Edit </th>
                                <th>Cancel </th>                                    
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($le_request)) {
                                foreach ($le_request->result() as $row) {
                                    $dateArray = explode("-", $row->created_at);
                                    $year = $dateArray[0];
                                    $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $row->unit, 'year' => $year, 'team' => 2))->row()->rate;
                                    $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 2);
                                    ?>
                                    <tr>
                                        <td>LE-<?= $row->id ?></td>
                                        <td><?php echo $row->subject; ?></td>
                                        <td><?php echo $this->admin_model->getLETaskType($row->task_type); ?></td>
                                        <td><?php echo $this->admin_model->getLESubject($row->subject_matter); ?></td>
                                        <td><?php echo $rateTrnasfared * $row->volume; ?></td>
                                        <td><?php echo $row->start_date; ?></td>
                                        <td><?php echo $row->delivery_date; ?></td>
                                        <td><?php if (strlen($row->file) > 1) { ?>
                                                <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/leRequest/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                            <?php } else{
                                                if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                                    <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                            <?php }} ?>
                                        </td>
                                        <td><?php echo $this->projects_model->getLETaskStatus($row->status); 
                                          if(!empty($row->start_after_id)){
                                            echo "<br/><span>Start After Task : ".$row->start_after_type."-".$row->start_after_id."<span>" ;
                                        }?>
                                        </td>
                                        <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                        <td><?php echo $row->created_at; ?></td>
                                        <td>
                                            <?php if ($permission->edit == 1) { ?>
                                                <a href="<?php echo base_url() ?>projects/leTask?t=<?php echo
                                    base64_encode($row->id);
                                                ?>" class="">
                                                    <i class="fa fa-eye"></i> View Task
                                                </a>
    <?php } ?>
                                        </td>
                                        <td>
                                               <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                <a href="<?php echo base_url() ?>projects/editLeTask?t=<?php echo
                                       base64_encode($row->id);
                                       ?>&j=<?= base64_encode($job) ?>" class="">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                               <?php if ($permission->edit == 1 && ($row->status == 1 || $row->status == 5 || $row->status == 6)) { ?>
                                                <a href="<?php echo base_url() ?>projects/cancelLERequest?t=<?php echo
                                       base64_encode($row->id);
                                       ?>&j=<?= base64_encode($job) ?>" title="Cancel" 
                                                   class="" onclick="return confirm('Are you sure you want to cancel this Task ?');">
                                                    <i class="fa fa-times text-danger text"></i> Cancel
                                                </a>
                                            <?php } ?>
                                        </td>

                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
    </div>
    <div class="col-sm-2"> 
        <section class="panel">
               <p style="border: 1px #185898 solid;padding: 10px;border-left: 10px #185898 solid;font-weight: bold"> Project Status : <?=$this->projects_model->getNewProjectStatus($project_data->status,$project_data->id)?></p>
          </section>  
          <section class="panel">               	
            <header class="panel-heading">
                  Project Data 
            </header>  
              <div class="panel-body">
                   <h5 class="text-dark font-weight-bold mb-2">Project Code</h5>
                   <p class="ml-2"><?= $project_data->code ?></p>
                   
                    <h5 class="text-dark font-weight-bold">Project Name</h5>
                    <p class="ml-2"><?= $project_data->name ?></p>
                    
                    <h5 class="text-dark font-weight-bold mb-2">Client</h5>
                    <p class="ml-2"><?= $this->customer_model->getCustomer($project_data->customer); ?></p>
                     
                    <h5 class="text-dark font-weight-bold mb-2">Product Line</h5>
                    <p class="ml-2"><?= $this->customer_model->getProductLine($project_data->product_line); ?></p>
                      <?php if($this->brand == 1){?>           
                    <h5 class="text-dark font-weight-bold mb-2">TTG Branch Name</h5>
                    <p class="ml-2"><?=$this->projects_model->getTTGBranchName($project_data->branch_name)?></p>
                      <?php  }?>         
                    <h5 class="text-dark font-weight-bold mb-2">Created By</h5>
                    <p class="ml-2"><?= $this->admin_model->getAdmin($project_data->created_by); ?></p>            
                    
                    <h5 class="text-dark font-weight-bold mb-2">Created At</h5>
                    <p class="ml-2"><?= $project_data->created_at; ?></p>                              
                          
              </div>
          </section>            
         <?php if ($project_data->status == 0) { ?>
        <section class="panel">
                 <a class="btn btn-primary center-block" href="<?php echo base_url() ?>vendor/vmPmTicket?t=<?php echo base64_encode($project_data->id); ?>" title="Add Tickets" style="color:#fff">View Tickets</a>
        </section> 
     <?php } ?>
    </div>
</div>
//<?php
//foreach ($job->result() as $r) {
//    $price = $this->projects_model->getJobPriceListData($r->price_list);
//    if ($permission->add == 1 && $r->status == 0) {
//        $dataRow['row'] = $r;
//        $dataRow['priceList'] = $price;
//        $this->view('ProjectManagment/jobModal.php', $dataRow);
//    }
//}
//?>
