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
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              

              <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">External Vendors List Filter</h3>
          </div>
      
            <form class="form" id="externalVendorForm" action="<?php echo base_url()?>externalVendor" method="post">
             <div class="card-body">
                <?php

                    if(!empty($filter['vr.created_at >='])){
                        $date_from=date("m/d/Y", strtotime($filter['vr.created_at >=']));
                    }
                    else{
                        $date_from="";
                    }
                    if(!empty($filter['vr.created_at <='])){
                        $date_to=date("m/d/Y", strtotime($filter['vr.created_at <=']));
                    }
                    else{
                        $date_to="";
                    }
                    if(!empty($filter['vr.id ='])){
                        $vendor_request_id = $filter['vr.id ='];
                    }else{
                        $vendor_request_id = "";
                    }
                    if(!empty($filter['vr.name LIKE '])){
                        $name = $filter['vr.name LIKE '];
                    }else{
                        $name = "";
                    }
                    if(!empty($filter['vr.email LIKE '])){
                        $email = $filter['vr.email LIKE '];
                    }else{
                        $email = "";
                    }
                    if(!empty($filter['vr.contact LIKE '])){
                        $contact = $filter['vr.contact LIKE '];
                    }else{
                        $contact = "";
                    }
                    if(!empty($filter['vsr.source_lang = '])){
                        $source_lang = $filter['vsr.source_lang = '];
                    }else{
                        $source_lang = "";
                    }
                    if(!empty($filter['vsr.target_lang = '])){
                        $target_lang = $filter['vsr.target_lang = '];
                    }else{
                        $target_lang = "";
                    }
                   

                ?>
              <div class="form-group row">

                    <label class="col-lg-2 col-form-label text-lg-right">Vendor Request ID</label>
                    <div class="col-lg-3">
                    <input class="form-control" type="text" name="request_id" autocomplete="off" value=<?=$vendor_request_id?>>
                    </div>

                    <label class="col-lg-2 col-form-label text-lg-right">Vendor Name</label>
                    <div class="col-lg-3">
                    <input class="form-control" type="text" name="name" autocomplete="off" value=<?=$name?>>
                    </div>  

               </div>
               <div class="form-group row">

                    <label class="col-lg-2 col-form-label text-lg-right">Vendor Email</label>
                    <div class="col-lg-3">
                    <input class="form-control" type="text" name="email" autocomplete="off" value=<?=$email?>>
                    </div>

                    <label class="col-lg-2 col-form-label text-lg-right">Vendor Contact</label>
                    <div class="col-lg-3">
                    <input class="form-control" type="text" name="contact" autocomplete="off" value=<?=$contact?>>
                    </div>  

                </div>


              <div class='form-group row'>
                  <label class='col-lg-2 col-form-label text-right' >Section</label>

                  <div class='col-lg-3'>
                        <select name="source_lang" class="form-control m-b" id="source" />
                                 <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                 <?=$this->admin_model->selectLanguage($source_lang)?>
                        </select>
                  </div>

                  <label class='col-lg-2 col-form-label text-right' >Category</label>
                  <div class='col-lg-3'>
                       <select name="target_lang" class="form-control m-b" id="target" />
                                 <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                 <?=$this->admin_model->selectLanguage($target_lang)?>
                        </select>
                  </div>

                  
              </div>

               <div class="form-group row">

                    <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
                    <div class="col-lg-3">
                    <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value=<?=$date_from?>>
                    </div>  

                    <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
                    <div class="col-lg-3">
                    <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" value=<?=$date_to?>>
                    </div>
              </div>

              <div class="form-group row">
                    <label class="col-lg-2 col-form-label text-lg-right">Status</label>
                    <div class='col-lg-3'>
                            <select name="status" class="form-control m-b" id="status" />
                                        <option disabled="disabled" selected="selected">-- Select Status --</option>
                                        <option value="1" <?php if($filter['vsr.status =']==1){echo "selected";}?>>Pending</option>
                                        <option value="3" <?php if($filter['vsr.status =']==0){echo "selected";}?>>Rejected</option>
                                </select>
                        </div>
              </div>
             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search"  onclick="var e2 = document.getElementById('externalVendorForm'); e2.action='<?=base_url()?>externalvendor'; e2.submit();" type="submit">Search</button>  
                           <a href="<?=base_url()?>externalVendor" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

               </div>
              </div>
             </div>
            </form>
                       </div>
                       </div>
                        
              <!-- end search form -->
              <form method="post" action="<?=base_url()?>externalVendor/action">
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">External Vendor Requests</h3>
                    </div>
                    <div class='form-group row'>
                        <label class='col-lg-2 col-form-label text-right' >Approve/Reject</label>

                        <div class='col-lg-3'>
                                <select name="RequestAction" class="form-control m-b" />
                                        <option disabled="disabled" selected="selected">-- Select Action --</option>
                                        <option value="0">Reject</option>
                                        <option value="1">Accept</option>
                                </select>

                        </div>
                        <div class='col-lg-3'>
                            <button class="btn btn-success mr-2" name="action"  type="submit">Submit</button>  

                        </div>
                    </div>
                   
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <thead>
                            <tr>
                                    <th><input type="checkbox" id="checkall" onchange="toggleExternalVendors(this)"></th>
                                    <th>External Vendor ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Country</th>
                                    <th>Profile  </th>
                                    <th>Source Language</th>
                                    <th>Target Language</th>
                                    <th>Service</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Special Rate</th>
                                    <th>Currency</th>
                                    <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($vendors->result() as $row)
                            {?>
                                    <tr>
                                        <td><input type="checkbox" name="approve_reject[]" class="vendor_row" value="<?=$row->sheetid?>">
                                         </td>
                                        <td><?= $row->id?></td>  
                                        <td><?= $row->name?></td>                              
                                        <td><?= $row->email?></td>
                                        <td><?= $row->contact ;?></td>
                                        <td><?= $row->country_name ?></td>
                                        <td><?= $row->profile ;?></td>
                                        <td><?= $row->source_lang ;?></td>
                                        <td><?= $row->target_lang ?></td>  
                                        <td><?= $row->service_name ?></td>
                                        <td><?= $row->unit_name ?></td>                        
                                        <td><?= $row->rate ?></td>
                                        <td><?= $row->special_rate ?></td>
                                        <td><?= $row->currency_name ?></td>
                                        <td><?= $row->created_at ;?></td>
                                    </tr>
                            <?php
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
               </form>
               </div>
                <!--end::Card-->
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->
