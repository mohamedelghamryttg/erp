<!DOCTYPE ><html dir=ltr>
    <head>
        <meta charset="UTF-8">
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
      text-align: center;
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
                                <?php if($this->brand == 1){?>
                                    <th>Brand Name</th>
                                <?php }?>
                                <th>Invoice Number</th>
                                <th>External serial</th>
                                <th>Issue Date</th>
                                <th>Issue Month</th>
                                <th>Issue Year</th>                                                            
                                <th>Customer Name</th>
                                <th>Client Status</th>
                                <th>Country</th>
                                <th>Region</th>
                                <th>Currency</th>
                                <th>Total Revenue</th>
                                <th>Total Revenue $</th>
                                <th>PO Number</th>
                                <th>Status</th> 
                                <th>Payment Date</th>   
                                 <th>Payment Month</th>   
                                 <th>Payment year</th> 
                                <th>Payment Method</th>   
                                <th>Service</th>
                                <th>Source</th>
                                <th>Target</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Rate</th>   
                                <th>PM Name</th>         
                                <th>Sales Name</th> 
                                <th>Payment terms</th>
                                <th>Due Date</th>
                                <th>Due Month</th>
                                <th>Due Year</th> 
                                <th>Created By</th>
                                <th>Created At</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoice->result() as $row) {
                                $invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
                                $invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
                                $jobs = $this->db->query(" SELECT * FROM job WHERE po IN (".$row->po_ids.") ")->result(); 
                                foreach ($jobs as $job) {
                                    $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                                    $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
                                    $payment = $this->db->query(" SELECT * FROM payment WHERE customer = $row->customer AND( po_ids like '%,$job->po,%' OR  po_ids like '$job->po,%' OR  po_ids like '%,$job->po' OR  po_ids like '$job->po')")->row();
                                ?>
                                <tr>
                                    <?php if($this->brand == 1){?>
                                        <td><?php echo $this->projects_model->getTTGBranchForJob($job->id);?></td>
                                    <?php }?>
                                    <td># <?= $row->id ?></td>
                                    <td><?= $row->external_serial ?></td>
                                    <td><?= $row->issue_date ?></td>
                                    <td><?= date('F', strtotime($row->issue_date)) ?></td>
                                    <td><?= date('Y', strtotime($row->issue_date)) ?></td> 
                                    <td><?php echo $this->customer_model->getCustomer($row->customer); ?></td>
                                    <td><?= $this->accounting_model->getCustomerStatus($row->customer); ?></td>                                    
                                    <td><?= $this->admin_model->getCountry($this->customer_model->getLeadDataByCustomer($row->lead)->country) ?></td>
                                    <td><?= $this->admin_model->getRegion($this->customer_model->getLeadDataByCustomer($row->lead)->region) ?></td>
                                    <td><?= $this->admin_model->getCurrency($invoiceCurrency) ?></td>
                                    <td><?php echo $jobTotal; ?></td>  
                                    <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency, 2, $row->issue_date, $jobTotal), 2); ?></td>
                                    <td><?= $this->accounting_model->getPONumber($job->po) ?></td>        
                                    <td><?= $this->accounting_model->getPoInvoiceStatus($job->po, $row->created_at, $row->payment) ?></td>
                                    <?php if($payment){?>
                                    <td><?= $payment->payment_date?></td>
                                    <td><?= date('F', strtotime($payment->payment_date))?></td>                                                   
                                    <td><?= date("Y", strtotime($payment->payment_date)) ?></td>
                                    <td><?= $this->accounting_model->getPaymentMethod($payment->payment_method) ?></td> 
                                    <?php }else{?>
                                    <td></td>
                                    <td></td>                                                   
                                    <td></td>
                                    <td></td> 
                                    <?php }?>                                    
                                    <td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
                                    <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                                    <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                                    <?php if ($job->type == 1) { ?>
                                        <td><?php echo $job->volume; ?></td>
                                    <?php } elseif ($job->type == 2) { ?>
                                    <td><?php echo $jobTotal / $priceList->rate; ?></td>
                                        <?php } ?>                                                    
                                    <td><?php echo $this->admin_model->getUnit($priceList->unit) ?></td>
                                    <td><?php echo $priceList->rate; ?></td>
                                    <td><?= $this->admin_model->getAdmin($job->created_by);?></td>
                                    <td><?= $this->admin_model->getAdmin($job->assigned_sam);?></td>
                                    <td><?= $row->payment ?></td>                          
                                    <td><?= date("Y-m-d", strtotime($row->created_at . " +" . $row->payment . " days")) ?></td>
                                    <td><?= date("F", strtotime($row->created_at . " +" . $row->payment . " days")) ?></td>
                                    <td><?= date("Y", strtotime($row->created_at . " +" . $row->payment . " days")) ?></td>                               
                                    <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                    <td><?php echo $row->created_at; ?></td>
                                
                                        </tr>
                            <?php } } foreach ($creditNote as $row) { ?>
                                    <tr style="background-color: yellow;">
                                    <td>Credit Note Number # <?=$row->id?></td>
                                    <td></td>
                                    <td><?=$row->issue_date?></td>
                                     <td><?= date('F', strtotime($row->issue_date)) ?></td>
                                    <td><?= date('Y', strtotime($row->issue_date)) ?></td> 
                                    <td><?php echo $this->customer_model->getCustomer($row->customer);?> - <?=$this->accounting_model->getCreditNoteType($row->type)?></td>
                                    <td><?= $this->accounting_model->getCustomerStatus($row->customer); ?></td>
                                    
                                     <td><?= $this->admin_model->getCountry($this->customer_model->getLeadDataByCustomer($row->lead)->country) ?></td>
                                    <td><?= $this->admin_model->getRegion($this->customer_model->getLeadDataByCustomer($row->lead)->region) ?></td>
                                   
                                    <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                                    <td>-<?=$row->amount?></td>
                                    <td>-<?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,2,$row->issue_date,$row->amount),2);?></td>
                                    <td><?=$this->projects_model->getJobPoData($row->po)->number?></td>
                                    <td><?=$this->accounting_model->getCreditNoteStatus($row->status)?></td>
                                    
                                    <td colspan="16"></td>                                   
                                   
                                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                                    <td><?=$row->created_at?></td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                  </body>
</html>