<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add Currency Rate
			</header>
			
			<div class="panel-body">
				<div class="form">
			<form class="cmxform form-horizontal " id="form"action="<?php echo base_url()?>accounting/doAddCurrencyRate" onsubmit="return disableAddButton();" method="post" name="addCurrencyRate" enctype="multipart/form-data">
                           <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Select Currency</label>
                                <div class='col-lg-6'>
                                    <select name='currency'class='form-control m-b'value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectCurrency(0); ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Select Month</label>
                                <div class='col-lg-6'>
                                    <select name='month'class='form-control m-b' value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <option value='01'>Janaury</option>
                                        <option value='02'>February</option>
                                        <option value='03'>March</option>
                                        <option value='04'>April</option>
                                        <option value='05'>May</option>
                                        <option value='06'>June</option>
                                        <option value='07'>July</option>
                                        <option value='08'>August</option>
                                        <option value='09'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-lg-3 control-label' for='inputPassword'>Select Year</label>
                                <div class='col-lg-6'>
                                    <select name='year'class='form-control m-b'id="type_of_vacation" value="" required="">
                                        <option value="" disabled='' selected=''>-- Select --</option>
                                        <option value='2019'>2019</option>
                                        <option value='2020'>2020</option>
                                        <option value='2021'>2021</option>
                                        <option value='2022'>2022</option>
                                        <option value='2023'>2023</option>
                                        <option value='2024'>2024</option>
                                        <option value='2025'>2025</option>
                                        <option value='2026'>2026</option>
                                        <option value='2027'>2027</option>
                                        <option value='2028'>2028</option>
                                        <option value='2029'>2029</option>
                                        <option value='2030'>2030</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                   <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                      <thead>
                                        <tr>
                                          <th>Currency</th>
                                          <th>Rate</th>
                                        </tr>
                                      </thead>
                                       <tbody>
                                          <?=$this->accounting_model->CurrencyRateTable(); ?>
                                      </tbody>
                                  </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" name="save" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>accounting/currencyRate" class="btn btn-danger" type="button">Cancel</a>
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