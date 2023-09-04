<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				 Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="dtpProductionReport" method="get" enctype="multipart/form-data">
				 

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
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('dtpProductionReport'); e2.action='<?=base_url()?>dtp/dtpProductionReport'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpProductionReport'); e2.action='<?=base_url()?>dtp/exportDtpProductionReport'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>dtp/dtpProductionReport" class="btn btn-warning">(x) Clear Filter</a> 

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
        DTP Production Report
      </header>
      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
            
          </div>
          <div class="space15"></div>


   <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Assigned DTP</th>
                <th>Total By Assigned</th>
              	<th>Total Jobs</th>
                <th>Percentage</th>
              </tr>
            </thead>
            <tbody>
			<?php 
			if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    $totalJobs = $this->db->query(" SELECT *,(SELECT brand FROM users WHERE users.id = dtp_request_job.created_by) AS brand FROM `dtp_request_job` WHERE created_at BETWEEN '$date_from' AND '$date_to' HAVING brand = '$this->brand' ORDER BY `dtp_request_job`.`created_at` DESC ")->num_rows();
                }
            foreach($dtp as $dtp){
            	$assigned = $this->db->query(" SELECT *,(SELECT brand FROM users WHERE users.id = dtp_request_job.created_by) AS brand FROM `dtp_request_job` WHERE created_at BETWEEN '$date_from' AND '$date_to' AND dtp = '$dtp->id' HAVING brand = '$this->brand' ORDER BY `dtp_request_job`.`created_at` DESC ")->num_rows();
            ?>
          	<tr class="">
                  <td><?=$this->admin_model->getAdmin($dtp->id)?></td>
                  <td><?=$assigned?></td>
                  <td><?=$totalJobs?></td>
            	  <td><?php echo number_format(($assigned / $totalJobs)*100,2) ?> %</td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>