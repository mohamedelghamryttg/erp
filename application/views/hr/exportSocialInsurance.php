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
                    <th>Gender</th>
                    <th>Basic</th>
                    <th>Variable</th>
                    <th colspan="9" >Insurance Number</th>
                    <th>Currency</th>
                    <th>Country</th>
                    <th>Total Deductions</th>
                    <th>Bitrh Date</th>
                    <th>Activation Date</th>
                    <th>Deactivation Date</th>
                    <th>Created At</th>
                    <th>Created By</th>
              </tr>
            </thead>
           <tbody>
           <?php foreach ($socialInsurance->result() as $row) { ?>
              <tr> 
                   
                    <td><?=$row->id ?></td>
                    <td><?= $this->db->query("SELECT name FROM employees WHERE id = '$row->employee_id'")->row()->name;?></td>
                    <td>
                      <?php 
                       $gender = $this->db->query("SELECT gender FROM employees WHERE id = '$row->employee_id'")->row()->gender;  
                       if($gender == 1){
                        echo "Male";
                       }elseif($gender == 2){
                        echo "Female";
                       }
                      ?>
                        
                    </td>
                  
                    <td><?=$row->basic ?></td>
                    <td><?=$row->variable ?></td>
                       
                          <?php  $insuranceNumber = explode(" ", $row->insurance_number); ?>
                           <td width="3px"><?=$insuranceNumber[0]?></td>
                           <td width="3px"><?=$insuranceNumber[1]?></td>
                           <td width="3px"><?=$insuranceNumber[2]?></td>
                           <td width="3px"><?=$insuranceNumber[3]?></td>
                           <td width="3px"><?=$insuranceNumber[4]?></td>
                           <td width="3px"><?=$insuranceNumber[5]?></td>
                           <td width="3px"><?=$insuranceNumber[6]?></td>
                           <td width="3px"><?=$insuranceNumber[7]?></td>
                           <td width="3px"><?=$insuranceNumber[8]?></td>
                    
                    <td><?= $this->admin_model->getCurrency($row->currency) ?></td>
                    <td><?= $this->admin_model->getCountry($row->country) ?></td>
                    <td><?= $row->total_deductions ?></td>
                    <td><?=$this->db->query("SELECT birth_date FROM employees WHERE id = '$row->employee_id'")->row()->birth_date;?></td>
                    <td><?=$row->activation_date ?></td>
                    <td><?=$row->deactivation_date?></td>
                    <td><?=$row->created_at ?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
              </tr>
              <?php }?>
                  
            </tbody>
          </table>
</body>
</html>