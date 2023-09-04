<script type="text/javascript">
	function hideDiv() {
		$("#filter").hide();
      	$("#filter2").hide();
	}
    window.onload = hideDiv;
</script>

 <div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button> Request Filter
			</header>
		<?php 
		       if(!empty($_REQUEST['code'])){
                $code = $_REQUEST['code'];
                }else{
                    $code = "";
                }

             if(!empty($_REQUEST['subject'])){
                    $subject = $_REQUEST['subject'];
                
                }else{
                    $subject = "";
                }
              

			?>
			
			<div id="filter" class="panel-body">
			  <form class="cmxform form-horizontal " id="leRequestForm" action="<?php echo base_url()?>projects/pmLERequest" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Task Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value="<?=$code?>" name="code">
                    </div>

                 <label class="col-lg-2 control-label" for="role name">Task Name</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value="<?=$subject?>" name="subject">
                    </div>
                    
                </div>


                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <a href="<?=base_url()?>projects/pmLERequest" class="btn btn-warning">(x) Clear Filter</a>

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
				All Requests <span class="numberCircle"><span><?=$total_rows?></span></span>
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
	    <div class="adv-table editable-table " style="overflow:scroll;">
		<div class="clearfix">
			<div class="btn-group">
			<?php if($permission->add == 1){ ?>
				<a href="<?=base_url()?>projects/addLeRequest" class="btn btn-primary ">Add New Request</a>
				</br></br></br>
			<?php } ?>
			</div>
			
		    </div>
					
			<div class="panel-body">
				<div class="adv-table editable-table ">
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Task Code</th>
                              	<th>Task Name</th>
                              	<th>Task Type</th>
                              	<th>Subject Matter</th>
                              	<th>Product Line</th>
                              	<th>Linguist Format</th>
								<th>Deliverable Format</th>
								<th>Unit</th>
								<th>Volume</th>
                                <th>Complexicty</th>
                                <th>Rate</th>
								<th>Source Language</th>
								<th>Target Language</th>
                             	<th>Start Date</th>
                             	<th>Delivery Date</th>
                             	<th>Task File</th>
                             	<th>Status</th>
                             	<th>Request Date</th>
                             	<th>Requested By</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>View Request</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($le_request->result() as $row) { 
								$jobData = $this->projects_model->getJobData($row->job_id = 0);
            					
							?>
							<tr>
								<td><?php echo $row->id ;?></td>
                              	<td><?php echo $row->subject ;?></td>
								<td><?php echo $this->admin_model->getLETaskType($row->task_type);?></td>
								<td><?php echo $this->admin_model->getLESubject($row->subject_matter);?></td>
								<td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
								<?php if(is_numeric($row->linguist) && is_numeric($row->deliverable)){ ?>
								<td><?php echo $this->admin_model->getLeFormat($row->linguist);?></td>
								<td><?php echo $this->admin_model->getLeFormat($row->deliverable);?></td>
							<?php }else{ ?>
								<td><?=$row->linguist?></td>
								<td><?=$row->deliverable?></td>
							<?php } ?>	
								<td><?php echo $this->admin_model->getUnit($row->unit);?></td>
								<td><?=$row->volume?></td>
								
                               <td><?=$this->projects_model->getLeComplexicty($row->complexicty);?></td>
                               <td><?= $row->rate ?></td>
								<td><?php echo $this->admin_model->getLanguage($row->source_language);?></td>
								<td><?php echo $this->admin_model->getLanguage($row->target_language);?></td>
								<td><?php echo $row->start_date ;?></td>
								<td><?php echo $row->delivery_date ;?></td>
								<td><?php if(strlen($row->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$row->file?>" target="_blank">Click Here</a><?php } ?></td>
								<td><?php echo $this->projects_model->getTranslationTaskStatus($row->status) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->status_by) ;?></td>
								<td><?php echo $row->status_at ;?></td>
								<td>
									<?php if($permission->edit == 1){ ?>
									<a href="<?php echo base_url()?>projects/leTask?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-eye"></i> View Task
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->edit == 1 && $row->status == 5){ ?>
									<a href="<?php echo base_url()?>projects/editLeRequest?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1){ ?>
									<a href="<?php echo base_url()?>projects/deleteLeRequest?t=<?php echo 
									base64_encode($row->id) ;?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Project ?');">
										<i class="fa fa-times text-danger text"></i> Delete
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
				</div>
			</div>
		</section>
	</div>
</div>

<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>