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
                <th>Ticket Number</th>
                <th>Opened BY</th>
                <th>Closed By</th>
                <th>Requester Name</th>
                <th>Number Of Rescource</th>
                <th>Request Type</th>
                <th>Service</th>
                <th>Task Type</th>
                <th>Rate</th>
                <th>Count</th>
                <th>Unit</th>
                <th>Currency</th>
                <th>Source Language</th>
                <th>Target Language</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
                
                <th>Subject Matter</th>
                <th>Software</th>
                <th>Request Time</th>
                <th>Time Of Opening</th>
                <th>Time OF CLosing</th>
                <th>Taken Time</th>
                <th>New Vendors</th>
                <th>Existing Vendors</th>
                <th>Existing Vendors with New Pairs</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if($ticket != ""){
              foreach ($ticket->result() as $row) {
                $time_closing = $this->db->get_where('vm_ticket_time',array('ticket'=>$row->ticket,'status'=>'4'))->row();
                $vmClosed = $this->db->get_where('vm_ticket_time',array('ticket'=>$row->ticket,'status'=>'5'))->row();
                $existing = $this->db->query("SELECT COUNT(*) AS existing FROM `vm_ticket_resource` WHERE ticket = '$row->ticket' and type = '2'")->row()->existing;
                $new = $this->db->query("SELECT COUNT(*) AS new FROM `vm_ticket_resource` WHERE ticket = '$row->ticket' and type = '1'")->row()->new;
                $existing_pair = $this->db->query("SELECT COUNT(*) AS existing_pair FROM `vm_ticket_resource` WHERE ticket = '$row->ticket' and type = '3'")->row()->existing_pair;
              ?>
              <tr>
                <td><?php echo $row->ticket ;?></td>
                <td><?=$this->admin_model->getAdmin($row->vm)?></td>
                <td><?=$this->admin_model->getAdmin($vmClosed->created_by)?></td>
                <td><?=$this->admin_model->getAdmin($row->requester)?></td>
                <td><?php echo $row->number_of_resource ;?></td>
                <td><?php echo $this->vendor_model->getTicketType($row->request_type);?></td>
                <td><?php echo $this->admin_model->getServices($row->service);?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $this->admin_model->getLanguage($row->source_lang) ;?></td>
                <td><?php echo $this->admin_model->getLanguage($row->target_lang) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                
                <td><?php echo $this->admin_model->getFields($row->subject);?></td>
                <td><?php echo $this->sales_model->getToolName($row->software);?></td>
                <td><?php echo $row->request_time ;?></td>
                <td><?php echo $row->open_time ;?></td>
                <td><?php if(isset($time_closing->created_at)){echo $time_closing->created_at;}?></td>
                <td><?php echo $this->vendor_model->ticketTime($row->ticket).' H:M';?></td>
                <td><?=$new?></td>
                <td><?=$existing?></td>
                <td><?=$existing_pair?></td>
                <td><?php echo $this->vendor_model->getTicketStatus($row->ticket_status);?></td>
                </tr>
              <?php }} ?>
            </tbody>
          </table>
</body>
</html>