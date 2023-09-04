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
   vertical-align: middle;
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
            <th>Client Name</th>
            <th>Invoice Number</th>                                                   
            <th colspan="2">Selected POs</th>
            <th>Total Revenue</th>
            <th>Currency</th>
            <th>Total Revenue $</th>                                                   
            <th>Due Date</th>                                                    
            <th>Created By</th>
            <th>Created At</th>                                                       
                                                       
        </tr>
    </thead>
        <tbody>
        <?php
        foreach ($invoice->result() as $row) {
            $invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
            $invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
            $job = $this->db->query(" SELECT * FROM job WHERE po IN (".$row->po_ids.") ")->result(); 
            $poCount = count($job);
            foreach ($job as $k=>$job) {
                $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
   if($k==0){ ?>          
            <tr>
               <td rowspan="<?=$poCount?>"><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                <td rowspan="<?=$poCount?>"># <?=$row->id?></td>
                <td><?= $this->accounting_model->getPONumber($job->po) ?></td>
                <td><?php echo $jobTotal; ?></td>  
                <td rowspan="<?=$poCount?>"><?php echo $invoiceTotal ;?></td>
                <td rowspan="<?=$poCount?>"><?=$this->admin_model->getCurrency($invoiceCurrency)?></td>
                <td rowspan="<?=$poCount?>"><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency,2,$row->issue_date,$invoiceTotal),2);?></td>

                <td rowspan="<?=$poCount?>"><?=date( "Y-m-d", strtotime( $row->created_at." +".$row->payment." days" ) )?></td>

                <td rowspan="<?=$poCount?>"><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td rowspan="<?=$poCount?>"><?php echo $row->created_at ;?></td>

            </tr>
         <?php }else{?>
            <tr>
              <td><?= $this->accounting_model->getPONumber($job->po) ?></td>
              <td><?php echo $jobTotal; ?></td>  
            </tr>
        <?php }}} ?>
    </tbody>
    </table>
</body>
</html>