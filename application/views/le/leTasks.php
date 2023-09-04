<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				 Filter
			</header>

			<?php 
		       if(!empty($_REQUEST['code'])){
                $code = $_REQUEST['code'];
                }else{
                    $code = "";
                }

                if(!empty($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                }else{
                    $date_to = "";
                    $date_from = "";
                }

			?>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="leForm" action="<?php echo base_url()?>le/leTasks" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Task Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="code" value="<?=$code?>">
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
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('leForm'); e2.action='<?=base_url()?>le/exportTasks'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                       <a href="<?=base_url()?>le/leTasks" class="btn btn-warning">(x) Clear Filter</a>
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
				LE Jobs
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
							    <th>PM</th>
                                <th>Job Code</th>
                                <th>Assigned LE</th>
                              	<th>Task Type</th>
                              	<th>Linguist Format</th>
								<th>Deliverable Format</th>
								<th>Unit</th>
								<th>Volume</th>
                             	 <th>Task File</th>
                             	 <th>Status</th>
                             	 <th>View Job</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job->result() as $row) { ?>
							<tr class="">
							<td><?= $this->admin_model->getAdmin($this->db->query("SELECT created_by FROM le_request WHERE id = '$row->request_id'")->row()->created_by);?></td>
                             	<td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($row->request_id) ;?>" class="">LE-<?=$row->request_id?>-<?=$row->id?></a></td>
								<td><?php echo $this->admin_model->getAdmin($row->le) ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
								
								<?php if(is_numeric($row->linguist) && is_numeric($row->deliverable)){ ?>
								<td><?php echo $this->admin_model->getLeFormat($row->linguist);?></td>
								<td><abbr title="<?=$row->deliverable?>"><?php echo character_limiter($this->admin_model->getLeFormat($row->deliverable),10);?></abbr></td>
							<?php }else{ ?>
								<td><?=$row->linguist?></td>
								<td><abbr title="<?=$row->deliverable?>"><?=character_limiter($row->deliverable,10)?></abbr></td>
							<?php } ?>	
								<td><?php echo $this->admin_model->getUnit($row->unit);?></td>
								<td><?=$row->volume?></td>
								
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
								<td>
									<?php if($permission->add == 1){ ?>
									<a href="<?php echo base_url()?>le/viewLETask?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Job
									</a>
									<?php } ?>
								</td>
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