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
			 <form class="cmxform form-horizontal " id="dtpForm" action="<?php echo base_url()?>dtp/dtpTasks" method="get" enctype="multipart/form-data">
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
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpForm'); e2.action='<?=base_url()?>dtp/exportTasks'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                      <a href="<?=base_url()?>dtp/dtpTasks" class="btn btn-warning">(x) Clear Filter</a> 
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
				DTP Jobs
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
                                <th>Task Name</th>
                                <th>Task Code</th>
                              	<th>Task Type</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Source Language Direction</th>
                                <th>Target Language Direction</th>
                                <th>File Attachment</th>
                                <th>Status</th>
                             	 <th>View Job</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($job->result() as $row) { ?>
							<tr class="">
								 <td><?= $this->admin_model->getAdmin($this->db->query("SELECT created_by FROM dtp_request WHERE id = '$row->request_id'")->row()->created_by);?></td>
								<td><?= $this->db->query("SELECT task_name FROM dtp_request WHERE id = '$row->request_id'")->row()->task_name?></td>
                             	<td>DTP-<?=$row->request_id?>-<?=$row->id?></a></td>
								<td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
								<td><?=$row->volume?></td>
								<td><?=$this->admin_model->getUnit($row->unit)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
								<td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/dtpJob/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?=$this->projects_model->getTranslationJobStatus($row->status)?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>dtp/viewDtpTask?t=<?php echo 
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