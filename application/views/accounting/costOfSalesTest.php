<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Filter
      </header>
      <?php 
       if(!empty($filter['issue_date >='])){
          $date_from=date("m/d/Y", strtotime($filter['issue_date >=']));
        }
        else{
          $date_from="";
        }
        if(!empty($filter['issue_date <='])){
          $date_to=date("m/d/Y", strtotime($filter['issue_date <=']));
        }
        else{
          $date_to="";
        }
      ?>
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="costOfSales" action="<?php echo base_url()?>accounting/costOfSalesTest" method="post" enctype="multipart/form-data">
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" value="<?=$date_from?>" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" value="<?=$date_to?>" autocomplete="off">
            </div>

        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" name="search" type="submit">Search</button> 
                <button class="btn btn-success" onclick="var e2 = document.getElementById('costOfSales'); e2.action='<?=base_url()?>accounting/exportCostOfSalesTest'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
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
        Cost Of Sales
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Job Code</th>
               <th>Client Name</th>
               <th>PO Number</th>
               <th>Service</th>
               <th>Source</th>
               <th>Target</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Total Revenue</th>
               <th>Currency</th>
               <th>Total Revenue (USD)</th>
               <th>Total Cost (USD)</th>
               <th>Closed Date</th>
                <th>Created By</th>
                <th>Assigned SAM</th>
                <th>Issue Date</th>
              </tr>
            </thead>
            <tbody>
            <?php if(isset($jobs)){foreach ($jobs->result() as $job) {
              $total_revenue = $this->sales_model->calculateRevenueJobForSalesOfCost($job->id,$job->type,$job->volume,$job->price_list_rate);
                    ?>
                    <tr>
                      <td><?=$job->code?></td>
                      <td><?php echo $job->customer_name;?></td>
                      <td><?php echo $job->number; ?></td>
                      <td><?php echo $job->service_name;?></td>
                      <td><?php echo $job->source_lang;?></td>
                      <td><?php echo $job->target_lang;?></td>
                      <?php if($job->type == 1){ ?>
                      <td><?php echo $job->volume ;?></td>
                      <?php }elseif ($job->type == 2) { ?>
                      <td><?php echo $total_revenue / $job->price_list_rate ;?></td>
                      <?php } ?>
                      <td><?php echo $job->price_list_rate ;?></td>
                      <td><?=number_format($total_revenue,2)?></td>
                      <td><?php echo $job->currency_name ;?></td>
                      <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($job->price_list_currency,2,$job->issue_date,$total_revenue),2)?></td>
                      <td><?=number_format($this->accounting_model->totalCostByJobCurrency(2,$job->id),2)?></td>
                      <td><?php echo $job->closed_date ;?></td>
                      <td><?php echo $job->user_name ;?></td>
                      <td><?php echo $this->admin_model->getAdminMulti($job->assigned_sam) ;?></td>
                      <td><?php echo $job->issue_date ;?></td>
                    </tr>
              <?php  
            } }?>
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