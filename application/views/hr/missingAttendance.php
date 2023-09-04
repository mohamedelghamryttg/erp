<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
         Missing Attendance Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="missingAttendance" action="<?php echo base_url()?>hr/missingAttendance" method="get" enctype="multipart/form-data">
         <?php 
               
                if(isset($_REQUEST['employee_name'])){
                    $employee_name = $_REQUEST['employee_name'];
                }else{
                    $employee_name = "";
                }
         ?>
          <div class="form-group">
                       <label class="col-lg-2 control-label" for="role date">Date</label>

                        <div class="col-lg-3">
                             <input class="form-control date_sheet" type="text" class="datepicker form-control"name="date" autocomplete="off">
                        </div>
                    <?php if($this->role == 31 || $this->role == 46){ ?>

                    <label class="col-lg-2 control-label" for="role name">Employee Name</label>

                    <div class="col-lg-3">
                        <select name="employee_name"  class="form-control m-b"/>
                                 <option value="">-- Select status --</option>
                                  <?=$this->hr_model->selectEmployee($employee_name)?>
                        </select>
                    </div>
                </div> 
      <?php } ?>
                <div class="form-group" style="padding-top: 50px">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                     <a href="<?=base_url()?>hr/missingAttendance" class="btn btn-warning">(x) Clear Filter</a>

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
        Missing Attendance List
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
                  <a href="<?=base_url()?>hr/addmissingAttendance" class="btn btn-primary " style="margin-right: 5rem;"><i class="fa fa-plus" aria-hidden="true"></i> Add Missing Access Request</a>
             
            <?php } if($this->role == 31 || $this->role == 46){?>
                  <a href="<?=base_url()?>hr/addMissingAttendanceForEmployee" class="btn btn-info " style="margin-right: 5rem;"><i class="fa fa-user" aria-hidden="true"></i> Add Missing Access For Employee</a>
             
            <?php } ?>
                   </br></br></br>
            </div>
          </div>  
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>             
                     <th>ID</th>
                     <th>Employee ID</th>
                     <th>Employee Name</th>
                     <th>Date </th>
                     <th>Sign In/Out</th>
                      <th>Location</th>
                     <th>Created At</th>
                     <th>Manager Approval</th>
<!--                     <th>Hr Approval</th>-->
                     <th>Edit</th>
                     <th>Delete</th>
              </tr>
            </thead>
           <tbody>
            <?php
              foreach($missingAttendance->result() as $row)
                {
            ?>
              <tr>
                <td><?=$row->id ?></td>
                <td><?=$row->USRID ?></td>
                <td><?=$this->hr_model->getEmployee($row->USRID)?></td>
                <td><?= $row->SRVDT?></td>
                  <?php if($row->TNAKEY == 1){ ?>
                      <td><?php echo "Sign In";?></td>
                  <?php }elseif($row->TNAKEY == 2){?>
                     <td><?php echo "Sign Out";?></td>
                   <?php }?>
                      <td><?= $this->hr_model->getLocationType($row->location)?></td>
                <td><?= $row->created_at?></td>
                      <td><?=$this->hr_model->getVacationStatus($row->manager_approval);?></td>
                      <!--<td><?=$this->hr_model->getVacationStatus($row->hr_approval);?></td>-->
                 <td>
                      <?php if($permission->edit == 1){ ?>
                          <?php if ($row->manager_approval == 0 ){ ?>
                           <a href="<?php echo base_url()?>hr/editMissingAttendance?i=<?php echo base64_encode($row->id);?>" class="">
                            <i class="fa fa-pencil"></i> Edit
                          <?php } ?> 
                        
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                        <?php if ($row->manager_approval == 0){ ?>
                  <a href="<?php echo base_url()?>hr/deleteMissingAttendance?i=<?php echo base64_encode($row->id);?>" title="delete" 
                  class="" onclick="return confirm('Are you sure you want to delete this Employee ?');">
                         <i class="fa fa-times text-danger text"></i> Delete

                        <?php } ?> 
                      </a>
                      <?php } ?>
                    </td>
              </tr>
              <?php
                }
            ?>    
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
 <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>