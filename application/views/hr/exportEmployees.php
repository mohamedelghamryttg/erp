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


  <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th colspan="6" style="text-align: center; background: #2980B9;">Employee  Data</th>
                <th colspan="10" style="text-align: center; background: #7FB3D5;">Positioning Data </th>
                <th colspan="3" style="text-align: center; background: #D4E6F1 ;">Communication info</th>
              </tr>

              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>National ID</th>
                <th>Brand</th>
                <th>Division</th>
                <th>Function</th>
                <th>Position</th>
                <th>Direct Manager</th>
                <th>Time Zone</th>
                <th>Office Location</th>
                <th>Hiring Date</th>
                <th>Probationay Period</th>
                <th>Contract Date</th>
                <th>Contract Type</th>
                <th>Employee Status</th>
                <th>Resignation Date</th>
                <th>Resignation Reason</th>
                <th>Resignation Comment</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Emergency Contact</th>
                <th>Created By</th>
                <th>Created At</th>

                
              </tr>
            </thead>
            
            <tbody>
              <?php
              if(($employees->num_rows())>0)
              {
                foreach($employees->result() as $row)
                {
                  ?>
                  <tr class="">
                    <td><?php echo $row->id ;?></td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->birth_date;?></td>
                    <td><?php if($row->gender == 1){echo "Male";}else{echo "Female";}?></td>
                    <td><?php echo $row->national_id;?></td>
                    <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td>
                    <td><?php echo $this->hr_model->getDivision($row->division);?></td>
                    <td><?php echo $this->hr_model->getDepartment($row->department);?></td>
                    <td><?php echo $this->hr_model->getTitle($row->title);?></td>
                    <td><?php echo $this->hr_model->getEmployee($row->manager);?></td>
                    <td><?php echo $row->time_zone;?></td>
                    <td><?php echo $row->office_location;?></td>
                    <td><?php echo $row->hiring_date;?></td>
                    <td><?php echo $row->prob_period;?></td>
                    <td><?php echo $row->contract_date;?></td>
                    <td><?php if($row->contract_type == 1){echo "Full Time";}else if($row->contract_type == 2){echo "Part Time";}?></td>
                    <td><?php if($row->status == 0){echo "Working";}else if($row->status == 1){echo "Resigned";}?></td>
                    <td><?php echo $row->resignation_date;?></td>
                    <td><?php echo $this->hr_model->getResignationReason($row->resignation_reason);?></td>
                    <td><?php echo $row->resignation_comment;?></td>
                    <td><?php echo $row->email;?></td>
                    <td><?php echo $row->phone;?></td>
                    <td><?php echo $row->emergency;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
                  </tr>
                  <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is no Employee to list</td></tr><?php
              }
              ?>                
            </tbody>
          </table>

        </body>
   </html>