  
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">           
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
               <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success" role="alert">
          <span class="fa fa-check-circle"></span>
          <span><strong>
              <?= $this->session->flashdata('true') ?>
            </strong>
          </span>
        </div>
      <?php } ?>
      <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
          <span class="fa fa-warning"></span>
          <span><strong>
              <?= $this->session->flashdata('error') ?>
            </strong>
          </span>
        </div>
      <?php } ?>
            
            <!--begin::Card--> 
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header flex-wrap border-0 py-0">
                    <div class="card-title btn_lightgray">                          
                        <h5 class="card-label">BirthDays This Month <span class="btn btn-light-danger btn-sm"><span><?= $birthdayData->num_rows() ?></span></span><img src="https://www.animatedimages.org/data/media/296/animated-festivity-and-celebration-image-0166.gif" style="padding:5px;width:60px;height:60px;"></h5>
                    </div>
                    <div class="card-toolbar">
                        <button id="button_filter" onclick="showAndHide('filter', 'button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark border-0">
                            <i class="fa fa-chevron-down"></i>
                        </button>                    
                    </div>
                </div>
                <div class="card-body" id="filter" style="overflow:scroll; display: none;">
                    <!--begin: Datatable-->
                    <table class="table table-head-custom " id="">
                        <thead>
                            <tr>
                                <th> Name</th>
                                <th>Birth Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($birthdayData->num_rows() > 0) {
                                foreach ($birthdayData->result() as $row) {
                                    ?>
                                    <tr class="">

                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo $row->birth_date; ?></td>                                     
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="7">There is No Birth Days This Month  </td></tr>
<?php } ?>                
                        </tbody>
                    </table>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
            <!--begin::Card--> 
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header flex-wrap border-0 py-1 ">
                    <div class="card-title btn_lightgray">                          
                        <h5 class="card-label"> Contracts Notifications <span class="btn btn-light-success btn-sm ">
                                <?= $contractData->num_rows() ?>
                            </span></h5>
                    </div>
                    <div class="card-toolbar">
                        <button id="button_contract" onclick="showAndHide('contract', 'button_contract');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark border-0">
                            <i class="fa fa-chevron-down"></i>
                        </button>                    
                    </div>
                </div>
                <div class="card-body" id="contract" style="overflow:scroll; display: none;">
                    <!--begin: Datatable-->
                    <table class="table table-head-custom " id="">
                        <thead>
                            <tr>
                                <th> Name</th>
                                <th>Contract Date</th>
                                <th>Num. Of Days Left</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($contractData->num_rows() > 0) {
                                foreach ($contractData->result() as $row) {
                                    ?>
                                    <tr class="">

                                        <td>
                                            <?php echo $row->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->contract_date; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->days; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">There is No Contracts Coming In Next 10 Days </td>
                                </tr>
                                <?php
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
            <!-- start search form card --> 
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h6 class="card-title"> Employees Filter</h6>
                    </div>
 <?php
      if (!empty($_REQUEST['name'])) {
        $name = $_REQUEST['name'];

      } else {
        $name = "";
      }

      if (!empty($_REQUEST['title'])) {
        $title = $_REQUEST['title'];

      } else {
        $title = "";
      }

      if (!empty($_REQUEST['division'])) {
        $division = $_REQUEST['division'];

      } else {
        $division = "";
      }

      if (!empty($_REQUEST['department'])) {
        $department = $_REQUEST['department'];

      } else {
        $department = "";
      }

      if (!empty($_REQUEST['status'])) {
        $status = $_REQUEST['status'];

      } else {
        $status = "";
      }
      if (!empty($_REQUEST['date_from'])) {
        $date_from = $_REQUEST['date_from'];

      } else {
        $date_from = "";
      }
      if (!empty($_REQUEST['date_to'])) {
        $date_to = $_REQUEST['date_to'];

      } else {
        $date_to = "";
      }
      ?>          
        <form class="form"id="employees" action="<?php echo base_url() ?>hr/employees" method="get" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 control-label" for="role name">Name</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" value="<?= $name ?>" name="name"> 
                    </div>
                    <label class="col-lg-2 control-label text-right" for="role name">Position</label>
                    <div class="col-lg-3">
                        <select name="title" class="form-control m-b" id="title"/>
                        <option value="">-- Select Title --</option>
                                <?= $this->hr_model->selectTitle($title) ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 control-label" for="role name">Division</label>
                    <div class="col-lg-3">
                        <select name="division" onchange="getDepartment()" class="form-control m-b" id="division" />
                        <option value="">-- Select Division --</option>
                        <?= $this->hr_model->selectDivision($division) ?>
                        </select> 
                    </div>
                    <label class="col-lg-2 control-label text-right" for="role name">Function</label>
                    <div class="col-lg-3">
                        <select name="department" class="form-control m-b" id="department"/>
                        <option disabled="disabled" selected=""></option>
                        <?= $this->hr_model->selectDepartment($department) ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 control-label" for="role name">Employee Status</label>
                    <div class="col-lg-3">
                        <select name="status" onchange="showResignedSearch()" class="form-control m-b" id="status" />
                        <option value="">-- Select Status --</option>
                                <?php
                          if ($_REQUEST['status'] != NULL && $_REQUEST['status'] == 0) { ?>
                            <option selected="" value="0">Working</option>
                            <option value="1">Resigned</option>
                          <?php } elseif ($_REQUEST['status'] != NULL && $_REQUEST['status'] == 1) { ?>
                            <option value="0">Working</option>
                            <option selected="" value="1">Resigned</option>
                          <?php } else { ?>
                            <option value="0">Working</option>
                            <option value="1">Resigned</option>

                          <?php } ?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label text-right" for="role name">Social Insurance</label>
                    <div class="col-lg-3">
                         <select name="social_ins" class="form-control m-b" id="social_ins">
                        <option disabled="disabled" selected="">-- Select --</option>
                        <option value="1" <?= isset($social_ins) && $social_ins == '1' ? "selected" : '' ?>>Yes</option>
                        <option value="0" <?= isset($social_ins) && $social_ins == '0' ? "selected" : '' ?>>No</option>

                      </select>
                    </div>
                </div>
                <?php if(!empty($date_to)||!empty($date_from)){
                            $display = "flex";
                        }else{
                          $display ="none";  
                        }
                    ?>
                <div class="form-group row" style="display: <?=$display?>;" id="resignedSearch">
                    <label class="col-lg-2 control-label" for="role date">From</label>
                    <div class="col-lg-3">
                        <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value="<?= isset($date_from)?$date_from:''?>"> 
                    </div>
                    <label class="col-lg-2 control-label text-right" for="role date">Date To :</label>
                    <div class="col-lg-3">
                        <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" value="<?= isset($date_to)?$date_to:''?>">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10">
                            <button class="btn btn-success mr-2" name="search" type="submit">Search</button>   
                            <button class="btn btn-secondary" onclick="var e2 = document.getElementById('employees'); e2.action = '<?= base_url() ?>hr/exportEmployees'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                            <a href="<?= base_url() ?>hr/employees" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

                        </div>
                    </div>
                </div>                   
            </div>
        </form>
        <!-- end search form -->           
        </div>
        <!--end::Card--> 
        <!--begin::Card-->
        <div class="card">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Employees <span class="font-size-lg text-dark-50 font-weight-bold"> | <?=$total_rows?></span></h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
<?php if ($permission->add == 1) { ?>
                        <a href="<?= base_url() ?>hr/addEmployees" class="btn btn-primary font-weight-bolder"> 
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
                <div class="table-responsive">
                <table class="table table-bordered table-hover table-checkable table-head-custom table-foot-custom" id="kt_datatable2" >
                    <thead>
                        <tr>
                <th colspan="6" class="bg-info-o-90 text-center"style="color:white!important">Employee Data</th>
                <th colspan="15" class="bg-info-o-60 text-center"style="color:white!important">Positioning Data </th>
                <th colspan="3" class="bg-info-o-40 text-center"style="color:white!important">Communication info</th>
                <th colspan="4" class="bg-light-dark text-center"></th>
              </tr>
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
                <th>Workplace Model</th>
                <th>Employee Status</th>
                <th>Resignation Date</th>
                <th>Resignation Reason</th>
                <th>Resignation Comment</th>
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
              if (($employees->num_rows()) > 0) {
                foreach ($employees->result() as $row) {
                  ?>
                  <tr class="">
                    <td>
                      <?php echo $row->id; ?>
                    </td>
                    <td>
                      <?php echo $row->name; ?>
                    </td>
                    <td>
                      <?php echo $row->birth_date; ?>
                    </td>
                    <td>
                      <?php if ($row->gender == 1) {
                        echo "Male";
                      } else {
                        echo "Female";
                      } ?>
                    </td>
                    <td>
                      <?php echo $row->national_id; ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getBrand($row->emp_brands); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDivision($row->division); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getDepartment($row->department); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getTitle($row->title); ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getEmployee($row->manager); ?>
                    </td>
                    <td>
                      <?php echo $row->time_zone; ?>
                    </td>
                    <td>
                      <?php echo $row->office_location; ?>
                    </td>
                    <td>
                      <?php echo $row->hiring_date; ?>
                    </td>
                    <td>
                      <?php echo $row->prob_period; ?>
                    </td>
                    <td>
                      <?php echo $row->contract_date; ?>
                    </td>
                    <td>
                      <?php if ($row->contract_type == 1) {
                        echo "Full Time";
                      } else if ($row->contract_type == 2) {
                        echo "Part Time";
                      } ?>
                    </td>
                    <td>
                      <?= $row->workplace_model; ?>
                    </td>
                    <td>
                      <?php if ($row->status == 0) {
                        echo "Working";
                      } else if ($row->status == 1) {
                        echo "Resigned";
                      } ?>
                    </td>
                    <td>
                      <?php echo $row->resignation_date; ?>
                    </td>
                    <td>
                      <?php echo $this->hr_model->getResignationReason($row->resignation_reason); ?>
                    </td>
                    <td>   
                        <?php if($row->resignation_comment != null && str_word_count($row->resignation_comment)>10 )   {?>                 
                        <button type="button" class="btn btn-clean" data-container="body" data-toggle="popover" data-placement="top" data-content=" <?= strip_tags($row->resignation_comment) ?>">
                             <?= word_limiter(strip_tags($row->resignation_comment),10)?>
                        </button>
                        <?php }else{?>
                         <?= $row->resignation_comment?>
                        <?php }?>
                        
                     
                    </td>
                    <td>
                      <?php echo $row->email; ?>
                    </td>
                    <td>
                      <?php echo $row->phone; ?>
                    </td>
                    <td>
                      <?php echo $row->emergency; ?>
                    </td>
                    <td>
                      <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                    </td>
                    <td>
                      <?php echo $row->created_at; ?>
                    </td>
                    <td>
                      <?php if ($permission->edit == 1) { ?>
                        <a href="<?php echo base_url() ?>hr/editEmployees?t=<?php echo base64_encode($row->id); ?>" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit details">	                            <span class="svg-icon svg-icon-md">									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">											<rect x="0" y="0" width="24" height="24"></rect>											<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>											<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>										</g>									</svg>	                            </span>	                        </a>
                       
                      <?php } ?>
                    </td>

                    <td>
                      <?php if ($permission->delete == 1) { ?>
                        <a href="<?php echo base_url() ?>hr/deleteEmployees/<?php echo $row->id ?>" onclick="return confirm('Are you sure you want to delete this Employee?');" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon" title="Delete">								<span class="svg-icon svg-icon-md">									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
                                <rect x="0" y="0" width="24" height="24"></rect>	
                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>						
                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>	
                                </g>				
                                </svg>				
                            </span>
                        </a>                        
                      <?php } ?>
                    </td>
                  </tr>
                  <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="7">There is no Employee to list</td>
                </tr>
                <?php
              }
              ?>
            </tbody>
              <tfoot>
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
                <th>Workplace Model</th>
                <th>Employee Status</th>
                <th>Resignation Date</th>
                <th>Resignation Reason</th>
                <th>Resignation Comment</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Emergency Contact</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>

              </tr></tfoot>
                </table>
                <!--end: Datatable-->
                </div>
                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
<?= $this->pagination->create_links() ?>  
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

    function showResignedSearch() {

        $('#resignedSearch').show();

    }
</script>