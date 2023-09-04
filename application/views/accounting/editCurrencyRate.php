<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Structure
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/doEditCurrencyRate/<?=$rate->id?>" method="post" enctype="multipart/form-data">
                        <input type="text" name="id" value="<?=base64_encode($rate->id)?>" hidden="">
                           <div class='form-group'>
                                <label class='col-lg-3 control-label' for='Currency'>Currency From</label>
                                <div class='col-lg-6'>
                                    <select name='currency'class='form-control m-b'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectCurrency($rate->currency); ?>
                                    </select>
                                </div>
                            </div>


                           <div class='form-group'>
                                <label class='col-lg-3 control-label' for='Currency'>Currency To</label>
                                <div class='col-lg-6'>
                                    <select name='currency_to'class='form-control m-b'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectCurrency($rate->currency_to); ?>
                                    </select>
                                </div>
                            </div>
    
    
                            <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Select Month</label>
                                <div class='col-lg-6'>
                                    <select name='month'class='form-control m-b' required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->accounting_model->selectMonth($rate->month); ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Select Year</label>
                                <div class='col-lg-6'>
                                    <select name='year'class='form-control m-b' required="">
                                        <option value="" selected=''>-- Select --</option>
                                        <?=$this->accounting_model->selectYear($rate->year); ?>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Rate">Rate</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$rate->rate?>" name="rate" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>accounting/currencyRate" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>