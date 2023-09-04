<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Price List</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>customer/doEditPriceList/<?=$id?>" method="post" enctype="multipart/form-data">
                   <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                   <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                   <?php }else{ ?>
                   <input type="text" name="referer" value="<?=base_url()?>projects" hidden>
                   <?php } ?>
                   
                <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer</label>
                            <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer" onchange="CustomerData()" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerBySam($price->customer,$user,$permission,$brand)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="LeadData">
                                 <?=$this->customer_model->getLeadData($price->lead,$price->customer,$user)?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Product Lines</label>
                            <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLine($price->product_line,$brand)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Source Language</label>
                            <div class="col-lg-6">
                                    <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($price->source)?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Target Language</label>
                            <div class="col-lg-6">
                                    <select name="target" class="form-control m-b" id="target" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($price->target)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Services</label>
                            <div class="col-lg-6">
                                    <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" required />
                                            <option disabled="disabled" selected="" value=""></option>
                                            <?=$this->admin_model->selectServices($price->service)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Task Type</label>
                            <div class="col-lg-6">
                                    <select name="task_type" class="form-control m-b" id="task_type" required />
                                            <option disabled="disabled" selected="" value=""></option>
                                            <?=$this->admin_model->selectTaskType($price->task_type,$price->service)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Subject Matter</label>
                            <div class="col-lg-6">
                                    <select name="subject" class="form-control m-b" id="subject" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Subject --</option>
                                             <?=$this->admin_model->selectFields($price->subject)?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Unit</label>
                            <div class="col-lg-6">
                                    <select name="unit" class="form-control m-b" id="unit" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Unit --</option>
                                             <?=$this->admin_model->selectUnit($price->unit)?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Rate</label>
                            <div class="col-lg-6">
                                 <input type="number" onkeypress="return rateCode(event)" onblur="calculateMin()" class=" form-control" name="rate" data-maxlength="300" value="<?=$price->rate?>" id="rate" step="any" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Currency</label>
                            <div class="col-lg-6">
                                    <select name="currency" class="form-control m-b" id="currency" required />
                                             <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                                             <?=$this->admin_model->selectCurrency($price->currency)?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Number Of Columns</label>
                            <div class="col-lg-6">
                                 <input maxlength="2" type="text" class=" form-control" name="cols" id="cols" onkeypress="return numbersOnly(event)" onchange="fuzzy()" value="<?=$fuzzy->num_rows()?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Fuzzy Match</label>
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
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Comment</label>
                            <div class="col-lg-6">
                                <textarea name="comment" class="form-control" rows="6"><?=$price->comment?></textarea>
                            </div>
                        </div>
                    </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>customer/priceList" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>