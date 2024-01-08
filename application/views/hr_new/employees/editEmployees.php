<!--begin::Page Custom Styles(used by this page)-->
<link href="<?php echo base_url(); ?>/assets_new/css/pages/wizard/wizard-4.css" rel="stylesheet" type="text/css" />
<style>
    .select2{
        width: 100%!important;
        
    }
    .select2-container--default .select2-selection--single{
        background-color: #F3F6F9!important;
    }
</style><!--end::Page Custom Styles-->
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Edit User</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->
                <!--begin::Search Form-->
                <div class="d-flex align-items-center" id="kt_subheader_search">
                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Enter user details and submit</span>
                </div>
                <!--end::Search Form-->
            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="<?= base_url() ?>hr/employees" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Back</a>
                <!--end::Button-->               
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom card-transparent">
                <div class="card-body p-0">
                    <!--begin::Wizard-->
                    <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">
                        <!--begin::Wizard Nav-->
                        <div class="wizard-nav">
                            <div class="wizard-steps">
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">1</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Profile</div>
                                            <div class="wizard-desc">User's Personal Information</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">2</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Account</div>
                                            <div class="wizard-desc">Positioning Data</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">3</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Communication</div>
                                            <div class="wizard-desc">User's Communication Information</div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($this->role == 31 || $this->role == 21 || $this->role == 1){?>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">4</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Salary</div>
                                            
                                        </div>
                                    </div>
                                </div>
                                 <?php }?>
                            </div>
                        </div>
                        <!--end::Wizard Nav-->
                        <!--begin::Card-->
                        <div class="card card-custom card-shadowless rounded-top-0">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                    <div class="col-xl-12 col-xxl-10">
                                        <!--begin::Wizard Form-->
                                        <form class="form" id="kt_form" action="<?php echo base_url() ?>hr/doEditEmployees" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                                            <div class="row justify-content-center">
                                                <div class="col-xl-9">
                                                    <!--begin::Wizard Step 1-->
                                                    <div class="my-2 step" data-wizard-type="step-content" data-wizard-state="current">
                                                        <h5 class="text-dark font-weight-bold mb-10">Personal Information:</h5>                                                     
                                                        <!--begin::Group-->
                                                        <input type="text" name="id" value="<?= base64_encode($employees->id) ?>" hidden="">
                        
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Full Name <span class="text-danger">*</span></label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input class="form-control form-control-solid " name="name" type="text" value="<?= $employees->name ?>" required />
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                 <input size="16" type="text" class="form-control form-control-solid date_sheet"  name="birth_date" id="birth_date" value="<?= $employees->birth_date ?>" required="">
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                       
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Gender <span class="text-danger">*</span></label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <select name="gender" class="form-control form-control-solid " id="gender" required="">
                                                                    <option disabled="disabled" selected="selected">-- Select Gender --</option>
                                                                    <option value="1" <?=$employees->gender == 1?'selected':''?>>Male</option>
                                                                    <option value="2" <?=$employees->gender == 2?'selected':''?>>Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">National ID/Passport ID <span class="text-danger">*</span></label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input class="form-control form-control-solid " name="national_id" type="text" value="<?= $employees->national_id ?>" required />
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                    </div>
                                                    <!--end::Wizard Step 1-->
                                                    <!--begin::Wizard Step 2-->
                                                    <div class="my-5 step" data-wizard-type="step-content">
                                                        <h5 class="text-dark font-weight-bold mb-10 mt-5">Positioning Data</h5>
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-xl-3 col-lg-3">Division <span class="text-danger">*</span></label>
                                                            <div class="col-xl-9 col-lg-9">
                                                               <select name="division" onchange="getDepartment()" class="form-control form-control-solid" id="division" required="">
                                                                    <?= $this->hr_model->selectDivision($employees->division) ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label" for="Function">Function <span class="text-danger">*</span></label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                <select name="department" onchange="getTitle()" class="form-control form-control-solid" id="department" required />
                                                                <?= $this->hr_model->selectDepartment($employees->department, $employees->division) ?> 
                                                                </select>
                                                            </div>
                                                        </div>

                                                            <div class="form-group row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label " for="Position">Position <span class="text-danger">*</span></label>

                                                                <div class="col-xl-9 col-lg-9">
                                                                    <select name="title" onchange="getTitleData();getDirectManagerByTitle();" class="form-control form-control-solid" id="title" required />
                                                                    <option></option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label" for="data"></label>
                                                                <div class="col-xl-9 col-lg-9" id="titleData">
                                                                     <?= $this->hr_model->getTitleData($employees->title) ?>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label" for="Direct Manager">Direct Manager</label>

                                                                <div class="col-xl-9 col-lg-9">
                                                                    <select name="manager" class="form-control form-control-solid" id="manager">
                                                                       <?= $this->hr_model->getDirectManagerByTitle($employees->title) ?>
                                                                    </select>
                                                                </div>
                                                            </div>  
                                                        <div class="separator separator-dashed my-10"></div>
                                                        <h5 class="text-dark font-weight-bold mb-10">Details</h5>
                                                       <div class="form-group row">
                                                            <div class="col-xl-6">
                                                                 <label class=" col-form-label" for="Time Zone">Time Zone <span class="text-danger">*</span></label>                                                            
                                                                     <input type="text" class=" form-control form-control-solid" name="time_zone" data-maxlength="300" value="<?= $employees->time_zone ?>" id="time_zone" required="" >
                                                             </div>
                                                             <div class="col-xl-6">
                                                                 <label class="col-form-label" for="Office Location">Office Location <span class="text-danger">*</span></label>
                                                                 <input type="text" class=" form-control form-control-solid" name="office_location" data-maxlength="300" id="office_location" value="<?= $employees->office_location ?>" required="" >

                                                             </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-xl-4">
                                                                <label class="col-form-label"> Hiring Date <span class="text-danger">*</span></label>
                                                                 <input size="16" type="text" class="form-control date_sheet form-control-solid"  value="<?= $employees->hiring_date ?>" name="hiring_date" id="hiring_date" required="">
                                                            </div>
                                                       
                                                            <div class="col-xl-4">
                                                                <label class="col-form-label"> Probationay Period</label>
                                                                <input type="text" class=" form-control date_sheet form-control-solid" name="prob_period" data-maxlength="300" id="prob_period"  value="<?= $employees->prob_period ?>" >
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <label class="col-form-label"> Contract Date</label>
                                                               <input size="16" type="text" class="form-control date_sheet form-control-solid"  name="contract_date" id="contract_date"  value="<?= $employees->contract_date ?>">

                                                            </div>
                                                        </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-6">
                                                        <label class="col-form-label" for="Contract Type">Contract Type <span class="text-danger">*</span></label> 
                                                        <div class="col-lg-12">
                                                            <select name="contract_type" class="form-control form-control-solid" id="contract_type" required="">
                                                                <option disabled="disabled" selected="selected">-- Select Contract Type --</option>
                                                                <option value="1"<?=$employees->contract_type == 1?'selected':''?>>Full Time</option>
                                                                <option value="2"<?=$employees->contract_type == 2?'selected':''?>>Part Time</option>
                                                            </select>
                                                        </div>
                                                        </div>
                                                         <div class="col-xl-6">
                                                            <label class="col-form-label">Workplace Model</label>
                                                                <select name="workplace_model" class="form-control form-control-solid">
                                                                    <option disabled="disabled" selected="selected">-- Select Type --</option>
                                                                    <option value="office" <?= $employees->workplace_model == 'office' ? 'selected' : '' ?>>Office</option>
                                                                    <option value="hybrid" <?= $employees->workplace_model == 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
                                                                    <option value="remotely" <?= $employees->workplace_model == 'remotely' ? 'selected' : '' ?>>Remotely</option>
                                                                </select>
                                                            
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">Brand <span class="text-danger">*</span></label>
                                                        <div class="col-lg-12">
                                                            <select name="brand[]" class="form-control form-control-solid" id="brand" multiple="" requird>                                           
                                                                <?= $this->admin_model->selectBrand() ?>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                        <div class="separator separator-dashed my-10"></div>
                                                            <div class="form-group row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label" for="Employee Status">Employee Status <span class="text-danger">*</span></label>
                                                                <div class="-col-xl-9 col-lg-9">
                                                                    <select name="status" class="form-control form-control-solid" onchange="employeeStatus()" id="status" required="">
                                                                        <option disabled="disabled" selected="selected">-- Select Employee Status --</option>
                                                                        <option value="0"<?=$employees->status == 0?"selected":""?>>Working</option>
                                                                        <option value="1"<?=$employees->status == 1?"selected":""?>>Resigned</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php if ($employees->status == 0) {
                                    $hide = "style='display:none;'";
                                } else {
                                    $hide = "";
                                } ?>
                                                            <div class="form-group row" id="employeeResignation" <?= $hide ?>>
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Resignation Date</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <input size="16" type="text" value="<?= $employees->resignation_date ?>" class="form-control date_sheet form-control-solid"  name="resignation_date" id="resignation_date" required="">

                                                                </div>
                                                            </div>
                                                                 <div class="form-group row"id="position_comment">                      

                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Comment </label>

                                                                    <div class="col-xl-9 col-lg-9">
                                                                        <textarea name="position_comment" class="form-control form-control-solid" rows="6"> </textarea>
                                                                    </div>
                                                                </div>
                               
                                                    </div>
                                                    <!--end::Wizard Step 2-->
                                                    <!--begin::Wizard Step 3-->
                                                    <div class="my-5 step" data-wizard-type="step-content">
                                                        <h5 class="mb-10 font-weight-bold text-dark">Communication Information</h5>
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label" for="Email">Email</label>
                                                            <div class="col-xl-6 col-lg-6">
                                                                <input type="text" class=" form-control form-control-solid" name="email2" data-maxlength="300"  required="" >
                                                            </div>
                                                              <a class="btn bt-sm btn-light-primary" onClick="addEmails();" title="Add Email"><i
                                            class="fa fa-plus p-0"></i></a>
                                                        </div>
                                                        <div id="other_emails"></div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label" for="Phone Number">Phone Number</label>

                                                            <div class="col-xl-9 col-lg-9">
                                                                <input type="text" class=" form-control form-control-solid" name="phone2" data-maxlength="300"  required="">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label" for="Emergency Contact">Emergency Contact</label>

                                                            <div class="col-xl-9 col-lg-9">
                                                                <input type="text" class=" form-control form-control-solid" name="emergency" data-maxlength="300" id="emergency">
                                                            </div>
                                                        </div>
                                                            <!--end::Group-->
                                                        
                                                       
                                                    </div>
                                                    <!--end::Wizard Step 3-->
                                                      <?php if($this->role == 31 || $this->role == 21 || $this->role == 1){?>
                                                    <!--begin::Wizard Step 4-->
                                                    <div class="my-5 step" data-wizard-type="step-content">
                                                    <div class="form-group row">  
                                                        <label class="col-lg-3 col-form-label" for="Salary">Salary</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <input type="number" class=" form-control form-control-solid" name="salary"  />
                                                            </div>
                                                    </div>
                                                    </div>
                                                    <!--end::Wizard Step 4-->
                                                     <?php }?>
                                                    <!--begin::Wizard Actions-->
                                                    <div class="d-flex justify-content-between border-top pt-10 mt-15">
                                                        <div class="mr-2">
                                                            <button type="button" id="prev-step" class="btn btn-light-primary font-weight-bolder px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                                            <button type="button" id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next" onclick="checkRequired()">Next</button>
                                                        </div>
                                                    </div>
                                                    <!--end::Wizard Actions-->
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Wizard Form-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Wizard-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<script>
     function addEmails() {
        var emailDiv = "<div class ='form-group row'><label class='col-lg-3 control-label'></label><div class='col-lg-6'><input type='text' class=' form-control' name='other_emails[]'  data-maxlength='300' required ></div> <a class='btn btn-sm  btn-danger delEmail' ><i class='fa fa-trash p-0'></i></a></div>";
        $("#other_emails").append(emailDiv);
    }
    $(document).on("click", ".delEmail", function (event) {
        $(this).parent().remove();
    });
    
    var $select = $('select').select2();
    $select.each(function(i,item){  
      $(item).select2("destroy");
    });
    
    function checkRequired() {
       var elements = $(".step[data-wizard-state='current'] .required");
        for (var i=0; i<elements.length; i++) {
            alert('sdfhsdgfhbs');
//        alert(elements[i]);
    }
}
</script>