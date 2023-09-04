<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="costOfSales" action="<?php echo base_url()?>accounting/costOfSales" method="post" enctype="multipart/form-data">
          <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
            </div>

        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" name="search" type="submit">Search</button> 
                <button class="btn btn-success" onclick="var e2 = document.getElementById('costOfSales'); e2.action='<?=base_url()?>accounting/exportCostOfSales'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
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
               <th>Translation Total Cost (USD)</th>
               <th>LE Total Cost (USD)</th>
               <th>DTP Total Cost (USD)</th>
               <th>Created Date</th>
               <th>Closed Date</th>
                <th>Created By</th>
                <th>Assigned SAM</th>
                <th>Issue Date</th>
              </tr>
            </thead>
            <tbody>
            <?php if(isset($jobs)){foreach ($jobs->result() as $job) {
              $priceList = $this->projects_model->getJobPriceListData($job->price_list);
              $total_revenue = $this->sales_model->calculateRevenueJob($job->id,$job->type,$job->volume,$priceList->id);
                  $year =  explode("-", $job->created_at)[0];  
             //Translation
                $translation_tasks = $this->db->select('task_type, unit, created_at, count')->from('translation_request')->where(array('job_id'=>$job->id,'status'=> 3))->get()->result();
                $totalRateTrans = 0;
                foreach ($translation_tasks as $trans) {
                    $rateProductionTrans = $this->db->get_where('production_team_cost',array('task_type'=>$trans->task_type,'unit'=>$trans->unit,'year'=> $year,'team'=> 1))->row()->rate;
                    $rateTrnasfaredTrans = number_format($this->accounting_model->transfareTotalToCurrencyRate(1,2,$trans->created_at,$rateProductionTrans),2) * $trans->count;
                    $totalRateTrans = $totalRateTrans + $rateTrnasfaredTrans;
                }
            //LE
                $le_Tasks = $this->db->select('volume,unit,created_at')->from("le_request")->where(array('job_id'=>$job->id,'status'=> 3))->get()->result();
                $totalRateLe = 0;
                foreach ($le_Tasks as $le) {                     
                    $rateProductionLe = $this->db->get_where('production_team_cost',array('unit'=>$le->unit,'year'=> $year,'team'=> 2))->row()->rate;
                    $rateTrnasfaredLe = number_format($this->accounting_model->transfareTotalToCurrencyRate(1,2,$le->created_at,$rateProductionLe),2)* $le->volume;
                    $totalRateLe = $totalRateLe + $rateTrnasfaredLe;
                  }
                  
            //DTP
                $dtp_tasks = $this->db->select('volume,unit,created_at')->from('dtp_request')->where(array('job_id'=>$job->id))->get()->result();
                $totalRateDtp = 0;
                foreach ($dtp_tasks as $dtp) {                     
                    $rateProductionDtp = $this->db->get_where('production_team_cost',array('unit'=>$dtp->unit,'brand'=>$this->brand,'year'=> $year,'team'=> 3))->row()->rate;
                    $rateTrnasfaredDtp = $this->accounting_model->transfareTotalToCurrencyRate(1,2,$dtp->created_at,$rateProductionDtp)*$dtp->volume;
                    $totalRateDtp = $totalRateDtp + $rateTrnasfaredDtp;
                  }   ?>
                    <tr>
                      <td><?=$job->code?></td>
                      <td><?php echo $this->customer_model->getCustomer($job->customer);?></td>
                      <td><?php echo $job->number; ?></td>
                      <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                      <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                      <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                      <?php if($job->type == 1){ ?>
                      <td><?php echo $job->volume ;?></td>
                      <?php }elseif ($job->type == 2) { ?>
                      <td><?php echo $total_revenue / $priceList->rate ;?></td>
                      <?php } ?>
                      <td><?php echo $priceList->rate ;?></td>
                      <td><?=number_format($total_revenue,2)?></td>
                      <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                      <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$job->issue_date,$total_revenue),2)?></td>
                      <td><?=number_format($this->accounting_model->totalCostByJobCurrency(2,$job->id),2)?></td>
                        <td><?= number_format($totalRateTrans,2); ?></td>
                      <td><?= number_format($totalRateLe,2);?></td>
                       <td><?= number_format($totalRateDtp,2); ?></td>
                      <td><?php echo $job->created_at ;?></td>
                      <td><?php echo $job->closed_date ;?></td>
                      <td><?php echo $this->admin_model->getAdmin($job->created_by) ;?></td>
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