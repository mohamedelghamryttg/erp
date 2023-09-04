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
     <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <tr>
                 <th>ID</th>
                 <th>PM</th>
                <th>Customer</th>
                 <th>Region</th>
                 <th>Project Name</th>
                 <th>Product Line</th>
                 <th>Lost Reasons</th>
                 <th>Service</th>
                 <th>Source</th>
                 <th>Target</th>
                 <th>Task Type</th>
                 <th>Currency</th>
                 <th>Total Revenue</th>
                 <th>Created By</th>
                 <th>Created At</th>
                               
              </tr>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach($lost_opportunity->result() as $row)
                {
                  $leadData = $this->customer_model->getLeadDataByCustomer($row->lead);
                                  $customerData = $this->db->get_where('customer',array('id' => $row->customer))->row();
            ?>
                <tr class="">
                  <td><?php echo $row->id ;?></td> 
                  <td><?php echo $this->admin_model->getAdmin($row->pm) ;?></td>
                  <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                                    <th><?php echo $this->admin_model->getRegion($row->region); ?></th>

                                    <td><?php echo $row->project_name ;?></td> 
                                     <td><?php echo $this->sales_model->getProductLines($row->product_line );?></td>
                                    <td><?php echo $this->sales_model->getLostReasons($row->lost_reasons)?></td>
                                    <td><?php echo $this->admin_model->getServices($row->service);?></td>
                    <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
                    <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
                    <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                                    <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                                    <td><?php echo $row->total_revenue;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
                   
                  </tr>
            <?php
                }
            ?>    
            </tbody>
            
          </table>
</body>
</html>