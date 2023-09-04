<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
           Employee Balance Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="vacationBalanceFilter" action="<?php echo base_url()?>hr/vacationBalance" method="get" enctype="multipart/form-data">
         <?php 
               if(isset($_REQUEST['year'])){
                    $year = $_REQUEST['year'];
                }else{
                    $year = "";
                }
                if(isset($_REQUEST['employee_name'])){
                    $employee_name = $_REQUEST['employee_name'];
                }else{
                    $employee_name = "";
                }
         ?>
          <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">year</label>

                    <div class="col-lg-3">
                      <input class="form-control" type="text" value = "<?=$year ?>" name="year" autocomplete="off">
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Employee Name</label>

                    <div class="col-lg-3">
                        <select name="employee_name"  class="form-control m-b"/>
                                 <option value="">-- Select Employee --</option>
                                  <?=$this->hr_model->selectEmployee($employee_name)?>
                        </select>
                    </div>
                </div> 
       
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                     <button class="btn btn-success" onclick="var e2 = document.getElementById('vacationBalanceFilter'); e2.action='<?=base_url()?>hr/exportVacationBalance'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
            <a href="<?=base_url()?>hr/vacationBalance" class="btn btn-warning">(x) Clear Filter</a> 

          </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<!-- -->
 <div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Vacation Balance List
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
      <div class="panel-body" style="overflow:scroll;">
        <div class="adv-table editable-table ">
        <div class="clearfix">
            <div class="btn-group">
            <?php if($permission->add == 1){ ?>
                  <a href="<?=base_url()?>hr/addVacationBalance" class="btn btn-primary " style="margin-right: 5rem;"><i class="fa fa-plus" aria-hidden="true"></i> Add New Employee</a>
              </br></br></br>
            <?php } ?>
            </div>
          </div>  
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                    <th>#ID</th>
                    <th>Employee</th>
                    <th>Remaining Balance</th>
                    <th>Previous Year Balance</th>
                    <th>Double Days Balance</th>
                    <th>Annual Leave</th>
                    <th>Casual Leave</th>
                    <th>Sick Leave</th>
                    <th>Marriage</th>
                    <th>Maternity Leave</th>
                    <th>Death Leave</th>
                    <th>Year</th>
                    <th>Edit</th>
                    <th>Delete</th>
              </tr>
            </thead>
           <tbody>
           <?php foreach ($vacation_balance->result() as $row) { ?>
              <tr>  
                 
                   
                    <td><?= $row->id ?></td>
                    <td><?= $this->db->query("SELECT name FROM employees WHERE id = '$row->emp_id'")->row()->name;?></td>
                    <td><?= $row->current_year ?></td>
                    <td><?= $row->previous_year ?></td>
                    <td><?= $row->double_days ?></td>
                    <td><a href="<?php echo base_url()?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=1&search="target="_blank"><?= $row->annual_leave ?></a></td>
                    <td><a href="<?php echo base_url()?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=2&search="target="_blank"><?= $row->casual_leave ?></a></td>
                    <td><a href="<?php echo base_url()?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=3&search="target="_blank"><?= $row->sick_leave ?></a></td>
                    <td><a href="<?php echo base_url()?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=4&search="target="_blank"><?= $row->marriage ?></a></td>
                    <td><a href="<?php echo base_url()?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=5&search="target="_blank"><?= $row->maternity_leave ?></a></td>
                    <td><a href="<?php echo base_url()?>hr/viewVacationRequests?date_from=&date_to=&emp_id=<?= $row->emp_id ?>&type_of_vacation=6&search="target="_blank"><?= $row->death_leave ?></a></td>
                     <td><?= $row->year ?></td>
                   <td>
                      <?php if($permission->edit == 1){ ?>
                         <a href="<?php echo base_url()?>hr/editVacationBalance?i=<?php echo base64_encode($row->id);?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>hr/deleteVacationBalance?i=<?php echo base64_encode($row->id);?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Employee ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
              </tr>
              <?php }?>
                  
            </tbody>
          </table>
          <nav class="text-center">
                         <?=$this->pagination->create_links()?>
                    </nav>
        </div>
      </div>
    </section>
  </div>
</div>