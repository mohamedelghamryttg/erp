<!DOCTYPE >
<html dir=ltr>
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
                <th>Ticket ID</th>
                <th>Ticket From</th>                           
                <th>Function</th>                           
                <th>Ticket Type</th>
                <th>Service Type</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Date</th>
                <th>Status</th>                          
                <th>Closed BY</th>
                <th>Closed AT</th>
                <th>Action Type</th>
                

                
              </tr>
            </thead>
            
            <tbody>
              <?php
              if(($tickets->num_rows())>0)
              {
                foreach($tickets->result() as $row)
                {
                  ?>
                  <tr class="">
                    <td><?= $row->id ?></td>
                    <td><?= $this->automation_model->getEmpName($row->emp_id); ?></td>
                    <td><?= $this->automation_model->getEmpDep($row->emp_id); ?></td>                                
                    <td><?= $row->ticket_type ?></td>
                    <td><?= $this->automation_model->getServiceType($row->service_type) ?></td>
                    <td><?= $row->subject?></td>
                    <td><?= strip_tags($row->description)?></td>                   
                    <td><?= $row->created_at?></td>                   
                    <td><?= $this->automation_model->getTicketStatus($row->status)['status'] ?></td>
                    <td><?php echo $this->automation_model->getUserName($row->closed_by) ;?></td>
                    <td><?php echo $row->closed_at ;?></td>
                    <td>
                    <?php if($row->status == 3){
                     echo ($row->action_type==1)?'YES':'NO' ;
                    } ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is no Tickets to list</td></tr><?php
              }
              ?>                
            </tbody>
          </table>

        </body>
   </html>