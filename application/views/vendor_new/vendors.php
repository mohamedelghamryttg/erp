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
   <style type="text/css">
     .fav-color{
         color: red;
     }
   </style>
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              

              <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">Search Vendor</h3>
          </div>
         <?php 
           if(isset($_REQUEST['email'])){
                    $email = $_REQUEST['email'];
                }else{
                    $email = "";
                }
                if(isset($_REQUEST['name'])){
                    $name = $_REQUEST['name'];
                }else{
                    $name = "";
                }
                if(isset($_REQUEST['contact'])){
                    $contact = $_REQUEST['contact'];
                }else{
                    $contact = "";
                }
                if(isset($_REQUEST['country'])){
                    $country = $_REQUEST['country'];
                }else{
                    $country = "";
                }
                if(isset($_REQUEST['type'])){
                    $type = $_REQUEST['type'];
                }else{
                    $type = "";
                }
                if(isset($_REQUEST['dialect'])){
                    $dialect = $_REQUEST['dialect'];
                }else{
                    $dialect = "";
                }
                if(isset($_REQUEST['source_lang'])){
                    $source_lang = $_REQUEST['source_lang'];
                }else{
                    $source_lang = "";
                }
                if(isset($_REQUEST['target_lang'])){
                    $target_lang = $_REQUEST['target_lang'];
                }else{
                    $target_lang = "";
                }
                if(isset($_REQUEST['service'])){
                    $service = $_REQUEST['service'];
                }else{
                    $service = "";
                }
                if(isset($_REQUEST['task_type'])){
                    $task_type = $_REQUEST['task_type'];
                }else{
                    $task_type = "";
                }
                if(isset($_REQUEST['subject'])){
                   $subject = $_REQUEST['subject'];
                }else{
                    $subject = "";
                }
                if(isset($_REQUEST['tools'])){
                   $tools = $_REQUEST['tools'];
                }else{
                    $tools = "";
                } 
                if(isset($_REQUEST['rate'])){
                    $rate = $_REQUEST['rate'];
                }else{
                    $rate = "";
                }
         ?>
            <form class="cmxform form-horizontal " id="vendors" action="<?php echo base_url()?>vendor" method="get" enctype="multipart/form-data">
             <div class="card-body">

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Name</label>
               <div class="col-lg-3">
                 <input type="text" class="form-control" value="<?=$name?>" name="name">
               </div>  

               <label class="col-lg-2 control-label" for="role name">Email</label>
                        <div class="col-lg-3">
                       <input type="text" class="form-control" value = "<?=$email?>"name="email">
                        </div>
              </div>
               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Contact</label>
               <div class="col-lg-3">
                       <input type="text" class="form-control" value="<?=$contact?>" name="contact">
               </div>  

               <label class="col-lg-2 control-label" for="role name">Country of Residence</label>
                        <div class="col-lg-3">
                         <select name="country" class="form-control m-b" id="country"/>
                                 <option disabled="disabled" selected="selected">-- Select Country --</option>
                                 <?=$this->admin_model->selectAllCountries($country)?>
                        </select>
                        </div>
              </div>
             
             <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Source</label>
               <div class="col-lg-3">
                      <select name="source_lang" class="form-control m-b" id="source" />
                                 <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                 <?=$this->admin_model->selectLanguage($source_lang)?>
                        </select>
               </div>  

               <label class="col-lg-2 control-label" for="role name">Target</label>
                        <div class="col-lg-3">
                        <select name="target_lang" class="form-control m-b" id="target" />
                                 <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                 <?=$this->admin_model->selectLanguage($target_lang)?>
                        </select>
                        </div>
              </div>

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Service</label>
               <div class="col-lg-3">
                      <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectServices($service)?>
                        </select>
               </div>  

               <label class="col-lg-2 control-label" for="role name">Task Type</label>
                        <div class="col-lg-3">
                         <select name="task_type" class="form-control m-b" id="task_type" />
                                <option disabled="disabled" selected=""></option>
                        </select>
                        </div>
              </div>

              <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Unit</label>
               <div class="col-lg-3">
                      <select name="unit" class="form-control m-b" id="unit" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectUnit($unit)?>
                        </select>
               </div>  

               <label class="col-lg-2 control-label" for="role name">Vendor Type</label>
                        <div class="col-lg-3">
                       <select name="type" class="form-control m-b" id="type"/>
                                 <option selected="selected" disabled="disabled">-- Select Type --</option>
                        <?php 
                            if(isset($_REQUEST['type']) && $_REQUEST['type'] == 0){?>
                              <?=$this->vendor_model->selectVendorType($type)?>
                            <?php }elseif(isset($_REQUEST['type']) && $_REQUEST['type'] == 1){ ?>
                              <?=$this->vendor_model->selectVendorType($type)?>
                            <?php }else{?>
                              <?=$this->vendor_model->selectVendorType(25)?>
                            <?php }?>

                        </select>
                        </div>
              </div>
             
             <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Dialect</label>
               <div class="col-lg-3">
                     <input type="text" class="form-control" value="<?=$dialect?>" name="dialect">
               </div>  

               <label class="col-lg-2 control-label" for="role name">Subject Matter</label>
                        <div class="col-lg-3">
                         <select name="subject" class="form-control m-b" id="subject"><option disabled="disabled" value="" selected="selected">-- Select Subject --</option><?=$this->admin_model->selectFields($Subject)?></select>
                        </div>
              </div>

              <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Tools</label>
               <div class="col-lg-3">
                     <select name="tools" class="form-control m-b" id="tools"><option disabled="disabled" value="" selected="selected">-- Select Tools --</option><?=$this->sales_model->selectTools($tools)?></select>
               </div>  

               <label class="col-lg-2 control-label" for="role name">Rate</label>
                        <div class="col-lg-3">
                         <input type="text" class="form-control" value="<?=$rate?>" name="rate">
                        </div>
              </div>
             
             <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
               <div class="col-lg-3">
                    <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
               </div>  

               <label class="col-lg-2 control-label" for="role name">Date To</label>
                        <div class="col-lg-3">
                         <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                        </div>
              </div>

             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('vendors'); e2.action='<?=base_url()?>vendor/exportVendors'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                      <a href="<?=base_url()?>vendor" class="btn btn-warning">(x) Clear Filter</a>

               </div>
              </div>
             </div>
            </form>
                       </div>
                        </div>
              <!-- end search form -->
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Vendors</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>vendor/addVendor" class="btn btn-primary font-weight-bolder"> 
                      
                      <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>Add New Vendor</a>
                      <?php } ?>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Source Language</th>
                        <th>Target Language</th>
                        <th>Dialect</th>
                        <th>Service</th>
                        <th>Task Type</th>
                        <th>Unit</th>
                        <th>Rate</th>
                        <th>Special Rate</th>
                        <th>Currency</th>
                        <th>Contact</th>
                        <th>Country of Residence</th>
                        <th>Mother Tongue</th>
                        <th>Profile</th>
                        <th>CV</th>
                        <th>Subject Matter</th>
                        <th>Tools</th>
                        <th>Type</th>
                        <th>Color Reason</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                 </thead>
            
                 <tbody>
                      <?php

                      $x=1;
                        foreach($vendor->result() as $row)
                          {
                                          if($row->color == "1"){
                              $style = 'background-color: red;color: white;';
                            }elseif($row->color == "2"){
                              $style = 'background-color: yellow;';
                            }
                            else{
                              $style = '';
                            }
                      ?>
                            <tr style="<?=$style?>" class="">
                              <td><?php echo $x ;?></td>
                              <td><?=$row->id?></td>
                              <td>
                                <a href="<?=base_url()?>vendor/vendorProfile?t=<?=base64_encode($row->id)?>" target="_blank"><?=$row->name?></a> 
                                <?php  $color = '' ;
                                 if($row->favourite == 1){ $color = ' fav-color'; }else{$color = ' ';};
                                 ?>
                               <a href=''id="test" onclick="this.href='<?php echo base_url()?>vendor/addToFavouriteVendor?t=<?=base64_encode($row->id)?>&f='+document.getElementById('fav<?=$row->id?>').value"> 
                                 <i class=" fas fa-heart <?=$color?> " onclick="changeClass(<?=$row->id?>);" id="<?=$row->id?>"></i>
                               </a>
                                 <input type="text" name="fav" id="fav<?=$row->id?>" readonly="" hidden="" value="<?=$row->favourite?>">

                              </td>

                              <td><?=$row->email?></td>
                              <td><?php echo $this->vendor_model->getVendorStatus($row->status) ;?></td>
                              <td><?=$this->admin_model->getLanguage($row->source_lang)?></td>
                              <td><?=$this->admin_model->getLanguage($row->target_lang)?></td>
                              <td><?=$row->dialect?></td>
                              <td><?=$this->admin_model->getServices($row->service)?></td>
                              <td><?=$this->admin_model->getTaskType($row->task_type)?></td>
                              <td><?=$this->admin_model->getUnit($row->unit)?></td>
                              <td><?=$row->rate?></td>
                              <td><?=$row->special_rate?></td>
                              <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                              <td><?=$row->contact?></td>
                              <td><?=$this->admin_model->getCountry($row->country)?></td>
                              <td><?=$row->mother_tongue?></td>
                              <td><?=$row->profile?></td>
                              <td><?php if(strlen($row->cv) > 1){ ?><a href="<?=base_url()?>assets/uploads/vendors/<?=$row->cv?>">Download</a><?php } ?></td>
                              <td>
                              <?php
                              $subjects = explode(",", $row->subject);
                              for ($i=0; $i < count($subjects); $i++) { 
                                if($i > 0){echo " - ";}
                                echo $this->admin_model->getFields($subjects[$i]);
                               } 
                              ?>
                              </td>
                              <td>
                              <?php
                              $tools = explode(",", $row->tools);
                              for ($i=0; $i < count($tools); $i++) { 
                                if($i > 0){echo " - ";}
                                echo $this->sales_model->getToolName($tools[$i]);
                               } 
                              ?>
                              </td>
                              <td><?php echo $this->vendor_model->getVendorType($row->type) ;?></td>
                              <td><?php echo $row->color_comment ;?></td>
                              <td><?php echo $this->admin_model->getAdmin($row->sheetCreatedBy) ;?></td>
                              <td><?php echo $row->sheetCreatedAt ;?></td>
                              <td>
                                <?php if($permission->edit == 1){ ?>
                                <a href="<?php echo base_url()?>vendor/editVendor?t=<?=base64_encode($row->id)?>" class="btn btn-sm btn-clean btn-icon">
                                  <i class="la la-edit"></i>
                                </a>
                                <?php } ?>
                              </td>
                              <td>
                                <?php if($permission->delete == 1){ ?>
                                <a href="<?php echo base_url()?>vendor/deleteVendor?t=<?=base64_encode($row->id)?>" title="delete" 
                                class="btn btn-sm btn-clean btn-icon" onclick="return confirm('Are you sure you want to delete this Vendor ?');">
                                 <i class="la la-trash"></i>
                                </a>
                                <?php } ?>
                              </td>
                            </tr>
                      <?php

                      $x++;
                          }
                      ?>    
                      </tbody>
              
                    </table>
                    <!--end: Datatable-->
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
               function changeClass(id){
                     var test =  id ;    
                     var fav = "fav";
                     var input_id = fav.concat(test) ;
                     var check_input_id = document.getElementById(input_id).value ;
                        if(check_input_id == "0"){
                              document.getElementById(test).classList.add('fav-color'); 
                             document.getElementById(input_id).setAttribute('value','1');
                         }else if(check_input_id == "1"){
                            document.getElementById(test).classList.remove("fav-color");
                            document.getElementById(input_id).setAttribute('value','0');
                         }
                    } 
                  //  $('.row').on("click",".link",function(e){ 
                  //   e.preventDefault(); // cancel click
                  //   var page = $(this).attr('href');   
                  //   $('.i_test').load(page);
                  // });

                 // $('.test').click(function() {
                 //      location.reload();
                 //  }); 
                //  $('.test').click(function (event) {
                //   event.preventDefault();
                //   // or use return false;
                // });

               $('#test').click(function (event) {
                  //event.preventDefault();
                  // or use 
                  return false;
                });
          </script>