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
<table class="table table-striped table-hover table-bordered" style="overflow:scroll;" style="diplay:block;">
<thead>
    <tr>
      <th>Brand</th>
         <th>Region</th>
        <th>Customer</th>
         <th>Country</th>
         <th>Customer Type</th>
         <th>Rolled In</th>
         <th>Contact Method</th>
         <th>Call Status</th>  
         <th>Contact Name</th>
          <th>Contact Email</th>
          <th>Contact Phone</th>
          <th>Contact Job Title</th>
          <th>Contact Location</th>
          <th>Contact Skype Account</th> 
         <th>Comment</th>
         <th>Assigned PM</th>
        <th>Created BY</th>
        <th>Created At</th>
        <?php
        for ($i=1; $i <= 10; $i++) { 
          echo "<th>Follow Up Date - ".$i."</th>";
          echo "<th>Comment</th>";
          echo "<th>Call Status</th>";
          echo "<th>New Hitting</th>";
        }
        ?>
    </tr>
</thead>

<tbody>
    <?php
    if($sales->num_rows() > 0)
    {
        foreach($sales->result() as $row)
        {
            $leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
            $customerData = $this->db->get_where('customer',array('id'=>$row->customer))->row();
            $contactData = $this->db->get_where('customer_contacts',array('id'=>$row->contact_id))->row();
            $followUp = $this->db->get_where('sales_follow_up',array('sales'=>$row->id))->result();
            ?>
            <tr class="">
               <td><?php echo $this->admin_model->getBrand($customerData->brand);?></td>
              <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                <td>
                  <?php echo $this->customer_model->getCustomer($row->customer) ;?>
              </td>
              <td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
              <td><?php echo $this->customer_model->getType($leadData->type);?></td>
              <td><?php if($row->rolled_in == 1){echo "Yes";}else if($row->rolled_in == 2){echo "No";}else{}?></td>
              <td><?php echo $this->sales_model->getContactMethod($row->contact_method);?></td>
              <td><?php echo $this->sales_model->getActivityStatus($row->status);?></td>
              <td><?=$contactData->name?></td>
              <td><?=$contactData->email?></td>
              <td><?=$contactData->phone?></td>
              <td><?=$contactData->job_title?></td>
              <td><?=$contactData->location?></td>
              <td><?=$contactData->skype_account?></td>
              <td><?php echo $row->comment?></td>
              <td><?php echo $this->admin_model->getAdmin($row->pm)?></td>
              <td><?php echo $this->admin_model->getAdmin($row->created_by)?></td>
              <td><?php echo $row->created_at?></td>
              <?php foreach ($followUp as $follow) { ?>
              <td><?=$follow->follow_up?></td>
              <td><?=$follow->comment?></td>
              <td><?php echo $this->sales_model->getActivityStatus($follow->call_status);?></td>
              <td><?=$follow->new_hitting?></td>
              <?php } ?>
            </tr>
            <?php
        }
    }
    else
    {
        ?><tr><td colspan="7">There is no Activties in your list</td></tr><?php
    }
    ?>                              
</tbody>
</table>
</body>
</html>