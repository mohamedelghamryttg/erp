<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				TTG Software
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
							    <th>ID</th>
                                <th>File Name</th>
                         	    <th>Task Type</th>
                         	    <th>Attachment Type</th>
                         	    <th>Attachment</th>
                         	    <th>Link</th>
                         	    <th>Status</th>
                         	    <th>Created By</th>
                         	    <th>View Request</th>
                         	    
							</tr>
						</thead>
						<tbody>
							<?php foreach ($request->result() as $row) { ?>
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
                            	<td><a><?=$this->db->get_where('users',array('id'=>$row->created_by))->row()->email?></a></td>
								<td><a href="<?php echo base_url()?>software/softwareViewRequest?t=<?php echo base64_encode($row->id) ;?>" class="">View Request - <?= $row->id ?></a></td> 
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