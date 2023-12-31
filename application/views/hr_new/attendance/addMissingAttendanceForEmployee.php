 <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
     <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add Missing Attendance Request</h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>hr/doAddMissingAttendanceForEmployee" method="post" onsubmit="return disableAddButton();" enctype="multipart/form-data">
                <div class="card-body">
                <div class="form-group row">
                       <label class="col-lg-3 col-form-label text-right">Select Employee Name:</label>

                        <div class="col-lg-6">
                             <select name="emp_id" class="form-control"  required="" >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->getEmployeesNameByManager(); ?> 
                            </select>
                        </div>
                </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Date Time:</label>
                        <div class="col-lg-6">
                            <input name="date"type="text" id="date"autocomplete="off" required=""class="form-control form-control-solid datetimepicker-input date_sheet_day"placeholder="Select date &amp; time" data-toggle="datetimepicker" data-target="#kt_datetimepicker_5"  />

                        </div>
                      
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Signing Type:</label>

                        <div class="col-lg-6">
                            <select name="TNAKEY" id="TNAKEY" required class="form-control">
                                <option value="" disabled="disabled" selected="selected">-- Select Type --</option>
                                <option value="1">Sign In</option>
                                <option value="2">Sign Out</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="role name">Location</label>

                        <div class="col-lg-6">
                            <select name="location" class="form-control m-b" id="location" required >
                                <option value="" disabled="disabled" selected="selected">-- Select Type --</option>
                                <option value="0">Office</option>
                                <option value="1">Home</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>hr/missingAttendance" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
</div>
<script type="text/javascript">
   $(function() {
       $('.date_sheet_day').datetimepicker( {format: 'YYYY-MM-DD HH:mm:ss'}); 

    });
</script>