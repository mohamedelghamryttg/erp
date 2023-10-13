<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Employee
            </header>

            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>hr/doAddEmployees"
                        onsubmit="retunr disableAddButton();" method="post" enctype="multipart/form-data">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">Employee Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Positioning Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Communcation Info</a>
                            </li>
                            <?php if($this->role == 31){?>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-salary-tab" data-toggle="pill" href="#pills-salary"
                                    role="tab" aria-controls="pills-salary" aria-selected="false">Salary</a>
                            </li>
                            <?php }?>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show in" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <br>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Name">Name</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="name" data-maxlength="300"
                                            id="name" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Birth Date">Date of Birth</label>

                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control" name="birth_date"
                                            id="birth_date" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Gender">Gender</label>

                                    <div class="col-lg-6">
                                        <select name="gender" class="form-control m-b" id="gender" required="">
                                            <option disabled="disabled" selected="selected">-- Select Gender --</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="National ID">National ID/Passport
                                        ID</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="national_id" id="national_id"
                                            required="">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <br>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Division">Division</label>

                                    <div class="col-lg-6">
                                        <select name="division" onchange="getDepartment()" class="form-control m-b"
                                            id="division" required="">
                                            <option disabled="disabled" selected="" value=""> -- Select Division --
                                            </option>
                                            <?= $this->hr_model->selectDivision() ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Function">Function</label>

                                    <div class="col-lg-6">
                                        <select name="department" onchange="getTitle()" class="form-control m-b"
                                            id="department" required />
                                        <option></option>
                                        <?= $this->hr_model->selectDepartment() ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Position">Position</label>

                                    <div class="col-lg-6">
                                        <select name="title" onchange="getTitleData();getDirectManagerByTitle();"
                                            class="form-control m-b" id="title" required />
                                        <option></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="data"></label>
                                    <div class="col-lg-6" id="titleData"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Direct Manager">Direct Manager</label>

                                    <div class="col-lg-6">
                                        <select name="manager" class="form-control m-b" id="manager">
                                            <option disabled="disabled" selected="">-- Select Manager --</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Time Zone">Time Zone</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="time_zone" data-maxlength="300"
                                            id="time_zone" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Office Location">Office Location</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="office_location"
                                            data-maxlength="300" id="office_location" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3"> Hiring Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control" name="hiring_date"
                                            id="hiring_date" required="">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3"> Probationay Period</label>
                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="prob_period" data-maxlength="300"
                                            id="prob_period" readonly="">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3"> Contract Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control"
                                            name="contract_date" id="contract_date">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Contract Type">Contract Type</label>

                                    <div class="col-lg-6">
                                        <select name="contract_type" class="form-control m-b" id="contract_type"
                                            required="">
                                            <option disabled="disabled" selected="selected">-- Select Contract Type --
                                            </option>
                                            <option value="1">Full Time</option>
                                            <option value="2">Part Time</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Contract Type">Workplace Model</label>

                                    <div class="col-lg-6">
                                        <select name="workplace_model" class="form-control m-b" id="workplace_model">
                                            <option disabled="disabled" selected="selected">-- Select Type --</option>
                                            <option value="office">Office</option>
                                            <option value="hybrid">Hybrid</option>
                                            <option value="remotely">Remotely</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Employee Status">Employee Status</label>

                                    <div class="col-lg-6">
                                        <select name="status" class="form-control m-b" onchange="employeeStatus()"
                                            id="status" required="">
                                            <option disabled="disabled" selected="selected">-- Select Employee Status --
                                            </option>
                                            <option value="0">Working</option>
                                            <option value="1">Resigned</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="employeeResignation">
                                    <label class="control-label col-lg-3">Resignation Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control"
                                            name="resignation_date" id="resignation_date" required="">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">select brand</label>

                                    <div class="col-lg-6">
                                        <select name="brand" class="form-control m-b" id="brand">
                                            <option disabled="disabled" selected="">-- Select brand --</option>
                                            <?= $this->admin_model->selectBrand() ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="position_comment">
                                    <label class="col-lg-3 control-label">Comment </label>

                                    <div class="col-lg-6">
                                        <textarea name="position_comment" class="form-control" rows="6"> </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Email">Email</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="email" data-maxlength="300"
                                            id="email" required="">
                                    </div>
                                    <a class="btn btn-default" onClick="addEmails();" title="Add Email"><i
                                            class="fa fa-plus"></i></a>
                                </div>
                                <div id="other_emails">
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Phone Number">Phone Number</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="phone" data-maxlength="300"
                                            id="phone" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Emergency Contact">Emergency
                                        Contact</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="emergency" data-maxlength="300"
                                            id="emergency">
                                    </div>
                                </div>
                            </div>
                              <?php if($this->role == 31){?>
                            <div class="tab-pane fade" id="pills-salary" role="tabpanel"
                                aria-labelledby="pills-salary-tab">   
                                <br/>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Salary">Salary</label>
                                    <div class="col-lg-6">
                                        <input type="number" class=" form-control" name="salary"  />
                                    </div>
                                </div>

                 
                            </div>
                              <?php }?>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a
                                        href="<?php echo base_url() ?>hr/employees" class="btn btn-default"
                                        type="button">Cancel</a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
    function viewFamilyMembers() {
        var insured = $("#insured").val();
        if (insured == 1) {
            $("#familyMembers").show();
        } else if (insured == 2) {
            $("#familyMembers").hide();
        }
    }

    function addFamilyMember() {
        var members = $("#members").val();
        $("#familyMembersData").html("");
        for (var i = 1; i <= members; i++) {
            $("#familyMembersData").append(`
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Member `+ i + `:">Member ` + i + `:</label>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Name">Name:</label>

                    <div class="col-lg-6">
                        <input type="text" class=" form-control" name="name_`+ i + `" id="name_` + i + `" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Date Of Birth">Date Of Birth:</label>

                    <div class="col-lg-6">
                        <input type="text" class="datepicker form-control" name="birth_date_`+ i + `" id="birth_date_` + i + `" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Activation Date">Activation Date:</label>

                    <div class="col-lg-2">
                        <input type="text" class="datepicker form-control" name="activation_date_`+ i + `" id="activation_date_` + i + `" required="">
                    </div>
                    
                    <label class="col-lg-1 control-label" for="Type">Type:</label>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Annual Fees">Annual Fees:</label>

                    <div class="col-lg-6">
                        <input type="number" class=" form-control" name="fees_`+ i + `" id="fees_` + i + `" required="">
                    </div>
                </div>
            `);
        }
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    }
</script>

<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    });
    function addEmails() {
        var emailDiv = "<div class ='form-group'><label class='col-lg-3 control-label'></label><div class='col-lg-6'><input type='text' class=' form-control' name='other_emails[]'  data-maxlength='300' required ></div> <a class='btn btn-danger delEmail' ><i class='fa fa-minus'></i></a></div>";
        $("#other_emails").append(emailDiv);
    }
    $(document).on("click", ".delEmail", function (event) {
        $(this).parent().remove();
    });
</script>