<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">  Edit Journal </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" id="form"action="<?php echo base_url()?>accounting/doEditJournal" method="post" name="journal" onsubmit="return journalFormValidation();" enctype="multipart/form-data">
                 <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
	
                          <div class="card-body"> 

                          <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >ID</label>
                                <div class="col-lg-6">
                                    <input type="text" disabled class="form-control m-b" value="<?=$row->id?>">
                                </div>
                            </div>              
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Entry Description</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control m-b" name="entry_description" data-maxlength="300" value="<?=$row->entry_description ?>" id="first_name" placeholder="Entry Description" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Description</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control m-b" name="description" data-maxlength="300" value="<?=$row->description ?>" id="last_name" placeholder="Description"  required>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" >Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency"value="" required="" class="form-control m-b">
                                        <option disabled="" selected="">-- Select --</option>
                                        <?=$this->admin_model->selectCurrency($row->currency)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="type">Date</label>
                                <div class="col-lg-6">
                                   <input type="text" class="date_sheet form-control" name="date" value="<?=$row->date?>" id="date"  required="">

                                </div>

                            </div>
                            <?php  $balance = 0;$i=1;
                            foreach($transaction->result() as $transaction_row){ 
                                   if($transaction_row->debit_credit == 1){
                                        $balance = $balance + $transaction_row->amount;
                                   }elseif($transaction_row->debit_credit == 2){
                                        $balance = $balance - $transaction_row->amount;
                                   }
                                 ?>
                         <div class="pair">
                           <input type="text" class="tid" name="tID_<?= $i?>" hidden="" value="<?=$transaction_row->id?>">
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right'>Amount</label>
                                <div class='col-lg-6'>
                                    <input type='text' class='form-control amount m-b' onblur="calculateBalance();" placeholder="Amount" name="amount_<?= $i?>" value="<?=$transaction_row->amount?>" id="amount_<?= $i ?>" required="">
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Debit or Credit</label>
                                <div class='col-lg-6'>
                                    <select name='debit_credit_<?= $i?>' onchange="calculateBalance();" id='debit_credit_<?= $i?>' class="form-control m-b">
                                       <option  disabled="" selected="">-- Select --</option>
                                       <?=$this->accounting_model->selectDepitOrCredit($transaction_row->debit_credit)?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' for='inputPassword'>Bank</label>

                                <div class='col-lg-6'>
                                    <select name='bank_<?= $i?>'id='bank_<?= $i?>' class="form-control m-b">
                                        <option  disabled="" selected="">-- Select --</option>
                                       <?=$this->accounting_model->selectPaymentMethod($transaction_row->bank,$this->brand)?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' >Section</label>

                                <div class='col-lg-6'>
                                    <select name='section_name_<?= $i?>' id='section_name_<?= $i?>'class="form-control m-b" onchange="getCategories(<?= $i?>)">
                                        <option disabled="" selected="">-- Select --</option>
                                        <?=$this->accounting_model->selectSection($transaction_row->section_id)?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' >Category</label>
                                <div class='col-lg-6'>
                                    <select name='category_name_<?= $i?>' id='category_name_<?= $i?>'required="" class="form-control m-b" onchange="getSupCategories(<?= $i?>)">
                                        <option disabled="" value="" selected="">-- Select --</option>
                                        <?=$this->accounting_model->selectCategory($transaction_row->category_id,$transaction_row->section_id)?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label class='col-lg-3 col-form-label text-right' >Sup Category</label>
                                <div class='col-lg-6'>
                                    <select name='sup_category_<?= $i?>' id='sup_category_<?= $i?>' required=""class="form-control m-b">
                                        <option disabled="" value="" selected="">-- Select --</option>
                                        <?=$this->accounting_model->selectSupCategory($transaction_row->sup_category,$transaction_row->category_id)?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                              <div class="offset-5 col-lg-6">
                                <a class="btn btn-danger" onclick='deletePairInEditMode(this)'  title="delete" >Delete</a>
                              </div>
                             </div>
                            <hr>

                             </div>
                             <?php $i++;}?>
                            <div id="pairs">
                                
                            </div>
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="type">Balance</label>
                                <div class="col-lg-6">
                                   <input size="16" autocomplete="off"readonly type="text" class="form-control m-b" name="balance" id="balance" value="<?=$balance?>" >
                                </div>

                            </div>
                            <div class="form-group row">
                              <div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addNewPair()" class="btn btn-primary">Add Transaction</a>
                                  <input type="text" name="new_pair" id="new_pair" value="<?php echo $transaction->num_rows()+1;?>" hidden>
                             </div>
                             <input name="deletedTransactions" id="deletedTransactions" type="hidden">
                             
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
                                        <option disabled=''value='' selected=''>-- Select --</optiosn>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class='form-group row'>
                              <div class='offset-5 col-lg-6'>
                                <a class='btn btn-danger' onclick='deletePairInEditMode(this)' title='delete' >Delete</a>
                              </div>
                             </div>
                            <hr></div>`);
            var newInput = parseInt(x) + 1;
            $("#new_pair").val(newInput);
        }
    
    </script>