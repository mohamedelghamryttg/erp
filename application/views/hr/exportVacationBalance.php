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
                    <th>#ID</th>
                    <th>Employee</th>
                    <th>Current Year Balance</th>
                    <th>Previous Year Balance</th>
                    <!--<th>Double Days Balance</th>-->
                    <th>Annual Leave</th>
                    <th>Casual Leave</th>
                    <th>Sick Leave</th>
                    <th>Marriage</th>
                    <th>Maternity Leave</th>
                    <th>Death Leave</th>
                    <th>Year</th>
                  
              </tr>
            </thead>
           <tbody>
           <?php foreach ($vacation_balance->result() as $row) { ?>
              <tr> 
                   
                    <td><?= $row->id ?></td>
                    <td><?= $this->db->query("SELECT name FROM employees WHERE id = '$row->emp_id'")->row()->name;?></td>
                    <td><?= $row->current_year ?></td>
                    <td><?= $row->previous_year ?></td>
                    <!--<td><?= $row->double_days ?></td>-->
                    <td><?= $row->annual_leave ?></td>
                    <td><?= $row->casual_leave ?></td>
                    <td><?= $row->sick_leave ?></td>
                    <td><?= $row->marriage ?></td>
                    <td><?= $row->maternity_leave ?></td>
                    <td><?= $row->death_leave ?></td>
                     <td><?= $row->year ?></td>
                   
              </tr>
              <?php }?>
                  
            </tbody>
          </table>
</body>
</html>