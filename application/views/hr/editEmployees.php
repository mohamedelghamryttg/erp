<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector: 'textarea.resignation_comment_text' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Employee
            </header>

            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal "
                        action="<?php echo base_url() ?>hr/doEditEmployees/<?= $employees->id ?>" method="post"
                        enctype="multipart/form-data">

                        <input type="text" name="id" value="<?= base64_encode($employees->id) ?>" hidden="">
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
                               <?php if($this->role == 31 || $this->role == 21 || $this->role == 1){?>
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
                                        <input type="text" class=" form-control" name="name"
                                            value="<?= $employees->name ?>" data-maxlength="300" id="name" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Birth Date">Date of Birth</label>

                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control" name="birth_date"
                                            value="<?= $employees->birth_date ?>" id="birth_date" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Gender">Gender</label>

                                    <div class="col-lg-6">
                                        <select name="gender" class="form-control m-b" id="gender" required />
                                        <option disabled="disabled" selected="">-- Select Gender --</option>
                                        <?php if ($employees->gender == 1) { ?>
                                            <option value="1" selected="">Male</option>
                                            <option value="2">Femal</option>
                                        <?php } else { ?>
                                            <option value="1">Male</option>
                                            <option value="2" selected="">Female</option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="National ID">National ID</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="national_id"
                                            value="<?= $employees->national_id ?>" minlength="14" id="national_id"
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
                                            id="division" required />
                                        <option disabled="disabled" selected="" value=""></option>
                                        <?= $this->hr_model->selectDivision($employees->division) ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Function">Function</label>

                                    <div class="col-lg-6">
                                        <select name="department" onchange="getTitle()" class="form-control m-b"
                                            id="department" required />
                                        <option></option>
                                        <?= $this->hr_model->selectDepartment($employees->department, $employees->division) ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Position">Position</label>

                                    <div class="col-lg-6">
                                        <select name="title" onchange="getTitleData();getDirectManagerByTitle();"
                                            class="form-control m-b" id="title" required />
                                        <option disabled="disabled" selected="" value=""></option>
                                        <?= $this->hr_model->selectPosition($employees->title, $employees->department, $employees->division) ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="data"></label>
                                    <div class="col-lg-6" id="titleData">
                                        <?= $this->hr_model->getTitleData($employees->title) ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Direct Manager">Direct Manager</label>

                                    <div class="col-lg-6">
                                        <select name="manager" class="form-control m-b" id="manager" />

                                        <?= $this->hr_model->getDirectManagerByTitle($employees->title) ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Time Zone">Time Zone</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="time_zone"
                                            value="<?= $employees->time_zone ?>" data-maxlength="300" id="time_zone"
                                            required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Office Location">Office Location</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="office_location"
                                            value="<?= $employees->office_location ?>" data-maxlength="300"
                                            id="office_location" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3"> Hiring Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control" name="hiring_date"
                                            value="<?= $employees->hiring_date ?>" id="hiring_date" required="">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Probationay Period">Probationay
                                        Period</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="prob_period"
                                            value="<?= $employees->prob_period ?>" data-maxlength="300" id="prob_period"
                                            readonly="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3"> Contract Date</label>
                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="contract_date"
                                            value="<?= $employees->contract_date ?>" data-maxlength="300"
                                            id="contract_date">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Contract Type">Contract Type</label>

                                    <div class="col-lg-6">
                                        <select name="contract_type" class="form-control m-b" id="contract_type"
                                            required />
                                        <option disabled="disabled" selected="">-- Select Contract Type --</option>
                                        <?php if ($employees->contract_type == 1) { ?>
                                            <option value="1" selected="">Full Time</option>
                                            <option value="2">Part Time</option>
                                        <?php } elseif ($employees->contract_type == 2) { ?>
                                            <option value="1">Full Time</option>
                                            <option value="2" selected="">Part Time</option>
                                        <?php } else { ?>
                                            <option value="1">Full Time</option>
                                            <option value="2">Part Time</option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Workplace Model">Workplace Model</label>

                                    <div class="col-lg-6">
                                        <select name="workplace_model" class="form-control m-b" id="workplace_model">
                                            <option disabled="disabled" selected="">-- Select Type --</option>
                                            <option value="office" <?= $employees->workplace_model == 'office' ? 'selected' : '' ?>>Office</option>
                                            <option value="hybrid" <?= $employees->workplace_model == 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
                                            <option value="remotely" <?= $employees->workplace_model == 'remotely' ? 'selected' : '' ?>>Remotely
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Employee Status">Employee Status</label>
                                    <div class="col-lg-6">
                                        <select name="status" onchange="employeeStatus()" class="form-control m-b"
                                            id="status" required />
                                        <option disabled="disabled" selected="">-- Select Employee Status--</option>
                                        <?php if ($employees->status == 0) { ?>
                                            <option value="0" selected="">Working</option>
                                            <option value="1">Resigned</option>
                                        <?php } elseif ($employees->status == 1) { ?>
                                            <option value="0">Working</option>
                                            <option value="1" selected="">Resigned</option>
                                        <?php } else { ?>
                                            <option value="0">Working</option>
                                            <option value="1">Resigned</option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if ($employees->status == 0) {
                                    $hide = "style='display:none;'";
                                } else {
                                    $hide = "";
                                } ?>
                                <div class="form-group" id="employeeResignation" <?= $hide ?>>
                                    <label class="control-label col-lg-3">Resignation Date</label>
                                    <div class="col-lg-6">
                                        <input size="16" type="text" class="datepicker form-control"
                                            name="resignation_date" value="<?= $employees->resignation_date ?>"
                                            id="resignation_date">

                                    </div>s
                                </div>

                                <div class="form-group" id="resignation_reason" style="display:none">
                                    <label class="col-lg-3 control-label">Resignation Reason</label>

                                    <div class="col-lg-6">
                                        <select name="resignation_reason" class="form-control m-b">
                                            <option disabled="disabled" selected="" value=""> -- Select --</option>
                                            <?= $this->hr_model->selectResignationReason() ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="resignation_comment" style="display:none">
                                    <label class="col-lg-3 control-label">Resignation Reason</label>

                                    <div class="col-lg-6">
                                        <textarea name="resignation_comment"
                                            class="form-control resignation_comment_text" rows="6"> </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">select brand</label>

                                    <div class="col-lg-6">
                                        <select name="brand" class="form-control m-b" id="brand">
                                            <option disabled="disabled" selected="">-- Select brand --</option>
                                            <?= $this->admin_model->selectBrand($employees->brand) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="position_comment">
                                    <label class="col-lg-3 control-label">Comment </label>

                                    <div class="col-lg-6">
                                        <textarea name="position_comment" class="form-control"
                                            rows="6"><?= $employees->position_comment ?> </textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Email">Email</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="email"
                                            value="<?= $employees->email ?>" data-maxlength="300" id="email"
                                            required="">
                                    </div>
                                    <a class="btn btn-default" onClick="addEmails();" title="Add Email"><i
                                            class="fa fa-plus"></i></a>
                                </div>
                                <div id="other_emails">
                                    <?php
                                    if (!empty($employees->other_emails)) {
                                        $other_emails = explode(' ; ', $employees->other_emails);
                                        foreach ($other_emails as $email) { ?>
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label" for="Email"></label>

                                                <div class="col-lg-6">
                                                    <input type="text" class=" form-control" name="other_emails[]"
                                                        value="<?= $email ?>" data-maxlength="300" required>
                                                </div>
                                                <a class="btn btn-danger delEmail"><i class="fa fa-minus"></i></a>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Phone Number">Phone Number</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="phone"
                                            value="<?= $employees->phone ?>" data-maxlength="300" id="phone"
                                            required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Emergency Contact">Emergency
                                        Contact</label>

                                    <div class="col-lg-6">
                                        <input type="text" class=" form-control" name="emergency"
                                            value="<?= $employees->emergency ?>" data-maxlength="300" id="emergency">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-6">
                                        <button class="btn btn-primary" type="submit">Save</button> <a
                                            href="<?php echo base_url() ?>hr/employees" class="btn btn-default"
                                            type="button">Cancel</a>
                                    </div>
                                </div>
                            </div>
                                <?php if($this->role == 31 || $this->role == 21 || $this->role == 1){?>
                            <div class="tab-pane fade" id="pills-salary" role="tabpanel"
                                aria-labelledby="pills-salary-tab">  
                                <br/>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="Salary">Salary</label>

                                    <div class="col-lg-6">
                                        <input type="number" class=" form-control" name="salary" value="<?= $this->hr_model->getEmpSalary($employees->id)?>" />
                                    </div>
                                </div>

                 
                            </div>
                              <?php }?>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

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