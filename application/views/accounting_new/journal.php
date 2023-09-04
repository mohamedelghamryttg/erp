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
            <h3 class="card-title">journal List Filter</h3>
          </div>
      
            <form class="form" id="invoiceForm" action="<?php echo base_url()?>accounting/journal" method="post" enctype="multipart/form-data">
             <div class="card-body">
                <?php
                   if(!empty($filter['journal.id ='])){
                    $journal_id = $filter['journal.id ='];
                    }else{
                        $journal_id = "";
                    }

                    if(!empty($filter['t.id ='])){
                    $journal_transaction_id = $filter['t.id ='];
                    }else{
                        $journal_transaction_id = "";
                    }
                    if(!empty($filter['sec.id ='])){
                      $section = $filter['sec.id ='];
                    }else{
                      $section='';
                    }
                    if(!empty($filter['cat.id ='])){
                      $category = $filter['cat.id ='];
                    }else{
                      $category='';
                    }
                    if(!empty($filter['sub.id ='])){
                      $sub_category = $filter['sub.id ='];
                    }else{
                      $sub_category='';
                    }
                    if(!empty($filter['t.created_by ='])){
                    $created_by = $filter['t.created_by ='];
                    }else{
                        $created_by = "";
                    }

                    if(!empty($filter['t.created_at >='])){
                      $date_from=date("m/d/Y", strtotime($filter['t.created_at >=']));
                    }
                    else{
                      $date_from="";
                    }
                    if(!empty($filter['t.created_at <='])){
                      $date_to=date("m/d/Y", strtotime($filter['t.created_at <=']));
                    }
                    else{
                      $date_to="";
                    }
                ?>
              <div class="form-group row">

                <label class="col-lg-2 col-form-label text-lg-right">Journal ID</label>
                <div class="col-lg-3">
                  <input class="form-control" type="text" name="journal_id" autocomplete="off" value=<?=$journal_id?>>
                </div>

                <label class="col-lg-2 col-form-label text-lg-right">Journal Transaction ID</label>
                <div class="col-lg-3">
                  <input class="form-control" type="text" name="journal_transaction_id" autocomplete="off" value=<?=$journal_transaction_id?>>
                </div>    

               </div>


              <div class='form-group row'>
                  <label class='col-lg-2 col-form-label text-right' >Section</label>

                  <div class='col-lg-3'>
                      <select name='section_name_1' id='section_name_1' class='form-control m-b' id='section' onchange='getCategories(1)' value="" >
                          <option value="" disabled='' selected=''>-- Select --</option>
                          <?=$this->accounting_model->selectSection($section)?>
                      </select>
                  </div>

                  <label class='col-lg-2 col-form-label text-right' >Category</label>
                  <div class='col-lg-3'>
                      <select name='category_name_1' id='category_name_1' class='form-control m-b' id='category'onchange='getSupCategories(1)'>
                          <option value="" disabled='' selected=''>-- Select --</option>
                            <?=$this->accounting_model->selectCategory($category,$section)?>
                      </select>
                  </div>

                  
              </div>
              <div class="form-group row">
                    <label class='col-lg-2 col-form-label text-right' >Sup Category</label>
                       <div class='col-lg-3'>
                        <select name='sup_category_1' id='sup_category_1' class='form-control m-b'>
                            <option disabled='' value="" selected=''>-- Select --</option>
                            <?=$this->accounting_model->selectSupCategory($sub_category,$category)?>
                            
                        </select>
                    </div>
                    <label class="col-lg-2 col-form-label text-lg-right">Created By</label>
                    <div class="col-lg-3">
                            <select name="created_by" class="form-control m-b" />
                                    <option value="">-- Select --</option>
                                      <?=$this->accounting_model->selectAccountingTeam($created_by,$this->brand)?>
                            </select>                
                    </div>
              </div>

               <div class="form-group row">

               <label class="col-lg-2 col-form-label text-lg-right">Date From</label>
                <div class="col-lg-3">
                  <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value=<?=$date_from?>>
                </div>  

               <label class="col-lg-2 col-form-label text-lg-right" for="role name">Date To</label>
                  <div class="col-lg-3">
                  <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" value=<?=$date_to?>>
                  </div>
              </div>


             
             <div class="card-footer">
              <div class="row">
               <div class="col-lg-2"></div>
               <div class="col-lg-10">
                           <button class="btn btn-success mr-2" name="search"  onclick="var e2 = document.getElementById('invoiceForm'); e2.action='<?=base_url()?>accounting/journal'; e2.submit();" type="submit">Search</button>  
                           <button class="btn btn-secondary" onclick="var e2 = document.getElementById('invoiceForm'); e2.action='<?=base_url()?>accounting/exportJournals'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>  
                         <a href="<?=base_url()?>accounting/journal" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a> 

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
                      <h3 class="card-label">Journal List</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>accounting/addJournal" class="btn btn-primary font-weight-bolder"> 
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
                      </span>Add New Journal</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                    <th>Journal Number</th>
                    <th>Transaction Number</th>
                    <th>Entry Description </th>
                    <th>Description</th>
                    <th>Currency</th>
                    <th>Amount  </th>
                    <th>Total USD </th>
                    <th>Total EGP</th>
                    <th>Debit Credit</th>
                    <th>Bank</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Date</th>
                    <th>Brand</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Edit</th>
                    <th>Delete</th>
              </tr>
            </thead>
           <tbody>
                        <?php
                            foreach($journal->result() as $row)
                                {?>
                                <tr>
                                    <td><?= $row->id?></td>  
                                    <td><?= $row->tID?></td>                              
                                    <td><?= $row->entry_description?></td>
                                    <td><?= $row->description ;?></td>
                                    <td><?= $row->currency_name ?></td>
                                    <td><?= $row->amount ;?></td>
                                    <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,2,$row->date,$row->amount),2)?></td>
                                    <td><?=number_format($this->accounting_model->transfareTotalToCurrencyRate($row->currency,1,$row->date,$row->amount),2)?></td>
                                    <td><?= $this->accounting_model->getFollowUpDepitOrCredit($row->debit_credit)?></td>   
                                    <td><?= $row->payment_method_name ;?></td>
                                    <td><?= $row->section_name ?></td>  
                                    <td><?= $row->category_name ?></td>
                                    <td><?= $row->subcategory_name ?></td>                        
                                    <td><?= $row->date ?></td>
                                    <td><?= $row->brand_name ?></td>
                                    <td><?= $row->user_name ?></td>
                                    <td><?= $row->trans_created_at ;?></td>
                                    <td>
                                        <?php if($permission->edit == 1){ ?>
                                        <a href="<?php echo base_url()?>accounting/editJournal?j=<?php echo 
                                                 base64_encode($row->id) ;?>&t=<?php echo base64_encode($row->tID) ;?>" class="">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
                                        <a href="<?php echo base_url()?>accounting/deleteJournal?t=<?php echo 
                                  base64_encode($row->id) ;?>" title="delete" 
                                        class="" onclick="return confirm('Are you sure you want to delete this Journal ?');">
                                            <i class="fa fa-times text-danger text"></i> Delete
                                        </a>
                                        <?php } ?>
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