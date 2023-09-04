<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Medical Insurance Filter
      </header>

     <?php 

      if(!empty($_REQUEST['employee_id'])){
          $employee_id = $_REQUEST['employee_id'];
          
      }else{
          $employee_id = "";
      }

        ?>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/medicalInsurance" method="get" id="medical_insurance" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Employee Name</label>

                    <div class="col-lg-3">
                        <select name="employee_id"  class="form-control m-b"/>
                                 <option value="">-- Select Employee --</option>
                                  <?=$this->hr_model->selectEmployee(0)?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('medical_insurance'); e2.action='<?=base_url()?>hr/medicalInsurance'; e2.submit();" type="submit">Search</button>
                      <!--<button class="btn btn-success" onclick="var e2 = document.getElementById('structure'); e2.action='<?=base_url()?>hr/exportStructure'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> -->
                      <a href="<?=base_url()?>hr/medicalInsurance" class="btn btn-warning">(x) Clear Filter</a>
                  </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>



<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            
            <header class="panel-heading">
               Medical Insurance
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
                <div class="adv-table editable-table " style="overflow:scroll;">
                    <div class="clearfix">
                        <div class="btn-group">
                        <?php if($permission->add == 1){ ?>
                            <a href="<?=base_url()?>hr/addMedicalInsurance" class="btn btn-primary ">Add New Medical Insurance</a>
                            </br></br></br>
                        <?php } ?>
                        </div>
                        
                    </div>

          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Year</th>
                <th>CRT</th>
                <th>Activation Date</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($medical->num_rows()>0)
              {
                foreach($medical->result() as $row)
                {
                  ?>

                <tr>
                    <td rowspan="2"><?php echo $row->id ;?></td>
                    <td><?php echo $this->hr_model->getEmployee($row->employee_id);?></td>
                    <td><?php echo $this->hr_model->getYear($row->year);?></td>
                    <td><?php echo $row->crt;?></td>
                    <td><?php echo $row->activation_date;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                      <a href="<?php echo base_url()?>hr/editMedicalInsurance?t=<?php echo base64_encode($row->id) ;?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>hr/deleteMedicalInsurance?t=<?=base64_encode($row->id)?>&e=<?=base64_encode($row->employee_id)?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Member?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
              </tr>
              <tr>
                  <td colspan="4">
                     <table class="table table-striped table-hover table-bordered">
                         <thead>
                            <th>ID</th>
                            <th>Member Name</th>
                            <th>Date of Birth</th>
                            <th>Activation Date</th>
                            <th>Type</th>
                            <th>Annual fees</th>
                         </thead>
                         <tbody>   
                <?php 
                  $member = $this->db->get_where('medical_family_members',array('employee_id'=>$row->employee_id));
                  foreach ($member->result() as $member) { 

                  ?>
                      
                               <tr>
                                    <td><?php echo $member->id ;?></td>
                                    <td><?php echo $member->name ;?></td>
                                    <td><?php echo $member->birth_date ;?></td>
                                    <td><?php echo $member->activation_date ;?></td>
                                    <td><?php if($member->type == 1){echo "Supose";}else if($member->type == 2){echo "Child";}?></td>
                                    <td><?php echo $member->fees ;?></td>
                               </tr>
                                <?php } ?>
                             </tbody>
                           </table>
                         </td>
                       </tr>
             <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is no Medical Insurance to list</td></tr><?php
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