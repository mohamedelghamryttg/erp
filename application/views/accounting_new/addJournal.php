<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Journal</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" id="form"action="<?php echo base_url()?>accounting/doAddjournal" method="post" name="journal" onsubmit="return journalFormValidation();" enctype="multipart/form-data">
				<div class="card-body">
					
                           <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >ID</label>
                                <div class="col-lg-6">
                                    <input type="text" disabled class="form-control m-b" value="<?=$journal_id?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Entry Description</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control m-b" name="entry_description" data-maxlength="300" id="first_name" placeholder="Entry Description" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Description</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control m-b" name="description" data-maxlength="300" id="last_name" placeholder="Description"  required="">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency"value="" required="" class="form-control m-b">
                                        <option value="" disabled="" selected="">-- Select --</option>
                                        <?=$this->admin_model->selectCurrency()?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="type">Date</label>
                                <div class="col-lg-6">
                                   <input type="text" class="date_sheet form-control" name="date" id="date"  required="">

                                </div>

                            </div>
                            <div class='pair'>
                                <div class='form-group row'>
                                    <label class='col-lg-3 col-form-label text-right'>Amount</label>
                                    <div class='col-lg-6'>
                                        <input type='text' placeholder='Amount' class='form-control m-b' onblur="calculateBalance();" name='amount_1' id='amount_1' required=''>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Debit or Credit</label>
                                    <div class='col-lg-6'>
                                        <select onchange="calculateBalance();" name='debit_credit_1' id='debit_credit_1'class='form-control m-b debit_credit' value="" required="">
                                            <option value="" disabled='' selected=''>-- Select --</option>
                                            <option  value='1'>Debit</option>
                                            <option  value='2'>Credit</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class='form-group row'>
                                    <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Bank</label>

                                    <div class='col-lg-6'>
                                        <select name='bank_1'id='bank_1'value="" required=""class='form-control m-b'>
                                            <option value="" disabled='' selected=''>-- Select --</option>
                                            <?=$this->accounting_model->selectPaymentMethod(0,$this->brand)?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class='col-lg-3 col-form-label text-right' >Section</label>

                                    <div class='col-lg-6'>
                                        <select name='section_name_1' id='section_name_1' class='form-control m-b' id='section' onchange='getCategories(1)' value="" required="">
                                            <option value="" disabled='' selected=''>-- Select --</option>
                                            <?=$this->accounting_model->selectSection()?>
                                        </select>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class='col-lg-3 col-form-label text-right' >Category</label>
                                    <div class='col-lg-6'>
                                        <select name='category_name_1' id='category_name_1' class='form-control m-b' id='category'onchange='getSupCategories(1)' required="">
                                            <option value="" disabled='' selected=''>-- Select --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <label class='col-lg-3 col-form-label text-right' >Sup Category</label>
                                    <div class='col-lg-6'>
                                        <select name='sup_category_1' id='sup_category_1' class='form-control m-b' value="" required="">
                                            <option disabled='' value="" selected=''>-- Select --</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                <div class="offset-5 col-lg-6">
                                    <a class="btn btn-danger" onclick='deletePairInAddMode(this)' title="delete" >Delete</a>
                                </div>
                                </div>
                                <hr>
                            </div>
                            <div id="pairs">
                                
                             </div>
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="type">Balance</label>
                                <div class="col-lg-6">
                                   <input size="16" autocomplete="off"readonly type="text" class="form-control m-b" name="balance" id="balance" value="0" >
                                </div>

                            </div>
                            <div class="form-group row">
                              <div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addNewPair()" class="btn btn-primary">Add Transaction</a>
                                  <input type="text" name="new_pair" id="new_pair" value="2" hidden>
                              </div>
                             </div>
                             
                            
						
				</div>
					
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
                             <button class="btn btn-primary"name="save" type="submit">Save</button> 
                             <a href="<?php echo base_url()?>accounting/journal" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>
<script type="text/javascript">
        function addNewPair(){
            var x = $("#new_pair").val();
            $("#pairs").append(`
                <div id='pair_`+x+`' class='pair'>
                <div class='form-group row'>
                <label class='col-lg-3 col-form-label text-right'>Amount</label>
         <div class='col-lg-6'><input type='text' placeholder='Amount'onblur="calculateBalance();" class='form-control amount' name='amount_`+x+`' id='amount_`+x+`' required=''>
                                </div>
                                </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Debit or Credit</label>
                                <div class='col-lg-6'>
                                    <select name='debit_credit_`+x+`' required='' onchange="calculateBalance();" id='debit_credit_`+x+`'class='form-control m-b debit_credit' required=''>
                                        <option value='' disabled='' selected=''>-- Select --</option>
                                        <option  value='1'>Debit</option>
                                        <option  value='2'>Credit</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right'required='' >Bank</label>

                                <div class='col-lg-6'>
                                    <select name='bank_`+x+`'id='bank_`+x+`'class='form-control m-b' required=''>
                                        <option disabled=''value='' selected=''>-- Select --</option>
                                        <?=$this->accounting_model->selectPaymentMethod(0,$this->brand)?>
                                       
                                    </select>
                                </div>
                            </div>
                             <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' >Section</label>

                                <div class='col-lg-6'>
                                    <select name='section_name_`+x+`'required='' id='section_name_`+x+`' class='form-control m-b' onchange='getCategories(`+x+`)' required=''>
                                        <option disabled=''value='' selected=''>-- Select --</option>
                                        <?=$this->accounting_model->selectSection()?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' >Category</label>
                                <div class='col-lg-6'>
                                    <select name='category_name_`+x+`'required='' id='category_name_`+x+`' class='form-control m-b' id='category'onchange='getSupCategories(`+x+`)' required=''>
                                        <option disabled='' value='' selected=''>-- Select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' >Sup Category</label>
                                <div class='col-lg-6'>
                                    <select name='sup_category_`+x+`' required='' id='sup_category_`+x+`' class='form-control m-b'  >
                                        <option disabled=''value='' selected=''>-- Select --</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'>
                              <div class='offset-5 col-lg-6'>
                                <a class='btn btn-danger' onclick='deletePairInAddMode(this)' title='delete' >Delete</a>
                              </div>
                             </div>
                            <hr></div>`);
            var newInput = parseInt(x) + 1;
            $("#new_pair").val(newInput);
        }


    </script>