<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				 Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="dtpReport" method="get" enctype="multipart/form-data">
				 <?php 
           if(isset($_REQUEST['code'])){
            $code = $_REQUEST['code'];
            }else{
                $code = "";
            }
            if(isset($_REQUEST['dtp'])){
                $dtp = $_REQUEST['dtp'];
            }else{
                $dtp = "";
            }
        ?>
        <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Job Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" value = "<?= $code?>" name="code">
                    </div>

                    <label class="col-lg-2 control-label" for="role Assigned DTP">Assigned DTP</label>

                    <div class="col-lg-3">
                        <select name="dtp" class="form-control m-b" id="dtp" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectAllDTP($this->brand,$dtp)?>
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
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('dtpReport'); e2.action='<?=base_url()?>dtp/dtpReport'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('dtpReport'); e2.action='<?=base_url()?>dtp/exportDTPJobs'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>dtp/dtpReport" class="btn btn-warning">(x) Clear Filter</a> 

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
				DTP Report
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
              	<th>Assigned DTP</th>
                <th>Task Type</th>
                <th>Volume</th>
                <th>Updated Volume</th>
                <th>Unit</th>
                <th>Source Language</th>
                <th>Source Language Direction</th>
                <th>Target Language</th>
                <th>Target Language Direction</th>
                <th>Source Application</th>
                <th>Target Application</th>
                <th>Translatio In</th>
                 <th>Taken Time (Hrs)</th>
                 <th>Taken Time (Mins)</th>
                 <th>Status</th>
                  <th>Created By</th>
                  <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { 
                  $request = $this->db->get_where('dtp_request',array('id' => $row->request_id))->row();
                  $jobData = $this->projects_model->getJobData($request->job_id);
                  $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                  if($row->status == 2 || $row->status == 4){
                    $takenTime = $this->projects_model->getDTPJobTime($row->id);
                  }
              ?>
              <tr class="">
                <td><?=$request->task_name?></td>
                <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                <td><?=$request->created_at?></td>
              	<td><?php echo $this->admin_model->getAdmin($row->dtp) ;?></td>
                <td><?=$this->admin_model->getDTPTaskType($row->task_type)?></td>
                <td><?=$row->volume?></td>
                <td><?=$row->updated_count?></td>
                <td><?=$this->admin_model->getUnit($row->unit)?></td>
                <td><?=$this->admin_model->getLanguage($priceListData->source)?></td>
                <td><?=$this->admin_model->getLanguage($priceListData->target)?></td>
                <td><?=$this->admin_model->getDTPDirection($row->source_direction)?></td>
                <td><?=$this->admin_model->getDTPDirection($row->target_direction)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->source_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->target_application)?></td>
                <td><?=$this->admin_model->getDTPApplication($row->translation_in)?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
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