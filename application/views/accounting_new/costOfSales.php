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

      <form class="form" id="costOfSales" method="get" action="<?php echo base_url()?>accounting/costOfSales" enctype="multipart/form-data">
             <div class="card-body">

              <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
               <div class="col-lg-3">
                  <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
               </div>  

               <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
               <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>
            </div>

             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                            <button class="btn btn-primary" name="search" type="submit">Search</button> 
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('costOfSales'); e2.action='<?=base_url()?>accounting/exportCostOfSales'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
              

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
                      <h3 class="card-label">Cost Of Sales</h3>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
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
              $priceList = $this->projects_model->getJobPriceListData($job->price_list);
              $total_revenue = $this->sales_model->calculateRevenueJob($job->id,$job->type,$job->volume,$priceList->id);
                    ?>
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
                      <td><?php echo $job->closed_date ;?></td>
                      <td><?php echo $this->admin_model->getAdmin($job->created_by) ;?></td>
                      <td><?php echo $this->admin_model->getAdminMulti($job->assigned_sam) ;?></td>
                      <td><?php echo $job->issue_date ;?></td>
                    </tr>
              <?php  
            } }?>
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