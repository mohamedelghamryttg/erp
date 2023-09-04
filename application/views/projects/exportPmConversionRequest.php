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
                  <th>ID</th>
                                <th>File Name</th>
                              <th>Task Type</th>
                              <th>Attachment Type</th>
                              <th>Attachment</th>
                              <th>Link</th>
                              <th>Status</th>
                              <th>Created By</th>
                              <th>Created At</th>

                              
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pm_conversion_requests->result() as $row) { ?>
              <tr class="">
                <td><?= $row->id ?></td>
                <td><?= $row->file_name ?></td>
                <td><?= $this->projects_model->getConversionTaskType($row->task_type) ?></td>
                <td><?= $row->attachment_type == 1 ? "Attachment" : "Link"   ?></td>
                <td><?= $row->attachment ?></td>
                <td><a><?= $row->link ?></a></td>
                <td><?php  if($row->status == 1){
                  echo "Running";
                }elseif ($row->status == 2) {
                                    echo "Closed";
                }elseif ($row->status == 3) {
                  echo "Faild";
                } ?>
                  
                </td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?= $row->created_at ?></td>
                
                



              </tr>
            <?php } ?>
            </tbody> 
          </table>
</body>
</html>