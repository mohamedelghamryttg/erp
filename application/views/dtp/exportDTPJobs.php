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
<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Subject</th>
                <th>PM</th>
                <th>Sent Date</th>
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
                 <th>Taken Time (Hrs)</th>
                 <th>Taken Time (Mins)</th>
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
                <td><?=$request->created_at?></td>
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
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
</body>
</html>