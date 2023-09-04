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
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Password</th>
                          <th>Country</th>
                          <th>Language</th>
                          <th>Created At</th>
                          <th>Created By</th>
                         
                    </tr>
                  </thead>
                 <tbody>
                 <?php foreach ($accounts->result() as $row) { ?>
                    <tr> 
                         
                          <td><?= $row->id ?></td>
                          <td><?= $row->first_name ?></td>
                          <td><?= $row->last_name ?></td>
                          <td><?= $row->username ?></td>
                          <td><?= $row->email ?></td>
                          <td><?= $row->password ?></td>
                          <td><?= $row->country ?></td>
                          <td><?= $row->language ?></td>
                          <td><?= $row->created_at ?></td>
                          <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>
                         
                    </tr>
                    <?php }?>
                  </tbody>
          </table>
</body>
</html>