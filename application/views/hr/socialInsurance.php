<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
           Social Insurance Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="socialInsurance" action="<?php echo base_url()?>hr/socialInsurance" method="get" enctype="multipart/form-data">
          <?php 
               if(isset($_REQUEST['insurance_number'])){
                    $insurance_number = $_REQUEST['insurance_number'];
                }else{
                    $insurance_number = "";
                }
                if(isset($_REQUEST['employee_name'])){
                    $employee_name = $_REQUEST['employee_name'];
                }else{
                    $employee_name = "";
                }
         ?>
          <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Employee Name</label>

                    <div class="col-lg-3">
                        <select name="employee_name"  class="form-control m-b"/>
                                 <option value="">-- Select Employee --</option>
                                  <?=$this->hr_model->selectEmployee(0)?>
                        </select>
                    </div>

                     <label class="col-lg-2 control-label" for="role name">Social Insurance Number </label>

                    <div class="col-lg-3">
                      <input class="form-control" type="text" value = "<?= $insurance_number ?>" name="insurance_number" autocomplete="off">
                    </div>
          </div> 
       
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                     <button class="btn btn-success" onclick="var e2 = document.getElementById('socialInsurance'); e2.action='<?=base_url()?>hr/exportSocialInsurance'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
            <a href="<?=base_url()?>hr/socialInsurance" class="btn btn-warning">(x) Clear Filter</a> 

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
        Social Insurance List
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
                  <a href="<?=base_url()?>hr/addSocialInsurance" class="btn btn-primary " style="margin-right: 5rem;"><i class="fa fa-plus" aria-hidden="true"></i> Add Social Insurance</a>
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
                    <th>Year</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Edit</th>
                    <th>Delete</th> 
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
                    <td><?php echo $this->hr_model->getYear($row->year);?></td>
                    <td><?=$row->created_at ?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                         <a href="<?php echo base_url()?>hr/editSocialInsurance?i=<?php echo base64_encode($row->id);?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>hr/deleteSocialInsurance?i=<?php echo base64_encode($row->id);?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Record ?');">
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