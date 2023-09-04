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
        <tr>
            <th>Task Code</th>
            <th>Task Type</th>
           <th>Vendor</th>
           <th>Source Language</th>
           <th>Target Language</th>
           <th>Count</th>
           <th>Unit</th>
           <th>Rate</th>
           <th>Total Cost</th>
           <th>Currency</th>
           <th>Start Date</th>
           <th>Delivery Date</th>
           <th>Status</th>
           <th>Closed Date</th>
            <th>CPO Closed Date</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Invoice Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($task->result() as $row) { 
          $priceList = $this->projects_model->getJobPriceListData($row->price_list);
  			$project = explode("-", $row->code);
  			$projectData = $this->projects_model->getProjectData($project[1]);
            ?>
        <tr>
          <td><?=$row->code?></td>
          <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
          <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
          <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
          <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
          <td><?php echo $row->count ;?></td>
          <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
          <td><?php echo $row->rate ;?></td>
          <td><?php echo $row->rate * $row->count;?></td>
          <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
          <td><?php echo $row->start_date ;?></td>
          <td><?php echo $row->delivery_date ;?></td>
          <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
          <td><?php echo $row->closed_date ;?></td>
          <td><?=$projectData->closed_date?></td>
          <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
          <td><?php echo $row->created_at ;?></td>
          <td><?php echo $row->invoice_date ;?></td>
          <td> <?php if($row->job_portal == 1){?>
              Nexus System
          <?php }?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
</table>
</body>
</html>