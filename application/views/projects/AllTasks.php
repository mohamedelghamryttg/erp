<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				All Tasks Filter
			</header>
			 <?php 
        
        if(!empty($_REQUEST['code'])){
            $code = $_REQUEST['code'];
        }else{
            $code = "";
        }
        if(!empty($_REQUEST['vendor'])){
            $vendor = $_REQUEST['vendor'];
        }else{
            $vendor = "";
        }
        if(!empty($_REQUEST['task_type'])){
            $task_type = $_REQUEST['task_type'];
        }else{
            $task_type = "";
        }
        if(!empty($_REQUEST['status'])){
            $status = $_REQUEST['status'];
        }else{
            $status = "";
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
        if(isset($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                }else{
                    $created_by = "";
                }
      ?>
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/allTasks" method="get" enctype="multipart/form-data">
				<div class="form-group">
            <label class="col-lg-2 control-label" for="role name">Task Code</label>

            <div class="col-lg-3">
            	<input type="text" class="form-control" name="code" value="<?=$code?>">
            </div>

             <label class="col-lg-2 control-label" for="role Task Type">Vendor</label>

            <div class="col-lg-3">
                <select name="vendor" class="form-control m-b" id="vendor"/>
                         <option value="" disabled="disabled" selected="selected">-- Select Vendor --</option>
                         <?=$this->vendor_model->selectVendor($vendor,$this->brand)?>
                </select>
            </div>

        </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="role Task Type">Task Type</label>

            <div class="col-lg-3">
                <select name="task_type" class="form-control m-b" id="task_type" />
                        <option value="" disabled="disabled" selected=""></option>
                        <?=$this->admin_model->selectAllTaskType($task_type)?>
                </select>
            </div>
              
              <label class="col-lg-2 control-label" for="role Task Type">Status</label>

            <div class="col-lg-3">
                <select name="status" class="form-control m-b" id="status" />
                        <option value="">-- Select Status --</option>
                    <?php 
                       if(isset($_REQUEST['status']) && $_REQUEST['status'] == 3 ){?>
                       <option selected="" value = "<?=$_REQUEST['status']?>">Running</option>
                       <option value="1">Delivered</option>
                        <option value="2">Canceled</option>
                       <?php }elseif(isset($_REQUEST['status']) && $_REQUEST['status'] == 1){ ?>
            		   <option value="3">Running</option>
                       <option selected="" value = "<?=$_REQUEST['status']?>">Deliverd</option>
                       <option value="2">Canceled</option>
                       <?php }elseif(isset($_REQUEST['status']) && $_REQUEST['status'] == 2){ ?>
            			<option value="0">Running</option>
                        <option value="1">Delivered</option>
                       <option selected="" value = "<?=$_REQUEST['status']?>">Canceled</option>
                    <?php }else{?>
                        <option value="3">Running</option>
                        <option value="1">Delivered</option>
                        <option value="2">Canceled</option>
                    <?php }?>

                </select>
            </div>      
           </div>  

          <div class="form-group">
            <label class="col-lg-2 control-label" for="Source Language">Source Language</label>

            <div class="col-lg-3">
                 <select name="source" class="form-control m-b" id="source" />
                    <option value="" disabled="disabled" selected="selected">-- Select Source Language --</option>
                    <?=$this->admin_model->selectLanguage($source)?>
                  </select>
            </div>
              
            <label class="col-lg-2 control-label" for="Target Language">Target Language</label>

            <div class="col-lg-3">
                  <select name="target" class="form-control m-b" id="target" />
                        <option value="" disabled="disabled" selected="selected">-- Select Target Language --</option>
                        <?=$this->admin_model->selectLanguage($target)?>
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
                     <label class="col-lg-2 control-label" for="role name">Created by</label>

                    <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" />
                                 <option value="">-- Select --</option>
                                  <?=$this->admin_model->selectAllPm($created_by,$this->brand)?>
                        </select>
                    </div>

                </div> 

        <div class="form-group">
          <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button> 
              <a href="<?=base_url()?>projects/allTasks" class="btn btn-warning">(x) Clear Filter</a>
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
        All Tasks
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                  <th>Task Code</th>
                	<th>Task Subject</th>
                  <th>Task Type</th>
                  <th>Vendor</th>
                  <th>Source</th>
                  <th>Target</th>
                  <th>Count</th>
                  <th>Unit</th>
                  <th>Rate</th>
                  <th>Total Cost</th>
                  <th>Currency</th>
                  <th>Start Date</th>
                  <th>Delivery Date</th>
                  <th>Task File</th>
                  <th>Status</th>
                  <th>Closed Date</th>
                  <th>Created By</th>
                  <th>Created At</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($task->result() as $row) { 
            ?>
              <tr>
                <td><a href="<?=base_url()?>projects/taskPage?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
                <td><?php echo $row->subject ;?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $this->vendor_model->getVendorName($row->vendor);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $row->rate * $row->count;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/taskFile/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
                <td><?php echo $this->projects_model->getJobStatus($row->status) ;?></td>
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