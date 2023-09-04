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
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Opportunity Jobs</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1 && $opportunity_data->assigned == 0){ ?>
                        <a href="<?=base_url()?>sales/addOpportunityJob?t=<?=base64_encode($opportunity)?>" class="btn btn-primary font-weight-bolder"> 
                      <?php } ?>
                      <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>Add New</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                <tr>
                <th>Product Line</th>
                <th>Service</th>
                <th>Source</th>
                <th>Target</th>
                <th>Volume</th>
                <th>Rate</th>
                <th>Total Revenue</th>
                <th>Currency</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Edit </th>
              </tr>
              </tr>
            </thead>
          <tbody>
            <?php foreach ($job->result() as $row) { 
              $priceList = $this->projects_model->getJobPriceListData($row->price_list);
            ?>
              <tr>
                <td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
                <td><?php echo $this->admin_model->getServices($priceList->service);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
                <td><?php echo $row->volume ;?></td>
                <td><?php echo $priceList->rate ;?></td>
                <td><?=$this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id)?></td>
                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td>
                  <?php if($permission->edit == 1 && $opportunity_data->assigned == 0){ ?>
                  <a href="<?php echo base_url()?>sales/editOpportunityJob?t=<?php echo 
                  base64_encode($row->id) ;?>&o=<?=base64_encode($row->opportunity)?>" class="">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
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