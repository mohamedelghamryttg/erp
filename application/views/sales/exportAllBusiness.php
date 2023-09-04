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
                <th>Number #</th>
                <th>Customer</th>
                <th>Region</th>
                <th>Country</th>
                <th>Contact Name</th>
                <th>Contact Method</th>
                <th>Type</th>
                <th>SLA Reason</th>
                <th>SLA Attachment</th>
                <th>SIP Issue</th>
                <th>SIP Reason</th>
                <th>SIP Improvement Owner</th>
                <th>SIP Proposed Solution</th>
                <th>SIP Due Date For Final Feedback</th>
                <th>SIP Status Of Resolution</th>
                                <th>Created By</th>
                                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
              </tr>
            </thead>
            
            <tbody>
            <?php
              foreach($business->result() as $row)
                {
                  $leadData = $this->customer_model->getLeadDataByCustomer($row->lead);
                  $contactData = $this->db->get_where('customer_contacts',array('id'=>$row->contact_id))->row();
            ?>
                  <tr class="">
                    <td><?php echo $row->id ;?></td> 
                    <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                    <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                    <td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
                    <td><?=$contactData->name?></td>
                    <td><?=$this->sales_model->getContactMethod($row->contact_method)?></td>
                    <td><?php if($row->type == 1){echo "SLA";}elseif ($row->type == 2) {echo "SIP";}?></td>
                    <td><?=$this->sales_model->getSlaReason($row->sla_reason)?></td>
                    <td><?php if(strlen($row->sla_attachment) > 0){ echo "<a href=".base_url()."assets/uploads/slaAttachment/".$row->sla_attachment.">Click Me</a>"; }?></td>
                    <td><?=$this->sales_model->getSipIssue($row->sip_issue)?></td>
                    <td><?php echo $row->sip_reason ;?></td>
                    <td><?=$this->admin_model->getUsersByMail($row->sip_improvement_owner)?></td>
                    <td><?php echo $row->sip_proposed_solution ;?></td>
                    <td><?php echo $row->sip_due_date ;?></td>
                    <td><?php if($row->sip_status_resolution == 1){echo "Opened";}elseif ($row->sip_status_resolution == 2) {echo "Closed";}?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                      <a href="<?php echo base_url()?>sales/editBusinessReviews?t=<?php echo 
                      base64_encode($row->id) ;?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <!-- <a href="<?php echo base_url()?>sales/deleteOpportunity?t=<?php echo 
                      base64_encode($row->id) ;?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Opportunity ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a> -->
                      <?php } ?>
                    </td>
                  </tr>
            <?php
                }
            ?>    
            </tbody>
          </table>
</body>
</html>