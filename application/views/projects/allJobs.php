<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				All Jobs Filter
			</header>

      <?php 
          if(!empty($_REQUEST['code'])){
          $code = $_REQUEST['code'];
          }else{
              $code = "";
          }
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
          if(!empty($_REQUEST['service'])){
              $service = $_REQUEST['service'];
          }else{
              $service = "";
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
          if(!empty($_REQUEST['status'])){
              $status = $_REQUEST['status'];
          }else{
              $status = "";
          }
          if(isset($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = "";
                }
          ?>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/allJobs" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Job Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="code" value="<?=$code?>">
                    </div>

                     <label class="col-lg-2 control-label" for="role Task Type">Product Line</label>

                    <div class="col-lg-3">
                        <select name="product_line" class="form-control m-b" id="product_line" />
                                <option value="" disabled="disabled" selected="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine($product_line,$this->brand)?>
                        </select>
                    </div>

                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Client</label>

                     <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer" />
                                 <option value="" disabled="disabled" selected="selected">-- Select Client --</option>
                                 <?=$this->customer_model->selectCustomerByPm($customer,$this->user,$permission,$this->brand)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role Task Type">Service</label>

                    <div class="col-lg-3">
                      <select name="service" onchange="getTaskType()" class="form-control m-b" id="service" />
                                <option value="" disabled="disabled" selected="selected">-- Select Service --</option>
                                <?=$this->admin_model->selectServices($service)?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Source</label>

                    <div class="col-lg-3">
                      <select name="source" class="form-control m-b" id="source" />
                                 <option value="" disabled="disabled" selected="selected">-- Select Source Language --</option>
                                 <?=$this->admin_model->selectLanguage($source)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role Task Type">Target</label>

                    <div class="col-lg-3">
                        <select name="target" class="form-control m-b" id="target" />
                                 <option value="" disabled="disabled" selected="selected">-- Select Target Language --</option>
                                 <?=$this->admin_model->selectLanguage($target)?>
                        </select>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Status</label>

                    <div class="col-lg-3">
                      <select name="status" class="form-control m-b" id="status" />
                                 <option value="">-- Select Status --</option>
                      <?php 
                                if(isset($_REQUEST['status']) && $_REQUEST['status'] == 0 ){?>
                                <option selected="" value = "2">Running</option>
                                 <option value="1">Delivered</option>
                         
                                 <?php }elseif(isset($_REQUEST['status']) && $_REQUEST['status'] == 1){ ?>
                    			<option value="2">Running</option>
                                 <option selected="" value = "1">Delivered</option>
                                
                    <?php }else{?>
                        <option value="2">Running</option>
                        <option value="1">Delivered</option>
                     
                    <?php }?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label" for="role name">Created by</label>

                    <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" />
                                 <option value="">-- Select --</option>
                                  <?=$this->admin_model->selectAllPm($created_by,$this->brand)?>


                        </select>
                    </div>
                </div> 
                 <div class="form-group">
                      <label class="col-lg-2 control-label" for="role date">Date From</label>
                      <div class="col-lg-3">
                           <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                      </div>
                        <label class="col-lg-2 control-label" for="role date">Date To</label>
                        <div class="col-lg-3">
                             <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                     </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <a href="<?=base_url()?>projects/allJobs" class="btn btn-warning">(x) Clear Filter</a>
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
               <th>PO Status Date</th>
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
                <td><a href="<?=base_url()?>projects/jobTasks?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
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
                 <?php if(isset($poData->verified_at)){ ?>
                     <td><?= $poData->verified_at?></td>
                  <?php }elseif(empty($poData->verified_at)) { ?>
                     <td> </td>
                  <?php  } ?>
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
                 <?php if($row->status == 0) { ?>
                    <td> </td>
                 <?php }elseif ($row->status == 1) { ?>
                    <td><?php echo $row->closed_date ;?></td>
                <?php } ?>
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