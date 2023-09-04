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
                  <th>#</th>
                  <th>Task Code</th>
                  <th>Vendor</th>
                  <th>Vendor Email</th>  
                  <th>Contacts</th> 
                  <th>Rate</th>
                  <th>Volume</th>
                  <th>Unit</th>
                  <th>Total</th>
                  <th>Currency</th>
                  <th>Payment Method</th> 
                   <th>Payment Date</th>
                  <th>Status</th>
                  <th>Created By</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($payment->result() as $row) { 
                $task = $this->db->get_where('job_task',array('id'=>$row->task))->row();
                $vendor = $this->db->get_where('vendor',array('id'=>$task->vendor))->row();
              ?>
              <tr>
                <td><?=$row->id?></td>
                <td><?=$task->code?></td>
                <td><?php echo $this->vendor_model->getVendorName($task->vendor);?></td>
                <td><?=$vendor->email?></td>
                <td><?=$vendor->contact?></td>
                <td><?=$task->rate?></td>
                <td><?=$task->count?></td>
                <td><?=$this->admin_model->getUnit($task->unit)?></td>
                <td><?=$task->rate * $task->count?></td>
                <td><?=$this->admin_model->getCurrency($task->currency)?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
                <td><?php echo $row->payment_date ;?></td>
                <td><?php if($row->status == 1){echo "Paid";}elseif($row->status == 2){echo "Re-opened";} ?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
</body>
</html>