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

            <form class="form" id="dtpCOGS" method="get" enctype="multipart/form-data">
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
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpCOGS'); e2.action='<?=base_url()?>accounting/exportDtpRevenueReport'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
              <a href="<?=base_url()?>accounting/dtpRevenueReport" class="btn btn-warning">(x) Clear Filter</a>

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
                      <h3 class="card-label">DTP Revenue Report</h3>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                   <th>Job Name</th>
                   <th>Volume</th>
                   <th>Rate</th>
                   <th>Currency</th>
                   <th>Total Revenue</th>
                   <th>Total Revenue $ USD</th>
                   <th>Task Type</th>
                   <th>Unit</th>
                   <th>Source Language Direction</th>
                   <th>Target Language Direction</th>
                   <th>Start Date</th>
                   <th>Delivery Date</th>
                   <th>Closed Date</th>
                   <th>Created By</th>                           
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($project)){
              foreach ($project->result() as $row) { 
                  $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                  $jobTotal = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
            ?>
              <tr>
               <!-- jobs -->
                <td><?=$row->name?></td>
                <?php if($row->type == 1){ ?>
                <td><?php echo $row->volume ;?></td>
                <?php }elseif ($row->type == 2) { ?>
                <td><?php echo $jobTotal / $priceList->rate ;?></td>
                <?php } ?>
                <td><?php echo $priceList->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                <td><?php echo $jobTotal; ?></td>
                <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$row->closed_date,$jobTotal),2);?></td>
 

            <!--DTP Task -->


                  <td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
                  <td><?=$this->admin_model->getUnit($row->unit)?></td>
                  <td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
                  <td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>

                  <td><?=$row->start_date?></td>
                  <td><?=$row->delivery_date?></td>
                  <td><?=$row->closed_date?></td>
                  <td><?=$this->admin_model->getAdmin($row->created_by)?></td>

                </tr>
              <!-- End DTP Tasks -->

              </tr>
            <?php }} ?>
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