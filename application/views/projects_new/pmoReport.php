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

   <!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              

              <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">Search</h3>
          </div>
          
            <form class="form" id="pmoCustomer" action="<?php echo base_url()?>projects/pmoReport" method="get" enctype="multipart/form-data">
             <div class="card-body">

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
               <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required >

               </div>  

               <label class="col-lg-2 control-label" for="role name">Date To</label>
                        <div class="col-lg-3">
                        <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required >
                        </div>
              </div>
              
             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search"  onclick="var e2 = document.getElementById('pmoReport'); e2.action='<?=base_url()?>projects/pmoReport'; e2.submit();" type="submit">Search</button>  
                           <button class="btn btn-secondary" onclick="var e2 = document.getElementById('pmoReport'); e2.action='<?=base_url()?>projects/exportPmoReport'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>  
                         <a href="<?=base_url()?>projects/pmoReport" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

               </div>
              </div>
             </div>
            </form>
                       </div>
                       </div>
                        
              <!-- end search form -->
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                      <h3 class="card-label">Monthly PMO Report</h3>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
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
                          $pms = $this->db->query(" SELECT * FROM users WHERE (role = '2' OR role = '13' OR role = '16' OR role = '29') AND brand = '$this->brand' ")->result();
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
                                      $yearlyAchieved = $this->projects_model->getJobsRevenue($pm->id,date("Y", strtotime($_REQUEST['date_from']))."-01-06",$date_to)
            ?>
              <tr>

                <td><?php echo $pm->user_name ;?></td>
                <td><?php foreach($regions as $region){ 
                echo $this->admin_model->getRegion($region->region)." ";
                  }?>
                </td>
                <td></td>
                <td></td>
                <td><?=number_format($monthlyAchieved['total'],2)?></td>
                <td><?=number_format($yearlyAchieved['total'],2)?></td>
                <td><?=$customers?></td>
                <td></td>
                <td><?=$monthlyAchieved['jobsNum']?></td>
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
                    <!--end: Datatable-->
 <!--begin::Pagination-->
         <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <?=$this->pagination->create_links()?>  
                  </div>
              <!--end:: Pagination-->
                  </div>
                </div>
                <!--end::Card-->
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->