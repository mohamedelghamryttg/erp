<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/pmoReport" id="pmoReport" method="get" enctype="multipart/form-data">

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
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('pmoReport'); e2.action='<?=base_url()?>projects/exportPmoReport'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                  	  <a href="<?=base_url()?>projects/pmoReport" class="btn btn-warning">(x) Clear Filter</a>
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
				Monthly PMO Report
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
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
				                <th>PM Name</th>
                        <th>Region</th>
				                <th>Target/Monthly</th>
				                <th>Target/ Annually</th>
				                <th>Achieved Monthly $</th>
				                <th>Achieved Annually $</th>
				                <th>Number of Customers Served /Active</th>
				                <th>Number of Customers Assigned/Target</th>
				                <th>Number of jobs</th>
                                                 <th>Number Of Running Jobs</th>
                                                <th>Revenue Of Running Jobs</th>
				                <th>Services</th>
				                <th>VPOs/COGS</th>
				                <th>Gross Profit $</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if(isset($_GET['search'])){
				                $arr2 = array();
				                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
				                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
				                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                                                     // if permissions = all else see only user = this user
                                                     if($permission->view == 1){
				                	$pms = $this->db->query(" SELECT * FROM users WHERE (role = '2' OR role = '13' OR role = '16' OR role = '29' OR role = '43' OR role = '42' OR role = '45' OR role = '47' OR role = '52') AND brand = '$this->brand' ")->result();
                                	}elseif($permission->view == 2){
                                            $pms = $this->db->query(" SELECT * FROM users WHERE id = $this->user AND (role = '2' OR role = '13' OR role = '16' OR role = '29' OR role = '43' OR role = '42' OR role = '45' OR role = '47' OR role = '52') AND brand = '$this->brand' ")->result();
                                        }
                                        foreach($pms as $pm){
                                    	$regions = $this->db->query("SELECT DISTINCT c.region FROM job AS j 
										LEFT OUTER JOIN project AS p ON j.project_id = p.id
										LEFT OUTER JOIN customer_leads AS c ON p.lead = c.id
										WHERE j.created_by = '$pm->id' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to'  
										ORDER BY `c`.`region`  DESC")->result();
                                    	$customers = $this->db->query("SELECT DISTINCT p.customer FROM job AS j 
										LEFT OUTER JOIN project AS p ON j.project_id = p.id
										WHERE j.created_by = '$pm->id' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to'")->num_rows();
                                    	$services = $this->db->query(" SELECT DISTINCT l.service FROM job AS j 
											LEFT OUTER JOIN job_price_list AS l ON l.id = j.price_list
											WHERE j.created_by = '$pm->id' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to' ")->result();
                                    
                                    	$monthlyAchieved = $this->projects_model->getJobsRevenue($pm->id,$date_from,$date_to);
                                    	$totalCost = $this->projects_model->getTotalCost($pm->id,$date_from,$date_to);
                                    	$yearlyAchieved = $this->projects_model->getJobsRevenue($pm->id,date("Y", strtotime($_REQUEST['date_from']))."-01-06",$date_to);
					// running jobs
                                          $runningProjects = $this->db->query(" SELECT j.* FROM job AS j  WHERE j.created_at < '$date_to' AND project_id <> 0 AND j.status = 0  AND j.created_by = '$pm->id' ");
                                            $totalRunning = 0;
                                            foreach ($runningProjects->result() as $running) {
                                                $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                                                $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                                                $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
                                            }
                                     ?>
							<tr>

								<td><?php echo $pm->user_name ;?></td>
								<td>
                            	<?php foreach($regions as $region){ 
                        			echo $this->admin_model->getRegion($region->region)." ";
                        		}
                                ?>
                            	</td>
								<td></td>
								<td></td>
								<td><?=number_format($monthlyAchieved['total'],2)?></td>
								<td><?=number_format($yearlyAchieved['total'],2)?></td>
                              	<td><?=$customers?></td>
                              	<td></td>
                              	<td><?=$monthlyAchieved['jobsNum']?></td>
                                <td><?=$runningProjects->num_rows()?></td>
                                <td>$ <?=number_format($totalRunning,2)?></td>
                              	<td>
                            	<?php foreach($services as $service){ 
                        			echo $this->admin_model->getServices($service->service)." ";
                        		}
                                ?>
                            	</td>
                              	<td><?=number_format($totalCost,2)?></td>
                              	<td><?=number_format($monthlyAchieved['total']-$totalCost,2)?></td>

							</tr>
                        	<?php }}} ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>