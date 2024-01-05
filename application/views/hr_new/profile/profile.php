<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid py-lg-0" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center mr-1">               
                <!--begin::Mobile Toggle-->
                <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Mobile Toggle-->
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h2 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">My Profile</h2>
                    <!--end::Page Title-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->  
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <?php if ($this->session->flashdata('true')) { ?>
                <div class="alert alert-success" role="alert">
                    <span class="fa fa-check-circle"></span>
                    <span><strong><?= $this->session->flashdata('true') ?></strong></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-warning"></span>
                    <span><strong><?= $this->session->flashdata('error') ?></strong></span>
                </div>
            <?php } ?> 
            <!--begin::Profile Personal Information-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-300px w-xxl-350px" id="kt_profile_aside">
                    <!--begin::Profile Card-->
                    <div class="card card-custom card-stretch">
                        <!--begin::Body-->
                        <div class="card-body pt-4"> 
                            <!--begin::User-->
                            <div class="d-flex align-items-center mt-5">
                                <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                    <?php if (empty($employee->employee_image)) { ?>
                                        <div class="symbol-label" style='background-image:url("<?= base_url() ?>assets_new/media/users/blank.png")'></div>
                                    <?php } else { ?>
                                        <div class="symbol-label" style='background-image:url("<?= base_url() ?>assets/uploads/employeesImages/<?= $employee->employee_image ?>")'></div>
                                    <?php } ?>   
                                    <i class="symbol-badge bg-success"></i>
                                </div>
                                <div>
                                    <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary"><?= word_limiter($employee->name, 2, '') ?></a>
                                    <div class="text-muted"><?php echo $this->hr_model->getTitle($employee->title); ?></div>

                                </div>
                            </div>
                            <!--end::User-->
                            <!--begin::Contact-->
                            <!--                            <div class="py-9">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <span class="font-weight-bold mr-2">Email:</span>
                                                                <a href="#" class="text-muted text-hover-primary" style="word-wrap: anywhere;"><?= $employee->email ?></a>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <span class="font-weight-bold mr-2">Phone:</span>
                                                                <span class="text-muted"><?= $employee->phone ?></span>
                                                            </div>                                
                                                        </div>-->
                            <!--end::Contact-->
                            <!--begin::Nav-->                            
                            <div class="navi navi-bold navi-hover navi-active navi-link-rounded mt-15">
                                <div class="navi-item mb-2">
                                </div>
                                <div class="navi-item mb-2">
                                    <a data-toggle="tab" href="#personal_info" class="navi-link py-4 active">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="navi-text font-size-lg">Personal Information</span>
                                    </a>
                                </div>
                                <div class="navi-item mb-2">
                                    <a data-toggle="tab" href="#account_settings" class="navi-link py-4">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                                                <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                                                </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="navi-text font-size-lg">Account Information</span>
                                    </a>
                                </div>
                                <div class="navi-item mb-2">
                                    <a data-toggle="tab" href="#job_info" class="navi-link py-4">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="navi-text font-size-lg">Job Information</span>                                       
                                    </a>
                                </div>
                                <div class="navi-item mb-2 nav-item">
                                    <a data-toggle="tab" href="#vacation_balance" id="vacation-tab" class="navi-link py-4 nav-link">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="navi-text font-size-lg">Vacation Balance</span>                                        
                                    </a>
                                </div>
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Profile Card-->
                </div>
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <div class="card card-custom card-stretch">
                        <div class="tab-content" id="myTabContent">                      
                            <!--begin::Card-->
                            <div class="tab-pane fade show active" id="personal_info" role="tabpanel">
                                <!--begin::Form-->   
                                <form class="form" action="<?php echo base_url() ?>admin/addEmployeesImages" method="post" enctype="multipart/form-data">
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title align-items-start flex-column">
                                                <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                                                <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
                                            </div>
                                            <div class="card-toolbar">
                                                <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body">                   
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url(<?= base_url() ?>assets_new/media/users/blank.png)">
                                                        <?php if (!empty($employee->employee_image)) { ?>
                                                            <div class="image-input-wrapper" style="background-image: url(<?= base_url() ?>assets/uploads/employeesImages/<?= $employee->employee_image ?>)"></div>
                                                        <?php } else { ?>
                                                            <div class="image-input-wrapper" style="background-image: url(<?= base_url() ?>/assets_new/media/users/blank.png)"></div>
                                                        <?php } ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="file" accept=".png, .jpg, .jpeg" />                                               
                                                        </label>
                                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                        </span>                                            
                                                    </div>
                                                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" disabled value="<?= $employee->name ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-xl-3 col-lg-3"></label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-phone"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-lg form-control-solid text-dark-50" value="<?= $employee->phone ?>" placeholder="Phone" disabled="" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-at"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-lg form-control-solid text-dark-50" value="<?= $employee->email ?>" placeholder="Email" disabled="" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--end::Body-->                                    
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <div class="tab-pane fade" id="account_settings" role="tabpane2">
                                <!--begin::Form-->
                                <form class="form" action="<?php echo base_url() ?>admin/doEditProfile" method="post" enctype="multipart/form-data">
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title align-items-start flex-column">
                                                <h3 class="card-label font-weight-bolder text-dark">Account Information</h3>
                                                <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
                                            </div>
                                            <div class="card-toolbar">
                                                <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body">    

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Username</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" value="<?= $users->user_name ?>" readonly="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Email</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" value="<?= $users->email ?>" readonly="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Password</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control form-control-lg form-control-solid" name="password" type="password" id="inputPassword" placeholder="Password"  value="<?= base64_decode($users->password) ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Body-->                                    
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>                           
                            <div class="tab-pane fade" id="job_info" role="tabpane3">
                                <div class="card card-custom card-stretch">
                                    <!--begin::Body-->
                                    <!--begin::Header-->
                                    <div class="card-header py-2">
                                        <div class="card-title">
                                            <h3 class="card-label font-weight-bolder text-dark">Job Information</h3>
                                        </div>                                            
                                    </div>
                                    <!--end::Header-->
                                    <div class="card-body">                   

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Role</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" disabled value="<?php echo $this->hr_model->getTitle($employee->title); ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Function</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" disabled value="<?php echo $this->hr_model->getDepartment($employee->department); ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Direct Manager</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" disabled value="<?php echo $this->hr_model->getEmployee($employee->manager); ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Hiring Date</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid text-dark-50" type="text" disabled value="<?php echo $employee->hiring_date; ?>" />
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Body-->  
                                </div>
                            </div>
                            <div class="tab-pane fade" id="vacation_balance" role="tabpane4">
                                <div class="card card-custom card-stretch ">
                                    <!--begin::Body-->
                                    <!--begin::Header-->
                                    <div class="card-header py-2">
                                        <div class="card-title">
                                            <h3 class="card-label font-weight-bolder text-dark">Vacation Balance</h3>
                                        </div>                                            
                                    </div>
                                    <!--end::Header-->
                                    <div class="card-body"> 
                                        <div class="row m-0">
                                            <div class="col px-8 pb-8">
                                                <div class="font-size-sm text-muted font-weight-bold">  
                                                    <span class="svg-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-right.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)"></path>
                                                        </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Total Remaining Balance(Current Year + Previous Year )</div>
                                                <div class="font-size-h6 font-weight-bolder ml-8"><?= ($vacationBalance->current_year + $vacationBalance->previous_year) ?></div>
                                            </div>
                                        </div>
                                        <div class="row m-0">


                                            <div class="col px-8 pb-6">
                                                <div class="font-size-sm text-muted font-weight-bold">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-right.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)"></path>
                                                        </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>Total Remaining Sick Leave Balance</div>
                                                <div class="font-size-h6 font-weight-bolder ml-8"><?= $vacationBalance->sick_leave ?></div>
                                            </div>
                                        </div>
                                        <table class="table table-bordered mt-5" style="overflow:scroll;">
                                            <thead>
                                                <tr>
                                                    <th class="total"> Total <?= $vacationBalance->year ?> Balance</th>
                                                    <th class="total"> Total <?= $vacationBalance->year - 1 ?> Balance</th>                                           
                                                    <th> Consumed Annual Leave</th>
                                                    <th> Consumed Casual Leave</th>
                                                    <th class="total"> Total Consumed </th>                                            
                                                    <th class="total"> Total Remaining Balance</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr> 
                                                    <td class="total"><?= $vacationBalance->current_year ?></td>                                          
                                                    <td class="total"><?= $vacationBalance->previous_year ?></td>                                          
                                                    <td><?= $vacationBalance->annual_leave ?></td>
                                                    <td><?= $vacationBalance->casual_leave ?></td>
                                                    <td class="total"><a class="text-dark text-hover-danger"href="<?=base_url()?>hr/vacation"><u><?= $vacationBalance->casual_leave + $vacationBalance->annual_leave ?></u></a></td>
                                                    <td class="total"><span class="label label-inline label-light-success font-weight-bolder"><?= ($vacationBalance->current_year + $vacationBalance->previous_year) ?></span> </td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <!--end::Body-->  
                                </div>

                            </div>

                        </div>
                        <!--end::Content-->
                    </div>
                </div>
            </div>
            <!--end::Profile Personal Information-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
<script src="<?php echo base_url(); ?>assets_new/js/pages/custom/profile/profile.js"></script>
<script>
    $("a.navi-link").click(function () {
        $("a.navi-link").removeClass('active');
    });
</script>