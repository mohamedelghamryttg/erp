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
          
            <form class="form" id="pmoCustomerPm" action="<?php echo base_url()?>projects/pmoCustomerPm" method="get" enctype="multipart/form-data">
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
               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Customer</label>
               <div class="col-lg-3">
                <select name="name[]" class="form-control m-b" required="" id="name" multiple/>
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerExisting(0,$this->brand)?>
                        </select>
               </div>  
              </div>
             

             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search"  onclick="var e2 = document.getElementById('pmoCustomerPm'); e2.action='<?=base_url()?>projects/pmoCustomerPm'; e2.submit();" type="submit">Search</button>  
                           <button class="btn btn-secondary" onclick="var e2 = document.getElementById('pmoCustomerPm'); e2.action='<?=base_url()?>projects/exportPmoCustomerPm'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>  
                         <a href="<?=base_url()?>projects/pmoCustomerPm" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                      <h3 class="card-label">Operational Report By Customer</h3>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                <th>Customer</th>
                <th>PM</th>
                <th>Number Of Running Jobs</th>
                <th>Revenue Of Running Jobs</th>
                <th>Number Of Closed Jobs</th>
                <th>Revenue Of Closed Jobs</th>
              </tr>
            </thead>
            <tbody>
            <?php 
      if(isset($_POST['search'])){
            foreach ($customer->result() as $customer) {
              $assignedPMs = $this->db->get_where('customer_pm',array('customer'=>$customer->id))->result();
              foreach ($assignedPMs as $pm){

                  $runningProjects = $this->db->query(" SELECT j.*,p.customer FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.created_at < '$date_to' AND project_id <> 0 AND j.status = 0 AND p.customer = '$customer->id' AND j.created_by = '$pm->pm' ");
                $totalRunning = 0;
                foreach ($runningProjects->result() as $running) {
                    $priceList = $this->projects_model->getJobPriceListData($running->price_list);
                    $total_revenue = $this->sales_model->calculateRevenueJob($running->id,$running->type,$running->volume,$priceList->id);
                    $totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$running->created_at,$total_revenue);
                }
                $closedProjects = $this->db->query(" SELECT j.*,p.customer FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '$date_from' AND '$date_to' AND j.status ='1' AND p.customer = '$customer->id' AND j.created_by = '$pm->pm' ");
                $totalClosed = 0;
                foreach ($closedProjects->result() as $closed) {
                    $priceList = $this->projects_model->getJobPriceListData($closed->price_list);
                    $total_revenue = $this->sales_model->calculateRevenueJob($closed->id,$closed->type,$closed->volume,$priceList->id);
                    $totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$closed->created_at,$total_revenue);
                }
            ?>
            <tr>
              <td><?=$customer->name?></td>
              <td><?=$this->admin_model->getAdmin($pm->pm)?></td>
              <td><?=$runningProjects->num_rows()?></td>
              <td>$ <?=number_format($totalRunning,2)?></td>
              <td><?=$closedProjects->num_rows()?></td>
              <td>$ <?=number_format($totalClosed,2)?></td>
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