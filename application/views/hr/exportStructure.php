<!DOCTYPE >
<html dir=ltr>
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

   <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Division</th>
                <th>Department</th>
                <th>Track</th>
                <th>Brand</th>
                <th>Parent</th>
                <th>Grand Parent</th>
                <th>Created By</th>
                <th>Created At</th>
            

              </tr>
            </thead>

            <tbody>
              <?php
              if ($structure->num_rows() > 0) {
                foreach ($structure->result() as $row) {
                  ?>
                  <tr class="">
                    <td>
                      <?php echo $row->id; ?>
                    </td>
                    <td>
                      <?php echo $row->title; ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDivision($row->division); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDepartment($row->department); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getTrack($row->track); ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getBrand($row->brand); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getTitle($row->parent); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getTitle($row->grand_parent); ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                    </td>
                    <td>
                      <?php echo $row->created_at; ?>
                    </td>
                   
                  </tr>
                  <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="7">There is no Structure to list</td>
                </tr>
                <?php
              }
              ?>
            </tbody>

          </table>

        </body>
   </html>