<!DOCTYPE ><html dir=ltr>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
  background-color: #EEEEEE;
  text-align: center;
}
.clr1 {
background-color: #FFFFCC;
  text-align: center;
}
</style>
</head>
<body>


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
                 <th colspan="20" style="text-align: center;">In House Team Report By DTP</th>
              </tr>
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
                <th colspan="20" style="text-align: center;"> </th>
              </tr>
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
                <th colspan="17" style="text-align: center;">In House Team Report By Translation</th>
              </tr>
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
    </section>
  </div>
</div>
<?php } ?>


</body>
</html>