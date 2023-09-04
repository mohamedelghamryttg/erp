<!DOCTYPE ><html dir=rtl>
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
<table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
        <tr>
          <th>Customer</th>
          <th>Product Line</th>
          <th>Service</th>
          <th>Task Type</th>
          <th>Rate</th>
          <th>Unit</th>
          <th>Source</th>  
          <th>Target</th>
          <th>Status</th>
          <th>Created By</th>
          <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($priceList){
            foreach($priceList->result() as $row){
            $fuzzy = $this->db->get_where('customer_fuzzy',array('priceList'=>$row->id))->result();
        ?>
        <tr class="gradeX">
            <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
            <td><?php echo $this->customer_model->getProductLine($row->product_line) ;?></td>
            <td><?php echo $this->admin_model->getServices($row->service) ;?></td>
            <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
            <td><?php echo $row->rate ;?></td>
            <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
            <td><?php echo $this->admin_model->getLanguage($row->source) ;?></td>
            <td><?php echo $this->admin_model->getLanguage($row->target) ;?></td>
            <td><?php echo $this->sales_model->getClientPriceStatus($row->approved) ;?></td>
            <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
            <td><?php echo $row->created_at ;?></td>
            <?php foreach ($fuzzy as $fuzzy) { ?>
            <td><?=$fuzzy->prcnt?></td>
            <td><?=$fuzzy->value?></td>
            <?php } ?>
        </tr>
        <?php }} ?>
    </tbody>
</table>
</body>
</html>