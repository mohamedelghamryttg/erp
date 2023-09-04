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
<table class="table table-striped table-hover table-bordered" id=" " style="overflow:scroll;">
            <thead>
              <tr>
                <th>ID</th>
                <th>Job Code</th>
                <th>Job Name</th>
                <th>Status</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Source</th>
                <th>Target</th>
                <th>Volume</th>
                <th>Rate</th>      
                <th>Currency</th>
                <th>Created By</th>
                <th>Created At</th>
                                
              </tr>
            </thead>
            
            <tbody>
            <?php
              foreach($jobs->result() as $row)
                {
            ?>
                  <tr class="">
                    <td><?= $row->id ?></td>
                    <td><?php echo $row->code ;?></td>
                    <td><?php echo $row->name ;?></td>
                    <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                    <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                    <td><?php echo $this->admin_model->getServices($row->service);?></td>
                    <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
                    <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
                    <?php if($row->type == 1){ ?>
                    <td><?php echo $row->volume ;?></td>
                    <?php }elseif ($row->type == 2) { ?>
                    <td><?php echo $total_revenue / $row->rate ;?></td>
                    <?php } ?>
                    <td><?php echo $row->rate ;?></td>
                    <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
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