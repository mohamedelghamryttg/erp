<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Credit Note 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " onsubmit="return disableAddButton();" action="<?php echo base_url()?>accounting/doEditCreditNote" method="post" enctype="multipart/form-data">
                            <input type="text" name="type" value="<?=base64_encode($row->type)?>" hidden="">
                            <input type="text" name="id" value="<?=base64_encode($row->id)?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Type Of Credit Note</label>

                                 <div class="col-lg-6">
                                    <td><?=$this->accounting_model->getCreditNoteType($row->type)?></td>
                                </div>
                            </div>
                    		<?php if($row->type == 1 || $row->type == 4){ ?>
								<div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Currency</label>
						<input type="text" class=" form-control" name="deductions" id="deductions" value="0" hidden="">
						<input type="text" class=" form-control" name="advanced_payment" id="advanced_payment" value="0" hidden="">
                        <div class="col-lg-6">
                            <select name="currency" class="form-control m-b" id="currency" onchange="getClientInvoicedPOsSingleChoose()" required="" >
                                     <option disabled="disabled" selected="selected">-- Select Currency --</option>
                                     <?=$this->admin_model->selectCurrency($row->currency)?>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Client</label>

                         <div class="col-lg-6">
                            <select name="customer" class="form-control m-b" id="customer"  onchange="getClientInvoicedPOsSingleChoose();" required >
                                     <option value="" selected="selected" disabled="">-- Select Client --</option>
                                     <?=$this->customer_model->selectCustomerBranches($row->customer,$this->brand)?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Issue Date</label>

                        <div class="col-lg-6">
                            <input type="text" class="date_sheet form-control" name="issue_date" id="payment_date" onblur="getClientInvoicedPOsSingleChoose();" value="<?=date("m/d/Y", strtotime($row->issue_date))?>" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name"></label>
                        <div class="col-lg-6" id="invoicedPOs">
                            <?=$this->accounting_model->getClientInvoicedPOsSingleChoose($row->po,$row->customer,date("m/d/Y", strtotime($row->issue_date)),$row->currency)?>
                        </div>
                    </div>

					<div class="form-group">
                       <label class="col-lg-3 control-label" for="rate">PO Amount</label>
						<?php $poData = $this->projects_model->totalRevenuePO($row->po); ?>
                       <div class="col-lg-6">
                         <input type="number" onkeypress="return rateCode(event)" class="form-control" name="po_amount" data-maxlength="300" value="<?=$this->accounting_model->transfareTotalToCurrencyRate($poData['currency'],$row->currency,$row->issue_date,$poData['total'])?>" id="po_amount" step="any" required="" readonly="">
                       </div>
                     </div>

                    <div class="form-group">
                       <label class="col-lg-3 control-label" for="rate">Credit Note Amount</label>

                       <div class="col-lg-6">
                         <input type="number" onkeypress="return rateCode(event)" class="form-control" name="amount" data-maxlength="300" value="<?=$row->amount?>" id="amount" step="any" required="">
                       </div>
                     </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="role name">Attachment</label>

                        <div class="col-lg-6">
                            <input type="file" class=" form-control" name="file" id="file">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="description">Description</label>

                        <div class="col-lg-6">
                              <textarea name="description" class="form-control" rows="6"><?=$row->description?></textarea>
                        </div>
                    </div>
                            <?php } ?>
                    
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>accounting/creditNote" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>