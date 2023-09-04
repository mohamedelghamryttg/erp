<style>
    .star-rating{
	font-size: 0;
}
.star-rating__wrap{
	display: inline-block;
	font-size: 1rem;
}
.star-rating__wrap:after{
	content: "";
	display: table;
	clear: both;
}
.star-rating__ico{
	float: right;
	padding-left: 2px;
	cursor: pointer;
	color: #D7A83A!important;
}
.star-rating__ico:last-child{
	padding-left: 0;
}
.star-rating__input{
	display: none;
}
.star-rating__ico:hover:before,
.star-rating__ico:hover ~ .star-rating__ico:before,
.star-rating__input:checked ~ .star-rating__ico:before
{
	content: "\f005";
        font-weight: 900;
}
    </style>
    <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
          <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Task Feedback</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Add Task Feedback</span>

                    </div>
                    <!--end::Search Form-->

                </div>
                <!--end::Details-->

            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <div class="card-title">
                    <h4 class="card-label font-size-h6-sm">Task Code : <small><?= $row->code?></small></h4>
                    <h4 class="card-label font-size-h6"> | Vendor : <small><?= $this->vendor_model->getVendorName($row->vendor);?></small></h4>
                </div>       
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url() ?>ProjectManagment/doAddTaskFeedback" method="post" enctype="multipart/form-data">
                 <input type="hidden" class=" form-control" name="task" value="<?=base64_encode($row->id)?>"  required>            
                 <input type="hidden" class=" form-control" name="job" value="<?=base64_encode($row->job_id)?>"  required>            
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Quality <span class="text-danger">*</span></label>
                        <div class="col-lg-6"> 
                            <div class="star-rating mt-3">
                                <div class="star-rating__wrap">
                                    <input class="star-rating__input" id="star-rating-5" type="radio" name="quality" value="5">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-4" type="radio" name="quality" value="4">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-3" type="radio" name="quality" value="3">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-2" type="radio" name="quality" value="2">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-1" type="radio" name="quality" value="1">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
                                </div>
                            </div>
                        </div>       
                    </div>       
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Communication <span class="text-danger">*</span></label>
                        <div class="col-lg-6">  
                            <div class="star-rating mt-3">
                                <div class="star-rating__wrap">
                                    <input class="star-rating__input" id="star-rating-10" type="radio" name="communication" value="5">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-10" title="5 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-9" type="radio" name="communication" value="4">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-9" title="4 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-8" type="radio" name="communication" value="3">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-8" title="3 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-7" type="radio" name="communication" value="2">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-7" title="2 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-6" type="radio" name="communication" value="1">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-6" title="1 out of 5 stars"></label>
                                </div>
                            </div>
                        </div>       
                    </div>       
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Price <span class="text-danger">*</span></label>
                        <div class="col-lg-6">  
                            <div class="star-rating mt-3">
                                <div class="star-rating__wrap">
                                    <input class="star-rating__input" id="star-rating-15" type="radio" name="price" value="5">
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-15" title="5 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-14" type="radio" name="price" value="4" >
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-14" title="4 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-13" type="radio" name="price" value="3" >
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-13" title="3 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-12" type="radio" name="price" value="2" >
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-12" title="2 out of 5 stars"></label>
                                    <input class="star-rating__input" id="star-rating-11" type="radio" name="price" value="1" >
                                    <label class="star-rating__ico far fa-star fa-lg" for="star-rating-11" title="1 out of 5 stars"></label>
                                </div>
                            </div>
                        </div>       
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Comment</label>
                        <div class="col-lg-6">
                            <textarea class="form-control" name="comment" rows="3"></textarea>
                        </div>
                    </div>  
                    <?php if($row->service_type == 1){?>
                         <hr>
                         <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="role name">- Test Task , Vendor (Pass/Fail) ? </label>
                        <div class="col-lg-6 mt-5">
                            <div class="radio-inline">
                                <label class="radio radio-success">
                                    <input type="radio" value="1" name="task_response" required />
                                    <span></span>
                                    Pass
                                </label>
                                <label class="radio">
                                    <input type="radio" value="2" name="task_response" required/>
                                    <span></span>
                                    Fail
                                </label>

                            </div>
                        </div>
                    </div>
                    <?php }?>
                   
                   


                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>ProjectPlanning" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>

