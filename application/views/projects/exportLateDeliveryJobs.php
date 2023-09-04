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
      <th>PM Name</th>
      <th>Job Code</th>
      <th>Job Name</th>
     <th>Client Name</th>
      <th>Start Date</th>
      <th>Delivery Date</th>
      <th>Created At</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($job->result() as $row) { 
    $projectData = $this->db->get_where('project',array('id'=>$row->project_id))->row();
  ?>
    <tr>
      <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
      <td><a target="_blank" href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($row->project_id)?>"><?=$row->code?></a></td>
      <td><?=$row->name?></td>
      <td><?php echo $this->customer_model->getCustomer($projectData->customer);?></td>
      <td><?php echo $row->start_date ;?></td>
      <td><?php echo $row->delivery_date ;?></td>
      <td><?php echo $row->created_at ;?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</body>
</html>