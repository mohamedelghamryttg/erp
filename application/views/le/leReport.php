<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				 Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="leReport" method="get" enctype="multipart/form-data">
  			<?php 
              if(isset($_REQUEST['code'])){
                $code = $_REQUEST['code'];
            }else{
                $code = "";
            }
            if(isset($_REQUEST['le'])){
                $le = $_REQUEST['le'];
            }else{
                $le = "";
            }
           ?>
      	<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Job Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value="<?= $code?>" name="code">
                    </div>

                    <label class="col-lg-2 control-label" for="role Assigned LE">Assigned LE</label>

                    <div class="col-lg-3">
                        <select name="le" class="form-control m-b" id="le" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectAllLE($this->brand,$le)?>
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
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('leReport'); e2.action='<?=base_url()?>le/leReport'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('leReport'); e2.action='<?=base_url()?>le/exportLEJobs'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>le/leReport" class="btn btn-warning">(x) Clear Filter</a> 

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
				LE Report
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
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						
					</div>
					<div class="space15"></div>



<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Subject</th>
                <th>PM</th>
                <th>Sent Date</th>
                <th>Type</th>
                <th>Job Code</th>
                <th>Assigned LE</th>
                <th>Task Type</th>
                <th>Subject Matter</th>
                <th>Linguist Format</th>
                <th>Deliverable Format</th>
                 <th>Unit</th>
                <th>Volume</th>
               
                 <th>Taken Time (Hrs)</th>
                 <th>Taken Time (Mins)</th>
                 <th>Status</th>
                 <th>Job Log</th>
                  <th>Created By</th>
                  <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { 
                  $request = $this->db->get_where('le_request',array('id' => $row->request_id))->row();
                  if($row->status == 2 || $row->status == 4){
                    $takenTime = $this->projects_model->getLEJobTime($row->id);
                    $log = $this->db->get_where('le_request_history',array('task'=>$row->id))->result();
                  }
              ?>
              <tr class="">
                <td><?=$request->subject?></td>
                <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                <td><?=$request->created_at?></td>
                <td><?=$this->admin_model->getLETaskType($row->task_type)?></td>
                <td>LE-<?=$row->request_id?>-<?=$row->id?></td>
                <td><?php echo $this->admin_model->getAdmin($row->le) ;?></td>
                <td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
                <td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
                 <?php if(is_numeric($row->linguist) && is_numeric($row->deliverable)){ ?>
                <td><?php echo $this->admin_model->getLeFormat($row->linguist);?></td>
                <td><abbr title="<?=$row->deliverable?>"><?php echo character_limiter($this->admin_model->getLeFormat($row->deliverable),10);?></abbr></td>
              <?php }else{ ?>
                <td><?=$row->linguist?></td>
                <td><abbr title="<?=$row->deliverable?>"><?=character_limiter($row->deliverable,10)?></abbr></td>
              <?php } ?>  
                <td><?php echo $this->admin_model->getUnit($row->unit);?></td>
                <td><?=$row->volume?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td>
                  <table>
                    <thead>
                      <tr>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($log as $history) { ?>
                      <tr>
                        <td><?=$this->projects_model->getTranslationJobStatus($history->status)?></td>
                        <td><?=$history->created_at?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>


         <nav class="text-center">
         <?=$this->pagination->create_links()?>
          			</nav>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>