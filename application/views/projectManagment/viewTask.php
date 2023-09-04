<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<style>
  .custom{
  font-weight: 700!important;
  /*color: #B5B5C3 !important;*/  
  text-transform: uppercase;
  letter-spacing: 0.1rem;
}
.sendMSG{
    max-height: 40px;padding: 7px;margin: 15px;max-width: 20%;
}
input[type="radio"] {
  width: 1.5em;
  height: 1.5rem;
  accent-color: green;
  margin-right:2px;
}
#radioReject {  
  accent-color: red;
}
.timeline.custom-timeline .timeline-items .timeline-item .timeline-content:before {
    left: -35px;
}

</style>
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
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
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Task Info</h3>
                
            </div>
            <!--begin::Form-->
            	<!--begin::Header-->
            <div class="card-header card-header-tabs-line">
                <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                                    <li class="nav-item mr-3">
                                            <a class="nav-link active" data-toggle="tab" href="#kt_apps_projects_view_tab_1">
                                                    <span class="nav-icon mr-2">
                                                            <span class="svg-icon mr-3">
                                                                <i class="fa fa-info"></i>
                                                            </span>
                                                    </span>
                                                    <span class="nav-text font-weight-bold">Info</span>
                                            </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                            <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_2">
                                                    <span class="nav-icon mr-2">
                                                            <span class="svg-icon mr-3">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                                    <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                                    <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
                                                                            </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                            </span>
                                                    </span>
                                                    <span class="nav-text font-weight-bold">Instruction</span>
                                            </a>
                                    </li>
                                    <li class="nav-item mr-3" onclick="setTimeout(function() { MessageScroll(); }, 1000);">
                                            <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_3">
                                                    <span class="nav-icon mr-2">
                                                            <span class="svg-icon mr-3">
                                                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo10\dist/../src/media/svg/icons\Design\PenAndRuller.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"/>
                                                                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"/>
                                                                        </g>
                                                                    </svg><!--end::Svg Icon-->
                                                            </span>
                                                    </span>
                                                    <span class="nav-text font-weight-bold">Notes</span>
                                            </a>
                                    </li>
                                <?php if(!empty($row->vendor_notes) || !empty($row->vendor_attachment) || $row->status == 5){?>
                                    <li class="nav-item mr-3">
                                            <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_4">
                                                    <span class="nav-icon mr-2">
                                                            <span class="svg-icon mr-3">
                                                                <i class="fa fa-database"></i>
                                                            </span>
                                                    </span>
                                                    <span class="nav-text font-weight-bold">Vendor Reply</span>
                                            </a>
                                    </li>
                                <?php }?>
                                <li class="nav-item mr-3">
                                      <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_5">
                                              <span class="nav-icon mr-2">
                                                      <span class="svg-icon mr-3">
                                                          <i class="fa fa-clock"></i>
                                                      </span>
                                              </span>
                                              <span class="nav-text font-weight-bold">Job History</span>
                                      </a>
                              </li>
                                <li class="nav-item mr-3">
                                      <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_6">
                                              <span class="nav-icon mr-2">
                                                      <span class="svg-icon mr-3">
                                                          <i class="fa fa-star"></i>
                                                      </span>
                                              </span>
                                              <span class="nav-text font-weight-bold">Task Feedback</span>
                                      </a>
                              </li>

                            </ul>
                    </div>
                    <button class="btn btn-sm btn-light-info font-weight-bolder ml-2 sendMSG"  onclick="updateMessage();">Refresh Messages </button>
                                        
            </div>
            <div class="card-body">
                <div class="tab-content pt-5">
                    <!--begin::Tab Content-->
                    <div class="tab-pane active" id="kt_apps_projects_view_tab_1" role="tabpanel">
                        <div class="task_info"> 
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                                        <thead>
                                            <tr>
                                                <th>Job Code</th>
                                                <th>Product Line</th>
                                                <th>Service</th>
                                                <th>Source</th>
                                                <th>Target</th>
                                                <th>Volume</th>
                                                <th>Rate</th>
                                                <th>Total Revenue</th>
                                                <th>Currency</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr class="">
                                                <td><?= $job_data->code ?></td>
                                                <td><?php echo $this->customer_model->getProductLine($priceList->product_line); ?></td>
                                                <td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                                                <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                                                <td><?php echo $job_data->volume; ?></td>
                                                <td><?php echo $priceList->rate; ?></td>
                                                <td><?= $this->sales_model->calculateRevenueJob($job_data->id, $job_data->type, $job_data->volume, $priceList->id) ?></td>
                                                <td><?php echo $this->admin_model->getCurrency($priceList->currency); ?></td>
                                                <td><?php echo $this->admin_model->getAdmin($job_data->created_by); ?></td>
                                                <td><?php echo $job_data->created_at; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Mail Subject : </label>
                                <div class="col-lg-6 pt-2">
                                    <p><?= $row->subject ?>     </p>      
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Task Type :</label>
                                <div class="col-lg-6 pt-2">
                                    <p>   <?= $this->admin_model->getTaskType($row->task_type) ?> </p>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom"> Vendor : </label>
                                <div class="col-lg-6 pt-2">
                                    <p> <?= $this->vendor_model->getVendorName($row->vendor) ?></p>                                 
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Rate : </label>
                                <div class="col-lg-6 pt-2">

                                    <?= $row->rate ?> <?= $this->admin_model->getCurrency($row->currency) ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Volume :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $row->count ?> <?= $this->admin_model->getUnit($row->unit) ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Start Date :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $row->start_date ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Delivery Date :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $row->delivery_date ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Time Zone :</label>
                                <div class="col-lg-6 pt-2">
                                    <?= $this->admin_model->getTimeZone($row->time_zone) ?>                                      
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Task File :</label>
                                <div class="col-lg-6 pt-2">
                                    <?php if (strlen($row->file) > 1) { ?>
                                     <a href="<?= $this->projects_model->getTaskFileLink("assets/uploads/taskFile/",$row->file,$row->start_after_type) ?>" target="_blank">Click Here</a>
                                    <?php } else{
                                        if($row->start_after_id != null && $row->start_after_type == "Vendor"){?>
                                            <?= $this->projects_model->getTaskVendorNotes($row->start_after_id)?>
                                    <?php }} ?>
                                </div>
                            </div>
                             <?php if(strlen($jobData->job_file) > 1){ ?>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Job Files :</label>
                                <div class="col-lg-6 pt-2">
                                   <a href="<?=base_url()?>assets/uploads/jobFile/<?=$jobData->job_file?>" target="_blank"><?=$jobData->job_file_name?></a>
                                </div>
                            </div>                                 
                                <?php }?>

                        </div>
                    </div>
                    <div class="tab-pane" id="kt_apps_projects_view_tab_2" role="tabpanel">
                        <form class="form">
                                <div class="form-group">
                                         <?=$row->insrtuctions?>
                                </div>
                        </form>
                    </div>
                    <!--end::Tab Content-->
                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="kt_apps_projects_view_tab_3" role="tabpanel" style="overflow-y: scroll;max-height: 400px;">
                        <div class="form-group">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-3">
                                    <div class="timeline-items" id="timeline_items">
                                    <?php foreach ($timeline as $item) { 
                                            if($item->from == 2){
                                    ?>
                                    <div class="timeline-item">
                                        <div class="timeline-content">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <div class="mr-2">
                                                                <p href="#" class="text-dark-75 text-hover-primary font-weight-bold"><?=$this->vendor_model->getVendorData($item->created_by)->name?></p>
                                                                <span class="text-muted ml-2"><?=$item->created_at?></span>
                                                        </div>

                                                </div>
                                                <!-- <p class="p-0">$</p> -->
                                                <?=$item->message?>
                                        </div>
                                    </div>
                                    <?php }elseif($item->from == 1){ ?>
                                    <div class="timeline-item" style="padding: 0 0 20px 7px;">
                                        <div class="timeline-content">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="mr-2">
                                                        <p href="#" class="text-dark-75 text-hover-primary font-weight-bold"><?=$this->admin_model->getUser($item->created_by)?></p>
                                                        <span class="text-muted ml-2"><?=$item->created_at?></span>
                                                </div>
                                            </div>
                                            <!-- <p class="p-0">$</p> -->
                                            <?=$item->message?>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                </div>
                            </div>
                            <!--end::Timeline-->
                        </div>
                    </div>
                    <!--end::Tab Content-->
                    <div class="tab-pane" id="kt_apps_projects_view_tab_4" role="tabpanel">
                        <div class="form-group row">
                               <label class="col-lg-3 col-form-label text-right custom">Notes :</label>
                               <div class="col-lg-6 pt-2">
                                   <?=$row->vendor_notes?>
                               </div>
                       </div>
                        <div class="form-group row">
                               <label class="col-lg-3 col-form-label text-right custom">Attachment :</label>
                               <div class="col-lg-6 pt-2">
                                   <?php if (strlen($row->vendor_attachment) > 1) { ?><a href="<?=$this->projects_model->getNexusLinkByBrand()?>/assets/uploads/jobTaskVendorFiles/<?= $row->vendor_attachment ?>" target="_blank">Click Here ..</a><?php } ?>

                               </div>
                       </div>
                      <?php if($row->status == 5){?>
                       <form class="form" action="<?php echo base_url()?>ProjectManagment/pmConfirm" method="post" enctype="multipart/form-data">

                           <input type="text" name="task_id" value="<?=base64_encode($row->id)?>" hidden="">
                           <input type="text" name="job_status" value="<?=base64_encode($job_data->status)?>" hidden="">
                           <input type="text" name="status" value="<?=$row->status?>" hidden="">
                           <div class="form-group row">
                               <label class="col-lg-3 col-form-label text-right custom"></label>
                               <div class="col-lg-6 pt-2">
                                   <div class="radio-toolbar">
                                       <input type="radio" id="radioConfirmed" name="response" value="1" checked>
                                           <label for="radio" style="margin-right:10px">Confirmed</label>

                                           <input type="radio" id="radioReject" name="response" value="0">
                                               <label for="radio">Reject</label>

                                   </div>
                               </div>
                           </div>

                           <div class="form-group row" id='reason' style='display: none;'>
                               <label class="col-lg-3 col-form-label text-right custom">Reason :</label>
                               <div class="col-lg-6 pt-2">
                                   <input class="form-control" name="reason" id="reasonInput" type="text">
                               </div>
                           </div>  
                           <div class="form-group row">
                               <label class="col-lg-3 col-form-label text-right custom"></label>
                               <div class="col-lg-6 pt-2">
                                  <button type="submit" class="btn btn-success mr-2">Save</button>
                               </div>
                           </div>

                       </form>
                      <?php }?>
                    </div>
                    <!--end::Tab Content-->
                     <!--begin::Tab Content-->
                    <div class="tab-pane" id="kt_apps_projects_view_tab_5" role="tabpanel">
                        
                        <div class="form-group">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-3 custom-timeline" >
                                    <div class="timeline-items" id="timeline_items">
                                    <?php foreach ($jobHisory as $history) { 
                                            if($history->from == 2){
                                    ?>
                                    <div class="timeline-item">
                                        <div class="timeline-content">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <div class="mr-2">
                                                                <p href="#" class="text-dark-75 text-hover-primary font-weight-bold"><?=$this->vendor_model->getVendorData($history->created_by)->name?></p>
                                                                <span class="text-muted ml-2"><?=$history->created_at?></span>
                                                        </div>

                                                </div>
                                                <p class="p-0 font-weight-bold"> <?=$this->projects_model->getTaskLoggerStatus($history->status);?></p>                                            
                                                <small><?=$history->comment?></small>
                                        </div>
                                    </div>
                                    <?php }elseif($history->from == 1){ ?>
                                    <div class="timeline-item" style="padding: 0 0 20px 7px;">
                                        <div class="timeline-content">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="mr-2">
                                                        <p href="#" class="text-dark-75 text-hover-primary font-weight-bold"><?=$this->admin_model->getUser($history->created_by)?></p>
                                                        <span class="text-muted ml-2"><?=$history->created_at?></span>
                                                </div>
                                            </div>
                                            <p class="p-0 font-weight-bold"> <?=$this->projects_model->getTaskLoggerStatus($history->status);?></p>                                            
                                            <small><?=$history->comment?></small>
                                        </div>
                                    </div>
                                    <?php } }?>
                                </div>
                            </div>
                            <!--end::Timeline-->
                        </div>
                    </div>
                    <!--end::Tab Content-->
                     <!--begin::Tab Content-->
                    <div class="tab-pane" id="kt_apps_projects_view_tab_6" role="tabpanel">
                          <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Quality : </label>
                                <div class="col-lg-6 pt-2">
                                    <p>
                                    <?php for($i=1;$i<=$rate->quality;$i++){ ?>    
                                        <i class="fas fa-star text-warning"></i>
                                    <?php }?>
                                   
                                    </p>      
                                </div>

                            </div>
                          <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Communication : </label>
                                <div class="col-lg-6 pt-2">
                                    <p>
                                    <?php for($i=1;$i<=$rate->communication;$i++){ ?>    
                                        <i class="fas fa-star text-warning"></i>                                   
                                    <?php  }?>
                                    </p>      
                                </div>

                            </div>
                          <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Price : </label>
                                <div class="col-lg-6 pt-2">
                                    <p>
                                    <?php for($i=1;$i<=$rate->price;$i++){ ?>    
                                        <i class="fas fa-star text-warning"></i>   
                                    <?php  }?>
                                    </p>      
                                </div>

                            </div>
                          <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">Comment : </label>
                                <div class="col-lg-6 pt-2">
                                    <p>
                                    <?= $rate->comment ?>    
                                     
                                    </p>      
                                </div>

                            </div>
                        <?php if($row->service_type == 1){?>
                          <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right custom">- Test Task , Vendor (Pass/Fail) ? : </label>
                                <div class="col-lg-6 pt-2">
                                    <p>
                                    <?=$rate->task_response==1?'Pass':'' ?>    
                                    <?=$rate->task_response==2?'Fail':'' ?>    
                                     
                                    </p>      
                                </div>

                            </div>
                        <?php }?>
                        
                    </div>
                    <!--end::Tab Content-->
                </div>
            </div> 
        </div>
        <!--end::Card-->
          <div class="card card-custom mt-2">
                    <!--begin::Header-->
                    <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Send New Message</h5>
                            </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                            <div class="tab-content pt-5">
                                    <!--begin::Tab Content-->
                                    <div class="tab-pane active" id="kt_apps_projects_view_tab_msg" role="tabpanel">
                                        <form class="form">
                                            <input type="text" name="id" id="jobID" value="<?=base64_encode($task)?>" hidden="">
                                            <div class="form-group">
                                                    <textarea class="form-control" id="msg" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                    <a class="btn btn-primary" href="#" onclick="sendMessage();">
                                                            <span class="icon-1x flaticon2-send-1"></span> Send Message
                                                    </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!--end::Tab Content-->
                            </div>
                    </div>
                    <!--end::Body-->
            </div>
          
    </div>
</div>
<script>

function sendMessage(){
    var msg = tinyMCE.activeEditor.getContent();
    var jobID = $("#jobID").val();
    if(msg.trim().length > 0){
        // alert(msg);
        // alert(jobID);
        $.ajaxSetup({
            beforeSend: function(){
              $('#loading').show();
            },
        });
        $.post(base_url+"projects/sendMessage", {msg:msg,jobID:jobID} , function(data){
        $('#loading').hide();        
        // alert(data);
        tinymce.activeEditor.setContent('');
        if(data == 1){                	
            // alert("done");
        }else{
            alert("Error sending message, Please try again!")
        }
        });
    }else{
        alert("Please enter your message first");
    }
	$( "#kt_apps_projects_view_tab_3 .timeline" ).load(window.location.href + " #kt_apps_projects_view_tab_3 .timeline" );
 	MessageScroll();

}
function updateMessage(){
    $( "#kt_apps_projects_view_tab_3 .timeline" ).load(window.location.href + " #kt_apps_projects_view_tab_3 .timeline" );	
	$('.nav-link' ).removeClass('active');
	$('.tab-pane:not(#kt_apps_projects_view_tab_msg)').removeClass('active');	
	$('#kt_apps_projects_view_tab_3').tab('show');
	$('.nav-link[href*="#kt_apps_projects_view_tab_3"]' ).addClass('active');	
 	MessageScroll();
}

function MessageScroll(){
    $("#kt_apps_projects_view_tab_3").scrollTop($("#timeline_items").height());
}

$("input[name='response']").click(function() {
   if($('#radioReject').is(':checked')) { 
        $('#reason').show();
        $('#reasonInput').attr('required','true');
        
   }
   else{
        $('#reason').hide();
        $('#reasonInput').removeAttr('required');
        
   }
});
</script>