<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Date Filter
      </header>
      
         <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/pmoCustomer" method="post" id="pmoCustomer" enctype="multipart/form-data">

           <div class="form-group">
                    <label class="col-lg-2 control-label" for="role date">Date From</label>
                    
                    <div class="col-lg-3">
                         <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required >
                    </div>
                    <label class="col-lg-2 control-label" for="role date">Date To</label>
                    <div class="col-lg-3">
                         <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required >
                </div>
            </div>

          <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer</label>

                    <div class="col-lg-10">
                        <select name="name[]" class="form-control m-b" required="" id="name" multiple/>
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerExisting(0,$this->brand)?>
                        </select>
                    </div>


                </div>

                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('pmoCustomer'); e2.action='<?=base_url()?>projects/exportPmoCustomer'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                       <a href="<?=base_url()?>projects/pmoCustomer" class="btn btn-warning">(x) Clear Filter</a>

                  </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<!-- By Customer -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Operational Report By Customer
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">

            <thead>
              <tr>
                <th>Customer</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
                <th>Total VPOs Cost</th>
                <th>Profit</th>
              </tr>
            </thead>
            <tbody>
            <?php 
			if(isset($_POST['search'])){
            foreach ($customer->result() as $customer) { 
              $runningProjects = $this->db->query(" SELECT j.*,p.customer FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.created_at < '$date_to' AND project_id <> 0 AND j.status = 0 AND p.customer = '$customer->id' ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT j.*,p.customer FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '$date_from' AND '$date_to' AND j.status ='1' AND p.customer = '$customer->id' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            
              $totalCost = $this->projects_model->getTotalCostByCustomer($customer->id,$date_from,$date_to);
            ?>
            <tr>
              <td><?=$customer->name?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
              <td>$ <?=number_format($totalCost,2)?></td>
              <td>$ <?=number_format($totalClosed - $totalCost,2)?></td>
            </tr>
            <?php }} ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- End Customer Table -->
