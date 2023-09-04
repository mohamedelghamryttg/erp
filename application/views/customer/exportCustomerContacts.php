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
<table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
        <tr>
            <th> Lead ID</th>
            <th>Customer ID</th>
            <th>Client Name</th>
            <th>SAM Person</th>
            <th>Client Alias</th>
            <th>Region</th>
            <th>Country</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Job Title</th>
            <th>Location</th>
            <th>Skype Account</th>
            <th>Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($row){
            foreach ($row as $row) {
            	$customer = $this->db->get_where('customer',array('id'=>$row->customer))->row();
                $sam = $this->db->get_where('customer_sam',array('lead'=>$row->id))->row()->sam;
        ?>
        <tr class="gradeX">
            <td><?php echo $row->id;?></td>
            <td><?php echo $row->customer;?></td>
            <td><?php echo $customer->name;?></td>
            <td><?php echo $this->admin_model->getAdmin($sam) ;?></td>
            <td><?php echo $customer->alias;?></td>
            <td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
            <td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
            <td><?php echo $row->name ;?></td>
            <td><?php echo $row->email ;?></td>
            <td><?php echo $row->phone ;?></td>
            <td><?php echo $row->job_title ;?></td>
            <td><?php echo $row->location ;?></td>
            <td><?php echo $row->skype_account ;?></td>
            <td><?php echo $row->comment ;?></td>

        </tr>
        <?php }} ?>
    </tbody>
</table>
</body>
</html>