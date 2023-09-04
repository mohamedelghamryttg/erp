<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        DTP Freelance
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="dtpFreelance" action="<?php echo base_url()?>dtp/dtpFreelance" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Date From</label>

                    <div class="col-lg-3">
                      <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="">
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Date TO</label>

                    <div class="col-lg-3">
                      <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="">
                    </div>

                </div>


                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpFreelance'); e2.action='<?=base_url()?>dtp/exportDtpFreelance'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                  </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<!-- -->
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				DTP Freelance
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
                  <th>Job Id</th>
                  <th>Subject</th>
                	<th>Task Type</th>
                  <th>Vendor</th>
                  <th>Rate</th>
                  <th>Unit</th>
                  <th>Count</th>
                  <th>Total Cost</th>
                  <th>Currency</th>
                  <th>Start Date</th>
                  <th>Delivery Date</th> 
                  <th>Status</th>
                  <th>Created By</th>
							</tr>
						</thead>
						<tbody>
                
                   <?php foreach ($row->result() as $row) { 
                      if( $row->status == 0 or $row->status == 1){
                    ?>
                  <tr> 
                    <td><?=$row->id?></td>
                    <td><?=$row->job_id?></td>
                    <td><?=$row->subject?></td>
                    <td><?=$this->admin_model->getTaskType($row->task_type)?></td>
                    <td><?=$this->db->query("SELECT name FROM vendor WHERE id = '$row->vendor'")->row()->name; ?></td>
                    <td><?= $row->rate?></td>
                    <td><?=$this->admin_model->getUnit($row->unit)?></td>
                    <td><?= $row->count?></td>
                    <td><?php echo $row->rate * $row->count;?></td>
                    <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                    <td><?=$row->start_date?></td>
                    <td><?= $row->delivery_date?></td> 
                    <td><?= $this->projects_model->getJobStatus($row->status)?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                  </tr>
            <?php } }?>
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