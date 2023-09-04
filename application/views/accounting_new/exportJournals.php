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
                    <th>Journal Number</th>
                    <th>Transaction Number</th>
                    <th>Entry Description </th>
                    <th>Description</th>
                    <th>Currency</th>
                    <th>Amount  </th>
                    <th>Total USD </th>
                    <th>Total EGP</th>
                    <th>Debit Credit</th>
                    <th>Bank</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Date</th>
                    <th>Brand</th>
                    <th>Created By</th>
                    <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($journal->result() as $row){ ?>
                    <tr>
                                    <td><?= $row->id?></td>  
                                    <td><?= $row->tID?></td>                              
                                    <td><?= $row->entry_description?></td>
                                    <td><?= $row->description ;?></td>
                                    <td><?= $row->currency_name ?></td>
                                    <td><?= $row->amount ;?></td>
                                    <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,2,$row->date,$row->amount),2)?></td>
                                    <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,1,$row->date,$row->amount),2)?></td>
                                    <td><?= $this->accounting_model->getFollowUpDepitOrCredit($row->debit_credit)?></td>   
                                    <td><?= $row->payment_method_name ;?></td>
                                    <td><?= $row->section_name ?></td>  
                                    <td><?= $row->category_name ?></td>
                                    <td><?= $row->subcategory_name ?></td>                        
                                    <td><?= $row->date ?></td>
                                    <td><?= $row->brand_name ?></td>
                                    <td><?= $row->user_name ?></td>
                                    <td><?= $row->trans_created_at ;?></td>
            		</tr>
            	<?php } ?>
            </tbody>
          </table>
</body>
</html>