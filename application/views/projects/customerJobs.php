<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Jobs Waiting for Your Action - <span class="numberCircle"><span><?=$project->num_rows()?></span></span>
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
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
				               <th>Client Name</th>
                              	<th>Job Name</th>
				               <th>Service</th>
				               <th>Source</th>
				               <th>Target</th>
				               <th>Job File</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($project->result() as $row) { 
						?>
							<tr>
								<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
								<td><?=$row->name?></td>
                              	<td><?php echo $this->admin_model->getServices($row->service);?></td>
				                <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
				                <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
				                <td><a target="_blank" href="http://europelocalize.com/assets/uploads/jobFile/<?=$row->job_file?>">Click Here ...</a></td>
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