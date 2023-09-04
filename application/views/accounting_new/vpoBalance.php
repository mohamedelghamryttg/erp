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
            <h3 class="card-title">VPO Balance Search</h3>
          </div>

      <form class="form" id="vpoBalance" method="get" action="<?php echo base_url()?>accounting/vpoBalance" enctype="multipart/form-data">
             <div class="card-body">
			
             <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
               <div class="col-lg-3">
                   <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
               </div> 

               <label class="col-lg-2 col-form-label text-lg-right">Date To</label>
               <div class="col-lg-3">
                   <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
               </div>  

              </div>

             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                            <button class="btn btn-primary" name="search" type="submit">Search</button> 
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('vpoBalance'); e2.action='<?=base_url()?>accounting/exportvpoBalance'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
              

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
                      <h3 class="card-label">All VPOs</h3>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                  <th>PM Name</th>
                  <th>P.O Number</th>
                  <th>VPO Status</th>
                  <th>CPO Verified</th>
                  <th>CPO Verified Date</th>
                  <th>VPO Date</th>
                  <th>Vendor Name</th>
                  <th>Source Language</th>
                  <th>Target Language</th>
                  <th>Task Type</th>
                  <th>Count</th>
                  <th>Unit</th>
                  <th>Rate</th>
                  <th>Currency</th>
                  <th>P.O Amount</th>
                  <th>Invoice Status</th>
                  <th>Invoice Date</th>
                  <th>Due Date (45 Days)</th>
                  <th>Max Due Date (60 Days)</th>
                  <th>Payment Status</th>
                  <th>Payment Date</th>
                  <th>Payment Method</th>  
              </tr>
            </thead>
 <tbody>
            <?php if(isset($balance_paid)){foreach ($balance_paid->result() as $row) {
            $job = $this->db->get_where('job',array('id'=>$row->job_id))->row();
            $priceList = $this->projects_model->getJobPriceListData($job->price_list); 
            $po = $this->db->get_where('po',array('id'=>$job->po))->row()
            ?>
              <tr>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?=$row->code?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if($po->verified == 1){echo "Verified";}else{echo "";}?></td>
                <td><?php if($po->verified == 1){echo $po->verified_at;}else{echo "";}?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $row->rate * $row->count;?></td>
                <td><?=$this->accounting_model->getPOStatus($row->verified)?></td>
                <td><?php echo $row->verified_at ;?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +45 days" ) ); }?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +60 days" ) ); }?></td>
                <td><?php if($row->payment_status == 1){echo "Paid";}else{echo "Not Paid";}?></td>
                <td><?=$row->payment_date?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
              </tr>
            <?php }} ?>
 
 			<?php if(isset($balance_new)){foreach ($balance_new->result() as $row) {
            $job = $this->db->get_where('job',array('id'=>$row->job_id))->row();
            $priceList = $this->projects_model->getJobPriceListData($job->price_list); 
            $po = $this->db->get_where('po',array('id'=>$job->po))->row()
            ?>
              <tr>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?=$row->code?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if($po->verified == 1){echo "Verified";}else{echo "";}?></td>
                <td><?php if($po->verified == 1){echo $po->verified_at;}else{echo "";}?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $row->rate * $row->count;?></td>
                <td><?=$this->accounting_model->getPOStatus($row->verified)?></td>
                <td><?php echo $row->verified_at ;?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +45 days" ) ); }?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +60 days" ) ); }?></td>
                <td><?php if($row->payment_status == 1){echo "Paid";}else{echo "Not Paid";}?></td>
                <td><?=$row->payment_date?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
              </tr>
            <?php }} ?>
 
 			<?php if(isset($balance_verified)){foreach ($balance_verified->result() as $row) {
            $job = $this->db->get_where('job',array('id'=>$row->job_id))->row();
            $priceList = $this->projects_model->getJobPriceListData($job->price_list); 
            $po = $this->db->get_where('po',array('id'=>$job->po))->row()
            ?>
              <tr>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?=$row->code?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if($po->verified == 1){echo "Verified";}else{echo "";}?></td>
                <td><?php if($po->verified == 1){echo $po->verified_at;}else{echo "";}?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $row->rate * $row->count;?></td>
                <td><?=$this->accounting_model->getPOStatus($row->verified)?></td>
                <td><?php echo $row->verified_at ;?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +45 days" ) ); }?></td>
                <td><?php if($row->verified == 1){ echo date( "Y-m-d", strtotime( $row->verified_at." +60 days" ) ); }?></td>
                <td><?php if($row->payment_status == 1){echo "Paid";}else{echo "Not Paid";}?></td>
                <td><?=$row->payment_date?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
              </tr>
            <?php }} ?>
 
 
</tbody>
              
                    </table>
                    <!--end: Datatable-->
                    <!--begin::Pagination-->
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