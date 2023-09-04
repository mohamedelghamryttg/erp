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
            <th>ID</th>
            <th>Client Name</th>
            <th>Client Alias</th>
            <th>Name</th>
            <th>Email</th>
            <th>PM Name</th>
            <th>Region</th>

        </tr>
    </thead>
    <tbody>
        <?php 
        if($row){
            foreach ($row as $row) {
            	
        ?>
        <tr class="gradeX">
            <td><?php echo $row->id;?></td>
            <td><?php echo $row->client_name;?></td>
            <td><?php echo $row->client_alias;?></td>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo $row->pm_email;?></td>
            <td><?php echo $row->region;?></td>


        </tr>
        <?php }} ?>
    </tbody>
</table>
</body>
</html>