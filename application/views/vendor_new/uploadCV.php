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
            <h3 class="card-title">Search</h3>
          </div>
         
            <form class="cmxform form-horizontal " id="vendorForm" action="<?php echo base_url()?>vendor/uploadCV" method="post" enctype="multipart/form-data">
              <div class="card-body">
             
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

               <label class="col-lg-2 col-form-label text-lg-right">Field</label>
               <div class="col-lg-3">
                      <select name="field[]" multiple class="form-control m-b" id="subject" />
                                 <option disabled="disabled" selected="selected">-- Select Field --</option>
                                 <?=$this->admin_model->selectFields()?>
                        </select>
               </div>  

               <label class="col-lg-2 control-label" for="role name">Created By</label>
                        <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by"/>
                         <option value="">-- Select Vm --</option>
                         <?=$this->admin_model->selectAllVm($this->brand)?>
                </select>
                        </div>
              </div>

            
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>

               </div>
              </div>
             </div>
            </form>
                       </div>
                        
              <!-- end search form -->
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">CV List</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>vendor/addCV" class="btn btn-primary font-weight-bolder"> 
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
                      </span>Add New Record</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
<thead>
              <tr>
              <th>ID</th>
              <th>Source Language</th>
              <th>Target Language</th>
              <th>Dialect</th>
              <th>Field</th>
              <th>File</th>
              <th>Comment</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Edit</th>
              <th>Delete</th>
              </tr>
            </thead>
            
            <tbody>
            <?php
              foreach($cv->result() as $row)
                {
            ?>
                  <tr class="">
                                      <td><?=$row->id?></td>
                    <td><?=$this->admin_model->getLanguage($row->source_lang)?></td>
                    <td><?=$this->admin_model->getLanguage($row->target_lang)?></td>
                                      <td><?=$this->admin_model->getDialect($row->dialect)?></td>
                    <td>
                    <?php
                    $subjects = explode(",", $row->field);
                    for ($i=0; $i < count($subjects); $i++) { 
                      if($i > 0){echo " - ";}
                      echo $this->admin_model->getFieldsProz($subjects[$i]);
                     } 
                    ?>
                    </td>
                    <td><a target="_blank" href="<?=base_url()?>assets/uploads/vendorCV/<?=$row->file?>"><?=$row->file?></a></td>
                    <td><abbr title="<?=$row->comment?>"><?=character_limiter($row->comment,10)?></abbr></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                      <a href="<?php echo base_url()?>vendor/editCV?t=<?=base64_encode($row->id)?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>vendor/deleteCV?t=<?=base64_encode($row->id)?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Record ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
                  </tr>
            <?php
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