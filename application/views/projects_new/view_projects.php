
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              	<!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title btn_lightgray">
                      <h3 class="card-label">Your Projects From SAM - <span class="btn btn-danger"><span><?=$opportunity->num_rows()?></span></span></h3> 
                       <button id="button_filter2" onclick="showAndHide('filter2','button_filter2');" style="padding-top:0pc; float: right;font-size: 15px;" class="btn btn-success "><i class="fa fa-chevron-down"></i></button>
                    </div>
                    <div class="card-toolbar">
                     
                    
                    </div>
                  </div>
                  <div class="card-body" id="filter2">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-filter table-head-custom table-checkable table-hover">
                      <thead>
               <tr>
                       <th>Project Name</th>
                       <th>Client</th>
                       <th>Assigned Date</th>
                       <th>SAM</th>
                       <th>Save</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($opportunity->num_rows() > 0)
              {
                foreach($opportunity->result() as $row)
                {
                  ?>
                  <tr class="">

                      <td><?php echo $row->project_name?></td>
                      <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                      <td><?php echo $row->assigned_at;?></td>
                      <td><?php echo $this->admin_model->getAdmin($row->created_by);?></td>
                      <td><a href="<?php echo base_url()?>projects/saveProject?t=<?php echo 
                      base64_encode($row->id) ;?>" class="">
                        <i class="fa fa-pencil"></i> View Project
                      </a></td>
                  </tr>
                  <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is no new projects to you </td></tr><?php
              }
              ?>                
            </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
				
              <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title btn_lightgray">
                      <h3 class="card-label">Projects Filter</h3> 
                       <button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;font-size: 15px;" class="btn btn-success "><i class="fa fa-chevron-down"></i></button>
                    </div>
                    <div class="card-toolbar">
                     
                    
                    </div>
                  </div>
                  <div class="card-body" id="filter">
                    
                    <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">Search Projects</h3>
          </div>
      <?php 
      if(!empty($_REQUEST['code'])){
                    $code = $_REQUEST['code'];
                }else{
                    $code = "";
                }
                if(!empty($_REQUEST['name'])){
                    $name = $_REQUEST['name'];
                }else{
                    $name = "";
                }
                if(!empty($_REQUEST['customer'])){
                    $customer = $_REQUEST['customer'];
                }else{
                    $customer = "";
                }
                if(!empty($_REQUEST['product_line'])){
                    $product_line = $_REQUEST['product_line'];
                }else{
                    $product_line = "";
                }
                if(!empty($_REQUEST['status'])){
                    $status = $_REQUEST['status'];
                }else{
                    $status = "";
                }
                if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                }else{
                    $date_to = "";
                    $date_from = "";
                }
      ?>

            <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects" method="get" enctype="multipart/form-data">
             <div class="card-body">
              <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role name">Project Code</label>
                <div class="col-lg-3">
                     <input type="text" class="form-control" name="code" value="<?=$code?>">
                </div>
                 <label class="col-lg-2 control-label text-lg-right" for="role name">Project Name</label>
                <div class="col-lg-3">
                   <input type="text" class="form-control" name="name" value="<?=$name?>">
               </div>
              </div>
             <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role date">Client</label>
                <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer" />
                                 <option value=""  disabled="disabled" selected="selected">-- Select Client --</option>
                                 <?=$this->customer_model->selectCustomerByPm($customer,$this->user,$permission,$this->brand)?>
                        </select>
                </div>
                <label class="col-lg-2 control-label text-lg-right" for="role date">Product Line</label>
                <div class="col-lg-3">
                        <select name="product_line" class="form-control m-b" id="product_line" />
                                <option value=""  disabled="disabled" selected="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine($product_line,$this->brand)?>
                        </select>
                </div>
                 </div>
                 <div class="form-group row">
                <label class="col-lg-2 control-label text-lg-right" for="role date">Status</label>
                <div class="col-lg-3">
                        <select name="status" class="form-control m-b" id="status" />
                                <option value="">-- Select Status --</option>
                            <?php 
                            if($_REQUEST['status'] == 2 ){?>
                            <option selected="" value = "<?=$_REQUEST['status']?>">Running</option>
                            <option value = "1">Closed</option>   
                            <?php }elseif($_REQUEST['status'] == 1){ ?>
                            <option selected="" value = "<?=$_REQUEST['status']?>">Closed</option>
                            <option value = "2">Running</option>
                            <?php }else{?>
                            <option value="2">Running</option>
                            <option value="1">Closed</option>
                             <?php }?>
                      </select>
                </div>
                 </div>
                 <div class="form-group row">
                 <label class="col-lg-2 control-label text-lg-right" for="role date">Date From</label>
                <div class="col-lg-3">
                        <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                </div>
                <label class="col-lg-2 control-label text-lg-right" for="role date">Date To</label>
                <div class="col-lg-3">
                       <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                </div>

              </div>
            
</div>
             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-primary" name="search" type="submit">Search</button> 
                           <a href="<?=base_url()?>projects" class="btn btn-warning">(x) Clear Filter</a>

                         

               </div>
              </div>
             </div>
            </form>
                       </div>
                        
              <!-- end search form -->

                  </div>
</div>
                <!--end::Card--> 
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
          		<!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Projects List <span class="btn btn-danger"><span><?=$total_rows?></span></span></h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>projects/addProject" class="btn btn-primary font-weight-bolder"> 
                      <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>Add New Project</a>
                      <?php } ?>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                <tr>
                <th>ID</th>
                <th>Project Code</th>
                <th>Project Name</th>
                <th>Client</th>
                <th>Product Line</th>
                <th>Status</th>
                <th>View Tickets</th>
                <th>Opportunity No</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit </th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($project->result() as $row) { 
            ?>
              <tr>
                <td><?php echo $row->id ;?></td>
                <td><a href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
                <td><?php echo $row->name ;?></td>
                <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                <td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
                                <td>
                  <?=$this->projects_model->getNewProjectStatus($row->status,$row->id)?>
                </td>
                                <td>
                                <?php if($row->status == 0){ ?>
                  <a class="btn btn-primary" href="<?php echo base_url()?>vendor/vmPmTicket?t=<?php echo base64_encode($row->id); ?>" title="View Tickets" style="color:#fff">View Tickets</a>
                <?php } ?>
                </td>
                              <td><?php echo $row->opportunity ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td>
                  <?php if($permission->edit == 1 && $row->status == 0){ ?>
                  <a href="<?php echo base_url()?>projects/editProject?t=<?php echo 
                  base64_encode($row->id) ;?>" class="">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if($permission->delete == 1 && $row->status == 0){ ?>
                  <a href="<?php echo base_url()?>projects/deleteProject?t=<?php echo 
                  base64_encode($row->id) ;?>" title="delete" 
                  class="" onclick="return confirm('Are you sure you want to delete this Project ?');">
                    <i class="fa fa-times text-danger text"></i> Delete
                  </a>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
            </tbody>
                    </table>
                    <!--end: Datatable-->
                  	<!--begin::Pagination-->
         <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <?=$this->pagination->create_links()?>  
                  </div>
              <!--end:: Pagination-->
                  </div>
                </div>
                <!--end::Card-->
              </div>
          </div>
		</div>
<script>
   window.realAlert = window.alert;
   window.alert = function() {};
</script>

