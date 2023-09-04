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
            <h3 class="card-title">Invoices Customer</h3>
          </div>
          <?php 
           if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            }else{
                $id = "";
            }
            if(isset($_REQUEST['customer'])){
              $customer = $_REQUEST['customer'];
          }else{
              $customer = "";
          }
         ?>
            <form class="form" id="invoiceForm" action="<?php echo base_url()?>accounting/invoices" method="get" enctype="multipart/form-data">
             <div class="card-body">

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
               <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">

               </div>  

               <label class="col-lg-2 control-label" for="role name">Date To</label>
                        <div class="col-lg-3">
                        <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                        </div>
              </div>
               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Client</label>
               <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" />
                         <option disabled="disabled" selected="selected">-- Select Client --</option>
                         <?=$this->customer_model->selectCustomerBranches($customer,$brand)?>
                </select>
               </div>  

               <label class="col-lg-2 control-label" for="role name">Innvoice Number</label>
                        <div class="col-lg-3">
                       <input class="form-control" type="text" value="<?= $id?>" name="id" autocomplete="off">
                        </div>
              </div>
             

             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search"  onclick="var e2 = document.getElementById('invoiceForm'); e2.action='<?=base_url()?>accounting/invoices'; e2.submit();" type="submit">Search</button>  
                           <button class="btn btn-secondary" onclick="var e2 = document.getElementById('invoiceForm'); e2.action='<?=base_url()?>accounting/exportInvoices'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>  
                         <a href="<?=base_url()?>accounting/invoices" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

               </div>
              </div>
             </div>
            </form>
                       </div>
                        </div>
                <!--end::Card-->
              <!-- end search form -->
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Invoices List</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>accounting/addInvoice" class="btn btn-primary font-weight-bolder"> 
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
                      </span>Add New Invoice</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                   <th>Invoice Number</th>
                   <th>Client Name</th>
                   <th>Selected POs</th>
                   <th>Currency</th>
                   <th>Total Revenue</th>
                   <th>Total Revenue $</th>
                   <th>Payment Method</th>
                   <th>Issue Date</th>
                   <th>Payment terms</th>
                   <th>Due Date</th>
                   <th>Status</th>
                   <th>Created By</th>
                   <th>Created At</th>
                   <th>Export To Excel</th>
                   <th>Edit</th>
                   <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($invoice->result() as $row) { 
                $invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
                $invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
                            ?>
                              <tr>
                                <td># <?=$row->id?></td>
                                <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                                <td><?php echo $this->accounting_model->getSelectedPOs($row->po_ids) ;?></td>
                                <td><?=$this->admin_model->getCurrency($invoiceCurrency)?></td>
                                <td><?php echo $invoiceTotal ;?></td>
                                <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency,2,$row->issue_date,$invoiceTotal),2);?></td>
                                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
                                <td><?=$row->issue_date?></td>
                                <td><?=$row->payment?></td>
                                <td><?=date( "Y-m-d", strtotime( $row->issue_date." +".$row->payment." days" ) )?></td>
                                <td><?=$this->accounting_model->getInvoiceStatus($row->status,$row->issue_date,$row->payment)?></td>
                                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                                <td><?php echo $row->created_at ;?></td>
                                <td><a href="<?=base_url()?>accounting/exportInvoice?t=<?=base64_encode($row->id)?>" target="_blank" class="">
                                    <i class="fa fa-download"></i> Export To Excel
                                  </a></td>
                                <td>
                                  <?php if($permission->edit == 1 && $row->status == 0){ ?>
                                  <a href="#" class="">
                                    <i class="fa fa-pencil"></i> Edit
                                  </a>
                                  <?php } ?>
                                </td>
                                <td>
                                  <?php if($permission->delete == 1 && $row->status == 0){ ?>
                                  <a href="#" title="delete" 
                                  class="" onclick="return confirm('Are you sure you want to delete this Invoice ?');">
                                    <i class="fa fa-times text-danger text"></i> Delete
                                  </a>
                                  <?php } ?>
                                </td>
                              </tr>
                            <?php } ?>
            </tbody>
              
                    </table>
                  <!--begin::Pagination-->
				 <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <?=$this->pagination->create_links()?>  
                  </div>
         		  <!--end:: Pagination-->
                  
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->