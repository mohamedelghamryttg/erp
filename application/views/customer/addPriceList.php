<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Price List 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/doAddPriceList" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer" onchange="CustomerData()" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam(0,$user,$permission,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Product Lines</label>

                                <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLine(0,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target" class="form-control m-b" id="target" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected=""></option>
                                            <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject" class="form-control m-b" id="subject" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Subject --</option>
                                             <?=$this->admin_model->selectFields()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate"> Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" value="0" id="rate" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Number Of Columns</label>

                                <div class="col-lg-3">
                                    <input maxlength="2" type="text" class=" form-control" name="cols" id="cols" onkeypress="return numbersOnly(event)" onchange="fuzzy()" value="5" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Fuzzy Match</label>
                                <div class="table-responsive col-lg-6" style="overflow-x:auto;" id="fuzzyTable">
                                    <?php
                                    echo ' <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                        <thead>
                                            <tr>';
                                    echo ' <th><input type="text" value="100%" name="prcnt_1" id="prcnt_1" required=""></th> ';
                                    echo ' <th><input type="text" value="95-99 %" name="prcnt_2" id="prcnt_2" required=""></th> ';
                                    echo ' <th><input type="text" value="85-94 %" name="prcnt_3" id="prcnt_3" required=""></th> ';
                                    echo ' <th><input type="text" value="75-84 %" name="prcnt_4" id="prcnt_4" required=""></th> ';
                                    echo ' <th><input type="text" value="50-74 %" name="prcnt_5" id="prcnt_5" required=""></th> ';
                                    echo ' <th><input type="text" value="Reps" name="prcnt_6" id="prcnt_6" required="" readonly=""></th> ';
                                    echo ' <th><input type="text" value="No match" name="prcnt_7" id="prcnt_7" required="" readonly=""></th> ';
                                    echo ' <th>Min</th> ';             
                                    echo '</tr></thead><tbody><tr>';
                                    for ($i=1; $i <= 7; $i++) { 
                                        echo '<td><input type="text" onblur="calculateFuzzy('.$i.')" onkeypress="return rateCode(event)" name="value_'.$i.'" id="value_'.$i.'" required=""></td>';
                                    }
                                    echo ' <td></td> ';             
                                    echo '</tr></thead><tbody><tr>';
                                    for ($i=1; $i <= 7; $i++) { 
                                        echo '<td id="result_'.$i.'"></td>';
                                    }
                                        echo '<td id="min"></td>';
                                    echo '</tr></tbody></table>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>customer/priceList" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>