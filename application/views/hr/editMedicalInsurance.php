<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Medical Insurance
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doEditMedicalInsurance" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                        
                        <input type="text" name="id" value="<?=base64_encode($medical->id)?>" hidden="">
                        <input type="text" name="employee_id_old" value="<?=base64_encode($medical->employee_id)?>" hidden="">
                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Employee Name</label>

                                <div class="col-lg-6">
                                    <select name="employee_id" class="form-control m-b" id="employee_id"  required="">
                                        <option></option>
                                        <?=$this->hr_model->selectEmployee($medical->employee_id)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Year</label>

                                <div class="col-lg-6">
                                    <select name="year" class="form-control m-b" id="year" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectYear($medical->year)?>
                                    </select>
                                </div>
                            </div>
            
                            <div id="familyMembers" >
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="CRT">CRT</label>

                                    <div class="col-lg-1">
                                        <input type="number" class=" form-control" name="crt" id="crt" value="<?=$medical->crt?>" required="">
                                    </div>
                                
                                    <label class="col-lg-2 control-label" for="Activation date">Activation date</label>

                                    <div class="col-lg-3">
                                        <input type="text" class="datepicker form-control" name="activation_date" id="activation_date" value="<?=$medical->activation_date?>"required="">
                                    </div>
                                    </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Detect from Salary">Detect from Salary</label>

                                <div class="col-lg-6">
                                    <select name="deduction" class="form-control m-b" id="deduction" required />
                                        <?php if($medical->deduction == 1){ ?>
                                        <option value="1" selected="">Yes</option>
                                        <option value="2">No</option>
                                        <?php }else{ ?>
                                        <option value="1">Yes</option>
                                        <option value="2" selected="">No</option>
                                        <?php } ?>
                                    </select>
                                  </div>
                                 </div>
                    
                                </div>
            
                                <div id="familyMembersOld">
                                	<hr>
                                    <?php foreach($family as $familyRow){ ?>
                                		<div id="memberTable_<?=$familyRow->id?>">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="Name">Name:</label>

                                            <div class="col-lg-6">
                                                <input type="text" class=" form-control" name="name_table_<?=$familyRow->id?>" id="name_table_<?=$familyRow->id?>" value="<?=$familyRow->name?>" required="">
                                            </div>

                                           <div class=" col-lg-3">
                                            <a onclick="removeFamilyMemberTable(<?=$familyRow->id?>)" class="btn btn-danger" > Delete </a>
                                        </div> 
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="Date Of Birth">Date Of Birth:</label>

                                            <div class="col-lg-6">
                                                <input type="text" class="datepicker form-control" name="birth_date_table_<?=$familyRow->id?>" id="birth_date_table_<?=$familyRow->id?>" value="<?=$familyRow->birth_date?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="Activation Date">Activation Date:</label>

                                            <div class="col-lg-2">
                                                <input type="text" class="datepicker form-control" name="activation_date_table_<?=$familyRow->id?>" id="activation_date_table_<?=$familyRow->id?>" value="<?=$familyRow->activation_date?>" required="">
                                            </div>

                                            <label class="col-lg-1 control-label" for="Type">Type:</label>
                                            <div class="col-lg-3">
                                                <select name="type_table_<?=$familyRow->id?>" class="form-control m-b" id="type_table_<?=$familyRow->id?>" required="">
                                                    <?php if($familyRow->type == 1){ ?>
                                                    <option value="1" selected="">Supose</option>
                                                    <option value="2">Child</option>
                                                    <?php }else if($familyRow->type == 2){ ?>
                                                    <option value="1">Supose</option>
                                                    <option value="2" selected="">Child</option>
                                                    <?php }else{ ?>
                                                    <option value="1">Supose</option>
                                                    <option value="2">Child</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="Annual Fees">Annual Fees:</label>

                                            <div class="col-lg-6">
                                                <input type="number" class=" form-control" name="fees_table_<?=$familyRow->id?>" id="fees_table_<?=$familyRow->id?>" value="<?=$familyRow->fees?>" required="">
                                            </div>
                                        </div>
       									
                                		<hr>
                                	</div>
                                    <?php } ?>
                                </div>
                
                                <div class="form-group">
                              <div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addFamilyMember()" style="color:#fff;" class="btn btn-primary">Add Family Member +</a>
                                  <a onclick="deleteFamilyMember()" class="btn btn-danger">Delete Last One -</a>
                                  <input type="text" name="new_res" id="new_res" value="1" hidden>
                              </div>
                            </div>
            
                                <div id="familyMembersData">
                                    
                                </div>
							<hr>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>hr/structure" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>




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
            var i = $("#new_res").val();
            $("#familyMembersData").append(`
				<div id="member_`+i+`">
				<hr>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Name">Name:</label>

                    <div class="col-lg-6">
                        <input type="text" class=" form-control" name="name_`+i+`" id="name_`+i+`" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Date Of Birth">Date Of Birth:</label>

                    <div class="col-lg-6">
                        <input type="text" class="datepicker form-control" name="birth_date_`+i+`" id="birth_date_`+i+`" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="Activation Date">Activation Date:</label>

                    <div class="col-lg-2">
                        <input type="text" class="datepicker form-control" name="activation_date_`+i+`" id="activation_date_`+i+`" required="">
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
				</div>
            `);

                var newInput = parseInt(i) + 1;
                // alert(newInput);
                $("#new_res").val(newInput); 
        
        	$('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });

        }
    
    	function deleteFamilyMember(){
        	var i = $("#new_res").val();
        	if(i == 1){
            	alert("There's no rows to delete ..");
            }else if(i > 1){
            	var newInput = parseInt(i) - 1;
            	$("#member_"+newInput).remove();
            	$("#new_res").val(newInput); 
            }
        }


    </script>


        <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>