<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
           Handover Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="handoverFilter" action="<?php echo base_url()?>projects/handover" method="get" enctype="multipart/form-data">
         <?php 
               if(isset($_REQUEST['customer_name'])){
                    $customer_name = $_REQUEST['customer_name'];
                }else{
                    $customer_name = "";
                }
                if(isset($_REQUEST['ttg_pm_name'])){
                    $ttg_pm_name = $_REQUEST['ttg_pm_name'];
                }else{
                    $ttg_pm_name = "";
                }
         ?>
          <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer Name</label>

                    <div class="col-lg-3">
                        <select name="customer_name"  class="form-control m-b"/>
                                 <option value="">-- Select Customer Name --</option>
                                 <?=$this->customer_model->selectCustomer($customer_name)?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label" for="role name">TTG PM Name</label>

                    <div class="col-lg-3">
                        <select name="ttg_pm_name"  class="form-control m-b"/>
                                 <option value="">-- Select PM --</option>
                                 <?=$this->sales_model->selectPm($ttg_pm_name,$brand)?>
                        </select>
                    </div>
                </div> 
       
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                    <!-- <button class="btn btn-success" onclick="var e2 = document.getElementById('handoverFilter'); e2.action='<?=base_url()?>hr/exportHandover'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>-->
                   <a href="<?=base_url()?>projects/handover" class="btn btn-warning">(x) Clear Filter</a> 

          </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<!-- -->
 <div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Handover
      </header>
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
      <div class="panel-body" style="overflow:scroll;">
        <div class="adv-table editable-table ">
        <div class="clearfix">
            <div class="btn-group">
            <?php if($permission->add == 1){ ?>
                  <a href="<?=base_url()?>projects/addHandover" class="btn btn-primary " style="margin-right: 5rem;"><i class="fa fa-plus" aria-hidden="true"></i> Add New Record</a>
              </br></br></br>
            <?php } ?>
            </div>
          </div>  
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                      <th>#ID</th>
                      <th>Costumer Name</th>
                      <th>Costumer PM</th>
                      <th>TTG PM Name</th>
                      <th>Productline</th>
                      <th>Email subject</th>
                      <th>Service</th>
                      <th>Subject Matter</th>
                      <th>Source Language</th>
                      <th>Target Language</th>
                      <th>Dialect</th>
                      <th>Tool</th>
                      <th>Source Format</th>
                      <th>Source files location</th>
                      <th>Deliverables Format</th>
                      <th>Delivery location</th>
                      <th>Number of files</th>
                      <th>Files Names</th>
                      <th>Start date</th>
                      <th>Delivery date</th>
                      <th>Volume</th>
                      <th>Unite</th>
                      <th>Total PO Amount</th>
                      <th>Customer Instructions</th>
                      <th>Vendors to avoid </th>
                      <th>Important comment</th>
                      <th>Created At</th>
                      <th>Created By</th>
                      <th>Edit</th>
                      <th>Delete</th>
              </tr>
            </thead>
           <tbody>
            <?php foreach ($handover->result() as $row) { 
                  //$handoverResources = $this->db->query('SELECT * FROM handover_resources WHERE handover = "$row->id"');
                   $handoverResources = $this->db->get_where('handover_resources',array('handover'=>$row->id))->result();

              ?>
              <tr> 
                   
                    <td><?= $row->id ?></td>
                    <td><?= $this->customer_model->getCustomer($row->customer_name) ?></td>
                    <td><?= $row->customer_pm ?></td>
                    <td><?= $this->admin_model->getUser($row->ttg_pm_name) ?></td>
                    <td><?= $this->customer_model->getProductLine($row->productline) ?></td>
                    <td><?= $row->email_subject ?></td>
                    <td><?= $this->admin_model->getServices($row->service) ?></td>
                    <td><?= $row->subject_matter ?></td>
                    <td><?= $this->admin_model->getLanguage($row->source_language) ?></td>
                    <td><?= $this->admin_model->getLanguage($row->target_language) ?></td>
                    <td><?= $row->dialect ?></td>
                    <td><?= $this->sales_model->getToolName($row->tool) ?></td>
                    <td><?= $row->source_format ?></td>
                    <td><?= $row->source_files_location ?></td>
                    <td><?= $row->deliverables_format ?></td>
                    <td><?= $row->delivery_location ?></td>
                    <td><?= $row->number_of_files ?></td>
                    <td><?= $row->files_names ?></td>
                    <td><?= $row->start_date?></td>
                    <td><?= $row->delivery_date ?></td>
                    <td><?= $row->volume ?></td>
                    <td><?= $this->admin_model->getUnit($row->unit) ?></td>
                    <td><?= $row->total_po_amount ?></td>
                    <td><?= $row->customer_instructions ?></td>
                    <td><?= $row->vendors_to_avoid?></td>
                    <td><?= $row->important_comment?></td>
                    <td><?=$row->created_at ?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                   <td>
                      <?php if($permission->edit == 1){ ?>
                         <a href="<?php echo base_url()?>projects/editHandover?t=<?php echo base64_encode($row->id);?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>projects/deleteHandover?t=<?php echo base64_encode($row->id);?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Record ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
              </tr>
              <tr>
                <td colspan="16">
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                       <th>#ID</th>
                       <th>Type</th>
                       <th>Name</th>
                       <th>Delevery Date</th>
                       <th>Created At</th>
                       <th>Created By</th>
                       <th>Edit</th>
                       <th>Delete</th>
                       
                    </thead>
                    <tbody>
                    <?php foreach ($handoverResources as $resource) {  ?>
                      <tr>
                        <td><?= $resource->id ?></td>
                        <td>
                          <?php  if($resource->type == 1){ ?>
                            Translator
                          <?php }elseif($resource->type == 2){ ?>
                            Reviewer
                          <?php  }elseif($resource->type == 3){ ?>
                            Proofreader
                          <?php  } ?>
                          </td>
                        <td><?= $resource->name ?></td>
                        <td><?= $resource->delevery_date ?></td>
                        <td><?=$row->created_at ?></td>
                        <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                        <td>
                      <?php if($permission->edit == 1){ ?>
                         <a href="<?php echo base_url()?>projects/editHandoverResource?t=<?php echo base64_encode($resource->id);?>" class="">
                        <i class="fa fa-pencil"></i> Edit
                      </a>
                      <?php } ?>
                    </td>
                    
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>projects/deleteHandoverResource?t=<?php echo base64_encode($resource->id);?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this Record ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </td>
              </tr>
              <?php }?>
                  
            </tbody>
          </table>
          <nav class="text-center">
                         <?=$this->pagination->create_links()?>
                    </nav>
        </div>
      </div>
    </section>
  </div>
</div>