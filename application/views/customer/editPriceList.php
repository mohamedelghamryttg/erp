<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Price List 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/doEditPriceList/<?=$id?>" method="post" enctype="multipart/form-data">

                   <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                   <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                   <?php }else{ ?>
                   <input type="text" name="referer" value="<?=base_url()?>projects" hidden>
                   <?php } ?>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer" onchange="CustomerData()" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam($price->customer,$user,$permission,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                    <?=$this->customer_model->getLeadData($price->lead,$price->customer,$user)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Product Lines</label>

                                <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLine($price->product_line,$brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($price->source)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target" class="form-control m-b" id="target" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($price->target)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Services">Services</label>

                                <div class="col-lg-6">
                                    <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected="" value=""></option>
                                            <?=$this->admin_model->selectServices($price->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Task Type">Task Type</label>

                                <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected="" value=""></option>
                                            <?=$this->admin_model->selectTaskType($price->task_type,$price->service)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Subject Matter">Subject Matter</label>

                                <div class="col-lg-6">
                                    <select name="subject" class="form-control m-b" id="subject" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Subject --</option>
                                             <?=$this->admin_model->selectFields($price->subject)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Unit">Unit</label>

                                <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($price->unit)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="rate"> Rate</label>

                               <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" value="<?=$price->rate?>" id="rate" step="any" required>
                               </div>
                             </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Currency">Currency</label>

                                <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($price->currency)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Number Of Columns</label>

                                <div class="col-lg-3">
                                    <input maxlength="2" type="text" class=" form-control" name="cols" id="cols" onkeypress="return numbersOnly(event)" onchange="fuzzy()" value="<?=$fuzzy->num_rows()?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Fuzzy Match</label>
                                <div class="table-responsive col-lg-6" style="overflow-x:auto;" id="fuzzyTable">
                                    <?php
                                    $result_arr = array();
                                    echo ' <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                        <thead>
                                            <tr>';
                                    $i=1;
                                    foreach ($fuzzy->result() as $column) {
                                        echo ' <th><input type="text" value="'.$column->prcnt.'" name="prcnt_'.$i.'" id="prcnt_'.$i.'"></th> ';
                                        $i++;
                                    }
                                    echo ' <th>Min</th> ';             
                                    echo '</tr></thead><tbody><tr>';
                                    $y=1;
                                    foreach ($fuzzy->result() as $column) { 
                                        echo '<td><input type="text" onblur="calculateFuzzy('.$y.')" onkeypress="return rateCode(event)" value="'.$column->value.'" name="value_'.$y.'" id="value_'.$y.'"></td>';
                                        $result = $column->value * $price->rate;
                                        array_push($result_arr, $result);
                                        $y++;
                                    }
                                    echo ' <td></td> ';             
                                    echo '</tr></thead><tbody><tr>';
                                    for ($i=0; $i < count($result_arr); $i++) {
                                        $z = $i+1; 
                                        echo '<td id="result_'.$z.'">'.$result_arr[$i].'</td>';
                                    }
                                        $min = $price->rate * 250;
                                        echo '<td id="min">'.$min.'</td>';
                                    echo '</tr></tbody></table>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" rows="6"><?=$price->comment?></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>customer/priceList" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>