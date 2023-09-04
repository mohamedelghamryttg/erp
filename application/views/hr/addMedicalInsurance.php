<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Medical Insurance
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddMedicalInsurance" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Employee Name</label>

                                <div class="col-lg-6">
                                    <select name="employee_id" class="form-control m-b" id="employee_id" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectEmployee()?>
                                    </select>
                                </div>
                            </div>

                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Year</label>

                                <div class="col-lg-6">
                                    <select name="year" class="form-control m-b" id="year" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectYear()?>
                                    </select>
                                </div>
                            </div>
            
                                    <div id="familyMembers" >
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="CRT">CRT</label>

                                            <div class="col-lg-1">
                                                <input type="number" class=" form-control" name="crt" id="crt" required="">
                                            </div>
                                        
                                            <label class="col-lg-2 control-label" for="Activation date">Activation date</label>

                                            <div class="col-lg-3">
                                                <input type="text" class="datepicker form-control" autocomplete="off" name="activation_date" id="activation_date" required="">
                                            </div>
                                         </div>
                                    <div class="form-group">
                                            <label class="col-lg-3 control-label" for="Detect from Salary">Detect from Salary</label>

                                            <div class="col-lg-6">
                                               <select name="deduction" class="form-control m-b" id="deduction" required="">
                                        			<option value="1">Yes</option>
                                        			<option value="2">No</option>
                                    			</select>
                                            </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="Family Members Num:">Family Members Num:</label>

                                        <div class="col-lg-6">
                                            <input type="number" value="0" onchange="addFamilyMember()" class=" form-control" name="members" data-maxlength="300" id="members" required="">
                                        </div>
                                    </div>
                                </div>
            
                                <div id="familyMembersData">
                                    
                                </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>hr/medicalInsurance" class="btn btn-default" type="button">Cancel</a>
                                </div>
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
    </script>


    <script type="text/javascript">
        function viewFamilyMembers(){
            var insured = $("#insured").val();
            if(insured == 1){
                $("#familyMembers").show();
            }else if(insured == 2){
                $("#familyMembers").hide();
            }
        }
    
        function addFamilyMember(){
            var members = $("#members").val();
            $("#familyMembersData").html("");
            for(var i=1;i<=members;i++){
                $("#familyMembersData").append(`
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Member `+i+`:">Member `+i+`:</label>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Name">Name:</label>

                    <div class="col-lg-6">
                        <input type="text" class=" form-control" name="name_`+i+`" id="name_`+i+`" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Date Of Birth">Date Of Birth:</label>

                    <div class="col-lg-6">
                        <input type="text" class="datepicker form-control" autocomplete="off" name="birth_date_`+i+`" id="birth_date_`+i+`" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Activation Date">Activation Date:</label>

                    <div class="col-lg-2">
                        <input type="text" class="datepicker form-control" autocomplete="off" name="activation_date_`+i+`" id="activation_date_`+i+`" required="">
                    </div>
                    
                    <label class="col-lg-1 control-label" for="Type">Type:</label>
                    <div class="col-lg-3">
                        <select name="type_`+i+`" class="form-control m-b" id="type_`+i+`" required="">
                            <option disabled="disabled" selected="selected">-- Select Contract Type --</option>
                            <option value="1">Supose</option>
                            <option value="2">Child</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Annual Fees">Annual Fees:</label>

                    <div class="col-lg-6">
                        <input type="number" class=" form-control" name="fees_`+i+`" id="fees_`+i+`" required="">
                    </div>
                </div>
            `);
            }
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        }
    </script>