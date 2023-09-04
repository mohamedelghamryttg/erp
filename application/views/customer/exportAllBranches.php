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

            <th>Client Name</th>
            <th>Client Status</th>
            <th>Region</th>
            <th>Country</th>
            <th>Brand</th>
            <th>Assigned Sam 1</th>
            <th>Assigned Sam 2</th>
            <th>Assigned Sam 3</th>
            <th>Assigned Sam 4</th>
            <th>Assigned Sam 5</th>
            <th>Assigned Sam 6</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($row){
            foreach ($row as $row) {
              $sam = $this->db->get_where('customer_sam',array('lead'=>$row->id))->result();
        ?>
        <tr class="gradeX">
            <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
            <td><?php if($row->customer_status == 1){ echo "Lead"; }elseif ($row->customer_status == 2){ echo "Existing"; } ?></td>
            <td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
            <td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
            <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td>
            <?php foreach ($sam as $sam) { ?>
            <td><?=$this->admin_model->getAdmin($sam->sam)?></td>
            <?php } ?>
        </tr>
        <?php }} ?>
    </tbody>
</table>
</body>
</html>