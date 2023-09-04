<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
           Vacation Requests Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="viewVacationRequests" action="<?php echo base_url()?>hr/viewVacationRequests" method="get" enctype="multipart/form-data">
          <?php  
                 if(isset($_REQUEST['emp_id'])){
                    $emp_id = $_REQUEST['emp_id'];
                }else{
                    $emp_id = "";
                }
          ?> 
          
              <div class="form-group">
                <label class="col-lg-2 control-label" for="role date">Date From</label>
                <div class="col-lg-3">
                     <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                </div>
                <label class="col-lg-2 control-label" for="role date">Date To</label>
                <div class="col-lg-3">
                     <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                </div>
              </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="role name">Employee Name</label>

                      <div class="col-lg-3">
                          <select name="emp_id"  class="form-control m-b"/>
                                   <option value="">-- Select Employee --</option>
                                    <?=$this->hr_model->selectEmployee($emp_id)?>
                          </select>
                      </div>
                       <label class="col-lg-2 control-label" for="role name">Vacation Type</label>

                      <div class="col-lg-3">
                          <select name="type_of_vacation"  class="form-control m-b"/>
                                   <option value="">-- Select Vacation Type --</option>
                                    <?=$this->hr_model->selectAllVacationTypies()?>
                          </select>
                      </div>
              </div>
       
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                     <button class="btn btn-success" onclick="var e2 = document.getElementById('viewVacationRequests'); e2.action='<?=base_url()?>hr/exportViewVacationRequests'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
            <a href="<?=base_url()?>hr/viewVacationRequests" class="btn btn-warning">(x) Clear Filter</a> 

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
        Vacation Requests List
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
       
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                    <th>#ID</th>
                    <th>Employee</th>
                    <th>Direct Manager</th>
                    <th>Type of vacation</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Sick Leave Document</th>
                    <th>Requested Days</th>
                    <th>Status</th>
                    <th>Reject</th>
                    <th>edit</th>
                    <th>Created At</th>
              </tr>
            </thead>
           <tbody>
            <?php foreach($vacation_requests->result() as $row) { ?>
                  <tr class="">
                    <td><?= $row->id ;?></td>
                    <td><?= $this->hr_model->getEmpName($row->emp_id) ;?></td>
                    <td><?= $this->hr_model->getEmpName($this->hr_model->getManagerId($row->emp_id)) ;?></td>
                    <td><?= $this->hr_model->getAllVacationTypies($row->type_of_vacation) ;?></td>
                    <td><?= $row->start_date;?></td>
                    <td><?= $row->end_date;?></td>
                    <td><?php if(strlen($row->sick_leave_file) > 1){ ?><a href="<?=base_url()?>assets/uploads/sickLeaveDocument/<?=$row->sick_leave_file?>" target="_blank">Click Here</a><?php } ?></td>
                    <td><?= $row->requested_days;?></td>
                    <td><?= $this->hr_model->getVacationStatus($row->status);?></td>

                    <!-- reject -->
                     <?php  if($row->status == 1 ){ ?> 

                    <td rowspan="" style="border: 1px solid #ddd;"><a href="#myModal1<?php echo $row->id ?>" data-toggle="modal" class="btn btn-danger" >Reject</a></td>
                    <?php }else{ ?>
               <td></td>
                  <?php } ?> 
                    <!-- -->
                     <!-- edit -->
                     <?php  if($row->type_of_vacation == 1 or $row->type_of_vacation == 2){ 
                      ?> 
                    <td rowspan="" style="border: 1px solid #ddd;"><a href="#myModal2<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success" >Edit</a></td>
                  <?php }else{ ?>
               <td></td>
                  <?php } ?> 
                    <!-- -->

                    <td><?= $row->created_at;?></td>
                  </tr>

                  <!-- start pop up form reject -->
        <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="myModal1<?php echo $row->id;?>" class="modal fade">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                         <h4 class="modal-title">Reject Request</h4>
                     </div>
                     <div class="modal-body">
        <div class="form">
            <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/rejectApprovedRequest" method="post" name="rejectApprovedRequest" enctype="multipart/form-data">
                       <input name="row_id" type="hidden" value="<?php echo $row->id;?>" >
                       <input name="emp_id" type="hidden" value="<?php echo $row->emp_id;?>" >
                       <input name="days" type="hidden" value="<?php echo $row->requested_days;?>" > 
                      <input name="type_of_vacation" type="hidden" value="<?php echo $row->type_of_vacation;?>" >

                           <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary"name="save" type="submit">Reject</button> 
                                    <a href="<?php echo base_url()?>hr/viewVacationRequests" class="btn btn-danger" type="button">Cancel</a>
                                </div>
                            </div>
                    </div>
                            
                        </form> 
               </div>
               </div>
             </div>
           </div>
         </div>
            <!-- end pop up form -->
            <!-- start pop up form for edit -->
        <div aria-hidden="true" aria-labelledby="myModalLabel2" role="dialog" tabindex="-1" id="myModal2<?php echo $row->id;?>" class="modal fade">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                         <h4 class="modal-title">Edit</h4>
                     </div>
                     <div class="modal-body">
         <div class="form">
            <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/editApprovedRequest" method="post" name="editApprovedRequest" enctype="multipart/form-data">
                       <input name="row_id" type="hidden" value="<?php echo $row->id;?>" >
                       <input name="emp_id" type="hidden" value="<?php echo $row->emp_id;?>" >
                       <input name="days" type="hidden" value="<?php echo $row->requested_days;?>" >
                     <div class='form-group'>
                                <label class='col-lg-4 control-label' for='inputPassword'>Type Of Vacation</label>
                                <div class='col-lg-8'>
                                    <select name='type_of_vacation'class='form-control m-b'id="type_of_vacation"value="" required="">
                                        <?php  if($row->type_of_vacation == 1){ ?>
                                        <option value="1" selected=''>Annual</option>
                                        <option value="2">Casual</option>
                                      <?php }elseif($row->type_of_vacation == 2){ ?>
                                         <option value="2"selected=''>Casual</option>
                                         <option value="1" >Annual</option>
                                      <?php } ?>
                                     </select>
                                </div> 
                            </div> 
                           <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary"name="save" type="submit">Save</button> 
                                </div>
                            </div>
                    </div>
                            
                        </form> 
               </div>
             </div>
           </div>
         </div>
            <!-- end pop up form -->
               <?php } ?>  
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