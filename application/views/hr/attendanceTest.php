<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
               <th>Employee ID</th>
               <th>Employee Name</th>
               <th>Sign In</th>
               <th>Location</th>
               <th>Sign Out</th>
               <th>Location</th>
              </tr>
            </thead>
            <tbody>
            <?php for($i = 0;$i < count($attendance);$i++){ ?>
              <tr>
                <td><?=$attendance[$i]['USRID']?></td>
                <td><?=$this->hr_model->getEmployee($attendance[$i]['USRID'])?></td>
              	<td><?=$attendance[$i]['SignIn']?></td>
              	<td><?php if($attendance[$i]['SignInLocation'] == '0'){echo "Office";}elseif($attendance[$i]['SignInLocation'] == '1'){echo "Home";}?></td>
                <td><?=$attendance[$i]['SignOut']?></td>
              	<td><?php if($attendance[$i]['SignOutLocation'] == '0'){echo "Office";}elseif($attendance[$i]['SignOutLocation'] == '1'){echo "Home";}?></td>
              </tr>
            <?php  } ?>
            </tbody>
          </table>