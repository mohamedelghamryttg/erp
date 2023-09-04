  <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title btn_lightgray">
                            <button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark">
                              <i class="fa fa-chevron-down"></i>
                            </button>
                            <h5 class="card-label">Birthsdays This Month <span class="btn btn-danger"><span><?=$birthdayData->num_rows()?></span></span><img src="https://www.animatedimages.org/data/media/296/animated-festivity-and-celebration-image-0166.gif" style="padding:5px;width:60px;height:60px;"></h5>
                    </div>
                    <div class="card-toolbar">
                     
                    
                    </div>
                  </div>
                  <div class="card-body" id="filter" style="overflow:scroll; display: none;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="">
                      <thead>
              <tr>
              <th> Name</th>
              <th>Birth Date</th>
              </tr>
            </thead>
            
            <tbody>
              <?php
              if($birthdayData->num_rows() > 0)
              {
                foreach($birthdayData->result() as $row)
                {
                  ?>
                  <tr class="">

                        <td><?php echo $row->name;?></td>
                        <td><?php echo $row->birth_date;?></td>                                     
                  </tr>
                  <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is No Bitrth Days This Month  </td></tr><?php
              }
              ?>                
            </tbody>
          </table>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
                <!--begin::Card-->

            <div class="card-body" id="filter">
                    
                    <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">Search Employees</h3>
          </div>
 <?php 
                if(!empty($_REQUEST['name'])){
                    $name = $_REQUEST['name'];
                    
                }else{
                    $name = "";
                }

                if(!empty($_REQUEST['title'])){
                    $title = $_REQUEST['title'];
                   
                }else{
                    $title = "";
                }

                if(!empty($_REQUEST['division'])){
                    $division = $_REQUEST['division'];
                    
                }else{
                    $division = "";
                }

                if(!empty($_REQUEST['department'])){
                    $department = $_REQUEST['department'];
                    
                }else{
                    $department = "";
                }

                if(!empty($_REQUEST['status'])){
                    $status = $_REQUEST['status'];
                    
                }else{
                    $status = "";
                }
                ?>
      

            <form class="form"id="employees" action="<?php echo base_url()?>hr/employees" method="get" enctype="multipart/form-data">
             <div class="card-body">
              <div class="form-group row">
                <label class="col-lg-2 control-label" for="role name">Name</label>
                <div class="col-lg-3">
                     <input type="text" class="form-control" value="<?=$name?>" name="name"> 
                </div>
                 <label class="col-lg-2 control-label" for="role name">Position</label>
                <div class="col-lg-3">
                        <select name="title" class="form-control m-b" id="title"/>
                                 <option value="">-- Select Title --</option>
                                 <?=$this->hr_model->selectTitle($title)?>
                        </select>
               </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-2 control-label" for="role name">Division</label>
                <div class="col-lg-3">
                        <select name="division" onchange="getDepartment()" class="form-control m-b" id="division" />
                                 <option value="">-- Select Division --</option>
                                 <?=$this->hr_model->selectDivision($division)?>
                        </select> 
                </div>
                 <label class="col-lg-2 control-label" for="role name">Function</label>
                <div class="col-lg-3">
                        <select name="department" class="form-control m-b" id="department"/>
                                <option disabled="disabled" selected=""></option>
                                <?=$this->hr_model->selectDepartment($department)?>
                        </select>
               </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 control-label" for="role name">Employee Status</label>
                <div class="col-lg-3">
                        <select name="status" onchange="showResignedSearch()" class="form-control m-b" id="status" />
                                 <option value="">-- Select Status --</option>
                      <?php 
                                if($_REQUEST['status'] != NULL && $_REQUEST['status'] == 0 ){?>
                                <option selected="" value = "0">Working</option>
                                 <option value="1">Resigned</option>
                                 <?php }elseif($_REQUEST['status'] != NULL && $_REQUEST['status'] == 1){ ?>
                                <option value="0">Working</option>
                                 <option selected="" value = "1">Resigned</option>
                    <?php }else{?>
                                <option value="0">Working</option>
                                <option value="1">Resigned</option>
                     
                    <?php }?>
                        </select>
               </div>
              </div>

             <div class="form-group row" style="display: none;" id="resignedSearch">
                <label class="col-lg-2 control-label" for="role date">Resigned From</label>
                <div class="col-lg-3">
                    <input class="form-control date_sheet" type="text" name="resigned_from" autocomplete="off"> 
                </div>
                <label class="col-lg-2 control-label" for="role date">Date To :</label>
                <div class="col-lg-3">
                     <input class="form-control date_sheet" type="text" name="resigned_to" autocomplete="off">
                </div>
              </div>
            

             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search" type="submit">Search</button>   
                           <button class="btn btn-secondary" onclick="var e2 = document.getElementById('employees'); e2.action='<?=base_url()?>hr/exportEmployees'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                         <a href="<?=base_url()?>hr/employees" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

                         

               </div>
              </div>
             </div>
            </form>
                       </div>
                        
              <!-- end search form -->

                  </div>
                </div>
                <!--end::Card--> 
  <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Employees</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>hr/addEmployees" class="btn btn-primary font-weight-bolder"> 
                      <?php } ?>
                      <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>Add New Employee</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                      
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>National ID/Passport ID</th>
                <th>Brand</th>
                <th>Division</th>
                <th>Function</th>
                <th>Position</th>
                <th>Direct Manager</th>
                <th>Time Zone</th>
                <th>Office Location</th>
                <th>Hiring Date</th>
                <th>Probationay Period</th>
                <th>Contract Date</th>
                <th>Contract Type</th>
                <th>Employee Status</th>
                <th>Resignation Date</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Emergency Contact</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
                
              </tr>
            </thead>
            
            <tbody>
              <?php
              if(($employees->num_rows())>0)
              {
                foreach($employees->result() as $row)
                {
                  ?>
                  <tr class="">
                    <td><?php echo $row->id ;?></td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->birth_date;?></td>
                    <td><?php if($row->gender == 1){echo "Male";}else{echo "Female";}?></td>
                    <td><?php echo $row->national_id;?></td>
                    <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td>
                    <td><?php echo $this->hr_model->getDivision($row->division);?></td>
                    <td><?php echo $this->hr_model->getDepartment($row->department);?></td>
                    <td><?php echo $this->hr_model->getTitle($row->title);?></td>
                    <td><?php echo $this->hr_model->getEmployee($row->manager);?></td>
                    <td><?php echo $row->time_zone;?></td>
                    <td><?php echo $row->office_location;?></td>
                    <td><?php echo $row->hiring_date;?></td>
                    <td><?php echo $row->prob_period;?></td>
                    <td><?php echo $row->contract_date;?></td>
                    <td><?php if($row->contract_type == 1){echo "Full Time";}else if($row->contract_type == 2){echo "Part Time";}?></td>
                    <td><?php if($row->status == 0){echo "Working";}else if($row->status == 1){echo "Resigned";}?></td>
                    <td><?php echo $row->resignation_date;?></td>
                    <td><?php echo $row->email;?></td>
                    <td><?php echo $row->phone;?></td>
                    <td><?php echo $row->emergency;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                      <a href="<?php echo base_url()?>hr/editEmployees?t=<?php echo base64_encode($row->id) ;?>"class="btn btn-sm btn-clean btn-icon">
                        <i class="la la-edit"></i>
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>hr/deleteEmployees/<?php echo $row->id ?>" title="delete" 
                      class="btn btn-sm btn-clean btn-icon"  onclick="return confirm('Are you sure you want to delete this Employee?');">
                        <i class="la la-trash"></i>
                      </a>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is no Employee to list</td></tr><?php
              }
              ?>                
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
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->
          <script type="text/javascript">
  
 function showResignedSearch(){
  
     $('#resignedSearch').show();

  }
</script>