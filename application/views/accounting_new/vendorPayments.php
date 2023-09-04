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
            <h3 class="card-title">Search VPO</h3>
          </div>
         <?php 
                if(isset($_REQUEST['code'])){
                  $code = $_REQUEST['code'];
              }else{
                  $code = "";
              }
              if(isset($_REQUEST['vendor'])){
                  $vendor = $_REQUEST['vendor'];
              }else{
                  $vendor = "";
              }
              ?>
            <form class="form" id="vpoForm" action="<?php echo base_url()?>accounting/vpoStatus" method="get" enctype="multipart/form-data">
             <div class="card-body">
                <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">PO Number</label>
               <div class="col-lg-3">
                 <input class="form-control" type="text"value="<?= $code?>" name="code" autocomplete="off">

               </div>  

               <label class="col-lg-2 control-label" for="role name">Vendor Name</label>
                        <div class="col-lg-3">
                       <select name="vendor" class="form-control m-b" id="vendor" />
                         <option disabled="disabled" selected="selected">-- Select Vendor --</option>
                         <?=$this->vendor_model->selectVendor($vendor,$brand)?>
                </select>
                        </div>
              </div>
       
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                          <button class="btn btn-primary" name="search" type="submit">Search</button> 
                <!-- <button class="btn btn-success" onclick="var e2 = document.getElementById('vpoForm'); e2.action='<?=base_url()?>accounting/exportRunningVPOs'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> -->
               <a href="<?=base_url()?>accounting/vendorPayments" class="btn btn-warning">(x) Clear Filter</a>

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
                      <h3 class="card-label">Vendor Payments List</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>accounting/addVendorPayment" class="btn btn-primary font-weight-bolder"> 
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
                      </span>Add New Payment</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                  <th>#</th>
                  <th>Task Code</th>
                  <th>Vendor</th>
                  <th>Vendor Email</th>
                  <th>Contacts</th>
                  <th>Rate</th>
                  <th>Volume</th>
                  <th>Unit</th>
                  <th>Total</th>
                  <th>Currency</th>
                  <th>Payment Method</th>
                  <th>Payment Date</th>
                  <th>Status</th>
                  <th>Created By</th>
                  <th>Created At</th>
                  <th>Edit</th>
                  <th>Delete</th>
              </tr>
            </thead>
<tbody>
              <?php foreach ($payment->result() as $row) { 
                $vendor = $this->db->get_where('vendor',array('id'=>$row->vendor))->row();
              ?>
              <tr>
                <td><?=$row->id?></td>
                <td><?=$row->code?></td>
                <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
                <td><?=$vendor->email?></td>
                <td><?=$vendor->contact?></td>
                <td><?=$row->rate?></td>
                <td><?=$row->count?></td>
                <td><?=$this->admin_model->getUnit($row->unit)?></td>
                <td><?=$row->rate * $row->count?></td>
                <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
                <td><?php echo $row->payment_date ;?></td>
                <td><?php if($row->status == 1){echo "Paid";}elseif($row->status == 2){echo "Re-opened";} ?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <a href="<?=base_url()?>accounting/editVendorPayment?t=<?=base64_encode($row->id)?>" class="">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                  <?php } ?>
                </td>
                <td>
                  <?php if($permission->delete == 1){ ?>
                  <!-- <a href="#" title="delete" 
                  class="" onclick="return confirm('Are you sure you want to delete this Payment ?');">
                    <i class="fa fa-times text-danger text"></i> Delete
                  </a> -->
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