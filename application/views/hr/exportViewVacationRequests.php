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
                    <th>Direct Manager</th>
                    <th>Type of vacation</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Requested Days</th>
                    <th>Status</th>
                    <th>Created At</th>
              </tr>
            </thead>
           <tbody>
            <?php foreach($vacation_requests->result() as $row) { ?>
                  <tr class="">
                    <td><?= $row->id ;?></td>
                    <td><?= $this->hr_model->getUser($row->emp_id) ;?></td>
                    <td><?= $this->hr_model->getUser($this->hr_model->getManagerId($row->emp_id)) ;?></td>
                    <td><?= $this->hr_model->getAllVacationTypies($row->type_of_vacation) ;?></td>
                    <td><?= $row->start_date;?></td>
                    <td><?= $row->end_date;?></td>
                   <td><?= $row->requested_days;?></td>
                    <td><?= $this->hr_model->getVacationStatus($row->status);?></td>
                    <td><?= $row->created_at;?></td>
                  </tr>
               <?php } ?>  
            </tbody>
          </table>       
</body>
</html>