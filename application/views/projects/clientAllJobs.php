<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        All Jobs Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/clientAllJobs" method="post" enctype="multipart/form-data">
        <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Job Code</label>

                    <div class="col-lg-3">
                      <input type="text" class="form-control" name="code">
                    </div>

                     <label class="col-lg-2 control-label" for="role Task Type">Product Line</label>

                    <div class="col-lg-3">
                        <select name="product_line" class="form-control m-b" id="product_line" />
                                <option disabled="disabled" selected="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine(0,$brand)?>
                        </select>
                    </div>

                </div>
        <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Client</label>

                     <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer" />
                                 <option disabled="disabled" selected="selected">-- Select Client --</option>
                                 <?=$this->customer_model->selectCustomerByPm(0,$user,$permission,$brand)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role Task Type">Service</label>

                    <div class="col-lg-3">
                      <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectServices()?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Source</label>

                    <div class="col-lg-3">
                      <select name="source" class="form-control m-b" id="source" />
                                 <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                 <?=$this->admin_model->selectLanguage()?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role Task Type">Target</label>

                    <div class="col-lg-3">
                        <select name="target" class="form-control m-b" id="target" />
                                 <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                 <?=$this->admin_model->selectLanguage()?>
                        </select>
                    </div>
                </div>
        <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Status</label>

                    <div class="col-lg-3">
                      <select name="status" class="form-control m-b" id="status" />
                                 <option disabled="disabled" selected="selected">-- Select Status --</option>
                                 <option value="0">Running</option>
                                 <option value="1">Delivered</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                  </div>
              </div>   
              </form>
      </div>
    </section>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        All Jobs
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Job Code</th>
                <th>Job Name</th>
               <th>Product Line</th>
               <th>Client Name</th>
               <th>Service</th>
               <th>Source</th>
               <th>Target</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Total Revenue</th>
               <th>Currency</th>
               <th>Status</th>
               <th>PO Number</th>
                 <th>CPO File</th>
                  <th>PO Status</th>
               <th>Has Error</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
               <th>Closed Date</th>
                <th>Created By</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($job->result() as $row) { 
            $priceList = $this->projects_model->getJobPriceListData($row->price_list);
            $total_revenue = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
            $poData = $this->projects_model->getJobPoData($row->po);
            ?>
              <tr>
                <td><a href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($row->project_id)?>"><?=$row->code?></a></td>
                <td><?=$row->name?></td>
                <td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
                <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                <td><?php echo $this->admin_model->getServices($row->service);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
                <?php if($row->type == 1){ ?>
                <td><?php echo $row->volume ;?></td>
                <?php }elseif ($row->type == 2) { ?>
                <td><?php echo $total_revenue / $row->rate ;?></td>
                <?php } ?>
                <td><?php echo $row->rate ;?></td>
                <td><?=$total_revenue?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
                <td><?php if(isset($poData)){ echo $poData->number; }?></td>
                <td><?php 
                if(isset($poData)){ ?><a href="<?=base_url()?>assets/uploads/cpo/<?=$poData->cpo_file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?php if(isset($poData)){$this->accounting_model->getPOStatus($poData->verified); } ?></td>
                <td>
                <?php if(isset($poData)){
                    if($poData->verified == 2){
                      $errors = explode(",", $poData->has_error);
                      for ($i=0; $i < count($errors); $i++) { 
                        if($i > 0){echo " - ";}
                        echo $this->accounting_model->getError($errors[$i]);
                       }
                     }} ?>
                </td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
            <?php } ?>
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