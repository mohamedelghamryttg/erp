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
                <th>Task Code</th>
                  <th>Assigned Translator</th>
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
                 <th>Taken Time (Hrs)</th>
                 <th>Taken Time (Mins)</th>
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
                <td><?=$request->created_at?></td>
                <td>Translation-<?=$request->id?>-<?=$row->id?></td>
                <td><?php echo $this->admin_model->getAdmin($row->translator) ;?></td>
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
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
</body>
</html>