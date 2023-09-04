<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Filter
      </header>
    
     <?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
			<?php  } ?>
			<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
			<?php  } ?>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="attendance" action="<?php echo base_url()?>hr/attendanceMac" method="post" enctype="multipart/form-data">
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="">
            </div>

        </div>
       
       <?php if($permission->view == 1){ ?>

          
        <?php if ($this->role == 12){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->customer_model->selectSamEmployeeId()?>
                </select>
            </div>
        </div>

    <?php } ?>


        <?php if ($this->role == 15){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->accounting_model->selectAccountantEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>


        <?php if ($this->role == 16){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->projects_model->selectPmEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>


    <?php if ($this->role == 24){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->admin_model->selectDtpEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>


        <?php if ($this->role == 28){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->admin_model->selectTranslatorEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>


            <?php if ($this->role == 26){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->admin_model->selectLeEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>

        <?php if ($this->role == 22){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->admin_model->selectMarketingEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>

            <?php if ($this->role == 32){ ?>
                  <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user" required="" />
                         <option value="">-- Select Employee --</option>
                         <?=$this->vendor_model->selectVmEmployeeId()?>
                </select>
            </div>
        </div>
        
    <?php } ?>


     <?php if ($this->role == 1 or $this->role == 21 or $this->role == 31 ){ ?>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">Employee</label>
          <div class="col-lg-3">
                <select name="user" class="form-control m-b" id="user"/>
                         <option value="">-- Select Employee --</option>
                         <?=$this->hr_model->selectEmployee()?>
                </select>
            </div>
        </div>
    <?php } ?>


        <?php } ?>
      	


        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" name="search" type="submit">Search</button> 
            	<?php if($permission->add == 1){ ?>
            	<a href="<?=base_url()?>hr/remoteAccess" class="btn bg-primary ">Remote Access</a>
              <!-- <a href="<?=base_url()?>hr/missingAttendance" class="btn btn-danger ">Missing Attendance</a>-->
               <button class="btn btn-success" onclick="var e2 = document.getElementById('attendance'); e2.action='<?=base_url()?>hr/exportAttendanceLog'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
            	<?php } ?> 
            </div>
        </div> 
        </form>
      </div>
    </section> 
  </div>
</div>


<?php if(isset($_POST['search'])){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Attendance Log
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          
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
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>