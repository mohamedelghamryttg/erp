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
                  <th>Task Code</th>
                	<th>Task Subject</th>
                  <th>Task Type</th>
              <th>PO Number</th>
                  <th>Vendor Name</th>
                  <th>Vendor Email</th>
                  <th>Source</th>
                  <th>Target</th>
                  <th>Count</th>
                  <th>Unit</th>
                  <th>Rate</th>
                  <th>Total Cost</th>
                  <th>Currency</th>
                  <th>Start Date</th>
                  <th>Delivery Date</th>
                  <th>Task File</th>
                  <th>Status</th>
                  <th>Closed Date</th>
                  <th>Created By</th>
                  <th>Created At</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($task->result() as $row) { 
			$job_data = $this->db->get_where('job',array('id'=>$row->job_id))->row();
			$poData = $this->projects_model->getJobPoData($job_data->po);
            ?>
              <tr>
                <td><a href="<?=base_url()?>projects/taskPage?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
                <td><?php echo $row->subject ;?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
              	<td><?php if(isset($poData)){ echo $poData->number; }?></td>
              	<td><?php echo $row->name ;?></td>
              	<td><?php echo $row->email ;?></td>
                <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $row->rate * $row->count;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/taskFile/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>

          </body>
                    </html>