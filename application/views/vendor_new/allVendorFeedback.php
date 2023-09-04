
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
       
        <!--begin::Card-->
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Vendor Feedback</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total"><?= $this->vendor_model->getVendorName($vendor->id) ?></span>

                    </div>
                    <!--end::Search Form-->

                </div>
                <!--end::Details-->

            </div>
        </div>
        <!--end::Subheader-->
          <div class="card gutter-b min-h-500px">
        <?php if($feedback){
            foreach($feedback as $rate){?>
        <div class="card card-custom gutter-b m-5 mb-10">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Container-->
                <div>
                    <!--begin::Header-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->                       
                        <!--end::Symbol-->
                        <!--begin::Info-->
                        <div class="d-flex flex-column flex-grow-1 text-right">
                            <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder"><?=$this->admin_model->getAdmin($rate->created_by);?></a>
                            <span class="text-muted font-weight-bold"><?=$rate->created_at?></span>
                        </div>
                        <!--end::Info-->
                      
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div style="margin-top:-50px">
                        <div class="row ml-2 mt-3">
                              <label class="font-weight-bold mr-3">Quality : </label>
                              <div class="">                                    <span>
                                  <?php for($i=1;$i<=$rate->quality;$i++){ ?>    
                                      <i class="fas fa-star text-warning"></i>
                                  <?php } ($rate->quality) ?>                                   
                                  </span>      
                              </div>
                          </div>
                        <div class="row ml-2">
                              <label class="font-weight-bold mr-3">Communication : </label>
                              <div class="">                                    <span>
                                  <?php for($i=1;$i<=$rate->communication;$i++){ ?>    
                                      <i class="fas fa-star text-warning"></i>
                                  <?php } ( $rate->communication)?>                                   
                                  </span>      
                              </div>
                          </div>
                        <div class=" row ml-2">
                              <label class="font-weight-bold mr-3">Price : </label>
                              <div class="">                                    <span>
                                  <?php for($i=1;$i<=$rate->price;$i++){ ?>    
                                      <i class="fas fa-star text-warning"></i>
                                  <?php } ( $rate->price)?>                                   
                                  </span>      
                              </div>
                          </div>
						     <?php if($rate->task_response > 0){?>
                        <p class="font-size-lg font-weight-bold pt-2 mb-2 text-danger">
                                <?=$rate->task_response==1?'- Pass Test':'' ?>    
                                <?=$rate->task_response==2?'- Fail Test ':'' ?> 
                        </p>
                          <?php }?>
                        <!--begin::Text-->
                        <p class="text-dark-75 pt-5 mb-2"><?= $rate->comment ?></p>
                       
                        <!--end::Text-->
                       
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Container--> 
         
            </div>
            <!--end::Body-->
        </div>
        <?php }}else{?>
               <div class="card-body">
                   <p class="min-h-100 text-center">No Feedback Yet </p>
               </div>
        <?php }?>
    </div>
    </div>
</div>

