<style>
    .badge span{
        vertical-align: text-top;
    }
</style> 
  
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
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

              <!-- start search form card --> 
                  <div class="card card-custom gutter-b example example-compact">
          <div class="card-header">
            <h3 class="card-title">Search Price List</h3>
          </div>
           <?php
       if(!empty($_REQUEST['product_line'])){
                    $product_line = $_REQUEST['product_line'];
                    
                }else{
                    $product_line = "";
                }
                if(!empty($_REQUEST['customer'])){
                    $customer = $_REQUEST['customer'];
                    
                }else{
                    $customer = "";
                }
                if(!empty($_REQUEST['source'])){
                    $source = $_REQUEST['source'];
                    
                }else{
                    $source = "";
                }
                if(!empty($_REQUEST['target'])){
                    $target = $_REQUEST['target'];
                    
                }else{
                    $target = "";
                }
                if(!empty($_REQUEST['service'])){
                    $service = $_REQUEST['service'];
                   
                }else{
                    $service = "";
                }
                if(!empty($_REQUEST['task_type'])){
                    $task_type = $_REQUEST['task_type'];
                    
                }else{
                    $task_type = "";
                }
                if(!empty($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                    
                }else{
                    $created_by = "";
                }

                ?>
            <form class="form" id="priceListForm" action="<?php echo base_url()?>customer/priceListWaitingApproval" method="get" enctype="multipart/form-data">
             <div class="card-body">

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Customer</label>
               <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer"/>
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerBySam($customer,$this->user,$permission,$this->brand)?>
                        </select>

               </div>  

               <label class="col-lg-2 control-label text-lg-right" for="role name">Product Line</label>
                        <div class="col-lg-3">
                       <select name="product_line" class="form-control m-b" id="product_line" />
                                 <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine($product_line,$this->brand)?>
                        </select>
                        </div>
              </div>
               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Source Language</label>
               <div class="col-lg-3">
                <select name="source" class="form-control m-b" id="source" />
                                 <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                                 <option value="0">Empty</option>
                                 <?=$this->admin_model->selectLanguage($source)?>
                        </select>
               </div>  

               <label class="col-lg-2 control-label text-lg-right" for="role name">Target Language</label>
                        <div class="col-lg-3">
                      <select name="target" class="form-control m-b" id="target" />
                                 <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                                 <option value="0">Empty</option>
                                 <?=$this->admin_model->selectLanguage($target)?>
                        </select>
                        </div>
              </div>
             
             <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Service</label>
               <div class="col-lg-3">
               <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                                <option value="" disabled="disabled" selected="selected">-- Select Service --</option>
                                <?=$this->admin_model->selectServices($service)?>
                        </select>
               </div>  

               <label class="col-lg-2 control-label text-lg-right" for="role name">Task Type</label>
                        <div class="col-lg-3">
                     <select name="task_type" class="form-control m-b" id="task_type" />
                        <option value="" disabled="disabled" selected="selected">-- Select Task Type --</option>
                        <?=$this->admin_model->selectAllTaskType($task_type)?>
                </select>
                        </div>
              </div>

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Created By</label>
               <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by"/>
                                 <option value="">-- Select SAM --</option>
                                 <?=$this->customer_model->selectAllSam($created_by,$this->brand)?>
                        </select>
               </div>  
             

              </div>
             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                            <button class="btn btn-success mr-2" name="search"  onclick="var e2 = document.getElementById('priceListForm'); e2.action='<?=base_url()?>customer/priceListWaitingApproval'; e2.submit();" type="submit">Search</button>  
                            <a href="<?=base_url()?>customer/priceListWaitingApproval" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                      <h3 class="card-label">Customers Price List "Waiting Approval"</h3>
                    </div>
                    <div class="card-toolbar">
                   </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                <th>Customer</th>
                <th>Region</th>
                <th>Country</th>
                <th>Product Line</th>
                <th>Service</th>
                <th>Task Type</th>
                <th>Rate</th>
                <th>Unit</th>
                <th>Source</th>  
                <th>Target</th>
                <th>Dialect</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>             
                <th>View</th>             
                <th>Approve</th>             
              </tr>
            </thead>
         <tbody>
            <?php
              foreach($priceList->result() as $row)
                {
                                  $leadData = $this->db->get_where('customer_leads',array('id'=>$row->lead))->row();
            ?>
                  <tr class="">
                    <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                    <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                    <td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
                    <td><?php echo $this->customer_model->getProductLine($row->product_line) ;?></td>
                    <td><?php echo $this->admin_model->getServices($row->service) ;?></td>
                    <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                    <td><?php echo $row->rate ;?> <?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                    <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                    <td><?php echo $this->admin_model->getLanguage($row->source) ;?></td>
                    <td><?php echo $this->admin_model->getLanguage($row->target) ;?></td>
                    <td><?php echo $row->dialect ;?></td>
                    <td><?php echo $this->sales_model->getClientPriceStatus($row->approved) ;?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>  
                    <td>                   
                      <a href="<?php echo base_url()?>customer/viewPriceList?t=<?php echo 
                      base64_encode($row->id) ;?>" class="">
                        <i class="fa fa-pencil"></i> View
                      </a>                    
                    </td>
                    <td>                   
                      <a href="<?php echo base_url()?>customer/approvePriceList?t=<?php echo 
                      base64_encode($row->id) ;?>" title="Approve" 
                      class="btn btn-dark btn-sm p-2" onclick="return confirm('Are you sure you want to Approve this Price List ?');">
                        <i class="fa fa-check-circle"></i>Approve
                      </a>                  
                    </td>
                  </tr>
            <?php
                }
            ?>    
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