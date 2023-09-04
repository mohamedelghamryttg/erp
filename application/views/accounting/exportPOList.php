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
            <th>Client Name</th>
            <th>PO Number</th>
            <th>Job Code</th>
            <th>Job Name</th>
            <th>Project Name</th>
            <th>Service</th>
            <th>Source</th>
            <th>Target</th>
            <th>Volume</th>
            <th>Rate</th>
            <th>Currency</th>
            <th>Total Revenue</th>
            <th>Closed Date</th>
            <th>Created By</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cpo->result() as $row) { 
          $job = $this->db->get_where('job',array('po'=>$row->id))->result();
          foreach ($job as $job) { 
            $priceList = $this->projects_model->getJobPriceListData($job->price_list);
            $jobTotal = $this->sales_model->calculateRevenueJob($job->id,$job->type,$job->volume,$priceList->id);
        ?>
          <tr>
            <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
            <td><?php echo $row->number ;?></td>
            <td><?=$job->code?></td>
            <td><?=$job->name?></td>
            <td><?=$this->projects_model->getProjectData($job->project_id)->name?></td>   
            <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
            <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
            <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
            <td><?php echo $job->volume ;?></td>
            <td><?php echo $priceList->rate ;?></td>
            <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
            <td><?php echo $jobTotal; ?></td>
            <td><?php echo $job->closed_date ;?></td>
            <td><?php echo $this->admin_model->getAdmin($job->created_by) ;?></td>
          </tr>
        <?php }} ?>
    </tbody>
</table>
</body>
</html>