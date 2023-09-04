<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
       Currency Rate Filter
      </header>

     <?php 
      if(!empty($_REQUEST['currency'])){
                    $currency = $_REQUEST['currency'];
                    
                }else{
                    $currency = "";
                }

                if(!empty($_REQUEST['currency_to'])){
                    $currency_to = $_REQUEST['currency_to'];
                    
                }else{
                    $currency_to = "";
                }

                if(!empty($_REQUEST['months'])){
                    $month = $_REQUEST['months'];
                    
                }else{
                    $month = "";
                }

                if(!empty($_REQUEST['years'])){
                    $year = $_REQUEST['years'];
                    
                }else{
                    $year = "";
                }

                  ?>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/currencyRate" method="get" id="currencyRate" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Currency From</label>

                    <div class="col-lg-3">
                          <select name='currency'class='form-control m-b'value="">
                              <option value="" selected=''>-- Select --</option>
                              <?=$this->admin_model->selectCurrency($currency); ?>
                          </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Currency To</label>

                    <div class="col-lg-3">
                          <select name='currency_to'class='form-control m-b'value="">
                              <option value="" selected=''>-- Select --</option>
                              <?=$this->admin_model->selectCurrency($currency_to); ?>
                          </select>
                    </div>

                </div>
               <div class="form-group">
                    <label class="col-lg-2 control-label" for="Month">Month</label>

                    <div class="col-lg-3">
                          <select name='months'class='form-control m-b'>
                              <option value="" selected=''>-- Select --</option>
                              <?=$this->accounting_model->selectMonth($month); ?>
                          </select>
                    </div>

                    <label class="col-lg-2 control-label" for="Year">Year</label>

                    <div class="col-lg-3">
                          <select name='years'class='form-control m-b'>
                              <option value="" selected=''>-- Select --</option>
                              <?=$this->accounting_model->selectYear($year); ?>
                          </select>
                    </div>
                  </div>

                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('currencyRate'); e2.action='<?=base_url()?>accounting/currencyRate'; e2.submit();" type="submit">Search</button>
                      <!--<button class="btn btn-success" onclick="var e2 = document.getElementById('structure'); e2.action='<?=base_url()?>hr/exportStructure'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> -->
                      <a href="<?=base_url()?>accounting/currencyRate" class="btn btn-warning">(x) Clear Filter</a>
                  </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            
            <header class="panel-heading">
                Currency Rate
            </header>
            <?php if($this->session->flashdata('true')){ ?>
            <div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
            <?php  } ?>
            <?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
            <?php  } ?>
            
            <div class="panel-body">
                <div class="adv-table editable-table " style="overflow:scroll;">
                    <div class="clearfix">
                        <div class="btn-group">
                        <?php if($permission->add == 1){ ?>
                            <a href="<?=base_url()?>accounting/addCurrencyRate" class="btn btn-primary ">Add New Currency Rate</a>
                            </br></br></br>
                        <?php } ?>
                        </div>
                        
                    </div>
          
    <div class="space15"></div>
     <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Currency From</th>
                    <th>Currency To</th>
                    <th>Rate</th>
                    <th>Month</th>
                    <th>Year</th>
              		<th>Created By</th>
					<th>Created At</th>
                    <th>Edit</th>
                    <th>Delete</th>
                
              </tr>
            </thead>
            
            <tbody>
            <?php
              if($rate->num_rows()>0)
              {
                foreach($rate->result() as $row)
                {
                  ?>
                  <tr class="">
                   <td><?= $row->id ?></td>
                    <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                    <td><?=$this->admin_model->getCurrency($row->currency_to)?></td>
                    <td><?= $row->rate ?></td>
                    <td><?=$this->accounting_model->getMonth($row->month)?></td>
                    <td><?=$row->year?></td>
                   	<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
					<td><?php echo $row->created_at ;?></td>
                    <td>
                      <?php if($permission->edit == 1){ ?>
                      <a href="<?php echo base_url()?>accounting/editCurrencyRate?t=<?php echo base64_encode($row->id) ;?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>accounting/deleteCurrencyRate/<?php echo $row->id ?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Structure?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              else
              {
                ?><tr><td colspan="7">There is no Currency Rate to list</td></tr><?php
              }
              ?>                
            </tbody>
          </table>
               <nav class="text-center">
                         <?=$this->pagination->create_links()?>
                    </nav>
        </div>
      </div>
    </section>
  </div>
</div>