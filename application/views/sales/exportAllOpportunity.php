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
                <th>Opportunity Number</th>
                <th>Project Name</th>
                <th>Project Status</th>
                <th>Customer</th>
                <th>Brand</th>
                <th>Region</th>
                <th>Country</th>
                <th>Status</th>
                <th>Assign</th>
                <th>Tickets</th>
                <th>Created By</th>
                <th>Created At</th>
              </tr>
              </tr>
            </thead>
            
            <tbody>
            <?php
              foreach($opportunity->result() as $row)
                {
                  $leadData = $this->customer_model->getLeadDataByCustomer($row->lead);
                                  $customerData = $this->db->get_where('customer',array('id' => $row->customer))->row();
            ?>
                  <tr class="">
                    <td><?php echo $row->id ;?></td> 
                    <td><a href="<?=base_url()?>sales/viewOpportunityJob?t=<?=base64_encode($row->id)?>"><?php echo $row->project_name ;?></a></td>
                    <td><?php echo $this->sales_model->getProjectStatus($row->project_status) ;?></td>
                    <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                    <td><?php echo $this->admin_model->getBrand($customerData->brand);?></td>
                    <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                    <td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
                                        <td>
                                          <?php 
                                          if($row->saved == 0 && $row->assigned == 1){
                                            echo '<span class="badge badge-danger p-5" style="background-color: #07199b">Still Not Saved</span>';
                                          }else if($row->saved == 1){
                                            echo '<span class="badge badge-danger p-5" style="background-color: #07b817">Saved As A project</span>';
                                          }elseif ($row->saved == 2) {
                                            echo '<span class="badge badge-danger p-5" style="background-color: #fb0404">Opportunity Rejected</span>';
                                          }
                                          ?>
                                        </td>
                    <td>
                                          <?php if($row->project_status == 1){ ?>
                                          <?php if($row->assigned == 0 || $row->saved == 2){ ?>
                                            <a class="btn btn-primary" onclick="return confirm('Are you sure you want to Assign this Opportunity to PM ?');" href="<?php echo base_url()?>sales/assignOpportunity?t=<?php echo base64_encode($row->id); ?>&lead=<?=base64_encode($row->lead)?>" title="Assign" style="color:#fff">
                                                Assign
                                                </a>
                                            <?php }else{ ?>
                                              Opportunity Assigned 
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                          <?php if($row->assigned == 0 || $row->saved == 2){ ?>
                                            <a class="btn btn-primary" href="<?php echo base_url()?>vendor/vmTicket?t=<?php echo base64_encode($row->id); ?>" title="Add Tickets" style="color:#fff">
                                                Add Tickets
                                                </a>
                                            <?php } ?>
                                        </td>
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