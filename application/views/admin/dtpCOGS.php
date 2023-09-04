<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				 Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="dtpCOGS" method="get" enctype="multipart/form-data">


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
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('dtpCOGS'); e2.action='<?=base_url()?>report/dtpCOGS'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpCOGS'); e2.action='<?=base_url()?>report/exportDtpCOGS'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>report/dtpCOGS" class="btn btn-warning">(x) Clear Filter</a>
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
				DTP COGS Report
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


        <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
              <tr>

              
              
              <th>Job Name</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Currency</th>
               <th>Total Revenue</th>
              <th>Task Type</th>
                        <th>Unit</th>
                        <th>Source Language Direction</th>
                        <th>Target Language Direction</th>
                       <th>Start Date</th>
                       <th>Delivery Date</th>
                        <th>Created By</th>

                     
                
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($project)){
              foreach ($project->result() as $row) { 
                  $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                  $jobTotal = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
            ?>
              <tr>

                
               <!-- jobs -->
               
                <td><?=$row->name?></td>
                <?php if($row->type == 1){ ?>
                <td><?php echo $row->volume ;?></td>
                <?php }elseif ($row->type == 2) { ?>
                <td><?php echo $jobTotal / $priceList->rate ;?></td>
                <?php } ?>
                <td><?php echo $priceList->rate ;?></td>
                <td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
                <td><?php echo $jobTotal; ?></td>
 

            <!--DTP Task -->


                  <td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
                  <td><?=$this->admin_model->getUnit($row->unit)?></td>
                  <td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
                  <td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>

                  <td><?=$row->start_date?></td>
                  <td><?=$row->delivery_date?></td>

                  <td><?=$this->admin_model->getAdmin($row->created_by)?></td>

                </tr>
              <!-- End DTP Tasks -->

              </tr>
            <?php }} ?>
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