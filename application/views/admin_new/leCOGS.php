   <?php if ($this->session->flashdata('true')) { ?>
     <div class="alert alert-success" role="alert">
       <span class="fa fa-check-circle"></span>
       <span><strong><?= $this->session->flashdata('true') ?></strong></span>
     </div>
   <?php  } ?>
   <?php if ($this->session->flashdata('error')) { ?>
     <div class="alert alert-danger" role="alert">
       <span class="fa fa-warning"></span>
       <span><strong><?= $this->session->flashdata('error') ?></strong></span>
     </div>
   <?php  } ?>
   <!--begin::Content-->

   <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


     <!--begin::Entry-->
     <div class="d-flex flex-column-fluid">
       <!--begin::Container-->
       <div class="container-fluid">


         <!-- start search form card -->
         <div class="card card-custom gutter-b example example-compact">
           <div class="card-header">
             <h3 class="card-title">Search</h3>
           </div>

           <form class="form" id="leCOGS" method="get" enctype="multipart/form-data">
             <div class="card-body">
               <div class="form-group row">
                 <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date From</label>
                 <div class="col-lg-3">
                   <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                 </div>

                 <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date To</label>
                 <div class="col-lg-3">
                   <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                 </div>
               </div>


               <div class="card-footer">
                 <div class="row">
                   <div class="col-lg-2"></div>
                   <div class="col-lg-10">
                     <button class="btn btn-success mr-2" name="search" onclick="var e2 = document.getElementById('leCOGS'); e2.action='<?= base_url() ?>report/leCOGS'; e2.submit();" type="submit">Search</button>
                     <button class="btn btn-secondary" onclick="var e2 = document.getElementById('leCOGS'); e2.action='<?= base_url() ?>report/exportLeCOGS'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                     <a href="<?= base_url() ?>report/leCOGS" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a>

                   </div>
                 </div>
               </div>
           </form>
         </div>
       </div>

       <!-- end search form -->

       <!--begin::Card-->
       <div class="card">
         <div class="card-header flex-wrap border-0 pt-6 pb-0">
           <div class="card-title">
             <h3 class="card-label">LE COGS Report</h3>
           </div>

         </div>
         <div class="card-body">
           <!--begin: Datatable-->
           <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
             <thead>
               <tr>
                 <th>Job Name</th>
                 <th>Job Code</th>
                 <th>Total Revenue in $</th>
                 <th>count</th>
                 <th>Rate $</th>
                 <th>Total Cost in $</th>
                 <th>unit</th>
                 <th>Source Language Direction</th>
                 <th>Target Language Direction</th>
                 <th>Start Date</th>
                 <th>Delivery Date</th>
                 <th>Created By</th>

               </tr>
             </thead>
             <tbody>
               <?php
                if (isset($project)) {
                  foreach ($project->result() as $row) {
                    $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                    $jobTotal = $this->sales_model->calculateRevenueJob($row->id, $row->job_type, $row->job_volume, $priceList->id);
                    $jobTotal = number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $row->created_at, $jobTotal), 2);
                    $dateArray = explode("-", $row->created_at);
                    $year = $dateArray[0];
                    $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $row->unit, 'year' => $year, 'team' => 2))->row()->rate;
                    $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 6);
                ?>
                   <tr>


                     <!-- jobs -->

                     <td style="white-space: normal;"><?= $row->name ?></td>
                     <td><?= $row->code ?></td>


                     <td><?php echo $jobTotal; ?></td>
                     <td><?= $row->count ?></td>
                     <td><?= $rateTrnasfared ?></td>
                     <td><?php echo number_format(($rateTrnasfared * $row->count), 2); ?></td>

                     <td><?= $this->admin_model->getUnit($row->unit) ?></td>
                     <td><?= $this->admin_model->getLanguage($priceList->source) ?></td>
                     <td><?= $this->admin_model->getLanguage($priceList->target) ?></td>

                     <td><?= $row->start_date ?></td>
                     <td><?= $row->delivery_date ?></td>

                     <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>

                   </tr>


                   </tr>
               <?php }
                } ?>
             </tbody>
           </table>
           <!--end: Datatable-->
           <!--begin::Pagination-->
           <div class="d-flex justify-content-between align-items-center flex-wrap">
             <?= $this->pagination->create_links() ?>
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