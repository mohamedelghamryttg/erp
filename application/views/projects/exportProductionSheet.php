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
<table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
              <tr style="background-color: #900C3F;color: white;">
                <th>Project Code</th>
                <th>PM Name</th>
                <th>Client</th>
                <th>Region</th>
                <th>Product Line</th>
                <th>Created At</th>
                <th>Job Code</th>
                <th>Job Name</th>
                <th>Service</th>
                <th>Source</th>
                <th>Target</th>
                <th>Volume</th>
                <th>Rate</th>
                <th>Currency</th>
                <th>Unit</th>
                <th>Total Revenue</th>
                <th>Total Revenue $ USD</th>
                <th>Status</th>
                <th>PO Number</th>
                <th>PO Status</th>
                <th>Has Error</th>
                <th>Invoiced</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                <th>Closed Date</th>
                <th>Created At</th>
                <th>
                  <table>
                    <thead>
                      <tr>
                        <th colspan="17">Vendor Tasks</th>
                      </tr>
                      <tr>
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
                         <th>Status</th>
                         <th>Closed Date</th>
                         <th>VPO Status</th>
                         <th>Has Error</th>
                         <th>Created By</th>
                         <th>Created At</th>
                      </tr>
                    </thead>
                  </table>
                </th>
                <th>
                  <table>
                    <thead>
                      <tr>
                        <th colspan="12">Translation Tasks</th>
                      </tr>
                      <tr>
                        <th>Task Code</th>
                        <th>Task Subject</th>
                        <th>Task Type</th>
                       <th>Count</th>
                       <th>TM</th>
                       <th>Net word count</th>
                       <th>Unit</th>
                       <th>Start Date</th>
                       <th>Delivery Date</th>
                       <th>Task File</th>
                       <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                      </tr>
                    </thead>
                  </table>
                </th>
                <th>
                  <table>
                    <thead>
                      <tr>
                        <th colspan="17">DTP Tasks</th>
                      </tr>
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
                  </table>
                </th>
                <th>
                  <table>
                    <thead>
                      <tr>
                        <th colspan="10">LE Tasks</th>
                      </tr>
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
                      </tr>
                    </thead>
                  </table>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($project)){
              foreach ($project->result() as $row) { 
                  $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                  $jobTotal = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
                  $poData = $this->projects_model->getJobPoData($row->po);
                  $leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
            ?>
              <tr>
                <td><?=$row->p_code?></td>
                <td><?php echo $this->admin_model->getAdmin($row->p_createdBy) ;?></td>
                <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                <td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
                <td><?php echo $row->p_createdAt ;?></td>
               <!-- jobs -->
               <td><?=$row->code?></td>
                <td><?=$row->name?></td>
                <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                <?php if($row->type == 1){ ?>
                <td><?php echo $row->volume ;?></td>
                <?php }elseif ($row->type == 2) { ?>
                <td><?php echo $jobTotal / $priceList->rate ;?></td>
                <?php } ?>
                <td><?php echo $priceList->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                <td><?php echo $this->admin_model->getUnit($priceList->unit) ;?></td>
                <td><?php echo $jobTotal; ?></td>
                <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$row->created_at,$jobTotal),2);?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if(isset($poData)){ echo $poData->number; }?></td>
                <td><?php if(isset($poData)){$this->accounting_model->getPOStatus($poData->verified); } ?></td>
                <td>
                <?php if(isset($poData)){
                    if($poData->verified == 2){
                      $errors = explode(",", $poData->has_error);
                      for ($i=0; $i < count($errors); $i++) { 
                        if($i > 0){echo " - ";}
                        echo $this->accounting_model->getError($errors[$i]);
                       }
                     }} ?>
                </td>
                <td><?php if($poData->invoiced == 1){echo "Yes";}else{echo "No";}?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $row->created_at ;?></td>
              <!-- Tasks -->
              <td>
                <table>
                  <tbody>
                <?php 
                  $task = $this->db->query(" SELECT * FROM `job_task` WHERE job_id = '$row->id' ")->result();
                  $y = 1;
                foreach ($task as $task) { ?>
                <tr>
                  <td><?=$task->code?></td>
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
                  <td><?php echo $task->created_at ;?>
                </tr>
              <?php $y++;} ?>
              </tbody>
              </table>
              </td>
              <!-- End Vendor Tasks -->
              <!-- Translation Tasks -->
              <td>
                <table>
                  <tbody>
                <?php 
                  $translation_request = $this->db->get_where('translation_request',array('job_id'=>$row->id));
                foreach ($translation_request->result() as $row) { ?>
                <tr>
                  <td>Translation-<?=$row->id?></a></td>
                  <td><?php echo $row->subject ;?></td>
                  <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                  <td><?php echo $row->count ;?></td>
                  <td><?php echo $row->tm ;?></td>
                  <td><?php echo $row->count - $row->tm ;?></td>
                  <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                  <td><?php echo $row->start_date ;?></td>
                  <td><?php echo $row->delivery_date ;?></td>
                  <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                  <td><?php echo $this->projects_model->getTranslationTaskStatus($row->status) ;?></td>
                  <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                  <td><?php echo $row->created_at ;?></td>
                </tr>
              <?php $y++;} ?>
              </tbody>
              </table>
              </td>
              <!-- End Translation Tasks -->
              <!-- DTP Tasks -->
              <td>
                <table>
                  <tbody>
                <?php 
                  $dtp_request = $this->db->get_where('dtp_request',array('job_id'=>$row->id));
                foreach ($dtp_request->result() as $row) { ?>
                <tr>
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
              <?php $y++;} ?>
              </tbody>
              </table>
              </td>
              <!-- End DTP Tasks -->
              <!-- LE Tasks -->
              <td>
                <table>
                  <tbody>
                <?php 
                  $le_request = $this->db->get_where('le_request',array('job_id'=>$row->id));;
                foreach ($le_request->result() as $row) { ?>
                <tr>
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
                </tr>
              <?php $y++;} ?>
              </tbody>
              </table>
              </td>
              <!-- End LE Tasks -->
              </tr>
            <?php }} ?>
    </tbody>
</table>
</body>
</html>