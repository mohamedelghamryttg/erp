<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				PM Conversion Request  Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="pmConversionRequestForm" action="<?php echo base_url()?>projects/pmConversionRequest" method="get" enctype="multipart/form-data">
				<?php 
				   if(isset($_REQUEST['file_name'])){
                    $file_name = $_REQUEST['file_name'];
                   }else{
                    $file_name = "";
                   }
					if(isset($_REQUEST['task_type'])){
						$task_type = $_REQUEST['task_type'];
					}else{
						$task_type = "";
					}
					
				?>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">File Name</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control"value="<?=$file_name?>" name="file_name">
                    </div>
                    <label class="col-lg-2 control-label" for="role Task Type">Task Type</label>
					<div class="col-lg-3">
					       <select name="task_type" class="form-control m-b" id="task_type" />
                              <option disabled="disabled" selected="">Select Task Type</option>
                                  <?php echo $this->projects_model->selectConversionTaskType($task_type) ;?>
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
                  		<button class="btn btn-success" onclick="var e2 = document.getElementById('pmConversionRequestForm'); e2.action='<?=base_url()?>projects/exportPmConversionRequest'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
						  <a href="<?=base_url()?>projects/pmConversionRequest" class="btn btn-warning">(x) Clear Filter</a> 

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
				PM Conversion Requests
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
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							
							<a  href="<?=base_url()?>projects/addPmConversionRequest" class="btn btn-primary ">Add Conversion Request</a>
							</br></br></br>
						<?php } ?>
						</div>
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
							    <th>ID</th>
                                <th>File Name</th>
                         	    <th>Task Type</th>
                         	    <th>Attachment Type</th>
                         	    <th>Attachment</th>
                         	    <th>Link</th>
                         	    <th>Status</th>
                                <th>Created By</th>
                         	    <th>Created At</th>
                         	    <th>View Request</th>
<!--                          	    <th>Edit</th> -->
                         	    <th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($pm_conversion_requests->result() as $row) { ?>
							<tr class="">
								<td><?= $row->id ?></td>
								<td><?= $row->file_name ?></td>
								<td><?= $this->projects_model->getConversionTaskType($row->task_type) ?></td>
								<td><?= $row->attachment_type == 1 ? "Attachment" : "Link"   ?></td>
								<td><?= $row->attachment ?></td>
								<td><a><?= $row->link ?></a></td>
								<td><?php  if($row->status == 1){
									echo "Running";
								}elseif ($row->status == 2) {
                                    echo "Closed";
 								}elseif ($row->status == 3) {
 									echo "Faild";
 								} ?>
 									
 								</td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?= $row->created_at ?></td>
								<td>
									<a href="<?php echo base_url()?>projects/viewPmConversionRequest?t=<?php echo 
										base64_encode($row->id) ;?>" class="">
											<i class="fa fa-eye"></i> View Request
									</a>
								</td>
<!-- 								<td>
									 <?php if($permission->edit == 1){ ?>
										<?php if ($row->status == 1) {?>
											<a href="<?php echo base_url()?>projects/editPmConversionRequest?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
										<?php } ?>
									<?php } ?>
								</td> -->

                                <td>
									<?php if($permission->delete == 1){ ?>
										<a href="<?php echo base_url()?>projects/deletePmConversionRequest?t=<?php echo 
										base64_encode($row->id) ;?>" title="delete" 
										class="" onclick="return confirm('Are you sure you want to delete this Request ?');">
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
					</form>
				</div>
			</div>
		</section>
	</div>
</div>