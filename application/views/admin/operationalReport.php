<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Date Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="report" method="get" enctype="multipart/form-data">
        <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="">
            </div>

        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="role date">Report Name</label>
            <div class="col-lg-3">
              <select name="report" class="form-control m-b" id="report" required />
                       <option disabled="disabled" selected="selected" value="">-- Select Report --</option>
                        <?php 
              if($_REQUEST['report'] == 1 ){?>
                  <option selected="" value = "<?=$_REQUEST['report']?>">By PM</option>
                       <option value="2">By SAM</option>
                       <option value="3">By Customer</option>
                       <option value="4">SAM Activities</option>
             <?php }elseif($_REQUEST['report'] == 2){ ?>
                  <option selected="" value = "<?=$_REQUEST['report']?>">By SAM</option>
                       <option value="1">By PM</option>
                       <option value="3">By Customer</option>
                       <option value="4">SAM Activities</option>
             <?php }elseif($_REQUEST['report'] == 3){ ?>
                  <option selected="" value = "<?=$_REQUEST['report']?>">By Customer</option>
                  <option value="1">By PM</option>
                       <option value="2">By SAM</option>
                       <option value="4">SAM Activities</option>
             <?php }elseif($_REQUEST['report'] == 4){ ?>
                  <option selected="" value = "<?=$_REQUEST['report']?>">SAM Activities</option>
                  <option value="1">By PM</option>
                       <option value="2">By SAM</option>
                       <option value="3">By Customer</option> 
              <?php }else{?>
                       <option value="1">By PM</option>
                       <option value="2">By SAM</option>
                       <option value="3">By Customer</option>
                       <option value="4">SAM Activities</option>

              <?php }?>
              </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" onclick="var e2 = document.getElementById('report'); e2.action='<?=base_url()?>admin/operationalReport'; e2.submit();" name="search" type="submit"> Search</button>
                <button class="btn btn-success" onclick="var e2 = document.getElementById('report'); e2.action='<?=base_url()?>admin/exportOperationalReport'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
               <a href="<?=base_url()?>admin/operationalReport" class="btn btn-warning">(x) Clear Filter</a> 

            </div>
        </div>   
        </form>
      </div>
    </section>
  </div>
</div>
<!-- By PM -->
<?php if($report == 1){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Operational Report By PM
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="5" style="text-align: center;">Operational Report By PM From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>PM Name</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($pm->result() as $pm) { 
              $runningProjects = $this->db->query(" SELECT * FROM `job` WHERE created_at < '$date_to' AND created_by = '$pm->id' AND project_id <> 0 AND status = 0 ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT * FROM `job` WHERE closed_date BETWEEN '$date_from' AND '$date_to' AND status ='1' AND created_by = '$pm->id' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            
              if($totalClosed == 0 && $totalRunning == 0){
              	$display = "none";
              }else{
              	$display = "";
              }
            ?>
            <tr style="display:<?=$display?>;">
              <td><?=$pm->user_name?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End PM Table -->
<!-- By SAM -->
<?php if($report == 2){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Operational Report By SAM
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="5" style="text-align: center;">Operational Report By SAM From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>SAM Name</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($sam->result() as $sam) { 
              $runningProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = p.lead AND customer_sam.sam = '$sam->id') AS assigned FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.project_id <> 0 AND j.status = 0 AND j.created_at < '$date_to' HAVING assigned = '1' ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = p.lead AND customer_sam.sam = '$sam->id') AS assigned FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.project_id <> 0 AND j.status = 1 AND j.closed_date BETWEEN '$date_from' AND '$date_to' HAVING assigned = '1' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            ?>
            <tr>
              <td><?=$sam->user_name?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End sam Table -->
<!-- By Customer -->
<?php if($report == 3){ ?>
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
                <th colspan="6" style="text-align: center;">Operational Report By Customer From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Customer</th>
                <th>Region</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($customer->result() as $customer) { 
              $runningProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.created_at < '$date_to' AND p.lead = '$customer->leadID' AND project_id <> 0 AND j.status = 0 ");
              $totalRunning = 0;
              foreach ($runningProjects->result() as $running) {
                  $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                  $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
              }
              $closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '$date_from' AND '$date_to' AND j.status ='1' AND p.lead = '$customer->leadID' ");
              $totalClosed = 0;
              foreach ($closedProjects->result() as $closed) {
                  $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                  $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                  $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
              }
            ?>
            <tr>
              <td><?=$customer->name?></td>
              <td><?php echo $this->admin_model->getRegion($customer->region) ;?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End Customer Table -->
<!-- Sam Activities -->
<?php if($report == 4){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Operational Report SAM Activities
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="3" style="text-align: center;">SAM Activities From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>SAM Name</th>
                <th>Number Of New Sales Activities</th>
                <th>Number Of Business Review Activities</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($sam->result() as $sam) { 
              $activities = $this->db->query(" SELECT COUNT(*) AS total FROM `sales_activity` WHERE created_at BETWEEN '$date_from' AND '$date_to' AND created_by = '$sam->id' ")->row();
              $busimess = $this->db->query(" SELECT COUNT(*) AS total FROM `sales_business_reviews` WHERE created_at BETWEEN '$date_from' AND '$date_to' AND created_by = '$sam->id' ")->row();
            ?>
            <tr>
              <td><?=$sam->user_name?></td>
              <td><?=$activities->total?></td>
              <td><?=$busimess->total?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End Sam Activities Table -->