<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="row">
  <div class="col-sm-12">
    <section class="panel">
       
      <header class="panel-heading">
        vacation List
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
          <div class="clearfix">
            <div class="btn-group">
            <?php if($permission->add == 1){ ?>
                  <a href="<?=base_url()?>hr/addVacation" class="btn btn-primary " style="margin-right: 5rem;">Add New Vacation Request</a>
              <?php if($permission->role == 31 || $permission->role == 21 ||$permission->role == 46){ ?>
                  <a href="<?=base_url()?>hr/addVacationForEmployees" class="btn btn-info " style="margin-right: 5rem;">Add New Vacation For Employees</a>
       
            <?php }} ?>
                    </br></br></br>
            </div>
          </div> 

          
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
        
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Direct Manager</th>
                <th>Type of vacation</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($vacation->result() as $row) { ?>
                  <tr class="">
                    <td><?= $row->id ;?></td>
                    <td><?= $this->hr_model->getEmpName($row->emp_id) ;?></td>
                    <td><?= $this->hr_model->getEmpName($this->hr_model->getManagerId($this->emp_id)) ;?></td>                  
                    <td><?= $this->hr_model->getAllVacationTypies($row->type_of_vacation) ;
                        if($row->requested_days == 0.5){?>
                            <span class="badge badge-default p-2">½ Day</span>
                        <?php }?></td>
                    <td><?= $row->start_date;?></td>
                    <td><?= $row->end_date;?></td>
                    <td><?= $this->hr_model->getVacationStatus($row->status);?></td>
                      <td><?php if($row->status == 0){ ?> <a href="<?php echo base_url()?>hr/editVacationRequest?i=<?php echo base64_encode($row->id);?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a><?php } ?></td>
                      <td><?php if($row->status == 0){ ?> <a href="<?php echo base_url()?>hr/deleteVacationRequest?i=<?php echo base64_encode($row->id);?>" class="">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a><?php } ?></td>
                  </tr>
                      <?php } ?>          
            </tbody>
          </table>
          
        </div>
    </section>
  </div>
</div>

<!-- requests view for parent -->

<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <header class="panel-heading">
        <button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button> 
        Vacation Requests List <span class="numberCircle"><span><?=$requests->num_rows()?></span></span>
      </header>
      
      <div id="filter"  style="display: none;" class="panel-body" >
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>

              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Direct Manager</th>
                <th>Type of vacation</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Manager Approval</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($requests->result() as $request) { 
                 if($request->status == 0){ 
                ?>
                  <tr class="">
                    <td><?= $request->id ;?></td>
                    <td><?= $this->hr_model->getEmpName($request->emp_id) ;?></td>
                    <td><?= $this->hr_model->getEmpName($this->hr_model->getManagerId($request->emp_id));?></td>
                    <td><?= $this->hr_model->getAllVacationTypies($request->type_of_vacation) ; 
                    if($request->requested_days == 0.5){?>
                            <span class="badge badge-default p-2"> ½ Day</span>
                        <?php }?>
                    </td>
                    <td><?= $request->start_date;?></td>
                    <td><?= $request->end_date;?></td>
                    <td><?=$this->hr_model->getVacationStatus($request->status);?></td>
                    <td> 
                        <?php if($this->hr_model->checkThisUserIsEmployeeManager($request->emp_id)){?> 
                        <a href="<?php echo base_url()?>hr/responseToVacation?i=<?php echo base64_encode($request->id);?>" class="">
                            <i class="fa fa-pencil"></i> Take Action
                          </a>
                       <?php }?>
                    </td>

                  </tr>
                      <?php } } ?>          
            </tbody>
          </table>
          
        </div>
    </section>
  </div>
</div>
<!-- -->