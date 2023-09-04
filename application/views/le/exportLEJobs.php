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
                <th>Type</th>
                <th>Job Code</th>
                <th>Assigned LE</th>
                <th>Task Type</th>
                <th>Subject Matter</th>
                <th>Linguist Format</th>
                <th>Deliverable Format</th>
                 <th>Unit</th>
                <th>Volume</th>
                 <th>Taken Time (Hrs)</th>
                 <th>Taken Time (Mins)</th>
                 <th>Status</th>
                 <th>Job Log</th>
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
                <td><?=$request->created_at?></td>
                <td><?=$this->admin_model->getLETaskType($row->task_type)?></td>
                <td>LE-<?=$row->request_id?>-<?=$row->id?></td>
                <td><?php echo $this->admin_model->getAdmin($row->le) ;?></td>
                <td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
                <td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
                 <?php if(is_numeric($row->linguist) && is_numeric($row->deliverable)){ ?>
                <td><?php echo $this->admin_model->getLeFormat($row->linguist);?></td>
                <td><abbr title="<?=$row->deliverable?>"><?php echo character_limiter($this->admin_model->getLeFormat($row->deliverable),10);?></abbr></td>
              <?php }else{ ?>
                <td><?=$row->linguist?></td>
                <td><abbr title="<?=$row->deliverable?>"><?=character_limiter($row->deliverable,10)?></abbr></td>
              <?php } ?>  
                <td><?php echo $this->admin_model->getUnit($row->unit);?></td>
                <td><?=$row->volume?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td>
                  <table>
                    <thead>
                      <tr>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($log as $history) { ?>
                      <tr>
                        <td><?=$this->projects_model->getTranslationJobStatus($history->status)?></td>
                        <td><?=$history->created_at?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
</body>
</html>