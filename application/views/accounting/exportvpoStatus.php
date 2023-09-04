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
                  <th>PM Name</th>
                  <th>P.O Number</th>
                  <th>VPO Status</th>
                  <th>CPO Verified</th>
                  <th>CPO Verified Date</th>
                  <th>VPO Date</th>
                  <th>Vendor Name</th>
                  <th>Source Language</th>
                  <th>Target Language</th>
                  <th>Task Type</th>
                  <th>Count</th>
                  <th>Unit</th>
                  <th>Rate</th>
                  <th>Currency</th>
                  <th>P.O Amount</th>
                  <th>Invoice Status</th>
                  <th>Invoice Date</th>
                  <th>Due Date (45 Days)</th>
                  <th>Max Due Date (60 Days)</th>
                  <th>Payment Status</th>
                  <th>Payment Date</th>
                  <th>Payment Method</th>
                  <th></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($task->result() as $row) {
            $job = $this->db->get_where('job',array('id'=>$row->job_id))->row();
            $priceList = $this->projects_model->getJobPriceListData($job->price_list); 
            $po = $this->db->get_where('po',array('id'=>$job->po))->row()
            ?>
              <tr>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?=$row->code?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if($po->verified == 1){echo "Verified";}else{echo "";}?></td>
                <td><?php if($po->verified == 1){echo $po->verified_at;}else{echo "";}?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $row->rate * $row->count;?></td>
                <td><?=$this->accounting_model->getPOStatus($row->verified)?></td>
                <td><?php echo $row->verified_at ;?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +45 days" ) ); }?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +60 days" ) ); }?></td>
                <td><?php if($row->payment_status == 1){echo "Paid";}else{echo "Not Paid";}?></td>
                <td><?=$row->payment_date?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
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