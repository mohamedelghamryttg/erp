<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Date Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="report" method="post" enctype="multipart/form-data">
        <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="">
            </div>

        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="role date">Report Name</label>
            <div class="col-lg-3">
              <select name="report" class="form-control m-b" onchange="getInHouseTeam()" id="team" required />
                       <option disabled="disabled" selected="selected" value="">-- Select Report --</option>
                       <option value="1">By DTP</option>
                       <option value="2">By LE</option>
                       <option value="3">By Translators</option>
              </select>
            </div>
            <label class="col-lg-2 control-label" for="role name">In House Team</label>

               <div class="col-lg-3">
                  <select name="inHouseTeam" class="form-control m-b" id="inHouseTeam" />
                           <option value="" selected="selected" disabled="">-- Select Member --</option>
                  </select>
              </div>
        </div>


        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" onclick="var e2 = document.getElementById('report'); e2.action='<?=base_url()?>report/inHouseTeam'; e2.submit();" name="search" type="submit"> Search</button>
                <button class="btn btn-success" onclick="var e2 = document.getElementById('report'); e2.action='<?=base_url()?>report/exportInHouseTeam'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
            </div>
        </div>   
        </form>
      </div>
    </section>
  </div>
</div>
<!-- By DTP -->
<?php if($report == 1){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        In House Report By DTP
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                 <th colspan="20" style="text-align: center;">In House Team Report By DTP From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
             <tr>
                <th>Subject</th>
                <th>PM</th>
                <th>Assigned DTP</th>
                <th>Taken Time (Hrs)</th>
                <th>Taken Time (Mins)</th>
                <th>Sent Date</th>
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
                 <th>Status</th>
                  <th>Created By</th>
                  <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { 
                  $request = $this->db->get_where('dtp_request',array('id' => $row->request_id))->row();
                  $jobData = $this->projects_model->getJobData($request->job_id);
                  $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                  if($row->status == 2 || $row->status == 4){
                    $takenTime = $this->projects_model->getDTPJobTime($row->id);
                  }
              ?>
              <tr class="">
                <td><?=$request->task_name?></td>
                <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                <td><?php echo $this->admin_model->getAdmin($row->dtp) ;?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?=$request->created_at?></td>
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
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>

<!-- End DTP Table -->
<!-- By LE -->
<?php if($report == 2){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        In House Team Report By LE
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="20" style="text-align: center;"> In House Team Report By LE From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Subject</th>
                <th>PM</th>
                <th>Assigned LE</th>
                <th>Taken Time (Hrs)</th>
                <th>Taken Time (Mins)</th>
                <th>Sent Date</th>
                <th>Type</th>
                <th>Job Code</th>
                <th>Task Type</th>
                <th>Subject Matter</th>
                <th>Linguist Format</th>
                <th>Deliverable Format</th>
                 <th>Status</th>
                 <th>Created By</th>
                 <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { 
                  $request = $this->db->get_where('le_request',array('id' => $row->request_id))->row();
                  if($row->status == 2 || $row->status == 4){
                    $takenTime = $this->projects_model->getLEJobTime($row->id);
                    $log = $this->db->get_where('le_request_history',array('task'=>$row->id))->result();
                  }
              ?>
              <tr class="">
                <td><?=$request->subject?></td>
                <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                <td><?php echo $this->admin_model->getAdmin($row->le) ;?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?=$request->created_at?></td>
                <td><?=$this->admin_model->getLETaskType($row->task_type)?></td>
                <td>LE-<?=$row->request_id?>-<?=$row->id?></td>
                <td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
                <td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
                <td><?=$row->linguist?></td>
                <td><?=$row->deliverable?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End LE Table -->

<!-- By Translation -->
<?php if($report == 3){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Operational Report By Customer
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="17" style="text-align: center;">In House Team Report By Translation From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
               <tr>
                <th>Subject</th>
                <th>PM</th>
                <th>Assigned Translator</th>
                <th>Taken Time (Hrs)</th>
                <th>Taken Time (Mins)</th>
                <th>Sent Date</th>
                <th>Task Code</th>
                 <th>Task Type</th>
                 <th>Count</th>
                 <th>Updated Count</th>
                 <th>Unit</th>
                 <th>Start Date</th>
                 <th>Delivery Date</th>
                 <th>Status</th>
                  <th>Created By</th>
                  <th>Created At</th>
                 <th>Closed Date</th>

              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { 
                  $request = $this->db->get_where('translation_request',array('id' => $row->request_id))->row();
                  $jobData = $this->projects_model->getJobData($request->job_id);
                  $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                  if($row->status == 2 || $row->status == 4){
                    $takenTime = $this->projects_model->getTranslationJobTime($row->id);
                  }
              ?>
              <tr class="">
                <td><?=$request->subject?></td>
                <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                <td><?php echo $this->admin_model->getAdmin($row->translator) ;?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?=$request->created_at?></td>
                <td>Translation-<?=$request->id?>-<?=$row->id?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php if($row->status == 4){ echo $row->updated_count ;} ?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td><?php echo $row->closed_date ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End Customer Table -->