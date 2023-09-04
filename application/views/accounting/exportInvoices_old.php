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
                                <th>Invoice Number</th>
                              <th>Client Name</th>
                                <th>Selected POs</th>
                              <th>Currency</th>
                                <th>Total Revenue</th>
              					<th>Total Revenue $</th>
                                <th>Payment Method</th>
                              <th>Issue Date</th>
                              <th>Payment terms</th>
                              <th>Due Date</th>
                              <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($invoice->result() as $row) { 
				$invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
								$invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
                            ?>
                <tr>
                  <td># <?=$row->id?></td>
                  <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                   <td><?= str_replace("<br/>", "<br style='mso-data-placement:same-cell'/>", $this->accounting_model->getSelectedPOsLines($row->po_ids)); ?></td>
                  <td><?=$this->admin_model->getCurrency($invoiceCurrency)?></td>
                  <td><?php echo $invoiceTotal ;?></td>
                  <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency,2,$row->issue_date,$invoiceTotal),2);?></td>
                  <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
                  <td><?=$row->issue_date?></td>
                  <td><?=$row->payment?></td>
                  <td><?=date( "Y-m-d", strtotime( $row->issue_date." +".$row->payment." days" ) )?></td>
                  <td><?=$this->accounting_model->getInvoiceStatus($row->status,$row->issue_date,$row->payment)?></td>
                  <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                  <td><?php echo $row->created_at ;?></td>
                </tr>
              <?php } ?>
            	<?php foreach ($creditNote as $row) { ?>
            		<tr style="background-color: yellow;">
                	<td>Credit Note Number # <?=$row->id?></td>
                	<td><?php echo $this->customer_model->getCustomer($row->customer);?> - <?=$this->accounting_model->getCreditNoteType($row->type)?></td>
                	<td><?=$this->projects_model->getJobPoData($row->po)->number?></td>
                    <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                    <td>-<?=$row->amount?></td>
                    <td>-<?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,2,$row->issue_date,$row->amount),2);?></td>
                    <td></td>
                    <td><?=$row->issue_date?></td>
					<td></td>
					<td></td>
                    <td></td>
                	<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                	<td><?=$row->created_at?></td>
            		</tr>
            	<?php } ?>
            </tbody>
          </table>
</body>
</html>