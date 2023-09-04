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
               <th>Job Code</th>
               <th>Client Name</th>
               <th>Service</th>
               <th>Source</th>
               <th>Target</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Total Revenue</th>
               <th>Currency</th>
               <th>Status</th>
               <th>PO Number</th>               
               <th>PO Status</th>
               <th>PO Status Date</th>
               <th>Has Error</th>
               <th>Start Date</th>
               <th>Delivery Date</th>
               <th>Closed Date</th>
               <th>Created By</th>
               <th>Created At</th>
              </tr>
            </thead>
          <tbody>
            <?php foreach ($job->result() as $row) { 
          $priceList = $this->projects_model->getJobPriceListData($row->price_list);
          $total_revenue = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
              $poData = $this->projects_model->getJobPoData($row->po);
            ?>
              <tr>
                <td><?=$row->code?></td>
               
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
                <td><?=$total_revenue?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if(isset($poData)){ echo $poData->number; }?></td>
               <td><?php if(isset($poData)){$this->accounting_model->getPOStatus($poData->verified); } ?></td>
                 <?php if(isset($poData->verified_at)){ ?>
                     <td><?= $poData->verified_at?></td>
                  <?php }elseif(empty($poData->verified_at)) { ?>
                     <td> </td>
                  <?php  } ?>
                <td>
                <?php if(isset($poData)){
                    if($poData->verified == 2){
                      $errors = explode(",", $poData->has_error);
                      for ($i=0; $i < count($errors); $i++) { 
                        if($i > 0){echo " - ";}
                        echo $this->accounting_model->getError($errors[$i]);
                       }
                     }} ?>
                </td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                 <?php if($row->status == 0) { ?>
                    <td> </td>
                 <?php }elseif ($row->status == 1) { ?>
                    <td><?php echo $row->closed_date ;?></td>
                <?php } ?>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
            <?php } ?>
            </tbody>
              
    </table>
    </body>
</html>
             