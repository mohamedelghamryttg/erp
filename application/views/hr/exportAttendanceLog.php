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
	<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
               <th>Employee ID</th>
               <th>Employee Name</th>
               <th>Department</th>
               <th>Sign In</th>
               <th>Sign Out</th>
                <th>Location</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($attendance as $row){ 
           try {
                $signin = $this->db->query("SELECT id FROM attendance_log AS `log` WHERE log.USRID = " . $row->USRID . " AND `TNAKEY` = '1' AND `SRVDT` = '" . $row->SignIn  . "' ORDER BY log.id ASC LIMIT 1")->row();
            } catch (\Throwable $th) {
                    //throw $th;
                }    
             try {
            $signOut = $this->db->query("SELECT `SRVDT`,`id` FROM attendance_log AS log WHERE log.USRID = " . $row->USRID . " AND `TNAKEY` = '2' AND
                      ((log.SRVDT BETWEEN '" . $row->SignIn . "' AND DATE_ADD('" . $row->SignIn . "', INTERVAL 18 hour)) AND log.SRVDT > '" . $row->SignIn . "') ORDER BY log.id DESC LIMIT 1")->row();
            } catch (\Throwable $th) {
                    //throw $th;
                }     
                $department = $this->db->get_where('employees',array('id'=>$row->USRID))->row()->department;
            ?>
              <tr>
                <td><?=$row->USRID?></td>
                <td><?=$this->hr_model->getEmployee($row->USRID)?></td>
                <td><?=$this->hr_model->getDepartment($department)?></td>
              	<td><?=$row->SignIn?></td>
                <td><?=$signOut->SRVDT?></td>
                <td><?=$this->hr_model->checkAttendanceLocation($signin->id,$signOut->id)?></td>
              </tr>
            <?php  } ?>
            </tbody>
          </table>
					</body>
                    </html>