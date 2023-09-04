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
border: 2px solid black;
font-size:18px;
}
table td {
border: 2px solid black;
text-align: center;
}
table th {
border: 2px solid black;
background-color:  #a0280f;
color: white;
font-style: italic;
text-align: center;
}
</style>
</head>
<body>
  <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                  <th>ID</th>
                  <th>Date</th>
                  <th>Client Name</th>
                  <th>Selected PO</th>
                  <th>Invoice Number</th>
                  <th>Invoice Amount</th>
                  <th>Invoice Currency</th>
                  <th>Deductions</th>
                  <th>Deductions Reason</th>
                  <th>Advanced Payment</th>
              	  <th>Credit Note IDs</th>
                  <th>Credit Note Total</th>
                  <th>Net Amount</th>
                  <th>Currency</th>
                  <th>Payment Method</th>
                  <th>Created By</th>
                  <th>Created At</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($payment->result() as $row) { 
              $pos = explode(",", $row->po_ids);
            ?>
            <tr>
              <td rowspan="<?=count($pos)?>"><?=$row->id?></td>
              <td rowspan="<?=count($pos)?>"><?=$row->payment_date?></td>
              <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
              <td><?=$this->accounting_model->getPONumber($pos[0])?></td>
              <td><?=$this->accounting_model->getInvoiceNumberByPoAndCustomer($pos[0],$row->customer)?></td>
              <td><?php echo number_format($this->accounting_model->getInvoiceTotal($pos[0]),2) ;?></td>
              <td><?=$this->admin_model->getCurrency($this->accounting_model->getInvoiceCurrency($pos[0]))?></td>
              <td rowspan="<?=count($pos)?>"><?=$row->deductions?></td>
              <td rowspan="<?=count($pos)?>"><?=$this->accounting_model->getPaymentDeductions($row->deduction_reason)?></td>
              <td rowspan="<?=count($pos)?>"><?=$row->advanced_payment?></td>
              <td rowspan="<?=count($pos)?>"><?=$row->credit_note?></td>
              <td rowspan="<?=count($pos)?>"><?=$row->total_credit_note?></td>
              <td rowspan="<?=count($pos)?>"><?=number_format($row->net_amount,2)?></td>
              <td rowspan="<?=count($pos)?>"><?=$this->admin_model->getCurrency($row->currency)?></td>
              <td rowspan="<?=count($pos)?>"><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
              <td rowspan="<?=count($pos)?>"><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
              <td rowspan="<?=count($pos)?>"><?php echo $row->created_at ;?></td>
            </tr>
            <?php 
              for ($i=1; $i < count($pos) ; $i++) { 
            ?>
            <tr>
              <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
              <td><?=$this->accounting_model->getPONumber($pos[$i])?></td>
              <td><?=$this->accounting_model->getInvoiceNumberByPoAndCustomer($pos[$i],$row->customer)?></td>
              <td><?php echo number_format($this->accounting_model->getInvoiceTotal($pos[$i]),2) ;?></td>
              <td><?=$this->admin_model->getCurrency($this->accounting_model->getInvoiceCurrency($pos[$i]))?></td>
            </tr>
            <?php } ?>            
            <?php } ?>
            </tbody>
          </table>
</body>
</html>